<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhbsController extends Controller
{
    // ── Tampilkan halaman dashboard ──
    public function index()
    {
        // Ambil semua data tahun 2025
        $data = DB::table('phbs_data')
            ->where('tahun', 2025)
            ->orderBy('puskesmas')
            ->orderByRaw("FIELD(bulan,
                'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        // Susun format $raw yang dibutuhkan oleh JavaScript di blade
        // Format: [ 'NAMA_PUSKESMAS' => [ total_kk, ber_phbs, pct, months[] ] ]
        $raw = [];
        foreach ($data as $row) {
            $pk = $row->puskesmas;

            if (!isset($raw[$pk])) {
                $raw[$pk] = [
                    'total_kk' => 0,
                    'ber_phbs' => 0,
                    'pct'      => 0,
                    'months'   => [],
                ];
            }

            $raw[$pk]['total_kk'] += $row->jumlah_kk;
            $raw[$pk]['ber_phbs'] += $row->ber_phbs;
            $raw[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk,
                'ber_phbs' => (int) $row->ber_phbs,
            ];
        }

        // Hitung persentase per puskesmas
        foreach ($raw as $pk => &$d) {
            $d['pct'] = $d['total_kk'] > 0
                ? round($d['ber_phbs'] / $d['total_kk'] * 100, 1)
                : 0;
        }

        // Kirim $raw ke blade → dipakai: const RAW = {!! json_encode($raw) !!};
        return view('phbs.dashboard', compact('raw'));
    }

    // ── API: kirim data JSON (opsional, untuk fetch() dari JS) ──
    public function getData()
    {
        $data = DB::table('phbs_data')
            ->where('tahun', 2025)
            ->orderBy('puskesmas')
            ->get();

        $result = [];
        foreach ($data as $row) {
            $pk = $row->puskesmas;

            if (!isset($result[$pk])) {
                $result[$pk] = [
                    'total_kk' => 0,
                    'ber_phbs' => 0,
                    'pct'      => 0,
                    'months'   => [],
                ];
            }

            $result[$pk]['total_kk'] += $row->jumlah_kk;
            $result[$pk]['ber_phbs'] += $row->ber_phbs;
            $result[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk,
                'ber_phbs' => (int) $row->ber_phbs,
            ];
        }

        foreach ($result as $pk => &$d) {
            $d['pct'] = $d['total_kk'] > 0
                ? round($d['ber_phbs'] / $d['total_kk'] * 100, 1)
                : 0;
        }

        return response()->json($result);
    }

    // ── Simpan data input manual dari form ──
    public function simpan(Request $request)
    {
        $request->validate([
            'puskesmas' => 'required|string|max:100',
            'bulan'     => 'required|string|max:20',
            'tahun'     => 'required|integer|min:2000|max:2100',
            'jumlah_kk' => 'required|integer|min:0',
            'ber_phbs'  => 'required|integer|min:0',
        ]);

        // Jika ber_phbs lebih besar dari jumlah_kk, tolak
        if ($request->ber_phbs > $request->jumlah_kk) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Jumlah Ber-PHBS tidak boleh melebihi Total KK.',
            ], 422);
        }

        DB::table('phbs_data')->updateOrInsert(
            // Kunci unik: puskesmas + bulan + tahun
            [
                'puskesmas' => $request->puskesmas,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun,
            ],
            // Data yang di-update atau di-insert
            [
                'jumlah_kk'  => $request->jumlah_kk,
                'ber_phbs'   => $request->ber_phbs,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status'  => 'ok',
            'message' => "Data {$request->puskesmas} bulan {$request->bulan} berhasil disimpan.",
        ]);
    }
}

//riska/anis
use Illuminate\Support\Facades\Response;

class PhbsController extends Controller
{
    private $namaBulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
    ];

    public function index(Request $req)
    {
        $tahun    = $req->get('tahun', date('Y'));
        $bulan    = $req->get('bulan', 0);
        $pkmId    = $req->get('puskesmas_id', 0);
        $kategori = $req->get('kategori', '');

        $query = DB::table('data_phbs as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan)    $query->where('d.bulan', $bulan);
        if ($pkmId)    $query->where('d.id_puskesmas', $pkmId);
        if ($kategori === 'baik')   $query->where('d.persen_phbs', '>=', 80);
        if ($kategori === 'cukup')  $query->whereBetween('d.persen_phbs', [60, 79.99]);
        if ($kategori === 'kurang') $query->where('d.persen_phbs', '<', 60);

        $laporan       = $query->orderBy('p.nama_puskesmas')->orderBy('d.bulan')->get();
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();

        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => round($laporan->avg('persen_phbs'), 1),
        ];

        return view('phbs.index', compact(
            'laporan','puskesmasList','stats',
            'tahun','bulan','pkmId','kategori'
        ))->with('namaBulan', $this->namaBulan);
    }

    public function form()
    {
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();
        $namaBulan     = $this->namaBulan;
        $data          = null;
        return view('phbs.form', compact('puskesmasList','namaBulan','data'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'id_puskesmas'    => 'required',
            'tahun'           => 'required|integer',
            'bulan'           => 'required|integer|min:1|max:12',
            'jumlah_kk_l'     => 'required|integer|min:0',
            'jumlah_kk_p'     => 'required|integer|min:0',
            'jumlah_kk_total' => 'required|integer|min:0',
            'ber_phbs'        => 'required|integer|min:0',
        ]);

        $total = $req->jumlah_kk_total;
        $persen = $total > 0 ? round(($req->ber_phbs / $total) * 100, 2) : 0;

        $data = $req->except('_token');
        $data['persen_phbs'] = $persen;

        DB::table('data_phbs')->insert($data);

        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil disimpan!');
    }

    public function edit($id)
    {
        $data          = DB::table('data_phbs')->where('id_data', $id)->first();
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();
        $namaBulan     = $this->namaBulan;
        return view('phbs.form', compact('data','puskesmasList','namaBulan'));
    }

    public function update(Request $req, $id)
    {
        $total  = $req->jumlah_kk_total;
        $persen = $total > 0 ? round(($req->ber_phbs / $total) * 100, 2) : 0;

        $data = $req->except(['_token','_method']);
        $data['persen_phbs'] = $persen;

        DB::table('data_phbs')->where('id_data', $id)->update($data);

        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('data_phbs')->where('id_data', $id)->delete();
        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }

    public function exportExcel(Request $req)
    {
        $tahun    = $req->get('tahun', date('Y'));
        $bulan    = $req->get('bulan', 0);
        $pkmId    = $req->get('puskesmas_id', 0);
        $kategori = $req->get('kategori', '');

        $query = DB::table('data_phbs as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan)    $query->where('d.bulan', $bulan);
        if ($pkmId)    $query->where('d.id_puskesmas', $pkmId);
        if ($kategori === 'baik')   $query->where('d.persen_phbs', '>=', 80);
        if ($kategori === 'cukup')  $query->whereBetween('d.persen_phbs', [60, 79.99]);
        if ($kategori === 'kurang') $query->where('d.persen_phbs', '<', 60);

        $laporan   = $query->orderBy('p.nama_puskesmas')->orderBy('d.bulan')->get();
        $namaBulan = $this->namaBulan;

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Laporan_PHBS_'.$tahun.'.xls"',
            'Cache-Control'       => 'max-age=0',
        ];

        $html = view('phbs.export_excel', compact('laporan','namaBulan','tahun','bulan'))->render();
        return Response::make("\xEF\xBB\xBF".$html, 200, $headers);
    }
}
