@extends('layouts.sidebar')
@section('title','Dashboard - SIP-PHBS')
@section('content')
{{-- ══════════════════════ MAIN ══════════════════════ --}}
<main class="main">

    {{-- ─── HERO ─────────────────────────────────────────────────────── --}}
    <div class="hero">
        <div class="hero-left">
            <div class="hero-title">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard PHBS — {{ Auth::user()->puskesmas->nama_puskesmas ?? 'Puskesmas' }}
            </div>
            <p class="hero-desc">
                Pemantauan capaian 13 indikator Perilaku Hidup Bersih dan Sehat (PHBS)
                untuk wilayah kerja {{ Auth::user()->puskesmas->nama_puskesmas ?? 'puskesmas' }}.
            </p>
            <div class="hero-badges">
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $bulan ? \App\Models\NewDataPHBS::namaBulan($bulan) : 'Semua Bulan' }} {{ $tahun }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                    {{ Auth::user()->puskesmas->kecamatan->nama_kecamatan ?? 'Kecamatan' }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    13 Indikator PHBS
                </span>
            </div>
        </div>

        <div class="hero-right">
            <div class="rata-card">
                <div class="rata-label">Capaian Ber-PHBS</div>
                <div class="rata-value">
                    {{ number_format($rataRataPhbs ?? 0, 1) }}<span style="font-size:20px">%</span>
                </div>
                <div class="rata-bar">
                    <div class="rata-fill" style="width:{{ min($rataRataPhbs ?? 0, 100) }}%"></div>
                </div>
                <div class="rata-sub">
                    @if($rataRataPhbs >= 80)
                        <span style="color:#16a34a">✓ Sangat Baik</span>
                    @elseif($rataRataPhbs >= 60)
                        <span style="color:#2563eb">✓ Baik</span>
                    @else
                        <span style="color:#f59e0b">⚠ Perlu Ditingkatkan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ─── FILTER ───────────────────────────────────────────────────── --}}
    <div class="filter-section">
        <div class="filter-title">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM6 10a1 1 0 011-1h10a1 1 0 010 2H7a1 1 0 01-1-1zM9 16a1 1 0 011-1h4a1 1 0 010 2h-4a1 1 0 01-1-1z"/>
            </svg>
            Filter Dashboard
        </div>
        <p class="filter-desc">Pilih tahun atau bulan untuk menyesuaikan data yang ditampilkan.</p>

        <form method="GET" action="{{ route('dashboard') }}">
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

                <button type="submit" class="btn btn-primary" style="margin-top:auto;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    Terapkan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">Reset</a>
            </div>
        </form>
    </div>

    {{-- ══════════════ PAGE WRAP ══════════════ --}}
    <div class="page-wrap">

        {{-- ─── INFO CARDS (4 kolom) ─────────────────────────────────── --}}
        <div class="info-grid">

            {{-- Total Keluarga --}}
            <div class="info-card">
                <div class="info-icon blue">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Total Keluarga</div>
                    <div class="info-value">{{ number_format($totalKeluarga ?? 0) }}</div>
                    <div class="info-sub">
                        KK Laki: {{ number_format($kkLaki ?? 0) }} · KK Perempuan: {{ number_format($kkPerempuan ?? 0) }}
                    </div>
                </div>
            </div>

            {{-- Keluarga Ber-PHBS --}}
            <div class="info-card">
                <div class="info-icon green">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Keluarga Ber-PHBS</div>
                    <div class="info-value">{{ number_format($keluargaBerPhbs ?? 0) }}</div>
                    <div class="info-sub">
                        {{ number_format($persentasePhbs ?? 0, 1) }}% dari total keluarga
                    </div>
                </div>
            </div>

            {{-- Keluarga Belum Ber-PHBS --}}
            <div class="info-card">
                <div class="info-icon amber">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Belum Ber-PHBS</div>
                    <div class="info-value">{{ number_format(($totalKeluarga ?? 0) - ($keluargaBerPhbs ?? 0)) }}</div>
                    <div class="info-sub">
                        {{ number_format(100 - ($persentasePhbs ?? 0), 1) }}% masih perlu bantuan
                    </div>
                </div>
            </div>

            {{-- Status Laporan --}}
            <div class="info-card">
                <div class="info-icon sky">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Status Pengisian</div>
                    <div class="info-value">{{ $dataLengkap ? 'Lengkap' : 'Belum Lengkap' }}</div>
                    <div class="info-sub">
                        @if($dataLengkap)
                            <span style="color:#16a34a">✓ Semua indikator terisi</span>
                        @else
                            <span style="color:#f59e0b">⚠ Masih ada yang belum diisi</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ─── CHARTS & TABLES ─────────────────────────────────────── --}}
        <div class="charts-grid">

            {{-- Chart Trend Ber-PHBS --}}
            <div class="card chart-card">
                <div class="card-head">
                    <div>
                        <h3 class="card-title">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            Trend Ber-PHBS
                        </h3>
                        <p class="card-desc">Pergeseran capaian Ber-PHBS per bulan dalam tahun ini</p>
                    </div>
                </div>
                <div id="chartTrendContainer" style="position:relative;height:320px;">
                    <canvas id="chartTrend"></canvas>
                </div>
            </div>

            {{-- Chart Rasio KK Ber-PHBS vs Belum --}}
            <div class="card chart-card">
                <div class="card-head">
                    <div>
                        <h3 class="card-title">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Komposisi Keluarga
                        </h3>
                        <p class="card-desc">Perbandingan keluarga ber-PHBS dan belum ber-PHBS</p>
                    </div>
                </div>
                <div id="chartRasioContainer" style="position:relative;height:320px;">
                    <canvas id="chartRasio"></canvas>
                </div>
            </div>

        </div>

        {{-- ─── TABEL INDIKATOR ──────────────────────────────────────── --}}
        <div class="card table-card">
            <div class="card-head">
                <div>
                    <h3 class="card-title">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        13 Indikator PHBS
                    </h3>
                    <p class="card-desc">Capaian setiap indikator pada periode terpilih</p>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Indikator</th>
                            <th>Target</th>
                            <th>Capaian</th>
                            <th>Persentase</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indicators as $idx => $ind)
                            <tr>
                                <td><strong>{{ $idx + 1 }}</strong></td>
                                <td><strong>{{ $ind['kode'] ?? 'PHB-' . str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ $ind['nama'] ?? 'Indikator ' . ($idx + 1) }}</td>
                                <td class="text-right">{{ number_format($ind['target'] ?? 0) }}</td>
                                <td class="text-right"><strong>{{ number_format($ind['capaian'] ?? 0) }}</strong></td>
                                <td class="text-right">
                                    <strong>{{ number_format($ind['persentase'] ?? 0, 1) }}%</strong>
                                </td>
                                <td>
                                    @php
                                        $pct = $ind['persentase'] ?? 0;
                                        if ($pct >= 100) $status = ['label' => 'Tercapai', 'color' => 'green'];
                                        elseif ($pct >= 80) $status = ['label' => 'Baik', 'color' => 'sky'];
                                        elseif ($pct >= 60) $status = ['label' => 'Cukup', 'color' => 'amber'];
                                        else $status = ['label' => 'Kurang', 'color' => 'red'];
                                    @endphp
                                    <span class="badge badge-{{ $status['color'] }}">{{ $status['label'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:24px;color:#94a3b8;">
                                    Belum ada data untuk periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ─── PROGRESS INDIKATOR ──────────────────────────────────── --}}
        <div class="card">
            <div class="card-head">
                <div>
                    <h3 class="card-title">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                        Progress Per Indikator
                    </h3>
                    <p class="card-desc">Visualisasi pencapaian masing-masing indikator PHBS</p>
                </div>
            </div>

            <div class="progress-grid">
                @forelse($indicators as $idx => $ind)
                    <div class="progress-item">
                        <div class="progress-header">
                            <span class="progress-label">
                                {{ $ind['kode'] ?? 'PHB-' . str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="progress-value">
                                {{ number_format($ind['persentase'] ?? 0, 1) }}%
                            </span>
                        </div>
                        <div class="progress-bar">
                            @php
                                $pct = min($ind['persentase'] ?? 0, 100);
                                if ($pct >= 100) $bgColor = '#16a34a';
                                elseif ($pct >= 80) $bgColor = '#0ea5e9';
                                elseif ($pct >= 60) $bgColor = '#f59e0b';
                                else $bgColor = '#ef4444';
                            @endphp
                            <div class="progress-fill" style="width:{{ $pct }}%; background-color:{{ $bgColor }};"></div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:24px;color:#94a3b8;">
                        Belum ada data untuk periode ini
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</main>



{{-- ════════════════════ SCRIPTS ════════════════════ --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// Data dari PHP
const trendData = @json($trendData ?? []);
const rasioData = @json($rasioData ?? []);
const indicators = @json($indicators ?? []);

// Chart instances
let chartTrend = null;
let chartRasio = null;

// Initialize charts on load
document.addEventListener('DOMContentLoaded', function() {
    initChartTrend();
    initChartRasio();
});

// Chart Trend Ber-PHBS
function initChartTrend() {
    const ctx = document.getElementById('chartTrend').getContext('2d');
    
    const labels = trendData.map(d => d.bulan || '');
    const data = trendData.map(d => parseFloat(d.persentase) || 0);
    
    if (chartTrend) chartTrend.destroy();
    
    chartTrend = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Persentase Ber-PHBS (%)',
                data: data,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(v) { return v + '%'; }
                    }
                }
            }
        }
    });
}

// Chart Rasio KK Ber-PHBS vs Belum
function initChartRasio() {
    const ctx = document.getElementById('chartRasio').getContext('2d');
    
    const labels = rasioData.map(d => d.bulan || '');
    const berPhbsData = rasioData.map(d => parseInt(d.ber_phbs) || 0);
    const belumPhbsData = rasioData.map(d => (parseInt(d.total) || 0) - (parseInt(d.ber_phbs) || 0));
    
    if (chartRasio) chartRasio.destroy();
    
    chartRasio = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Ber-PHBS',
                    data: berPhbsData,
                    backgroundColor: '#16a34a',
                },
                {
                    label: 'Belum Ber-PHBS',
                    data: belumPhbsData,
                    backgroundColor: '#f3f4f6',
                }
            ]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true }
            }
        }
    });
}

</script>

@endsection