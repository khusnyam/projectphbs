<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('puskesmas', function (Blueprint $table) {

            $table->float('persentase_capaian')
                  ->default(0)
                  ->after('longitude');

            $table->integer('jumlah_kk')
                  ->nullable()
                  ->after('persentase_capaian');

            $table->string('status_kategori')
                  ->nullable()
                  ->after('jumlah_kk');

            $table->json('geojson_polygon')
                  ->nullable()
                  ->after('status_kategori');

            $table->string('warna')
                  ->nullable()
                  ->after('geojson_polygon');
        });
    }

    public function down(): void
    {
        Schema::table('puskesmas', function (Blueprint $table) {

            $table->dropColumn([
                'persentase_capaian',
                'jumlah_kk',
                'status_kategori',
                'geojson_polygon',
                'warna'
            ]);
        });
    }
};