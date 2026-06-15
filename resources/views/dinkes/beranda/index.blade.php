@extends('layouts.sidebar')
@section('title','Beranda - SIP-PHBS')
@section('top')
    {{-- ─── HERO ─────────────────────────────────────────────────────── --}}
        <div class="hero-left">
            <div class="hero-title">
                Dashboard PHBS Rumah Tangga
            </div>
            <p class="hero-desc">
                Pantau capaian PHBS Rumah Tangga
                berdasarkan laporan seluruh puskesmas di Kabupaten Sleman.
            </p>
        </div>
@endsection

@section('content')
{{-- ══════════════════════ MAIN ══════════════════════ --}}
<main class="main">

    

    {{-- ─── FILTER ───────────────────────────────────────────────────── --}}
    <div class="filter-section">
        <form method="GET" action="{{ route('beranda') }}">
            <div class="filter-row">
                <div class="fg fg-sm">
                    <label>Tahun</label>
                    <select name="tahun">
                        @foreach($availableTahun as $t)
                            <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="fg fg-md">
                    <label>Bulan</label>
                    <select name="bulan">
                        <option value="">Semua Bulan</option>
                        @php
                            $daftarBulan = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                        @endphp
                        @foreach($daftarBulan as $namaBulan)
                            <option value="{{ $namaBulan }}" @selected($namaBulan == $bulan)>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="fg fg-lg">
                    <label>Puskesmas</label>
                    <select name="id_puskesmas">
                        <option value="">Semua Puskesmas</option>
                        @foreach($puskesmasList as $pkm)
                            <option value="{{ $pkm->id_puskesmas }}" @selected($pkm->id_puskesmas == $id_puskesmas)>
                                {{ $pkm->nama_puskesmas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    Terapkan
                </button>
                <a href="{{ route('beranda') }}" class="btn btn-outline">Reset</a>
            </div>
        </form>
    </div>

    {{-- ══════════════ PAGE WRAP ══════════════ --}}
    <div class="page-wrap">

        {{-- ─── INFO CARDS (4 kolom) ─────────────────────────────────── --}}
        <div class="info-grid">

            {{-- Puskesmas Tertinggi --}}
            <div class="info-card">
                <div class="info-icon green">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Capaian Tertinggi</div>
                    <div class="info-value">{{ $puskesmasTertinggi?->nama_puskesmas ?? '–' }}</div>
                    <div class="info-sub">
                        @if($puskesmasTertinggi)
                            {{ number_format((float)$puskesmasTertinggi->persentase_phbs, 1) }}% Ber-PHBS 
                        @else
                            Belum ada data pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            {{-- Puskesmas Terendah --}}
            <div class="info-card">
                <div class="info-icon red">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Perlu Perhatian</div>
                    <div class="info-value">{{ $puskesmasTerendah?->nama_puskesmas ?? '–' }}</div>
                    <div class="info-sub">
                        @if($puskesmasTerendah)
                            {{ number_format((float)$puskesmasTerendah->persentase_phbs, 1) }}% – capaian terendah
                        @else
                            Belum ada data pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            {{-- Rata-rata PHBS --}}
            <div class="info-card">
                <div class="info-icon blue">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Rata-rata Ber-PHBS</div>
                    <div class="info-value">{{ number_format($rataRataPhbs, 1) }}%</div>
                    <div class="info-sub">Berdasarkan {{ $rekapData->count() }} puskesmas yang terpantau</div>
                </div>
            </div>
        </div>

        {{-- ─── STAT CARDS — Distribusi 4 level ─────────────────────── --}}
        <div class="stat-grid">
            <div class="stat-card green">
                <div class="stat-label">Tinggi ≥ 70%</div>
                <div class="stat-value">{{ $distribusiTinggi }}</div>
                <div class="stat-sub">puskesmas</div>
            </div>
            <div class="stat-card teal">
                <div class="stat-label">Sedang 50–69%</div>
                <div class="stat-value">{{ $distribusiSedang }}</div>
                <div class="stat-sub">puskesmas</div>
            </div>
            <div class="stat-card amber">
                <div class="stat-label">Rendah 30–49%</div>
                <div class="stat-value">{{ $distribusiRendah }}</div>
                <div class="stat-sub">puskesmas</div>
            </div>
            <div class="stat-card red">
                <div class="stat-label">Sangat Rendah &lt;30%</div>
                <div class="stat-value">{{ $distribusiSangatRendah }}</div>
                <div class="stat-sub">puskesmas</div>
            </div>
        </div>

        {{-- ─── CHARTS: Bar + Donut ───────────────────────────────────── --}}
        <div class="charts-grid" style="padding-bottom: 20px">

            {{-- Bar: capaian per puskesmas --}}
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-title">Capaian Ber-PHBS per Puskesmas</span>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <div style="height:260px;"><canvas id="chartBar"></canvas></div>
                <div class="legend">
                    <div class="legend-item"><div class="legend-dot" style="background:#22c55e"></div>Tinggi ≥70%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f59e0b"></div>Sedang 50–69%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f97316"></div>Rendah 30–49%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ef4444"></div>Sangat Rendah</div>
                </div>
            </div>

            {{-- Donut: distribusi --}}
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-title">Distribusi Capaian</span>
                    </div>
                    <span class="card-badge">{{ $rekapData->count() }} PKM</span>
                </div>
                <div style="height:220px;display:flex;justify-content:center;">
                    <canvas id="chartPie"></canvas>
                </div>
                <div class="legend" style="flex-direction:column;gap:6px;margin-top:12px;">
                    <div class="legend-item"><div class="legend-dot" style="background:#22c55e"></div>Tinggi ({{ $distribusiTinggi }})</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f59e0b"></div>Sedang ({{ $distribusiSedang }})</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f97316"></div>Rendah ({{ $distribusiRendah }})</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ef4444"></div>Sangat Rendah ({{ $distribusiSangatRendah }})</div>
                </div>
            </div>
        </div>

        {{-- ─── MATRIKS 13 INDIKATOR × PUSKESMAS ───────────────────── --}}
        <div class="section">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div>
                            <div class="section-title">Matriks 13 Indikator PHBS per Puskesmas</div>
                            <div class="section-sub">Persentase capaian setiap indikator — warna menunjukkan tingkat capaian</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $matriksData->count() }} puskesmas</span>
                </div>

                <div class="table-wrap">
                    @if($matriksData->isEmpty())
                        <div class="empty">
                            <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p>Belum ada data puskesmas untuk periode ini.</p>
                        </div>
                    @else
                    <table class="mtx-table">
                        <thead>
                            <tr>
                                <th style="min-width:150px;">Puskesmas</th>
                                <th class="c">Lap.</th>
                                <th class="c">Rata²</th>
                                @foreach($allIndikators as $ind)
                                    <th class="c" title="{{ $ind->nama_indikator }}">{{ $ind->kode_indikator }}</th>
                                @endforeach
                                <th class="c">Terendah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriksData as $row)
                            <tr>
                                <td class="mtx-name">{{ $row->nama_puskesmas }}</td>
                                <td class="c mtx-num">{{ $row->jumlah_laporan }}</td>
                                <td class="c">
                                    @php $rr = (float)$row->rata_rata; @endphp
                                    <span class="ic {{ $rr>=70?'ic-h':($rr>=50?'ic-m':($rr>=30?'ic-l':($rr>0?'ic-v':'ic-n'))) }}">
                                        {{ $rr > 0 ? number_format($rr,0).'%' : '–' }}
                                    </span>
                                </td>
                                @foreach($allIndikators as $ind)
                                    @php $pct = (float)($row->{'ind'.$ind->id_indikator.'_pct'} ?? 0); @endphp
                                    <td class="c">
                                        <span class="ic {{ $pct>=70?'ic-h':($pct>=50?'ic-m':($pct>=30?'ic-l':($pct>0?'ic-v':'ic-n'))) }}">
                                            {{ $pct > 0 ? number_format($pct,0).'%' : '–' }}
                                        </span>
                                    </td>
                                @endforeach
                                <td class="c">
                                    <span class="ic ic-v" title="{{ $row->ind_terendah_pct }}%">
                                        {{ $row->ind_terendah }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <div class="mtx-legend">
                    <span class="ic-h">≥ 70%</span>
                    <span class="ic-m">50–69%</span>
                    <span class="ic-l">30–49%</span>
                    <span class="ic-v">&lt; 30%</span>
                    <span class="ic-n">– (tidak ada data)</span>
                </div>
            </div>
        </div>

        {{-- ─── REKAPITULASI BER-PHBS PER PUSKESMAS ────────────────── --}}
        <div class="section">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div>
                            <div class="section-title">Rekapitulasi Ber-PHBS per Puskesmas</div>
                            <div class="section-sub">Diurutkan berdasarkan persentase capaian tertinggi · Tahun {{ $tahun }}</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $rekapData->count() }} puskesmas</span>
                </div>

                <div class="table-wrap">
                    @if($rekapData->isEmpty())
                        <div class="empty">
                            <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Tidak ada data sesuai filter yang dipilih.</p>
                        </div>
                    @else
                    <table class="rkp-table">
                        <thead>
                            <tr>
                                <th style="width:34px;">No</th>
                                <th>Nama Puskesmas</th>
                                <th>Kecamatan</th>
                                {{-- <th>Kepala Puskesmas</th> --}}
                                <th class="r">Laporan</th>
                                <th class="r">Total KK</th>
                                <th class="r">Ber-PHBS</th>
                                <th style="min-width:180px;">Capaian</th>
                                <th style="text-align:center;">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapData as $i => $row)
                                @php
                                    $pct = (float) $row->persentase_phbs;
                                    [$lvl, $bdg, $pg] = match(true) {
                                        $pct >= 70 => ['Tinggi',       'b-tinggi',       'pg-green'],
                                        $pct >= 50 => ['Sedang',       'b-sedang',       'pg-amber'],
                                        $pct >= 30 => ['Rendah',       'b-rendah',       'pg-orange'],
                                        default    => ['Sangat Rendah','b-sangatrendah', 'pg-red'],
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="rank {{ $i===0?'rk-1':($i===1?'rk-2':'rk-n') }}">{{ $i+1 }}</div>
                                    </td>
                                    <td style="font-weight:600;color:var(--text);">{{ $row->nama_puskesmas }}</td>
                                    <td>{{ $row->kecamatan ?? '–' }}</td>
                                    {{-- <td style="color:var(--text-b);">{{ $row->kepala_puskesmas ?? '–' }}</td> --}}
                                    <td class="r">{{ number_format($row->jumlah_laporan) }}</td>
                                    <td class="r">{{ number_format($row->total_kk) }}</td>
                                    <td class="r">{{ number_format($row->total_ber_phbs) }}</td>
                                    <td>
                                        <div class="prog-wrap">
                                            <div class="prog-bar">
                                                <div class="prog-fill {{ $pg }}" style="width:{{ min($pct,100) }}%;"></div>
                                            </div>
                                            <span class="prog-pct">{{ number_format($pct,1) }}%</span>
                                        </div>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="badge {{ $bdg }}">{{ $lvl }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            SIP-PHBS &mdash; Dinas Kesehatan Kabupaten Sleman &copy; {{ date('Y') }}
        </div>

    </div>{{-- /page-wrap --}}
</main>

{{-- ══════════════════ CHART.JS ══════════════════ --}}
<script>
const barLabels  = @json($grafikLabels);
const barData    = @json($grafikData);
const barColors  = @json($grafikColors);
const pieData    = [{{ $distribusiTinggi }}, {{ $distribusiSedang }}, {{ $distribusiRendah }}, {{ $distribusiSangatRendah }}];
const trenLabels = @json($trenLabels);
const trenData   = @json($trenData);


Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color       = '#94a3b8';
Chart.defaults.borderColor = '#e2e8f0';

// ── Bar: per puskesmas ─────────────────────────────────────────────────
new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Ber-PHBS (%)',
            data: barData,
            backgroundColor: barColors,
            borderRadius: 5,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${Number(c.parsed.y).toFixed(1)}%` } }
        },
        scales: {
            x: { ticks: { font: { size: 10 }, maxRotation: 45 }, grid: { display: false } },
            y: {
                min: 0, max: 100,
                ticks: { callback: v => v + '%' },
                grid: { color: 'rgba(0,0,0,.05)' }
            }
        }
    }
});

// ── Donut: distribusi ─────────────────────────────────────────────────
new Chart(document.getElementById('chartPie'), {
    type: 'doughnut',
    data: {
        labels: ['Tinggi (≥70%)', 'Sedang (50–69%)', 'Rendah (30–49%)', 'Sangat Rendah (<30%)'],
        datasets: [{
            data: pieData,
            backgroundColor: [
                'rgba(34,197,94,.85)',
                'rgba(245,158,11,.85)',
                'rgba(249,115,22,.85)',
                'rgba(239,68,68,.85)'
            ],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '62%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.label}: ${c.parsed} puskesmas` } }
        }
    }
});


// ── Line: tren bulanan ────────────────────────────────────────────────
@if(count($trenLabels) > 0)
new Chart(document.getElementById('chartTren'), {
    type: 'line',
    data: {
        labels: trenLabels,
        datasets: [
            {
                label: 'Rata-rata Ber-PHBS (%)',
                data: trenData,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2563eb',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2.5,
            },
            // {
            //     label: `Target (${target}%)`,
            //     data: Array(trenLabels.length).fill(target),
            //     borderColor: 'rgba(239,68,68,.5)',
            //     borderDash: [6, 4],
            //     borderWidth: 1.5,
            //     pointRadius: 0,
            //     fill: false,
            // }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { font: { size: 12 }, boxWidth: 12 } },
            tooltip: { callbacks: { label: c => ` ${c.dataset.label}: ${Number(c.parsed.y).toFixed(1)}%` } }
        },
        scales: {
            y: { min: 0, max: 100, ticks: { callback: v => v + '%' } }
        }
    }
});
@endif
</script>
@endsection