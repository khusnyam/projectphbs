<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;

class NewRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Dinkes
        role::create([
            'id_role1'       => '1',
            'nama_role'     => 'Dinas Kesehatan',
            'role'          => 'dinkes',
        ]);

        //Puskesmas
        role::create([
            'id_role1'       => '2',
            'nama_role'     => 'Puskesmas',
            'role'          => 'puskesmas',
        ]);
    }
}
