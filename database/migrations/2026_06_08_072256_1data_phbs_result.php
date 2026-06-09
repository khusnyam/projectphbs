<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('1data_phbs_result', function (Blueprint $table) {
            $table->id('id_phbs1');
            $table->unsignedBigInteger('id_puskesmas1');
            $table->unsignedBigInteger('id_data_phbs_detail1');
            $table->integer('jumlah_kk_total')->default(0)->nullable();
            $table->integer('ber_phbs')->default(0);
            $table->decimal('persen_phbs', 5, 2)->default(0);
            $table->enum('kategori_capaian', ['Tinggi','Sedang','Rendah']);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('1data_phbs_result');
    }
};
