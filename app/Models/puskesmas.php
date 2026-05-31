<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class puskesmas extends Model
{
    protected $table = 'puskesmas';

    protected $primaryKey = 'id_puskesmas';

    protected $fillable = [
        'nama_puskesmas'
    ];

    public function phbs()
    {
        return $this->hasMany(
            data_phbs::class,
            'id_puskesmas',
            'id_puskesmas'
        );
    }
}