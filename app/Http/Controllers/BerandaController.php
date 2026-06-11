<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\IndikatorPhbs;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BerandaController extends Controller
{
    // ── Route: GET /beranda  →  name('dashboard') ─────────────────────────────
    public function index(Request $request)
    {
        // ── Filter ─────────────────────────────────────────────────────────────
        $tahun        = (int) $request->get('tahun', date('Y'));
        $bulan        = $request->filled('bulan')        ? (int) $request->get('bulan')        : null;
        $id_puskesmas = $request->filled('id_puskesmas') ? (int) $request->get('id_puskesmas') : null;
 
        // ── Dropdown puskesmas aktif ────────────────────────────────────────────
        $puskesmasList = DB::table('puskesmas')
            ->orderBy('nama_puskesmas')
            ->get(['id_puskesmas', 'nama_puskesmas']);
 
        // ── Hitung laporan terkirim & draft ─────────────────────────────────────
        $baseCount = NewDataPHBS::where('tahun', $tahun)
            ->when($bulan,        fn($q) => $q->where('bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('id_puskesmas', $id_puskesmas));
 
        // $statusTerkirim = (clone $baseCount)->terkirim()->count();
        // $statusDraft    = (clone $baseCount)->draft()->count();
 
        // ── Rekapitulasi Ber-PHBS per Puskesmas ────────────────────────────────
        // - Ambil semua data (terkirim + draft) untuk keperluan ringkasan
        // - jumlah_kk_total dihitung langsung dari kolom lk + pr (bukan appends)
        $rekapData = DB::table('data_phbs as dp')
            ->join('puskesmas as p',          'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->leftJoin('kecamatans as k',      'p.id_kecamatan',  '=', 'k.id_kecamatan')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas',
                'p.nama_puskesmas',
                'k.nama_kecamatan as kecamatan',
                // DB::raw("COALESCE(p.kepala_puskesmas, '-') AS kepala_puskesmas"),
                DB::raw('COUNT(dp.id_phbs)                                              AS jumlah_laporan'),
                DB::raw('SUM(dp.jumlah_kk_lk + dp.jumlah_kk_pr)                        AS total_kk'),
                DB::raw('SUM(dp.ber_phbs)                                               AS total_ber_phbs'),
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_lk+dp.jumlah_kk_pr),0)*100,2) AS persentase_phbs'),
            )
            ->groupBy('p.id_puskesmas', 'p.nama_puskesmas', 'k.nama_kecamatan')
            ->orderByDesc('persentase_phbs')
            ->get();
 
        // ── Stat cards ──────────────────────────────────────────────────────────
        $rataRataPhbs       = round($rekapData->avg('persentase_phbs') ?? 0, 1);
        $puskesmasTertinggi = $rekapData->first();
        $puskesmasTerendah  = $rekapData->last();
 
        $distribusiTinggi       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 70)->count();
        $distribusiSedang       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 50 && $r->persentase_phbs < 70)->count();
        $distribusiRendah       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 30 && $r->persentase_phbs < 50)->count();
        $distribusiSangatRendah = $rekapData->filter(fn($r) => $r->persentase_phbs  < 30)->count();
 
        // ── Rekapitulasi per Indikator ──────────────────────────────────────────
        // Sumber: data_phbs_detail JOIN data_phbs (hanya status terkirim)
        $allIndikators = DB::table('indikator_phbs')->orderBy('id_indikator')->get();
 
        $detailAgg = DB::table('data_phbs_detail as dpd')
            ->join('data_phbs as dp',   'dpd.id_phbs',     '=', 'dp.id_phbs')
            ->join('puskesmas as p',    'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            // ->where('dp.status_laporan', 'terkirim')
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'dpd.id_indikator',
                DB::raw('SUM(dpd.jumlah_sasaran)  AS total_sasaran'),
                DB::raw('SUM(dpd.jumlah_capaian)  AS total_jumlah'),
                DB::raw('ROUND(SUM(dpd.jumlah_capaian)/NULLIF(SUM(dpd.jumlah_sasaran),0)*100,2) AS persentase'),
            )
            ->groupBy('dpd.id_indikator')
            ->get()
            ->keyBy('id_indikator');
 
        $rekapIndikator = $allIndikators->mapWithKeys(function ($ind) use ($detailAgg) {
            $agg = $detailAgg->get($ind->id_indikator);
            return [
                $ind->id_indikator => [
                    'label'         => $ind->nama_indikator,
                    'kode'          => $ind->kode_indikator,
                    // 'target'        => $ind->target_nasional ?? 70,
                    'total_sasaran' => (int)   ($agg?->total_sasaran ?? 0),
                    'total_jumlah'  => (int)   ($agg?->total_jumlah  ?? 0),
                    'persentase'    => (float) ($agg?->persentase     ?? 0),
                ],
            ];
        })->all();
 
        // ── Matriks per Puskesmas × per Indikator ──────────────────────────────
        // Langkah 1: ringkasan dari data_phbs
        $matriksBase = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas', 'p.nama_puskesmas',
                DB::raw('COUNT(dp.id_phbs) AS jumlah_laporan'),
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_lk+dp.jumlah_kk_pr),0)*100,1) AS rata_rata'),
            )
            ->groupBy('p.id_puskesmas', 'p.nama_puskesmas')
            ->orderByDesc('rata_rata')
            ->get();
 
        // Langkah 2: persentase per indikator per puskesmas (query terpisah)
        $indPerPkm = DB::table('data_phbs_detail as dpd')
            ->join('data_phbs as dp',  'dpd.id_phbs',     '=', 'dp.id_phbs')
            ->join('puskesmas as p',   'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas', 'dpd.id_indikator',
                DB::raw('ROUND(SUM(dpd.jumlah_capaian)/NULLIF(SUM(dpd.jumlah_sasaran),0)*100,1) AS pct'),
            )
            ->groupBy('p.id_puskesmas', 'dpd.id_indikator')
            ->get()
            ->groupBy('id_puskesmas');
 
        // Langkah 3: merge → tambah ind{n}_pct ke setiap baris
        $indikatorIds = $allIndikators->pluck('id_indikator');
 
        $matriksData = $matriksBase->map(function ($row) use ($indPerPkm, $indikatorIds) {
            $byInd = $indPerPkm->get($row->id_puskesmas, collect())->keyBy('id_indikator');
            $minPct = null; $minIdInd = null;
 
            foreach ($indikatorIds as $id) {
                $pct = (float) ($byInd->get($id)?->pct ?? 0);
                $row->{"ind{$id}_pct"} = $pct;
 
                if ($pct > 0 && ($minPct === null || $pct < $minPct)) {
                    $minPct = $pct; $minIdInd = $id;
                }
            }
            $row->ind_terendah     = $minIdInd ? "I{$minIdInd}" : '-';
            $row->ind_terendah_pct = $minPct ?? 0;
            return $row;
        });
 
        // ── Tren Bulanan ────────────────────────────────────────────────────────
        // Dihitung langsung dari data_phbs (hanya laporan terkirim)
        $trenBulan = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            // ->where('dp.status_laporan', 'terkirim')
            ->where('p.status_aktif', true)
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'dp.bulan',
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_lk+dp.jumlah_kk_pr),0)*100,2) AS rata_rata'),
            )
            ->groupBy('dp.bulan')
            ->orderBy('dp.bulan')
            ->get();
 
        $trenLabels = $trenBulan->map(fn($t) => NewDataPHBS::namaBulan((int) $t->bulan))->toArray();
        $trenData   = $trenBulan->pluck('rata_rata')->map(fn($v) => (float) $v)->toArray();
 
        // target nasional: rata-rata dari tabel, fallback 70
        // $targetNasional = (float) (NewIndikator::aktif()->avg('target_nasional') ?? 70);
 
        // ── Grafik batang ───────────────────────────────────────────────────────
        $grafikLabels = $rekapData->pluck('nama_puskesmas')
            ->map(fn($n) => $this->singkat($n))->values()->toArray();
        $grafikData   = $rekapData->pluck('persentase_phbs')
            ->map(fn($v) => (float) $v)->values()->toArray();
        $grafikColors = $rekapData
            ->map(fn($r) => $this->warna((float) $r->persentase_phbs))->values()->toArray();
 
        // ── Tahun tersedia ──────────────────────────────────────────────────────
        $availableTahun = NewDataPHBS::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        if ($availableTahun->isEmpty()) $availableTahun = collect([date('Y')]);
 
        return view('dinkes.beranda.index', compact(
            'rataRataPhbs', 'puskesmasTertinggi', 'puskesmasTerendah',
            'distribusiTinggi', 'distribusiSedang', 'distribusiRendah', 'distribusiSangatRendah',
            'rekapData', 'rekapIndikator', 'matriksData', 'allIndikators',
            'grafikLabels', 'grafikData', 'grafikColors',
            'trenLabels', 'trenData',
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