<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NewPuskesmas;

class NewPuskesmasSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        NewPuskesmas::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['id_user'=>2,'id_kecamatan'=>1,'nama_puskesmas'=>'Puskesmas Gamping I','alamat'=>'Jl. Wates KM 6, Gamping','email'=>'gamping1@phbs.test','status_aktif'=>true],
            ['id_user'=>3,'id_kecamatan'=>1,'nama_puskesmas'=>'Puskesmas Gamping II','alamat'=>'Jl. Kabupaten, Trihanggo, Gamping','email'=>'gamping2@phbs.test','status_aktif'=>true],
            ['id_user'=>4,'id_kecamatan'=>2,'nama_puskesmas'=>'Puskesmas Godean I','alamat'=>'Jl. Godean KM 10, Sidoarum','email'=>'godean1@phbs.test','status_aktif'=>true],
            ['id_user'=>5,'id_kecamatan'=>2,'nama_puskesmas'=>'Puskesmas Godean II','alamat'=>'Jl. Godean KM 11, Sidomulyo','email'=>'godean2@phbs.test','status_aktif'=>true],
            ['id_user'=>6,'id_kecamatan'=>3,'nama_puskesmas'=>'Puskesmas Moyudan','alamat'=>'Jl. Nanggulan, Sumberrahayu','email'=>'moyudan@phbs.test','status_aktif'=>true],
            ['id_user'=>7,'id_kecamatan'=>4,'nama_puskesmas'=>'Puskesmas Minggir','alamat'=>'Jl. Kebon Agung, Sendangmulyo','email'=>'minggir@phbs.test','status_aktif'=>true],
            ['id_user'=>8,'id_kecamatan'=>5,'nama_puskesmas'=>'Puskesmas Seyegan','alamat'=>'Jl. Kebonagung KM 9, Margomulyo','email'=>'seyegan@phbs.test','status_aktif'=>true],
            ['id_user'=>9,'id_kecamatan'=>6,'nama_puskesmas'=>'Puskesmas Mlati I','alamat'=>'Jl. Magelang KM 8, Sinduadi','email'=>'mlati1@phbs.test','status_aktif'=>true],
            ['id_user'=>10,'id_kecamatan'=>6,'nama_puskesmas'=>'Puskesmas Mlati II','alamat'=>'Jl. Rajawali, Tirtoadi','email'=>'mlati2@phbs.test','status_aktif'=>true],
            ['id_user'=>11,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok I','alamat'=>'Jl. Kabupaten, Condongcatur','email'=>'depok1@phbs.test','status_aktif'=>true],
            ['id_user'=>12,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok II','alamat'=>'Jl. Cempaka, Maguwoharjo','email'=>'depok2@phbs.test','status_aktif'=>true],
            ['id_user'=>13,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok III','alamat'=>'Jl. Ringroad Utara, Caturtunggal','email'=>'depok3@phbs.test','status_aktif'=>true],
            ['id_user'=>14,'id_kecamatan'=>8,'nama_puskesmas'=>'Puskesmas Berbah','alamat'=>'Jl. Solo KM 15, Tegaltirto','email'=>'berbah@phbs.test','status_aktif'=>true],
            ['id_user'=>15,'id_kecamatan'=>9,'nama_puskesmas'=>'Puskesmas Prambanan','alamat'=>'Jl. Solo KM 18, Bokoharjo','email'=>'prambanan@phbs.test','status_aktif'=>true],
            ['id_user'=>16,'id_kecamatan'=>10,'nama_puskesmas'=>'Puskesmas Kalasan','alamat'=>'Jl. Solo KM 14, Tirtomartani','email'=>'kalasan@phbs.test','status_aktif'=>true],
            ['id_user'=>17,'id_kecamatan'=>11,'nama_puskesmas'=>'Puskesmas Ngemplak I','alamat'=>'Jl. Kaliurang KM 13, Wedomartani','email'=>'ngemplak1@phbs.test','status_aktif'=>true],
            ['id_user'=>18,'id_kecamatan'=>11,'nama_puskesmas'=>'Puskesmas Ngemplak II','alamat'=>'Jl. Nanggulan, Bimomartani','email'=>'ngemplak2@phbs.test','status_aktif'=>true],
            ['id_user'=>19,'id_kecamatan'=>12,'nama_puskesmas'=>'Puskesmas Ngaglik I','alamat'=>'Jl. Kaliurang KM 10, Sariharjo','email'=>'ngaglik1@phbs.test','status_aktif'=>true],
            ['id_user'=>20,'id_kecamatan'=>12,'nama_puskesmas'=>'Puskesmas Ngaglik II','alamat'=>'Jl. Palagan Tentara Pelajar, Donoharjo','email'=>'ngaglik2@phbs.test','status_aktif'=>true],
            ['id_user'=>21,'id_kecamatan'=>13,'nama_puskesmas'=>'Puskesmas Sleman','alamat'=>'Jl. Bhayangkara 48, Tridadi','email'=>'sleman@phbs.test','status_aktif'=>true],
            ['id_user'=>22,'id_kecamatan'=>14,'nama_puskesmas'=>'Puskesmas Tempel I','alamat'=>'Jl. Magelang KM 17, Margorejo','email'=>'tempel1@phbs.test','status_aktif'=>true],
            ['id_user'=>23,'id_kecamatan'=>14,'nama_puskesmas'=>'Puskesmas Tempel II','alamat'=>'Jl. Magelang KM 19, Pondokrejo','email'=>'tempel2@phbs.test','status_aktif'=>true],
            ['id_user'=>24,'id_kecamatan'=>15,'nama_puskesmas'=>'Puskesmas Turi','alamat'=>'Jl. Kaliurang KM 18, Donokerto','email'=>'turi@phbs.test','status_aktif'=>true],
            ['id_user'=>25,'id_kecamatan'=>16,'nama_puskesmas'=>'Puskesmas Pakem','alamat'=>'Jl. Kaliurang KM 22, Pakembinangun','email'=>'pakem@phbs.test','status_aktif'=>true],
            ['id_user'=>26,'id_kecamatan'=>17,'nama_puskesmas'=>'Puskesmas Cangkringan','alamat'=>'Jl. Merapi Golf, Argomulyo','email'=>'cangkringan@phbs.test','status_aktif'=>true],
        ];

        foreach ($data as $item) {
            NewPuskesmas::create($item);
        }
    }
}