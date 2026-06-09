<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * 16 Kecamatan Sleman dengan polygon boundary (GeoJSON).
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Kecamatan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            ['nama_kecamatan' => 'Gamping', 'geojson_polygon' => $this->poly([[110.3020,-7.7780],[110.3280,-7.7780],[110.3280,-7.8200],[110.3020,-7.8200]])],
            ['nama_kecamatan' => 'Godean', 'geojson_polygon' => $this->poly([[110.2680,-7.7700],[110.3020,-7.7700],[110.3020,-7.8100],[110.2680,-7.8100]])],
            ['nama_kecamatan' => 'Moyudan', 'geojson_polygon' => $this->poly([[110.2300,-7.7550],[110.2680,-7.7550],[110.2680,-7.7900],[110.2300,-7.7900]])],
            ['nama_kecamatan' => 'Minggir', 'geojson_polygon' => $this->poly([[110.2300,-7.7900],[110.2680,-7.7900],[110.2680,-7.8250],[110.2300,-7.8250]])],
            ['nama_kecamatan' => 'Seyegan', 'geojson_polygon' => $this->poly([[110.2680,-7.7300],[110.3080,-7.7300],[110.3080,-7.7700],[110.2680,-7.7700]])],
            ['nama_kecamatan' => 'Mlati', 'geojson_polygon' => $this->poly([[110.3280,-7.7450],[110.3600,-7.7450],[110.3600,-7.7900],[110.3280,-7.7900]])],
            ['nama_kecamatan' => 'Depok', 'geojson_polygon' => $this->poly([[110.3600,-7.7450],[110.4150,-7.7450],[110.4150,-7.7900],[110.3600,-7.7900]])],
            ['nama_kecamatan' => 'Berbah', 'geojson_polygon' => $this->poly([[110.4150,-7.7600],[110.4450,-7.7600],[110.4450,-7.7900],[110.4150,-7.7900]])],
            ['nama_kecamatan' => 'Prambanan', 'geojson_polygon' => $this->poly([[110.4450,-7.7500],[110.4800,-7.7500],[110.4800,-7.7900],[110.4450,-7.7900]])],
            ['nama_kecamatan' => 'Kalasan', 'geojson_polygon' => $this->poly([[110.4150,-7.7300],[110.4450,-7.7300],[110.4450,-7.7600],[110.4150,-7.7600]])],
            ['nama_kecamatan' => 'Ngemplak', 'geojson_polygon' => $this->poly([[110.3900,-7.7200],[110.4450,-7.7200],[110.4450,-7.7500],[110.3900,-7.7500]])],
            ['nama_kecamatan' => 'Ngaglik', 'geojson_polygon' => $this->poly([[110.3280,-7.7200],[110.3900,-7.7200],[110.3900,-7.7450],[110.3280,-7.7450]])],
            ['nama_kecamatan' => 'Sleman', 'geojson_polygon' => $this->poly([[110.3080,-7.7100],[110.3600,-7.7100],[110.3600,-7.7300],[110.3080,-7.7300]])],
            ['nama_kecamatan' => 'Tempel', 'geojson_polygon' => $this->poly([[110.2700,-7.6800],[110.3500,-7.6800],[110.3500,-7.7100],[110.2700,-7.7100]])],
            ['nama_kecamatan' => 'Turi', 'geojson_polygon' => $this->poly([[110.3500,-7.6400],[110.3900,-7.6400],[110.3900,-7.6800],[110.3500,-7.6800]])],
            ['nama_kecamatan' => 'Pakem', 'geojson_polygon' => $this->poly([[110.3900,-7.6200],[110.4300,-7.6200],[110.4300,-7.6700],[110.3900,-7.6700]])],
            ['nama_kecamatan' => 'Cangkringan', 'geojson_polygon' => $this->poly([[110.4300,-7.6200],[110.4800,-7.6200],[110.4800,-7.6900],[110.4300,-7.6900]])],
        ];

        foreach ($data as $item) {
            Kecamatan::create($item);
        }
    }

    private function poly(array $coords): string
    {
        return json_encode([
            'type' => 'Polygon',
            'coordinates' => [array_merge($coords, [$coords[0]])],
        ]);
    }
}
