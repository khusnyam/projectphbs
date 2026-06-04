<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('data_phbs', function (Blueprint $table) {
            $table->id('id_phbs');
            $table->unsignedBigInteger('id_puskesmas');
            $table->year('tahun');
            $table->string('bulan');
            $table->integer('jumlah_kk_l')->default(0)->nullable(); //lakilaki
            $table->integer('jumlah_kk_p')->default(0)->nullable(); //perempuan
            $table->integer('jumlah_kk_total')->default(0)->nullable();
            $table->integer('ber_phbs')->default(0);
            $table->decimal('persen_phbs', 5, 2)->default(0);
            $table->enum('status_laporan', ['draft','terkirim'])->default('draft');
            $table->timestamps();
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('puskesmas');
        });
    }
    public function down(): void {
        Schema::dropIfExists('data_phbs');
    }
};
