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
        Schema::create('data_phbs_detail', function (Blueprint $table) {
            $table->id('id_detail_phbs');
            $table->unsignedBigInteger('id_phbs');
            $table->unsignedBigInteger('id_indikator');
            $table->integer('jumlah_sasaran')->nullable();
            $table->integer('jumlah_capaian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_phbs_detail');
    }
};
