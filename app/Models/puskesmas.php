<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class puskesmas extends Model
{
    use HasFactory;
    //
    protected $table = 'puskesmas';
    protected $primaryKey = 'id_puskesmas';
    protected $fillable = [
        'nama_puskesmas',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'email',
        'kepala_puskesmas',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'status_aktif' => 'boolean', // Mengubah 1/0 di database menjadi true/false di program
    ];
}
