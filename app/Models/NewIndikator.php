<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Models\NewDataPHBSDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewIndikator extends Model
{
    //
    protected $table = 'indikator_phbs';

    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'kode_indikator',
        'nama_indikator',
        'kategori_indikator',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    //relasi
    public function detailPhbs()
    {
        return $this->hasMany(
            NewDataPHBSDetail::class,
            'id_indikator',
            'id_indikator'
        );
    }
}
