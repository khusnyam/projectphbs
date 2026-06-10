<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('data_phbs', function (Blueprint $table) {
            $table->id('id_phbs');
            $table->unsignedBigInteger('id_puskesmas');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('jumlah_kk_lk');
            $table->integer('jumlah_kk_pr'); 
            $table->integer('ber_phbs')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('data_phbs');
    }
};
