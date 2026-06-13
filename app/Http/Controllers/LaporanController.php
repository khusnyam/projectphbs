<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\NewPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $query->where('bulan', $bulan);
        }

        $laporan = $query->orderBy('bulan')->get();

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

    public function exportExcel(Request $request)
    {
        return view('PHBS.export_excel');
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