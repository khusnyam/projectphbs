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
        
        schema::table('puskesmas', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatans')->onDelete('cascade');
        });

        schema::table('data_phbs', function (Blueprint $table) {
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('puskesmas')->onDelete('cascade');
            // $table->foreign('id_data_phbs_detail1')->references('id_detail_phbs')->on('data_phbs_detail')->onDelete('cascade');
        });

        schema::table('users', function (Blueprint $table) {
            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });

        schema::table('indikator_phbs', function (Blueprint $table) {
            $table->boolean('status_aktif')->default(true)->change();
        });

        schema::table('data_phbs_detail', function (Blueprint $table) {
            $table->foreign('id_indikator')->references('id_indikator')->on('indikator_phbs')->onDelete('cascade');
            $table->foreign('id_phbs')->references('id_phbs')->on('data_phbs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
