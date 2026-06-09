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
//         Schema::create('puskesmas', function (Blueprint $table) {
//             $table->id('id_puskesmas');
//             $table->string('nama_puskesmas');
//             $table->text('alamat');
//             $table->string('kecamatan');
//             $table->string('kabupaten')->default('Sleman');
//             $table->string('provinsi')->default('Daerah Istimewa Yogyakarta');
//             $table->string('kode_pos')->default('Tidak Ada Data');
//             $table->string('no_telepon')->default('Tidak Ada Data');
//             $table->string('email');
//             $table->string('kepala_puskesmas')->default('Tidak Ada Data');
//             $table->integer('latitude')->nullable();
//             $table->integer('longitude')->nullable();
//             $table->boolean('status_aktif')->default(true);
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('puskesmas');
//     }
// };
