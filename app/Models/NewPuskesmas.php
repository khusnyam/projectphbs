<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewPuskesmas extends Model
{
    protected $table = 'puskesmas';

    protected $primaryKey = 'id_puskesmas';

    protected $fillable = [
        'id_user',
        'id_kecamatan',
        'nama_puskesmas',
        'alamat',
        'email',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    //relasi
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function kecamatan()
    {
        return $this->belongsTo(
            NewKecamatan::class,
            'id_kecamatan',
            'id_kecamatan'
        );
    }

    // public function dataPhbsDetails()
    // {
    //     return $this->hasManyThrough(
    //         NewDataPHBSDetail::class,
    //         NewDataPHBS::class,
    //         'id_puskesmas',
    //         'id_phbs',
    //         'id_puskesmas',
    //         'id_phbs'
    //     );
    // }

    public function dataPhbs(): HasMany
    {
        return $this->hasMany(NewDataPHBS::class, 'id_puskesmas', 'id_puskesmas');
    }
 
    public function dataPhbsDetails(): HasMany
    {
        return $this->hasMany(NewDataPHBSDetail::class, 'id_puskesmas', 'id_puskesmas');
    }
}