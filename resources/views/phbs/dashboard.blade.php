<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard PHBS Rumah Tangga — Kabupaten Sleman 2025</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* =========================================================
   STYLE DASHBOARD PUSKESMAS — disamakan dengan Dashboard Dinkes
   Fokus: font, sidebar, icon, card, tabel, tombol, spacing.
   ========================================================= */
:root{
  /* Colors */
  --green:#22c55e; --green-bg:#f0fdf4; --green-ring:#bbf7d0;
  --teal:#14b8a6; --teal-bg:#f0fdfa;
  --sky:#0ea5e9; --sky-bg:#f0f9ff;
  --amber:#f59e0b; --amber-bg:#fffbeb; --amber-ring:#fde68a;
  --red:#ef4444; --red-bg:#fef2f2; --red-ring:#fecaca;
  --orange:#f97316;
  --primary:#2563eb; --primary-dk:#1d4ed8; --primary-lt:#eff6ff;

  /* Sidebar */
  --sb-bg:#0f1629;
  --sb-hover:rgba(255,255,255,.06);
  --sb-active:rgba(255,255,255,.09);
  --sb-border:rgba(255,255,255,.07);
  --sb-text:rgba(255,255,255,.65);
  --sb-head:rgba(255,255,255,.30);

  /* Layout */
  --surface:#ffffff;
  --card:#ffffff;
  --bg:#f1f5f9;
  --border:#e2e8f0;
  --line:#e2e8f0;
  --text:#0f172a;
  --text-b:#475569;
  --text-muted:#94a3b8;
  --muted:#94a3b8;
  --soft:#f8fafc;
  --green-pale:#f0fdf4;

  /* Misc */
  --radius:12px;
  --radius-sm:8px;
  --shadow:0 1px 3px rgba(0,0,0,.08),0 1px 2px rgba(0,0,0,.04);
  --shadow-lg:0 10px 25px rgba(0,0,0,.12);
  --sidebar-w:220px;
  --mono:'JetBrains Mono',monospace;
}

/* ─── RESET ───────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;background:#f1f5f9;}
body{
  font-family:'Inter',sans-serif;
  background:var(--bg);
  color:var(--text-b);
  min-height:100vh;
  display:flex;
}
button,input,select,textarea{font-family:'Inter',sans-serif;}
a{text-decoration:none;color:inherit;}
.hidden{display:none!important;}

/* ─── APP LAYOUT ─────────────────────────────────────── */
#app,.layout{width:100%;min-height:100vh;display:block;}
.main{
  margin-left:var(--sidebar-w);
  width:calc(100vw - var(--sidebar-w));
  min-height:100vh;
  background:var(--bg);
  flex:1;
  min-width:0;
}
.content{
  padding:28px;
  display:flex;
  flex-direction:column;
  gap:18px;
  width:100%;
  max-width:none;
}

/* Cegah flicker total saat halaman dibuka lewat hash.
   Bukan cuma content yang disembunyikan, tapi body juga,
   karena garis kuning active ada di sidebar. */
html:not(.app-ready) body{
  visibility:hidden!important;
  opacity:0!important;
}
html.app-ready body{
  visibility:visible!important;
  opacity:1!important;
}
.page{display:none;width:100%;max-width:none;}
.page.active{display:flex;flex-direction:column;gap:18px;width:100%;}
.page>*{width:100%;max-width:none;}
.topbar{display:none!important;}

