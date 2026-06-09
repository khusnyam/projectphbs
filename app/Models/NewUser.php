<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\NewRole;
use App\Models\NewPuskesmas;

class NewUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role1',
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

    //relas
    public function role()
    {
        return $this->belongsTo(
            NewRole::class,
            'id_role1',
            'id_role1'
        );
    }

    public function puskesmas()
    {
        return $this->hasOne(
            NewPuskesmas::class,
            'id_user',
            'id_user'
        );
    }
}