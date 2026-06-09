<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Edit Data PHBS - SIP-PHBS</title>
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
html{scroll-behavior:smooth;}
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



/* =========================================================
   Tambahan khusus halaman Input Data PHBS
   Rapih: card metode, informasi laporan, tabel indikator
   ========================================================= */
.page.active{display:flex!important;}
.alert{
  padding:12px 14px;
  border-radius:var(--radius);
  font-size:13px;
  font-weight:600;
  display:flex;
  align-items:center;
  gap:8px;
  border:1px solid var(--border);
}
.alert-success{background:#dcfce7;border-color:#bbf7d0;color:#166534;}
.alert-error{background:#fee2e2;border-color:#fecaca;color:#991b1b;}

/* Card pilihan import / manual */
.method-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:18px;
  align-items:stretch;
}
.method-card{
  min-height:150px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  gap:18px;
}
.method-card .chart-title{
  font-size:14px;
  line-height:1.35;
  margin-bottom:7px;
}
.method-card .chart-sub{
  max-width:640px;
  line-height:1.55;
}
.method-actions{
  margin-top:auto;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

/* Panel formulir */
.form-panel{
  display:flex;
  flex-direction:column;
  gap:18px;
}

/* Bagian Informasi Laporan dibuat rapi: label di atas, input sejajar */
#manualBox .detail-panel{
  padding:24px 24px 26px;
  overflow:hidden;
}
#manualBox .section-head{
  align-items:flex-start;
  margin-bottom:22px;
  padding-bottom:16px;
  border-bottom:1px solid var(--border);
}
#manualBox .section-head h3{
  font-size:14.5px;
  line-height:1.35;
}
#manualBox .section-head p{
  margin-top:5px;
  max-width:520px;
  line-height:1.5;
}
.count-badge{
  flex:0 0 auto;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  min-height:30px;
  padding:6px 12px;
  border-radius:999px;
  background:var(--primary-lt);
  color:var(--primary);
  font-size:11.5px;
  font-weight:700;
  letter-spacing:.2px;
  white-space:nowrap;
}

/* Ini yang bikin screenshot sebelumnya berantakan:
   label tidak lagi inline dengan input */
#manualBox .form-grid{
  display:grid;
  grid-template-columns:minmax(230px,1.25fr) minmax(150px,.75fr) minmax(160px,.8fr) minmax(170px,.9fr);
  gap:18px;
  align-items:end;
}
#manualBox .fg{
  display:flex;
  flex-direction:column;
  gap:8px;
  min-width:0;
}
#manualBox .fg label{
  display:block!important;
  margin:0!important;
  line-height:1.2!important;
  white-space:nowrap!important;
}
#manualBox .fg select,
#manualBox .fg input{
  width:100%!important;
  height:44px!important;
  min-height:44px!important;
  padding:10px 13px!important;
}

/* Tabel indikator */
.table-card{
  overflow:hidden;
}
.table-header{
  padding:18px 24px;
}
.table-header .table-title{
  font-size:14.5px;
  line-height:1.35;
}
.table-header .chart-sub{
  line-height:1.5;
}
.status-pill{
  background:var(--primary-lt)!important;
  color:var(--primary)!important;
  border:0!important;
  font-size:11.5px!important;
  font-weight:700!important;
  padding:7px 12px!important;
}
.table-wrap{
  overflow-x:auto;
}
#manualBox table{
  min-width:880px;
}
#manualBox th:first-child,
#manualBox td:first-child{
  width:80px;
  text-align:center!important;
}
#manualBox th:nth-child(3),
#manualBox th:nth-child(4),
#manualBox th:nth-child(5),
#manualBox td:nth-child(3),
#manualBox td:nth-child(4),
#manualBox td:nth-child(5){
  text-align:center!important;
}
#manualBox td{
  height:72px;
}
.input-sm{
  width:118px!important;
  height:44px!important;
  min-height:44px!important;
  text-align:center!important;
  margin:0 auto!important;
}
.percent{
  min-width:70px;
  height:30px;
  padding:6px 12px!important;
}
.table-footer,
.footer-actions{
  display:flex;
  justify-content:flex-end;
  gap:10px;
  background:#f8fafc;
  padding:16px 22px;
  border-top:1px solid var(--border);
  border-radius:0 0 var(--radius) var(--radius);
}

/* Import box */
.import-box{
  padding:42px;
  text-align:center;
}
.import-box h2{
  font-size:18px;
  font-weight:800;
  color:var(--text);
  margin:8px 0 6px;
}
.import-box p{
  font-size:13px;
  color:var(--text-muted);
  margin-bottom:18px;
}
.drop-zone{
  border:2px dashed var(--border);
  border-radius:18px;
  background:#f8fafc;
  padding:30px;
  max-width:620px;
  margin:0 auto;
}
.is-hidden{display:none!important;}

