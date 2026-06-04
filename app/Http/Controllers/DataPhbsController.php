<?php

namespace App\Http\Controllers;

use App\Models\CapaianBulanan;
use App\Models\data_phbs as DataPhbs;
use App\Models\data_phbs_detail as DataPhbsDetail;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth;

class DataPhbsController extends Controller
{
    private const NAMA_BULAN = [
        1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
        5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November', 12=>'Desember',
    ];

    // ── Halaman daftar data PHBS ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $bulan  = $request->get('bulan');
        $tahun  = $request->get('tahun', date('Y'));

        $query = DataPhbs::with('puskesmas')
            ->when($bulan, fn($q) => $q->where('bulan', $bulan))
            ->when($tahun, fn($q) => $q->where('tahun', $tahun))
            ->orderBy('tahun','desc')
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->paginate(25);

        $puskesmasList = Puskesmas::orderBy('nama_puskesmas')->get();
        $tahunList     = DataPhbs::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('import.index', compact('query','puskesmasList','tahunList','bulan','tahun'));
    }

    // ── Form input manual ─────────────────────────────────────────────────────
    public function create()
    {
        $puskesmasList = Puskesmas::orderBy('nama_puskesmas')->get();
        $bulanList     = self::NAMA_BULAN;
        return view('import.create', compact('puskesmasList','bulanList'));
    }

    // ── Simpan input manual ───────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'id_puskesmas' => 'required|exists:puskesmas,id_puskesmas',
            'bulan'        => 'required|in:' . implode(',', self::NAMA_BULAN),
            'tahun'        => 'required|integer|min:2000|max:2100',
            'jumlah_kk_total'    => 'required|integer|min:1',
            'indikator'    => 'required|array|min:1',
            'indikator.*.id_indikator'    => 'required|exists:indikator_phbs,id_indikator',
            'indikator.*.jumlah_sasaran'  => 'required|integer|min:0',
            'indikator.*.jumlah_capaian'  => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Hapus data lama jika ada (upsert)
            $old = DataPhbs::where([
                'id_puskesmas' => $request->id_puskesmas,
                'bulan'        => $request->bulan,
                'tahun'        => $request->tahun,
            ])->first();

            if ($old) {
                DataPhbsDetail::where('id_phbs', $old->id_phbs)->delete();
                $old->delete();
            }

            // Hitung total dari indikator
            $totalSasaran = collect($request->indikator)->sum('jumlah_sasaran');
            $totalCapaian = collect($request->indikator)->sum('jumlah_capaian');
            $pct = $totalSasaran > 0 ? round($totalCapaian / $totalSasaran * 100, 2) : 0;

            // Simpan header data_phbs
            $dataPhbs = DataPhbs::create([
                'id_puskesmas'        => $request->id_puskesmas,
                'bulan'               => $request->bulan,
                'tahun'               => $request->tahun,
                'jumlah_kk_total'           => $request->jumlah_kk_total,
                'total_indikator_phbs'=> $totalCapaian,
                'kategori_phbs'       => $this->statusByPct($pct),
                'user_penginput'      => auth()->id() ?? 1,
            ]);

            // Simpan detail per indikator
            foreach ($request->indikator as $ind) {
                $indPct = $ind['jumlah_sasaran'] > 0
                    ? round($ind['jumlah_capaian'] / $ind['jumlah_sasaran'] * 100, 2)
                    : 0;

                DataPhbsDetail::create([
                    'id_phbs'          => $dataPhbs->id_phbs,
                    'id_indikator'     => $ind['id_indikator'],
                    'jumlah_sasaran'   => $ind['jumlah_sasaran'],
                    'jumlah_capaian'   => $ind['jumlah_capaian'],
                    'persentase'       => $indPct,
                    'kategori_capaian' => $this->statusByPct($indPct),
                    'keterangan'       => $ind['keterangan'] ?? null,
                ]);
            }

            // ✅ Otomatis update capaian_bulanan → peta terupdate
            $this->syncCapaianBulanan($request->id_puskesmas, $request->bulan, $request->tahun);
        });

        return redirect()->route('data-phbs.index')
            ->with('success', 'Data PHBS berhasil disimpan dan peta diperbarui.');
    }

    // ── Import dari Excel/CSV ─────────────────────────────────────────────────
    public function importForm()
    {
        return view('import.upload');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:csv,txt|max:5120',
            'bulan' => 'required|in:' . implode(',', self::NAMA_BULAN),
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $file  = $request->file('file');
        $bulan = $request->bulan;
        $tahun = (int) $request->tahun;

        $handle = fopen($file->getPathname(), 'r');

        // Baca header baris pertama
        $header = fgetcsv($handle, 0, ',');
        $header = array_map('trim', $header);

        $errors  = [];
        $success = 0;
        $row     = 1;

        DB::transaction(function () use ($handle, $header, $bulan, $tahun, &$errors, &$success, &$row) {
            while (($line = fgetcsv($handle, 0, ',')) !== false) {
                $row++;
                $data = array_combine($header, $line);

                // Cari puskesmas by nama
                $pkm = Puskesmas::where('nama_puskesmas', trim($data['nama_puskesmas'] ?? ''))
                    ->first();

                if (!$pkm) {
                    $errors[] = "Baris $row: Puskesmas '{$data['nama_puskesmas']}' tidak ditemukan.";
                    continue;
                }

                // Kolom indikator yang ada di CSV (sesuai kolom Excel PHBS)
                $indikatorMap = [
                    'persalinan_nakes'      => 'Persalinan ditolong nakes',
                    'asi_eksklusif'         => 'Memberi bayi ASI eksklusif',
                    'timbang_balita'        => 'Menimbang balita',
                    'air_bersih'            => 'Menggunakan air bersih',
                    'cuci_tangan'           => 'Mencuci tangan',
                    'jamban_sehat'          => 'Menggunakan jamban sehat',
                    'tidak_merokok'         => 'Tidak merokok',
                    'aktivitas_fisik'       => 'Aktivitas fisik',
                    'makan_buah_sayur'      => 'Makan buah dan sayur',
                    'pengelolaan_air_minum' => 'Pengelolaan air minum',
                    'pengelolaan_limbah'    => 'Pengelolaan limbah cair',
                    'buang_sampah'          => 'Membuang sampah',
                    'pemberantasan_jentik'  => 'Pemberantasan jentik',
                ];

                $jumlahKk     = (int) ($data['jumlah_kk_total'] ?? 0);
                $totalSasaran = 0;
                $totalCapaian = 0;
                $indDetails   = [];

                foreach ($indikatorMap as $col => $namaInd) {
                    $sasaran  = (int) ($data[$col . '_sasaran'] ?? $jumlahKk);
                    $capaian  = (int) ($data[$col] ?? 0);
                    $totalSasaran += $sasaran;
                    $totalCapaian += $capaian;

                    // Cari id_indikator by nama
                    $ind = DB::table('indikator_phbs')
                        ->where('nama_indikator', 'like', "%$namaInd%")
                        ->first();

                    if ($ind) {
                        $indDetails[] = [
                            'id_indikator'   => $ind->id_indikator,
                            'jumlah_sasaran' => $sasaran,
                            'jumlah_capaian' => $capaian,
                        ];
                    }
                }

                $pct = $totalSasaran > 0
                    ? round($totalCapaian / $totalSasaran * 100, 2)
                    : 0;

                // Upsert data_phbs
                $old = DataPhbs::where([
                    'id_puskesmas' => $pkm->id_puskesmas,
                    'bulan'        => $bulan,
                    'tahun'        => $tahun,
                ])->first();

                if ($old) {
                    DataPhbsDetail::where('id_phbs', $old->id_phbs)->delete();
                    $old->delete();
                }

                $dataPhbs = DataPhbs::create([
                    'id_puskesmas'         => $pkm->id_puskesmas,
                    'bulan'                => $bulan,
                    'tahun'                => $tahun,
                    'jumlah_kk_total'            => $jumlahKk,
                    'total_indikator_phbs' => $totalCapaian,
                    'kategori_phbs'        => $this->statusByPct($pct),
                    'user_penginput'       => Auth::id() ?? 1,
                ]);

                foreach ($indDetails as $ind) {
                    $indPct = $ind['jumlah_sasaran'] > 0
                        ? round($ind['jumlah_capaian'] / $ind['jumlah_sasaran'] * 100, 2)
                        : 0;
                    DataPhbsDetail::create([
                        'id_phbs'          => $dataPhbs->id_phbs,
                        'id_indikator'     => $ind['id_indikator'],
                        'jumlah_sasaran'   => $ind['jumlah_sasaran'],
                        'jumlah_capaian'   => $ind['jumlah_capaian'],
                        'persentase'       => $indPct,
                        'kategori_capaian' => $this->statusByPct($indPct),
                    ]);
                }

                // ✅ Sync ke capaian_bulanan → peta update otomatis
                $this->syncCapaianBulanan($pkm->id_puskesmas, $bulan, $tahun);
                $success++;
            }
        });

        fclose($handle);

        $msg = "Berhasil import $success puskesmas.";
        if ($errors) $msg .= ' ' . count($errors) . ' baris gagal.';

        return redirect()->route('data-phbs.index')
            ->with('success', $msg)
            ->with('import_errors', $errors);
    }

    // ── Core: Sync data_phbs → capaian_bulanan ────────────────────────────────
    /**
     * Hitung ulang persentase dari data_phbs_details
     * lalu upsert ke tabel capaian_bulanan.
     * Dipanggil setiap kali data disimpan/diimport.
     */
    public function syncCapaianBulanan(int $idPuskesmas, string $bulan, int $tahun): void
    {
        // Ambil bulan sebagai angka untuk capaian_bulanan
        $bulanAngka = array_search($bulan, self::NAMA_BULAN);
        if (!$bulanAngka) return;

        // Hitung dari data_phbs_details
        $agg = DB::table('data_phbs')
            ->join('data_phbs_details', 'data_phbs.id_phbs', '=', 'data_phbs_details.id_phbs')
            ->where('data_phbs.id_puskesmas', $idPuskesmas)
            ->where('data_phbs.bulan', $bulan)
            ->where('data_phbs.tahun', $tahun)
            ->selectRaw('
                SUM(data_phbs_details.jumlah_sasaran) AS total_sasaran,
                SUM(data_phbs_details.jumlah_capaian) AS total_capaian,
                MAX(data_phbs.jumlah_kk_total) AS jumlah_kk_total
            ')
            ->first();

        if (!$agg || $agg->total_sasaran <= 0) return;

        $pct      = round($agg->total_capaian / $agg->total_sasaran * 100, 2);
        $status   = CapaianBulanan::getStatusByPersentase($pct);

        // Upsert ke capaian_bulanan
        $existing = CapaianBulanan::where([
            'id_puskesmas' => $idPuskesmas,
            'bulan'        => $bulanAngka,
            'tahun'        => $tahun,
        ])->first();

        $payload = [
            'id_puskesmas'       => $idPuskesmas,
            'bulan'              => $bulanAngka,
            'tahun'              => $tahun,
            'persentase_capaian' => $pct,
            'jumlah_sasaran'     => (int) $agg->total_sasaran,
            'jumlah_tercapai'    => (int) $agg->total_capaian,
            'status_kategori'    => $status,
        ];

        if ($existing) {
            $existing->update($payload);
        } else {
            CapaianBulanan::create($payload);
        }

        // Update juga kolom persentase_capaian di tabel puskesmas (cache)
        DB::table('puskesmas')
            ->where('id_puskesmas', $idPuskesmas)
            ->update([
                'persentase_capaian' => $pct,
                'status_kategori'    => $status,
            ]);
    }

    // ── Hapus data ────────────────────────────────────────────────────────────
    public function destroy(int $id)
    {
        $data = DataPhbs::findOrFail($id);
        DB::transaction(function () use ($data) {
            DataPhbsDetail::where('id_phbs', $data->id_phbs)->delete();

            // Hapus juga dari capaian_bulanan
            $bulanAngka = array_search($data->bulan, self::NAMA_BULAN);
            CapaianBulanan::where([
                'id_puskesmas' => $data->id_puskesmas,
                'bulan'        => $bulanAngka,
                'tahun'        => $data->tahun,
            ])->delete();

            $data->delete();
        });

        return redirect()->route('data-phbs.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    private function statusByPct(float $pct): string
    {
        if ($pct < 60) return 'Rendah';
        if ($pct < 80) return 'Sedang';
        return 'Tinggi';
    }
}
