<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Models\NewDataPHBSDetail;

class NewIndikator extends Model
{
    //
    protected $table = '1indikator_phbs';

    protected $primaryKey = 'id_indikator1';

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
            'id_indikator1',
            'id_indikator1'
        );
    }
}
