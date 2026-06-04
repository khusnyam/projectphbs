<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class data_phbs extends Model
{
    protected $table = 'data_phbs';
    protected $primaryKey = 'id_phbs';
    public $incrementing = true;
    protected $keyType = 'int';

    // 3. Array $fillable untuk mass-assignment
    protected $fillable = [
        'id_puskesmas',
        'tahun',
        'bulan',
        'jumlah_kk_l',
        'jumlah_kk_p',
        'jumlah_kk_total',
        'ber_phbs',
        'persen_phbs',
        'status_laporan',
        'user_penginput',
        'kategori_phbs'
        ];

    public function scopeTerkirim($query)
    {
        return $query->where('status_laporan', 'terkirim');
    }
 
    public function scopeDraft($query)
    {
        return $query->where('status_laporan', 'draft');
    }
 
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public static function namaBulan(int $bulan): string
    {
        return [
            1  => 'Januari',   2  => 'Februari',  3  => 'Maret',
            4  => 'April',     5  => 'Mei',        6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',    9  => 'September',
            10 => 'Oktober',   11 => 'November',   12 => 'Desember',
        ][$bulan] ?? '-';
    }

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
