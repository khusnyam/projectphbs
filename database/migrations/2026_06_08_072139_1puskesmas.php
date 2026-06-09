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
        Schema::create('1puskesmas', function (Blueprint $table) {
            $table->id('id_puskesmas1');
            $table->unsignedBigInteger('id_user1');
            $table->unsignedBigInteger('id_kecamatan1');
            $table->string('nama_puskesmas');
            $table->text('alamat');
            $table->string('email');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1puskesmas');
    }
};
