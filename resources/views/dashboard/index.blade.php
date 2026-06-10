{{-- resources/views/dashboard/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard PHBS – SIP-PHBS Kab. Sleman</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<style>
/* ─── Overrides kecil yang spesifik untuk halaman ini ─── */
body{min-height:100vh;display:block;}
.main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;}
/* .section yang masih pakai padding kiri-kanan sendiri */
.section{padding:20px 28px 0;}
.charts-grid{padding:20px 0 0;}
.info-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;padding:20px 0 0;}
/* Stat cards distribusi (4 kolom) */
.dist-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;padding:20px 0 0;}
.dist-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);
    padding:18px 20px;box-shadow:var(--shadow);display:flex;align-items:center;gap:14px;
    transition:transform .2s,box-shadow .2s;}
.dist-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.dist-ico{width:44px;height:44px;border-radius:12px;flex-shrink:0;display:flex;align-items:center;justify-content:center;}
.dist-body .lbl{font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:var(--text-muted);margin-bottom:4px;}
.dist-body .val{font-size:28px;font-weight:800;font-family:'JetBrains Mono',monospace;letter-spacing:-1px;color:var(--text);line-height:1;}
.dist-body .sub{font-size:11px;color:var(--text-muted);margin-top:3px;}
/* Matriks min-width */
.mtx-table{min-width:1100px;}
/* Chart tren full-width */
.tren-wrap{padding:20px 0 0;}
/* Badge target pada rekap indikator */
.target-dot{display:inline-block;width:7px;height:7px;border-radius:50%;background:var(--red);margin-right:4px;}
@media(max-width:1100px){.dist-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:900px){
    .sidebar{display:none;}
    .main{margin-left:0;}
    .info-grid-3,.charts-grid,.dist-grid{grid-template-columns:1fr;}
    .hero{flex-direction:column;}.hero-right{width:100%;}
}
</style>
</head>
<body>

@php
    $authUser = auth()->user();
    $userName = $authUser->name ?? 'Admin Dinkes';
    $userRole = ucfirst($authUser->role->role ?? $authUser->role ?? 'Dinkes');
@endphp

{{-- ══════════════ SIDEBAR ══════════════ --}}
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-logo">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
            </svg>
        </div>
        <div class="sb-name">
            <strong>SIP-PHBS</strong>
            <span>Sistem Informasi Pelaporan PHBS</span>
        </div>
    </div>

    <div class="sb-section">
        <span class="sb-label">Menu Utama</span>

        <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>

        <a href="{{ \Illuminate\Support\Facades\Route::has('peta.index') ? route('peta.index') : '#' }}"
           class="sb-item {{ request()->routeIs('peta.index') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Peta Distribusi
        </a>

        <a href="{{ \Illuminate\Support\Facades\Route::has('phbs.index') ? route('phbs.index') : '#' }}"
           class="sb-item {{ request()->routeIs('phbs.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            Laporan Rekapitulasi
        </a>

        <a href="{{ \Illuminate\Support\Facades\Route::has('puskesmas.index') ? route('puskesmas.index') : '#' }}"
           class="sb-item {{ request()->routeIs('puskesmas.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Data Puskesmas
        </a>
    </div>

    <div class="sb-section">
        <span class="sb-label">Akun</span>
        <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('logout') ? route('logout') : '#' }}">
            @csrf
            <button type="submit" class="sb-item">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr($userName, 0, 1)) }}</div>
            <div class="sb-user-info">
                <strong>{{ $userName }}</strong>
                <span>{{ $userRole }} &bull; SIP-PHBS</span>
            </div>
        </div>
    </div>
</aside>

