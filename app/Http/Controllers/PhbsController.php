<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use app\Models\puskesmas;
use App\Models\NewDataPHBSDetail;
use Illuminate\Support\Facades\Auth;

class PhbsController extends Controller
{
    // halaman dashboard & req data grafik
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        
        // dd(Auth::user()->toArray());

        dd(
    Auth::user()->id_user,
    \App\Models\NewPuskesmas::where('id_user', Auth::user()->id_user)->first()
);


        // $idPuskesmas = Auth::user()->id_puskesmas1;
        // $idPuskesmas = Auth::user()->puskesmas->id_puskesmas1;
        $user = Auth::user();
        $puskesmas = $user->puskesmas;

        if (!$puskesmas) {
            abort(403, 'Akun ini belum terhubung dengan puskesmas.');
        }

        $idPuskesmas = $puskesmas->id_puskesmas1;

        if (!$idPuskesmas) {
        abort(403, 'Akun ini belum terhubung dengan puskesmas.');
    }

        $data = NewDataPHBSDetail::with(['puskesmas','indikator'])
            ->where('id_puskesmas1', $idPuskesmas->id_puskesmas1)
            ->where('tahun', $tahun)
            ->orderByRaw("FIELD(bulan,
                'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

       

        $totalKK = $data->sum('jumlah_kk_total');
        $totalCapaian = $data->sum('jumlah_capaian');

        $pct = $totalKK > 0
            ? round(($totalCapaian / $totalKK) * 100, 1)
            : 0;

        $datadashboard = [
            'nama_puskesmas' => $idPuskesmas->nama_puskesmas,
            'total_kk'       => $totalKK,
            'ber_phbs'       => $totalCapaian,
            'pct'            => $pct,
            'months'         => $data,
        ];

        if ($request->ajax()) {
            return response()->json($datadashboard);
        }

        return view('phbs.dashboard', compact('datadashboard'));
    }
    // public function index(Request $request)
    // {
    //     $tahun = $request->tahun ?? date('Y');
    //     // Gate::authorize('akses-puskesmas');

    //     // $data = 
    //     $data = DB::table('data_phbs')
    //         ->join('puskesmas', 'data_phbs.id_puskesmas', '=', 'puskesmas.id_puskesmas')
    //         ->where('tahun', $tahun)
    //         ->orderBy('puskesmas.nama_puskesmas', 'asc')
    //         ->orderByRaw("FIELD(bulan,
    //             'Januari','Februari','Maret','April','Mei','Juni',
    //             'Juli','Agustus','September','Oktober','November','Desember')")
    //         ->select('data_phbs.*', 'puskesmas.nama_puskesmas')
    //         ->get();

    //     $data = NewDataPHBSDetail::all();

    //     // Susun format $raw yang dibutuhkan oleh JavaScript di blade
    //     // Format: [ 'NAMA_PUSKESMAS' => [ total_kk, ber_phbs, pct, months[] ] ]
    //     $datadashboard = [];
    //     // foreach ($data as $row) {
    //     //     $row->jumlah_kk_total = (int) $row->jumlah_kk_total;
    //     //     $row->ber_phbs = (int) $row->ber_phbs;
    //     // }

    //     foreach ($data as $rowdashboard) {
    //         $pk = $rowdashboard->nama_puskesmas;

    //         if (!isset($datadashboard[$pk])) {
    //             $datadashboard[$pk] = [
    //                 'total_kk' => 0,
    //                 'ber_phbs' => 0,
    //                 'pct'      => 0,
    //                 'months'   => [],
    //             ];
    //         }

    //         $datadashboard[$pk]['total_kk'] += $rowdashboard->jumlah_kk_total;
    //         $datadashboard[$pk]['ber_phbs'] += $rowdashboard->ber_phbs;
    //         $datadashboard[$pk]['months'][]  = [
    //             'bulan'    => $rowdashboard->bulan,
    //             'kk'       => (int) $rowdashboard->jumlah_kk_total,
    //             'ber_phbs' => (int) $rowdashboard->ber_phbs,
    //         ];
    //     }

    //     // Hitung persentase per puskesmas
    //     foreach ($datadashboard as $pk => &$d) {
    //         $d['pct'] = $d['total_kk'] > 0
    //             ? round($d['ber_phbs'] / $d['total_kk'] * 100, 1)
    //             : 0;
    //     }

    //     if ($request->ajax()) {
    //     return response()->json($raw);
    //     }

    //     // Kirim $raw ke blade → dipakai: const RAW = {!! json_encode($raw) !!};
    //     return view('phbs.dashboard', compact('raw'));
    // }

    // INI GAJADI DIPAKEEEE --> PAKENYA PUNYA OLIV
    // simpan input manual dari puskesmas
    public function simpan(Request $request)
    {
        Gate::authorize('akses-puskesmas');

        $request->validate([
            'id_puskesmas' => $request->id_puskesmas ?? 'required|exists:puskesmas,id_puskesmas',
            'bulan'     => $request->bulan ?? 'required|string|max:20',
            'tahun'     => $request->tahun ?? 'required|integer|min:2000|max:2100',
            'jumlah_kk_total' => $request->jumlah_kk_total ?? 'required|integer|min:0',
            'ber_phbs'  => $request->ber_phbs ?? 'required|integer|min:0',
        ]);

        // Jika ber_phbs lebih besar dari jumlah_kk_total, tolak
        if ($request->ber_phbs > $request->jumlah_kk_total) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Jumlah Ber-PHBS tidak boleh melebihi Total KK.',
            ], 422);
        }

        DB::table('data_phbs')->updateOrInsert(
            // Kunci unik: puskesmas + bulan + tahun
            [
                'id_puskesmas' => $request->puskesmas,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun,
            ],
            // Data yang di-update atau di-insert
            [
                'jumlah_kk_total'  => $request->jumlah_kk_total,
                'ber_phbs'   => $request->ber_phbs,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status'  => 'ok',
            'message' => "Data berhasil disimpan.",
        ]);
    }
}