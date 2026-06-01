<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\data_phbs;

class Puskesmas extends Model
{
    use HasFactory;
    protected $table = 'puskesmas';

    protected $primaryKey = 'id_puskesmas';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nama_puskesmas',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'email',
        'kepala_puskesmas',
        'latitude',
        'longitude',
        'status_aktif',

        // tambahan peta
        'persentase_capaian',
        'jumlah_kk',
        'status_kategori',
        'geojson_polygon',
        'warna',
    ];

    protected $casts = [
        'geojson_polygon' => 'array',
        'persentase_capaian' => 'float',
        'status_aktif' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function phbs()
    {
        return $this->hasMany(DataPHBS::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function latestPhbs()
    {
        return $this->hasOne(DataPHBS::class, 'id_puskesmas', 'id_puskesmas')
                    ->latestOfMany('id_phbs');
    }

    public function capaianBulanan()
    {
        return $this->hasMany(CapaianBulanan::class,'id_puskesmas','id_puskesmas');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    public function getWarnaByPersentase(): string
    {
        $persen = $this->persentase_capaian;
        if ($persen < 60) return '#e74c3c';   
        if ($persen < 80) return '#f1c40f';   
        return '#27ae60';
    }
    public function getStatusByPersentase(): string
    {
        $persen = $this->persentase_capaian;
        if ($persen < 60) return 'Rendah';
        if ($persen < 80) return 'Sedang';
        return 'Tinggi';
    }

    public function toGeoJsonFeature(): array
    {
        return [
            'type' => 'Feature',

            'geometry' => $this->geojson_polygon,

            'properties' => [
                'id' => $this->id_puskesmas,
                'nama_puskesmas' => $this->nama_puskesmas,
                'kecamatan' => $this->kecamatan,
                'persentase_capaian' => $this->persentase_capaian,
                'jumlah_kk' => $this->jumlah_kk,
                'status_kategori' => $this->getStatusByPersentase(),
                'warna' => $this->getWarnaByPersentase(),
            ],
        ];
    }
}
