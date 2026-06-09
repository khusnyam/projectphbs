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

    // protected $primaryKey = 'id_user1';

    // protected $fillable = [
    //     'id_role1',
    //     'name',
    //     'email',
        use Notifiable;
    //     'status_aktif',
        protected $table = 'users';

        protected $primaryKey = 'id_user1';
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'status_aktif'      => 'boolean',
        protected $fillable = [
            'id_role1',
            'name',
            'email',
            'password',
            'status_aktif',
        ];
    //         NewRole::class,
    //         'id_role1',
    //         'id_role1'
    //     );
        protected $hidden = [
            'password',
            'remember_token',
        ];
    //     return $this->hasOne(
    //         NewPuskesmas::class,
    //         'id_user1',
    //         'id_user1'
    //     );
        protected $casts = [
            'email_verified_at' => 'datetime',
            'status_aktif'      => 'boolean',
            'password'          => 'hashed',
        ];
}