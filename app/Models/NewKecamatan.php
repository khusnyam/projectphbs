<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewKecamatan extends Model
{
    protected $table = 'kecamatans';

    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'geojson_polygon',
        'warna',
    ];

    protected $casts = [
        'geojson_polygon' => 'array',
    ];

    public function puskesmas(): HasMany
    {
        return $this->hasMany(
            NewPuskesmas::class,
            'id_kecamatan',
            'id_kecamatan'
        );
    }
}