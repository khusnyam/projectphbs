<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewDataPHBS;
use App\Models\NewDataPHBSDetail;
use App\Models\NewPuskesmas;

class PBerandaController extends Controller
{
    /**
     * Dashboard Puskesmas
     * Menampilkan data PHBS spesifik untuk satu puskesmas
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Validasi user adalah puskesmas
        if ($user->role->role !== 'puskesmas') {
            abort(403, 'Akses hanya untuk pengguna Puskesmas');
        }

        // Get puskesmas dari auth user
        $puskesmas = $user->puskesmas;
        if (!$puskesmas) {
            abort(403, 'Pengguna belum terhubung dengan puskesmas');
        }

        // Parameters
        $tahun = $request->query('tahun', date('Y'));
        $bulan = $request->query('bulan', null);

        // Get available years
        $availableTahun = NewDataPHBS::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->distinct('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($availableTahun->isEmpty()) {
            $availableTahun = collect([date('Y')]);
        }

        // Build query
        $query = NewDataPHBSDetail::with(['header', 'indikator'])
            ->whereHas('header', function ($q) use ($puskesmas, $tahun, $bulan) {
                $q->where('id_puskesmas', $puskesmas->id_puskesmas)
                  ->where('tahun', $tahun);

                if ($bulan) {
                    $bulanNama = $this->getNamaBulan($bulan);
                    $q->where('bulan', $bulanNama);
                }
            });

        $details = $query->get();

        // Sort by bulan
        $details = $details->sortBy(function ($item) {
            $months = [
                'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
            ];
            return $months[$item->header->bulan] ?? 99;
        })->values();

        // Hitung statistik
        $totalKeluarga = 0;
        $kkLaki = 0;
        $kkPerempuan = 0;
        $keluargaBerPhbs = 0;
        $rataRataPhbs = 0;
        $dataLengkap = true;

        if ($details->isNotEmpty()) {
            $latestHeader = $details->last()->header;

            $totalKeluarga = $latestHeader->jumlah_kk_total ?? 0;
            $kkLaki = $latestHeader->jumlah_kk_lk ?? 0;
            $kkPerempuan = $latestHeader->jumlah_kk_pr ?? 0;
            $keluargaBerPhbs = $latestHeader->ber_phbs ?? 0;

            if ($totalKeluarga > 0) {
                $rataRataPhbs = round(($keluargaBerPhbs / $totalKeluarga) * 100, 1);
            }

            $totalIndikators = 13;
            $filledIndicators = $details->count();
            $dataLengkap = $filledIndicators >= $totalIndikators;
        }

        $persentasePhbs = $rataRataPhbs;

        $trendData = $this->formatTrendData($details);
        $rasioData = $this->formatRasioData($details);
        $indicators = $this->formatIndicators($details);

        return view('beranda.index', [
            'puskesmas' => $puskesmas,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'availableTahun' => $availableTahun,
            'totalKeluarga' => $totalKeluarga,
            'kkLaki' => $kkLaki,
            'kkPerempuan' => $kkPerempuan,
            'keluargaBerPhbs' => $keluargaBerPhbs,
            'persentasePhbs' => $persentasePhbs,
            'rataRataPhbs' => $rataRataPhbs,
            'dataLengkap' => $dataLengkap,
            'trendData' => $trendData,
            'rasioData' => $rasioData,
            'indicators' => $indicators,
        ]);
    }

    private function formatTrendData($details)
    {
        $trendByMonth = [];

        foreach ($details as $detail) {
            $bulan = $detail->header->bulan;
            $id_phbs = $detail->id_phbs;

            if (!isset($trendByMonth[$id_phbs])) {
                $trendByMonth[$id_phbs] = [
                    'bulan' => $bulan,
                    'ber_phbs' => $detail->header->ber_phbs,
                    'total' => $detail->header->jumlah_kk_total,
                    'persentase' => $detail->header->jumlah_kk_total > 0
                        ? round(($detail->header->ber_phbs / $detail->header->jumlah_kk_total) * 100, 1)
                        : 0,
                ];
            }
        }

        $months = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
            'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
            'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        usort($trendByMonth, function ($a, $b) use ($months) {
            $orderA = $months[$a['bulan']] ?? 99;
            $orderB = $months[$b['bulan']] ?? 99;
            return $orderA <=> $orderB;
        });

        return array_values($trendByMonth);
    }

    private function formatRasioData($details)
    {
        $rasioByMonth = [];

        foreach ($details as $detail) {
            $bulan = $detail->header->bulan;
            $id_phbs = $detail->id_phbs;

            if (!isset($rasioByMonth[$id_phbs])) {
                $rasioByMonth[$id_phbs] = [
                    'bulan' => $bulan,
                    'ber_phbs' => $detail->header->ber_phbs,
                    'total' => $detail->header->jumlah_kk_total,
                ];
            }
        }

        $months = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
            'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
            'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        usort($rasioByMonth, function ($a, $b) use ($months) {
            $orderA = $months[$a['bulan']] ?? 99;
            $orderB = $months[$b['bulan']] ?? 99;
            return $orderA <=> $orderB;
        });

        return array_values($rasioByMonth);
    }

    private function formatIndicators($details)
    {
        $indicators = [];

        foreach ($details as $detail) {
            $indId = $detail->id_indikator;

            if (!isset($indicators[$indId])) {
                $indicators[$indId] = [
                    'id' => $indId,
                    'kode' => $detail->indikator->kode_indikator ?? 'PHB-' . str_pad($indId, 2, '0', STR_PAD_LEFT),
                    'nama' => $detail->indikator->nama_indikator ?? 'Indikator ' . $indId,
                    'target' => $detail->jumlah_sasaran ?? $detail->header->jumlah_kk_total,
                    'capaian' => $detail->jumlah_capaian ?? 0,
                    'persentase' => $detail->persentase ?? 0,
                ];
            }
        }

        return array_values($indicators);
    }

    private function getNamaBulan($bulan)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $months[$bulan] ?? null;
    }
}