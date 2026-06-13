<?php

namespace App\Http\Controllers;

use App\Models\NewDataPHBS;
use App\Models\NewDataPHBSDetail;
use App\Models\Puskesmas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Integer 1–12 → nama bulan string (sesuai isi kolom data_phbs.bulan).
     */
    private function monthIntToStr(int $bulan): string
    {
        return [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember',
        ][$bulan] ?? 'Januari';
    }

    /**
     * Terima bulan dalam bentuk apapun (integer atau nama string),
     * kembalikan integer 1–12.
     */
    private function normalizeMonth($bulan): int
    {
        if (is_numeric($bulan)) {
            return (int) $bulan;
        }

        $map = [
            'januari'   => 1,  'februari'  => 2,  'maret'     => 3,
            'april'     => 4,  'mei'       => 5,  'juni'      => 6,
            'juli'      => 7,  'agustus'   => 8,  'september' => 9,
            'oktober'   => 10, 'november'  => 11, 'desember'  => 12,
        ];

        return $map[strtolower(trim((string) $bulan))] ?? (int) date('n');
    }

    /**
     * Tahun yang tersedia di data_phbs.
     * Kolom tahun disimpan sebagai string → di-cast ke integer.
     */
    private function availableYears(): array
    {
        return NewDataPHBS::selectRaw('DISTINCT CAST(tahun AS UNSIGNED) AS tahun')
            ->orderByRaw('CAST(tahun AS UNSIGNED) DESC')
            ->pluck('tahun')
            ->map(fn ($y) => (int) $y)
            ->toArray();
    }

    /**
     * Bulan (integer) yang tersedia untuk tahun tertentu.
     */
    private function availableMonths(int $tahun): array
    {
        $map = [
            'januari'   => 1,  'februari'  => 2,  'maret'     => 3,
            'april'     => 4,  'mei'       => 5,  'juni'      => 6,
            'juli'      => 7,  'agustus'   => 8,  'september' => 9,
            'oktober'   => 10, 'november'  => 11, 'desember'  => 12,
        ];

        return NewDataPHBS::selectRaw('DISTINCT bulan')
            ->where('tahun', (string) $tahun)
            ->pluck('bulan')
            ->map(fn ($b) => $map[strtolower(trim($b))] ?? null)
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Query utama: puskesmas + data_phbs + data_phbs_detail (semua 13 indikator).
     *
     * Rumus persentase_capaian — sama persis dengan getPersentaseAttribute() model:
     *   Indikator 1-3  : sasaran dari kolom jumlah_sasaran (tidak NULL)
     *   Indikator 4-13 : sasaran NULL → fallback ke jumlah_kk_lk + jumlah_kk_pr
     *
     *   persentase = SUM(capaian) / SUM(sasaran_efektif) * 100
     *
     * Fallback jika tidak ada record data_phbs bulan+tahun tsb → persentase = 0
     */
    private function queryCapaian(int $bulan, int $tahun)
    {
        $bulanStr = $this->monthIntToStr($bulan);
        $tahunStr = (string) $tahun;

        return Puskesmas::join('kecamatans', 'puskesmas.id_kecamatan', '=', 'kecamatans.id_kecamatan')
        ->leftJoin('data_phbs', function ($join) use ($bulanStr, $tahunStr) {
            $join->on('puskesmas.id_puskesmas', '=', 'data_phbs.id_puskesmas')
                 ->where('data_phbs.bulan', $bulanStr)
                 ->where('data_phbs.tahun', $tahunStr);
        })
        ->leftJoin('data_phbs_detail', function ($join) {
            // Join SEMUA indikator (1-13) tanpa filter NULL
            $join->on('data_phbs.id_phbs', '=', 'data_phbs_detail.id_phbs');
        })
        ->select([
            'puskesmas.id_puskesmas',
            'puskesmas.nama_puskesmas',
            'kecamatans.nama_kecamatan AS kecamatan',   // dari tabel kecamatans
            'kecamatans.geojson_polygon',                // polygon ada di kecamatans
            'kecamatans.id_kecamatan',

            // jumlah_kk_total diambil dari data_phbs (lk+pr), fallback 0
            DB::raw('COALESCE(
                data_phbs.jumlah_kk_lk + data_phbs.jumlah_kk_pr, 0
            ) AS jumlah_kk_total'),

            // Total KK dipantau bulan ini
            DB::raw('COALESCE(
                data_phbs.jumlah_kk_lk + data_phbs.jumlah_kk_pr, 0
            ) AS jumlah_sasaran'),

            // Jumlah KK ber-PHBS dari header, fallback 0
            DB::raw('COALESCE(data_phbs.ber_phbs, 0) AS jumlah_tercapai'),

            /*
             * Persentase capaian:
             * - Indikator 1-3: pakai jumlah_sasaran dari DB
             * - Indikator 4-13: jumlah_sasaran NULL → COALESCE ke total KK header
             * - Jika tidak ada data bulan ini (left join miss) → 0
             */
            DB::raw('CASE
                WHEN data_phbs.id_phbs IS NULL
                THEN 0
                WHEN SUM(
                    COALESCE(
                        data_phbs_detail.jumlah_sasaran,
                        data_phbs.jumlah_kk_lk + data_phbs.jumlah_kk_pr
                    )
                ) = 0
                THEN 0
                ELSE ROUND(
                    SUM(data_phbs_detail.jumlah_capaian)
                    / SUM(
                        COALESCE(
                            data_phbs_detail.jumlah_sasaran,
                            data_phbs.jumlah_kk_lk + data_phbs.jumlah_kk_pr
                        )
                    ) * 100, 2
                )
            END AS persentase_capaian'),
        ])
        ->groupBy(
            'puskesmas.id_puskesmas',
            'puskesmas.nama_puskesmas',
            'kecamatans.id_kecamatan',
            'kecamatans.nama_kecamatan',
            'kecamatans.geojson_polygon',
            'data_phbs.id_phbs',
            'data_phbs.jumlah_kk_lk',
            'data_phbs.jumlah_kk_pr',
            'data_phbs.ber_phbs'
        );
    }

    // ── Warna & Kategori ─────────────────────────────────────────────────────

    /**
     * Warna choropleth — threshold sesuai blade & legend:
     *   < 30  → merah  (#e74c3c) — "Sangat Rendah"
     *  30–49  → oranye (#e67e22) — "Rendah"
     *  50–69  → toska  (#1abc9c) — "Sedang"
     *  >= 70  → hijau  (#27ae60) — "Tinggi"
     */
    private function colorByPct(float $pct): string
    {
        if ($pct < 30)  return '#e74c3c';
        if ($pct < 50)  return '#e67e22';
        if ($pct < 70)  return '#1abc9c';
        return '#27ae60';
    }

    /**
     * Label status — harus persis sama dengan key getStatusColors() di blade.
     */
    private function statusByPct(float $pct): string
    {
        if ($pct < 30)  return 'Sangat Rendah';
        if ($pct < 50)  return 'Rendah';
        if ($pct < 70)  return 'Sedang';
        return 'Tinggi';
    }

    // ── Pages ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $tahunList = $this->availableYears();
        $tahun     = (int) $request->get('tahun', date('Y'));
        $bulan     = $this->normalizeMonth($request->get('bulan', date('n')));
        $bulanList = $this->availableMonths($tahun);

        // Pastikan bulan valid untuk tahun yang dipilih
        if (!in_array($bulan, $bulanList) && count($bulanList)) {
            $bulan = max($bulanList);
        }

        $rows = $this->queryCapaian($bulan, $tahun)->get();

        $totalPuskesmas  = $rows->count();
        $rataRataCapaian = round((float) $rows->avg('persentase_capaian'), 1);
        $totalKK         = $rows->sum('jumlah_kk_total');

        /*
         * Key statistik → ID elemen blade:
         *   'sangat_rendah' → id="k-merah"   (< 30%)
         *   'rendah'        → id="k-oranye"  (30–49%)
         *   'sedang'        → id="k-kuning"  (50–69%)
         *   'tinggi'        → id="k-hijau"   (>= 70%)
         */
        $statistik = [
            'sangat_rendah' => $rows->filter(fn ($r) => (float) $r->persentase_capaian < 30)->count(),
            'rendah'        => $rows->filter(fn ($r) => (float) $r->persentase_capaian >= 30 && (float) $r->persentase_capaian < 50)->count(),
            'sedang'        => $rows->filter(fn ($r) => (float) $r->persentase_capaian >= 50 && (float) $r->persentase_capaian < 70)->count(),
            'tinggi'        => $rows->filter(fn ($r) => (float) $r->persentase_capaian >= 70)->count(),
        ];

        return view('dinkes.peta.index', compact(
            'totalPuskesmas', 'rataRataCapaian', 'totalKK',
            'statistik', 'bulan', 'tahun', 'bulanList', 'tahunList'
        ));
    }

    // ── API JSON ──────────────────────────────────────────────────────────────

    public function geojson(Request $request): JsonResponse
    {
        $tahun = (int) $request->get('tahun', date('Y'));
        $bulan = $this->normalizeMonth($request->get('bulan', date('n')));

        $rows = $this->queryCapaian($bulan, $tahun)->get();

        $features = $rows->map(function ($row) {

    $pct = (float) $row->persentase_capaian;

    $geometry = $row->geojson_polygon;

    // decode pertama
    $geometry = json_decode($geometry, true);

    // kalau hasilnya masih string, decode lagi
    if (is_string($geometry)) {
        $geometry = json_decode($geometry, true);
    }


            return [
                'type' => 'Feature',
                'geometry' => $geometry,
                'properties' => [
                    'id'                 => $row->id_puskesmas,
                    'nama_puskesmas'     => $row->nama_puskesmas,
                    'kecamatan'          => $row->kecamatan,
                    'persentase_capaian' => $pct,
                    'jumlah_kk_total'    => (int) $row->jumlah_kk_total,
                    'jumlah_tercapai'    => (int) $row->jumlah_tercapai,
                    'jumlah_sasaran'     => (int) $row->jumlah_sasaran,
                    'status_kategori'    => $this->statusByPct($pct),
                    'warna'              => $this->colorByPct($pct),
    ]
];
        })->values()->toArray();

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $features,
            'meta'     => ['bulan' => $bulan, 'tahun' => $tahun],
        ]);
    }

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
                'jumlah_kk_total'    => (int) $row->jumlah_kk_total,
                'jumlah_tercapai'    => (int) $row->jumlah_tercapai,
                'status_kategori'    => $this->statusByPct($pct),
                'warna'              => $this->colorByPct($pct),
            ];
        });

        return response()->json($data);
    }

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
            'jumlah_kk_total'    => (int) $row->jumlah_kk_total,
            'jumlah_tercapai'    => (int) $row->jumlah_tercapai,
            'jumlah_sasaran'     => (int) $row->jumlah_sasaran,
            'status_kategori'    => $this->statusByPct($pct),
            'warna'              => $this->colorByPct($pct),
        ]);
    }

    public function periodeList(Request $request): JsonResponse
    {
        $tahunList = $this->availableYears();
        $tahun     = (int) $request->get('tahun', $tahunList[0] ?? (int) date('Y'));
        $bulanList = $this->availableMonths($tahun);

        return response()->json([
            'tahun_list' => $tahunList,
            'bulan_list' => $bulanList,
            'active'     => [
                'tahun' => $tahun,
                'bulan' => (int) $request->get('bulan', $bulanList ? max($bulanList) : 1),
            ],
        ]);
    }
}
