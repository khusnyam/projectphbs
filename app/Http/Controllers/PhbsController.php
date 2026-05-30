<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhbsController extends Controller
{
    // ── Tampilkan halaman dashboard ──
    public function index()
    {
        // Ambil semua data tahun 2025
        $data = DB::table('phbs_data')
            ->where('tahun', 2025)
            ->orderBy('puskesmas')
            ->orderByRaw("FIELD(bulan,
                'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        // Susun format $raw yang dibutuhkan oleh JavaScript di blade
        // Format: [ 'NAMA_PUSKESMAS' => [ total_kk, ber_phbs, pct, months[] ] ]
        $raw = [];
        foreach ($data as $row) {
            $pk = $row->puskesmas;

            if (!isset($raw[$pk])) {
                $raw[$pk] = [
                    'total_kk' => 0,
                    'ber_phbs' => 0,
                    'pct'      => 0,
                    'months'   => [],
                ];
            }

            $raw[$pk]['total_kk'] += $row->jumlah_kk;
            $raw[$pk]['ber_phbs'] += $row->ber_phbs;
            $raw[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk,
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
        $data = DB::table('phbs_data')
            ->where('tahun', 2025)
            ->orderBy('puskesmas')
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

            $result[$pk]['total_kk'] += $row->jumlah_kk;
            $result[$pk]['ber_phbs'] += $row->ber_phbs;
            $result[$pk]['months'][]  = [
                'bulan'    => $row->bulan,
                'kk'       => (int) $row->jumlah_kk,
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
        $request->validate([
            'puskesmas' => 'required|string|max:100',
            'bulan'     => 'required|string|max:20',
            'tahun'     => 'required|integer|min:2000|max:2100',
            'jumlah_kk' => 'required|integer|min:0',
            'ber_phbs'  => 'required|integer|min:0',
        ]);

        // Jika ber_phbs lebih besar dari jumlah_kk, tolak
        if ($request->ber_phbs > $request->jumlah_kk) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Jumlah Ber-PHBS tidak boleh melebihi Total KK.',
            ], 422);
        }

        DB::table('phbs_data')->updateOrInsert(
            // Kunci unik: puskesmas + bulan + tahun
            [
                'puskesmas' => $request->puskesmas,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun,
            ],
            // Data yang di-update atau di-insert
            [
                'jumlah_kk'  => $request->jumlah_kk,
                'ber_phbs'   => $request->ber_phbs,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status'  => 'ok',
            'message' => "Data {$request->puskesmas} bulan {$request->bulan} berhasil disimpan.",
        ]);
    }
}
