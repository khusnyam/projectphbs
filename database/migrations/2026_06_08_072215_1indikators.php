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
        Schema::create('1indikator_phbs', function (Blueprint $table) {
            $table->id('id_indikator1');
            $table->string('kode_indikator')->unique();
            $table->string('nama_indikator');
            $table->string('deskripsi');
            $table->boolean('status_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1indikator_phbs');
    }
};
