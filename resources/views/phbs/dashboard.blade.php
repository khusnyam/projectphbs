<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard PHBS Rumah Tangga — Kabupaten Sleman 2025</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>

:root{
  --blue-dark:#002277;
  --blue:#003399;
  --blue-mid:#0044cc;
  --yellow:#FFCC00;
  --yellow-soft:#fff8cc;
  --green:#16a34a;
  --red:#ef4444;
  --orange:#f59e0b;
  --bg:#f0f4ff;
  --navy:#0a1628;
  --navy-2:#0d2137;
  --text:#0f172a;
  --muted:#64748b;
  --line:#e5e7eb;
  --soft:#f8fafc;
  --card:#ffffff;
  --shadow:0 1px 7px rgba(15,23,42,.07);
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:var(--bg);min-height:100vh;color:var(--text);display:flex}
a{text-decoration:none;color:inherit}
.sidebar{
  width:230px;flex-shrink:0;position:fixed;left:0;top:0;bottom:0;z-index:100;
  background:linear-gradient(180deg,#0a1628 0%,#0d2137 60%,#0a3d2e 100%);
  color:#fff;display:flex;flex-direction:column;
}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sb-logo-row{display:flex;align-items:center;gap:10px}
.sb-icon{
  width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));
  color:var(--yellow);display:flex;align-items:center;justify-content:center;font-size:16px;
}
.sb-logo h1{font-size:.85rem;font-weight:700;color:#fff}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.5);margin-top:1px;line-height:1.35}
.sb-nav{padding:14px 10px;flex:1;overflow:auto}
.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.28);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{
  display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;
  color:rgba(255,255,255,.62);font-size:.8rem;font-weight:600;transition:.15s;margin-bottom:2px;
}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left:3px solid var(--yellow)}
.nav-item i{width:16px;text-align:center}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer .user-name{font-size:.75rem;font-weight:700;color:rgba(255,255,255,.82)}
.sb-footer .user-role{font-size:.62rem;color:rgba(255,255,255,.42);margin-top:2px}
.main{margin-left:230px;flex:1;min-width:0}
.content{padding:26px;display:flex;flex-direction:column;gap:18px}
.card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);border:1px solid rgba(15,23,42,.05)}
.header-card{
  background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 58%,#0a3d2e 100%);
  color:#fff;border-radius:16px;padding:24px 28px;box-shadow:0 4px 20px rgba(0,51,153,.18);
  display:flex;justify-content:space-between;gap:20px;align-items:center;
}
.header-card h1{font-size:1.35rem;font-weight:700;margin-bottom:8px;letter-spacing:.2px}
.header-card p{font-size:.84rem;color:rgba(255,255,255,.75);line-height:1.55}
.header-tag{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.13);font-size:.69rem;font-weight:800;padding:6px 10px;border-radius:999px;color:rgba(255,255,255,.92);margin-top:12px}
.section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:14px}
.section-head h3{font-size:.95rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.section-head h3 i{color:var(--blue)}
.section-head p{font-size:.72rem;color:var(--muted);margin-top:3px;line-height:1.45}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:9px;padding:9px 13px;font-size:.78rem;font-weight:700;cursor:pointer;font-family:'Segoe UI',sans-serif}
.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue-dark)}
.btn-warning{background:var(--yellow);color:#1f2937}.btn-danger{background:var(--red);color:#fff}
.btn-outline{background:#fff;color:#1e3a5f;border:1.5px solid #cbd5e1}.btn-outline:hover{border-color:var(--blue);color:var(--blue)}
.form-card,.table-card,.filter-card,.info-card{padding:17px 20px}
.form-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.fg label{display:block;font-size:.66rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px}
.fg select,.fg input{width:100%;height:41px;border-radius:8px;border:1.5px solid #cbd5e1;background:#fff;padding:0 11px;font-size:.8rem;color:var(--text);font-family:'Segoe UI',sans-serif}
.fg select:focus,.fg input:focus{outline:none;border-color:var(--blue)}
.tab-row{display:flex;gap:10px}
.tab{border-radius:999px;padding:9px 14px;font-size:.78rem;font-weight:800;border:1px solid #cbd5e1;background:#fff;color:#1e3a5f;cursor:pointer}
.tab.active{background:var(--blue);border-color:var(--blue);color:#fff}
.panel-head{background:linear-gradient(135deg,var(--blue-dark),var(--blue));color:#fff;padding:17px 20px;border-radius:14px 14px 0 0;display:flex;justify-content:space-between;align-items:center}
.panel-head h3{font-size:1rem}.panel-head p{font-size:.72rem;color:rgba(255,255,255,.75);margin-top:3px}
.panel-badge{background:rgba(255,255,255,.13);font-size:.68rem;font-weight:800;padding:6px 10px;border-radius:999px}
.table-wrap{overflow:auto;border:1px solid var(--line);border-radius:0 0 14px 14px;background:#fff}
table{width:100%;border-collapse:separate;border-spacing:0}
th{background:#f8fafc;color:#64748b;font-size:.66rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;padding:10px;text-align:left;white-space:nowrap;border-bottom:1px solid var(--line)}
td{padding:10px;border-bottom:1px solid #f1f5f9;font-size:.78rem;vertical-align:middle}
tr:hover td{background:#f8faff}
.num{width:30px;height:30px;border-radius:8px;background:#eef2ff;color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:.74rem;font-weight:800}
.input-sm{width:90px;height:34px;text-align:center;border:1.5px solid #cbd5e1;border-radius:8px;font-size:.78rem}
.percent{display:inline-flex;min-width:55px;justify-content:center;padding:5px 9px;border-radius:999px;background:#eef2ff;color:var(--blue);font-weight:800;font-size:.72rem}
.footer-actions{display:flex;justify-content:flex-end;gap:10px;background:#f8fafc;padding:14px 18px;border-top:1px solid var(--line);border-radius:0 0 14px 14px}
.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.quick{padding:16px 18px;display:flex;align-items:center;gap:13px;min-height:96px}
.qico{width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0}
.qico.blue{background:#eef2ff;color:var(--blue)}.qico.good{background:#dcfce7;color:#166534}.qico.warn{background:#fef3c7;color:#92400e}
.quick .label{font-size:.65rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em}
.quick .value{font-size:1.35rem;font-weight:800;color:var(--text);margin-top:4px}
.history-card{overflow:hidden}
.history-top{background:linear-gradient(135deg,var(--blue-dark),var(--blue));color:#fff;padding:18px 20px;display:flex;justify-content:space-between;align-items:center}
.history-top h3{font-size:1rem}.history-top p{font-size:.72rem;color:rgba(255,255,255,.72);margin-top:3px}
.status-pill{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:7px 12px;font-size:.72rem;font-weight:800}
.history-body{padding:18px}
.progress{height:7px;background:#e2e8f0;border-radius:999px;overflow:hidden}.progress span{display:block;height:100%;background:var(--blue);border-radius:999px}
.indicator-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:14px}
.ind-mini{background:#f8fafc;border:1px solid var(--line);border-radius:12px;padding:12px}
.ind-mini-row{display:flex;justify-content:space-between;gap:10px;margin-bottom:8px;font-size:.75rem}
.ind-mini b{color:var(--blue)}
.upload-box{border:2px dashed #cbd5e1;border-radius:18px;background:#f8fafc;padding:42px;text-align:center}
.upload-icon{width:72px;height:72px;border-radius:999px;background:#dcfce7;color:#166534;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 14px}
.hidden{display:none}
@media(max-width:1000px){.form-grid,.quick-grid,.indicator-grid{grid-template-columns:1fr}.header-card{align-items:flex-start;flex-direction:column}.sidebar{position:relative;width:100%;height:auto}.main{margin-left:0}body{display:block}}


/* =========================================================
   PATCH RISKΑ — menjaga layout tetap sama seperti Oliv
   ========================================================= */

.topbar{display:none!important}
.layout{display:block!important;width:100%!important;min-height:100vh!important}

/* Pastikan area konten selebar Oliv, tidak mepet/kecil */
.main{
  margin-left:230px!important;
  flex:1!important;
  min-width:0!important;
  width:calc(100vw - 230px)!important;
  max-width:none!important;
}
.content{
  padding:26px!important;
  display:flex!important;
  flex-direction:column!important;
  gap:18px!important;
  width:100%!important;
  max-width:none!important;
  align-items:stretch!important;
}

/* Riska punya beberapa halaman dalam satu file */
.page{
  display:none!important;
  width:100%!important;
  max-width:none!important;
  align-self:stretch!important;
}
.page.active{
  display:flex!important;
  flex-direction:column!important;
  gap:18px!important;
  width:100%!important;
  max-width:none!important;
  align-self:stretch!important;
}
.page > *{
  width:100%!important;
  max-width:none!important;
  margin-left:0!important;
  margin-right:0!important;
}

/* Header Riska dibuat identik seperti header-card Oliv */
.page-header{
  background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 58%,#0a3d2e 100%)!important;
  color:#fff!important;
  border-radius:16px!important;
  padding:24px 28px!important;
  box-shadow:0 4px 20px rgba(0,51,153,.18)!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  gap:0!important;
  align-items:flex-start!important;
}
.page-header h2{
  font-size:1.35rem!important;
  font-weight:700!important;
  margin-bottom:8px!important;
  letter-spacing:.2px!important;
  color:#fff!important;
  display:flex!important;
  align-items:center!important;
  gap:10px!important;
  line-height:1.25!important;
}
.page-header h2 i{
  color:#fff!important;
  font-size:1.1rem!important;
}
.page-header p{
  font-size:.84rem!important;
  color:rgba(255,255,255,.75)!important;
  line-height:1.55!important;
  margin:0!important;
}

/* Sidebar logout: jangan pernah berubah jadi tombol putih */
.sidebar form{
  margin:0!important;
  padding:0!important;
  background:transparent!important;
  border:0!important;
  width:100%!important;
}
.sidebar button.nav-item,
.sidebar .logout-btn{
  appearance:none!important;
  -webkit-appearance:none!important;
  outline:none!important;
  box-shadow:none!important;
  border:0!important;
  background:transparent!important;
  width:100%!important;
  text-align:left!important;
}
.sidebar button.nav-item:hover,
.sidebar .logout-btn:hover{
  background:rgba(255,255,255,.08)!important;
  color:#fff!important;
}

/* Card statistik Riska mengikuti quick card Oliv */
.stat-grid{
  display:grid!important;
  grid-template-columns:repeat(4,1fr)!important;
  gap:16px!important;
  margin-bottom:6px!important;
}
.stat-card{
  background:var(--card)!important;
  border-radius:14px!important;
  box-shadow:var(--shadow)!important;
  border:1px solid rgba(15,23,42,.05)!important;
  padding:16px 18px!important;
  display:flex!important;
  align-items:center!important;
  gap:13px!important;
  min-height:96px!important;
  position:relative!important;
  overflow:hidden!important;
  transition:transform .2s,box-shadow .2s!important;
}
.stat-card:hover{transform:translateY(-2px)!important;box-shadow:0 8px 32px rgba(15,23,42,.12)!important}
.stat-card::before{display:none!important}
.stat-icon{
  position:static!important;
  width:46px!important;
  height:46px!important;
  border-radius:13px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  font-size:1.15rem!important;
  flex-shrink:0!important;
  opacity:1!important;
  background:#eef2ff!important;
  color:var(--blue)!important;
  order:-1!important;
}
.stat-card.teal .stat-icon{background:#dcfce7!important;color:#166534!important}
.stat-card.sky .stat-icon{background:#fef3c7!important;color:#92400e!important}
.stat-card.amber .stat-icon{background:var(--yellow-soft)!important;color:#8a6b00!important}
.stat-label{
  font-size:.65rem!important;
  font-weight:700!important;
  color:var(--muted)!important;
  text-transform:uppercase!important;
  letter-spacing:.08em!important;
  padding:0!important;
}
.stat-value{
  font-size:1.35rem!important;
  font-weight:800!important;
  font-family:'Segoe UI',sans-serif!important;
  letter-spacing:0!important;
  line-height:1.1!important;
  color:var(--text)!important;
  margin-top:4px!important;
}
.stat-sub{font-size:.7rem!important;color:var(--muted)!important;margin-top:4px!important}

/* Riska card, table, filter agar selaras dengan Oliv */
.chart-grid{
  display:grid!important;
  grid-template-columns:1fr 1fr!important;
  gap:20px!important;
  margin-bottom:6px!important;
  width:100%!important;
}
.chart-card,
.table-card,
.detail-panel{
  background:var(--card)!important;
  border-radius:14px!important;
  box-shadow:var(--shadow)!important;
  border:1px solid rgba(15,23,42,.05)!important;
  width:100%!important;
  max-width:none!important;
}
.chart-card{padding:22px!important}
.chart-card.wide{grid-column:1/-1!important}
.chart-title,.table-title{font-size:14px!important;font-weight:700!important;color:var(--text)!important}
.chart-sub{font-size:12px!important;color:var(--muted)!important;margin-bottom:18px!important}
.chart-title i,.detail-name i{color:var(--blue)!important;margin-right:8px!important}

.filter-bar{
  display:flex!important;
  gap:10px!important;
  flex-wrap:wrap!important;
  align-items:center!important;
  margin-bottom:6px!important;
  background:var(--card)!important;
  border-radius:14px!important;
  box-shadow:var(--shadow)!important;
  border:1px solid rgba(15,23,42,.05)!important;
  padding:17px 20px!important;
  width:100%!important;
}
.filter-bar label{font-size:12px!important;font-weight:700!important;color:var(--muted)!important}
.filter-bar select,.filter-bar input,.table-search,input,select{
  border:1px solid var(--border)!important;
  border-radius:8px!important;
  background:var(--card)!important;
  color:var(--text)!important;
  font-family:'Segoe UI',sans-serif!important;
  outline:none!important;
}
.filter-bar select,.filter-bar input{padding:7px 12px!important;font-size:13px!important}
.table-search{padding:7px 14px!important;width:220px!important;font-size:13px!important}

.table-card{overflow:hidden!important;margin-bottom:6px!important}
.table-header{
  padding:18px 22px 14px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  gap:12px!important;
}
table{width:100%!important;border-collapse:collapse!important;font-size:13px!important}
thead th,.ind-table th{
  background:linear-gradient(135deg,var(--blue-dark),var(--blue))!important;
  color:#fff!important;
  padding:11px 16px!important;
  text-align:left!important;
  font-size:11px!important;
  font-weight:700!important;
  text-transform:uppercase!important;
  letter-spacing:.5px!important;
  border-bottom:1px solid var(--border)!important;
  white-space:nowrap!important;
}
tbody tr{border-bottom:1px solid var(--border)!important;transition:background .15s!important}
tbody tr:hover{background:#f8faff!important}
tbody td{padding:11px 16px!important;color:#334155!important}
.rank{font-family:'JetBrains Mono',monospace!important;font-weight:600!important;font-size:12px!important;color:var(--muted)!important}

.btn-green,
button[onclick*='showPuskDetail'],
button[onclick*='document.getElementById']{
  padding:7px 18px!important;
  background:var(--blue)!important;
  color:#fff!important;
  border:none!important;
  border-radius:8px!important;
  font-size:13px!important;
  font-weight:700!important;
  font-family:'Segoe UI',sans-serif!important;
  cursor:pointer!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:7px!important;
}
.btn-green:hover,
button[onclick*='showPuskDetail']:hover,
button[onclick*='document.getElementById']:hover{background:var(--blue-dark)!important}

.pbar{flex:1!important;height:7px!important;background:#e2e8f0!important;border-radius:4px!important;overflow:hidden!important}
.pbar-fill{height:100%!important;border-radius:4px!important;transition:width .6s!important}
.pbar-wrap{display:flex!important;align-items:center!important;gap:10px!important}
.pbar-val{font-family:'JetBrains Mono',monospace!important;font-size:12px!important;font-weight:600!important;width:44px!important;text-align:right!important}
.badge{display:inline-block!important;padding:2px 8px!important;border-radius:20px!important;font-size:11px!important;font-weight:600!important}
.badge-green{background:#dcfce7!important;color:#166534!important}
.badge-amber{background:#fef3c7!important;color:#92400e!important}
.badge-red{background:#fee2e2!important;color:#991b1b!important}

.detail-panel{padding:24px!important;margin-bottom:6px!important}
.detail-name{font-size:22px!important;font-weight:800!important;margin-bottom:4px!important;color:var(--text)!important}
.detail-meta{font-size:13px!important;color:var(--muted)!important;margin-bottom:20px!important}
.section-title{font-size:13px!important;font-weight:700!important;color:var(--muted)!important;text-transform:uppercase!important;letter-spacing:.6px!important;margin-bottom:12px!important}

/* Donut tidak nabrak */
.chart-card:has(#chart-donut){min-height:420px!important}
.chart-card .chart-wrap:has(#chart-donut){
  height:220px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  overflow:hidden!important;
}
#chart-donut{
  width:220px!important;
  height:220px!important;
  max-width:220px!important;
  max-height:220px!important;
}
#donut-legend{
  margin-top:16px!important;
  font-size:12px!important;
  display:flex!important;
  flex-direction:column!important;
  gap:8px!important;
  position:relative!important;
  z-index:3!important;
}

@media(max-width:1100px){
  .stat-grid{grid-template-columns:repeat(2,1fr)!important}
  .chart-grid{grid-template-columns:1fr!important}
}
@media(max-width:760px){
  .sidebar{display:none!important}
  .main{margin-left:0!important;width:100%!important}
  .content{padding:16px!important}
  .stat-grid{grid-template-columns:1fr!important}
  .table-header{align-items:flex-start!important;flex-direction:column!important}
  .table-search{width:100%!important}
}

</style>
</head>
<body>

<!-- ════════════════════ MAIN APP ════════════════════ -->
<div id="app">
<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sb-logo">
        <div class="sb-logo-row">
          <div class="sb-icon"><i class="fa-solid fa-heart-pulse"></i></div>
          <div>
            <h1>SIP-PHBS</h1>
            <p>Sistem Informasi Pelaporan PHBS</p>
          </div>
        </div>
      </div>

      <nav class="sb-nav">
        <div class="nav-section">Menu Utama</div>

        <div class="nav-item active" onclick="showPage('dashboard')">
          <i class="fa-solid fa-chart-line icon"></i> Dashboard
        </div>

        <div class="nav-item" onclick="showPage('input-data')">
          <i class="fa-solid fa-clipboard-list icon"></i> Input Data
        </div>

        <div class="nav-item" onclick="showPage('tabel-puskesmas')">
          <i class="fa-solid fa-hospital icon"></i> Data Puskesmas
        </div>

        <div class="nav-item" onclick="showPage('lihat-history')">
          <i class="fa-solid fa-calendar-days icon"></i> Lihat History
        </div>

        <div class="nav-divider"></div>

        <div class="nav-section">Analisis</div>

        <div class="nav-item" onclick="showPage('per-indikator')">
          <i class="fa-solid fa-chart-column icon"></i> Per Indikator
        </div>

        <div class="nav-item" onclick="showPage('perbandingan')">
          <i class="fa-solid fa-scale-balanced icon"></i> Perbandingan
        </div>

        <div class="nav-section">Akun</div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-item logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </button>
        </form>
      </nav>

      <div class="sb-footer">
        <div class="user-name">Admin Dinkes</div>
        <div class="user-role">dinkes • SIP-PHBS</div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <div class="content">
<!-- ── PAGE: DASHBOARD ── -->
      <div id="page-dashboard" class="page active">
        <div class="page-header">
          <h2><i class="fa-solid fa-chart-line"></i> Dashboard Kabupaten</h2>
          <p>Rekapitulasi PHBS Tatanan Rumah Tangga — Sleman 2025</p>
        </div>

        <!-- Stats -->
        <div class="stat-grid">
          <div class="stat-card green">
            <span class="stat-icon"><i class="fa-solid fa-house-user"></i></span>
            <div class="stat-label">Total KK Diperiksa</div>
            <div class="stat-value" id="stat-kk">0</div>
            <div class="stat-sub">seluruh puskesmas</div>
          </div>
          <div class="stat-card teal">
            <span class="stat-icon"><i class="fa-solid fa-circle-check"></i></span>
            <div class="stat-label">KK Ber-PHBS</div>
            <div class="stat-value" id="stat-phbs">0</div>
            <div class="stat-sub">memenuhi kriteria PHBS</div>
          </div>
          <div class="stat-card sky">
            <span class="stat-icon"><i class="fa-solid fa-chart-simple"></i></span>
            <div class="stat-label">% Ber-PHBS</div>
            <div class="stat-value" id="stat-pct">0%</div>
            <div class="stat-sub">rata-rata kabupaten</div>
          </div>
          <div class="stat-card amber">
            <span class="stat-icon"><i class="fa-solid fa-hospital"></i></span>
            <div class="stat-label">Puskesmas</div>
            <div class="stat-value">25</div>
            <div class="stat-sub">unit pelayanan aktif</div>
          </div>
        </div>

        <!-- Charts row 1 -->
        <div class="chart-grid">
          <div class="chart-card wide">
            <div class="chart-title">Tren Ber-PHBS per Bulan (Kumulatif Kabupaten)</div>
            <div class="chart-sub">Jumlah KK yang memenuhi syarat PHBS sepanjang tahun 2025</div>
            <div class="chart-wrap" style="height:220px;">
              <canvas id="chart-tren"></canvas>
            </div>
          </div>
        </div>

        <div class="chart-grid">
          <div class="chart-card">
            <div class="chart-title">% Ber-PHBS per Puskesmas</div>
            <div class="chart-sub">Ranking capaian PHBS tahun 2025</div>
            <div class="chart-wrap" style="height:360px;">
              <canvas id="chart-bar"></canvas>
            </div>
          </div>
          <div class="chart-card">
            <div class="chart-title">Distribusi Capaian</div>
            <div class="chart-sub">Kategori puskesmas berdasarkan % PHBS</div>
            <div class="chart-wrap" style="height:200px;display:flex;align-items:center;justify-content:center;">
              <canvas id="chart-donut" style="width:220px;height:220px;max-width:220px;max-height:220px;"></canvas>
            </div>
            <div id="donut-legend" style="margin-top:14px;font-size:12px;display:flex;flex-direction:column;gap:6px;"></div>
          </div>
        </div>

        <!-- Top 5 table -->
        <div class="section-title">Ranking Puskesmas</div>
        <div class="table-card">
          <div class="table-header">
            <div class="table-title">Semua Puskesmas — Urut % Ber-PHBS</div>
            <input class="table-search" type="text" placeholder="Cari puskesmas…" oninput="filterTable(this.value)">
          </div>
          <div style="overflow-x:auto;">
            <table id="main-table">
              <thead>
                <tr>
                  <th onclick="sortTable(0)">#</th>
                  <th onclick="sortTable(1)">Puskesmas ↕</th>
                  <th onclick="sortTable(2)">Total KK ↕</th>
                  <th onclick="sortTable(3)">Ber-PHBS ↕</th>
                  <th onclick="sortTable(4)">% Ber-PHBS ↕</th>
                  <th>Capaian</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="table-body"></tbody>
            </table>
          </div>
        </div>
      </div><!-- /page-dashboard -->


      <!-- ── PAGE: INPUT DATA ── -->
      <div id="page-input-data" class="page">
        <div class="page-header">
          <h2><i class="fa-solid fa-clipboard-list"></i> Input Data PHBS</h2>
          <p>Masukkan data rekapitulasi PHBS bulanan per puskesmas</p>
        </div>

        <div class="filter-bar" style="margin-bottom:24px;">
          <div style="background:var(--green-pale);border-radius:10px;padding:14px 20px;font-size:13px;color:var(--green);font-weight:600;border:1px solid #bbf7d0;">
            <i class="fa-solid fa-circle-info"></i> Pilih metode input data:
          </div>
        </div>

        <div class="chart-grid">
          <div class="chart-card">
            <div class="chart-title"><i class="fa-solid fa-file-excel"></i> Import Excel</div>
            <div class="chart-sub">Upload file Excel sesuai format Dashboard_PHBS_RT_2025.xlsx</div>
            <div style="margin-top:12px;">
              <input type="file" id="excel-file" accept=".xlsx,.xls" style="display:none;" onchange="previewExcel(this)">
              <button class="btn-green" onclick="document.getElementById('excel-file').click()"><i class="fa-solid fa-folder-open"></i> Pilih File Excel</button>
              <div id="excel-status" style="margin-top:12px;font-size:13px;color:var(--text-muted);"></div>
            </div>
          </div>
          <div class="chart-card">
            <div class="chart-title"><i class="fa-solid fa-pen-to-square"></i> Input Manual</div>
            <div class="chart-sub">Isi data langsung lewat formulir di bawah</div>
            <div style="margin-top:12px;">
              <button class="btn-green" onclick="showManualForm()"><i class="fa-solid fa-file-lines"></i> Buka Formulir</button>
            </div>
          </div>
        </div>

        <!-- Manual Form -->
        <div id="manual-form" style="display:none;" class="detail-panel">
          <div class="chart-title" style="margin-bottom:16px;">Formulir Input Data Bulanan</div>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:16px;">
            <div class="form-group" style="margin:0;">
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Puskesmas</label>
              <select id="f-pusk" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;">
              </select>
            </div>
            <div class="form-group" style="margin:0;">
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Bulan</label>
              <select id="f-bulan" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;">
                <option>Januari</option><option>Februari</option><option>Maret</option>
                <option>April</option><option>Mei</option><option>Juni</option>
                <option>Juli</option><option>Agustus</option><option>September</option>
                <option>Oktober</option><option>November</option><option>Desember</option>
              </select>
            </div>
            <div class="form-group" style="margin:0;">
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Tahun</label>
              <input type="number" id="f-tahun" value="2025" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;">
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:16px;">
            <div>
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Jumlah KK Laki-laki</label>
              <input type="number" id="f-kkl" placeholder="0" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;" oninput="calcTotal()">
            </div>
            <div>
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Jumlah KK Perempuan</label>
              <input type="number" id="f-kkp" placeholder="0" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;" oninput="calcTotal()">
            </div>
            <div>
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Total KK (otomatis)</label>
              <input type="number" id="f-kktotal" readonly style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;background:#f8fafc;outline:none;">
            </div>
          </div>

          <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:20px;">
            <div>
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">Jumlah Ber-PHBS</label>
              <input type="number" id="f-phbs" placeholder="0" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;" oninput="calcPct()">
            </div>
            <div>
              <label style="display:block;font-size:12px;font-weight:600;margin-bottom:6px;">% Ber-PHBS (otomatis)</label>
              <input type="text" id="f-pct" readonly style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;background:#f8fafc;outline:none;">
            </div>
          </div>

          <div style="display:flex;gap:10px;">
            <button class="btn-green" onclick="saveManual()"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
            <button onclick="document.getElementById('manual-form').style.display='none'"
              style="padding:7px 18px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;cursor:pointer;background:#fff;">Batal</button>
          </div>
        </div>

        <!-- Saved entries table -->
        <div id="new-entries" class="table-card" style="display:none;">
          <div class="table-header">
            <div class="table-title">Data Baru yang Disimpan</div>
          </div>
          <div style="overflow-x:auto;">
            <table>
              <thead><tr>
                <th>Puskesmas</th><th>Bulan</th><th>Tahun</th>
                <th>KK L</th><th>KK P</th><th>Total KK</th>
                <th>Ber-PHBS</th><th>%</th><th>Aksi</th>
              </tr></thead>
              <tbody id="new-entries-body"></tbody>
            </table>
          </div>
        </div>
      </div><!-- /page-input-data -->


      <!-- ── PAGE: TABEL PUSKESMAS ── -->
      <div id="page-tabel-puskesmas" class="page">
        <div class="page-header">
          <h2><i class="fa-solid fa-hospital"></i> Data Per Puskesmas</h2>
          <p>Klik nama puskesmas untuk melihat detail data bulanan</p>
        </div>

        <div class="filter-bar">
          <label>Filter:</label>
          <select id="pusk-filter-status" onchange="renderPuskTable()">
            <option value="all">Semua Status</option>
            <option value="baik">Baik (≥ 80%)</option>
            <option value="sedang">Sedang (65–79%)</option>
            <option value="kurang">Kurang (&lt; 65%)</option>
          </select>
          <input type="text" placeholder="Cari…" oninput="filterPuskTable(this.value)" style="padding:7px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;">
        </div>

        <div class="table-card">
          <div style="overflow-x:auto;">
            <table>
              <thead><tr>
                <th>#</th><th>Puskesmas</th>
                <th>Total KK</th><th>Ber-PHBS</th>
                <th>% PHBS</th><th>Status</th><th>Detail</th>
              </tr></thead>
              <tbody id="pusk-table-body"></tbody>
            </table>
          </div>
        </div>

        <!-- Detail puskesmas -->
        <div id="pusk-detail" style="display:none;" class="detail-panel">
          <div class="detail-name" id="detail-name">—</div>
          <div class="detail-meta" id="detail-meta">—</div>
          <div class="chart-wrap" style="height:200px;margin-bottom:20px;">
            <canvas id="chart-pusk-detail"></canvas>
          </div>
          <div class="section-title">Data Bulanan</div>
          <table class="ind-table">
            <thead><tr><th>Bulan</th><th>Total KK</th><th>Ber-PHBS</th><th>% Ber-PHBS</th><th>Capaian</th></tr></thead>
            <tbody id="detail-months-body"></tbody>
          </table>
        </div>
      </div><!-- /page-tabel-puskesmas -->


      <!-- ── PAGE: LIHAT HISTORY ── -->
      <div id="page-lihat-history" class="page">
        <div class="page-header">
          <h2><i class="fa-solid fa-calendar-days"></i> History per Bulan / Tahun</h2>
          <p>Lihat rekap data per periode waktu dan puskesmas</p>
        </div>

        <div class="filter-bar">
          <label>Puskesmas:</label>
          <select id="hist-pusk" onchange="renderHistory()">
            <option value="all">Semua</option>
          </select>
          <label>Bulan:</label>
          <select id="hist-bulan" onchange="renderHistory()">
            <option value="all">Semua Bulan</option>
            <option>Januari</option><option>Februari</option><option>Maret</option>
            <option>April</option><option>Mei</option><option>Juni</option>
            <option>Juli</option><option>Agustus</option><option>September</option>
            <option>Oktober</option><option>November</option><option>Desember</option>
          </select>
        </div>

        <div class="table-card">
          <div class="table-header">
            <div class="table-title">History Data PHBS</div>
            <div id="hist-count" style="font-size:12px;color:var(--text-muted);"></div>
          </div>
          <div style="overflow-x:auto;">
            <table>
              <thead><tr>
                <th>#</th><th>Puskesmas</th><th>Bulan</th>
                <th>Total KK</th><th>Ber-PHBS</th><th>% PHBS</th><th>Status</th>
              </tr></thead>
              <tbody id="hist-body"></tbody>
            </table>
          </div>
        </div>
      </div><!-- /page-lihat-history -->


      <!-- ── PAGE: PER INDIKATOR ── -->
      <div id="page-per-indikator" class="page">
        <div class="page-header">
          <h2><i class="fa-solid fa-chart-column"></i> Analisis Per Indikator</h2>
          <p>13 indikator PHBS Rumah Tangga Kabupaten Sleman 2025</p>
        </div>
        <div class="chart-card">
          <div class="chart-title">13 Indikator PHBS Rumah Tangga</div>
          <div class="chart-sub">Estimasi capaian rata-rata kabupaten per indikator (berdasarkan rata-rata proyeksi puskesmas)</div>
          <div class="chart-wrap" style="height:340px;">
            <canvas id="chart-indikator"></canvas>
          </div>
        </div>
        <div class="table-card" style="margin-top:20px;">
          <div class="table-header"><div class="table-title">Detail 13 Indikator PHBS</div></div>
          <div style="overflow-x:auto;">
            <table class="ind-table" id="ind-table-main">
              <thead><tr><th>#</th><th>Indikator</th><th>% Capaian (est.)</th><th>Capaian</th><th>Keterangan</th></tr></thead>
              <tbody id="ind-body"></tbody>
            </table>
          </div>
        </div>
      </div><!-- /page-per-indikator -->


      <!-- ── PAGE: PERBANDINGAN ── -->
      <div id="page-perbandingan" class="page">
        <div class="page-header">
          <h2><i class="fa-solid fa-scale-balanced"></i> Perbandingan Antar Puskesmas</h2>
          <p>Pilih 2–4 puskesmas untuk dibandingkan secara visual</p>
        </div>
        <div class="filter-bar">
          <label>Pilih (maks 4):</label>
          <select id="cmp1"><option value="">— Puskesmas 1 —</option></select>
          <select id="cmp2"><option value="">— Puskesmas 2 —</option></select>
          <select id="cmp3"><option value="">— Puskesmas 3 —</option></select>
          <select id="cmp4"><option value="">— Puskesmas 4 —</option></select>
          <button class="btn-green" onclick="renderCompare()">Bandingkan</button>
        </div>
        <div class="chart-card">
          <div class="chart-title">Tren Ber-PHBS (% per bulan)</div>
          <div class="chart-wrap" style="height:280px;">
            <canvas id="chart-cmp"></canvas>
          </div>
        </div>
      </div><!-- /page-perbandingan -->

    </div><!-- /content -->
    </main><!-- /main -->
  </div><!-- /layout -->
</div><!-- /app -->

<script>
// ═══════════════════════════════════════════════════════
//  DATA — dari Controller Laravel (PhbsController@index)
// ═══════════════════════════════════════════════════════
const RAW = {!! json_encode($raw) !!};


// ═══════════════════════════════════════════════════════
//  DATA — diambil dari Dashboard_PHBS_RT_2025.xlsx
// ═══════════════════════════════════════════════════════


const INDIKATORS = [
  "Persalinan ditolong nakes","Memberi bayi ASI eksklusif","Menimbang balita setiap bulan",
  "Menggunakan air bersih","Mencuci tangan dg air bersih & sabun","Pengelolaan air minum & makan RT",
  "Menggunakan jamban sehat","Pengelolaan limbah cair RT","Membuang sampah di tempat sampah",
  "Memberantas jentik di rumah","Makan sayur & buah setiap hari","Melakukan aktivitas fisik setiap hari",
  "Tidak merokok di dalam rumah"
];
// Estimated capaian per indikator (avg dari proyeksi semua puskesmas)
const IND_PCT = [100, 93.9, 97.0, 99.7, 99.1, 99.5, 98.1, 94.8, 96.7, 97.8, 97.4, 98.1, 73.0];

const BULAN_ORDER = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
const COLORS = ['#003399','#FFCC00','#0044cc','#f59e0b','#0a3d2e','#ef4444','#1a4db3','#8a6b00','#0284c7','#64748b','#16a34a','#d97706'];

// ─── state ───
let newEntries = [];
let puskDetailChart = null;
let cmpChart = null;
let sortDir = 1;
let currentSort = 4; // sort by pct desc default

// ─── INIT ───
document.addEventListener("DOMContentLoaded", initApp);
function initApp(){
  populateSelects();
  renderStats();
  renderTrenChart();
  renderBarChart();
  renderDonut();
  renderMainTable();
  renderPuskTable();
  renderHistory();
  renderIndikator();
  initCompare();
  populateFormPusk();
}

// ─── SELECTS ───
function populateSelects(){
  const ids = ['hist-pusk'];
  ids.forEach(id => {
    const sel = document.getElementById(id);
    Object.keys(RAW).forEach(pk => {
      const o = document.createElement('option');
      o.value = pk; o.textContent = pk;
      sel.appendChild(o);
    });
  });
}
function populateFormPusk(){
  const sel = document.getElementById('f-pusk');
  Object.keys(RAW).forEach(pk => {
    const o = document.createElement('option'); o.value=pk; o.textContent=pk; sel.appendChild(o);
  });
}

// ─── PAGES ───
function showPage(id){
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-'+id).classList.add('active');
  event.currentTarget.classList.add('active');
}

// ─── STATS ───
function renderStats(){
  let totKK=0, totPhbs=0;
  Object.values(RAW).forEach(d => { totKK+=d.total_kk; totPhbs+=d.ber_phbs; });
  const pct = totKK>0 ? (totPhbs/totKK*100).toFixed(1) : 0;
  document.getElementById('stat-kk').textContent = totKK.toLocaleString('id');
  document.getElementById('stat-phbs').textContent = totPhbs.toLocaleString('id');
  document.getElementById('stat-pct').textContent = pct+'%';
}

// ─── TREN CHART ───
function renderTrenChart(){
  const monthly = {};
  BULAN_ORDER.forEach(b => monthly[b] = {kk:0, phbs:0});
  Object.values(RAW).forEach(d => {
    d.months.forEach(m => {
      const b = m.bulan==='Nopember'?'November':m.bulan;
      if(monthly[b]){ monthly[b].kk+=m.kk; monthly[b].phbs+=m.ber_phbs; }
    });
  });
  const labels = BULAN_ORDER.map(b=>b.slice(0,3));
  const data = BULAN_ORDER.map(b => monthly[b].kk>0 ? +(monthly[b].phbs/monthly[b].kk*100).toFixed(1) : 0);
  new Chart(document.getElementById('chart-tren'),{
    type:'line',
    data:{labels,datasets:[{
      label:'% Ber-PHBS',data,
      borderColor:'#003399',backgroundColor:'rgba(0,51,153,.10)',
      fill:true, tension:.4, pointBackgroundColor:'#003399', pointRadius:4
    }]},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{display:false}},
      scales:{y:{min:0,max:100,ticks:{callback:v=>v+'%'},grid:{color:'#f1f5f9'}},
               x:{grid:{color:'#f1f5f9'}}}}
  });
}

// ─── BAR CHART ───
function renderBarChart(){
  const sorted = Object.entries(RAW).sort((a,b)=>b[1].pct-a[1].pct);
  const labels = sorted.map(e=>e[0]);
  const data   = sorted.map(e=>e[1].pct);
  const colors = data.map(v => v>=80?'#16a34a':v>=65?'#d97706':'#dc2626');
  new Chart(document.getElementById('chart-bar'),{
    type:'bar',
    data:{labels,datasets:[{label:'% Ber-PHBS',data,backgroundColor:colors,borderRadius:5}]},
    options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,
      plugins:{legend:{display:false}},
      scales:{x:{min:0,max:100,ticks:{callback:v=>v+'%'},grid:{color:'#f1f5f9'}},
               y:{ticks:{font:{size:10}},grid:{display:false}}}}
  });
}

// ─── DONUT CHART ───
function renderDonut(){
  const counts = {baik:0,sedang:0,kurang:0};
  Object.values(RAW).forEach(d => {
    if(d.pct>=80) counts.baik++;
    else if(d.pct>=65) counts.sedang++;
    else counts.kurang++;
  });
  new Chart(document.getElementById('chart-donut'),{
    type:'doughnut',
    data:{
      labels:['Baik (≥80%)','Sedang (65–79%)','Kurang (<65%)'],
      datasets:[{data:[counts.baik,counts.sedang,counts.kurang],
        backgroundColor:['#16a34a','#d97706','#dc2626'],borderWidth:0}]
    },
    options:{responsive:true,maintainAspectRatio:false,cutout:'65%',plugins:{legend:{display:false}},
      animation:{animateRotate:true}}
  });
  const leg = document.getElementById('donut-legend');
  const items=[
    {label:`Baik (≥80%) — ${counts.baik} puskesmas`,color:'#16a34a'},
    {label:`Sedang (65–79%) — ${counts.sedang} puskesmas`,color:'#d97706'},
    {label:`Kurang (<65%) — ${counts.kurang} puskesmas`,color:'#dc2626'}
  ];
  leg.innerHTML = items.map(i=>
    `<div style="display:flex;align-items:center;gap:8px;">
      <div style="width:12px;height:12px;border-radius:3px;background:${i.color};flex-shrink:0;"></div>
      <span>${i.label}</span></div>`
  ).join('');
}

// ─── MAIN TABLE ───
let tableData = [];
function renderMainTable(){
  tableData = Object.entries(RAW).map(([name,d],i) => ({name, kk:d.total_kk, phbs:d.ber_phbs, pct:d.pct}));
  tableData.sort((a,b)=>b.pct-a.pct);
  drawTable(tableData);
}
function drawTable(data){
  const tb = document.getElementById('table-body');
  tb.innerHTML = data.map((r,i) => {
    const color = r.pct>=80?'#16a34a':r.pct>=65?'#d97706':'#dc2626';
    const badge = r.pct>=80?'badge-green':r.pct>=65?'badge-amber':'badge-red';
    const status = r.pct>=80?'Baik':r.pct>=65?'Sedang':'Kurang';
    return `<tr>
      <td class="rank">${i+1}</td>
      <td style="font-weight:600;">${r.name}</td>
      <td>${r.kk.toLocaleString('id')}</td>
      <td>${r.phbs.toLocaleString('id')}</td>
      <td>
        <div class="pbar-wrap">
          <div class="pbar"><div class="pbar-fill" style="width:${r.pct}%;background:${color};"></div></div>
          <div class="pbar-val" style="color:${color};">${r.pct}%</div>
        </div>
      </td>
      <td><div class="pbar-wrap"><div class="pbar"><div class="pbar-fill" style="width:${r.pct}%;background:${color};"></div></div></div></td>
      <td><span class="badge ${badge}">${status}</span></td>
    </tr>`;
  }).join('');
}
function filterTable(q){
  const f = q.toLowerCase();
  const filtered = tableData.filter(r => r.name.toLowerCase().includes(f));
  drawTable(filtered);
}
function sortTable(col){
  const keys = ['_rank','name','kk','phbs','pct'];
  if(currentSort===col) sortDir*=-1; else { sortDir=1; currentSort=col; }
  tableData.sort((a,b) => {
    const av = a[keys[col]], bv = b[keys[col]];
    if(typeof av==='string') return sortDir*av.localeCompare(bv);
    return sortDir*(av-bv);
  });
  drawTable(tableData);
}

// ─── PUSK TABLE ───
function renderPuskTable(){
  const status = document.getElementById('pusk-filter-status').value;
  let data = Object.entries(RAW).map(([name,d])=>({name,...d}));
  if(status==='baik') data=data.filter(d=>d.pct>=80);
  if(status==='sedang') data=data.filter(d=>d.pct>=65&&d.pct<80);
  if(status==='kurang') data=data.filter(d=>d.pct<65);
  data.sort((a,b)=>b.pct-a.pct);
  document.getElementById('pusk-detail').style.display='none';
  const tb = document.getElementById('pusk-table-body');
  tb.innerHTML = data.map((r,i)=>{
    const color = r.pct>=80?'#16a34a':r.pct>=65?'#d97706':'#dc2626';
    const badge = r.pct>=80?'badge-green':r.pct>=65?'badge-amber':'badge-red';
    const status = r.pct>=80?'Baik':r.pct>=65?'Sedang':'Kurang';
    return `<tr>
      <td class="rank">${i+1}</td>
      <td style="font-weight:600;">${r.name}</td>
      <td>${r.total_kk.toLocaleString('id')}</td>
      <td>${r.ber_phbs.toLocaleString('id')}</td>
      <td><span style="font-family:'JetBrains Mono',monospace;font-weight:700;color:${color};">${r.pct}%</span></td>
      <td><span class="badge ${badge}">${status}</span></td>
      <td><button onclick="showPuskDetail('${r.name}')" style="padding:5px 12px;background:var(--green);color:#fff;border:none;border-radius:6px;font-size:12px;font-family:inherit;cursor:pointer;"><i class="fa-solid fa-eye"></i> Detail</button></td>
    </tr>`;
  }).join('');
}
function filterPuskTable(q){
  const rows = document.querySelectorAll('#pusk-table-body tr');
  rows.forEach(r => {
    r.style.display = r.cells[1].textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
  });
}
function showPuskDetail(name){
  const d = RAW[name];
  if(!d) return;
  document.getElementById('pusk-detail').style.display='block';
  document.getElementById('detail-name').innerHTML = '<i class="fa-solid fa-hospital"></i> ' + name;
  document.getElementById('detail-meta').textContent = `Total KK: ${d.total_kk.toLocaleString('id')} | Ber-PHBS: ${d.ber_phbs.toLocaleString('id')} | Persentase: ${d.pct}%`;
  // monthly table
  const tb = document.getElementById('detail-months-body');
  tb.innerHTML = d.months.map(m=>{
    const pct = m.kk>0?(m.ber_phbs/m.kk*100).toFixed(1):0;
    const color = pct>=80?'#16a34a':pct>=65?'#d97706':'#dc2626';
    return `<tr>
      <td>${m.bulan}</td>
      <td>${m.kk.toLocaleString('id')}</td>
      <td>${m.ber_phbs.toLocaleString('id')}</td>
      <td style="font-weight:700;color:${color};">${pct}%</td>
      <td><div class="pbar"><div class="pbar-fill" style="width:${pct}%;background:${color};"></div></div></td>
    </tr>`;
  }).join('');
  // chart
  if(puskDetailChart) puskDetailChart.destroy();
  const ctx = document.getElementById('chart-pusk-detail');
  puskDetailChart = new Chart(ctx,{
    type:'bar',
    data:{
      labels: d.months.map(m=>m.bulan.slice(0,3)),
      datasets:[
        {label:'Total KK',data:d.months.map(m=>m.kk),backgroundColor:'rgba(2,132,199,.2)',borderColor:'#0284c7',borderWidth:1,borderRadius:4},
        {label:'Ber-PHBS',data:d.months.map(m=>m.ber_phbs),backgroundColor:'rgba(22,163,74,.6)',borderColor:'#16a34a',borderWidth:1,borderRadius:4}
      ]
    },
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top'}},
      scales:{y:{grid:{color:'#f1f5f9'}},x:{grid:{display:false}}}}
  });
  document.getElementById('pusk-detail').scrollIntoView({behavior:'smooth'});
}

// ─── HISTORY ───
function renderHistory(){
  const pusk = document.getElementById('hist-pusk').value;
  const bulan = document.getElementById('hist-bulan').value;
  const rows = [];
  Object.entries(RAW).forEach(([name,d])=>{
    if(pusk!=='all' && name!==pusk) return;
    d.months.forEach(m=>{
      const b = m.bulan==='Nopember'?'November':m.bulan;
      if(bulan!=='all' && b!==bulan) return;
      const pct = m.kk>0?(m.ber_phbs/m.kk*100).toFixed(1):0;
      rows.push({name, bulan:m.bulan, kk:m.kk, phbs:m.ber_phbs, pct:parseFloat(pct)});
    });
  });
  document.getElementById('hist-count').textContent = `${rows.length} entri`;
  const tb = document.getElementById('hist-body');
  tb.innerHTML = rows.map((r,i)=>{
    const color = r.pct>=80?'#16a34a':r.pct>=65?'#d97706':'#dc2626';
    const badge = r.pct>=80?'badge-green':r.pct>=65?'badge-amber':'badge-red';
    const status = r.pct>=80?'Baik':r.pct>=65?'Sedang':'Kurang';
    return `<tr>
      <td class="rank">${i+1}</td>
      <td style="font-weight:600;">${r.name}</td>
      <td>${r.bulan}</td>
      <td>${r.kk.toLocaleString('id')}</td>
      <td>${r.phbs.toLocaleString('id')}</td>
      <td style="font-weight:700;color:${color};">${r.pct}%</td>
      <td><span class="badge ${badge}">${status}</span></td>
    </tr>`;
  }).join('');
}

// ─── INDIKATOR ───
function renderIndikator(){
  new Chart(document.getElementById('chart-indikator'),{
    type:'bar',
    data:{
      labels:INDIKATORS.map((s,i)=>`${i+1}. ${s.length>30?s.slice(0,30)+'…':s}`),
      datasets:[{
        label:'% Capaian',data:IND_PCT,
        backgroundColor:IND_PCT.map(v=>v>=90?'rgba(22,163,74,.7)':v>=75?'rgba(13,148,136,.7)':'rgba(217,119,6,.7)'),
        borderRadius:5
      }]
    },
    options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,
      plugins:{legend:{display:false}},
      scales:{x:{min:0,max:100,ticks:{callback:v=>v+'%'},grid:{color:'#f1f5f9'}},
               y:{ticks:{font:{size:11}},grid:{display:false}}}}
  });
  const tb = document.getElementById('ind-body');
  tb.innerHTML = INDIKATORS.map((name,i)=>{
    const pct = IND_PCT[i];
    const color = pct>=90?'#16a34a':pct>=75?'#0d9488':'#d97706';
    const badge = pct>=90?'badge-green':pct>=75?'badge-green':'badge-amber';
    const ket = pct>=90?'Sangat Baik':pct>=75?'Baik':'Perlu Perhatian';
    return `<tr>
      <td class="rank">${i+1}</td>
      <td>${name}</td>
      <td><div class="pbar-wrap">
        <div class="pbar"><div class="pbar-fill" style="width:${pct}%;background:${color};"></div></div>
        <div class="pbar-val" style="color:${color};">${pct}%</div>
      </div></td>
      <td><div class="pbar"><div class="pbar-fill" style="width:${pct}%;background:${color};"></div></div></td>
      <td><span class="badge ${badge}">${ket}</span></td>
    </tr>`;
  }).join('');
}

// ─── COMPARE ───
function initCompare(){
  const names = Object.keys(RAW);
  ['cmp1','cmp2','cmp3','cmp4'].forEach(id=>{
    const sel = document.getElementById(id);
    names.forEach(pk=>{
      const o=document.createElement('option'); o.value=pk; o.textContent=pk; sel.appendChild(o);
    });
  });
  document.getElementById('cmp1').value='GODEAN I';
  document.getElementById('cmp2').value='MLATI II';
}
function renderCompare(){
  const sel = ['cmp1','cmp2','cmp3','cmp4']
    .map(id=>document.getElementById(id).value)
    .filter(v=>v);
  if(sel.length<2){ alert('Pilih minimal 2 puskesmas!'); return; }
  const labels = BULAN_ORDER.map(b=>b.slice(0,3));
  const datasets = sel.map((pk,i)=>{
    const d = RAW[pk];
    const byBulan = {};
    BULAN_ORDER.forEach(b=>byBulan[b]=null);
    d.months.forEach(m=>{
      const b = m.bulan==='Nopember'?'November':m.bulan;
      if(byBulan.hasOwnProperty(b) && m.kk>0) byBulan[b] = +(m.ber_phbs/m.kk*100).toFixed(1);
    });
    return {
      label:pk,
      data: BULAN_ORDER.map(b=>byBulan[b]),
      borderColor:COLORS[i], backgroundColor:COLORS[i]+'33',
      fill:false, tension:.4, pointRadius:4, spanGaps:true
    };
  });
  if(cmpChart) cmpChart.destroy();
  cmpChart = new Chart(document.getElementById('chart-cmp'),{
    type:'line',
    data:{labels,datasets},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top'}},
      scales:{y:{min:0,max:100,ticks:{callback:v=>v+'%'},grid:{color:'#f1f5f9'}},
               x:{grid:{color:'#f1f5f9'}}}}
  });
}

// ─── MANUAL FORM ───
function showManualForm(){
  document.getElementById('manual-form').style.display='block';
  document.getElementById('manual-form').scrollIntoView({behavior:'smooth'});
}
function calcTotal(){
  const l = parseInt(document.getElementById('f-kkl').value)||0;
  const p = parseInt(document.getElementById('f-kkp').value)||0;
  document.getElementById('f-kktotal').value = l+p;
  calcPct();
}
function calcPct(){
  const total = parseInt(document.getElementById('f-kktotal').value)||0;
  const phbs  = parseInt(document.getElementById('f-phbs').value)||0;
  document.getElementById('f-pct').value = total>0?(phbs/total*100).toFixed(1)+'%':'0%';
}
async function saveManual(){
  const pusk  = document.getElementById('f-pusk').value;
  const bulan = document.getElementById('f-bulan').value;
  const tahun = document.getElementById('f-tahun').value;
  const kkl   = parseInt(document.getElementById('f-kkl').value)||0;
  const kkp   = parseInt(document.getElementById('f-kkp').value)||0;
  const total = kkl+kkp;
  const phbs  = parseInt(document.getElementById('f-phbs').value)||0;
  const pct   = total>0?(phbs/total*100).toFixed(1):0;
  if(!total){ alert('Isi jumlah KK terlebih dahulu!'); return; }

  // ── Kirim ke server Laravel ──
  try {
    const res = await fetch('{{ route("phbs.simpan") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ puskesmas:pusk, bulan, tahun, jumlah_kk_total:total, ber_phbs:phbs })
    });
    const result = await res.json();
    if(result.status === 'ok'){
      document.getElementById('excel-status').innerHTML = `<i class="fa-solid fa-circle-check"></i> ${result.message}`;
    } else {
      document.getElementById('excel-status').innerHTML = `<i class="fa-solid fa-circle-xmark"></i> Gagal menyimpan data.`;
    }
  } catch(err) {
    document.getElementById('excel-status').innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> Error: ${err.message}`;
  }

  // Tambahkan juga ke tabel lokal sementara
  const entry = {pusk,bulan,tahun,kkl,kkp,total,phbs,pct};
  newEntries.push(entry);
  renderNewEntries();
  document.getElementById('new-entries').style.display='block';
  // clear form
  ['f-kkl','f-kkp','f-kktotal','f-phbs','f-pct'].forEach(id=>document.getElementById(id).value='');
}
function renderNewEntries(){
  const tb = document.getElementById('new-entries-body');
  tb.innerHTML = newEntries.map((e,i)=>`<tr>
    <td>${e.pusk}</td><td>${e.bulan}</td><td>${e.tahun}</td>
    <td>${e.kkl}</td><td>${e.kkp}</td><td>${e.total}</td>
    <td>${e.phbs}</td><td>${e.pct}%</td>
    <td><button onclick="newEntries.splice(${i},1);renderNewEntries();"
      style="padding:4px 10px;border:1px solid #dc2626;border-radius:6px;color:#dc2626;background:#fff;cursor:pointer;font-size:12px;"><i class="fa-solid fa-trash"></i> Hapus</button></td>
  </tr>`).join('');
}

// ─── EXCEL PREVIEW (stub) ───
function previewExcel(input){
  const file = input.files[0];
  if(!file) return;
  document.getElementById('excel-status').innerHTML = `<i class="fa-solid fa-file-lines"></i> File dipilih: ${file.name} (${(file.size/1024).toFixed(1)} KB). Untuk integrasi penuh gunakan SheetJS atau server-side PHP.`;
}

</script>
</body>
</html>