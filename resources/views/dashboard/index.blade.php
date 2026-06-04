{{-- resources/views/dashboard/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PHBS – SIP-PHBS Kab. Sleman</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<style>
/* ─── DESIGN TOKENS ─────────────────────────────────────────────── */
:root {
    /* Colors (sesuai riska.txt) */
    --green:   #22c55e;  --green-bg:  #f0fdf4;  --green-ring: #bbf7d0;
    --teal:    #14b8a6;  --teal-bg:   #f0fdfa;
    --sky:     #0ea5e9;  --sky-bg:    #f0f9ff;
    --amber:   #f59e0b;  --amber-bg:  #fffbeb;  --amber-ring: #fde68a;
    --red:     #ef4444;  --red-bg:    #fef2f2;   --red-ring:   #fecaca;
    --primary: #2563eb;  --primary-dk:#1d4ed8;   --primary-lt: #eff6ff;

    /* Sidebar */
    --sb-bg:     #0f1629;
    --sb-hover:  rgba(255,255,255,.06);
    --sb-active: rgba(255,255,255,.09);
    --sb-border: rgba(255,255,255,.07);
    --sb-text:   rgba(255,255,255,.65);
    --sb-head:   rgba(255,255,255,.30);

    /* Layout */
    --surface:  #ffffff;
    --bg:       #f1f5f9;
    --border:   #e2e8f0;
    --text:     #0f172a;
    --text-b:   #475569;
    --text-muted:#94a3b8;

    /* Misc */
    --radius:   12px;
    --radius-sm: 8px;
    --shadow:   0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
    --shadow-lg:0 10px 25px rgba(0,0,0,.12);
    --sidebar-w:220px;
}

/* ─── RESET ─────────────────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-b);min-height:100vh;}
a{text-decoration:none;}

/* ─── SIDEBAR ───────────────────────────────────────────────────── */
.sidebar{
    position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;
    background:var(--sb-bg);display:flex;flex-direction:column;
    border-right:1px solid var(--sb-border);z-index:200;
    overflow-y:auto;
}
.sb-brand{
    padding:20px 16px 18px;
    border-bottom:1px solid var(--sb-border);
    display:flex;align-items:center;gap:11px;
}
.sb-logo{
    width:38px;height:38px;border-radius:10px;flex-shrink:0;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    display:flex;align-items:center;justify-content:center;
}
.sb-logo svg{color:#fff;}
.sb-name{line-height:1;}
.sb-name strong{display:block;font-size:14px;font-weight:800;color:#fff;letter-spacing:-.2px;}
.sb-name span{display:block;font-size:10px;color:var(--sb-text);margin-top:2px;line-height:1.3;}

.sb-section{padding:18px 10px 6px;}
.sb-label{
    font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;
    color:var(--sb-head);padding:0 8px;margin-bottom:4px;display:block;
}
.sb-item{
    display:flex;align-items:center;gap:9px;
    padding:9px 10px;border-radius:var(--radius-sm);
    color:var(--sb-text);font-size:13px;font-weight:500;
    transition:background .15s,color .15s;cursor:pointer;
    position:relative;
}
.sb-item:hover{background:var(--sb-hover);color:#fff;}
.sb-item.active{
    background:var(--sb-active);color:#fff;font-weight:600;
}
.sb-item.active::before{
    content:'';position:absolute;left:0;top:6px;bottom:6px;
    width:3px;border-radius:0 3px 3px 0;
    background:var(--amber);
}
.sb-item svg{flex-shrink:0;opacity:.75;}
.sb-item.active svg{opacity:1;}

.sb-footer{
    margin-top:auto;padding:14px 16px;
    border-top:1px solid var(--sb-border);
}
.sb-user{display:flex;align-items:center;gap:10px;}
.sb-avatar{
    width:34px;height:34px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,var(--primary),var(--teal));
    display:flex;align-items:center;justify-content:center;
    font-size:12px;font-weight:700;color:#fff;
}
.sb-user-info strong{display:block;font-size:13px;font-weight:600;color:#fff;}
.sb-user-info span{display:block;font-size:11px;color:var(--sb-text);}

/* ─── MAIN ──────────────────────────────────────────────────────── */
.main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;}
.page-wrap{padding:0 28px 40px;}

/* ─── HERO ──────────────────────────────────────────────────────── */
.hero{
    background:linear-gradient(135deg, #1a3a7a 0%, #1e4db7 55%, #1260ae 100%);
    padding:30px 28px;
    display:flex;align-items:center;justify-content:space-between;gap:24px;
    margin-bottom:0;
}
.hero-left{flex:1;min-width:0;}
.hero-title{
    display:flex;align-items:center;gap:10px;
    font-size:22px;font-weight:800;color:#fff;margin-bottom:8px;
}
.hero-title svg{opacity:.9;flex-shrink:0;}
.hero-desc{font-size:13px;color:rgba(255,255,255,.75);margin-bottom:16px;line-height:1.5;}
.hero-badges{display:flex;flex-wrap:wrap;gap:8px;}
.hero-badge{
    display:inline-flex;align-items:center;gap:5px;
    background:rgba(255,255,255,.14);color:rgba(255,255,255,.9);
    font-size:12px;font-weight:500;
    padding:5px 11px;border-radius:20px;
    border:1px solid rgba(255,255,255,.18);
}
.hero-badge svg{opacity:.8;}

.hero-right{flex-shrink:0;}
.rata-card{
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.15);
    border-radius:var(--radius);
    padding:18px 22px;
    min-width:220px;
    backdrop-filter:blur(6px);
}
.rata-label{
    font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;
    color:rgba(255,255,255,.6);margin-bottom:8px;
}
.rata-value{
    font-family:'JetBrains Mono',monospace;
    font-size:38px;font-weight:800;color:#fff;
    letter-spacing:-2px;line-height:1;margin-bottom:10px;
}
.rata-bar{height:4px;border-radius:99px;background:rgba(255,255,255,.2);overflow:hidden;margin-bottom:8px;}
.rata-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#22c55e,#86efac);transition:width .6s;}
.rata-sub{font-size:12px;color:rgba(255,255,255,.55);}

/* ─── FILTER SECTION ─────────────────────────────────────────────── */
.filter-section{background:var(--surface);border-bottom:1px solid var(--border);padding:20px 28px;}
.filter-title{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:var(--text);margin-bottom:3px;}
.filter-desc{font-size:12px;color:var(--text-muted);margin-bottom:16px;}
.filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;}
.fg{display:flex;flex-direction:column;gap:5px;}
.fg label{font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;}
.fg select,.fg input{
    border:1px solid var(--border);border-radius:var(--radius-sm);
    padding:8px 12px;font-size:13px;font-family:'Inter',sans-serif;
    color:var(--text);background:var(--bg);outline:none;
    transition:border-color .15s,box-shadow .15s;
}
.fg select:focus,.fg input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(37,99,235,.12);}
.fg-sm select{min-width:130px;}
.fg-md select{min-width:160px;}
.fg-lg select{min-width:260px;}
.btn{
    display:inline-flex;align-items:center;gap:6px;
    padding:9px 18px;border-radius:var(--radius-sm);
    border:none;cursor:pointer;font-family:'Inter',sans-serif;
    font-size:13px;font-weight:600;transition:background .15s,transform .1s;
}
.btn:active{transform:scale(.97);}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:var(--primary-dk);}
.btn-outline{background:transparent;color:var(--text-b);border:1px solid var(--border);}
.btn-outline:hover{background:var(--bg);}

/* ─── INFO CARDS ─────────────────────────────────────────────────── */
.info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;padding:20px 28px 0;}
.info-card{
    background:var(--surface);border:1px solid var(--border);
    border-radius:var(--radius);padding:18px 20px;
    box-shadow:var(--shadow);
    display:flex;align-items:flex-start;gap:14px;
    transition:transform .2s,box-shadow .2s;
}
.info-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.info-icon{
    width:44px;height:44px;border-radius:12px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
}
.info-icon.green{background:var(--green-bg);color:var(--green);}
.info-icon.red{background:var(--red-bg);color:var(--red);}
.info-icon.amber{background:var(--amber-bg);color:var(--amber);}
.info-body{min-width:0;}
.info-label{
    font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;
    color:var(--text-muted);margin-bottom:4px;
}
.info-value{
    font-size:15px;font-weight:700;color:var(--text);
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
    margin-bottom:3px;
}
.info-sub{font-size:11.5px;color:var(--text-muted);line-height:1.4;}

