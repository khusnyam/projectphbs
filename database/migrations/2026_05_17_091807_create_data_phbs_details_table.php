<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('data_phbs_details', function (Blueprint $table) {
//             $table->id('id_detail_phbs');
//             $table->foreignId('id_indikator')->constrained('indikator_phbs')->onDelete('cascade');
//             $table->moonth('bulan');
//             $table->year('tahun');
//             $table->integer('jumlah_sasaran');
//             $table->integer('jumlah_capaian');
//             $table->integer('persentase_capaian');
//             $table->text('keterangan');
//             $table->enum('status_laporan', ['draft','terkirim'])->default('draft');
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('data_phbs_details');
//     }
// };
