<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewUser;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // Dinkes
            [
                'name' => 'Admin Dinas Kesehatan Sleman',
                'email' => 'dkk.sleman@dinkes.com',
                'password' => Hash::make('dkk123'),
                'id_role' => 1,
                'status_aktif' => true,
            ],

            // Puskesmas
            ['name'=>'Puskesmas Gamping I','email'=>'gamping1@puskesmas.go.id','password'=>Hash::make('gamping1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Gamping II','email'=>'gamping2@puskesmas.go.id','password'=>Hash::make('gamping2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Godean I','email'=>'godean1@puskesmas.go.id','password'=>Hash::make('godean1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Godean II','email'=>'godean2@puskesmas.go.id','password'=>Hash::make('godean2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Moyudan','email'=>'moyudan@puskesmas.go.id','password'=>Hash::make('moyudan'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Minggir','email'=>'minggir@puskesmas.go.id','password'=>Hash::make('minggir'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Seyegan','email'=>'seyegan@puskesmas.go.id','password'=>Hash::make('seyegan'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Mlati I','email'=>'mlati1@puskesmas.go.id','password'=>Hash::make('mlati1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Mlati II','email'=>'mlati2@puskesmas.go.id','password'=>Hash::make('mlati2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Depok I','email'=>'depok1@puskesmas.go.id','password'=>Hash::make('depok1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Depok II','email'=>'depok2@puskesmas.go.id','password'=>Hash::make('depok2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Depok III','email'=>'depok3@puskesmas.go.id','password'=>Hash::make('depok3'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Berbah','email'=>'berbah@puskesmas.go.id','password'=>Hash::make('berbah'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Prambanan','email'=>'prambanan@puskesmas.go.id','password'=>Hash::make('prambanan'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Kalasan','email'=>'kalasan@puskesmas.go.id','password'=>Hash::make('kalasan'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Ngemplak I','email'=>'ngemplak1@puskesmas.go.id','password'=>Hash::make('ngemplak1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Ngemplak II','email'=>'ngemplak2@puskesmas.go.id','password'=>Hash::make('ngemplak2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Ngaglik I','email'=>'ngaglik1@puskesmas.go.id','password'=>Hash::make('ngaglik1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Ngaglik II','email'=>'ngaglik2@puskesmas.go.id','password'=>Hash::make('ngaglik2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Sleman','email'=>'sleman@puskesmas.go.id','password'=>Hash::make('sleman'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Tempel I','email'=>'tempel1@puskesmas.go.id','password'=>Hash::make('tempel1'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Tempel II','email'=>'tempel2@puskesmas.go.id','password'=>Hash::make('tempel2'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Turi','email'=>'turi@puskesmas.go.id','password'=>Hash::make('turi'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Pakem','email'=>'pakem@puskesmas.go.id','password'=>Hash::make('pakem'),'id_role'=>2,'status_aktif'=>true],
            ['name'=>'Puskesmas Cangkringan','email'=>'cangkringan@puskesmas.go.id','password'=>Hash::make('cangkringan'),'id_role'=>2,'status_aktif'=>true],
        ];

        foreach ($users as $user) {
            NewUser::create($user);
        }
    }
}