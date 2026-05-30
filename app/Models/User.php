<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory, Notifiable;
    
    protected $table      = 'users';
    protected $primaryKey = 'id_users';

    protected $fillable = [
        'nama_user',
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