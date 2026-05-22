<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class data_phbs_detail extends Model
{
    //data fillable
    protected $fillable = ['id_detail_phbs','id_phbs','id_indikator','jumlah_sasaran','jumlah_capaian','persentase','kategori_capaian','keterangan'];
}
