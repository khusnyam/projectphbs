<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\NewRole;
use App\Models\NewPuskesmas;

class User extends Authenticatable
{
    use Notifiable;

<<<<<<< HEAD
    protected $table      = 'users';
=======
    protected $table = 'users';

>>>>>>> a0aff25b32e0e6d800417eb10bc7249656eea7fd
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role',
        'name',
        'email',
        'password',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status_aktif'      => 'boolean',
        'password'          => 'hashed',
    ];

<<<<<<< HEAD
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
=======
    //relas
    public function role()
    {
        return $this->belongsTo(
            NewRole::class,
            'id_role',
            'id_role'
        );
>>>>>>> a0aff25b32e0e6d800417eb10bc7249656eea7fd
    }

    public function puskesmas()
    {
<<<<<<< HEAD
        return $this->hasOne(Puskesmas::class, 'id_user', 'id_user');
=======
        return $this->hasOne(
            NewPuskesmas::class,
            'id_user',
            'id_user'
        );
>>>>>>> a0aff25b32e0e6d800417eb10bc7249656eea7fd
    }
}