/* ─── SIDEBAR — sama seperti dashboard dinkes ─────────── */
.sidebar{
  position:fixed;
  top:0;left:0;
  width:var(--sidebar-w);
  height:100vh;
  background:var(--sb-bg);
  color:#fff;
  display:flex;
  flex-direction:column;
  border-right:1px solid var(--sb-border);
  z-index:200;
  overflow-y:auto;
  flex-shrink:0;
}
.sb-brand{
  padding:20px 16px 18px;
  border-bottom:1px solid var(--sb-border);
  display:flex;
  align-items:center;
  gap:11px;
  min-height:77px;
}
.sidebar .sb-logo{
  width:38px;
  height:38px;
  padding:0;
  margin:0;
  border:0;
  border-radius:10px;
  flex-shrink:0;
  background:linear-gradient(135deg,#2563eb,#0ea5e9);
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
}
.sidebar .sb-logo svg{width:20px;height:20px;color:#fff;display:block;}
.sb-name{line-height:1;min-width:0;}
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
.sb-nav{padding:0;flex:1;overflow-y:auto;}
.sb-section{padding:18px 10px 6px;margin:0;}
.sb-account-section{padding-top:14px;}
.sb-label,.nav-section{
  font-size:10px;
  font-weight:700;
  letter-spacing:.8px;
  text-transform:uppercase;
  color:var(--sb-head);
  padding:0 8px;
  margin:0 0 4px;
  display:block;
  line-height:1.2;
}
.sidebar .nav-item,
.sidebar .sb-item,
.sidebar button.nav-item,
.sidebar button.sb-item,
.sidebar .logout-btn{
  appearance:none;
  -webkit-appearance:none;
  display:flex;
  align-items:center;
  gap:9px;
  width:100%;
  min-height:33px;
  padding:9px 10px;
  margin:0;
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
  box-shadow:none;
  outline:none;
}
.sidebar .nav-item:hover,
.sidebar .sb-item:hover,
.sidebar button.nav-item:hover,
.sidebar button.sb-item:hover,
.sidebar .logout-btn:hover{background:var(--sb-hover);color:#fff;}
.sidebar .nav-item.active,
.sidebar .sb-item.active{
  background:var(--sb-active);
  color:#fff;
  font-weight:600;
}
.sidebar .nav-item.active::before,
.sidebar .sb-item.active::before{
  content:'';
  position:absolute;
  left:0;
  top:6px;
  bottom:6px;
  width:3px;
  border-radius:0 3px 3px 0;
  background:var(--amber);
}
.sidebar .nav-item i,
.sidebar .sb-item i{
  width:15px;
  min-width:15px;
  text-align:center;
  font-size:15px;
  line-height:1;
  opacity:.75;
}
.sidebar .nav-item.active i,
.sidebar .sb-item.active i{opacity:1;}
.sidebar form{margin:0;padding:0;background:transparent;border:0;width:100%;}
.nav-divider{display:none!important;}
.sb-footer{
  margin-top:auto;
  padding:14px 14px 16px;
  border-top:1px solid var(--sb-border);
  background:transparent;
}
.sb-user{display:flex;align-items:flex-start;gap:10px;width:100%;}
.sb-avatar{
  width:34px;height:34px;border-radius:50%;flex-shrink:0;margin-top:2px;
  background:linear-gradient(135deg,var(--primary),var(--teal));
  display:flex;align-items:center;justify-content:center;
  font-size:12px;font-weight:700;color:#fff;
}
.sb-user-info{flex:1 1 auto;min-width:0;line-height:1.2;}
.sb-user-info strong,
.sb-footer .user-name{
  display:block;
  font-size:12.5px;
  font-weight:600;
  color:#fff;
  line-height:1.25;
  white-space:normal;
  overflow:visible;
  text-overflow:clip;
  width:100%;
}
.sb-user-info span,
.sb-footer .user-role{
  display:block;
  font-size:10.5px;
  color:var(--sb-text);
  margin-top:1px;
  line-height:1.25;
  white-space:normal;
  overflow:visible;
}

/* ─── HEADER / HERO ─────────────────────────────────── */
.page-header,
.header-card{
  background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
  color:#fff;
  border-radius:var(--radius);
  padding:30px 28px;
  box-shadow:none;
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  justify-content:center;
  gap:0;
}
.page-header h2,
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
.page-header h2 i{font-size:20px;color:#fff;opacity:.9;}
.page-header p,
.header-card p{
  font-size:13px;
  color:rgba(255,255,255,.75);
  line-height:1.5;
  margin:0;
}
.header-tag,
.panel-badge,
.status-pill{
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
}

/* ─── CARDS & SECTION HEAD ───────────────────────────── */
.card,
.chart-card,
.table-card,
.detail-panel,
.form-card,
.filter-card,
.info-card,
.history-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
}
.chart-card,
.detail-panel,
.form-card,
.filter-card,
.info-card{padding:20px;}
.chart-card:hover,
.table-card:hover,
.stat-card:hover{box-shadow:var(--shadow-lg);}
.section-head{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:12px;
  margin-bottom:16px;
}
.section-head h3,
.chart-title,
.table-title{
  font-size:13.5px;
  font-weight:700;
  color:var(--text);
  display:flex;
  align-items:center;
  gap:8px;
}
.section-head h3 i,
.chart-title i,
.table-title i,
.detail-name i{color:var(--primary);}
.section-head p,
.chart-sub{
  font-size:12px;
  color:var(--text-muted);
  line-height:1.45;
  margin-top:4px;
}
.section-title{
  font-size:14px;
  font-weight:700;
  color:var(--text);
  display:flex;
  align-items:center;
  gap:8px;
  margin:2px 0 -2px;
}

/* ─── STAT CARDS — gaya Dinkes ───────────────────────── */
.stat-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:16px;
  margin-bottom:0;
}
.stat-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:var(--radius);
  padding:20px 22px;
  box-shadow:var(--shadow);
  display:flex;
  flex-direction:column;
  gap:6px;
  position:relative;
  overflow:hidden;
  min-height:128px;
  transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-2px);}
