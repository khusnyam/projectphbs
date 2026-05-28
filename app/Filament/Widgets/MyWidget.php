<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class MyWidget extends Widget
{
    protected string $view = 'filament.widgets.my-widget';
    
}

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\LaporanPhbs; // Panggil model database kamu

class RaporPhbsChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Capaian PHBS Per Wilayah';

    protected function getData(): array
    {
        // Logika: Ambil data dari database kamu
        // Contoh sederhana: kita hitung jumlah laporan sehat vs tidak sehat
        $sehat = LaporanPhbs::where('status', 'Sehat')->count();
        $tidakSehat = LaporanPhbs::where('status', 'Tidak Sehat')->count();

        return [
            // 1. Mengisi angka batang grafiknya
            'datasets' => [
                [
                    'label' => 'Jumlah Rumah Tangga',
                    'data' => [$sehat, $tidakSehat], // Angka dari database masuk ke sini
                    'backgroundColor' => ['#11caa0', '#ff4d4d'], // Warna hijau dan merah
                ],
            ],
            // 2. Mengisi tulisan di bawah grafiknya
            'labels' => ['Memenuhi Syarat PHBS', 'Belum Memenuhi Syarat'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Jenis grafiknya (bisa diganti 'line' atau 'pie')
    }
}