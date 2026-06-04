<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\data_phbs;
use App\Models\indikator_phbs;
use App\Models\Puskesmas;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     //return view('dashboard');
    //     $stats = [
    //         'total_puskesmas' => DB::table('puskesmas')->count(),
    //         'total_laporan'   => DB::table('data_phbs')->where('tahun', date('Y'))->count(),
    //         'total_kk'        => DB::table('data_phbs')->sum('jumlah_kk_total') ?? 0,
    //         'rata_phbs'       => round(DB::table('data_phbs')->avg('persen_phbs') ?? 0, 1),
    //     ];

    //     return view('dashboard.index', compact('stats'));
    // }

    public function dinkes(Request $req)
    {
        // if (request()->user()?->id_role !== 1) {
        //     abort(403, 'Halaman ini khusus untuk Dinkes.');
        // }

        // Gate::authorize('akses-dinkes');
        Gate::authorize('akses-dinkes');

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $tahun    = $req->get('tahun', date('Y'));
        $bulan    = $req->get('bulan', 0);
        $pkmId    = $req->get('puskesmas_id', 0);
        $kategori = $req->get('kategori', '');

        $query = DB::table('data_phbs as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan) {
            $query->where('d.bulan', $bulan);
        }

        if ($pkmId) {
            $query->where('d.id_puskesmas', $pkmId);
        }

        if ($kategori === 'baik') {
            $query->where('d.persen_phbs', '>=', 80);
        }

        if ($kategori === 'cukup') {
            $query->whereBetween('d.persen_phbs', [60, 79.99]);
        }

        if ($kategori === 'kurang') {
            $query->where('d.persen_phbs', '<', 60);
        }

        $laporan = $query
            ->orderBy('p.nama_puskesmas')
            ->orderBy('d.bulan')
            ->get();

        $puskesmasList = DB::table('puskesmas')
            ->orderBy('nama_puskesmas')
            ->get();

        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => round($laporan->avg('persen_phbs') ?? 0, 1),
        ];

        return view('dashboard.dinkes', compact(
            'laporan',
            'puskesmasList',
            'stats',
            'tahun',
            'bulan',
            'pkmId',
            'kategori'
        ))->with('namaBulan', $namaBulan);
    }

    public function index(Request $request)
    {
        // ── Filter ────────────────────────────────────────────────────────────
        $tahun        = (int) $request->get('tahun', date('Y'));
        $bulan        = $request->filled('bulan')        ? (int) $request->get('bulan')        : null;
        $id_puskesmas = $request->filled('id_puskesmas') ? (int) $request->get('id_puskesmas') : null;
 
        // ── Dropdown Puskesmas ────────────────────────────────────────────────
        $puskesmasList = Puskesmas::aktif()
            ->orderBy('nama_puskesmas')
            ->get(['id_puskesmas', 'nama_puskesmas']);
 
        // ── Status laporan (terkirim vs draft) ────────────────────────────────
        $baseCount = data_phbs::where('tahun', $tahun)
            ->when($bulan,        fn($q) => $q->where('bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('id_puskesmas', $id_puskesmas));
 
        $statusTerkirim = (clone $baseCount)->terkirim()->count();
        $statusDraft    = (clone $baseCount)->draft()->count();
 
        // ── Rekapitulasi Ber-PHBS per Puskesmas ──────────────────────────────
        // Query hanya ke data_phbs (ber_phbs & jumlah_kk_total sudah tersimpan di sana)
        $rekapData = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('dp.status_laporan', 'terkirim')
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas', 'p.nama_puskesmas', 'p.kecamatan', 'p.kepala_puskesmas',
                DB::raw('COUNT(dp.id_phbs)         AS jumlah_laporan'),
                DB::raw('SUM(dp.jumlah_kk_total)   AS total_kk'),
                DB::raw('SUM(dp.ber_phbs)           AS total_ber_phbs'),
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,2) AS persentase_phbs'),
            )
            ->groupBy('p.id_puskesmas', 'p.nama_puskesmas', 'p.kecamatan', 'p.kepala_puskesmas')
            ->orderBy('persentase_phbs', 'desc')
            ->get();
 
        // ── Stat cards ─────────────────────────────────────────────────────────
        $rataRataPhbs       = round($rekapData->avg('persentase_phbs') ?? 0, 1);
        $puskesmasTertinggi = $rekapData->first();
        $puskesmasTerendah  = $rekapData->last();
 
        $distribusiTinggi       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 70)->count();
        $distribusiSedang       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 50 && $r->persentase_phbs < 70)->count();
        $distribusiRendah       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 30 && $r->persentase_phbs < 50)->count();
        $distribusiSangatRendah = $rekapData->filter(fn($r) => $r->persentase_phbs  < 30)->count();
 
        // ── Rekapitulasi per Indikator ────────────────────────────────────────
        // Sumber: data_phbs_details JOIN indikator_phbs (bukan kolom ind1-13 lagi)
 
        $allIndikators = indikator_phbs::aktif()->orderBy('id_indikator')->get();
 
        $detailAgg = DB::table('data_phbs_details as dpd')
            ->join('data_phbs as dp',   'dpd.id_phbs',      '=', 'dp.id_phbs')
            ->join('puskesmas as p',    'dp.id_puskesmas',  '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('dp.status_laporan', 'terkirim')
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'dpd.id_indikator',
                DB::raw('SUM(dpd.jumlah_sasaran) AS total_sasaran'),
                DB::raw('SUM(dpd.jumlah_capaian) AS total_jumlah'),
                DB::raw('ROUND(SUM(dpd.jumlah_capaian)/NULLIF(SUM(dpd.jumlah_sasaran),0)*100,2) AS persentase'),
            )
            ->groupBy('dpd.id_indikator')
            ->get()
            ->keyBy('id_indikator'); // index by id_indikator untuk merge mudah
 
        // Gabungkan: semua indikator aktif + data agregat (0 jika belum ada laporan)
        $rekapIndikator = $allIndikators->mapWithKeys(function ($ind) use ($detailAgg) {
            $agg = $detailAgg->get($ind->id_indikator);
            return [
                $ind->id_indikator => [
                    'label'         => $ind->nama_indikator,
                    'kode'          => $ind->kode_indikator,
                    'target'        => $ind->target_nasional,
                    'total_sasaran' => (int)   ($agg?->total_sasaran ?? 0),
                    'total_jumlah'  => (int)   ($agg?->total_jumlah  ?? 0),
                    'persentase'    => (float) ($agg?->persentase     ?? 0),
                ],
            ];
        })->all(); // tetap terindex oleh id_indikator (1–13)
 
        // ── Matriks per Puskesmas × per Indikator ────────────────────────────
        // Langkah 1: statistik dasar dari data_phbs (bukan detail)
        $matriksBase = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas', 'p.nama_puskesmas',
                DB::raw('COUNT(dp.id_phbs) AS jumlah_laporan'),
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,1) AS rata_rata'),
            )
            ->groupBy('p.id_puskesmas', 'p.nama_puskesmas')
            ->orderBy('rata_rata', 'desc')
            ->get();
 
        // Langkah 2: persentase per indikator per puskesmas dari data_phbs_details
        // (query terpisah → tidak ada inflasi baris akibat JOIN)
        $indPerPkm = DB::table('data_phbs_details as dpd')
            ->join('data_phbs as dp',  'dpd.id_phbs',     '=', 'dp.id_phbs')
            ->join('puskesmas as p',   'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas',
                'dpd.id_indikator',
                DB::raw('ROUND(SUM(dpd.jumlah_capaian)/NULLIF(SUM(dpd.jumlah_sasaran),0)*100,1) AS pct'),
            )
            ->groupBy('p.id_puskesmas', 'dpd.id_indikator')
            ->get()
            ->groupBy('id_puskesmas'); // Collection<id_puskesmas, Collection<rows>>
 
        // Langkah 3: merge di PHP — tambah ind1_pct … ind13_pct ke setiap baris
        $indikatorIds = $allIndikators->pluck('id_indikator'); // [1,2,...,13]
 
        $matriksData = $matriksBase->map(function ($row) use ($indPerPkm, $indikatorIds) {
            // Ambil data indikator puskesmas ini, index by id_indikator
            $byInd = $indPerPkm->get($row->id_puskesmas, collect())->keyBy('id_indikator');
 
            $minPct = null;
            $minIdInd = null;
 
            foreach ($indikatorIds as $id) {
                $pct = (float) ($byInd->get($id)?->pct ?? 0);
                $row->{"ind{$id}_pct"} = $pct;
 
                if ($pct > 0 && ($minPct === null || $pct < $minPct)) {
                    $minPct   = $pct;
                    $minIdInd = $id;
                }
            }
 
            // Cari label indikator terendah dari IndikatorPhbs (via $allIndikators)
            $row->ind_terendah     = $minIdInd ? "I{$minIdInd}" : '-';
            $row->ind_terendah_pct = $minPct ?? 0;
 
            return $row;
        });
 
        // ── Tren Bulanan ──────────────────────────────────────────────────────
        $trenBulan = DB::table('capaian_bulanan as cb')
            ->join('puskesmas as p', 'cb.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('cb.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($id_puskesmas, fn($q) => $q->where('cb.id_puskesmas', $id_puskesmas))
            ->select('cb.bulan', DB::raw('ROUND(AVG(cb.persentase_capaian),2) AS rata_rata'))
            ->groupBy('cb.bulan')
            ->orderBy('cb.bulan')
            ->get();
 
        // Fallback: hitung dari data_phbs jika capaian_bulanan belum terisi
        if ($trenBulan->isEmpty()) {
            $trenBulan = DB::table('data_phbs as dp')
                ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
                ->where('dp.tahun', $tahun)
                ->where('dp.status_laporan', 'terkirim')
                ->where('p.status_aktif', true)
                ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
                ->select('dp.bulan', DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,2) AS rata_rata'))
                ->groupBy('dp.bulan')
                ->orderBy('dp.bulan')
                ->get();
        }
 
        $trenLabels = $trenBulan->map(fn($t) => data_phbs::namaBulan((int) $t->bulan))->toArray();
        $trenData   = $trenBulan->pluck('rata_rata')->toArray();
 
        $targetNasional = indikator_phbs::aktif()->avg('target_nasional') ?? 70;
 
        // ── Grafik batang ──────────────────────────────────────────────────────
        $grafikLabels = $rekapData->pluck('nama_puskesmas')->map(fn($n) => $this->singkat($n))->values()->toArray();
        $grafikData   = $rekapData->pluck('persentase_phbs')->values()->toArray();
        $grafikColors = $rekapData->map(fn($r) => $this->warna((float) $r->persentase_phbs))->values()->toArray();
 
        // ── Filter options ────────────────────────────────────────────────────
        $availableTahun = data_phbs::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        if ($availableTahun->isEmpty()) $availableTahun = collect([date('Y')]);
 
        return view('dashboard.index', compact(
            // stat cards / info cards
            'rataRataPhbs', 'puskesmasTertinggi', 'puskesmasTerendah',
            'statusTerkirim', 'statusDraft',
            // distribusi
            'distribusiTinggi', 'distribusiSedang', 'distribusiRendah', 'distribusiSangatRendah',
            // tabel rekap
            'rekapData', 'rekapIndikator', 'matriksData', 'allIndikators',
            // grafik
            'grafikLabels', 'grafikData', 'grafikColors',
            'trenLabels', 'trenData', 'targetNasional',
            // filter
            'tahun', 'bulan', 'id_puskesmas', 'availableTahun', 'puskesmasList',
        ));
    }
 
    // ── Private Helpers ────────────────────────────────────────────────────────
 
    private function singkat(string $n): string
    {
        return trim(preg_replace('/^(PUSKESMAS|UPT\s+PUSKESMAS|PKM|UPT)\s+/i', '', $n));
    }
 
    private function warna(float $p): string
    {
        return match(true) {
            $p >= 70 => 'rgba(34,197,94,.82)',
            $p >= 50 => 'rgba(245,158,11,.82)',
            $p >= 30 => 'rgba(249,115,22,.82)',
            default  => 'rgba(239,68,68,.82)',
        };
    }
}