<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewRole extends Model
{
    //
    protected $table = '1roles';
    protected $primaryKey = 'id_role1';
    protected $fillable = [
        'nama_role',
        'role'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_role1', 'id_role1');
    }
}


