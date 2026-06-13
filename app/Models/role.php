<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;

// class role extends Model
// {
//     //
//     protected $table = 'roles';
//     protected $primaryKey = 'id_role';
//     protected $fillable = [
//         'nama_role',
//         'deskripsi_role',
//         'role'
//     ];

//     public function users(): HasMany
//     {
//         return $this->hasMany(User::class, 'id_role', 'id_role');
//     }
// }


class Role extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
        'role',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}