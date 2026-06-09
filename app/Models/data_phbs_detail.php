<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Models\data_phbs;

// class NewDataPHBSDetail extends Model
// {
//     protected $table = 'data_phbs_details';

//     protected $primaryKey = 'id_detail_phbs';

//     protected $fillable = [
//     'id_phbs',
//     'id_indikator',
//     'jumlah_sasaran',
//     'jumlah_capaian',
//     'persentase',
//     'kategori_capaian',
//     'keterangan',
//     ];

//     protected $casts = [
//         'jumlah_sasaran' => 'integer',
//         'jumlah_capaian' => 'integer',
//         'persentase'     => 'integer',
//     ];

//     // RELASI KE DATA PHBS
//     public function phbs()
//     {
//         return $this->belongsTo(
//             data_phbs::class,
//             'id_phbs'
//         );
//     }
// }