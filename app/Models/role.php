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


<<<<<<< HEAD
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
=======
>>>>>>> a0aff25b32e0e6d800417eb10bc7249656eea7fd
