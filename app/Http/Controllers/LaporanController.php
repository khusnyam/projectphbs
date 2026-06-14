<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\NewPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function exportExcel(Request $request)
    {
        $tahun    = $request->get('tahun', date('Y'));
        $bulan    = $request->get('bulan', 0);
        $pkmId    = $request->get('puskesmas_id', 0);
        $kategori = $request->get('kategori', '');

        $query = DB::table('NewDataPHBS as d')
            ->join('puskesmas as p', 'd.id_puskesmas', '=', 'p.id_puskesmas')
            ->select('d.*', 'p.nama_puskesmas')
            ->where('d.tahun', $tahun);

        if ($bulan)    $query->where('d.bulan', $bulan);
        if ($pkmId)    $query->where('d.id_puskesmas', $pkmId);
        if ($kategori === 'baik')   $query->where('d.persen_phbs', '>=', 80);
        if ($kategori === 'cukup')  $query->whereBetween('d.persen_phbs', [60, 79.99]);
        if ($kategori === 'kurang') $query->where('d.persen_phbs', '<', 60);

        $laporan   = $query->orderBy('p.nama_puskesmas')->orderBy('d.bulan')->get();
        $namaBulan = $this->index($request)->namaBulan;

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Laporan_PHBS_'.$tahun.'.xls"',
            'Cache-Control'       => 'max-age=0',
        ];

        $html = view('phbs.export_excel', compact('laporan','namaBulan','tahun','bulan'))->render();
        return Response::make("\xEF\xBB\xBF".$html, 200, $headers);
        NewDataPhbs::findOrFail($id)->delete();
        return redirect()->route('phbs.index')->with('success', 'Data berhasil dihapus.');
    // }
    //     $export = $this->index($request)->getData();

    //     return view('dinkes.pelaporan.export_excel',compact('export'));
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