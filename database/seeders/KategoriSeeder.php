<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = DB::table('data_phbs')->get();

        foreach ($data as $row) {

            $kategori = 'Kurang';

            if ($row->persen_phbs >= 80) {
                $kategori = 'Baik';
            } elseif ($row->persen_phbs >= 60) {
                $kategori = 'Cukup';
            }

            DB::table('data_phbs')
                ->where('id', $row->id)
                ->update([
                    'kategori_phbs' => $kategori
                ]);
        }
    }
}