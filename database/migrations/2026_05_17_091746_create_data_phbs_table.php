<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_phbs', function (Blueprint $table) {
            $table->id('id_phbs');
            $table->foreignId('id_puskesmas');
            $table->enum('bulan',['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']);
            $table->integer('tahun');
            $table->integer('jumlah_kk');
            $table->integer('persalinan_nakes');
            $table->integer('asi_eksklusif');
            $table->integer('timbang_balita');
            $table->integer('air_bersih');
            $table->integer('cuci_tangan');
            $table->integer('jamban_sehat');
            $table->integer('tidak_merokok');
            $table->integer('aktivitas_fisik');
            $table->integer('makan_buah_sayur');
            $table->integer('pengelolaan_air_minum');
            $table->integer('pengelolaan_limbah');
            $table->integer('buang_sampah');
            $table->integer('pemberantasan_jentik');
            $table->integer('total_indikator_phbs');
            $table->string('kategori_phbs');
            $table->integer('user_penginput');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_phbs');
    }
};
