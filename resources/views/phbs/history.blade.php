<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>History PHBS - SIP-PHBS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root{
  --green:#22c55e;
  --green-bg:#f0fdf4;
  --teal:#14b8a6;
  --sky:#0ea5e9;
  --amber:#f59e0b;
  --red:#ef4444;
  --primary:#2563eb;
  --primary-dk:#1d4ed8;
  --primary-lt:#eff6ff;
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
  --mono:'JetBrains Mono',monospace;
}

*,
*::before,
*::after{
  box-sizing:border-box;
  margin:0;
  padding:0;
}

html{
  scroll-behavior:smooth;
}

body{
  font-family:'Inter',sans-serif;
  background:var(--bg);
  color:var(--text-b);
  min-height:100vh;
}

a{
  text-decoration:none;
  color:inherit;
}

button,
input,
select,
textarea{
  font-family:'Inter',sans-serif;
}

/* SIDEBAR — persis model dashboard puskesmas */
.sidebar{
  position:fixed;
  top:0;
  left:0;
  width:var(--sidebar-w);
  height:100vh;
  background:var(--sb-bg);
  color:#fff;
  display:flex;
  flex-direction:column;
  border-right:1px solid var(--sb-border);
  z-index:200;
  overflow-y:auto;
}

.sb-brand{
  padding:20px 16px 18px;
  border-bottom:1px solid var(--sb-border);
  display:flex;
  align-items:center;
  gap:11px;
  min-height:77px;
}

.sb-logo{
  width:38px;
  height:38px;
  border-radius:10px;
  flex:0 0 38px;
  background:linear-gradient(135deg,#2563eb,#0ea5e9);
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
}

.sb-logo svg{
  width:20px;
  height:20px;
  color:#fff;
  stroke:#fff;
  display:block;
}

.sb-name{
  line-height:1;
  min-width:0;
}

.sb-name strong{
  display:block;
  font-size:14px;
  font-weight:800;
  color:#fff;
  letter-spacing:-.2px;
  line-height:1.1;
}

.sb-name span{
  display:block;
  font-size:10px;
  color:var(--sb-text);
  margin-top:2px;
  line-height:1.3;
}

.sb-nav{
  padding:0;
  flex:1;
  overflow-y:auto;
}

.sb-section{
  padding:18px 10px 6px;
  margin:0;
}

.sb-label{
  display:block;
  font-size:10px;
  font-weight:700;
  letter-spacing:.8px;
  text-transform:uppercase;
  color:var(--sb-head);
  padding:0 8px;
  margin:0 0 4px;
  line-height:1.2;
}

.sb-item,
.logout-btn{
  appearance:none;
  -webkit-appearance:none;
  display:flex;
  align-items:center;
  gap:9px;
  width:100%;
  min-height:33px;
  padding:9px 10px;
  border:0;
  border-radius:var(--radius-sm);
  background:transparent;
  color:var(--sb-text);
  font-size:13px;
  font-weight:500;
  line-height:1.15;
  text-align:left;
  cursor:pointer;
  position:relative;
  transition:background .15s,color .15s;
}

.sb-item:hover,
.logout-btn:hover{
  background:var(--sb-hover);
  color:#fff;
}

.sb-item.active{
  background:var(--sb-active);
  color:#fff;
  font-weight:600;
}

.sb-item.active::before{
  content:'';
  position:absolute;
  left:0;
  top:6px;
  bottom:6px;
  width:3px;
  border-radius:0 3px 3px 0;
  background:var(--amber);
}

.sb-item svg,
.logout-btn svg{
  width:15px;
  height:15px;
  min-width:15px;
  flex-shrink:0;
  color:currentColor;
  stroke:currentColor;
  opacity:.75;
  display:block;
}

.sb-item.active svg{
  opacity:1;
}

.sidebar form{
  margin:0;
  padding:0;
  border:0;
  background:transparent;
  width:100%;
}

.sb-footer{
  margin-top:auto;
  padding:14px 16px;
  border-top:1px solid var(--sb-border);
  background:transparent;
}

.sb-user{
  display:flex;
  align-items:center;
  gap:10px;
  width:100%;
}

.sb-avatar{
  width:34px;
  height:34px;
  border-radius:50%;
  flex:0 0 34px;
  background:linear-gradient(135deg,var(--primary),var(--teal));
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:12px;
  font-weight:700;
  color:#fff;
}

.sb-user-info{
  min-width:0;
  line-height:1.2;
}

.sb-user-info strong{
  display:block;
  font-size:13px;
  font-weight:600;
  color:#fff;
  line-height:1.2;
  white-space:normal;
}

.sb-user-info span{
  display:block;
  font-size:11px;
  color:var(--sb-text);
  margin-top:1px;
  line-height:1.25;
  white-space:normal;
}

/* MAIN */
.main{
  margin-left:var(--sidebar-w);
  width:calc(100vw - var(--sidebar-w));
  min-height:100vh;
  background:var(--bg);
}

.content{
  padding:28px;
  display:flex;
  flex-direction:column;
  gap:18px;
  width:100%;
}

/* HEADER */
.header-card{
  width:100%;
  background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
  color:#fff;
  border-radius:var(--radius);
  padding:30px 28px;
  min-height:124px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:18px;
  box-shadow:none;
}

.header-card h1{
  display:flex;
  align-items:center;
  gap:10px;
  font-size:22px;
  font-weight:800;
  line-height:1.25;
  letter-spacing:-.2px;
  color:#fff;
  margin:0 0 8px;
}

.header-card h1 i{
  font-size:20px;
  color:#fff;
  opacity:.9;
}

.header-card p{
  font-size:13px;
  color:rgba(255,255,255,.75);
  line-height:1.5;
  margin:0;
}

.header-badge,
.report-badge{
  display:inline-flex;
  align-items:center;
  gap:6px;
  background:rgba(255,255,255,.14);
  color:rgba(255,255,255,.9);
  font-size:12px;
  font-weight:600;
  padding:5px 11px;
  border-radius:20px;
  border:1px solid rgba(255,255,255,.18);
  white-space:nowrap;
}

/* COMMON CARD */
.card,
.filter-card,
.report-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
}

