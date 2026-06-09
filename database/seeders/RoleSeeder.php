<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Dinkes
        role::create([
            'id_role'       => '1',
            'nama_role'     => 'Dinas Kesehatan',
            'role'          => 'dinkes',
        ]);

        //Puskesmas
        role::create([
            'id_role'       => '2',
            'nama_role'     => 'Puskesmas',
            'role'          => 'puskesmas',
        ]);
    }
}
