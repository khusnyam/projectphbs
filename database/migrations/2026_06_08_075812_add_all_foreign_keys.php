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
        
        schema::table('1puskesmas', function (Blueprint $table) {
            $table->foreign('id_user1')->references('id_user1')->on('1users')->onDelete('cascade');
            $table->foreign('id_kecamatan1')->references('id_kecamatan1')->on('1kecamatans')->onDelete('cascade');
        });

        schema::table('1data_phbs_result', function (Blueprint $table) {
            $table->foreign('id_puskesmas1')->references('id_puskesmas1')->on('1puskesmas')->onDelete('cascade');
            $table->foreign('id_data_phbs_detail1')->references('id_detail_phbs1')->on('1data_phbs_details')->onDelete('cascade');
        });

        schema::table('1users', function (Blueprint $table) {
            $table->foreign('id_role1')->references('id_role1')->on('1roles')->onDelete('cascade');
        });

        schema::table('1indikator_phbs', function (Blueprint $table) {
            $table->boolean('status_aktif')->default(true)->change();
        });

        schema::table('1data_phbs_details', function (Blueprint $table) {
            $table->foreign('id_indikator1')->references('id_indikator1')->on('1indikator_phbs')->onDelete('cascade');
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
