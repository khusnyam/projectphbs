<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewPuskesmas extends Model
{
    protected $table = '1puskesmas';

    protected $primaryKey = 'id_puskesmas1';

    protected $fillable = [
        'id_user1',
        'id_kecamatan1',
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
            'id_user1',
            'id_user1'
        );
    }

    public function kecamatan()
    {
        return $this->belongsTo(
            NewKecamatan::class,
            'id_kecamatan1',
            'id_kecamatan1'
        );
    }

    public function dataPhbsDetails()
    {
        return $this->hasMany(
            NewDataPHBSDetail::class,
            'id_puskesmas1',
            'id_puskesmas1'
        );
    }
}