.stat-card::before{
  content:'';
  position:absolute;
  top:0;left:0;right:0;
  height:4px;
  border-radius:14px 14px 0 0;
}
.stat-card.green::before{background:var(--green);}
.stat-card.teal::before{background:var(--teal);}
.stat-card.sky::before{background:var(--sky);}
.stat-card.amber::before{background:var(--amber);}
.stat-icon{
  font-size:28px;
  position:absolute;
  right:18px;
  top:18px;
  opacity:.15;
  width:auto;
  height:auto;
  border-radius:0;
  background:transparent!important;
  color:var(--text)!important;
}
.stat-label{
  font-size:11px;
  font-weight:600;
  color:var(--text-muted);
  text-transform:uppercase;
  letter-spacing:.5px;
}
.stat-value{
  font-size:30px;
  font-weight:800;
  font-family:'JetBrains Mono',monospace;
  letter-spacing:-1px;
  color:var(--text);
  line-height:1.05;
}
.stat-sub{font-size:12px;color:var(--text-muted);line-height:1.4;}

/* ─── CHARTS ─────────────────────────────────────────── */
.chart-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:16px;
  width:100%;
  margin:0;
}
.chart-card.wide{grid-column:1/-1;}
.chart-wrap{position:relative;width:100%;}
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
  color:var(--text-b)!important;
}

/* ─── FILTER / FORM ──────────────────────────────────── */
.filter-bar{
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:12px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  padding:17px 20px;
}
.filter-bar label,
.fg label,
.form-group label,
label{
  font-size:11px!important;
  font-weight:600!important;
  color:var(--text-muted)!important;
  text-transform:uppercase;
  letter-spacing:.5px;
}
select,
input,
textarea,
.fg select,
.fg input,
.filter-bar select,
.filter-bar input,
.table-search,
.input-sm{
  border:1px solid var(--border)!important;
  border-radius:var(--radius-sm)!important;
  background:var(--surface)!important;
  color:var(--text)!important;
  font-size:13px!important;
  outline:none!important;
  box-shadow:none!important;
}
select,
input,
.filter-bar select,
.filter-bar input,.table-search{min-height:36px;padding:8px 12px!important;}
select:focus,
input:focus,
textarea:focus,
.table-search:focus{
  border-color:var(--primary)!important;
  box-shadow:0 0 0 3px rgba(37,99,235,.12)!important;
}
.form-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
.upload-box{
  border:2px dashed var(--border);
  border-radius:18px;
  background:#f8fafc;
  padding:42px;
  text-align:center;
}
.upload-icon{
  width:72px;height:72px;border-radius:999px;background:var(--green-bg);color:#15803d;
  display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 14px;
}

