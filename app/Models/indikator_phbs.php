<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;

// class indikator_phbs extends Model
// {
//     use HasFactory;

//     // 1. Tentukan nama tabel di database
//     protected $table = 'indikator_phbs';

//     // 2. ⚠️ WAJIB: Beritahu Laravel kalau primary key kamu adalah id_indikator
//     protected $primaryKey = 'id_indikator';

//     // 3. Array $fillable untuk kolom yang boleh diisi mass-assignment
//     protected $fillable = [
//         'kode_indikator',
//         'nama_indikator',
//         'kategori_indikator',
//         'deskripsi',
//         'target_nasional',
//         'status_aktif',
//     ];

//     // 4. ✨ BONUS TIPS: Mengubah tipe data saat dibaca di Laravel/Filament
//     protected $casts = [
//         'status_aktif' => 'boolean', // Mengubah 1/0 di database menjadi true/false di program
//         'target_nasional' => 'integer'
//     ];

//     public function scopeAktif($query)
//     {
//         return $query->where('status_aktif', true);
//     }
 
//     public function details(): HasMany
//     {
//         return $this->hasMany(data_phbs_detail::class, 'id_indikator', 'id_indikator');
//     }
// }