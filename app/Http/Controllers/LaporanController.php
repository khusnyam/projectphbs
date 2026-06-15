<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\NewPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NewIndikator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user();
        $role     = $user->role->role ?? 'puskesmas';
        $tahun    = $request->get('tahun', date('Y'));
        $bulan    = $request->get('bulan', 0);
        $pkmId    = $request->get('puskesmas_id', 0);
        $kategori = $request->get('kategori', '');

        $puskesmasList = NewPuskesmas::where('status_aktif', true)
            ->orderBy('nama_puskesmas')
            ->get();

        $query = NewDataPHBS::with('puskesmas')
            ->where('tahun', $tahun);

        if ($role === 'puskesmas') {
            $pkm = $user->puskesmas;
            if ($pkm) {
                $query->where('id_puskesmas', $pkm->id_puskesmas);
            }
        } elseif ($pkmId > 0) {
            $query->where('id_puskesmas', $pkmId);
        }

        if ($bulan > 0) {
            $namaBulanString = \App\Models\NewDataPHBS::namaBulan($bulan);
    
            $query->where('bulan', $namaBulanString);
        }

        $laporan = $query->get();

        if ($kategori) {
            $laporan = $laporan->filter(function ($row) use ($kategori) {
                $pct = $row->persen_phbs;
                if ($kategori === 'baik')   return $pct >= 80;
                if ($kategori === 'cukup')  return $pct >= 60 && $pct < 80;
                if ($kategori === 'kurang') return $pct < 60;
                return true;
            });
        }

        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => $laporan->count() > 0
                ? round($laporan->avg('persen_phbs'), 1)
                : 0,
        ];

        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November', 12=>'Desember',
        ];

        return view('dinkes.pelaporan.index', compact(
            'laporan', 'stats', 'puskesmasList',
            'tahun', 'bulan', 'pkmId', 'kategori',
            'namaBulan', 'role'
        ));
    }

    public function form()
    {
        return view('PHBS.form');
    }

    /**
     * Export History PHBS ke Excel
     */
    /**
     * Export History PHBS ke Excel
     */
    /**
     * Export History PHBS ke Excel
     */
    public function exportExcel(Request $request)
    {
        // 1. Query data dasar dengan relasi lengkap
        $query = NewDataPHBS::with(['puskesmas', 'details.indikator']);

        // 2. FILTER AKUN / HAK AKSES PUSKESMAS
        if (Auth::check() && Auth::user()->id_role == 2) {
            $userPuskesmas = NewPuskesmas::where('id_user', Auth::id())->first();
            $id_puskesmas = $userPuskesmas ? $userPuskesmas->id_puskesmas : null;
            $query->where('id_puskesmas', $id_puskesmas);
            
            $currentPuskesmas = $userPuskesmas;
        } else {
            // PERBAIKAN 1: Nama request dari blade adalah 'puskesmas_id'. Nilai > 0 berarti difilter
            if ($request->has('puskesmas_id') && $request->puskesmas_id > 0) {
                $query->where('id_puskesmas', $request->puskesmas_id);
                $currentPuskesmas = NewPuskesmas::find($request->puskesmas_id);
            } else {
                $currentPuskesmas = null;
            }
        }

        // 3. FILTER BULAN & TAHUN
        // PERBAIKAN 2: Jika > 0, konversikan angka dari option value menjadi String nama bulan
        if ($request->has('bulan') && $request->bulan > 0) {
            $namaBulanString = \App\Models\NewDataPHBS::namaBulan($request->bulan);
            $query->where('bulan', $namaBulanString);
        }

        if ($request->has('tahun') && $request->tahun > 0) {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data hasil query (Tanpa pagination)
        $historyData = $query->orderBy('tahun', 'desc')
                            ->orderBy('bulan', 'desc')
                            ->get();

        // 4. FILTER KATEGORI (Sama persis seperti di fungsi index)
        // PERBAIKAN 3: Jika user memfilter kategori Baik/Cukup/Kurang, terapkan di Excel juga
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $historyData = $historyData->filter(function ($row) use ($kategori) {
                $pct = $row->persen_phbs;
                if ($kategori === 'baik')   return $pct >= 80;
                if ($kategori === 'cukup')  return $pct >= 60 && $pct < 80;
                if ($kategori === 'kurang') return $pct < 60;
                return true;
            });
        }

        $allIndikator = NewIndikator::orderBy('id_indikator')->get();

        // 5. Penamaan file excel dinamis sesuai filter
        $namaPkm = $currentPuskesmas ? str_replace(' ', '_', $currentPuskesmas->nama_puskesmas) : 'Semua_Puskesmas';
        $filterBulan = ($request->has('bulan') && $request->bulan > 0) ? '_' . \App\Models\NewDataPHBS::namaBulan($request->bulan) : '';
        $filterTahun = $request->has('tahun') ? '_' . $request->tahun : '';
        
        $filename = "Laporan_PHBS_" . $namaPkm . $filterBulan . $filterTahun . "_" . date('Ymd_His') . ".xls";

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ];

        // Sesuaikan dengan letak view Excel Anda yang ada di LaporanController
        // (contoh: 'dinkes.pelaporan.export_excel' atau 'puskesmas.formulir.export_history_excel')
        $html = view('dinkes.pelaporan.export_excel', compact('historyData', 'allIndikator', 'currentPuskesmas'))->render();
        
        return response("\xEF\xBB\xBF" . $html, 200, $headers);
    }

    public function edit($id)
    {
        $laporan = NewDataPHBS::with('puskesmas')->findOrFail($id);
        return view('PHBS.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = NewDataPHBS::findOrFail($id);
        $laporan->update($request->only([
            'bulan', 'tahun', 'jumlah_kk_lk', 'jumlah_kk_pr', 'ber_phbs'
        ]));
        return redirect()->route('phbs.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        NewDataPHBS::findOrFail($id)->delete();
        return redirect()->route('phbs.index')->with('success', 'Data berhasil dihapus.');
    }
}