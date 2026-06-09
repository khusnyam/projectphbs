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
        //

        // 1. INPUT DATA HEADER (Hanya 1 baris untuk bulan Januari)
        $header = NewDataPHBS::create(['id_puskesmas' => 6, 'bulan' => 'Januari', 'tahun' => '2026', 'jumlah_kk_lk' => 100, 'jumlah_kk_pr' => 100, 'ber_phbs' => 104]);

        // 2. INPUT DATA DETAIL (Satu baris untuk tiap indikator)
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 1, 'jumlah_sasaran' => 40, 'jumlah_capaian' => 37]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 2, 'jumlah_sasaran' => 45, 'jumlah_capaian' => 42]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 3, 'jumlah_sasaran' => 60, 'jumlah_capaian' => 50]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 4, 'jumlah_sasaran' => null, 'jumlah_capaian' => 190]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 5, 'jumlah_sasaran' => null, 'jumlah_capaian' => 170]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 6, 'jumlah_sasaran' => null, 'jumlah_capaian' => 160]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 7, 'jumlah_sasaran' => null, 'jumlah_capaian' => 205]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 8, 'jumlah_sasaran' => null, 'jumlah_capaian' => 150]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 9, 'jumlah_sasaran' => null, 'jumlah_capaian' => 145]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 10, 'jumlah_sasaran' => null, 'jumlah_capaian' => 120]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 11, 'jumlah_sasaran' => null, 'jumlah_capaian' => 180]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 12, 'jumlah_sasaran' => null, 'jumlah_capaian' => 175]);
        NewDataPHBSDetail::create(['id_phbs' => $header->id_phbs, 'id_indikator' => 13, 'jumlah_sasaran' => null, 'jumlah_capaian' => 230]);
    }
}
