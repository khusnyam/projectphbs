<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User di-import
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Demo untuk Dinkes
        User::create([
            'name'     => 'Admin Dinas Kesehatan Sleman',
            'email'    => 'dkk.sleman@dinkes.com',
            'password' => Hash::make('dkk123'), // Otomatis enkripsi agar bisa login
            'id_role'  => 1,
            'status_aktif' => true,
        ]);

        // 2. Akun Demo untuk Puskesmas
        User::create(['name'=>'Puskesmas Gamping I','email'=>'gamping1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>1,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Gamping II','email'=>'gamping2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>2,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Godean I','email'=>'godean1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>3,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Godean II','email'=>'godean2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>4,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Moyudan','email'=>'moyudan@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>5,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Minggir','email'=>'minggir@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>6,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Seyegan','email'=>'seyegan@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>7,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Mlati I','email'=>'mlati1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>8,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Mlati II','email'=>'mlati2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>9,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Depok I','email'=>'depok1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>10,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Depok II','email'=>'depok2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>11,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Depok III','email'=>'depok3@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>12,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Berbah','email'=>'berbah@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>13,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Prambanan','email'=>'prambanan@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>14,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Kalasan','email'=>'kalasan@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>15,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Ngemplak I','email'=>'ngemplak1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>16,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Ngemplak II','email'=>'ngemplak2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>17,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Ngaglik I','email'=>'ngaglik1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>18,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Ngaglik II','email'=>'ngaglik2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>19,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Sleman','email'=>'sleman@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>20,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Tempel I','email'=>'tempel1@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>21,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Tempel II','email'=>'tempel2@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>22,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Turi','email'=>'turi@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>23,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Pakem','email'=>'pakem@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>24,'status_aktif'=>true]);
        User::create(['name'=>'Puskesmas Cangkringan','email'=>'cangkringan@puskesmas.go.id','password'=>Hash::make('pkm123'),'id_role'=>2,'id_puskesmas'=>25,'status_aktif'=>true]);

    }
}

