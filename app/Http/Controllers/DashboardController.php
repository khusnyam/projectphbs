<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_puskesmas' => DB::table('puskesmas')->count(),
            'total_laporan'   => DB::table('data_phbs')->whereYear('created_at', date('Y'))->count(),
            'total_kk'        => DB::table('data_phbs')->sum('jumlah_kk') ?? 0,
            'rata_phbs'       => round(DB::table('data_phbs')->avg('total_indikator_phbs') ?? 0, 1),
        ];

        return view('dashboard.index', compact('stats'));
    }
}