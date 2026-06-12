<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table      = 'kecamatans';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'geojson_polygon',
        'warna',
    ];

    protected $casts = [
        'geojson_polygon' => 'array',
    ];

    public function puskesmas()
    {
        return $this->hasMany(Puskesmas::class, 'id_kecamatan', 'id_kecamatan');
    }
}