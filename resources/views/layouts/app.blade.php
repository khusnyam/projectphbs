<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peta Wilayah Kerja Puskesmas')</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        :root {
             /* IKEA THEME */
             --bg-dark:      #f5f7fb;
             --bg-card:      #ffffff;
             --bg-card2:     #eef3ff;
             --border:       #d6e0f5;
             --border-light: #b8c9ee;
             
             --text-primary: #003399;
             --text-muted:   #6b7280;
             --text-dim:     #94a3b8;
             
             --accent:       #FFCC00;
             --accent-dark:  #e6b800;
             
             --accent-glow:  rgba(255,204,0,.18);
             
             --merah:   #ef4444;
             --oranye:  #f97316;
             --kuning:  #FFCC00;
             --hijau:   #22c55e;
            }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-dark); color: var(--text-primary);
            height: 100vh; overflow: hidden; display: flex; flex-direction: column;
        }

        /* ── HEADER ── */
        .app-header {
            background: var(--bg-card); border-bottom: 1px solid var(--border);
            padding: 0 1.25rem; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0; z-index: 1000; gap: 1rem;
        }
        .header-brand { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg,#003399,#1d4ed8);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: .9rem; box-shadow: 0 0 14px rgba(56,189,248,.3);
        }
        .brand-text h1 { font-size: .9rem; font-weight: 700; letter-spacing: -.01em; }
        .brand-text p  { font-size: .65rem; color: var(--text-muted); font-family: 'Roboto Mono',monospace; }

        /* ── PERIODE SELECTOR ── */
        .periode-bar {
            display: flex; align-items: center; gap: .6rem;
            background: var(--bg-card2); border: 1px solid var(--border);
            border-radius: 8px; padding: .35rem .75rem;
            flex-shrink: 0;
        }
        .periode-label {
            font-size: .68rem; font-weight: 600; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .06em; white-space: nowrap;
        }
        .periode-select {
            background: var(--bg-dark); border: 1px solid var(--border-light);
            border-radius: 5px; color: var(--text-primary);
            font-family: 'Roboto Mono', monospace; font-size: .78rem; font-weight: 600;
            padding: .25rem .5rem; outline: none; cursor: pointer; transition: border-color .2s;
        }
        .periode-select:focus { border-color: var(--accent); }
        .periode-divider { color: var(--border-light); font-size: .8rem; }

        /* Bulan nav arrows */
        .btn-nav {
            background: none; border: 1px solid var(--border);
            border-radius: 5px; color: var(--text-dim); cursor: pointer;
            width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;
            font-size: .7rem; transition: all .15s; flex-shrink: 0;
        }
        .btn-nav:hover:not(:disabled) { border-color: var(--accent); color: var(--accent); }
        .btn-nav:disabled { opacity: .3; cursor: default; }

        /* Button close */
        .btn-close{
            width:35px;
            height:35px;
            border:none;
            border-radius:50%;
            background:#dc3545;
            color:white;
            font-size:22px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            transition:0.3s;
        }

        .btn-close:hover{
            transform:scale(1.1);
        }

        /* Active badge */
        .periode-active {
            font-size: .72rem; font-weight: 700; font-family: 'Roboto Mono',monospace;
            color: var(--accent); background: var(--accent-glow);
            border: 1px solid rgba(56,189,248,.25); border-radius: 5px;
            padding: .2rem .55rem; white-space: nowrap;
        }

        .header-stats { display: flex; gap: 1.25rem; flex-shrink: 0; }
        .stat-badge { display: flex; flex-direction: column; align-items: flex-end; }
        .stat-badge .val { font-size: .9rem; font-weight: 700; color: var(--accent); font-family: 'Roboto Mono',monospace; }
        .stat-badge .lbl { font-size: .6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .04em; }

        /* ── BODY / SIDEBAR / MAP ── */
        .app-body { display: flex; flex: 1; overflow: hidden; }
        .sidebar {
            width: 295px; background: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column; flex-shrink: 0; overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,.05);
        }
        .sidebar-section { padding: 1rem; border-bottom: 1px solid var(--border); }
        .sidebar-title {
            font-size: .68rem; font-weight: 600; letter-spacing: .08em;
            text-transform: uppercase; color: var(--text-muted);
            margin-bottom: .75rem; display: flex; align-items: center; gap: .4rem;
        }
        .kategori-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
        .kategori-card {
            background: var(--bg-card2); border: 1px solid var(--border);
            border-radius: 8px; padding: .6rem .75rem; cursor: pointer; transition: all .2s;
        }
        .kategori-card:hover { border-color: var(--border-light); transform: translateY(-1px); }
        .kategori-card .dot  { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: .4rem; }
        .kategori-card .num  { font-size: 1.3rem; font-weight: 800; font-family: 'Roboto Mono',monospace; display: block; }
        .kategori-card .label { font-size: .62rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .04em; }
        .merah-card  .num { color: var(--merah);  } .merah-card  .dot { background: var(--merah);  }
        .oranye-card .num { color: var(--oranye); } .oranye-card .dot { background: var(--oranye); }
        .kuning-card .num { color: var(--kuning); } .kuning-card .dot { background: var(--kuning); }
        .hijau-card  .num { color: var(--hijau);  } .hijau-card  .dot { background: var(--hijau);  }

        .search-box { position: relative; }
        .search-box input {
            width: 100%; background: var(--bg-card2); border: 1px solid var(--border);
            border-radius: 8px; padding: .5rem .75rem .5rem 2.2rem;
            color: var(--text-primary); font-size: .78rem; font-family: inherit; outline: none; transition: border-color .2s;
        }
        .search-box input:focus { border-color: var(--accent); }
        .search-box input::placeholder { color: var(--text-muted); }
        .search-box .search-icon { position: absolute; left: .7rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: .72rem; }

        .puskesmas-list { flex: 1; overflow-y: auto; padding: .4rem; }
        .puskesmas-list::-webkit-scrollbar { width: 4px; }
        .puskesmas-list::-webkit-scrollbar-track { background: transparent; }
        .puskesmas-list::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 2px; }

        .pkm-item {
            display: flex; align-items: center; gap: .7rem;
            padding: .55rem .7rem; border-radius: 7px; cursor: pointer;
            transition: background .15s; margin-bottom: 2px;
        }
        .pkm-item:hover { background: var(--bg-card2); }
        .pkm-item.active {background: #fff8d6;box-shadow: inset 4px 0 0 var(--accent);}
        .pkm-color-bar { width: 4px; height: 30px; border-radius: 2px; flex-shrink: 0; }
        .pkm-info { flex: 1; min-width: 0; }
        .pkm-name { font-size: .78rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .pkm-sub  { font-size: .66rem; color: var(--text-muted); display: flex; gap: .4rem; margin-top: 1px; }
        .pkm-pct  { font-size: .72rem; font-weight: 700; font-family: 'Roboto Mono',monospace; flex-shrink: 0; }
        .pct-bar  { height: 2px; background: var(--border); border-radius: 1px; margin-top: 3px; overflow: hidden; }
        .pct-fill { height: 100%; border-radius: 1px; transition: width .4s ease; }

        /* ── MAP ── */
        .map-container { flex: 1; position: relative; }
        #map { width: 100%; height: 100%; }

        .map-legend {
            position: absolute; bottom: 2rem; right: 1rem; z-index: 500;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 10px; padding: .85rem 1.1rem; min-width: 155px;
        }
        .legend-title { font-size: .63rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); margin-bottom: .65rem; }
        .legend-item  { display: flex; align-items: center; gap: .55rem; margin-bottom: .4rem; font-size: .72rem; }
        .legend-color { width: 12px; height: 12px; border-radius: 3px; flex-shrink: 0; }

        .map-info-panel {
            position: absolute; top: 1rem; right: 1rem; z-index: 500;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 10px; padding: 1rem; width: 225px; display: none;
        }
        .map-info-panel.visible { display: block; }
        .info-panel-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .75rem; }
        .info-panel-name   { font-size: .83rem; font-weight: 700; line-height: 1.3; flex: 1; }
        .info-close { background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: .78rem; padding: 0 0 0 .5rem; transition: color .15s; }
        .info-close:hover { color: var(--text-primary); }
        .info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .45rem; font-size: .72rem; }
        .info-row .k { color: var(--text-muted); }
        .info-row .v { font-weight: 600; font-family: 'Roboto Mono',monospace; }
        .info-pct-display { margin: .65rem 0 .45rem; text-align: center; }
        .pct-circle { font-size: 1.9rem; font-weight: 800; font-family: 'Roboto Mono',monospace; }
        .info-status-badge { display: inline-block; padding: .22rem .55rem; border-radius: 20px; font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-top: .35rem; }

        /* ── Leaflet overrides ── */
        .leaflet-container {background: #dbeafe !important;}
        .leaflet-popup-content-wrapper {
            background: var(--bg-card) !important; border: 1px solid var(--border) !important;
            border-radius: 10px !important; box-shadow: 0 8px 32px rgba(0,0,0,.5) !important;
            color: var(--text-primary) !important;
        }
        .leaflet-popup-tip { background: var(--bg-card) !important; }
        .leaflet-popup-content { margin: 0 !important; font-family: 'Plus Jakarta Sans',sans-serif !important; }
        .popup-inner  { padding: .85rem 1rem; min-width: 190px; }
        .popup-title  { font-size: .83rem; font-weight: 700; margin-bottom: .6rem; padding-bottom: .45rem; border-bottom: 1px solid var(--border); }
        .popup-row    { display: flex; justify-content: space-between; font-size: .7rem; margin-bottom: .28rem; gap: .5rem; }
        .popup-row .pk { color: var(--text-muted); }
        .popup-row .pv { font-weight: 600; font-family: 'Roboto Mono',monospace; }
        .popup-status { display: inline-block; padding: .18rem .5rem; border-radius: 20px; font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; margin-top: .45rem; }
        .popup-pct-bar  { height: 4px; background: var(--border); border-radius: 2px; margin: .55rem 0 .2rem; overflow: hidden; }
        .popup-pct-fill { height: 100%; border-radius: 2px; }
        .leaflet-tooltip {
            background: var(--bg-card) !important; border: 1px solid var(--border-light) !important;
            border-radius: 6px !important; color: var(--text-primary) !important;
            font-family: 'Plus Jakarta Sans',sans-serif !important;
            font-size: .7rem !important; font-weight: 600 !important;
            padding: .28rem .55rem !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important;
        }
        .leaflet-tooltip-top::before { border-top-color: var(--border-light) !important; }

        /* loading */
        .loading-overlay {
            position: absolute; inset: 0; background: rgba(10,15,30,.75);
            display: flex; align-items: center; justify-content: center; z-index: 600;
            flex-direction: column; gap: .75rem; transition: opacity .3s;
        }
        .loading-overlay.hidden { display: none; }
        .spinner { width: 34px; height: 34px; border: 3px solid var(--border); border-top-color: var(--acc, var(--accent)); border-radius: 50%; animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-text { font-size: .75rem; color: var(--text-muted); font-family: 'Roboto Mono',monospace; }

        @media (max-width: 900px) { .header-stats { display: none; } .sidebar { width: 255px; } }
        @media (max-width: 700px) { .periode-bar .periode-label { display: none; } }
    </style>

    @stack('styles')
</head>
<body>

<header class="app-header">
    <div class="header-brand">
        <button class="btn-close" onclick="history.back()"><i class="fa-solid fa-square-xmark"></i></button>
        {{-- <button class="btn-close" id="btnClose" onclick="history.back()" title="Close"><i class="fa-solid fa-square-xmark"></i></button> --}}
        {{-- <div class="brand-icon"><i class="fa-solid fa-map-location-dot" style="color:#fff"></i></div> --}}
        <div class="brand-text">
            <h1>SIG Pola Hidup Bersih dan Sehat</h1>
            <p>Kabupaten Sleman · D.I. Yogyakarta</p>
        </div>
    </div>

    {{-- ── PERIODE FILTER ── --}}
    <div class="periode-bar" id="periodeBar">
        <span class="periode-label"><i class="fa-regular fa-calendar-days"></i> Periode</span>

        {{-- Tahun --}}
        <select class="periode-select" id="selectTahun" onchange="onTahunChange(this.value)">
            @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>

        <span class="periode-divider">·</span>

        {{-- Navigasi bulan ◀ --}}
        <button class="btn-nav" id="btnPrev" onclick="navigateBulan(-1)" title="Bulan sebelumnya">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        {{-- Dropdown bulan --}}
        <select class="periode-select" id="selectBulan" onchange="onBulanChange(this.value)">
            @php
            $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                          'Juli','Agustus','September','Oktober','November','Desember'];
            @endphp
            @foreach($bulanList as $b)
                <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>{{ $namaBulan[$b] }}</option>
            @endforeach
        </select>

        {{-- Navigasi bulan ▶ --}}
        <button class="btn-nav" id="btnNext" onclick="navigateBulan(1)" title="Bulan berikutnya">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        {{-- Badge aktif --}}
        <span class="periode-active" id="periodeActive">
            {{ $bulan }} {{ $tahun }}
        </span>
    </div>

    <div class="header-stats">
        <div class="stat-badge">
            <span class="val" id="statTotal">{{ $totalPuskesmas }}</span>
            <span class="lbl">Puskesmas</span>
        </div>
        <div class="stat-badge">
            <span class="val" id="statAvg">{{ number_format($rataRataCapaian, 1) }}%</span>
            <span class="lbl">Rata-rata</span>
        </div>
        <div class="stat-badge">
            <span class="val">{{ number_format($totalKK, 0, ',', '.') }}</span>
            <span class="lbl">Jumlah KK</span>
        </div>
    </div>
</header>

<div class="app-body">
    @yield('content')
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@stack('scripts')
</body>
</html>
