<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewDataPHBS extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel secara eksplisit karena tidak mengikuti konvensi Laravel
    protected $table = 'data_phbs';

    // 2. Definisikan custom Primary Key Anda
    protected $primaryKey = 'id_phbs';

    // 3. Daftarkan kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'id_puskesmas',
        'bulan',
        'tahun',
        'jumlah_kk_lk',
        'jumlah_kk_pr',
        'ber_phbs',
    ];

    // 4. Tambahkan append untuk otomatis menghitung total KK saat diconvert ke JSON/Array
    protected $appends = ['jumlah_kk_total'];

    /**
     * Accessor untuk mendapatkan total jumlah KK (Laki-laki + Perempuan)
     */
    public function getJumlahKkTotalAttribute()
    {
        return ($this->jumlah_kk_lk ?? 0) + ($this->jumlah_kk_pr ?? 0);
    }

    /**
     * Jika Anda sudah membuat model Puskesmas, 
     * Anda bisa mengaktifkan relasi ini nanti.
     */
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }
}