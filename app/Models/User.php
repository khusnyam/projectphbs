<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use App\Models\NewRole;
// use App\Models\NewPuskesmas;

// class User extends Authenticatable
// {
//     use Notifiable;

//     protected $table      = 'users';
//     protected $primaryKey = 'id_user';

//     protected $fillable = [
//         'id_role1',
//         'name',
//         'email',
//         'password',
//         'status_aktif',
//     ];

//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'status_aktif'      => 'boolean',
//         'password'          => 'hashed',
//     ];

//     public function role()
//     {
//         return $this->belongsTo(Role::class, 'id_role', 'id_role');
//     }

//     public function puskesmas()
//     {
//         return $this->hasOne(Puskesmas::class, 'id_user', 'id_user');
//     }
// }