/* ─── STAT CARDS (riska.txt) ─────────────────────────────────────── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
.stat-card{
    background:var(--surface);border:1px solid var(--border);
    border-radius:var(--radius);padding:20px 22px;
    box-shadow:var(--shadow);
    display:flex;flex-direction:column;gap:6px;
    position:relative;overflow:hidden;
    transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.stat-card::before{
    content:'';position:absolute;top:0;left:0;right:0;
    height:4px;border-radius:14px 14px 0 0;
}
.stat-card.green::before{background:var(--green);}
.stat-card.teal::before {background:var(--teal);}
.stat-card.sky::before  {background:var(--sky);}
.stat-card.amber::before{background:var(--amber);}
.stat-icon{font-size:28px;position:absolute;right:18px;top:18px;opacity:.15;}
.stat-label{font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;}
.stat-value{font-size:30px;font-weight:800;font-family:'JetBrains Mono',monospace;letter-spacing:-1px;color:var(--text);}
.stat-sub{font-size:12px;color:var(--text-muted);}

/* ─── CHARTS ─────────────────────────────────────────────────────── */
.charts-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px;padding:20px 28px 0;}
.chart-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow);}
.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.card-head-left{display:flex;align-items:center;gap:8px;}
.card-title{font-size:13.5px;font-weight:700;color:var(--text);}
.card-badge{
    font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;
    background:var(--primary-lt);color:var(--primary);
}
.legend{display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;}
.legend-dot{width:9px;height:9px;border-radius:50%;}
.legend-item{display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--text-b);}