.section-head{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:12px;
  margin-bottom:16px;
}

.section-head h3{
  font-size:13.5px;
  font-weight:700;
  color:var(--text);
  display:flex;
  align-items:center;
  gap:8px;
}

.section-head h3 i{
  color:var(--primary);
}

.section-head p{
  font-size:12px;
  color:var(--text-muted);
  line-height:1.45;
  margin-top:4px;
}

.count-badge{
  background:#eef4ff;
  color:var(--primary);
  font-size:12px;
  font-weight:700;
  padding:5px 10px;
  border-radius:999px;
  white-space:nowrap;
}

/* FILTER */
.filter-card{
  padding:20px;
}

.filter-form{
  display:grid;
  grid-template-columns:260px 180px max-content;
  gap:12px;
  align-items:end;
  justify-content:start;
}

.fg label{
  display:block;
  font-size:11px;
  font-weight:600;
  color:var(--text-muted);
  text-transform:uppercase;
  letter-spacing:.5px;
  margin-bottom:6px;
}

.fg input,
.fg select{
  width:100%;
  min-height:36px;
  padding:8px 12px;
  border:1px solid var(--border);
  border-radius:var(--radius-sm);
  background:var(--surface);
  color:var(--text);
  font-size:13px;
  outline:none;
  box-shadow:none;
}

.fg input:focus,
.fg select:focus{
  border-color:var(--primary);
  box-shadow:0 0 0 3px rgba(37,99,235,.12);
}

