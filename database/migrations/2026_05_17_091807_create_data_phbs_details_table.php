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
        Schema::create('data_phbs_details', function (Blueprint $table) {
            $table->id('id_detail_phbs');
            $table->foreignId('id_phbs');
            $table->foreignId('id_indikator');
            $table->integer('jumlah_sasaran');
            $table->integer('jumlah_capaian');
            $table->integer('persentase');
            $table->enum('kategori_capaian', ['Tinggi','Sedang','Rendah']);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_phbs_details');
    }
};
