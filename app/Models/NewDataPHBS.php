<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewDataPHBS extends Model
{
    use HasFactory;

    protected $table = 'data_phbs';

    protected $primaryKey = 'id_phbs';

    protected $fillable = [
        'id_puskesmas',
        'bulan',
        'tahun',
        'jumlah_kk_lk',
        'jumlah_kk_pr',
        'ber_phbs',
    ];

    protected $casts = [
        'jumlah_kk_lk'   => 'integer',
        'jumlah_kk_pr'   => 'integer',
        'ber_phbs'        => 'integer',
        'bulan'           => 'integer',
        'tahun'           => 'integer',
    ];

    //json
    protected $appends = ['jumlah_kk_total'];

    //accessor
    public function getJumlahKkTotalAttribute()
    {
        return ($this->jumlah_kk_lk ?? 0) + ($this->jumlah_kk_pr ?? 0);
    }

    /** Hanya laporan yang sudah dikirim ke Dinkes */
    public function scopeTerkirim($query)
    {
        return $query->where('status_laporan', 'terkirim');
    }
 
    /** Hanya laporan masih berstatus draft */
    public function scopeDraft($query)
    {
        return $query->where('status_laporan', 'draft');
    }
 
    /** Filter berdasarkan tahun */
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }
 
    /** Filter berdasarkan bulan (nullable — skip jika null) */
    public function scopeBulan($query, ?int $bulan)
    {
        return $bulan ? $query->where('bulan', $bulan) : $query;
    }

    //relasi
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function details()
    {
        return $this->hasMany(NewDataPHBSDetail::class, 'id_phbs', 'id_phbs');
    }

    //fungsi untuk menampilkan nama bulan
    public static function namaBulan(int $n): string
    {
        return [
            1  => 'Januari',   2  => 'Februari',  3  => 'Maret',
            4  => 'April',     5  => 'Mei',        6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ][$n] ?? '-';
    }
}