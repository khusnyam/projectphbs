<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataPHBS extends Model
{
    protected $table = 'data_phbs';
    protected $primaryKey = 'id_phbs';
    public $incrementing = true;
    protected $keyType = 'int';

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

    public function puskesmas()
    {
        return $this->belongsTo(
            puskesmas::class,
            'id_puskesmas',
            'id_puskesmas'
        );
    }

    public function details()
    {
        return $this->hasMany(
            data_phbs_detail::class,
            'id_phbs',
            'id_phbs'
        );
    }    
}
