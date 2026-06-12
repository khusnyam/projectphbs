<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorPhbs extends Model
{
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

    public function details()
    {
        return $this->hasMany(DataPhbsDetail::class, 'id_indikator', 'id_indikator');
    }
}