<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianBulanan extends Model
{
    use HasFactory;

    protected $table = 'capaian_bulanan';

    protected $primaryKey = 'id_capaian';

    protected $fillable = [
        'id_puskesmas1',
        'bulan',
        'tahun',
        'persentase_capaian',
        'jumlah_sasaran',
        'jumlah_tercapai',
        'status_kategori',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public static function getStatusByPersentase(float $pct): string
    {
        if ($pct < 60) return 'Rendah';
        if ($pct < 80) return 'Sedang';
        return 'Tinggi';
    }

    protected $casts = [
        'bulan'              => 'integer',
        'tahun'              => 'integer',
        'persentase_capaian' => 'float',
        'jumlah_sasaran'     => 'integer',
        'jumlah_tercapai'    => 'integer',
    ];
    
    public function puskesmas()
    {
        return $this->belongsTo(
            Puskesmas::class,
            'id_puskesmas1',
            'id_puskesmas1'
        );
    }
}