<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = ['nama_kecamatan', 'geojson_polygon'];
    
    protected $casts = [
        'geojson_polygon' => 'array',
    ];
}
