<?php

namespace Database\Seeders;

use App\Models\CapaianBulanan;
use App\Models\Puskesmas;
use Illuminate\Database\Seeder;

class CapaianBulananSeeder extends Seeder
{
    public function run(): void
    {
        CapaianBulanan::truncate();

        $tahun = 2024;
        $puskesmasList = Puskesmas::all();

        foreach ($puskesmasList as $pkm) {
            $finalPct = $pkm->persentase_capaian ?? 50;
            $startPct = $finalPct * mt_rand(30, 55) / 100;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $progress = ($bulan - 1) / 11;
                $base     = $startPct + ($finalPct - $startPct) * $progress;
                $noise    = mt_rand(-400, 400) / 100;
                $pct      = max(0, min(100, round($base + $noise, 2)));

                $sasaran  = $pkm->jumlah_kk ?? 0;        // ✅ jumlah_kk
                $tercapai = (int) round($sasaran * $pct / 100);

                CapaianBulanan::create([
                    'id_puskesmas'       => $pkm->id_puskesmas,  // ✅ id_puskesmas
                    'bulan'              => $bulan,
                    'tahun'              => $tahun,
                    'persentase_capaian' => $pct,
                    'jumlah_sasaran'     => $sasaran,
                    'jumlah_tercapai'    => $tercapai,
                    'status_kategori'    => CapaianBulanan::getStatusByPersentase($pct),
                ]);
            }
        }
    }
}