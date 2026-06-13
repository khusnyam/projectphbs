<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\IndikatorPhbs;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardPhbsController extends Controller
{
    // Mapping nama bulan (sesuai isi database) → index 1-12
    private array $bulanMap = [
        'Januari'=>1,'Februari'=>2,'Maret'=>3,'April'=>4,
        'Mei'=>5,'Juni'=>6,'Juli'=>7,'Agustus'=>8,
        'September'=>9,'Oktober'=>10,'November'=>11,'Desember'=>12,
    ];

    public function index(Request $request)
    {
        // ── Filter ──────────────────────────────────────────────────────────
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = $request->filled('bulan') ? $request->get('bulan') : null;
        // bulan filter pakai nama juga (karena DB simpan string)
        $bulanNama = $bulan ? array_search((int)$bulan, $this->bulanMap) : null;

        // ── Dropdown tahun tersedia ──────────────────────────────────────────
        $availableTahun = NewDataPHBS::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        if ($availableTahun->isEmpty()) $availableTahun = collect([date('Y')]);

        // ── Semua indikator ──────────────────────────────────────────────────
        $allIndikators = DB::table('indikator_phbs')
            ->where('status_aktif', true)
            ->orderBy('id_indikator')
            ->get();

        // ── Ringkasan 13 Indikator tingkat Kabupaten ─────────────────────────
        $detailAgg = DB::table('data_phbs_detail as dpd')
            ->join('data_phbs as dp',  'dpd.id_phbs',     '=', 'dp.id_phbs')
            ->join('puskesmas as p',   'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulanNama, fn($q) => $q->where('dp.bulan', $bulanNama))
            ->select(
                'dpd.id_indikator',
                DB::raw('SUM(CASE WHEN dpd.id_indikator IN (1,2,3) THEN dpd.jumlah_sasaran ELSE (dp.jumlah_kk_lk + dp.jumlah_kk_pr) END) AS total_sasaran'),
                DB::raw('SUM(dpd.jumlah_capaian) AS total_capaian'),
                DB::raw('ROUND(SUM(dpd.jumlah_capaian) / NULLIF(SUM(CASE WHEN dpd.id_indikator IN (1,2,3) THEN dpd.jumlah_sasaran ELSE (dp.jumlah_kk_lk + dp.jumlah_kk_pr) END), 0) * 100, 2) AS persentase'),
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
                    'total_sasaran' => (int)   ($agg?->total_sasaran ?? 0),
                    'total_capaian' => (int)   ($agg?->total_capaian ?? 0),
                    'persentase'    => (float) ($agg?->persentase    ?? 0),
                ],
            ];
        })->all();

        // ── Indikator terkuat & terlemah ─────────────────────────────────────
        $indWithData    = collect($rekapIndikator)->filter(fn($v) => $v['persentase'] > 0);
        $indTerkuat     = $indWithData->sortByDesc('persentase')->first();
        $indTerlemah    = $indWithData->sortBy('persentase')->first();
        $indTerkuatKey  = $indWithData->sortByDesc('persentase')->keys()->first();
        $indTerlemahKey = $indWithData->sortBy('persentase')->keys()->first();

        // ── Rata-rata kabupaten ──────────────────────────────────────────────
        $rataKabupaten = round($indWithData->avg('persentase') ?? 0, 1);

        // ── Radar chart ──────────────────────────────────────────────────────
        $radarLabels = $allIndikators->pluck('kode_indikator')->toArray();
        $radarData   = $allIndikators->map(fn($ind) =>
            (float) ($rekapIndikator[$ind->id_indikator]['persentase'] ?? 0)
        )->toArray();

        // ── Tren per indikator per bulan ─────────────────────────────────────
        // DB menyimpan bulan sebagai nama: "Januari", "Februari", dst.
        $namaBulanFull = array_keys($this->bulanMap);   // urutan Januari-Desember
        $namaBulan     = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

        $trenPerIndikator = DB::table('data_phbs_detail as dpd')
            ->join('data_phbs as dp',  'dpd.id_phbs',     '=', 'dp.id_phbs')
            ->join('puskesmas as p',   'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->whereIn('dp.bulan', $namaBulanFull)   // pastikan hanya baris dengan nama bulan valid
            ->select(
                'dp.bulan',
                'dpd.id_indikator',
                DB::raw('ROUND(SUM(dpd.jumlah_capaian) / NULLIF(SUM(CASE WHEN dpd.id_indikator IN (1,2,3) THEN dpd.jumlah_sasaran ELSE (dp.jumlah_kk_lk + dp.jumlah_kk_pr) END), 0) * 100, 2) AS persentase'),
            )
            ->groupBy('dp.bulan', 'dpd.id_indikator')
            ->get()
            ->groupBy('id_indikator');

        $trenData = [];
        foreach ($allIndikators as $ind) {
            // keyBy nama bulan: "Januari", "Februari", dst.
            $byBulan = $trenPerIndikator->get($ind->id_indikator, collect())
                ->keyBy('bulan');
            $bulanan = [];
            foreach ($namaBulanFull as $nb) {
                $bulanan[] = (float) ($byBulan->get($nb)?->persentase ?? 0);
            }
            $trenData[$ind->id_indikator] = [
                'kode'  => $ind->kode_indikator,
                'label' => $ind->nama_indikator,
                'data'  => $bulanan,
            ];
        }

        // ── Heatmap: Indikator × Bulan ───────────────────────────────────────
        $heatmapData = [];
        foreach ($allIndikators as $ind) {
            $byBulan = $trenPerIndikator->get($ind->id_indikator, collect())
                ->keyBy('bulan');
            $row = ['kode' => $ind->kode_indikator, 'label' => $ind->nama_indikator, 'bulan' => []];
            foreach ($namaBulanFull as $nb) {
                $row['bulan'][] = (float) ($byBulan->get($nb)?->persentase ?? 0);
            }
            $heatmapData[] = $row;
        }

        // ── Distribusi level indikator ───────────────────────────────────────
        $indTinggi       = collect($rekapIndikator)->filter(fn($v) => $v['persentase'] >= 70)->count();
        $indSedang       = collect($rekapIndikator)->filter(fn($v) => $v['persentase'] >= 50 && $v['persentase'] < 70)->count();
        $indRendah       = collect($rekapIndikator)->filter(fn($v) => $v['persentase'] >= 30 && $v['persentase'] < 50)->count();
        $indSangatRendah = collect($rekapIndikator)->filter(fn($v) => $v['persentase'] < 30 && $v['persentase'] > 0)->count();

        return view('dinkes.dashboard.index', compact(
            'tahun', 'bulan', 'availableTahun',
            'allIndikators', 'rekapIndikator',
            'indTerkuat', 'indTerlemah', 'indTerkuatKey', 'indTerlemahKey',
            'rataKabupaten',
            'radarLabels', 'radarData',
            'trenData', 'heatmapData', 'namaBulan',
            'indTinggi', 'indSedang', 'indRendah', 'indSangatRendah',
        ));
    }
}