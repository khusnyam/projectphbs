<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan Rekapitulasi PHBS – SIP-PHBS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
/* ─── DESIGN TOKENS: sama seperti resources/views/dashboard/index.blade.php ─── */
:root{
    --green:#22c55e;--green-bg:#f0fdf4;--green-ring:#bbf7d0;
    --teal:#14b8a6;--teal-bg:#f0fdfa;
    --sky:#0ea5e9;--sky-bg:#f0f9ff;
    --amber:#f59e0b;--amber-bg:#fffbeb;--amber-ring:#fde68a;
    --red:#ef4444;--red-bg:#fef2f2;--red-ring:#fecaca;
    --primary:#2563eb;--primary-dk:#1d4ed8;--primary-lt:#eff6ff;
    --sb-bg:#0f1629;
    --sb-hover:rgba(255,255,255,.06);
    --sb-active:rgba(255,255,255,.09);
    --sb-border:rgba(255,255,255,.07);
    --sb-text:rgba(255,255,255,.65);
    --sb-head:rgba(255,255,255,.30);
    --surface:#ffffff;
    --bg:#f1f5f9;
    --border:#e2e8f0;
    --text:#0f172a;
    --text-b:#475569;
    --text-muted:#94a3b8;
    --radius:12px;
    --radius-sm:8px;
    --shadow:0 1px 3px rgba(0,0,0,.08),0 1px 2px rgba(0,0,0,.04);
    --shadow-lg:0 10px 25px rgba(0,0,0,.12);
    --sidebar-w:220px;
    --mono:'JetBrains Mono',monospace;--s5:var(--text-muted);--blue:var(--primary);--blue-dark:#1e40af;--yellow:#facc15;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-b);min-height:100vh;}
a{text-decoration:none;color:inherit;}

/* ─── SIDEBAR: copy gaya dashboard/index.blade.php ─── */
.sidebar{
    position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;
    background:var(--sb-bg);display:flex;flex-direction:column;
    border-right:1px solid var(--sb-border);z-index:200;overflow-y:auto;
}
.sb-brand{padding:20px 16px 18px;border-bottom:1px solid var(--sb-border);display:flex;align-items:center;gap:11px;}
.sb-logo{width:38px;height:38px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#2563eb,#0ea5e9);display:flex;align-items:center;justify-content:center;}
.sb-logo svg{color:#fff;}
.sb-name{line-height:1;}
.sb-name strong{display:block;font-size:14px;font-weight:800;color:#fff;letter-spacing:-.2px;}
.sb-name span{display:block;font-size:10px;color:var(--sb-text);margin-top:2px;line-height:1.3;}
.sb-section{padding:18px 10px 6px;}
.sb-label{font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--sb-head);padding:0 8px;margin-bottom:4px;display:block;}
.sb-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-sm);color:var(--sb-text);font-size:13px;font-weight:500;transition:background .15s,color .15s;cursor:pointer;position:relative;width:100%;background:transparent;border:0;font-family:'Inter',sans-serif;text-align:left;}
.sb-item:hover{background:var(--sb-hover);color:#fff;}
.sb-item.active{background:var(--sb-active);color:#fff;font-weight:600;}
.sb-item.active::before{content:'';position:absolute;left:0;top:6px;bottom:6px;width:3px;border-radius:0 3px 3px 0;background:var(--amber);}
.sb-item svg{flex-shrink:0;opacity:.75;}
.sb-item.active svg{opacity:1;}
.sb-footer{margin-top:auto;padding:14px 16px;border-top:1px solid var(--sb-border);}
.sb-user{display:flex;align-items:center;gap:10px;}
.sb-avatar{width:34px;height:34px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--primary),var(--teal));display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;}
.sb-user-info strong{display:block;font-size:13px;font-weight:600;color:#fff;line-height:1.2;}
.sb-user-info span{display:block;font-size:11px;color:var(--sb-text);margin-top:1px;}

/* ─── MAIN ─── */
.main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;background:var(--bg);}
.content{padding:0 28px 40px;display:flex;flex-direction:column;gap:0;}

/* ─── HERO: topbar lama dibuat sama seperti hero beranda ─── */
.topbar{
    background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
    padding:30px 28px;display:flex;align-items:center;justify-content:space-between;gap:24px;
    margin-bottom:0;border:0;box-shadow:none;position:relative;top:auto;z-index:1;color:#fff;
}
.tb-left{flex:1;min-width:0;}
.tb-left h2{display:flex;align-items:center;gap:10px;font-size:22px;font-weight:800;color:#fff;margin-bottom:8px;letter-spacing:0;}
.tb-left h2 i{color:#fff!important;opacity:.9;margin-right:0!important;}
.tb-left p{font-size:13px;color:rgba(255,255,255,.75);margin-top:0;line-height:1.5;}
.tb-right{flex-shrink:0;display:flex;align-items:center;gap:10px;}
.tb-right::before{content:'RATA-RATA PHBS PERIODE INI';display:block;font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:8px;}
.tb-right{background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.15);border-radius:var(--radius);padding:18px 22px;min-width:220px;backdrop-filter:blur(6px);flex-direction:column;align-items:flex-start;}
.tb-right .btn-export{height:auto;padding:8px 14px;border-radius:var(--radius-sm);font-size:12px;font-weight:700;background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);}
.tb-right .btn-export:hover{background:rgba(255,255,255,.2);}

/* ─── BUTTONS ─── */
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);border:none;cursor:pointer;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;transition:background .15s,transform .1s;text-decoration:none;}
.btn:active{transform:scale(.97);}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:var(--primary-dk);}
.btn-outline{background:transparent;color:var(--text-b);border:1px solid var(--border);}
.btn-outline:hover{background:var(--bg);}
.btn-export{background:var(--primary);color:#fff;}
.btn-sm-edit{display:inline-flex;align-items:center;gap:5px;padding:6px 10px;border-radius:var(--radius-sm);font-size:12px;font-weight:600;background:var(--primary);color:#fff;text-decoration:none;}
.btn-sm-del{display:inline-flex;align-items:center;gap:5px;padding:6px 10px;border-radius:var(--radius-sm);font-size:12px;font-weight:600;background:var(--red);color:#fff;border:none;cursor:pointer;font-family:'Inter',sans-serif;}

/* ─── ALERT ─── */
.alert{order:0;padding:12px 14px;border-radius:var(--radius-sm);font-size:13px;font-weight:500;margin:20px 0 0;display:flex;align-items:center;gap:9px;}
.alert-ok{background:var(--green-bg);color:#166534;border:1px solid var(--green-ring);}
.alert-err{background:var(--red-bg);color:#991b1b;border:1px solid var(--red-ring);}

/* ─── FILTER SECTION: rapi, tidak nabrak, dan sejajar dengan dashboard ─── */
.filter-card{
    order:1;
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    padding:20px 22px 22px;
    margin:20px 0 22px;
    overflow:hidden;
}
.filter-card::before{
    content:'Filter Dashboard';
    display:block;
    font-size:15px;
    font-weight:800;
    color:var(--text);
    letter-spacing:-.1px;
    margin-bottom:5px;
}
.filter-card::after{
    content:'Pilih tahun, bulan, puskesmas, atau kategori untuk menampilkan data sesuai kebutuhan.';
    display:block;
    font-size:12.5px;
    line-height:1.45;
    color:var(--text-muted);
    margin:0 0 18px;
    pointer-events:none;
}
.filter-card form{
    display:grid;
    grid-template-columns:160px 200px minmax(260px,1fr) 190px 108px 116px;
    gap:14px;
    align-items:end;
    margin-top:0;
}
.fg{
    display:flex;
    flex-direction:column;
    gap:7px;
    min-width:0;
}
.fg label{
    font-size:11px;
    font-weight:800;
    color:var(--text-muted);
    text-transform:uppercase;
    letter-spacing:.7px;
}
.fg select,.fg input{
    width:100%;
    height:44px;
    border:1px solid var(--border);
    border-radius:10px;
    padding:0 14px;
    font-size:14px;
    font-family:'Inter',sans-serif;
    font-weight:500;
    color:var(--text);
    background:#f8fafc;
    outline:none;
    transition:border-color .15s,box-shadow .15s,background .15s;
}
.fg select:hover,.fg input:hover{
    background:#fff;
    border-color:#cbd5e1;
}
.fg select:focus,.fg input:focus{
    background:#fff;
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(37,99,235,.12);
}
.filter-card .btn{
    height:44px;
    padding:0 18px;
    justify-content:center;
    border-radius:10px;
    white-space:nowrap;
}
.filter-card .btn-primary{
    box-shadow:0 8px 18px rgba(37,99,235,.20);
}
.filter-card .btn-outline{
    background:#fff;
    color:var(--text-b);
}
.filter-card .btn-outline:hover{
    background:#f8fafc;
    border-color:#cbd5e1;
}

@media(max-width:1180px){
    .filter-card form{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
    .filter-card .btn{width:100%;}
}
@media(max-width:640px){
    .filter-card{padding:18px;margin:16px 0 20px;}
    .filter-card form{grid-template-columns:1fr;}
}

/* ─── STAT CARDS: tetap isinya, style mengikuti kartu beranda ─── */
.stat-row{order:2;display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:0 0 20px;}
.sc{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow);display:flex;flex-direction:column;gap:6px;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;}
.sc:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.sc::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:14px 14px 0 0;background:var(--primary);}
.sc:nth-child(1)::before{background:var(--green);}
.sc:nth-child(2)::before{background:var(--teal);}
.sc:nth-child(3)::before{background:var(--sky);}
.sc:nth-child(4)::before{background:var(--amber);}
.sc .sc-top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.sc .sc-ico{font-size:28px;position:absolute;right:18px;top:18px;opacity:.15;background:transparent!important;color:var(--text)!important;width:auto;height:auto;border-radius:0;}
.sc .lbl{font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;}
.sc .val{font-size:30px;font-weight:800;font-family:'JetBrains Mono',monospace;letter-spacing:-1px;color:var(--text);line-height:1.05;}
.sc .sub{font-size:12px;color:var(--text-muted);margin-top:2px;}
.pbar{height:5px;border-radius:99px;background:var(--border);overflow:hidden;margin-top:8px;}
.pbar-fill{height:100%;border-radius:99px;}

/* ─── TABLE ─── */
.table-card{order:3;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:28px;}
.table-head{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.table-head h3{font-size:14px;font-weight:700;color:var(--text);}
.count-badge{font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;background:var(--primary-lt);color:var(--primary);}
.tw{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:13px;}
thead tr{background:var(--bg);}
thead th{padding:10px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:1px solid var(--border);white-space:nowrap;background:var(--bg);}
tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f8fafc;}
tbody td{padding:11px 14px;vertical-align:middle;font-size:13px;}
.td-pkm{font-weight:600;color:var(--text);}
.td-num{font-family:'JetBrains Mono',monospace;text-align:right;font-size:12px;font-weight:600;}
.badge{display:inline-flex;align-items:center;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;}
.b-baik{background:#dcfce7;color:#15803d;}
.b-cukup{background:#fef9c3;color:#a16207;}
.b-kurang{background:#fee2e2;color:#b91c1c;}
.b-draft{background:#f1f5f9;color:#94a3b8;}
.b-kirim{background:var(--primary-lt);color:var(--primary);}
.acts{display:flex;gap:6px;align-items:center;}
.empty td{text-align:center;padding:48px 20px;color:var(--text-muted);font-size:13px;}

@media(max-width:900px){
    .sidebar{display:none;}
    .main{margin-left:0;}
    .topbar{flex-direction:column;align-items:flex-start;}
    .tb-right{width:100%;}
    .stat-row{grid-template-columns:1fr;}
}
</style>
</head>
<body>

{{-- SIDEBAR --}}
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

        <a href="{{ route('phbs.dashboard') }}" class="sb-item {{ request()->routeIs('phbs.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
            </svg>
            Ringkasan PHBS
        </a>

        <a href="{{ route('peta.index') }}" class="sb-item {{ request()->routeIs('peta.index') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Peta
        </a>

        <a href="{{ route('phbs.index') }}" class="sb-item {{ request()->routeIs('phbs.index') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            Laporan Rekapitulasi
        </a>
    </div>

    <div class="sb-section">
        <span class="sb-label">Akun</span>
        <form method="POST" action="{{ route('logout') }}">
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
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->nama_user ?? auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="sb-user-info">
                <strong>{{ auth()->user()->nama_user ?? auth()->user()->name ?? 'Admin Dinkes' }}</strong>
                <span>{{ ucfirst(auth()->user()->role ?? 'dinkes') }} &bull; SIP-PHBS</span>
            </div>
        </div>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
  <div class="topbar">
    <div class="tb-left">
      <h2><i class="fa-solid fa-chart-bar" style="color:var(--blue);margin-right:7px"></i>Laporan Rekapitulasi PHBS</h2>
      <p>Tatanan Rumah Tangga • Tahun {{ $tahun }}</p>
    </div>
    <div class="tb-right">
      <a href="{{ route('phbs.export', request()->query()) }}" class="btn btn-export">
        <i class="fa-solid fa-file-excel"></i> Export Excel
      </a>
      {{-- <a href="{{ route('phbs.form') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Input Laporan
      </a> --}}
    </div>
  </div>

  <div class="content">

    {{-- ALERT --}}
    @if(session('success'))
      <div class="alert alert-ok"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    {{-- STAT CARDS --}}
    @php
      $rata     = $stats['rata_phbs'] ?? 0;
      $barColor = $rata >= 80 ? '#16a34a' : ($rata >= 60 ? '#f59e0b' : '#ef4444');
      $katTxt   = $rata >= 80 ? 'Kategori Baik' : ($rata >= 60 ? 'Kategori Cukup' : 'Kategori Kurang');
    @endphp
    <div class="stat-row">
      <div class="sc">
        <div class="sc-top">
          <div>
            <div class="lbl">Total Laporan</div>
            <div class="val">{{ $stats['total_laporan'] }}</div>
            <div class="sub">Periode ditampilkan</div>
          </div>
          <div class="sc-ico sc-ico-blue"><i class="fa-solid fa-file-lines"></i></div>
        </div>
      </div>
      <div class="sc">
        <div class="sc-top">
          <div>
            <div class="lbl">Total KK Dipantau</div>
            <div class="val">{{ number_format($stats['total_kk']) }}</div>
            <div class="sub">Kepala Keluarga</div>
          </div>
          <div class="sc-ico sc-ico-blue"><i class="fa-solid fa-house-user"></i></div>
        </div>
      </div>
      <div class="sc">
        <div class="sc-top">
          <div>
            <div class="lbl">KK Ber-PHBS</div>
            <div class="val">{{ number_format($stats['total_ber_phbs']) }}</div>
            <div class="sub">Memenuhi indikator</div>
          </div>
          <div class="sc-ico sc-ico-yellow"><i class="fa-solid fa-circle-check"></i></div>
        </div>
      </div>
      <div class="sc">
        <div class="sc-top">
          <div>
            <div class="lbl">Rata-rata % PHBS</div>
            <div class="val" style="color:{{ $barColor }}">{{ $rata }}%</div>
          </div>
          <div class="sc-ico sc-ico-yellow"><i class="fa-solid fa-chart-line"></i></div>
        </div>
        <div class="pbar"><div class="pbar-fill" style="width:{{ $rata }}%;background:{{ $barColor }}"></div></div>
        <div class="sub" style="margin-top:6px">{{ $katTxt }}</div>
      </div>
    </div>

    {{-- FILTER --}}
    <div class="filter-card">
      <form method="GET" action="{{ route('phbs.index') }}">
        <div class="fg">
          <label>Tahun</label>
          <select name="tahun">
            @for($y=2023;$y<=2026;$y++)
              <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>
        <div class="fg">
          <label>Bulan</label>
          <select name="bulan">
            <option value="0">Semua Bulan</option>
            @foreach($namaBulan as $num=>$nm)
              <option value="{{ $num }}" {{ $bulan==$num?'selected':'' }}>{{ $nm }}</option>
            @endforeach
          </select>
        </div>
        <div class="fg">
          <label>Puskesmas</label>
          <select name="puskesmas_id">
            <option value="0">Semua Puskesmas</option>
            @foreach($puskesmasList as $pkm)
              <option value="{{ $pkm->id_puskesmas }}" {{ $pkmId==$pkm->id_puskesmas?'selected':'' }}>
                {{ $pkm->nama_puskesmas }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="fg">
          <label>Kategori PHBS</label>
          <select name="kategori">
            <option value="">Semua</option>
            <option value="baik"   {{ $kategori=='baik'?'selected':'' }}>Baik (≥80%)</option>
            <option value="cukup"  {{ $kategori=='cukup'?'selected':'' }}>Cukup (60–79%)</option>
            <option value="kurang" {{ $kategori=='kurang'?'selected':'' }}>Kurang (&lt;60%)</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-magnifying-glass"></i> Filter
        </button>
        <a href="{{ route('phbs.index') }}" class="btn btn-outline">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </a>
      </form>
    </div>

    {{-- TABEL --}}
    <div class="table-card">
      <div class="table-head">
        <h3>Data Laporan PHBS</h3>
        <span class="count-badge">{{ $laporan->count() }} data</span>
      </div>
      <div class="tw">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Puskesmas</th>
              <th>Bulan</th>
              <th>Tahun</th>
              <th style="text-align:right">KK L</th>
              <th style="text-align:right">KK P</th>
              <th style="text-align:right">Total KK</th>
              <th style="text-align:right">Ber-PHBS</th>
              <th style="text-align:right">% PHBS</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($laporan as $i=>$row)
            @php
              $pct = $row->persen_phbs;
              $pc  = $pct>=80?'#166534':($pct>=60?'#92400e':'#991b1b');
              $bk  = $pct>=80?'b-baik':($pct>=60?'b-cukup':'b-kurang');
              $kt  = $pct>=80?'Baik':($pct>=60?'Cukup':'Kurang');
            @endphp
            <tr>
              <td style="color:var(--s5);font-size:.7rem">{{ $i+1 }}</td>
              <td class="td-pkm">{{ $row->nama_puskesmas }}</td>
              <td style="font-size:.73rem;color:var(--s5)">{{ $namaBulan[$row->bulan]??'-' }}</td>
              <td style="font-size:.73rem;color:var(--s5)">{{ $row->tahun }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_l) }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_p) }}</td>
              <td class="td-num"><strong>{{ number_format($row->jumlah_kk_total) }}</strong></td>
              <td class="td-num">{{ number_format($row->ber_phbs) }}</td>
              <td class="td-num"><strong style="color:{{ $pc }}">{{ number_format($pct,1) }}%</strong></td>
              <td><span class="badge {{ $bk }}">{{ $kt }}</span></td>
              <td>
                <span class="badge {{ $row->status_laporan=='terkirim'?'b-kirim':'b-draft' }}">
                  {{ $row->status_laporan=='terkirim'?'Terkirim':'Draft' }}
                </span>
              </td>
              <td>
                <div class="acts">
                  <a href="{{ route('phbs.edit',$row->id_phbs) }}" class="btn-sm-edit">
                    <i class="fa-solid fa-pen"></i> Edit
                  </a>
                  <form method="POST" action="{{ route('phbs.destroy',$row->id_phbs) }}"
                        onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm-del">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr class="empty"><td colspan="12">📭 Belum ada data untuk filter ini.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
</body>
</html>