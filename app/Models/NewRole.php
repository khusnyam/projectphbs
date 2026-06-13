<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewRole extends Model
{
    //
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'nama_role',
        'role'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(NewUser::class, 'id_role', 'id_role');
    }
}