/* ─── BUTTONS ────────────────────────────────────────── */
.btn,
.btn-green,
button[onclick*='showPuskDetail'],
button[onclick*='document.getElementById'],
button[onclick*='renderCompare'],
button[onclick*='saveManual'],
button[onclick*='showManualForm']{
  appearance:none;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  gap:6px!important;
  padding:9px 18px!important;
  border-radius:var(--radius-sm)!important;
  border:none!important;
  cursor:pointer!important;
  font-family:'Inter',sans-serif!important;
  font-size:13px!important;
  font-weight:600!important;
  line-height:1.2!important;
  background:var(--primary)!important;
  color:#fff!important;
  transition:background .15s,transform .1s!important;
}
.btn:active,.btn-green:active,button:active{transform:scale(.97);}
.btn-primary,.btn-green{background:var(--primary)!important;color:#fff!important;}
.btn-primary:hover,.btn-green:hover,button[onclick*='showPuskDetail']:hover{background:var(--primary-dk)!important;}
.btn-warning{background:var(--amber)!important;color:#1f2937!important;}
.btn-danger{background:var(--red)!important;color:#fff!important;}
.btn-outline,
button[onclick*="manual-form"]{
  background:transparent!important;
  color:var(--text-b)!important;
  border:1px solid var(--border)!important;
}
.btn-outline:hover{background:var(--bg)!important;color:var(--text)!important;}
.tab-row{display:flex;gap:10px;flex-wrap:wrap;}
.tab{
  border-radius:999px;
  padding:8px 14px;
  font-size:13px;
  font-weight:700;
  border:1px solid var(--border);
  background:#fff;
  color:var(--text-b);
  cursor:pointer;
}
.tab.active{background:var(--primary);border-color:var(--primary);color:#fff;}

/* ─── TABLE — gaya Dinkes ────────────────────────────── */
.table-card{overflow:hidden;padding:0;}
.table-header{
  padding:16px 20px;
  border-bottom:1px solid var(--border);
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  flex-wrap:wrap;
}
.table-wrap{overflow:auto;border:0;border-radius:0;background:#fff;}
table{width:100%;border-collapse:collapse;border-spacing:0;font-size:13px;}
thead tr{background:#0f1629;}
th,
thead th,
.ind-table th{
  background:#0f1629!important;
  color:rgba(255,255,255,.8)!important;
  padding:11px 14px!important;
  text-align:left!important;
  font-size:10px!important;
  font-weight:700!important;
  text-transform:uppercase!important;
  letter-spacing:.5px!important;
  white-space:nowrap!important;
  border:none!important;
}
td,
tbody td{
  padding:11px 14px!important;
  border-bottom:1px solid var(--border)!important;
  font-size:13px!important;
  vertical-align:middle!important;
  color:var(--text-b)!important;
}
tbody tr{transition:background .1s;}
tbody tr:last-child td{border-bottom:none!important;}
tbody tr:hover td{background:#f8fafc!important;}
.rank,
.num{
  width:24px;
  height:24px;
  border-radius:7px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-family:'JetBrains Mono',monospace;
  font-size:11px;
  font-weight:700;
  background:var(--bg);
  color:var(--text-muted);
}
.table-search{width:220px;}

/* ─── BADGES & PROGRESS ──────────────────────────────── */
.badge{
  display:inline-flex!important;
  align-items:center;
  justify-content:center;
  font-size:11px!important;
  font-weight:600!important;
  padding:2px 8px!important;
  border-radius:20px!important;
  line-height:1.4!important;
}
.badge-green{background:#dcfce7!important;color:#15803d!important;}
.badge-amber{background:#fef9c3!important;color:#a16207!important;}
.badge-red{background:#fee2e2!important;color:#b91c1c!important;}
.percent{display:inline-flex;min-width:55px;justify-content:center;padding:5px 9px;border-radius:999px;background:var(--primary-lt);color:var(--primary);font-weight:800;font-size:12px;}
.pbar-wrap{display:flex!important;align-items:center!important;gap:8px!important;min-width:150px;}
.pbar,.progress{
  flex:1;
  min-width:70px;
  height:5px!important;
  background:var(--border)!important;
  border-radius:99px!important;
  overflow:hidden!important;
}
.pbar-fill,.progress span{height:100%;border-radius:99px;transition:width .6s;display:block;}
.pbar-val{
  font-family:'JetBrains Mono',monospace!important;
  font-size:11.5px!important;
  font-weight:700!important;
  width:46px!important;
  text-align:right!important;
}

/* ─── DETAIL / HISTORY / PANEL ───────────────────────── */
.detail-panel{padding:20px;}
.detail-name{font-size:22px;font-weight:800;color:var(--text);margin-bottom:4px;}
.detail-meta{font-size:13px;color:var(--text-muted);margin-bottom:20px;}
.panel-head,
.history-top{
  background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
  color:#fff;
  padding:16px 20px;
  border-radius:var(--radius) var(--radius) 0 0;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
}
.panel-head h3,.history-top h3{font-size:14px;font-weight:700;color:#fff;}
.panel-head p,.history-top p{font-size:12px;color:rgba(255,255,255,.75);margin-top:3px;}
.history-body{padding:18px;}
.indicator-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:14px;}
.ind-mini{background:#f8fafc;border:1px solid var(--border);border-radius:12px;padding:12px;}
.ind-mini-row{display:flex;justify-content:space-between;gap:10px;margin-bottom:8px;font-size:12px;}
.ind-mini b{color:var(--primary);}
.footer-actions{display:flex;justify-content:flex-end;gap:10px;background:#f8fafc;padding:14px 18px;border-top:1px solid var(--border);border-radius:0 0 var(--radius) var(--radius);}
.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;}
.quick{padding:16px 18px;display:flex;align-items:center;gap:13px;min-height:96px;}
.qico{width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0;}
.qico.blue{background:var(--primary-lt);color:var(--primary);}.qico.good{background:var(--green-bg);color:#15803d;}.qico.warn{background:var(--amber-bg);color:#a16207;}
.quick .label{font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;}
.quick .value{font-size:22px;font-weight:800;color:var(--text);margin-top:4px;}

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media(max-width:1100px){
  .stat-grid{grid-template-columns:repeat(2,1fr);}
  .chart-grid{grid-template-columns:1fr;}
  .form-grid,.quick-grid,.indicator-grid{grid-template-columns:1fr;}
}
@media(max-width:760px){
  body{display:block;}
  .sidebar{position:relative;width:100%;height:auto;}
  .main{margin-left:0;width:100%;}
  .content{padding:16px;}
  .stat-grid{grid-template-columns:1fr;}
  .page-header{padding:22px;}
  .table-header{align-items:flex-start;flex-direction:column;}
  .table-search{width:100%;}
}


/* =========================================================
   FINAL SIDEBAR MATCH DINKES — ukuran 220px + SVG stroke icons
   ========================================================= */
:root{--sidebar-w:220px!important;}
body{font-family:'Inter',sans-serif!important;background:var(--bg)!important;color:var(--text-b)!important;}
.sidebar{
  position:fixed!important;
  top:0!important;
  left:0!important;
  bottom:auto!important;
  width:220px!important;
  min-width:220px!important;
  max-width:220px!important;
  height:100vh!important;
  background:#0f1629!important;
  background-image:none!important;
  display:flex!important;
  flex-direction:column!important;
  border-right:1px solid rgba(255,255,255,.07)!important;
  z-index:200!important;
  overflow-y:auto!important;
  color:#fff!important;
}
.sb-brand{
  padding:20px 16px 18px!important;
  border-bottom:1px solid rgba(255,255,255,.07)!important;
  display:flex!important;
  align-items:center!important;
  gap:11px!important;
  min-height:77px!important;
}
.sidebar .sb-logo{
  width:38px!important;
  height:38px!important;
  min-width:38px!important;
  max-width:38px!important;
  padding:0!important;
  margin:0!important;
  border:0!important;
  border-radius:10px!important;
  flex:0 0 38px!important;
  background:linear-gradient(135deg,#2563eb,#0ea5e9)!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  color:#fff!important;
}
.sidebar .sb-logo svg{width:20px!important;height:20px!important;color:#fff!important;stroke:#fff!important;opacity:1!important;}
.sb-name{line-height:1!important;min-width:0!important;}
.sb-name strong{display:block!important;font-size:14px!important;font-weight:800!important;color:#fff!important;letter-spacing:-.2px!important;line-height:1.1!important;}
.sb-name span{display:block!important;font-size:10px!important;color:rgba(255,255,255,.65)!important;margin-top:2px!important;line-height:1.3!important;}
.sb-nav{padding:0!important;flex:1!important;overflow-y:auto!important;}
.sb-section{padding:18px 10px 6px!important;margin:0!important;}
.sb-label{font-size:10px!important;font-weight:700!important;letter-spacing:.8px!important;text-transform:uppercase!important;color:rgba(255,255,255,.30)!important;padding:0 8px!important;margin:0 0 4px!important;display:block!important;line-height:1.2!important;}
.sidebar .sb-item,
.sidebar button.sb-item,
.sidebar .nav-item,
.sidebar button.nav-item,
.sidebar .logout-btn{
  appearance:none!important;
  -webkit-appearance:none!important;
  display:flex!important;
  align-items:center!important;
  gap:9px!important;
  width:100%!important;
  min-height:33px!important;
  padding:9px 10px!important;
  margin:0!important;
  border:0!important;
  border-left:0!important;
  border-radius:8px!important;
  background:transparent!important;
  color:rgba(255,255,255,.65)!important;
  font-family:'Inter',sans-serif!important;
  font-size:13px!important;
  font-weight:500!important;
  line-height:1.15!important;
  text-align:left!important;
  cursor:pointer!important;
  position:relative!important;
  transition:background .15s,color .15s!important;
  box-shadow:none!important;
  outline:none!important;
}
.sidebar .sb-item:hover,
.sidebar .nav-item:hover,
.sidebar .logout-btn:hover{background:rgba(255,255,255,.06)!important;color:#fff!important;}
.sidebar .sb-item.active,
.sidebar .nav-item.active{background:rgba(255,255,255,.09)!important;color:#fff!important;font-weight:600!important;}
.sidebar .sb-item.active::before,
.sidebar .nav-item.active::before{content:''!important;position:absolute!important;left:0!important;top:6px!important;bottom:6px!important;width:3px!important;border-radius:0 3px 3px 0!important;background:#f59e0b!important;}
.sidebar .sb-item svg,
.sidebar .nav-item svg,
.sidebar .logout-btn svg{width:15px!important;height:15px!important;min-width:15px!important;flex-shrink:0!important;color:currentColor!important;stroke:currentColor!important;opacity:.75!important;display:block!important;}
.sidebar .sb-item.active svg,
.sidebar .nav-item.active svg{opacity:1!important;}
.sidebar .sb-item i,
.sidebar .nav-item i,
.sidebar .logout-btn i{display:none!important;}
.sidebar form{margin:0!important;padding:0!important;border:0!important;background:transparent!important;width:100%!important;}
.sb-footer{margin-top:auto!important;padding:14px 16px!important;border-top:1px solid rgba(255,255,255,.07)!important;background:transparent!important;}
.sb-user{display:flex!important;align-items:center!important;gap:10px!important;width:100%!important;}
.sb-avatar{width:34px!important;height:34px!important;border-radius:50%!important;flex:0 0 34px!important;margin:0!important;background:linear-gradient(135deg,#2563eb,#14b8a6)!important;display:flex!important;align-items:center!important;justify-content:center!important;font-size:12px!important;font-weight:700!important;color:#fff!important;}
.sb-user-info{min-width:0!important;line-height:1.2!important;}
.sb-user-info strong,.sb-footer .user-name{display:block!important;font-size:13px!important;font-weight:600!important;color:#fff!important;line-height:1.2!important;white-space:normal!important;overflow:visible!important;text-overflow:clip!important;max-width:none!important;}
.sb-user-info span,.sb-footer .user-role{display:block!important;font-size:11px!important;color:rgba(255,255,255,.65)!important;margin-top:1px!important;line-height:1.25!important;white-space:normal!important;overflow:visible!important;text-overflow:clip!important;max-width:none!important;}
.main{margin-left:220px!important;width:calc(100vw - 220px)!important;min-height:100vh!important;background:var(--bg)!important;}
@media(max-width:760px){.sidebar{position:relative!important;width:100%!important;min-width:0!important;max-width:none!important;height:auto!important}.main{margin-left:0!important;width:100%!important}}

</style>
</head>
<body>

<!-- ════════════════════ MAIN APP ════════════════════ -->
<div id="app">
<div class="layout">
@php
  $authUser = auth()->user() ?? (object) [];

  // Ambil role dari database. Di UserSeeder: id_role = 1 untuk Dinkes, id_role = 2 untuk Puskesmas.
  $roleId = (int) ($authUser->id_role ?? 0);
  $rawRole = strtolower((string) ($authUser->role ?? $authUser->level ?? ''));
  $isDinkes = $roleId === 1 || stripos($rawRole, 'dinkes') !== false || stripos($rawRole, 'dinas') !== false;

  // Ambil nama akun login dari kolom users.name.
  // Contoh dari seeder: "Puskesmas Gamping I", "Puskesmas Mlati II", dst.
  $userName = trim((string) ($authUser->name ?? ''));

  // Kalau nanti tabel user punya relasi/kolom khusus puskesmas, ini tetap aman dipakai.
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
      ?? (!$isDinkes ? $userName : null);

  $puskesmasLabel = $puskesmasName
      ? (stripos($puskesmasName, 'puskesmas') !== false ? $puskesmasName : 'Puskesmas '.$puskesmasName)
      : 'Puskesmas';

  // Teks footer sidebar mengikuti akun yang sedang login.
  // Login Puskesmas Gamping I => Admin Puskesmas Gamping I.
  // Login Dinkes => Admin Dinas Kesehatan Sleman.
  $footerName = $isDinkes
      ? ($userName ?: 'Admin Dinkes')
      : 'Admin '.$puskesmasLabel;

  $footerRole = $isDinkes
      ? 'Dinas Kesehatan • SIP-PHBS'
      : $puskesmasLabel.' • SIP-PHBS';

  $footerInitial = $isDinkes ? 'D' : strtoupper(substr($puskesmasLabel, 0, 1));
@endphp

    <!-- SIDEBAR -->
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

      <nav class="sb-nav" aria-label="Navigasi utama dashboard puskesmas">
        <div class="sb-section">
          <span class="sb-label">Menu Utama</span>

          <button type="button" class="sb-item nav-item active" data-page="dashboard" onclick="showPage('dashboard')">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
            </svg>
            <span>Dashboard</span>
          </button>

          <a href="{{ route('phbs.create') }}" class="sb-item nav-item" data-page="input-data">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
              <path d="M9 5a2 2 0 012-2h2a2 2 0 012 2 2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              <path d="M9 12h6M9 16h6"/>
            </svg>
            <span>Input Data</span>
          </a>

          {{-- <button type="button" class="sb-item nav-item" data-page="tabel-puskesmas" onclick="showPage('tabel-puskesmas')">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
              <path d="M3 21h18"/>
              <path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/>
            </svg>
            <span>Data Puskesmas</span>
          </button> --}}

          <a href="{{ route('phbs.history') }}" class="sb-item nav-item" data-page="lihat-history">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Lihat History</span>
          </a>
        </div>

        <div class="sb-section">
          <span class="sb-label">Analisis</span>

          <button type="button" class="sb-item nav-item" data-page="per-indikator" onclick="showPage('per-indikator')">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            <span>Per Indikator</span>
          </button>

          {{-- <button type="button" class="sb-item nav-item" data-page="perbandingan" onclick="showPage('perbandingan')">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 3v18"/>
              <path d="M5 7h14"/>
              <path d="M7 7l-3 6h6L7 7z"/>
              <path d="M17 7l-3 6h6l-3-6z"/>
              <path d="M8 21h8"/>
            </svg>
            <span>Perbandingan</span>
          </button> --}}
        </div>

        <div class="sb-section sb-account-section">
          <span class="sb-label">Akun</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-item logout-btn">
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
          <div class="sb-avatar">{{ $footerInitial }}</div>
          <div class="sb-user-info">
            <strong title="{{ $footerName }}">{{ $footerName }}</strong>
            <span title="{{ $footerRole }}">{{ $footerRole }}</span>
          </div>
        </div>
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
const COLORS = ['#2563eb','#22c55e','#f59e0b','#ef4444','#14b8a6','#0ea5e9','#8b5cf6','#f97316','#64748b','#10b981','#1d4ed8','#c2410c'];

// ─── state ───
let newEntries = [];
let puskDetailChart = null;
let cmpChart = null;
let sortDir = 1;
let currentSort = 4; // sort by pct desc default

// ─── INIT ───
document.addEventListener("DOMContentLoaded", function(){
  try{
    initApp();
  } catch(error){
    console.error(error);
    document.documentElement.classList.add('app-ready');
  }
});

// Fallback supaya halaman tidak kosong kalau ada script eksternal yang telat/bermasalah.
setTimeout(function(){
  document.documentElement.classList.add('app-ready');
}, 1500);
function initApp(){
  // Penting: proses hash dulu sebelum konten ditampilkan,
  // supaya tidak sempat terlihat masuk Dashboard dulu.
  handleInitialHash();

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

  // Baru tampilkan halaman setelah page aktif, sidebar aktif, tabel, dan chart siap.
  requestAnimationFrame(function(){
    document.documentElement.classList.add('app-ready');
  });
}

function getPageFromHash(){
  const hash = window.location.hash.replace('#', '');
  const map = {
    'page-dashboard':'dashboard',
    'dashboard':'dashboard',
    'page-input-data':'input-data',
    'input-data':'input-data',
    'page-tabel-puskesmas':'tabel-puskesmas',
    'data-puskesmas':'tabel-puskesmas',
    'tabel-puskesmas':'tabel-puskesmas',
    'page-lihat-history':'lihat-history',
    'lihat-history':'lihat-history',
    'page-per-indikator':'per-indikator',
    'per-indikator':'per-indikator',
    'page-perbandingan':'perbandingan',
    'perbandingan':'perbandingan'
  };
  return map[hash] || 'dashboard';
}

function handleInitialHash(){
  showPage(getPageFromHash(), false);
}
window.addEventListener('hashchange', handleInitialHash);

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
function setActiveSidebar(pageId){
  document.querySelectorAll('.sidebar .nav-item, .sidebar .sb-item').forEach(item => {
    item.classList.remove('active');
  });

  const activeItem = document.querySelector(`.sidebar [data-page="${pageId}"]`);
  if(activeItem){
    activeItem.classList.add('active');
  }
}

function showPage(id, updateHash = true){
  const targetPage = document.getElementById('page-' + id);
  if(!targetPage) return;

  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  targetPage.classList.add('active');

  setActiveSidebar(id);

  // Saat klik menu dalam dashboard tidak perlu reload halaman.
  // Hash hanya diubah agar saat refresh tetap balik ke menu yang sama.
  if(updateHash){
    const newUrl = id === 'dashboard'
      ? window.location.pathname + window.location.search
      : '#page-' + id;
    history.replaceState(null, '', newUrl);
  }
}


// ─── STATS ───
function renderStats(){
  let totKK=0, totPhbs=0;
  Object.values(RAW).forEach(d => { totKK+=d.total_kk; totPhbs+=d.ber_phbs; });
  const pct = totKK>0 ? (totPhbs/totKK*100).toFixed(1) : 0;
  document.getElementById('stat-kk').textContent = totKK.toLocaleString('id');
  document.getElementById('stat-phbs').textContent = totPhbs.toLocaleString('id');
  document.getElementById('stat-pct').textContent = 61+'%';
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
      borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,.08)',
      fill:true, tension:.4, pointBackgroundColor:'#2563eb', pointRadius:4
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
  const colors = data.map(v => v>=80?'#22c55e':v>=65?'#f59e0b':'#ef4444');
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
        backgroundColor:['#22c55e','#f59e0b','#ef4444'],borderWidth:0}]
    },
    options:{responsive:true,maintainAspectRatio:false,cutout:'65%',plugins:{legend:{display:false}},
      animation:{animateRotate:true}}
  });
  const leg = document.getElementById('donut-legend');
  const items=[
    {label:`Baik (≥80%) — ${counts.baik} puskesmas`,color:'#22c55e'},
    {label:`Sedang (65–79%) — ${counts.sedang} puskesmas`,color:'#f59e0b'},
    {label:`Kurang (<65%) — ${counts.kurang} puskesmas`,color:'#ef4444'}
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
    const color = r.pct>=80?'#22c55e':r.pct>=65?'#f59e0b':'#ef4444';
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
    const color = r.pct>=80?'#22c55e':r.pct>=65?'#f59e0b':'#ef4444';
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
    const color = pct>=80?'#22c55e':pct>=65?'#f59e0b':'#ef4444';
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
        {label:'Total KK',data:d.months.map(m=>m.kk),backgroundColor:'rgba(2,132,199,.2)',borderColor:'#0ea5e9',borderWidth:1,borderRadius:4},
        {label:'Ber-PHBS',data:d.months.map(m=>m.ber_phbs),backgroundColor:'rgba(22,163,74,.6)',borderColor:'#22c55e',borderWidth:1,borderRadius:4}
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
    const color = r.pct>=80?'#22c55e':r.pct>=65?'#f59e0b':'#ef4444';
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
        backgroundColor:IND_PCT.map(v=>v>=90?'rgba(34,197,94,.75)':v>=75?'rgba(20,184,166,.75)':'rgba(245,158,11,.75)'),
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
    const color = pct>=90?'#22c55e':pct>=75?'#14b8a6':'#f59e0b';
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