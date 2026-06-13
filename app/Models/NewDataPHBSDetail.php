<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel data_phbs_detail
 *
 * Kolom aktual DB:
 *   id_detail_phbs | id_phbs | id_indikator
 *   jumlah_sasaran (nullable) | jumlah_capaian
 *
 * Kolom persentase & kategori_capaian TIDAK ADA di DB.
 * → dihitung via accessor getPersentaseAttribute (virtual, di $appends).
 *
 * Logika sasaran:
 *   - Indikator 1-3: jumlah_sasaran diisi dari input user (tidak NULL)
 *   - Indikator 4-13: jumlah_sasaran disimpan NULL di DB,
 *     accessor otomatis ambil jumlah_kk_total dari relasi header.
 */
class NewDataPHBSDetail extends Model
{
    use HasFactory;

    protected $table      = 'data_phbs_detail';
    protected $primaryKey = 'id_detail_phbs';

    protected $fillable = [
        'id_phbs',
        'id_indikator',
        'jumlah_sasaran',  // nullable untuk indikator 4-13
        'jumlah_capaian',
    ];

    // Virtual accessor
    protected $appends = ['persentase'];

    // ── Accessor ─────────────────────────────────────────────────────────

    /**
     * Hitung persentase capaian.
     * Jika jumlah_sasaran NULL (indikator 4-13), ambil total KK dari header.
     */
    public function getPersentaseAttribute(): float
    {
        $sasaran = $this->jumlah_sasaran;

        if (is_null($sasaran) && $this->header) {
            $sasaran = $this->header->jumlah_kk_total;
        }

        return $sasaran > 0
            ? round(($this->jumlah_capaian / $sasaran) * 100, 2)
            : 0.0;
    }

    // ── Relasi ──────────────────────────────────────────────────────────

    /**
     * Relasi ke header data_phbs.
     * Dibutuhkan oleh getPersentaseAttribute untuk ind 4-13.
     */
    public function header()
    {
        return $this->belongsTo(NewDataPHBS::class, 'id_phbs', 'id_phbs');
    }

    public function indikator()
    {
        return $this->belongsTo(NewIndikator::class, 'id_indikator', 'id_indikator');
    }
}