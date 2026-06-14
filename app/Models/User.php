<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\NewRole;
use App\Models\NewPuskesmas;

class User extends Authenticatable
{
        use Notifiable;
        protected $table = 'users';
        protected $primaryKey = 'id_user';
        protected $fillable = [
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
            'id_role'           => 'integer',
            'email_verified_at' => 'datetime',
            'status_aktif'      => 'boolean',
            'password'          => 'hashed',
        ];

    //relasi
    public function role()
    {
        return $this->belongsTo(NewRole::class, 'id_role', 'id_role');
    }

    public function puskesmas()
    {
        return $this->hasOne(NewPuskesmas::class, 'id_user', 'id_user');
    }

    //helper
    public function isDinkes()
{
    return (int) $this->id_role === 1;
}

public function isPuskesmas()
{
    return (int) $this->id_role === 2;
}
}