{{-- ══════════════ MAIN ══════════════ --}}
<main class="main">

    {{-- ── HERO ─────────────────────────────────────────────────── --}}
    <div class="hero">
        <div class="hero-left">
            <div class="hero-title">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard PHBS
            </div>
            <p class="hero-desc">
                Pemantauan capaian 13 indikator PHBS berdasarkan laporan puskesmas pada periode terpilih.
                Dinas Kesehatan Kabupaten Sleman.
            </p>
            <div class="hero-badges">
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $bulan ? \App\Models\NewDataPHBS::namaBulan($bulan) : 'Semua Bulan' }} {{ $tahun }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                    {{ $id_puskesmas ? ($puskesmasList->firstWhere('id_puskesmas', $id_puskesmas)?->nama_puskesmas ?? 'Terpilih') : 'Semua Puskesmas' }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    {{ $allIndikators->count() }} Indikator PHBS
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{-- {{ $statusTerkirim }}  --}}
                    Laporan Terkirim
                </span>
            </div>
        </div>

        <div class="hero-right">
            <div class="rata-card">
                <div class="rata-label">Rata-rata Ber-PHBS Periode Ini</div>
                <div class="rata-value">{{ number_format($rataRataPhbs, 1) }}<span style="font-size:22px;letter-spacing:0">%</span></div>
                <div class="rata-bar">
                    <div class="rata-fill" style="width:{{ min($rataRataPhbs, 100) }}%"></div>
                </div>
                <div class="rata-sub">
                    {{-- Target nasional: {{ number_format($targetNasional, 0) }}% &bull;
                    @if($rataRataPhbs >= $targetNasional)
                        <span style="color:#86efac">✓ Tercapai</span>
                    @else
                        <span style="color:#fca5a5">Perlu peningkatan</span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>{{-- /hero --}}

    {{-- ── FILTER ────────────────────────────────────────────────── --}}
    <div class="filter-section">
        <div class="filter-title">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM6 10a1 1 0 011-1h10a1 1 0 010 2H7a1 1 0 01-1-1zM9 16a1 1 0 011-1h4a1 1 0 010 2h-4a1 1 0 01-1-1z"/>
            </svg>
            Filter Dashboard
        </div>
        <p class="filter-desc">Pilih tahun, bulan, atau puskesmas untuk menampilkan data sesuai kebutuhan.</p>

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
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    Terapkan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M4 4v5h.582M20 20v-5h-.581M4.582 9A8 8 0 0119.418 15M19.419 15H15m4.419 0v4.419"/></svg>
                    Reset
                </a>
            </div>
        </form>
    </div>{{-- /filter --}}

    <div class="page-wrap">

        {{-- ── 4 DISTRIBUSI STAT CARDS ───────────────────────────── --}}
        <div class="dist-grid">
            <div class="dist-card">
                <div class="dist-ico" style="background:#dcfce7;color:#15803d;">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="dist-body">
                    <div class="lbl">Tinggi ≥ 70%</div>
                    <div class="val">{{ $distribusiTinggi }}</div>
                    <div class="sub">Puskesmas</div>
                </div>
            </div>
            <div class="dist-card">
                <div class="dist-ico" style="background:#fef9c3;color:#a16207;">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="dist-body">
                    <div class="lbl">Sedang 50–69%</div>
                    <div class="val">{{ $distribusiSedang }}</div>
                    <div class="sub">Puskesmas</div>
                </div>
            </div>
            <div class="dist-card">
                <div class="dist-ico" style="background:#ffedd5;color:#c2410c;">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="dist-body">
                    <div class="lbl">Rendah 30–49%</div>
                    <div class="val">{{ $distribusiRendah }}</div>
                    <div class="sub">Puskesmas</div>
                </div>
            </div>
            <div class="dist-card">
                <div class="dist-ico" style="background:#fee2e2;color:#b91c1c;">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="dist-body">
                    <div class="lbl">Sangat Rendah &lt;30%</div>
                    <div class="val">{{ $distribusiSangatRendah }}</div>
                    <div class="sub">Puskesmas</div>
                </div>
            </div>
        </div>

        {{-- ── 3 INFO CARDS ──────────────────────────────────────── --}}
        <div class="info-grid-3">
            <div class="info-card">
                <div class="info-icon green">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Puskesmas Terbaik</div>
                    <div class="info-value">{{ $puskesmasTertinggi?->nama_puskesmas ?? 'Belum ada data' }}</div>
                    <div class="info-sub">
                        @if($puskesmasTertinggi)
                            {{ number_format((float)$puskesmasTertinggi->persentase_phbs, 1) }}% capaian Ber-PHBS tertinggi
                        @else
                            Belum ada laporan pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon red">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Perlu Perhatian</div>
                    <div class="info-value">{{ $puskesmasTerendah?->nama_puskesmas ?? 'Belum ada data' }}</div>
                    <div class="info-sub">
                        @if($puskesmasTerendah)
                            {{ number_format((float)$puskesmasTerendah->persentase_phbs, 1) }}% – capaian terendah
                        @else
                            Belum ada laporan pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon amber">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Status Laporan</div>
                    <div class="info-value">
                        {{-- {{ $statusTerkirim }} terkirim &bull; {{ $statusDraft }} draft --}}draft</div>
                    <div class="info-sub">Total 
                        {{-- {{ $statusTerkirim + $statusDraft }} --}}
                         laporan masuk pada periode terpilih.</div>
                </div>
            </div>
        </div>

        {{-- ── CHARTS (Bar + Donut) ──────────────────────────────── --}}
        <div class="charts-grid" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="card-title">Capaian Ber-PHBS per Puskesmas</span>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <div style="height:260px;"><canvas id="chartBar"></canvas></div>
                <div class="legend" style="margin-top:12px;">
                    <div class="legend-item"><div class="legend-dot" style="background:#22c55e"></div>Tinggi ≥70%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f59e0b"></div>Sedang 50–69%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#f97316"></div>Rendah 30–49%</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#ef4444"></div>Sangat Rendah</div>
                </div>
            </div>

            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 010 20"/>
                        </svg>
                        <span class="card-title">Distribusi Capaian</span>
                    </div>
                    <span class="card-badge">{{ $rekapData->count() }} PKM</span>
                </div>
                <div style="height:200px;display:flex;justify-content:center;">
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

        {{-- ── TREN BULANAN (full width) ─────────────────────────── --}}
        @if(count($trenLabels) > 0)
        <div class="tren-wrap">
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M3 3v18h18M7 16l4-4 4 4 4-4"/>
                        </svg>
                        <span class="card-title">Tren Rata-rata Capaian PHBS per Bulan</span>
                    </div>
                    <span class="card-badge">Tahun {{ $tahun }}</span>
                </div>
                <div style="height:200px;"><canvas id="chartTren"></canvas></div>
            </div>
        </div>
        @endif

        {{-- ── REKAP PER PUSKESMAS ───────────────────────────────── --}}
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <div>
                            <div class="section-title">Rekapitulasi Ber-PHBS per Puskesmas</div>
                            <div class="section-sub">Diurutkan berdasarkan capaian tertinggi &bull; Tahun {{ $tahun }}</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $rekapData->count() }} puskesmas</span>
                </div>
                <div class="table-wrap">
                    @if($rekapData->isEmpty())
                        <div class="empty">
                            <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p>Tidak ada data sesuai filter yang dipilih.</p>
                        </div>
                    @else
                    <table class="rkp-table">
                        <thead>
                            <tr>
                                <th style="width:32px;">#</th>
                                <th>Nama Puskesmas</th>
                                <th>Kecamatan</th>
                                <th>Kepala Puskesmas</th>
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
                                    $pct = (float)$row->persentase_phbs;
                                    [$lvl,$bdg,$pg] = match(true){
                                        $pct>=70 => ['Tinggi',      'b-tinggi',       'pg-green'],
                                        $pct>=50 => ['Sedang',      'b-sedang',       'pg-amber'],
                                        $pct>=30 => ['Rendah',      'b-rendah',       'pg-orange'],
                                        default  => ['Sangat Rendah','b-sangatrendah','pg-red'],
                                    };
                                @endphp
                                <tr>
                                    <td><div class="rank {{ $i===0?'rk-1':($i===1?'rk-2':'rk-n') }}">{{ $i+1 }}</div></td>
                                    <td style="font-weight:600;color:var(--text);">{{ $row->nama_puskesmas }}</td>
                                    <td>{{ $row->kecamatan ?? '-' }}</td>
                                    <td>{{ $row->kepala_puskesmas ?? '-' }}</td>
                                    <td class="r">{{ number_format($row->jumlah_laporan) }}</td>
                                    <td class="r">{{ number_format($row->total_kk) }}</td>
                                    <td class="r">{{ number_format($row->total_ber_phbs) }}</td>
                                    <td>
                                        <div class="prog-wrap">
                                            <div class="prog-bar"><div class="prog-fill {{ $pg }}" style="width:{{ min($pct,100) }}%;"></div></div>
                                            <span class="prog-pct">{{ number_format($pct,1) }}%</span>
                                        </div>
                                    </td>
                                    <td style="text-align:center;"><span class="badge {{ $bdg }}">{{ $lvl }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── REKAP PER INDIKATOR ────────────────────────────────── --}}
        @if(count($rekapIndikator) > 0)
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <div>
                            <div class="section-title">Rekapitulasi per Indikator PHBS</div>
                            <div class="section-sub">Akumulasi seluruh puskesmas, hanya laporan terkirim &bull; Tahun {{ $tahun }}</div>
                        </div>
                    </div>
                </div>
                <div class="table-wrap">
                    <table class="rkp-table">
                        <thead>
                            <tr>
                                <th style="width:40px;text-align:center;">No</th>
                                <th>Kode</th>
                                <th>Nama Indikator</th>
                                <th class="r">Sasaran</th>
                                <th class="r">Capaian</th>
                                <th style="min-width:200px;">Persentase</th>
                                <th style="text-align:center;">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapIndikator as $no => $ind)
                                @php
                                    $pct = (float)$ind['persentase'];
                                    [$lvl,$bdg,$pg] = match(true){
                                        $pct>=70 => ['Tinggi',       'b-tinggi',       'pg-green'],
                                        $pct>=50 => ['Sedang',       'b-sedang',       'pg-amber'],
                                        $pct>=30 => ['Rendah',       'b-rendah',       'pg-orange'],
                                        default  => ['Sangat Rendah','b-sangatrendah', 'pg-red'],
                                    };
                                    // $target = (float)($ind['target'] ?? 70);
                                @endphp
                                <tr>
                                    <td style="text-align:center;font-weight:600;color:var(--text-muted);">{{ $no }}</td>
                                    <td><code style="font-size:11px;background:var(--bg);padding:2px 6px;border-radius:4px;">{{ $ind['kode'] }}</code></td>
                                    <td style="font-weight:500;color:var(--text);max-width:280px;white-space:normal;line-height:1.4;">{{ $ind['label'] }}</td>
                                    <td class="r">{{ $ind['total_sasaran'] > 0 ? number_format($ind['total_sasaran']) : '-' }}</td>
                                    <td class="r">{{ $ind['total_jumlah'] > 0 ? number_format($ind['total_jumlah']) : '-' }}</td>
                                    <td>
                                        @if($ind['total_sasaran'] > 0)
                                        <div class="prog-wrap">
                                            <div class="prog-bar" style="position:relative;">
                                                <div class="prog-fill {{ $pg }}" style="width:{{ min($pct,100) }}%;"></div>
                                                {{-- garis target --}}
                                                {{-- <div style="position:absolute;top:0;bottom:0;left:{{ min($target,100) }}%;width:1.5px;background:rgba(239,68,68,.5);"></div> --}}
                                            </div>
                                            <span class="prog-pct">{{ number_format($pct,1) }}%</span>
                                        </div>
                                        <div style="font-size:10px;color:var(--text-muted);margin-top:3px;">
                                            {{-- <span class="target-dot"></span>Target: {{ number_format($target,0) }}% --}}
                                        </div>
                                        @else
                                            <span style="color:var(--text-muted);font-size:12px;">Belum ada data</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if($ind['total_sasaran'] > 0)
                                            <span class="badge {{ $bdg }}">{{ $lvl }}</span>
                                        @else
                                            <span class="badge b-draft">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- ── MATRIKS 13 INDIKATOR ─────────────────────────────── --}}
        @if($matriksData->isNotEmpty())
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
                        </svg>
                        <div>
                            <div class="section-title">Matriks {{ $allIndikators->count() }} Indikator PHBS per Puskesmas</div>
                            <div class="section-sub">Persentase capaian setiap indikator PHBS per puskesmas &bull; Tahun {{ $tahun }}</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $matriksData->count() }} puskesmas</span>
                </div>
                <div class="table-wrap">
                    <table class="mtx-table">
                        <thead>
                            <tr>
                                <th>Puskesmas</th>
                                <th class="c">Lap.</th>
                                <th class="c">Rata-rata</th>
                                @foreach($allIndikators as $ind)
                                    <th class="c" title="{{ $ind->nama_indikator }}">I{{ $ind->id_indikator }}</th>
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
                                        {{ $rr > 0 ? number_format($rr,0).'%' : '-' }}
                                    </span>
                                </td>
                                @foreach($allIndikators as $ind)
                                    @php $i = $ind->id_indikator; $pct = (float)($row->{"ind{$i}_pct"} ?? 0); @endphp
                                    <td class="c">
                                        <span class="ic {{ $pct>=70?'ic-h':($pct>=50?'ic-m':($pct>=30?'ic-l':($pct>0?'ic-v':'ic-n'))) }}">
                                            {{ $pct > 0 ? number_format($pct,0).'%' : '-' }}
                                        </span>
                                    </td>
                                @endforeach
                                <td class="c">
                                    <span class="ic ic-v" title="{{ $row->ind_terendah_pct }}%">{{ $row->ind_terendah }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="legend" style="padding:12px 20px;border-top:1px solid var(--border);">
                    <span style="font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:#dcfce7;color:#15803d;">Tinggi ≥70%</span>
                    <span style="font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:#fef9c3;color:#a16207;">Sedang 50–69%</span>
                    <span style="font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:#ffedd5;color:#c2410c;">Rendah 30–49%</span>
                    <span style="font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:#fee2e2;color:#b91c1c;">Sangat Rendah &lt;30%</span>
                    <span style="font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:#f1f5f9;color:#94a3b8;">Belum ada data</span>
                </div>
            </div>
        </div>
        @endif

        <div class="footer">
            SIP-PHBS &mdash; Dinas Kesehatan Kabupaten Sleman &copy; {{ date('Y') }}
        </div>

    </div>{{-- /page-wrap --}}
</main>

{{-- ══════════════ CHARTS JS ══════════════ --}}
<script>
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color       = '#94a3b8';
Chart.defaults.borderColor = '#e2e8f0';

const barLabels  = @json($grafikLabels);
const barData    = @json($grafikData);
const barColors  = @json($grafikColors);
const pieData    = [{{ $distribusiTinggi }}, {{ $distribusiSedang }}, {{ $distribusiRendah }}, {{ $distribusiSangatRendah }}];
const trenLabels = @json($trenLabels);
const trenData   = @json($trenData);


// ── Bar chart: capaian per puskesmas ──────────────────────────────────────
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
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${Number(c.parsed.y).toFixed(1)}%` } }
        },
        scales: {
            x: { ticks: { font: { size: 10 }, maxRotation: 40 }, grid: { display: false } },
            y: {
                min: 0, max: 100,
                ticks: { callback: v => v + '%' },
                grid: { color: 'rgba(0,0,0,.04)' }
            }
        }
    }
});

// ── Doughnut: distribusi ──────────────────────────────────────────────────
new Chart(document.getElementById('chartPie'), {
    type: 'doughnut',
    data: {
        labels: ['Tinggi (≥70%)', 'Sedang (50–69%)', 'Rendah (30–49%)', 'Sangat Rendah (<30%)'],
        datasets: [{
            data: pieData,
            backgroundColor: ['rgba(34,197,94,.85)','rgba(245,158,11,.85)','rgba(249,115,22,.85)','rgba(239,68,68,.85)'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '62%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.label}: ${c.parsed} puskesmas` } }
        }
    }
});

// ── Line chart: tren bulanan ──────────────────────────────────────────────
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
                backgroundColor: 'rgba(37,99,235,.07)',
                fill: true, tension: .4,
                pointBackgroundColor: '#2563eb',
                pointRadius: 4, pointHoverRadius: 6, borderWidth: 2.5
            },
            {
                // label: `Target Nasional (${target}%)`,
                // data: Array(trenLabels.length).fill(target),
                // borderColor: 'rgba(239,68,68,.55)',
                // borderDash: [6, 4], borderWidth: 1.5,
                // pointRadius: 0, fill: false
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { font: { size: 12 }, boxWidth: 12 } },
            tooltip: { callbacks: { label: c => ` ${c.dataset.label}: ${Number(c.parsed.y).toFixed(1)}%` } }
        },
        scales: {
            y: {
                min: 0, max: 100,
                ticks: { callback: v => v + '%' },
                grid: { color: 'rgba(0,0,0,.04)' }
            }
        }
    }
});
@endif
</script>
</body>
</html>