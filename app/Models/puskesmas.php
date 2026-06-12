<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    protected $table      = 'puskesmas';
    protected $primaryKey = 'id_puskesmas';

    protected $fillable = [
        'id_user',
        'id_kecamatan',
        'nama_puskesmas',
        'alamat',
        'email',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function dataPhbs()
    {
        return $this->hasMany(DataPhbs::class, 'id_puskesmas', 'id_puskesmas');
    }
}