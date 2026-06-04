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
            'deskripsi_role' => 'Dinas Kesehatan Kabupaten Sleman',
            'role'          => 'dinkes',
        ]);

        //Puskesmas
        role::create([
            'id_role'       => '2',
            'nama_role'     => 'Puskesmas',
            'deskripsi_role' => 'Puskesmas di Kabupaten Sleman',
            'role'          => 'puskesmas',
        ]);
    }
}
