<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel indikator_phbs
 *
 * Kolom aktual DB:
 *   id_indikator | kode_indikator | nama_indikator | deskripsi | status_aktif
 *
 * TIDAK ADA kolom target_nasional di DB → dihapus dari fillable.
 */
class NewIndikator extends Model
{
    use HasFactory;

    protected $table      = 'indikator_phbs';
    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'kode_indikator',
        'nama_indikator',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    // ── Relasi ──────────────────────────────────────────────────────────

    public function detailPhbs()
    {
        return $this->hasMany(NewDataPHBSDetail::class, 'id_indikator', 'id_indikator');
    }
}