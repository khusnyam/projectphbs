<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capaian_bulanan', function (Blueprint $table) {

            $table->id('id_capaian');

            // FK sesuai tabel puskesmas asli
            $table->unsignedBigInteger('id_puskesmas');

            $table->tinyInteger('bulan');

            $table->smallInteger('tahun');

            $table->decimal('persentase_capaian', 5, 2)
                  ->default(0);

            $table->integer('jumlah_sasaran')
                  ->default(0);

            $table->integer('jumlah_tercapai')
                  ->default(0);

            $table->enum('status_kategori', [
                'Sangat Rendah',
                'Rendah',
                'Sedang',
                'Tinggi'
            ])->default('Rendah');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('id_puskesmas')
                  ->references('id_puskesmas')
                  ->on('puskesmas')
                  ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'id_puskesmas',
                'bulan',
                'tahun'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capaian_bulanan');
    }
};