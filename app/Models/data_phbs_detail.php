<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Models\data_phbs;

// class DataPhbsDetail extends Model
// {
//     protected $table      = 'data_phbs_detail';
//     protected $primaryKey = 'id_detail_phbs';

//     protected $fillable = [
//         'id_phbs',
//         'id_indikator',
//         'jumlah_sasaran',
//         'jumlah_capaian',
//     ];

//     protected $appends = ['persentase'];

//     public function getPersentaseAttribute()
//     {
//         $sasaran = $this->jumlah_sasaran;
//         if (is_null($sasaran) && $this->header) {
//             $sasaran = $this->header->jumlah_kk_total;
//         }
//         return $sasaran > 0
//             ? round(($this->jumlah_capaian / $sasaran) * 100, 2)
//             : 0;
//     }

//     public function header()
//     {
//         return $this->belongsTo(DataPhbs::class, 'id_phbs', 'id_phbs');
//     }

//     public function indikator()
//     {
//         return $this->belongsTo(IndikatorPhbs::class, 'id_indikator', 'id_indikator');
//     }
// }
