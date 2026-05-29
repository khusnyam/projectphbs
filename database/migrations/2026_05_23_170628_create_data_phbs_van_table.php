<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('data_phbs_van', function (Blueprint $table) {
            $table->id('id_data');
            $table->unsignedBigInteger('id_puskesmas');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->integer('jumlah_kk_l')->default(0);
            $table->integer('jumlah_kk_p')->default(0);
            $table->integer('jumlah_kk_total')->default(0);
            // 13 Indikator
            $table->integer('ind1_sasaran')->default(0);  $table->integer('ind1_jumlah')->default(0);
            $table->integer('ind2_sasaran')->default(0);  $table->integer('ind2_jumlah')->default(0);
            $table->integer('ind3_sasaran')->default(0);  $table->integer('ind3_jumlah')->default(0);
            $table->integer('ind4_sasaran')->default(0);  $table->integer('ind4_jumlah')->default(0);
            $table->integer('ind5_sasaran')->default(0);  $table->integer('ind5_jumlah')->default(0);
            $table->integer('ind6_sasaran')->default(0);  $table->integer('ind6_jumlah')->default(0);
            $table->integer('ind7_sasaran')->default(0);  $table->integer('ind7_jumlah')->default(0);
            $table->integer('ind8_sasaran')->default(0);  $table->integer('ind8_jumlah')->default(0);
            $table->integer('ind9_sasaran')->default(0);  $table->integer('ind9_jumlah')->default(0);
            $table->integer('ind10_sasaran')->default(0); $table->integer('ind10_jumlah')->default(0);
            $table->integer('ind11_sasaran')->default(0); $table->integer('ind11_jumlah')->default(0);
            $table->integer('ind12_sasaran')->default(0); $table->integer('ind12_jumlah')->default(0);
            $table->integer('ind13_sasaran')->default(0); $table->integer('ind13_jumlah')->default(0);
            $table->integer('ber_phbs')->default(0);
            $table->decimal('persen_phbs', 5, 2)->default(0);
            $table->enum('status_laporan', ['draft','terkirim'])->default('draft');
            $table->timestamps();
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('puskesmas');
        });
    }
    public function down(): void {
        Schema::dropIfExists('data_phbs_van');
    }
};