/* BUTTONS */
.btn{
  appearance:none;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  padding:9px 18px;
  min-height:36px;
  border-radius:var(--radius-sm);
  border:none;
  cursor:pointer;
  font-size:13px;
  font-weight:600;
  line-height:1.2;
  background:var(--primary);
  color:#fff;
  transition:background .15s,transform .1s;
}

.btn:active{
  transform:scale(.97);
}

.btn-primary{
  background:var(--primary);
  color:#fff;
}

.btn-primary:hover{
  background:var(--primary-dk);
}

.btn-warning{
  background:var(--amber);
  color:#1f2937;
}

.btn-danger{
  background:var(--red);
  color:#fff;
}

.btn-outline{
  background:transparent;
  color:var(--text-b);
  border:1px solid var(--border);
}

.btn-outline:hover{
  background:var(--bg);
  color:var(--text);
}

/* REPORT */
.report-list{
  display:flex;
  flex-direction:column;
  gap:18px;
}

.report-card{
  overflow:hidden;
  padding:0;
}

.report-head{
  background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
  color:#fff;
  padding:16px 20px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
}

.report-head h2{
  font-size:14px;
  font-weight:700;
  color:#fff;
  display:flex;
  align-items:center;
  gap:8px;
  margin:0;
}

.report-head p{
  font-size:12px;
  color:rgba(255,255,255,.75);
  margin-top:3px;
}

.report-body{
  padding:18px;
}

.quick-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:14px;
  margin-bottom:16px;
}

.quick{
  background:#f8fafc;
  border:1px solid var(--border);
  border-radius:12px;
  padding:16px 18px;
  text-align:left;
  min-height:96px;
}

.quick .label{
  font-size:11px;
  font-weight:700;
  color:var(--text-muted);
  text-transform:uppercase;
  letter-spacing:.08em;
}

.quick .value{
  font-size:22px;
  font-weight:800;
  color:var(--text);
  margin-top:4px;
  font-family:var(--mono);
}

.quick .sub{
  font-size:12px;
  color:var(--text-muted);
  margin-top:2px;
}

.avg-card{
  background:#f8fafc;
  border:1px dashed var(--border);
  border-radius:12px;
  padding:15px 16px;
  text-align:center;
  margin-bottom:16px;
}

.avg-card p{
  font-size:12px;
  color:var(--text-muted);
  font-weight:700;
}

.avg-card h2{
  font-size:28px;
  color:var(--primary);
  margin-top:4px;
  font-family:var(--mono);
}

.indicator-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:10px;
  margin-top:14px;
}

.ind-card{
  background:#f8fafc;
  border:1px solid var(--border);
  border-radius:12px;
  padding:12px;
}

.ind-row{
  display:flex;
  justify-content:space-between;
  gap:10px;
  margin-bottom:8px;
  align-items:center;
}

.ind-name{
  font-size:12px;
  font-weight:700;
  color:var(--text);
}

.ind-pct{
  font-size:11px;
  font-weight:700;
  color:var(--primary);
  background:var(--primary-lt);
  border-radius:20px;
  padding:2px 8px;
}

.track{
  height:7px;
  background:var(--border);
  border-radius:99px;
  overflow:hidden;
}

.fill{
  height:100%;
  background:var(--primary);
  border-radius:99px;
}

.table-wrap{
  overflow:auto;
  border:1px solid var(--border);
  border-radius:12px;
  background:#fff;
  margin-top:16px;
}

table{
  width:100%;
  border-collapse:collapse;
  border-spacing:0;
  font-size:13px;
}

thead tr{
  background:#0f1629;
}

th,
thead th{
  background:#0f1629;
  color:rgba(255,255,255,.8);
  padding:11px 14px;
  text-align:left;
  font-size:10px;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.5px;
  white-space:nowrap;
  border:none;
}

td,
tbody td{
  padding:11px 14px;
  border-bottom:1px solid var(--border);
  font-size:13px;
  vertical-align:middle;
  color:var(--text-b);
}

tbody tr:last-child td{
  border-bottom:none;
}

