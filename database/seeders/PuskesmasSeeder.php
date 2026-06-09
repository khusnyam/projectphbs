<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuskesmasSeeder extends Seeder
{
    /**
     * 25 Puskesmas Kabupaten Sleman – koordinat polygon per kecamatan (GeoJSON lon,lat).
     * Sumber referensi batas kecamatan Sleman (disederhanakan untuk demo).
     */
    public function run(): void
    {
        // Nonaktifkan FK check dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Puskesmas::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['id_user'=>2,'id_kecamatan'=>1,'nama_puskesmas'=>'Puskesmas Gamping I','alamat'=>'Jl. Wates KM 6, Gamping','jumlah_kk_lk'=>10780,'jumlah_kk_pr'=>10560],
            ['id_user'=>3,'id_kecamatan'=>1,'nama_puskesmas'=>'Puskesmas Gamping II','alamat'=>'Jl. Kabupaten, Trihanggo, Gamping','jumlah_kk_lk'=>9480,'jumlah_kk_pr'=>9280],
            ['id_user'=>4,'id_kecamatan'=>2,'nama_puskesmas'=>'Puskesmas Godean I','alamat'=>'Jl. Godean KM 10, Sidoarum','jumlah_kk_lk'=>9870,'jumlah_kk_pr'=>9710],
            ['id_user'=>5,'id_kecamatan'=>2,'nama_puskesmas'=>'Puskesmas Godean II','alamat'=>'Jl. Godean KM 11, Sidomulyo','jumlah_kk_lk'=>8260,'jumlah_kk_pr'=>8140],
            ['id_user'=>6,'id_kecamatan'=>3,'nama_puskesmas'=>'Puskesmas Moyudan','alamat'=>'Jl. Nanggulan, Sumberrahayu','jumlah_kk_lk'=>7180,'jumlah_kk_pr'=>7050],
            ['id_user'=>7,'id_kecamatan'=>4,'nama_puskesmas'=>'Puskesmas Minggir','alamat'=>'Jl. Kebon Agung, Sendangmulyo','jumlah_kk_lk'=>5980,'jumlah_kk_pr'=>5890],
            ['id_user'=>8,'id_kecamatan'=>5,'nama_puskesmas'=>'Puskesmas Seyegan','alamat'=>'Jl. Kebonagung KM 9, Margomulyo','jumlah_kk_lk'=>8340,'jumlah_kk_pr'=>8200],
            ['id_user'=>9,'id_kecamatan'=>6,'nama_puskesmas'=>'Puskesmas Mlati I','alamat'=>'Jl. Magelang KM 8, Sinduadi','jumlah_kk_lk'=>11150,'jumlah_kk_pr'=>10950],
            ['id_user'=>10,'id_kecamatan'=>6,'nama_puskesmas'=>'Puskesmas Mlati II','alamat'=>'Jl. Rajawali, Tirtoadi','jumlah_kk_lk'=>10020,'jumlah_kk_pr'=>9850],
            ['id_user'=>11,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok I','alamat'=>'Jl. Kabupaten, Condongcatur','jumlah_kk_lk'=>14450,'jumlah_kk_pr'=>14150],
            ['id_user'=>12,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok II','alamat'=>'Jl. Cempaka, Maguwoharjo','jumlah_kk_lk'=>12780,'jumlah_kk_pr'=>12520],
            ['id_user'=>13,'id_kecamatan'=>7,'nama_puskesmas'=>'Puskesmas Depok III','alamat'=>'Jl. Ringroad Utara, Caturtunggal','jumlah_kk_lk'=>11650,'jumlah_kk_pr'=>11450],
            ['id_user'=>14,'id_kecamatan'=>8,'nama_puskesmas'=>'Puskesmas Berbah','alamat'=>'Jl. Solo KM 15, Tegaltirto','jumlah_kk_lk'=>8810,'jumlah_kk_pr'=>8640],
            ['id_user'=>15,'id_kecamatan'=>9,'nama_puskesmas'=>'Puskesmas Prambanan','alamat'=>'Jl. Solo KM 18, Bokoharjo','jumlah_kk_lk'=>9190,'jumlah_kk_pr'=>9010],
            ['id_user'=>16,'id_kecamatan'=>10,'nama_puskesmas'=>'Puskesmas Kalasan','alamat'=>'Jl. Solo KM 14, Tirtomartani','jumlah_kk_lk'=>10280,'jumlah_kk_pr'=>10060],
            ['id_user'=>17,'id_kecamatan'=>11,'nama_puskesmas'=>'Puskesmas Ngemplak I','alamat'=>'Jl. Kaliurang KM 13, Wedomartani','jumlah_kk_lk'=>7920,'jumlah_kk_pr'=>7760],
            ['id_user'=>18,'id_kecamatan'=>11,'nama_puskesmas'=>'Puskesmas Ngemplak II','alamat'=>'Jl. Nanggulan, Bimomartani','jumlah_kk_lk'=>6670,'jumlah_kk_pr'=>6530],
            ['id_user'=>19,'id_kecamatan'=>12,'nama_puskesmas'=>'Puskesmas Ngaglik I','alamat'=>'Jl. Kaliurang KM 10, Sariharjo','jumlah_kk_lk'=>12380,'jumlah_kk_pr'=>12120],
            ['id_user'=>20,'id_kecamatan'=>12,'nama_puskesmas'=>'Puskesmas Ngaglik II','alamat'=>'Jl. Palagan Tentara Pelajar, Donoharjo','jumlah_kk_lk'=>11010,'jumlah_kk_pr'=>10790],
            ['id_user'=>21,'id_kecamatan'=>13,'nama_puskesmas'=>'Puskesmas Sleman','alamat'=>'Jl. Bhayangkara 48, Tridadi','jumlah_kk_lk'=>11560,'jumlah_kk_pr'=>11340],
            ['id_user'=>22,'id_kecamatan'=>14,'nama_puskesmas'=>'Puskesmas Tempel I','alamat'=>'Jl. Magelang KM 17, Margorejo','jumlah_kk_lk'=>7890,'jumlah_kk_pr'=>7710],
            ['id_user'=>23,'id_kecamatan'=>14,'nama_puskesmas'=>'Puskesmas Tempel II','alamat'=>'Jl. Magelang KM 19, Pondokrejo','jumlah_kk_lk'=>6680,'jumlah_kk_pr'=>6520],
            ['id_user'=>24,'id_kecamatan'=>15,'nama_puskesmas'=>'Puskesmas Turi','alamat'=>'Jl. Kaliurang KM 18, Donokerto','jumlah_kk_lk'=>6120,'jumlah_kk_pr'=>5980],
            ['id_user'=>25,'id_kecamatan'=>16,'nama_puskesmas'=>'Puskesmas Pakem','alamat'=>'Jl. Kaliurang KM 22, Pakembinangun','jumlah_kk_lk'=>6780,'jumlah_kk_pr'=>6620],
            ['id_user'=>26,'id_kecamatan'=>17,'nama_puskesmas'=>'Puskesmas Cangkringan','alamat'=>'Jl. Merapi Golf, Argomulyo','jumlah_kk_lk'=>5490,'jumlah_kk_pr'=>5380],
        ];

        foreach ($data as $item) {
            Puskesmas::create($item);
        }
    }
}