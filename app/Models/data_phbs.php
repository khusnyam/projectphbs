<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPhbs extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel secara spesifik (sesuaikan dengan nama tabel di database-mu)
    protected $table = 'laporan_phbs';

    // 2. ⚠️ WAJIB: Beritahu Laravel kalau primary key kamu kustom, bukan 'id'
    protected $primaryKey = 'id_phbs';

    // 3. Array $fillable untuk mass-assignment
    protected $fillable = [
        'id_puskesmas',
        'bulan',
        'tahun',
        'jumlah_kk',
        'persalinan_nakes',
        'asi_eksklusif',
        'timbang_balita',
        'air_bersih',
        'cuci_tangan',
        'jamban_sehat',
        'tidak_merokok',
        'aktivitas_fisik',
        'makan_buah_sayur',
        'pengelolaan_air_minum',
        'pengelolaan_limbah',
        'buang_sampah',
        'pemberantasan_jentik',
        'total_indikator_phbs',
        'kategori_phbs',
        'user_penginput',
    ];

    // 🤝 TAMBAHKAN FUNGSI RELASI INI
    public function puskesmas(): BelongsTo
    {
        // Parameter: (NamaModelTarget, 'kolom_foreign_key_di_tabel_ini', 'kolom_primary_key_di_tabel_target')
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }
}
