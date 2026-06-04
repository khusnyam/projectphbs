<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use app\Models\puskesmas;

class PhbsController extends Controller
{
    // ── Tampilkan halaman dashboard ──
    public function index()
    {
        // Gate::authorize('akses-puskesmas');
        // Ambil semua data tahun 2025
        $data = DB::table('data_phbs')
            ->join('puskesmas', 'data_phbs.id_puskesmas', '=', 'puskesmas.id_puskesmas')
            ->where('tahun', 2025)
            ->orderBy('puskesmas.nama_puskesmas', 'asc')
            ->orderByRaw("FIELD(bulan,
                'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember')")
            ->select('data_phbs.*', 'puskesmas.nama_puskesmas')
            ->get();

        // Susun format $raw yang dibutuhkan oleh JavaScript di blade
        // Format: [ 'NAMA_PUSKESMAS' => [ total_kk, ber_phbs, pct, months[] ] ]
        $raw = [];
        foreach ($data as $row) {
            $pk = $row->nama_puskesmas;

            if (!isset($raw[$pk])) {
                $raw[$pk] = [
                    'total_kk' => 0,
                    'ber_phbs' => 0,
                    'pct'      => 0,
                    'months'   => [],
                ];
            }

            $raw[$pk]['total_kk'] += $row->jumlah_kk_total;
            $raw[$pk]['ber_phbs'] += $row->ber_phbs;
            $raw[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk_total,
                'ber_phbs' => (int) $row->ber_phbs,
            ];
        }

        // Hitung persentase per puskesmas
        foreach ($raw as $pk => &$d) {
            $d['pct'] = $d['total_kk'] > 0
                ? round($d['ber_phbs'] / $d['total_kk'] * 100, 1)
                : 0;
        }

        // Kirim $raw ke blade → dipakai: const RAW = {!! json_encode($raw) !!};
        return view('phbs.dashboard', compact('raw'));
    }

    // ── API: kirim data JSON (opsional, untuk fetch() dari JS) ──
    public function getData()
    {
        // Gate::authorize('akses-puskesmas');

        $data = DB::table('data_phbs')
            ->join('puskesmas', 'data_phbs.id_puskesmas', '=', 'puskesmas.id_puskesmas')
            ->where('tahun', 2025)
            ->orderBy('puskesmas.nama_puskesmas', 'asc')
            ->select('data_phbs.*', 'puskesmas.nama_puskesmas')
            ->get();

        $result = [];
        foreach ($data as $row) {
            $pk = $row->puskesmas;

            if (!isset($result[$pk])) {
                $result[$pk] = [
                    'total_kk' => 0,
                    'ber_phbs' => 0,
                    'pct'      => 0,
                    'months'   => [],
                ];
            }

            $result[$pk]['total_kk'] += $row->jumlah_kk_total;
            $result[$pk]['ber_phbs'] += $row->ber_phbs;
            $result[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk_total,
                'ber_phbs' => (int) $row->ber_phbs,
            ];
        }

        foreach ($result as $pk => &$d) {
            $d['pct'] = $d['total_kk'] > 0
                ? round($d['ber_phbs'] / $d['total_kk'] * 100, 1)
                : 0;
        }

        return response()->json($result);
    }

    // ── Simpan data input manual dari form ──
    public function simpan(Request $request)
    {
        Gate::authorize('akses-puskesmas');

        $request->validate([
            'id_puskesmas' => 'required|string|max:100',
            'bulan'     => 'required|string|max:20',
            'tahun'     => 'required|integer|min:2000|max:2100',
            'jumlah_kk_total' => 'required|integer|min:0',
            'ber_phbs'  => 'required|integer|min:0',
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