<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewDataPHBSDetail;
use App\Models\NewDataPHBS;

class NewDataPHBSDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            for ($idPuskesmas = 1; $idPuskesmas <= 25; $idPuskesmas++) {

                $kkLk = rand(180, 350);
                $kkPr = rand(180, 350);
                $totalKK = $kkLk + $kkPr;

                // ─── PENENTUAN KATEGORI BERVARIASI VIA PROBABILITAS ───
                $dice = rand(1, 100);

                if ($dice <= 40) {
                    // Kategori Tinggi (>= 70%) -> Peluang muncul 40%
                    $minPercent = 0.70;
                    $maxPercent = 0.95;
                } elseif ($dice <= 70) {
                    // Kategori Sedang (50% - 69%) -> Peluang muncul 30%
                    $minPercent = 0.50;
                    $maxPercent = 0.69;
                } elseif ($dice <= 90) {
                    // Kategori Rendah (30% - 49%) -> Peluang muncul 20%
                    $minPercent = 0.30;
                    $maxPercent = 0.49;
                } else {
                    // Kategori Sangat Rendah (< 30%) -> Peluang muncul 10%
                    $minPercent = 0.10;
                    $maxPercent = 0.29;
                }

                // Hitung ber_phbs sesuai dengan range kategori yang terpilih di atas
                $berPhbs = rand((int)($totalKK * $minPercent), (int)($totalKK * $maxPercent));

                $header = NewDataPHBS::create([
                    'id_puskesmas' => $idPuskesmas,
                    'bulan' => NewDataPHBS::namaBulan($bulan),
                    'tahun' => '2026',
                    'jumlah_kk_lk' => $kkLk,
                    'jumlah_kk_pr' => $kkPr,
                    'ber_phbs' => $berPhbs,
                ]);

                // ─── INDIKATOR 1 - 3 (IKUT BERVARIASI SESUAI KATEGORI) ───
                $sasaran1 = rand(50, 120);
                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 1,
                    'jumlah_sasaran' => $sasaran1,
                    'jumlah_capaian' => rand((int)($sasaran1 * $minPercent), (int)($sasaran1 * min(1, $maxPercent + 0.05)))
                ]);

                $sasaran2 = rand(50, 120);
                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 2,
                    'jumlah_sasaran' => $sasaran2,
                    'jumlah_capaian' => rand((int)($sasaran2 * $minPercent), (int)($sasaran2 * min(1, $maxPercent + 0.05)))
                ]);

                $sasaran3 = rand(50, 120);
                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 3,
                    'jumlah_sasaran' => $sasaran3,
                    'jumlah_capaian' => rand((int)($sasaran3 * $minPercent), (int)($sasaran3 * min(1, $maxPercent + 0.05)))
                ]);

                // ─── INDIKATOR 4 s/d 13 (IKUT BERVARIASI SESUAI KATEGORI) ───
                for ($indikator = 4; $indikator <= 13; $indikator++) {
                    NewDataPHBSDetail::create([
                        'id_phbs' => $header->id_phbs,
                        'id_indikator' => $indikator,
                        'jumlah_sasaran' => null,
                        'jumlah_capaian' => rand((int)($totalKK * $minPercent), (int)($totalKK * min(1, $maxPercent + 0.05)))
                    ]);
                }
            }
        }
    }
}