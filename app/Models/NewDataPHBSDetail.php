<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use App\Models\NewIndikator;
// use App\Models\Puskesmas;

class NewDataPHBSDetail extends Model
{
    //
    protected $table = '1data_phbs_details';

    protected $primaryKey = 'id_detail_phbs1';

    protected $fillable = [
        'id_puskesmas1',
        'id_indikator1',
        'bulan',
        'tahun',
        'jumlah_kk_lk',
        'jumlah_kk_pr',
        'jumlah_sasaran',
        'jumlah_capaian',
        'status_laporan',
    ];

    // relasi
    public function indikator()
    {
        return $this->belongsTo(
            NewIndikator::class,
            'id_indikator1',
            'id_indikator1'
        );
    }

    public function puskesmas()
    {
        return $this->belongsTo(
            NewPuskesmas::class,
            'id_puskesmas1',
            'id_puskesmas1'
        );
    }

    //accessor
    protected $appends = ['jumlah_kk_total','persentase']; //kirim ke json

    public function getJumlahKkTotalAttribute()
    {
        return $this->jumlah_kk_lk + $this->jumlah_kk_pr;
    }

    public function getPersentaseAttribute()
    {
        return $this->jumlah_sasaran > 0
            ? round(($this->jumlah_capaian / $this->jumlah_sasaran) * 100, 2)
            : 0;
    }

    public function getJumlahSasaranAttribute($value)
    {
        if (in_array($this->id_indikator1, [1,2,3])) {
        return $value;
        }

        return $this->jumlah_kk_lk + $this->jumlah_kk_pr;
    }
}