/* ─── SECTION WRAPPER ────────────────────────────────────────────── */
.section{padding:20px 28px 0;}
.section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;}
.section-head{
    padding:16px 20px;border-bottom:1px solid var(--border);
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
}
.section-head-left{display:flex;align-items:center;gap:8px;}
.section-title{font-size:14px;font-weight:700;color:var(--text);}
.section-sub{font-size:12px;color:var(--text-muted);margin-top:2px;}

/* ─── MATRIX TABLE ───────────────────────────────────────────────── */
.table-wrap{overflow-x:auto;}
.mtx-table{width:100%;border-collapse:collapse;font-size:12px;}
.mtx-table thead tr{background:#0f1629;}
.mtx-table thead th{
    padding:11px 10px;color:rgba(255,255,255,.8);
    font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;
    white-space:nowrap;border:none;text-align:left;
}
.mtx-table thead th.c{text-align:center;}
.mtx-table tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
.mtx-table tbody tr:last-child{border-bottom:none;}
.mtx-table tbody tr:hover{background:#f8fafc;}
.mtx-table td{padding:10px 10px;vertical-align:middle;white-space:nowrap;}
.mtx-table td.c{text-align:center;}
.mtx-name{font-weight:600;color:var(--text);max-width:160px;white-space:normal;line-height:1.3;}
.mtx-num{font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:600;text-align:center;}

/* indicator cell coloring */
.ic{display:inline-flex;align-items:center;justify-content:center;
    width:42px;border-radius:5px;padding:3px 2px;font-weight:600;font-size:11px;font-family:'JetBrains Mono',monospace;}
.ic-h{background:#dcfce7;color:#15803d;}   /* ≥70 */
.ic-m{background:#fef9c3;color:#a16207;}   /* 50-69 */
.ic-l{background:#ffedd5;color:#c2410c;}   /* 30-49 */
.ic-v{background:#fee2e2;color:#b91c1c;}   /* <30  */
.ic-n{background:#f1f5f9;color:#94a3b8;}   /* 0/null */

/* ─── REKAP TABLE ────────────────────────────────────────────────── */
.rkp-table{width:100%;border-collapse:collapse;font-size:13px;}
.rkp-table thead tr{background:var(--bg);}
.rkp-table thead th{
    padding:10px 14px;text-align:left;
    font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;
    color:var(--text-muted);border-bottom:1px solid var(--border);white-space:nowrap;
}
.rkp-table thead th.r{text-align:right;}
.rkp-table tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
.rkp-table tbody tr:last-child{border-bottom:none;}
.rkp-table tbody tr:hover{background:#f8fafc;}
.rkp-table td{padding:11px 14px;vertical-align:middle;}
.rkp-table td.r{text-align:right;font-family:'JetBrains Mono',monospace;font-size:12px;}

.prog-wrap{display:flex;align-items:center;gap:8px;}
.prog-bar{height:5px;border-radius:99px;background:var(--border);overflow:hidden;flex:1;min-width:60px;}
.prog-fill{height:100%;border-radius:99px;}
.pg-green {background:var(--green);}
.pg-amber {background:var(--amber);}
.pg-orange{background:#f97316;}
.pg-red   {background:var(--red);}
.prog-pct {font-family:'JetBrains Mono',monospace;font-size:11.5px;font-weight:700;min-width:40px;text-align:right;}

.rank{width:24px;height:24px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;}
.rk-1{background:#fef3c7;color:#b45309;}
.rk-2{background:#dcfce7;color:#15803d;}
.rk-n{background:var(--bg);color:var(--text-muted);}

.badge{display:inline-flex;align-items:center;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;}
.b-tinggi       {background:#dcfce7;color:#15803d;}
.b-sedang       {background:#fef9c3;color:#a16207;}
.b-rendah       {background:#ffedd5;color:#c2410c;}
.b-sangatrendah {background:#fee2e2;color:#b91c1c;}

/* ─── EMPTY STATE ────────────────────────────────────────────────── */
.empty{text-align:center;padding:48px 20px;color:var(--text-muted);}
.empty svg{opacity:.25;margin-bottom:10px;}
.empty p{font-size:13px;}

/* ─── SPACER & FOOTER ────────────────────────────────────────────── */
.spacer{height:20px;}
.footer{text-align:center;font-size:11.5px;color:var(--text-muted);padding:20px 28px 0;border-top:1px solid var(--border);margin-top:28px;}

/* ─── RESPONSIVE ─────────────────────────────────────────────────── */
@media(max-width:900px){
    .sidebar{display:none;}
    .main{margin-left:0;}
    .charts-grid,.info-grid,.stat-grid{grid-template-columns:1fr;}
    .hero{flex-direction:column;}
    .hero-right{width:100%;}
}
</style>
</head>
<body>

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
        <a href="#" class="sb-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>
        <a href="{{ route('dashboard') }}" class="sb-item active">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
            </svg>
            Ringkasan PHBS
        </a>
        <a href="#" class="sb-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Peta
        </a>
        <a href="#" class="sb-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            Laporan Rekapitulasi
        </a>
    </div>

    <div class="sb-section">
        <span class="sb-label">Akun</span>
        <a href="{{ route('logout') ?? '#' }}" class="sb-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') ?? '#' }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
            <div class="sb-user-info">
                <strong>{{ auth()->user()->name ?? 'Admin Dinkes' }}</strong>
                <span>Dinkes &bull; SIP-PHBS</span>
            </div>
        </div>
    </div>
</aside>

{{-- ══════════════ MAIN ══════════════ --}}
<main class="main">

    {{-- ── HERO ── --}}
    <div class="hero">
        <div class="hero-left">
            <div class="hero-title">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
                Dashboard PHBS
            </div>
            <p class="hero-desc">
                Pemantauan capaian 13 indikator PHBS berdasarkan laporan puskesmas pada periode terpilih.
            </p>
            <div class="hero-badges">
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $bulan ? \App\Models\data_phbs::namaBulan($bulan) : 'Semua Bulan' }} {{ $tahun }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                    @if($id_puskesmas)
                        {{ $puskesmasList->firstWhere('id_puskesmas', $id_puskesmas)?->nama_puskesmas ?? 'Puskesmas Terpilih' }}
                    @else
                        Semua Puskesmas
                    @endif
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
                <div class="rata-label">Rata-rata PHBS Periode Ini</div>
                <div class="rata-value">{{ number_format($rataRataPhbs, 1) }}<span style="font-size:22px">%</span></div>
                <div class="rata-bar">
                    <div class="rata-fill" style="width:{{ min($rataRataPhbs, 100) }}%"></div>
                </div>
                <div class="rata-sub">{{ $statusTerkirim }} laporan terpantau</div>
            </div>
        </div>
    </div>{{-- /hero --}}

    {{-- ── FILTER ── --}}
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
                                {{ \App\Models\data_phbs::namaBulan($b) }}
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
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    Terapkan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M4 4v5h.582M20 20v-5h-.581M4.582 9A8 8 0 0119.418 15M19.419 15H15m4.419 0v4.419"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>{{-- /filter --}}

    <div class="page-wrap">

        {{-- ── INFO CARDS ── --}}
        <div class="info-grid" style="padding:20px 0 0;">
            {{-- Puskesmas Terbaik --}}
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
                            {{ number_format((float)$puskesmasTertinggi->persentase_phbs,1) }}% capaian Ber-PHBS
                        @else
                            Belum ada laporan pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            {{-- Perlu Perhatian --}}
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
                            {{ number_format((float)$puskesmasTerendah->persentase_phbs,1) }}% – capaian terendah
                        @else
                            Belum ada laporan pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            {{-- Status Laporan --}}
            <div class="info-card">
                <div class="info-icon amber">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Status Laporan</div>
                    <div class="info-value">{{ $statusTerkirim }} terkirim &bull; {{ $statusDraft }} draft</div>
                    <div class="info-sub">Jumlah laporan terkirim dan draft pada periode terpilih.</div>
                </div>
            </div>
        </div>

        {{-- ── CHARTS ── --}}
        <div class="charts-grid" style="padding:20px 0 0;">

            {{-- Bar: capaian per puskesmas --}}
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

            {{-- Doughnut: distribusi --}}
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

        {{-- Tren Bulanan (full width) --}}
        <div style="padding:16px 0 0;">
            <div class="chart-card">
                <div class="card-head">
                    <div class="card-head-left">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M3 3v18h18M7 16l4-4 4 4 4-4"/>
                        </svg>
                        <span class="card-title">Tren Rata-rata Capaian PHBS per Bulan</span>
                    </div>
                    <span class="card-badge">{{ $tahun }}</span>
                </div>
                <div style="height:200px;"><canvas id="chartTren"></canvas></div>
            </div>
        </div>

        {{-- ── MATRIKS 13 INDIKATOR ── --}}
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
                        </svg>
                        <div>
                            <div class="section-title">Matriks 13 Indikator PHBS per Puskesmas</div>
                            <div class="section-sub">Tabel ini menampilkan persentase capaian setiap indikator PHBS per puskesmas.</div>
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
                                <th>Puskesmas</th>
                                <th class="c">Laporan</th>
                                <th class="c">Rata-rata</th>
                                @foreach($allIndikators as $ind)<th class="c" title="{{ $ind->nama_indikator }}">I{{ $ind->id_indikator }}</th>@endforeach
                                <th class="c">Ind. Terendah</th>
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
                                    <span class="ic ic-v">{{ $row->ind_terendah }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── REKAP PER PUSKESMAS ── --}}
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <div>
                            <div class="section-title">Rekapitulasi Ber-PHBS per Puskesmas</div>
                            <div class="section-sub">Hanya laporan berstatus <strong>terkirim</strong> · Tahun {{ $tahun }}</div>
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
                                        $pct>=70 => ['Tinggi','b-tinggi','pg-green'],
                                        $pct>=50 => ['Sedang','b-sedang','pg-amber'],
                                        $pct>=30 => ['Rendah','b-rendah','pg-orange'],
                                        default  => ['Sangat Rendah','b-sangatrendah','pg-red'],
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="rank {{ $i===0?'rk-1':($i===1?'rk-2':'rk-n') }}">{{ $i+1 }}</div>
                                    </td>
                                    <td style="font-weight:600;color:var(--text);">{{ $row->nama_puskesmas }}</td>
                                    <td>{{ $row->kecamatan ?? '-' }}</td>
                                    <td style="color:var(--text-b);">{{ $row->kepala_puskesmas ?? '-' }}</td>
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

        {{-- ── REKAP PER INDIKATOR ── --}}
        <div style="padding:20px 0 0;">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <div>
                            <div class="section-title">Rekapitulasi per Indikator PHBS</div>
                            <div class="section-sub">Akumulasi seluruh puskesmas · Tahun {{ $tahun }}</div>
                        </div>
                    </div>
                </div>
                <div class="table-wrap">
                    <table class="rkp-table">
                        <thead>
                            <tr>
                                <th style="width:32px;text-align:center;">No</th>
                                <th>Indikator</th>
                                <th class="r">Total Sasaran</th>
                                <th class="r">Total Jumlah</th>
                                <th style="min-width:200px;">Persentase</th>
                                <th style="text-align:center;">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapIndikator as $no => $ind)
                                @php
                                    $pct = (float)$ind['persentase'];
                                    [$lvl,$bdg,$pg] = match(true){
                                        $pct>=70 => ['Tinggi','b-tinggi','pg-green'],
                                        $pct>=50 => ['Sedang','b-sedang','pg-amber'],
                                        $pct>=30 => ['Rendah','b-rendah','pg-orange'],
                                        default  => ['Sangat Rendah','b-sangatrendah','pg-red'],
                                    };
                                @endphp
                                <tr>
                                    <td style="text-align:center;font-weight:600;color:var(--text-muted);">{{ $no }}</td>
                                    <td style="font-weight:500;color:var(--text);">{{ $ind['label'] }}</td>
                                    <td class="r">{{ number_format($ind['total_sasaran']) }}</td>
                                    <td class="r">{{ number_format($ind['total_jumlah']) }}</td>
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
                </div>
            </div>
        </div>

        <div class="footer">SIP-PHBS &mdash; Dinas Kesehatan Kabupaten Sleman &copy; {{ date('Y') }}</div>

    </div>{{-- /page-wrap --}}
</main>

{{-- ══════════════ CHARTS JS ══════════════ --}}
<script>
const barLabels  = @json($grafikLabels);
const barData    = @json($grafikData);
const barColors  = @json($grafikColors);
const pieData    = [{{ $distribusiTinggi }},{{ $distribusiSedang }},{{ $distribusiRendah }},{{ $distribusiSangatRendah }}];
const trenLabels = @json($trenLabels);
const trenData   = @json($trenData);
const target     = {{ $targetNasional }};

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color       = '#94a3b8';
Chart.defaults.borderColor = '#e2e8f0';

// Bar
new Chart(document.getElementById('chartBar'),{
    type:'bar',
    data:{labels:barLabels,datasets:[{label:'Ber-PHBS (%)',data:barData,backgroundColor:barColors,borderRadius:5,borderSkipped:false}]},
    options:{
        responsive:true,maintainAspectRatio:false,
        plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>` ${Number(c.parsed.y).toFixed(1)}%`}}},
        scales:{x:{ticks:{font:{size:10},maxRotation:45},grid:{display:false}},y:{min:0,max:100,ticks:{callback:v=>v+'%'}}}
    }
});

// Doughnut
new Chart(document.getElementById('chartPie'),{
    type:'doughnut',
    data:{
        labels:['Tinggi (≥70%)','Sedang (50–69%)','Rendah (30–49%)','Sangat Rendah (<30%)'],
        datasets:[{data:pieData,backgroundColor:['rgba(34,197,94,.85)','rgba(245,158,11,.85)','rgba(249,115,22,.85)','rgba(239,68,68,.85)'],borderWidth:2,borderColor:'#fff'}]
    },
    options:{responsive:true,maintainAspectRatio:false,cutout:'62%',plugins:{legend:{display:false},tooltip:{callbacks:{label:c=>` ${c.label}: ${c.parsed} puskesmas`}}}}
});

// Tren
new Chart(document.getElementById('chartTren'),{
    type:'line',
    data:{
        labels:trenLabels,
        datasets:[
            {label:'Rata-rata Ber-PHBS (%)',data:trenData,borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,.08)',fill:true,tension:.4,pointBackgroundColor:'#2563eb',pointRadius:4,pointHoverRadius:6,borderWidth:2.5},
            {label:`Target (${target}%)`,data:Array(trenLabels.length).fill(target),borderColor:'rgba(239,68,68,.5)',borderDash:[6,4],borderWidth:1.5,pointRadius:0,fill:false}
        ]
    },
    options:{
        responsive:true,maintainAspectRatio:false,
        plugins:{legend:{position:'top',labels:{font:{size:12},boxWidth:12}},tooltip:{callbacks:{label:c=>` ${c.dataset.label}: ${Number(c.parsed.y).toFixed(1)}%`}}},
        scales:{y:{min:0,max:100,ticks:{callback:v=>v+'%'}}}
    }
});
</script>
</body>
</html>