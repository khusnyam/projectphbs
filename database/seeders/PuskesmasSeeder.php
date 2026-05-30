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
            ['nama_puskesmas'=>'Puskesmas Gamping I',    'alamat'=>'Jl. Wates KM 6, Gamping',              'kecamatan'=>'Gamping',     'persentase_capaian'=>78.4, 'jumlah_kk'=>21340, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.3020,-7.7780],[110.3280,-7.7780],[110.3280,-7.8000],[110.3020,-7.8000],[110.3020,-7.7780]])],
            ['nama_puskesmas'=>'Puskesmas Gamping II',   'alamat'=>'Jl. Kabupaten, Trihanggo, Gamping',    'kecamatan'=>'Gamping',     'persentase_capaian'=>61.2, 'jumlah_kk'=>18760, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3020,-7.8000],[110.3280,-7.8000],[110.3280,-7.8200],[110.3020,-7.8200],[110.3020,-7.8000]])],
            ['nama_puskesmas'=>'Puskesmas Godean I',     'alamat'=>'Jl. Godean KM 10, Sidoarum',           'kecamatan'=>'Godean',      'persentase_capaian'=>85.7, 'jumlah_kk'=>19580, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.2680,-7.7700],[110.3020,-7.7700],[110.3020,-7.7900],[110.2680,-7.7900],[110.2680,-7.7700]])],
            ['nama_puskesmas'=>'Puskesmas Godean II',    'alamat'=>'Jl. Godean KM 11, Sidomulyo',          'kecamatan'=>'Godean',      'persentase_capaian'=>42.3, 'jumlah_kk'=>16400, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.2680,-7.7900],[110.3020,-7.7900],[110.3020,-7.8100],[110.2680,-7.8100],[110.2680,-7.7900]])],
            ['nama_puskesmas'=>'Puskesmas Moyudan',      'alamat'=>'Jl. Nanggulan, Sumberrahayu',          'kecamatan'=>'Moyudan',     'persentase_capaian'=>55.6, 'jumlah_kk'=>14230, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.2300,-7.7550],[110.2680,-7.7550],[110.2680,-7.7900],[110.2300,-7.7900],[110.2300,-7.7550]])],
            ['nama_puskesmas'=>'Puskesmas Minggir',      'alamat'=>'Jl. Kebon Agung, Sendangmulyo',        'kecamatan'=>'Minggir',     'persentase_capaian'=>19.8, 'jumlah_kk'=>11870, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.2300,-7.7900],[110.2680,-7.7900],[110.2680,-7.8250],[110.2300,-7.8250],[110.2300,-7.7900]])],
            ['nama_puskesmas'=>'Puskesmas Seyegan',      'alamat'=>'Jl. Kebonagung KM 9, Margomulyo',      'kecamatan'=>'Seyegan',     'persentase_capaian'=>70.2, 'jumlah_kk'=>16540, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.2680,-7.7300],[110.3080,-7.7300],[110.3080,-7.7700],[110.2680,-7.7700],[110.2680,-7.7300]])],
            ['nama_puskesmas'=>'Puskesmas Mlati I',      'alamat'=>'Jl. Magelang KM 8, Sinduadi',          'kecamatan'=>'Mlati',       'persentase_capaian'=>88.1, 'jumlah_kk'=>22100, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.3280,-7.7450],[110.3600,-7.7450],[110.3600,-7.7700],[110.3280,-7.7700],[110.3280,-7.7450]])],
            ['nama_puskesmas'=>'Puskesmas Mlati II',     'alamat'=>'Jl. Rajawali, Tirtoadi',               'kecamatan'=>'Mlati',       'persentase_capaian'=>74.5, 'jumlah_kk'=>19870, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3280,-7.7700],[110.3600,-7.7700],[110.3600,-7.7900],[110.3280,-7.7900],[110.3280,-7.7700]])],
            ['nama_puskesmas'=>'Puskesmas Depok I',      'alamat'=>'Jl. Kabupaten, Condongcatur',          'kecamatan'=>'Depok',       'persentase_capaian'=>91.3, 'jumlah_kk'=>28600, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.3600,-7.7450],[110.3900,-7.7450],[110.3900,-7.7700],[110.3600,-7.7700],[110.3600,-7.7450]])],
            ['nama_puskesmas'=>'Puskesmas Depok II',     'alamat'=>'Jl. Cempaka, Maguwoharjo',             'kecamatan'=>'Depok',       'persentase_capaian'=>83.9, 'jumlah_kk'=>25300, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.3600,-7.7700],[110.3900,-7.7700],[110.3900,-7.7900],[110.3600,-7.7900],[110.3600,-7.7700]])],
            ['nama_puskesmas'=>'Puskesmas Depok III',    'alamat'=>'Jl. Ringroad Utara, Caturtunggal',     'kecamatan'=>'Depok',       'persentase_capaian'=>67.8, 'jumlah_kk'=>23100, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3900,-7.7600],[110.4150,-7.7600],[110.4150,-7.7850],[110.3900,-7.7850],[110.3900,-7.7600]])],
            ['nama_puskesmas'=>'Puskesmas Berbah',       'alamat'=>'Jl. Solo KM 15, Tegaltirto',           'kecamatan'=>'Berbah',      'persentase_capaian'=>46.7, 'jumlah_kk'=>17450, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.4150,-7.7600],[110.4450,-7.7600],[110.4450,-7.7900],[110.4150,-7.7900],[110.4150,-7.7600]])],
            ['nama_puskesmas'=>'Puskesmas Prambanan',    'alamat'=>'Jl. Solo KM 18, Bokoharjo',            'kecamatan'=>'Prambanan',   'persentase_capaian'=>58.4, 'jumlah_kk'=>18200, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.4450,-7.7500],[110.4800,-7.7500],[110.4800,-7.7900],[110.4450,-7.7900],[110.4450,-7.7500]])],
            ['nama_puskesmas'=>'Puskesmas Kalasan',      'alamat'=>'Jl. Solo KM 14, Tirtomartani',         'kecamatan'=>'Kalasan',     'persentase_capaian'=>76.1, 'jumlah_kk'=>20340, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.4150,-7.7300],[110.4450,-7.7300],[110.4450,-7.7600],[110.4150,-7.7600],[110.4150,-7.7300]])],
            ['nama_puskesmas'=>'Puskesmas Ngemplak I',   'alamat'=>'Jl. Kaliurang KM 13, Wedomartani',     'kecamatan'=>'Ngemplak',    'persentase_capaian'=>33.5, 'jumlah_kk'=>15680, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.3900,-7.7200],[110.4150,-7.7200],[110.4150,-7.7450],[110.3900,-7.7450],[110.3900,-7.7200]])],
            ['nama_puskesmas'=>'Puskesmas Ngemplak II',  'alamat'=>'Jl. Nanggulan, Bimomartani',           'kecamatan'=>'Ngemplak',    'persentase_capaian'=>24.9, 'jumlah_kk'=>13200, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.4150,-7.7200],[110.4450,-7.7200],[110.4450,-7.7500],[110.4150,-7.7500],[110.4150,-7.7200]])],
            ['nama_puskesmas'=>'Puskesmas Ngaglik I',    'alamat'=>'Jl. Kaliurang KM 10, Sariharjo',       'kecamatan'=>'Ngaglik',     'persentase_capaian'=>80.6, 'jumlah_kk'=>24500, 'status_kategori'=>'Tinggi',        'geojson_polygon'=>$this->poly([[110.3600,-7.7200],[110.3900,-7.7200],[110.3900,-7.7450],[110.3600,-7.7450],[110.3600,-7.7200]])],
            ['nama_puskesmas'=>'Puskesmas Ngaglik II',   'alamat'=>'Jl. Palagan Tentara Pelajar, Donoharjo','kecamatan'=>'Ngaglik',    'persentase_capaian'=>65.3, 'jumlah_kk'=>21800, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3280,-7.7200],[110.3600,-7.7200],[110.3600,-7.7450],[110.3280,-7.7450],[110.3280,-7.7200]])],
            ['nama_puskesmas'=>'Puskesmas Sleman',       'alamat'=>'Jl. Bhayangkara 48, Tridadi',          'kecamatan'=>'Sleman',      'persentase_capaian'=>71.8, 'jumlah_kk'=>22900, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3080,-7.7100],[110.3600,-7.7100],[110.3600,-7.7300],[110.3080,-7.7300],[110.3080,-7.7100]])],
            ['nama_puskesmas'=>'Puskesmas Tempel I',     'alamat'=>'Jl. Magelang KM 17, Margorejo',        'kecamatan'=>'Tempel',      'persentase_capaian'=>47.2, 'jumlah_kk'=>15600, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.3080,-7.6800],[110.3500,-7.6800],[110.3500,-7.7100],[110.3080,-7.7100],[110.3080,-7.6800]])],
            ['nama_puskesmas'=>'Puskesmas Tempel II',    'alamat'=>'Jl. Magelang KM 19, Pondokrejo',       'kecamatan'=>'Tempel',      'persentase_capaian'=>38.9, 'jumlah_kk'=>13200, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.2700,-7.6800],[110.3080,-7.6800],[110.3080,-7.7100],[110.2700,-7.7100],[110.2700,-7.6800]])],
            ['nama_puskesmas'=>'Puskesmas Turi',         'alamat'=>'Jl. Kaliurang KM 18, Donokerto',       'kecamatan'=>'Turi',        'persentase_capaian'=>52.4, 'jumlah_kk'=>12100, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3500,-7.6400],[110.3900,-7.6400],[110.3900,-7.6800],[110.3500,-7.6800],[110.3500,-7.6400]])],
            ['nama_puskesmas'=>'Puskesmas Pakem',        'alamat'=>'Jl. Kaliurang KM 22, Pakembinangun',   'kecamatan'=>'Pakem',       'persentase_capaian'=>63.7, 'jumlah_kk'=>13400, 'status_kategori'=>'Sedang',        'geojson_polygon'=>$this->poly([[110.3900,-7.6200],[110.4300,-7.6200],[110.4300,-7.6700],[110.3900,-7.6700],[110.3900,-7.6200]])],
            ['nama_puskesmas'=>'Puskesmas Cangkringan',  'alamat'=>'Jl. Merapi Golf, Argomulyo',           'kecamatan'=>'Cangkringan', 'persentase_capaian'=>29.3, 'jumlah_kk'=>10870, 'status_kategori'=>'Rendah',        'geojson_polygon'=>$this->poly([[110.4300,-7.6200],[110.4800,-7.6200],[110.4800,-7.6900],[110.4300,-7.6900],[110.4300,-7.6200]])],
        ];

        foreach ($data as $item) {
            Puskesmas::create($item);
        }
    }

    private function poly(array $coords): string
    {
        return json_encode([
            'type'        => 'Polygon',
            'coordinates' => [$coords],
        ]);
    }
}
