<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\data_phbs;

class data_phbs_detail extends Model
{
    protected $table = 'data_phbs_details';

    protected $primaryKey = 'id_detail_phbs';

    protected $fillable = [
    'id_phbs',
    'id_indikator',
    'jumlah_sasaran',
    'jumlah_capaian',
    'persentase',
    'kategori_capaian',
    'keterangan',
    ];

    // RELASI KE DATA PHBS
    public function phbs()
    {
        return $this->belongsTo(
            DataPHBS::class,
            'id_phbs'
        );
    }
}