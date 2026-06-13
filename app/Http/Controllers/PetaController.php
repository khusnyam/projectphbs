<?php

namespace App\Http\Controllers;

use App\Models\CapaianBulanan;
use App\Models\Puskesmas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    // ── Helpers ──────────────────────────────────────────────────────────────

    /** Tahun yang tersedia di tabel capaian_bulanan. */
    private function availableYears(): array
    {
        return CapaianBulanan::selectRaw('DISTINCT tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    /** Bulan yang tersedia untuk tahun tertentu. */
    private function availableMonths(int $tahun): array
    {
        return CapaianBulanan::where('tahun', $tahun)
            ->selectRaw('DISTINCT bulan')
            ->orderBy('bulan')
            ->pluck('bulan')
            ->toArray();
    }

    private function normalizeMonth($bulan): int
    {
        if (is_numeric($bulan)) {
            return (int) $bulan;
        }

        $bulan = trim(strtolower((string) $bulan));
        $names = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'desember',
        ];

        $key = array_search($bulan, array_map('strtolower', $names), true);

        return $key ?: date('n');
    }

    /**
     * Query capaian bulan+tahun tertentu, di-join ke puskesmas.
     * Jika bulan/tahun tidak ada, fallback ke persentase_capaian di tabel puskesmas.
     */
    private function queryCapaian($bulan, int $tahun)
    {
        $bulan = $this->normalizeMonth($bulan);

        return Puskesmas::leftJoin('capaian_bulanan', function ($join) use ($bulan, $tahun) {
            $join->on('puskesmas.id_puskesmas', '=', 'capaian_bulanan.id_puskesmas')
                 ->where('capaian_bulanan.bulan', $bulan)
                 ->where('capaian_bulanan.tahun', $tahun);
        })
        ->select([
            'puskesmas.id_puskesmas',
            'puskesmas.nama_puskesmas',
            'puskesmas.kecamatan',
            'puskesmas.jumlah_kk_total',
            'puskesmas.geojson_polygon',
            DB::raw('COALESCE(capaian_bulanan.persentase_capaian, puskesmas.persentase_capaian) AS persentase_capaian'),
            DB::raw('COALESCE(capaian_bulanan.status_kategori,    puskesmas.status_kategori)    AS status_kategori'),
            DB::raw('COALESCE(capaian_bulanan.jumlah_tercapai, 0) AS jumlah_tercapai'),
            DB::raw('COALESCE(capaian_bulanan.jumlah_sasaran,  puskesmas.jumlah_kk_total) AS jumlah_sasaran'),
        ]);
    }

    // ── Pages ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $tahunList = $this->availableYears();
        $tahun     = (int) $request->get('tahun', date('Y'));
        $bulan     = $this->normalizeMonth($request->get('bulan', date('n')));
        $bulanList = $this->availableMonths($tahun);

        // Pastikan bulan valid untuk tahun yg dipilih
        if (!in_array($bulan, $bulanList) && count($bulanList)) {
            $bulan = max($bulanList);
        }

        $rows = $this->queryCapaian($bulan, $tahun)->get();

        $totalPuskesmas  = $rows->count();
        $rataRataCapaian = $rows->avg('persentase_capaian');
        $totalKK   = $rows->sum('jumlah_kk_total');

        $statistik = [
            'rendah'        => $rows->where('persentase_capaian', '<', 60)->count(),
            'sedang'        => $rows->filter(fn($r) => $r->persentase_capaian >= 60 && $r->persentase_capaian <= 80)->count(),
            'tinggi'        => $rows->where('persentase_capaian', '>', 80)->count(),
        ];

        return view('dinkes.peta.index', compact(
            'totalPuskesmas', 'rataRataCapaian', 'totalKK',
            'statistik', 'bulan', 'tahun', 'bulanList', 'tahunList'
        ));
    }

    // ── API JSON ──────────────────────────────────────────────────────────────

    /** GeoJSON FeatureCollection dengan filter bulan+tahun. */
    public function geojson(Request $request): JsonResponse
    {
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = $this->normalizeMonth($request->get('bulan', date('n')));

        $rows = $this->queryCapaian($bulan, $tahun)->get();

        $features = $rows->map(function ($row) {
            $pct   = (float) $row->persentase_capaian;
            $warna = $this->colorByPct($pct);

            return [
                'type'     => 'Feature',
                'geometry' => is_string($row->geojson_polygon)
                    ? json_decode($row->geojson_polygon, true)
                    : $row->geojson_polygon,
                'properties' => [
                    'id'                 => $row->id_puskesmas,
                    'nama_puskesmas'     => $row->nama_puskesmas,
                    'kecamatan'          => $row->kecamatan,
                    'persentase_capaian' => $pct,
                    'jumlah_kk_total'    => (int) $row->jumlah_kk_total,
                    'jumlah_tercapai'    => (int) $row->jumlah_tercapai,
                    'jumlah_sasaran'     => (int) $row->jumlah_sasaran,
                    'status_kategori'    => $row->status_kategori,
                    'warna'              => $warna,
                ],
            ];
        })->values()->toArray();

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $features,
            'meta'     => ['bulan' => $bulan, 'tahun' => $tahun],
        ]);
    }

    /** Daftar puskesmas (sidebar) dengan filter bulan+tahun. */
    public function list(Request $request): JsonResponse
    {
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = $this->normalizeMonth($request->get('bulan', date('n')));

        $rows = $this->queryCapaian($bulan, $tahun)
            ->orderBy('puskesmas.nama_puskesmas')
            ->get();

        $data = $rows->map(function ($row) {
            $pct = (float) $row->persentase_capaian;
            return [
                'id'                 => $row->id_puskesmas,
                'nama_puskesmas'     => $row->nama_puskesmas,
                'kecamatan'          => $row->kecamatan,
                'persentase_capaian' => $pct,
                'jumlah_kk_total'    => number_format($row->jumlah_kk_total, 0, ',', '.'),
                'jumlah_tercapai'    => number_format($row->jumlah_tercapai, 0, ',', '.'),
                'status_kategori'    => $row->status_kategori,
                'warna'              => $this->colorByPct($pct),
            ];
        });

        return response()->json($data);
    }

    /** Detail satu puskesmas pada bulan+tahun tertentu. */
    public function show(int $id, Request $request): JsonResponse
    {
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = $this->normalizeMonth($request->get('bulan', date('n')));

        $row = $this->queryCapaian($bulan, $tahun)
            ->where('puskesmas.id_puskesmas', $id)
            ->firstOrFail();

        $pct = (float) $row->persentase_capaian;

        return response()->json([
            'id'                 => $row->id_puskesmas,
            'nama_puskesmas'     => $row->nama_puskesmas,
            'kecamatan'          => $row->kecamatan,
            'persentase_capaian' => $pct,
            'jumlah_kk_total'    => number_format($row->jumlah_kk_total, 0, ',', '.'),
            'jumlah_tercapai'    => number_format($row->jumlah_tercapai, 0, ',', '.'),
            'jumlah_sasaran'     => number_format($row->jumlah_sasaran,  0, ',', '.'),
            'status_kategori'    => $row->status_kategori,
            'warna'              => $this->colorByPct($pct),
        ]);
    }

    /** Daftar tahun + bulan yang tersedia (untuk populate dropdown). */
    public function periodeList(Request $request): JsonResponse
    {
        $tahunList = $this->availableYears();
        $tahun     = (int) $request->get('tahun', $tahunList[0] ?? date('Y'));
        $bulanList = $this->availableMonths($tahun);

        return response()->json([
            'tahun_list' => $tahunList,
            'bulan_list' => $bulanList,
            'active'     => [
                'tahun' => $tahun,
                'bulan' => (int) $request->get('bulan', max($bulanList ?: [1])),
            ],
        ]);
    }

    // ── Utility ───────────────────────────────────────────────────────────────

    private function colorByPct(float $pct): string
    {
        if ($pct <= 60) return '#e74c3c';
        if ($pct <= 80) return '#f1c40f';
        return '#27ae60';
    }
}