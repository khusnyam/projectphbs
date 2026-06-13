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
        //JANUARI
            for ($idPuskesmas = 1; $idPuskesmas <= 25; $idPuskesmas++) {

                $kkLk = rand(180, 350);
                $kkPr = rand(180, 350);
                $totalKK = $kkLk + $kkPr;
                $berPhbs = rand((int)($totalKK * 0.65), (int)($totalKK * 0.90));

                $header = NewDataPHBS::create([
                    'id_puskesmas' => $idPuskesmas,
                    'bulan' => NewDataPHBS::namaBulan($bulan),
                    'tahun' => '2026',
                    'jumlah_kk_lk' => $kkLk,
                    'jumlah_kk_pr' => $kkPr,
                    'ber_phbs' => $berPhbs,
                ]);

                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 1,
                    'jumlah_sasaran' => rand(50,120),
                    'jumlah_capaian' => rand(0,100)
                ]);

                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 2,
                    'jumlah_sasaran' => rand(50,120),
                    'jumlah_capaian' => rand(0,120)
                ]);

                NewDataPHBSDetail::create([
                    'id_phbs' => $header->id_phbs,
                    'id_indikator' => 3,
                    'jumlah_sasaran' => rand(50,120),
                    'jumlah_capaian' => rand(0,120)
                ]);

                for ($indikator = 4; $indikator <= 13; $indikator++) {
                    NewDataPHBSDetail::create([
                        'id_phbs' => $header->id_phbs,
                        'id_indikator' => $indikator,
                        'jumlah_sasaran' => null,
                        'jumlah_capaian' => rand((int)($totalKK * 0.40),(int)($totalKK * 1)
                        )
                    ]);
                }
            }
        }
    }
}
