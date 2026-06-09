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
        Schema::create('1data_phbs_details', function (Blueprint $table) {
            $table->id('id_detail_phbs1');
            $table->unsignedBigInteger('id_indikator1');
            $table->unsignedBigInteger('id_puskesmas1');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('jumlah_kk_lk');
            $table->integer('jumlah_kk_pr'); 
            $table->integer('jumlah_sasaran')->nullable();
            $table->integer('jumlah_capaian');
            $table->enum('status_laporan', ['draft','terkirim'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1data_phbs_details');
    }
};
