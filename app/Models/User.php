<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'id_puskesmas',
        'no_hp',
        'status_aktif',
    ];

    protected $hidden = ['password'];
}