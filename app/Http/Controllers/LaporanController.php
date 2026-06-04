<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//vanda
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    private $namaBulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
    ];

    public function index(Request $req)
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

        $laporan       = $query->orderBy('p.nama_puskesmas')->orderBy('d.bulan')->get();
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();

        $stats = [
            'total_laporan'  => $laporan->count(),
            'total_kk'       => $laporan->sum('jumlah_kk_total'),
            'total_ber_phbs' => $laporan->sum('ber_phbs'),
            'rata_phbs'      => round($laporan->avg('persen_phbs'), 1),
        ];

        return view('phbs.index', compact(
            'laporan','puskesmasList','stats',
            'tahun','bulan','pkmId','kategori'
        ))->with('namaBulan', $this->namaBulan);
    }

    public function form()
    {
        $puskesmasList = DB::table('puskesmas')->orderBy('nama_puskesmas')->get();
        $namaBulan     = $this->namaBulan;
        $data          = null;
        return view('phbs.form', compact('puskesmasList','namaBulan','data'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'id_puskesmas'    => 'required',
            'tahun'           => 'required|integer',
            'bulan'           => 'required|integer|min:1|max:12',
            'jumlah_kk_l'     => 'required|integer|min:0',
            'jumlah_kk_p'     => 'required|integer|min:0',
            'jumlah_kk_total' => 'required|integer|min:0',
            'ber_phbs'        => 'required|integer|min:0',
        ]);

        $total = $req->jumlah_kk_total;
        $persen = $total > 0 ? round(($req->ber_phbs / $total) * 100, 2) : 0;

        $data = $req->except('_token');
        $data['persen_phbs'] = $persen;

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
        $total  = $req->jumlah_kk_total;
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
