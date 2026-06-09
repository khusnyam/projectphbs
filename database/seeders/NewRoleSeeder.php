<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewRole;

class NewRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Dinkes
        NewRole::create([
            'id_role'       => '1',
            'nama_role'     => 'Dinas Kesehatan',
            'role'          => 'dinkes',
        ]);

        //Puskesmas
        NewRole::create([
            'id_role'       => '2',
            'nama_role'     => 'Puskesmas',
            'role'          => 'puskesmas',
        ]);
    }
}
