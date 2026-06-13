<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPhbs extends Model
{
    use HasFactory;

    protected $table      = 'data_phbs';
    protected $primaryKey = 'id_phbs';

    protected $fillable = [
        'id_puskesmas',
        'bulan',
        'tahun',
        'jumlah_kk_lk',
        'jumlah_kk_pr',
        'ber_phbs',
    ];

    protected $appends = ['jumlah_kk_total', 'persen_phbs', 'kategori_phbs'];

    public function getJumlahKkTotalAttribute()
    {
        return ($this->jumlah_kk_lk ?? 0) + ($this->jumlah_kk_pr ?? 0);
    }

    public function getPersenPhbsAttribute()
    {
        $total = $this->jumlah_kk_total;
        return $total > 0 ? round(($this->ber_phbs / $total) * 100, 1) : 0;
    }

    public function getKategoriPhbsAttribute()
    {
        $pct = $this->persen_phbs;
        if ($pct >= 80) return 'Baik';
        if ($pct >= 60) return 'Cukup';
        return 'Kurang';
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function details()
    {
        return $this->hasMany(DataPhbsDetail::class, 'id_phbs', 'id_phbs');
    }
}