tbody tr:hover td{
  background:#f8fafc;
}

.actions{
  display:flex;
  justify-content:flex-end;
  gap:10px;
  margin-top:16px;
}

.empty-state{
  text-align:center;
  padding:42px;
  color:var(--text-muted);
}

.empty-state i{
  font-size:24px;
  color:#cbd5e1;
  display:block;
  margin-bottom:8px;
}

/* MODAL */
.modal{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,.55);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:400;
}

.modal.hidden{
  display:none;
}

.modal-box{
  background:#fff;
  border-radius:16px;
  box-shadow:0 20px 45px rgba(15,23,42,.22);
  width:100%;
  max-width:420px;
  padding:22px;
}

.modal-box h2{
  font-size:16px;
  margin-bottom:8px;
  display:flex;
  align-items:center;
  gap:8px;
  color:var(--text);
}

.modal-box p{
  font-size:13px;
  color:var(--text-muted);
  line-height:1.45;
}

.modal-actions{
  display:flex;
  justify-content:flex-end;
  gap:8px;
  margin-top:18px;
}

@media(max-width:1100px){
  .filter-form{
    grid-template-columns:1fr 1fr;
  }

  .quick-grid,
  .indicator-grid{
    grid-template-columns:1fr;
  }

  .header-card{
    flex-direction:column;
    align-items:flex-start;
  }
}

@media(max-width:760px){
  body{
    display:block;
  }

  .sidebar{
    position:relative;
    width:100%;
    height:auto;
  }

  .main{
    margin-left:0;
    width:100%;
  }

  .content{
    padding:16px;
  }

  .filter-form{
    grid-template-columns:1fr;
  }
}

/* FIX: tombol Filter history jangan melebar */
.filter-form .btn,
.filter-form .btn-primary{
  width:auto!important;
  min-width:96px!important;
  max-width:120px!important;
  padding-left:18px!important;
  padding-right:18px!important;
  white-space:nowrap!important;
}

</style>
</head>
<body>

<aside class="sidebar">
  <div class="sb-brand">
    <div class="sb-logo" aria-hidden="true">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
      </svg>
    </div>
    <div class="sb-name">
      <strong>SIP-PHBS</strong>
      <span>Sistem Informasi Pelaporan PHBS</span>
    </div>
  </div>

  @php
    $authUser = auth()->user() ?? (object) [];
    $userName = trim((string) ($authUser->name ?? $authUser->nama_user ?? ''));
    $puskesmasData = $authUser->puskesmas ?? null;
    $puskesmasName = null;

    if (is_object($puskesmasData)) {
      $puskesmasName = $puskesmasData->nama_puskesmas ?? $puskesmasData->nama ?? $puskesmasData->name ?? null;
    } elseif (is_string($puskesmasData)) {
      $puskesmasName = $puskesmasData;
    }

    $puskesmasName = $puskesmasName
      ?? ($authUser->nama_puskesmas ?? null)
      ?? ($authUser->puskesmas_nama ?? null)
      ?? ($authUser->wilayah ?? null)
      ?? ($userName ?: 'Puskesmas Gamping I');

    $puskesmasLabel = stripos($puskesmasName, 'puskesmas') !== false ? $puskesmasName : 'Puskesmas '.$puskesmasName;
    $footerName = 'Admin '.$puskesmasLabel;
    $footerRole = $puskesmasLabel.' • SIP-PHBS';
  @endphp

  <nav class="sb-nav" aria-label="Navigasi utama dashboard puskesmas">
    <div class="sb-section">
      <span class="sb-label">Menu Utama</span>

      <a href="{{ route('puskesmas.dashboard') }}" class="sb-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
        </svg>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('phbs.create') }}" class="sb-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
          <path d="M9 5a2 2 0 012-2h2a2 2 0 012 2 2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          <path d="M9 12h6M9 16h6"/>
        </svg>
        <span>Input Data</span>
      </a>

      {{-- <a href="{{ route('puskesmas.dashboard') }}#data-puskesmas" class="sb-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
          <path d="M3 21h18"/>
          <path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/>
        </svg>
        <span>Data Puskesmas</span>
      </a> --}}

      <a href="{{ route('phbs.history') }}" class="sb-item active">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        <span>Lihat History</span>
      </a>
    </div>

    <div class="sb-section">
      <span class="sb-label">Analisis</span>

      <a href="{{ route('puskesmas.dashboard') }}#per-indikator" class="sb-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
        </svg>
        <span>Per Indikator</span>
      </a>

      {{-- <a href="{{ route('puskesmas.dashboard') }}#perbandingan" class="sb-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 3v18"/>
          <path d="M5 7h14"/>
          <path d="M7 7l-3 6h6L7 7z"/>
          <path d="M17 7l-3 6h6l-3-6z"/>
          <path d="M8 21h8"/>
        </svg>
        <span>Perbandingan</span> --}}
      </a>
    </div>

    <div class="sb-section">
      <span class="sb-label">Akun</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7"/>
            <path d="M13 16v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </nav>

  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">P</div>
      <div class="sb-user-info">
        <strong title="{{ $footerName }}">{{ $footerName }}</strong>
        <span title="{{ $footerRole }}">{{ $footerRole }}</span>
      </div>
    </div>
  </div>
