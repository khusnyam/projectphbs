<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_phbs;
use App\Models\data_phbs_detail;
use App\Models\puskesmas;
use Illuminate\Support\Facades\Auth;

class PhbsInputController extends Controller
{
    // FORM INPUT
    public function create()
    {
        $puskesmas = puskesmas::all();

        return view('phbs.create', compact('puskesmas'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {

        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $id_puskesmas = Auth::user()->id_puskesmas;

        $jumlah = $request->input('jumlah_input', []);

        $total = array_sum($jumlah);

        if ($total >= 100) {
            $kategori = 'Baik';
        } elseif ($total >= 50) {
            $kategori = 'Cukup';
        } else {
            $kategori = 'Kurang';
        }

        $phbs = data_phbs::create([
            // 'id_puskesmas' => Auth::user()->id_puskesmas,
            // 'bulan' => $request->bulan,
            // 'tahun' => $request->tahun,
            // 'jumlah_kk_total' => $request->jumlah_kk_total,

            'id_puskesmas'    => Auth::user()->id_puskesmas,
            'bulan'           => $request->bulan,
            'tahun'           => $request->tahun,
            'jumlah_kk_l'     => $request->jumlah_kk_l,
            'jumlah_kk_p'     => $request->jumlah_kk_p,
            'jumlah_kk_total' => $request->jumlah_kk_total,
            'ber_phbs'        => $total,
            // 'persen_phbs'     => $persenPhbs,
            'status_laporan'  => 'draft'

            // 'persalinan_nakes'      => $jumlah[1] ?? 0,
            // 'asi_eksklusif'         => $jumlah[2] ?? 0,
            // 'timbang_balita'        => $jumlah[3] ?? 0,
            // 'air_bersih'            => $jumlah[4] ?? 0,
            // 'cuci_tangan'           => $jumlah[5] ?? 0,
            // 'pengelolaan_air_minum' => $jumlah[6] ?? 0,
            // 'jamban_sehat'          => $jumlah[7] ?? 0,
            // 'pengelolaan_limbah'    => $jumlah[8] ?? 0,
            // 'buang_sampah'          => $jumlah[9] ?? 0,
            // 'pemberantasan_jentik'  => $jumlah[10] ?? 0,
            // 'makan_buah_sayur'      => $jumlah[11] ?? 0,
            // 'aktivitas_fisik'       => $jumlah[12] ?? 0,
            // 'tidak_merokok'         => $jumlah[13] ?? 0,

            // 'total_indikator_phbs' => $total,
            // 'kategori_phbs' => $kategori,
            // 'user_penginput' => 1,
        ]);

        $sasaran = $request->input('sasaran_input', []);

for ($i = 1; $i <= 13; $i++) {

    $jumlahSasaran = $sasaran[$i] ?? 0;
    $jumlahCapaian = $jumlah[$i] ?? 0;

    $persentase = $jumlahSasaran > 0
        ? ($jumlahCapaian / $jumlahSasaran) * 100
        : 0;

    if ($persentase >= 80) {
        $kategoriCapaian = 'Tinggi';
    } elseif ($persentase >= 50) {
        $kategoriCapaian = 'Sedang';
    } else {
        $kategoriCapaian = 'Rendah';
    }

    data_phbs_detail::create([
        'id_phbs' => $phbs->id_phbs,
        'id_indikator' => $i,
        'jumlah_sasaran' => $jumlahSasaran,
        'jumlah_capaian' => $jumlahCapaian,
        'persentase' => round($persentase),
        'kategori_capaian' => $kategoriCapaian,
        'keterangan' => '',
    ]);
}

        return redirect()
    ->route('phbs.create')
    ->with('success', 'Data berhasil disimpan');

    }

    // HISTORY
    public function history(Request $request)
{
    $query = data_phbs::with([
    'puskesmas',
    'details'
]);

    if (Auth::user()->id_role == 2) { // role puskesmas
        $query->where('id_puskesmas', Auth::user()->id_puskesmas);
    } elseif ($request->puskesmas) {
        $query->where('id_puskesmas', $request->puskesmas);
    }

    if ($request->bulan) {
        $query->where('bulan', $request->bulan);
    }

    if ($request->tahun) {
        $query->where('tahun', $request->tahun);
    }

    $data = $query
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan')
        ->paginate(10);

    $puskesmas = puskesmas::all();

    return view(
        'phbs.history',
        compact('data', 'puskesmas')
    );
}
    // =====================
    // EDIT
    // =====================
    public function edit($id_phbs)
    {
        $phbs = data_phbs::findOrFail($id_phbs);

        $puskesmas = puskesmas::all();

        return view(
            'phbs.edit',
            compact(
                'phbs',
                'puskesmas'
            )
        );
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id_phbs)
    {
        $phbs = data_phbs::findOrFail($id_phbs);

        $phbs->update([
            'id_puskesmas' => $request->id_puskesmas,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_kk_total' => $request->jumlah_kk_total,
        ]);

        return redirect()
            ->route('phbs.history')
            ->with('success', 'Data berhasil diperbarui');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy($id_phbs)
    {
        $phbs = data_phbs::findOrFail($id_phbs);

        $phbs->delete();

        return redirect()
            ->route('phbs.history')
            ->with('success', 'Data berhasil dihapus');
    }

}
