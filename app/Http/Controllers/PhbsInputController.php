<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewDataPHBS;
use App\Models\NewDataPHBSDetail;
use App\Models\NewPuskesmas;
use App\Models\NewIndikator;
use Illuminate\Support\Facades\Auth;

class PhbsInputController extends Controller
{
    /**
     * Tampilkan halaman tunggal: Input + History
     * GET /phbs  atau  GET /phbs/create
     */
    public function index(Request $request)
    {
        // Data untuk form input
        $puskesmas    = NewPuskesmas::orderBy('nama_puskesmas')->get();
        $allIndikator = NewIndikator::orderBy('id_indikator')->get();

        // Data untuk history
        $query = NewDataPHBS::with(['puskesmas', 'details.indikator']);

        // Role 2 = puskesmas → hanya lihat data milik sendiri
        if (Auth:: check () && Auth::user()->id_role == 2) {
            $query->where('id_puskesmas', Auth::user()->id_puskesmas);
        } elseif ($request->filled('puskesmas')) {
            $query->where('id_puskesmas', $request->puskesmas);
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $historyData = $query
            ->orderByDesc('tahun')
            ->orderBy('bulan')
            ->paginate(10)
            ->withQueryString();

        // Info footer sidebar
        $footerName    = Auth::user()->name ?? '-';
        $footerRole    = Auth::user()->role->nama_role ?? 'Puskesmas';
        $footerInitial = strtoupper(substr($footerName, 0, 1));

        return view('puskesmas.formulir.input', compact(
            'puskesmas',
            'allIndikator',
            'historyData',
            'footerName',
            'footerRole',
            'footerInitial'
        ));
    }

    /**
     * Simpan data baru
     * POST /phbs/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'bulan'        => 'required|string',
            'tahun'        => 'required|integer|min:2000|max:2100',
            'jumlah_kk_lk' => 'required|integer|min:0',
            'jumlah_kk_pr' => 'required|integer|min:0',
        ]);

        $id_puskesmas  = Auth::user()->id_puskesmas;
        $jumlah        = $request->input('jumlah_input', []);
        $sasaran       = $request->input('sasaran_input', []);
        $jumlahKkTotal = $request->jumlah_kk_lk + $request->jumlah_kk_pr;
        $berPhbs       = array_sum($jumlah);

        $persenPhbs = $jumlahKkTotal > 0
            ? round($berPhbs / $jumlahKkTotal * 100, 2)
            : 0;

        $kategori = match (true) {
            $persenPhbs >= 80 => 'Baik',
            $persenPhbs >= 50 => 'Cukup',
            default           => 'Kurang',
        };

        $phbs = NewDataPHBS::create([
            'id_puskesmas'   => $id_puskesmas,
            'bulan'          => $request->bulan,
            'tahun'          => $request->tahun,
            'jumlah_kk_lk'   => $request->jumlah_kk_lk,
            'jumlah_kk_pr'   => $request->jumlah_kk_pr,
            'ber_phbs'       => $berPhbs,
            'persen_phbs'    => $persenPhbs,
            'kategori_phbs'  => $kategori,
            'status_laporan' => 'draft',
        ]);

        for ($i = 1; $i <= 13; $i++) {
            $jumlahSasaran  = (int) ($sasaran[$i] ?? 0);
            $jumlahCapaian  = (int) ($jumlah[$i]  ?? 0);
            $sasaranEfektif = $jumlahSasaran > 0 ? $jumlahSasaran : $jumlahKkTotal;

            NewDataPHBSDetail::create([
                'id_phbs'        => $phbs->id_phbs,
                'id_indikator'   => $i,
                'jumlah_sasaran' => $jumlahSasaran > 0 ? $jumlahSasaran : null,
                'jumlah_capaian' => $jumlahCapaian,
            ]);
        }

        // Redirect ke route puskesmas.formulir.input (= GET /phbs)
        // dengan tab history langsung terbuka
        return redirect()
            ->route('formulir.input', ['tab' => 'history'])
            ->with('success', 'Data PHBS berhasil disimpan.');
    }

    /**
     * Hapus data
     * DELETE /phbs/{id_phbs}
     */
    public function destroy($id_phbs)
    {
        $phbs = NewDataPHBS::findOrFail($id_phbs);

        // if (Auth::check() && Auth::user()->id_role == 2 && $phbs->id_puskesmas != Auth::user()->id_puskesmas) {
        //     abort(403);
        // }

        $phbs->delete();

        return redirect()
            // ->back()
            ->route('formulir.input', ['tab' => 'history'])
            ->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Form edit
     * GET /phbs/{id_phbs}/edit
     */
    public function edit($id_phbs)
    {
        $phbs         = NewDataPHBS::with('details.indikator')->findOrFail($id_phbs);
        $puskesmas    = NewPuskesmas::orderBy('nama_puskesmas')->get();
        $allIndikator = NewIndikator::orderBy('id_indikator')->get();

        $footerName    = Auth::check() ? (Auth::user()->name ?? '-') : 'Guest';
$footerRole    = 'Puskesmas';
$footerInitial = Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'G';

        return view('puskesmas.formulir.edit', compact(
            'phbs', 'puskesmas', 'allIndikator',
            'footerName', 'footerRole', 'footerInitial'
        ));
    }

    /**
     * Simpan perubahan edit
     * PUT /phbs/{id_phbs}
     */
    public function update(Request $request, $id_phbs)
    {
        $request->validate([
            'bulan'        => 'required|string',
            'tahun'        => 'required|integer',
            'jumlah_kk_lk' => 'required|integer|min:0',
            'jumlah_kk_pr' => 'required|integer|min:0',
        ]);

        $phbs          = NewDataPHBS::findOrFail($id_phbs);
        $jumlah        = $request->input('jumlah_input', []);
        $sasaran       = $request->input('sasaran_input', []);
        $total         = $request->jumlah_kk_lk + $request->jumlah_kk_pr;
        $berPhbs       = array_sum($jumlah);
        $persen        = $total > 0 ? round($berPhbs / $total * 100, 2) : 0;

        $phbs->update([
            'bulan'         => $request->bulan,
            'tahun'         => $request->tahun,
            'jumlah_kk_lk'  => $request->jumlah_kk_lk,
            'jumlah_kk_pr'  => $request->jumlah_kk_pr,
            'ber_phbs'      => $berPhbs,
            'persen_phbs'   => $persen,
            'kategori_phbs' => $persen >= 80 ? 'Baik' : ($persen >= 50 ? 'Cukup' : 'Kurang'),
        ]);

        for ($i = 1; $i <= 13; $i++) {
            $jumlahSasaran = (int) ($sasaran[$i] ?? 0);
            $jumlahCapaian = (int) ($jumlah[$i]  ?? 0);

            $phbs->details()->updateOrCreate(
                ['id_phbs' => $phbs->id_phbs, 'id_indikator' => $i],
                [
                    'jumlah_sasaran' => $jumlahSasaran > 0 ? $jumlahSasaran : null,
                    'jumlah_capaian' => $jumlahCapaian,
                ]
            );
        }

        return redirect()
            ->route('formulir.input', ['tab' => 'history'])
            ->with('success', 'Data PHBS berhasil diperbarui.');
    }
}