<?php

namespace App\Http\Controllers;

use App\Models\data_phbs;
use App\Models\IndikatorPhbs;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ── Filter ────────────────────────────────────────────────────────
        $tahun        = (int) $request->get('tahun', date('Y'));
        $bulan        = $request->filled('bulan')        ? (int) $request->get('bulan')        : null;
        $id_puskesmas = $request->filled('id_puskesmas') ? (int) $request->get('id_puskesmas') : null;

        // ── Dropdown Puskesmas ─────────────────────────────────────────────
        $puskesmasList = Puskesmas::aktif()
            ->orderBy('nama_puskesmas')
            ->get(['id_puskesmas', 'nama_puskesmas']);

        // ── Status Laporan Count ───────────────────────────────────────────
        $baseQuery = data_phbs::where('tahun', $tahun)
            ->when($bulan,        fn($q) => $q->where('bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('id_puskesmas', $id_puskesmas));

        $statusTerkirim = (clone $baseQuery)->where('status_laporan', 'terkirim')->count();
        $statusDraft    = (clone $baseQuery)->where('status_laporan', 'draft')->count();

        // ── Rekapitulasi per Puskesmas (untuk stat cards + info cards) ────
        $rekapData = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('dp.status_laporan', 'terkirim')
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->select(
                'p.id_puskesmas', 'p.nama_puskesmas', 'p.kecamatan', 'p.kepala_puskesmas',
                DB::raw('COUNT(dp.id_data)         AS jumlah_laporan'),
                DB::raw('SUM(dp.jumlah_kk_total)   AS total_kk'),
                DB::raw('SUM(dp.ber_phbs)           AS total_ber_phbs'),
                DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,2) AS persentase_phbs'),
            )
            ->groupBy('p.id_puskesmas','p.nama_puskesmas','p.kecamatan','p.kepala_puskesmas')
            ->orderBy('persentase_phbs', 'desc')
            ->get();

        // Rata-rata, tertinggi, terendah
        $rataRataPhbs       = round($rekapData->avg('persentase_phbs') ?? 0, 1);
        $puskesmasTertinggi = $rekapData->first();
        $puskesmasTerendah  = $rekapData->last();

        // Distribusi 4 level
        $distribusiTinggi       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 70)->count();
        $distribusiSedang       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 50 && $r->persentase_phbs < 70)->count();
        $distribusiRendah       = $rekapData->filter(fn($r) => $r->persentase_phbs >= 30 && $r->persentase_phbs < 50)->count();
        $distribusiSangatRendah = $rekapData->filter(fn($r) => $r->persentase_phbs < 30)->count();

        // ── Matriks 13 Indikator per Puskesmas ────────────────────────────
        $matriksData = DB::table('data_phbs as dp')
            ->join('puskesmas as p', 'dp.id_puskesmas', '=', 'p.id_puskesmas')
            ->where('dp.tahun', $tahun)
            ->where('p.status_aktif', true)
            ->when($bulan,        fn($q) => $q->where('dp.bulan',        $bulan))
            ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
            ->selectRaw("
                p.id_puskesmas, p.nama_puskesmas,
                COUNT(dp.id_data) AS jumlah_laporan,
                ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,1) AS rata_rata,
                ROUND(SUM(dp.ind1_jumlah) /NULLIF(SUM(dp.ind1_sasaran) ,0)*100,1) AS ind1_pct,
                ROUND(SUM(dp.ind2_jumlah) /NULLIF(SUM(dp.ind2_sasaran) ,0)*100,1) AS ind2_pct,
                ROUND(SUM(dp.ind3_jumlah) /NULLIF(SUM(dp.ind3_sasaran) ,0)*100,1) AS ind3_pct,
                ROUND(SUM(dp.ind4_jumlah) /NULLIF(SUM(dp.ind4_sasaran) ,0)*100,1) AS ind4_pct,
                ROUND(SUM(dp.ind5_jumlah) /NULLIF(SUM(dp.ind5_sasaran) ,0)*100,1) AS ind5_pct,
                ROUND(SUM(dp.ind6_jumlah) /NULLIF(SUM(dp.ind6_sasaran) ,0)*100,1) AS ind6_pct,
                ROUND(SUM(dp.ind7_jumlah) /NULLIF(SUM(dp.ind7_sasaran) ,0)*100,1) AS ind7_pct,
                ROUND(SUM(dp.ind8_jumlah) /NULLIF(SUM(dp.ind8_sasaran) ,0)*100,1) AS ind8_pct,
                ROUND(SUM(dp.ind9_jumlah) /NULLIF(SUM(dp.ind9_sasaran) ,0)*100,1) AS ind9_pct,
                ROUND(SUM(dp.ind10_jumlah)/NULLIF(SUM(dp.ind10_sasaran),0)*100,1) AS ind10_pct,
                ROUND(SUM(dp.ind11_jumlah)/NULLIF(SUM(dp.ind11_sasaran),0)*100,1) AS ind11_pct,
                ROUND(SUM(dp.ind12_jumlah)/NULLIF(SUM(dp.ind12_sasaran),0)*100,1) AS ind12_pct,
                ROUND(SUM(dp.ind13_jumlah)/NULLIF(SUM(dp.ind13_sasaran),0)*100,1) AS ind13_pct
            ")
            ->groupBy('p.id_puskesmas','p.nama_puskesmas')
            ->orderBy('rata_rata', 'desc')
            ->get();

        // Hitung indikator terendah per puskesmas
        foreach ($matriksData as $row) {
            $min = null; $minIdx = null;
            for ($i = 1; $i <= 13; $i++) {
                $pct = (float) ($row->{"ind{$i}_pct"} ?? 0);
                if ($pct > 0 && ($min === null || $pct < $min)) {
                    $min = $pct; $minIdx = $i;
                }
            }
            $row->ind_terendah     = $minIdx ? "I{$minIdx}" : '-';
            $row->ind_terendah_pct = $min ?? 0;
        }

        // ── Rekap per Indikator (akumulasi kabupaten) ──────────────────────
        $namaIndikator = IndikatorPhbs::aktif()
            ->orderBy('kode_indikator')
            ->pluck('nama_indikator', 'id_indikator')
            ->toArray();
        if (empty($namaIndikator)) $namaIndikator = data_phbs::labelIndikator();

        $rekapIndikator = [];
        for ($i = 1; $i <= 13; $i++) {
            $row = DB::table('data_phbs')
                ->where('tahun', $tahun)
                ->where('status_laporan', 'terkirim')
                ->when($bulan,        fn($q) => $q->where('bulan',        $bulan))
                ->when($id_puskesmas, fn($q) => $q->where('id_puskesmas', $id_puskesmas))
                ->selectRaw("SUM(ind{$i}_sasaran) AS ts, SUM(ind{$i}_jumlah) AS tj,
                    ROUND(SUM(ind{$i}_jumlah)/NULLIF(SUM(ind{$i}_sasaran),0)*100,2) AS pct")
                ->first();
            $rekapIndikator[$i] = [
                'label'         => $namaIndikator[$i] ?? "Indikator {$i}",
                'total_sasaran' => (int)  ($row->ts  ?? 0),
                'total_jumlah'  => (int)  ($row->tj  ?? 0),
                'persentase'    => (float)($row->pct ?? 0),
            ];
        }

        // ── Tren Bulanan ───────────────────────────────────────────────────
        $trenBulan = DB::table('capaian_bulanan as cb')
            ->join('puskesmas as p','cb.id_puskesmas','=','p.id_puskesmas')
            ->where('cb.tahun', $tahun)->where('p.status_aktif', true)
            ->when($id_puskesmas, fn($q) => $q->where('cb.id_puskesmas', $id_puskesmas))
            ->select('cb.bulan', DB::raw('ROUND(AVG(cb.persentase_capaian),2) AS rata_rata'))
            ->groupBy('cb.bulan')->orderBy('cb.bulan')->get();

        if ($trenBulan->isEmpty()) {
            $trenBulan = DB::table('data_phbs as dp')
                ->join('puskesmas as p','dp.id_puskesmas','=','p.id_puskesmas')
                ->where('dp.tahun',$tahun)->where('dp.status_laporan','terkirim')->where('p.status_aktif',true)
                ->when($id_puskesmas, fn($q) => $q->where('dp.id_puskesmas', $id_puskesmas))
                ->select('dp.bulan',DB::raw('ROUND(SUM(dp.ber_phbs)/NULLIF(SUM(dp.jumlah_kk_total),0)*100,2) AS rata_rata'))
                ->groupBy('dp.bulan')->orderBy('dp.bulan')->get();
        }

        $trenLabels   = $trenBulan->map(fn($t) => data_phbs::namaBulan((int)$t->bulan))->toArray();
        $trenData     = $trenBulan->pluck('rata_rata')->toArray();
        $targetNasional = IndikatorPhbs::aktif()->avg('target_nasional') ?? 70;

        // Grafik bar
        $grafikLabels = $rekapData->pluck('nama_puskesmas')->map(fn($n) => $this->singkat($n))->values()->toArray();
        $grafikData   = $rekapData->pluck('persentase_phbs')->values()->toArray();
        $grafikColors = $rekapData->map(fn($r) => $this->warna((float)$r->persentase_phbs))->values()->toArray();

        // ── Filter Options ─────────────────────────────────────────────────
        $availableTahun = data_phbs::select('tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun');
        if ($availableTahun->isEmpty()) $availableTahun = collect([date('Y')]);

        return view('dashboard.index', compact(
            'rataRataPhbs','puskesmasTertinggi','puskesmasTerendah',
            'statusTerkirim','statusDraft',
            'distribusiTinggi','distribusiSedang','distribusiRendah','distribusiSangatRendah',
            'rekapData','rekapIndikator','matriksData',
            'grafikLabels','grafikData','grafikColors',
            'trenLabels','trenData','targetNasional',
            'tahun','bulan','id_puskesmas','availableTahun','puskesmasList',
        ));
    }

    private function singkat(string $n): string
    {
        return trim(preg_replace('/^(PUSKESMAS|UPT\s+PUSKESMAS|PKM|UPT)\s+/i', '', $n));
    }

    private function warna(float $p): string
    {
        return match(true) {
            $p >= 70 => 'rgba(34,197,94,.82)',
            $p >= 50 => 'rgba(234,179,8,.82)',
            $p >= 30 => 'rgba(249,115,22,.82)',
            default  => 'rgba(239,68,68,.82)',
        };
    }
}