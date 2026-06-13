<?php

namespace App\Http\Controllers;

use App\Models\NewDataPhbs;
use App\Models\NewPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewDataPHBSDetail;

class PhbsController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $role     = $user->role->role ?? 'puskesmas';
        $tahun    = $request->get('tahun', date('Y'));
        $bulan    = $request->get('bulan', 0);
        $pkmId    = $request->get('puskesmas_id', 0);
        $kategori = $request->get('kategori', '');

        // Ambil daftar puskesmas untuk filter
        $puskesmasList = NewPuskesmas::where('status_aktif', true)
            ->orderBy('nama_puskesmas')
            ->get();

        // Query laporan
        $query = NewDataPhbs::with('puskesmas')
            ->where('tahun', $tahun);

        // Kalau role puskesmas, hanya tampilkan data miliknya
        if ($role === 'puskesmas') {
            $pkm = $user->puskesmas;

            if ($pkm) {
                $query->where('id_puskesmas', $pkm->id_puskesmas);
            }
        } elseif ($pkmId > 0) {
            $query->where('id_puskesmas', $pkmId);
        }

        if ($bulan > 0) {
            $query->where('bulan', $bulan);
        }

        $laporan = $query->orderBy('bulan')->get();

        // Filter kategori setelah query (pakai accessor)
        if ($kategori) {
            $laporan = $laporan->filter(function ($row) use ($kategori) {
                $pct = $row->persen_phbs;

                if ($kategori === 'baik') {
                    return $pct >= 80;
                }

                if ($kategori === 'cukup') {
                    return $pct >= 60 && $pct < 80;
                }

                if ($kategori === 'kurang') {
                    return $pct < 60;
                }

                return true;
            });
        }

        // Hitung stats
        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => $laporan->count() > 0
                ? round($laporan->avg('persen_phbs'), 1)
                : 0,
        ];

        $namaBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('phbs.dashboard', compact('datadashboard'));
    }
    // public function index(Request $request)
    // {
    //     $tahun = $request->tahun ?? date('Y');
    //     // Gate::authorize('akses-puskesmas');

    //     // $data = 
    //     $data = DB::table('NewDataPHBS')
    //         ->join('puskesmas', 'NewDataPHBS.id_puskesmas', '=', 'puskesmas.id_puskesmas')
    //         ->where('tahun', $tahun)
    //         ->orderBy('puskesmas.nama_puskesmas', 'asc')
    //         ->orderByRaw("FIELD(bulan,
    //             'Januari','Februari','Maret','April','Mei','Juni',
    //             'Juli','Agustus','September','Oktober','November','Desember')")
    //         ->select('NewDataPHBS.*', 'puskesmas.nama_puskesmas')
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
        $req->validate([
            'id_puskesmas'    => 'required',
            'tahun'           => 'required|integer',
            'bulan'           => 'required|integer|min:1|max:12',
            'jumlah_kk_total_l'     => 'required|integer|min:0',
            'jumlah_kk_total_p'     => 'required|integer|min:0',
            'jumlah_kk_total_total' => 'required|integer|min:0',
            'ber_phbs'        => 'required|integer|min:0',
        ]);

        $total = $req->jumlah_kk_total_total;
        $persen = $total > 0 ? round(($req->ber_phbs / $total) * 100, 2) : 0;

        DB::table('NewDataPHBS')->updateOrInsert(
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
        DB::table('data_phbs')->insert($data);

        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil disimpan!');
    }

    public function edit($id)
    {
        $data          = DB::table('data_phbs')->where('id_data', $id)->first();
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();
        $namaBulan     = $this->namaBulan;
        return view('phbs.form', compact('data','puskesmasList','namaBulan'));
    }

    public function update(Request $req, $id)
    {
        $total  = $req->jumlah_kk_total_total;
        $persen = $total > 0 ? round(($req->ber_phbs / $total) * 100, 2) : 0;

        $data = $req->except(['_token','_method']);
        $data['persen_phbs'] = $persen;

        DB::table('data_phbs')->where('id_data', $id)->update($data);

        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('data_phbs')->where('id_data', $id)->delete();
        return redirect()->route('phbs.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }

    public function exportExcel(Request $req)
    {
        $tahun    = $req->get('tahun', date('Y'));
        $bulan    = $req->get('bulan', 0);
        $pkmId    = $req->get('puskesmas_id', 0);
        $kategori = $req->get('kategori', '');

        $query = DB::table('data_phbs as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan)    $query->where('d.bulan', $bulan);
        if ($pkmId)    $query->where('d.id_puskesmas', $pkmId);
        if ($kategori === 'baik')   $query->where('d.persen_phbs', '>=', 80);
        if ($kategori === 'cukup')  $query->whereBetween('d.persen_phbs', [60, 79.99]);
        if ($kategori === 'kurang') $query->where('d.persen_phbs', '<', 60);

        $laporan   = $query->orderBy('p.nama_puskesmas')->orderBy('d.bulan')->get();
        $namaBulan = $this->namaBulan;

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Laporan_PHBS_'.$tahun.'.xls"',
            'Cache-Control'       => 'max-age=0',
        ];

        $html = view('phbs.export_excel', compact('laporan','namaBulan','tahun','bulan'))->render();
        return Response::make("\xEF\xBB\xBF".$html, 200, $headers);
    }
}