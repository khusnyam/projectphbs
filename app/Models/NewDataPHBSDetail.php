<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewDataPHBSDetail extends Model
{
    use HasFactory;

    protected $table = 'data_phbs_detail';

    protected $primaryKey = 'id_detail_phbs';

    protected $fillable = [
        'id_phbs',
        'id_indikator',
        'jumlah_sasaran',
        'jumlah_capaian',
    ];

   //relasi ke header (data_phbs), indikator
    public function header()
    {
        return $this->belongsTo(
            NewDataPHBS::class, 
            'id_phbs', 
            'id_phbs');
    }

    public function indikator()
    {
        return $this->belongsTo(
            NewIndikator::class,
            'id_indikator',
            'id_indikator'
        );
    }

    public function puskesmas()
    {
        return $this->belongsTo(
            NewPuskesmas::class,
            'id_puskesmas',
            'id_puskesmas'
        );
    }

    //accessor
    protected $appends = ['persentase'];

    public function getPersentaseAttribute()
    {
        $sasaran = $this->jumlah_sasaran;

        // JIKA jumlah_sasaran bernilai NULL di database (Kasus Indikator 4-13),
        // MAKA otomatis ambil nilai dari total KK yang ada di tabel header via relasi
        if (is_null($sasaran) && $this->header) {
            $sasaran = $this->header->jumlah_kk_total;
        }

        // Jalankan rumus persentase dengan aman (hindari pembagian dengan angka 0)
        return $sasaran > 0
            ? round(($this->jumlah_capaian / $sasaran) * 100, 2)
            : 0;
    }

    // public function getPersentaseAttribute() //persentase tiap indikator
    // {
    //     return $this->jumlah_sasaran > 0
    //         ? round(($this->jumlah_capaian / $this->jumlah_sasaran) * 100, 2)
    //         : 0;
    // }

    public function getJumlahSasaranAttribute($value)
    {
        if (in_array($this->id_indikator, [1,2,3])) {
        return $value;
        }

        return $this->jumlah_kk_lk + $this->jumlah_kk_pr;
    }
}
