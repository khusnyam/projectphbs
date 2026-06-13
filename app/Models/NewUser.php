<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\NewRole;
use App\Models\NewPuskesmas;

class NewUser extends Authenticatable
{
    // use Notifiable;

    // protected $table = 'users';

    // protected $primaryKey = 'id_user';

    // protected $fillable = [
    //     'id_role',
    //     'name',
    //     'email',
        use Notifiable;
    //     'status_aktif',
        protected $table = 'users';

        protected $primaryKey = 'id_user';
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'status_aktif'      => 'boolean',
        protected $fillable = [
            'id_role',
            'name',
            'email',
            'password',
            'status_aktif',
        ];
    //         NewRole::class,
    //         'id_role',
    //         'id_role'
    //     );
        protected $hidden = [
            'password',
            'remember_token',
        ];
    //     return $this->hasOne(
    //         NewPuskesmas::class,
    //         'id_user',
    //         'id_user'
    //     );
        protected $casts = [
            'email_verified_at' => 'datetime',
            'status_aktif'      => 'boolean',
            'password'          => 'hashed',
        ];

    public function NewRole()
    {
        return $this->belongsTo(NewRole::class, 'id_role', 'id_role');
    }

    public function NewPuskesmas()
    {
        return $this->hasOne(NewPuskesmas::class, 'id_user', 'id_user');
    }
}