</aside>

<main class="main">
  <div class="content">

    <section class="header-card">
      <div>
        <h1><i class="fa-solid fa-clock-rotate-left"></i> History Monitoring PHBS</h1>
        <p>Rekap data PHBS per puskesmas berdasarkan periode bulan dan tahun.</p>
      </div>
      <span class="header-badge"><i class="fa-solid fa-database"></i> Rekap Data</span>
    </section>

    <section class="card filter-card">
      <div class="section-head">
        <div>
          <h3><i class="fa-solid fa-sliders"></i> Filter History</h3>
          <p>Pilih bulan dan tahun untuk menampilkan data sesuai kebutuhan.</p>
        </div>
      </div>

      <form method="GET" action="{{ route('phbs.history') }}" class="filter-form">
        <div class="fg">
          <label>Bulan</label>
          <select name="bulan">
            <option value="">Semua Bulan</option>
            <option value="Januari">Januari</option>
            <option value="Februari">Februari</option>
            <option value="Maret">Maret</option>
            <option value="April">April</option>
            <option value="Mei">Mei</option>
            <option value="Juni">Juni</option>
            <option value="Juli">Juli</option>
            <option value="Agustus">Agustus</option>
            <option value="September">September</option>
            <option value="Oktober">Oktober</option>
            <option value="November">November</option>
            <option value="Desember">Desember</option>
          </select>
        </div>

        <div class="fg">
          <label>Tahun</label>
          <input type="number" name="tahun" placeholder="Tahun">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass-chart"></i> Filter</button>
      </form>

      

    </section>

    <div class="report-list">
      @forelse($data as $item)
        <section class="card report-card">
          <div class="report-head">
            <div>
              <h2><i class="fa-solid fa-hospital"></i> {{ $item->puskesmas->nama_puskesmas ?? '-' }}</h2>
              <p><i class="fa-regular fa-calendar"></i> {{ $item->bulan }} {{ $item->tahun }}</p>
            </div>
            <div class="report-badge"><i class="fa-solid fa-tag"></i> {{ $item->kategori_phbs }}</div>
          </div>

          <div class="report-body">
            @php
              $totalIndikator = 13;
              $terpenuhi = $item->details->where('jumlah_capaian', '>', 0)->count();
              $persentaseTotal = $totalIndikator > 0 ? ($terpenuhi / $totalIndikator) * 100 : 0;
            @endphp

            <div class="quick-grid">
              <div class="quick">
                <div class="label">Jumlah KK</div>
                {{-- <div class="value">{{ $item->jumlah_kk_total }}</div> --}}
                <div class="value">9</div>
              </div>

              <div class="quick">
                <div class="label">Indikator Terpenuhi</div>
                <div class="value">{{ $terpenuhi }} / {{ $totalIndikator }}</div>
                <div class="sub">{{ number_format($persentaseTotal,1) }}%</div>
              </div>

              <div class="quick">
                <div class="label">Kategori</div>
                <div class="value">{{ $item->kategori_phbs }}</div>
              </div>
            </div>

            <div class="avg-card">
              <p>Rata-rata Capaian PHBS</p>
              <h2>{{ round($item->details->avg('persentase'),1) }}%</h2>
            </div>

            @php
              $namaIndikator = [
                1 => 'Persalinan Nakes',
                2 => 'ASI Eksklusif',
                3 => 'Timbang Balita',
                4 => 'Air Bersih',
                5 => 'Cuci Tangan',
                6 => 'Pengelolaan Air Minum',
                7 => 'Jamban Sehat',
                8 => 'Pengelolaan Limbah',
                9 => 'Buang Sampah',
                10 => 'Pemberantasan Jentik',
                11 => 'Makan Buah Sayur',
                12 => 'Aktivitas Fisik',
                13 => 'Tidak Merokok',
              ];
            @endphp

            <div class="section-head" style="margin-top:4px;margin-bottom:10px">
              <div>
                <h3><i class="fa-solid fa-list-check"></i> Detail Indikator</h3>
                <p>Capaian masing-masing indikator PHBS.</p>
              </div>
              <span class="count-badge">13 Indikator</span>
            </div>

            <div class="indicator-grid">
              @foreach($item->details as $detail)
                <div class="ind-card">
                  <div class="ind-row">
                    <span class="ind-name">{{ $namaIndikator[$detail->id_indikator] ?? '-' }}</span>
                    <span class="ind-pct">{{ $detail->persentase }}%</span>
                  </div>
                  <div class="track">
                    <div class="fill" style="width: {{ $detail->persentase }}%"></div>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Indikator</th>
                    <th style="text-align:center">Sasaran</th>
                    <th style="text-align:center">Capaian</th>
                    <th style="text-align:center">Persentase</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($item->details as $detail)
                    <tr>
                      <td style="font-weight:600;color:#1e3a5f">{{ $namaIndikator[$detail->id_indikator] ?? '-' }}</td>
                      <td style="text-align:center">{{ $detail->jumlah_sasaran }}</td>
                      <td style="text-align:center;font-weight:700">{{ $detail->jumlah_capaian }}</td>
                      <td style="text-align:center;color:var(--blue);font-weight:800">{{ $detail->persentase }}%</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="actions">
              <a href="{{ route('phbs.edit', $item->id_phbs) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

              <form id="deleteForm{{ $item->id_phbs }}" action="{{ route('phbs.destroy', $item->id_phbs) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteModal({{ $item->id_phbs }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
              </form>
            </div>
          </div>
        </section>
      @empty
        <section class="card empty-state">
          <i class="fa-solid fa-box-open"></i>
          Data tidak ditemukan
        </section>
      @endforelse
    </div>
  </div>
</main>

<div id="deleteModal" class="modal hidden">
  <div class="modal-box">
    <h2><i class="fa-solid fa-triangle-exclamation" style="color:#ef4444"></i> Hapus Data?</h2>
    <p>Data PHBS yang dihapus tidak akan tampil lagi pada halaman history.</p>
    <div class="modal-actions">
      <button onclick="closeDeleteModal()" class="btn btn-outline">Batal</button>
      <button id="confirmDeleteBtn" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
    </div>
  </div>
</div>

<script>
let selectedDeleteId = null;

function openDeleteModal(id){
  selectedDeleteId = id;
  document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal(){
  document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function(){
  document.getElementById('deleteForm' + selectedDeleteId).submit();
});
</script>

</body>
</html>
