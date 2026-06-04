<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('data_phbs', function (Blueprint $table) {
            $table->id('id_data');
            $table->unsignedBigInteger('id_puskesmas');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->integer('jumlah_kk_l')->default(0); //lakilaki
            $table->integer('jumlah_kk_p')->default(0); //perempuan
            $table->integer('jumlah_kk_total')->default(0);
            // // 13 Indikator
            // $table->integer('persalinan_nakes_sasaran')->default(0);      $table->integer('persalinan_nakes_jumlah')->default(0);
            // $table->integer('asi_eksklusif_sasaran')->default(0);         $table->integer('asi_eksklusif_jumlah')->default(0);
            // $table->integer('timbang_balita_sasaran')->default(0);        $table->integer('timbang_balita_jumlah')->default(0);
            // $table->integer('air_bersih_sasaran')->default(0);            $table->integer('air_bersih_jumlah')->default(0);
            // $table->integer('cuci_tangan_sasaran')->default(0);           $table->integer('cuci_tangan_jumlah')->default(0);
            // $table->integer('pengelolaan_air_minum_sasaran')->default(0); $table->integer('pengelolaan_air_minum_jumlah')->default(0);
            // $table->integer('jamban_sehat_sasaran')->default(0);          $table->integer('jamban_sehat_jumlah')->default(0);
            // $table->integer('pengelolaan_limbah_sasaran')->default(0);    $table->integer('pengelolaan_limbah_jumlah')->default(0);
            // $table->integer('buang_sampah_sasaran')->default(0);          $table->integer('buang_sampah_jumlah')->default(0);
            // $table->integer('pemberantasan_jentik_sasaran')->default(0);  $table->integer('pemberantasan_jentik_jumlah')->default(0);
            // $table->integer('makan_buah_sayur_sasaran')->default(0);      $table->integer('makan_buah_sayur_jumlah')->default(0);
            // $table->integer('aktivitas_fisik_sasaran')->default(0);       $table->integer('aktivitas_fisik_jumlah')->default(0);
            // $table->integer('tidak_merokok_sasaran')->default(0);         $table->integer('tidak_merokok_jumlah')->default(0);
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
