@extends('layouts.sidebar')
@section('title','Dashboard PHBS - SIP-PHBS')
@section('top')
    {{-- ─── HERO ───────────────────────────────────────────────────────────── --}}
    {{-- <div class="hero"> --}}
        <div class="hero-left">
            <div class="hero-title">
                Analisis Indikator
            </div>
            <p class="hero-desc">
                Analisis mendalam 13 indikator PHBS Rumah Tangga
                Kabupaten Sleman.
            </p>
        </div>
    {{-- </div> --}}
@endsection

@section('content')

<main class="main">

    {{-- ─── FILTER ─────────────────────────────────────────────────────────── --}}
    <div class="filter-section">
        <form method="GET" action="{{ route('dashboard.phbs') }}">
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
                        @foreach(range(1,12) as $b)
                            <option value="{{ $b }}" @selected($b == $bulan)>
                                {{ \App\Models\NewDataPHBS::namaBulan($b) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    Terapkan
                </button>
                <a href="{{ route('dashboard.phbs') }}" class="btn btn-outline">Reset</a>
            </div>
        </form>
    </div>

    {{-- ══════════════════════ PAGE WRAP ══════════════════════ --}}
    <div class="page-wrap">

        {{-- ─── STAT CARDS — Distribusi level indikator ───────────────────── --}}
        <div class="stat-grid" style="padding-top:20px;">
            <div class="stat-card green">
                <div class="stat-label">Tinggi ≥ 70%</div>
                <div class="stat-value">{{ $indTinggi }}</div>
                <div class="stat-sub">indikator</div>
            </div>
            <div class="stat-card teal">
                <div class="stat-label">Sedang 50–69%</div>
                <div class="stat-value">{{ $indSedang }}</div>
                <div class="stat-sub">indikator</div>
            </div>
            <div class="stat-card amber">
                <div class="stat-label">Rendah 30–49%</div>
                <div class="stat-value">{{ $indRendah }}</div>
                <div class="stat-sub">indikator</div>
            </div>
            <div class="stat-card red">
                <div class="stat-label">Sangat Rendah &lt;30%</div>
                <div class="stat-value">{{ $indSangatRendah }}</div>
                <div class="stat-sub">indikator</div>
            </div>
        </div>

        {{-- ─── INDIKATOR TERKUAT vs TERLEMAH ──────────────────────────────── --}}
        <div class="info-grid" style="padding-top:16px;">
            {{-- Terkuat --}}
            <div class="info-card">
                <div class="info-icon green">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M5 3l14 9-14 9V3z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Indikator Terkuat</div>
                    <div class="info-value" style="font-size:13px;">
                        @if($indTerkuat)
                            <span style="color:var(--primary);font-family:var(--mono);font-size:12px;">{{ $indTerkuat['kode'] }}</span>
                            {{ $indTerkuat['label'] }}
                        @else –
                        @endif
                    </div>
                    <div class="info-sub">
                        @if($indTerkuat) {{ number_format($indTerkuat['persentase'],1) }}% capaian tertinggi @endif
                    </div>
                </div>
            </div>

            {{-- Terlemah --}}
            <div class="info-card">
                <div class="info-icon red">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Indikator Terlemah</div>
                    <div class="info-value" style="font-size:13px;">
                        @if($indTerlemah)
                            <span style="color:var(--red);font-family:var(--mono);font-size:12px;">{{ $indTerlemah['kode'] }}</span>
                            {{ $indTerlemah['label'] }}
                        @else –
                        @endif
                    </div>
                    <div class="info-sub">
                        @if($indTerlemah) {{ number_format($indTerlemah['persentase'],1) }}% – perlu perhatian @endif
                    </div>
                </div>
            </div>

            {{-- Rata-rata indikator --}}
            <div class="info-card">
                <div class="info-icon blue">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Rata-rata Kabupaten</div>
                    <div class="info-value">{{ number_format($rataKabupaten, 1) }}%</div>
                    <div class="info-sub">Rata-rata 13 indikator PHBS</div>
                </div>
            </div>
        </div>

        {{-- ─── RINGKASAN 13 INDIKATOR TINGKAT KABUPATEN ───────────────────── --}}
        <div class="section" style="padding-top:20px;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div>
                            <div class="section-title">Ringkasan 13 Indikator PHBS Tingkat Kabupaten</div>
                            <div class="section-sub">Capaian setiap indikator se-Kabupaten Sleman — Tahun {{ $tahun }}{{ $bulan ? ' / Bulan '.\App\Models\NewDataPHBS::namaBulan($bulan) : '' }}</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <div class="table-wrap">
                    <table class="rkp-table" style="min-width:700px;">
                        <thead>
                            <tr>
                                <th style="width:40px;">No</th>
                                <th style="width:80px;">Kode</th>
                                <th>Nama Indikator</th>
                                <th class="r" style="width:120px;">Total Sasaran</th>
                                <th class="r" style="width:120px;">Total Capaian</th>
                                <th style="min-width:200px;">Persentase</th>
                                <th style="text-align:center;width:100px;">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapIndikator as $id => $ind)
                                @php
                                    $pct = (float) $ind['persentase'];
                                    [$lvl, $bdg, $pg] = match(true) {
                                        $pct >= 70 => ['Tinggi',       'b-tinggi',       'pg-green'],
                                        $pct >= 50 => ['Sedang',       'b-sedang',       'pg-amber'],
                                        $pct >= 30 => ['Rendah',       'b-rendah',       'pg-orange'],
                                        default    => ['Sangat Rendah','b-sangatrendah', 'pg-red'],
                                    };
                                @endphp
                                <tr>
                                    <td style="text-align:center;font-weight:600;color:var(--text-muted);">{{ $loop->iteration }}</td>
                                    <td>
                                        <span style="font-family:var(--mono);font-size:12px;font-weight:700;color:var(--primary);background:var(--primary-lt);padding:2px 7px;border-radius:5px;">
                                            {{ $ind['kode'] }}
                                        </span>
                                    </td>
                                    <td style="font-weight:500;color:var(--text);max-width:280px;white-space:normal;line-height:1.4;">{{ $ind['label'] }}</td>
                                    <td class="r">{{ number_format($ind['total_sasaran']) }}</td>
                                    <td class="r">{{ number_format($ind['total_capaian']) }}</td>
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
                </div>
                <div class="mtx-legend">
                    <span class="ic ic-h">≥70% Tinggi</span>
                    <span class="ic ic-m">50–69% Sedang</span>
                    <span class="ic ic-l">30–49% Rendah</span>
                    <span class="ic ic-v">&lt;30% Sangat Rendah</span>
                </div>
            </div>
        </div>

        {{-- ─── CHARTS: Radar + Bar Horizontal ────────────────────────────── --}}
        <div class="charts-grid" style="padding-top:20px;">

            {{-- Radar Chart --}}
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-title">Profil 13 Indikator PHBS Kabupaten</span>
                    </div>
                    <span class="card-badge">Radar</span>
                </div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;">Visualisasi "bentuk" capaian — semakin luas area, semakin baik capaian keseluruhan.</p>
                <div style="height:300px;"><canvas id="chartRadar"></canvas></div>
            </div>

            {{-- Bar Horizontal: ranking indikator --}}
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <span class="card-title">Ranking Indikator</span>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <p style="font-size:12px;color:var(--text-muted);margin-bottom:12px;">Urutan capaian dari tertinggi ke terendah.</p>
                <div style="height:300px;"><canvas id="chartBarH"></canvas></div>
            </div>
        </div>

        {{-- ─── TREN PER INDIKATOR ──────────────────────────────────────────── --}}
        <div class="section" style="padding-top:20px;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div>
                            <div class="section-title">Tren Capaian per Indikator</div>
                            <div class="section-sub">Perkembangan setiap indikator dari bulan ke bulan selama {{ $tahun }}</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <select id="indSelect" class="dash-select" onchange="updateTren(this.value)">
                            @foreach($trenData as $id => $ind)
                                <option value="{{ $id }}">{{ $ind['kode'] }} – {{ Str::limit($ind['label'], 40) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="padding:20px;">
                    <div style="height:240px;"><canvas id="chartTren"></canvas></div>
                </div>
            </div>
        </div>

        {{-- ─── HEATMAP INDIKATOR × BULAN ──────────────────────────────────── --}}
        <div class="section" style="padding-top:20px;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div>
                            <div class="section-title">Heatmap Konsistensi Indikator per Bulan</div>
                            <div class="section-sub">Seberapa konsisten capaian tiap indikator sepanjang {{ $tahun }} — warna lebih gelap = capaian lebih tinggi</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <div class="table-wrap">
                    <table class="heatmap-table">
                        <thead>
                            <tr>
                                <th class="hm-ind-col">Indikator</th>
                                @foreach($namaBulan as $nb)
                                    <th class="hm-cell-head">{{ $nb }}</th>
                                @endforeach
                                <th class="hm-cell-head" style="color:var(--primary)">Avg</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($heatmapData as $row)
                                @php
                                    $bulanData = $row['bulan'];
                                    $aktif = array_filter($bulanData, fn($v) => $v > 0);
                                    $avg = count($aktif) > 0 ? round(array_sum($aktif)/count($aktif),1) : 0;
                                @endphp
                                <tr>
                                    <td class="hm-ind-label">
                                        <span class="hm-kode">{{ $row['kode'] }}</span>
                                        <span class="hm-nama">{{ $row['label'] }}</span>
                                    </td>
                                    @foreach($bulanData as $val)
                                        @php
                                            $opacity = $val > 0 ? round(0.15 + ($val/100)*0.80, 2) : 0;
                                            $textColor = $val >= 50 ? '#fff' : ($val > 0 ? '#166534' : '#cbd5e1');
                                            $bgColor = $val > 0 ? "rgba(34,197,94,{$opacity})" : '#f8fafc';
                                        @endphp
                                        <td class="hm-cell" style="background:{{ $bgColor }};color:{{ $textColor }};">
                                            {{ $val > 0 ? number_format($val,0).'%' : '–' }}
                                        </td>
                                    @endforeach
                                    @php
                                        $avgOpacity = $avg > 0 ? round(0.15 + ($avg/100)*0.80, 2) : 0;
                                        $avgText    = $avg >= 50 ? '#fff' : ($avg > 0 ? '#166534' : '#cbd5e1');
                                        $avgBg      = $avg > 0 ? "rgba(37,99,235,{$avgOpacity})" : '#f8fafc';
                                    @endphp
                                    <td class="hm-cell hm-avg" style="background:{{ $avgBg }};color:{{ $avgText }};">
                                        {{ $avg > 0 ? number_format($avg,1).'%' : '–' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding:0 20px 14px;display:flex;align-items:center;gap:10px;font-size:11.5px;color:var(--text-muted);">
                    <span>Skala warna:</span>
                    <span style="display:inline-flex;gap:3px;align-items:center;">
                        <span style="width:14px;height:14px;border-radius:3px;background:rgba(34,197,94,.15);display:inline-block;border:1px solid #e2e8f0;"></span> Rendah
                    </span>
                    <span style="display:inline-flex;gap:3px;align-items:center;">
                        <span style="width:14px;height:14px;border-radius:3px;background:rgba(34,197,94,.55);display:inline-block;"></span> Sedang
                    </span>
                    <span style="display:inline-flex;gap:3px;align-items:center;">
                        <span style="width:14px;height:14px;border-radius:3px;background:rgba(34,197,94,.95);display:inline-block;"></span> Tinggi
                    </span>
                    <span style="margin-left:8px;display:inline-flex;gap:3px;align-items:center;">
                        <span style="width:14px;height:14px;border-radius:3px;background:rgba(37,99,235,.55);display:inline-block;"></span> Rata-rata (biru)
                    </span>
                </div>
            </div>
        </div>

        <div class="footer">
            SIP-PHBS &mdash; Dinas Kesehatan Kabupaten Sleman &copy; {{ date('Y') }}
        </div>

    </div>{{-- /page-wrap --}}
</main>

{{-- ══════════════════════ CHART.JS ══════════════════════ --}}
<script>
const radarLabels = @json($radarLabels);
const radarData   = @json($radarData);
const trenAllData = @json($trenData);

const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color       = '#94a3b8';
Chart.defaults.borderColor = '#e2e8f0';

// ── Radar Chart ────────────────────────────────────────────────────────────
new Chart(document.getElementById('chartRadar'), {
    type: 'radar',
    data: {
        labels: radarLabels,
        datasets: [{
            label: 'Capaian Indikator (%)',
            data: radarData,
            backgroundColor: 'rgba(37,99,235,.15)',
            borderColor: 'rgba(37,99,235,.8)',
            borderWidth: 2,
            pointBackgroundColor: radarData.map(v =>
                v >= 70 ? 'rgba(34,197,94,.9)' :
                v >= 50 ? 'rgba(245,158,11,.9)' :
                v >= 30 ? 'rgba(249,115,22,.9)' : 'rgba(239,68,68,.9)'
            ),
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                min: 0, max: 100,
                ticks: { stepSize: 20, callback: v => v + '%', font: { size: 10 } },
                pointLabels: { font: { size: 10.5, weight: '600' } },
                grid: { color: 'rgba(0,0,0,.07)' },
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.dataset.label}: ${Number(c.parsed.r).toFixed(1)}%` } }
        }
    }
});

// ── Bar Horizontal: ranking indikator ──────────────────────────────────────
const sortedIdx = radarData
    .map((v, i) => ({ v, i }))
    .sort((a, b) => b.v - a.v);

new Chart(document.getElementById('chartBarH'), {
    type: 'bar',
    data: {
        labels: sortedIdx.map(x => radarLabels[x.i]),
        datasets: [{
            label: 'Capaian (%)',
            data: sortedIdx.map(x => x.v),
            backgroundColor: sortedIdx.map(x =>
                x.v >= 70 ? 'rgba(34,197,94,.82)' :
                x.v >= 50 ? 'rgba(245,158,11,.82)' :
                x.v >= 30 ? 'rgba(249,115,22,.82)' : 'rgba(239,68,68,.82)'
            ),
            borderRadius: 4,
            borderSkipped: false,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${Number(c.parsed.x).toFixed(1)}%` } }
        },
        scales: {
            x: { min: 0, max: 100, ticks: { callback: v => v + '%' }, grid: { color: 'rgba(0,0,0,.05)' } },
            y: { ticks: { font: { size: 10, weight: '600' } }, grid: { display: false } }
        }
    }
});

// ── Tren per Indikator ─────────────────────────────────────────────────────
let trenChart = null;

function updateTren(id) {
    const d = trenAllData[id];
    if (!d) return;

    const colors = d.data.map(v =>
        v >= 70 ? 'rgba(34,197,94,.9)' :
        v >= 50 ? 'rgba(245,158,11,.9)' :
        v >= 30 ? 'rgba(249,115,22,.9)' : 'rgba(239,68,68,.9)'
    );

    if (trenChart) trenChart.destroy();
    trenChart = new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: namaBulan,
            datasets: [{
                label: `${d.kode} — ${d.label}`,
                data: d.data,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 2.5,
            }, {
                label: 'Target 70%',
                data: Array(12).fill(70),
                borderColor: 'rgba(239,68,68,.45)',
                borderDash: [6, 4],
                borderWidth: 1.5,
                pointRadius: 0,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 11 }, boxWidth: 12 } },
                tooltip: { callbacks: { label: c => ` ${c.dataset.label}: ${Number(c.parsed.y).toFixed(1)}%` } }
            },
            scales: {
                y: { min: 0, max: 100, ticks: { callback: v => v + '%' }, grid: { color: 'rgba(0,0,0,.05)' } },
                x: { grid: { display: false } }
            }
        }
    });
}

// Inisialisasi tren dengan indikator pertama
const firstId = Object.keys(trenAllData)[0];
if (firstId) updateTren(firstId);
</script>
@endsection