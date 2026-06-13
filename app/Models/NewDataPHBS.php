<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewDataPHBS extends Model
{
    use HasFactory;

    protected $table      = 'data_phbs';
    protected $primaryKey = 'id_phbs';

    protected $fillable = [
        'id_puskesmas',
        'bulan',
        'tahun',
        'jumlah_kk_lk',   // kolom asli di DB
        'jumlah_kk_pr',   // kolom asli di DB
        'ber_phbs',
        // 'persen_phbs',    // opsional — tambahkan kolom ini via migration jika belum ada
        // 'kategori_phbs',  // opsional
        // 'status_laporan', // opsional
    ];

    // ── Accessor: jumlah_kk_total (virtual, tidak disimpan ke DB) ──────────
    protected $appends = ['jumlah_kk_total'];

    public function getJumlahKkTotalAttribute(): int
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

    // ── Relasi ────────────────────────────────────────────────────────────

    public function puskesmas()
    {
        return $this->belongsTo(NewPuskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function details()
    {
        return $this->hasMany(NewDataPHBSDetail::class, 'id_phbs', 'id_phbs');
    }

    //bulan
    public static function namaBulan($bulan)
    {
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulanList[$bulan] ?? '-';
    }
}