/* History/modal tetap aman */
.report-list{display:flex;flex-direction:column;gap:18px;}
.history-card{overflow:hidden;}
.history-body{padding:18px;}
.history-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px;}
.modal{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,.55);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:999;
}
.modal.hidden{display:none;}
.modal-box{
  background:#fff;
  border-radius:16px;
  box-shadow:0 20px 45px rgba(15,23,42,.22);
  width:100%;
  max-width:420px;
  padding:22px;
}
.modal-box h2{
  font-size:17px;
  font-weight:800;
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

/* Responsive */
@media(max-width:1100px){
  .method-grid{grid-template-columns:1fr;}
  #manualBox .form-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
}
@media(max-width:760px){
  #manualBox .detail-panel{padding:20px;}
  #manualBox .section-head{
    flex-direction:column;
    gap:12px;
  }
  #manualBox .form-grid{grid-template-columns:1fr;}
  .input-sm{width:100px!important;}
}
</style>
</head>
<body>
<!-- ════════════════════ MAIN APP ════════════════════ -->
<div id="app">
<div class="layout">
@php
  $authUser = auth()->user() ?? (object) [];
  $roleId = (int) ($authUser->id_role1 ?? 0);
  $rawRole = strtolower((string) ($authUser->role ?? $authUser->level ?? ''));
  $isDinkes = $roleId === 1 || stripos($rawRole, 'dinkes') !== false || stripos($rawRole, 'dinas') !== false;
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
      ?? (!$isDinkes ? $userName : null);

  $puskesmasLabel = $puskesmasName
      ? (stripos($puskesmasName, 'puskesmas') !== false ? $puskesmasName : 'Puskesmas '.$puskesmasName)
      : 'Puskesmas';

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

          <a href="{{ route('puskesmas.dashboard') }}" class="sb-item nav-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
            <span>Dashboard</span>
          </a>

          <a href="{{ route('phbs.create') }}" class="sb-item nav-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><path d="M9 5a2 2 0 012-2h2a2 2 0 012 2 2 2 0 01-2 2h-2a2 2 0 01-2-2z"/><path d="M9 12h6M9 16h6"/></svg>
            <span>Input Data</span>
          </a>

          {{-- <a href="{{ route('puskesmas.dashboard') }}#page-tabel-puskesmas" class="sb-item nav-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/><path d="M3 21h18"/><path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/></svg>
            <span>Data Puskesmas</span>
          </a> --}}

          <a href="{{ route('phbs.history') }}" class="sb-item nav-item active">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            <span>Lihat History</span>
          </a>
        </div>

        <div class="sb-section">
          <span class="sb-label">Analisis</span>

          <a href="{{ route('puskesmas.dashboard') }}#page-per-indikator" class="sb-item nav-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10h18M3 14h18M10 3v18M14 3v18"/></svg>
            <span>Per Indikator</span>
          </a>

          {{-- <a href="{{ route('puskesmas.dashboard') }}#page-perbandingan" class="sb-item nav-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v18"/><path d="M5 7h14"/><path d="M7 7l-3 6h6L7 7z"/><path d="M17 7l-3 6h6l-3-6z"/><path d="M8 21h8"/></svg>
            <span>Perbandingan</span>
          </a> --}}
        </div>

        <div class="sb-section sb-account-section">
          <span class="sb-label">Akun</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-item logout-btn">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 16l4-4m0 0l-4-4m4 4H7"/><path d="M13 16v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
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
        <div id="page-input-data" class="page active">
          <div class="page-header">
            <h2><i class="fa-solid fa-clipboard-list"></i> Input Data PHBS</h2>
            <p>Input laporan indikator PHBS per puskesmas dengan metode manual atau import Excel.</p>
          </div>

          @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
          @endif

          {{-- <div class="method-grid">
            <div class="chart-card method-card">
              <div>
                <div class="chart-title"><i class="fa-solid fa-file-excel"></i> Import Excel</div>
                <div class="chart-sub">Upload file Excel format .xlsx / .xls sesuai kebutuhan pelaporan PHBS.</div>
              </div>
              <div class="method-actions">
                <button type="button" class="btn-green" onclick="showImport()"><i class="fa-solid fa-folder-open"></i> Buka Import</button>
              </div>
            </div>

            <div class="chart-card method-card">
              <div>
                <div class="chart-title"><i class="fa-solid fa-pen-to-square"></i> Input Manual</div>
                <div class="chart-sub">Isi data utama dan 13 indikator PHBS secara langsung melalui formulir.</div>
              </div>
              <div class="method-actions">
                <button type="button" class="btn-green" onclick="showManual()"><i class="fa-solid fa-file-lines"></i> Buka Formulir</button>
              </div>
            </div>
          </div> --}}

          <div id="manualBox" class="form-panel">
            <form method="POST" action="{{ route('phbs.update', $phbs->id_phbs) }}">
              @csrf
              @method('PATCH')

              {{-- <section class="detail-panel">
                <div class="section-head">
                  <div>
                    <h3><i class="fa-solid fa-clipboard-list"></i> Informasi Laporan</h3>
                    <p>Lengkapi data utama laporan sebelum mengisi capaian indikator.</p>
                  </div>
                  <span class="count-badge">Data Utama</span>
                </div>

                <div class="form-grid">
                  <div class="fg">
                    <label>Puskesmas</label>
                    <select name="id_puskesmas">
                      <option value="">Pilih Puskesmas</option>
                      @foreach($puskesmas as $item)
                        <option value="{{ $item->id_puskesmas }}">{{ $item->nama_puskesmas }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="fg">
                    <label>Bulan</label>
                    <select name="bulan">
                      <option>Januari</option><option>Februari</option><option>Maret</option>
                      <option>April</option><option>Mei</option><option>Juni</option>
                      <option>Juli</option><option>Agustus</option><option>September</option>
                      <option>Oktober</option><option>November</option><option>Desember</option>
                    </select>
                  </div>

                  <div class="fg">
                    <label>Tahun</label>
                    <input type="number" name="tahun" value="2026">
                  </div>

                  <div class="fg">
                    <label>Jumlah KK</label>
                    <input type="number" name="jumlah_kk" value="0">
                  </div>
                </div>
              </section> --}}

              <section class="table-card">
                <div class="table-header">
                  <div>
                    <div class="table-title"><i class="fa-solid fa-list-check"></i> 13 Indikator PHBS</div>
                    <div class="chart-sub">Input sasaran dan capaian. Persentase dihitung otomatis.</div>
                  </div>
                  <span class="status-pill"><i class="fa-solid fa-percent"></i> Auto Persentase</span>
                </div>

                <div class="table-wrap">
                  <table>
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Indikator</th>
                        <th style="text-align:center">Sasaran</th>
                        <th style="text-align:center">Capaian</th>
                        <th style="text-align:center">%</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $indikator = [
                          "Persalinan ditolong tenaga kesehatan",
                          "Memberi bayi ASI eksklusif",
                          "Menimbang balita setiap bulan",
                          "Menggunakan air bersih",
                          "Mencuci tangan dengan air bersih dan sabun",
                          "Pengelolaan air minum dan makan di rumah tangga",
                          "Menggunakan jamban sehat",
                          "Pengelolaan limbah cair di rumah tangga",
                          "Membuang sampah di tempat sampah",
                          "Memberantas jentik di rumah",
                          "Makan buah dan sayur setiap hari",
                          "Melakukan aktivitas fisik setiap hari",
                          "Tidak merokok di dalam rumah"
                        ];
                      @endphp

                      @foreach($indikator as $key => $item)
                        <tr>
                          <td><span class="num">{{ $key + 1 }}</span></td>
                          <td style="font-weight:600;color:#1e3a5f">{{ $item }}</td>
                          <td style="text-align:center">
                            <input type="number" name="sasaran_input[{{ $key+1 }}]" value="{{ $detail[$key+1]->sasaran ?? 0 }}" class="input-sm sasaran">
                          </td>
                          <td style="text-align:center">
                            <input type="number" name="jumlah_input[{{ $key+1 }}]" value="{{ $detail[$key+1]->jumlah ?? 0 }}" class="input-sm jumlah">
                          </td>
                          <td style="text-align:center"><span class="percent">0%</span></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <div class="footer-actions">
                  <button type="reset" class="btn btn-outline"><i class="fa-solid fa-rotate-left"></i> Reset</button>
                  <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                </div>
              </section>
            </form>
          </div>

          <div id="importBox" class="is-hidden">
            <section class="detail-panel import-box">
              <div class="upload-icon"><i class="fa-solid fa-file-excel"></i></div>
              <h2>Upload Excel PHBS</h2>
              <p>Import file Excel format .xlsx / .xls.</p>

              <form method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="drop-zone">
                  <input type="file" name="file" style="font-size:13px;margin-bottom:16px">
                  <br>
                  <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Upload Excel</button>
                </div>
              </form>
            </section>
          </div>
        </div><!-- /page-input-data -->
      </div><!-- /content -->
    </main><!-- /main -->
  </div><!-- /layout -->
</div><!-- /app -->

<script>
function showImport(){
  document.getElementById('manualBox').classList.add('is-hidden');
  document.getElementById('importBox').classList.remove('is-hidden');
}
function showManual(){
  document.getElementById('manualBox').classList.remove('is-hidden');
  document.getElementById('importBox').classList.add('is-hidden');
}

document.querySelectorAll('.sasaran, .jumlah').forEach(input => {
  input.addEventListener('input', function(){
    let row = this.closest('tr');
    let sasaran = parseInt(row.querySelector('.sasaran').value) || 0;
    let jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
    let persen = sasaran > 0 ? (jumlah / sasaran) * 100 : 0;
    row.querySelector('.percent').innerHTML = persen.toFixed(1) + '%';
  });
});
</script>

</body>
</html>
