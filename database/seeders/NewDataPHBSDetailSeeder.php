<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewDataPHBSDetail;

class NewDataPHBSDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        NewDataPHBSDetail::insert([
        ['id_indikator1'=>1,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>50,'jumlah_kk_pr'=>50,'jumlah_sasaran'=>40,'jumlah_capaian'=>37,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>2,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>60,'jumlah_kk_pr'=>60,'jumlah_sasaran'=>45,'jumlah_capaian'=>42,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>3,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>75,'jumlah_kk_pr'=>75,'jumlah_sasaran'=>60,'jumlah_capaian'=>50,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>4,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>100,'jumlah_kk_pr'=>100,'jumlah_sasaran'=>null,'jumlah_capaian'=>190,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>5,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>100,'jumlah_kk_pr'=>100,'jumlah_sasaran'=>null,'jumlah_capaian'=>170,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>6,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>90,'jumlah_kk_pr'=>90,'jumlah_sasaran'=>null,'jumlah_capaian'=>160,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>7,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>105,'jumlah_kk_pr'=>105,'jumlah_sasaran'=>null,'jumlah_capaian'=>205,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>8,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>95,'jumlah_kk_pr'=>95,'jumlah_sasaran'=>null,'jumlah_capaian'=>150,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>9,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>100,'jumlah_kk_pr'=>100,'jumlah_sasaran'=>null,'jumlah_capaian'=>145,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>10,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>85,'jumlah_kk_pr'=>85,'jumlah_sasaran'=>null,'jumlah_capaian'=>120,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>11,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>110,'jumlah_kk_pr'=>110,'jumlah_sasaran'=>null,'jumlah_capaian'=>180,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>12,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>105,'jumlah_kk_pr'=>105,'jumlah_sasaran'=>null,'jumlah_capaian'=>175,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ['id_indikator1'=>13,'bulan'=>'Januari','tahun'=>'2025','jumlah_kk_lk'=>125,'jumlah_kk_pr'=>125,'jumlah_sasaran'=>null,'jumlah_capaian'=>230,'status_laporan'=>'terkirim','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
