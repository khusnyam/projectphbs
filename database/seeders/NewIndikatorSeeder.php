<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewIndikator;

class NewIndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        NewIndikator::insert([
            ['kode_indikator'=>'IND01','nama_indikator'=>'Persalinan Ditolong Tenaga Kesehatan','deskripsi'=>'Persalinan ditolong oleh tenaga kesehatan yang kompeten.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND02','nama_indikator'=>'Pemberian ASI Eksklusif','deskripsi'=>'Bayi usia 0-6 bulan mendapatkan ASI eksklusif.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND03','nama_indikator'=>'Menimbang Balita Setiap Bulan','deskripsi'=>'Balita ditimbang secara rutin setiap bulan.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND04','nama_indikator'=>'Menggunakan Air Bersih','deskripsi'=>'Rumah tangga menggunakan sumber air bersih yang memenuhi syarat kesehatan.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND05','nama_indikator'=>'Cuci Tangan Pakai Sabun','deskripsi'=>'Anggota rumah tangga melakukan cuci tangan pakai sabun pada waktu penting.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND06','nama_indikator'=>'Pengelolaan Air Minum Rumah Tangga','deskripsi'=>'Air minum rumah tangga dikelola secara aman dan sehat.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND07','nama_indikator'=>'Menggunakan Jamban Sehat','deskripsi'=>'Rumah tangga menggunakan jamban sehat.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND08','nama_indikator'=>'Pengelolaan Limbah Cair Rumah Tangga','deskripsi'=>'Limbah cair rumah tangga dikelola dengan baik.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND09','nama_indikator'=>'Membuang Sampah Pada Tempatnya','deskripsi'=>'Sampah rumah tangga dibuang pada tempat yang semestinya.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND10','nama_indikator'=>'Pemberantasan Sarang Nyamuk','deskripsi'=>'Melakukan pemberantasan sarang nyamuk secara rutin.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND11','nama_indikator'=>'Konsumsi Buah dan Sayur','deskripsi'=>'Anggota rumah tangga mengonsumsi buah dan sayur setiap hari.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND12','nama_indikator'=>'Melakukan Aktivitas Fisik','deskripsi'=>'Anggota rumah tangga melakukan aktivitas fisik secara teratur.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['kode_indikator'=>'IND13','nama_indikator'=>'Tidak Merokok','deskripsi'=>'Tidak merokok di dalam rumah maupun lingkungan keluarga.','status_aktif'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
