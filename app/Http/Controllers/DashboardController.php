<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //return view('dashboard');
        $stats = [
            'total_puskesmas' => DB::table('puskesmas')->count(),
            'total_laporan'   => DB::table('data_phbs')->where('tahun', date('Y'))->count(),
            'total_kk'        => DB::table('data_phbs')->sum('jumlah_kk_total') ?? 0,
            'rata_phbs'       => round(DB::table('data_phbs')->avg('persen_phbs') ?? 0, 1),
        ];

        return view('dashboard.index', compact('stats'));
    }

    public function dinkes(Request $req)
    {
        if (auth()->users()->role !== 'dinkes') {
            abort(403, 'Halaman ini khusus untuk Dinkes.');
        }

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $tahun    = $req->get('tahun', date('Y'));
        $bulan    = $req->get('bulan', 0);
        $pkmId    = $req->get('puskesmas_id', 0);
        $kategori = $req->get('kategori', '');

        $query = DB::table('data_phbs as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan) {
            $query->where('d.bulan', $bulan);
        }

        if ($pkmId) {
            $query->where('d.id_puskesmas', $pkmId);
        }

        if ($kategori === 'baik') {
            $query->where('d.persen_phbs', '>=', 80);
        }

        if ($kategori === 'cukup') {
            $query->whereBetween('d.persen_phbs', [60, 79.99]);
        }

        if ($kategori === 'kurang') {
            $query->where('d.persen_phbs', '<', 60);
        }

        $laporan = $query
            ->orderBy('p.nama_puskesmas')
            ->orderBy('d.bulan')
            ->get();

        $puskesmasList = DB::table('puskesmas')
            ->orderBy('nama_puskesmas')
            ->get();

        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => round($laporan->avg('persen_phbs') ?? 0, 1),
        ];

        return view('dashboard.dinkes', compact(
            'laporan',
            'puskesmasList',
            'stats',
            'tahun',
            'bulan',
            'pkmId',
            'kategori'
        ))->with('namaBulan', $namaBulan);
    }
}