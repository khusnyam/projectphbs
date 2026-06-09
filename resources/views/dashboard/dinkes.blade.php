<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PHBS – SIP-PHBS Kab. Sleman</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">

<style>
/* ─── DESIGN TOKENS: mengikuti resources/views/dashboard/index.blade.php ─── */
:root {
    --green:#22c55e; --green-bg:#f0fdf4; --green-ring:#bbf7d0;
    --teal:#14b8a6; --teal-bg:#f0fdfa;
    --sky:#0ea5e9; --sky-bg:#f0f9ff;
    --amber:#f59e0b; --amber-bg:#fffbeb; --amber-ring:#fde68a;
    --red:#ef4444; --red-bg:#fef2f2; --red-ring:#fecaca;
    --primary:#2563eb; --primary-dk:#1d4ed8; --primary-lt:#eff6ff;

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
}

/* ─── RESET ─────────────────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-b);min-height:100vh;}
a{text-decoration:none;color:inherit;}

/* ─── SIDEBAR: disamakan dari index.blade ───────────────────────── */
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
    position:relative;width:100%;border:0;background:transparent;
    font-family:'Inter',sans-serif;text-align:left;
}
.sb-item:hover{background:var(--sb-hover);color:#fff;}
.sb-item.active{background:var(--sb-active);color:#fff;font-weight:600;}
.sb-item.active::before{
    content:'';position:absolute;left:0;top:6px;bottom:6px;
    width:3px;border-radius:0 3px 3px 0;background:var(--amber);
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
.sb-user-info strong{display:block;font-size:13px;font-weight:600;color:#fff;line-height:1.2;}
.sb-user-info span{display:block;font-size:11px;color:var(--sb-text);margin-top:1px;}

/* ─── MAIN ──────────────────────────────────────────────────────── */
.main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;}
.page-wrap{padding:0 28px 40px;}

/* ─── HERO ──────────────────────────────────────────────────────── */
.hero{
    background:linear-gradient(135deg,#1a3a7a 0%,#1e4db7 55%,#1260ae 100%);
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
    padding:18px 22px;min-width:220px;
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
.info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;padding:20px 0 0;}
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
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px;
}
.info-sub{font-size:11.5px;color:var(--text-muted);line-height:1.4;}

/* ─── SECTION WRAPPER ────────────────────────────────────────────── */
.section{padding:20px 0 0;}
.section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;}
.section-head{
    padding:16px 20px;border-bottom:1px solid var(--border);
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
}
.section-head-left{display:flex;align-items:center;gap:8px;}
.section-title{font-size:14px;font-weight:700;color:var(--text);}
.section-sub{font-size:12px;color:var(--text-muted);margin-top:2px;}
.card-badge{
    font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;
    background:var(--primary-lt);color:var(--primary);
}

/* ─── MATRIX TABLE ───────────────────────────────────────────────── */
.table-wrap{overflow-x:auto;}
.mtx-table{width:100%;border-collapse:collapse;font-size:12px;min-width:1260px;}
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
.mtx-name{font-weight:600;color:var(--text);min-width:210px;line-height:1.3;}
.mtx-small{display:block;color:var(--text-muted);font-size:10.5px;font-weight:500;margin-top:2px;}
.mtx-num{font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:600;text-align:center;}

.ic{
    display:inline-flex;align-items:center;justify-content:center;
    min-width:42px;border-radius:5px;padding:3px 6px;
    font-weight:600;font-size:11px;font-family:'JetBrains Mono',monospace;
}
.ic-h,.ic-good{background:#dcfce7;color:#15803d;}
.ic-m,.ic-mid{background:#fef9c3;color:#a16207;}
.ic-l,.ic-low{background:#fee2e2;color:#b91c1c;}
.ic-n,.ic-empty{background:#f1f5f9;color:#94a3b8;}

.legend{display:flex;gap:8px;flex-wrap:wrap;padding:12px 20px;border-top:1px solid var(--border);}
.legend span{font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;}
.legend .good{background:#dcfce7;color:#15803d;}
.legend .mid{background:#fef9c3;color:#a16207;}
.legend .low{background:#fee2e2;color:#b91c1c;}
.legend .empty{background:#f1f5f9;color:#94a3b8;}

.empty{text-align:center;padding:48px 20px;color:var(--text-muted);}
.empty svg{opacity:.25;margin-bottom:10px;}
.empty p{font-size:13px;}

/* ─── INDICATOR SUMMARY ──────────────────────────────────────────── */
.indicator-grid{
    display:grid;grid-template-columns:repeat(13,minmax(158px,1fr));
    gap:10px;overflow-x:auto;padding:16px 20px 20px;
}
.ind-card{border:1px solid var(--border);border-radius:var(--radius);background:#fff;padding:12px;}
.ind-num{
    width:28px;height:28px;border-radius:8px;background:var(--primary-lt);color:var(--primary);
    font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;margin-bottom:8px;
}
.ind-title{font-size:11.5px;line-height:1.35;font-weight:700;color:var(--text);min-height:39px;}
.ind-pct{font-family:'JetBrains Mono',monospace;font-size:20px;font-weight:800;margin:7px 0 2px;}
.ind-meta{font-size:10.5px;color:var(--text-muted);}
.mini-track{height:6px;background:#f1f5f9;border-radius:999px;overflow:hidden;margin-top:8px;}
.mini-fill{height:100%;border-radius:999px;}
.footer-note{
    font-size:12px;color:var(--text-muted);line-height:1.55;background:#f8fafc;
    border:1px dashed #cbd5e1;border-radius:10px;padding:10px 12px;margin:0 20px 18px;
}

/* ─── RESPONSIVE ─────────────────────────────────────────────────── */
@media(max-width:900px){
    .sidebar{display:none;}
    .main{margin-left:0;}
    .info-grid{grid-template-columns:1fr;}
    .hero{flex-direction:column;align-items:flex-start;}
    .hero-right{width:100%;}
    .rata-card{width:100%;}
}
</style>
</head>

<body>
@php
  $laporan = collect($laporan ?? []);
  $puskesmasList = collect($puskesmasList ?? []);

  $namaBulan = $namaBulan ?? [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
    7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
  ];

  $indicatorLabels = [
    1=>'Persalinan ditolong oleh Nakes',
    2=>'Memberi bayi ASI Eksklusif',
    3=>'Menimbang balita setiap bulan',
    4=>'Menggunakan air bersih',
    5=>'Mencuci tangan dg air bersih & sabun',
    6=>'Pengelolaan air minum & makanan',
    7=>'Menggunakan jamban sehat',
    8=>'Pengelolaan limbah cair rumah tangga',
    9=>'Membuang sampah di tempat sampah',
    10=>'Memberantas jentik di rumah',
    11=>'Makan sayur dan buah setiap hari',
    12=>'Melakukan aktivitas fisik setiap hari',
    13=>'Tidak merokok di dalam rumah',
  ];

  $tahun = $tahun ?? date('Y');
  $bulan = $bulan ?? 0;
  $pkmId = $pkmId ?? 0;

  $cellClass = function($value, $empty = false){
    if($empty) return 'empty';
    if($value >= 80) return 'good';
    if($value >= 60) return 'mid';
    return 'low';
  };

  $kategoriName = function($value){
    if($value >= 80) return 'Baik';
    if($value >= 60) return 'Cukup';
    return 'Kurang';
  };

  $totalKk = (int) $laporan->sum('jumlah_kk_total');
  $totalBerPhbs = (int) $laporan->sum('ber_phbs');
  $rataPhbs = $totalKk > 0 ? round(($totalBerPhbs / $totalKk) * 100, 1) : 0;

  $visiblePuskesmas = $pkmId
    ? $puskesmasList->where('id_puskesmas', $pkmId)->values()
    : $puskesmasList->values();

  $puskesmasSummary = $visiblePuskesmas->map(function($pkm) use ($laporan, $indicatorLabels, $cellClass, $kategoriName){
    $items = $laporan->where('id_puskesmas', $pkm->id_puskesmas);

    $total = (int) $items->sum('jumlah_kk_total');
    $ber = (int) $items->sum('ber_phbs');
    $avg = $total > 0 ? round(($ber / $total) * 100, 1) : 0;

    $indicators = collect($indicatorLabels)->map(function($label, $num) use ($items, $cellClass, $kategoriName){
      $sasaran = (int) $items->sum("ind{$num}_sasaran");
      $jumlah = (int) $items->sum("ind{$num}_jumlah");
      $persen = $sasaran > 0 ? round(($jumlah / $sasaran) * 100, 1) : 0;

      return [
        'num'=>$num,
        'label'=>$label,
        'sasaran'=>$sasaran,
        'jumlah'=>$jumlah,
        'persen'=>$persen,
        'class'=>$cellClass($persen, $sasaran <= 0),
        'kategori'=>$sasaran <= 0 ? '-' : $kategoriName($persen),
      ];
    })->values();

    return [
      'id_puskesmas'=>$pkm->id_puskesmas,
      'nama_puskesmas'=>$pkm->nama_puskesmas,
      'laporan_count'=>$items->count(),
      'total_kk'=>$total,
      'ber_phbs'=>$ber,
      'rata_phbs'=>$avg,
      'class'=>$cellClass($avg, $items->count() <= 0),
      'kategori'=>$items->count() <= 0 ? '-' : $kategoriName($avg),
      'indicators'=>$indicators,
      'indikator_terendah'=>$indicators->where('sasaran','>',0)->sortBy('persen')->first(),
      'indikator_terbaik'=>$indicators->where('sasaran','>',0)->sortByDesc('persen')->first(),
    ]; 
  })->filter(fn($row) => $row['rata_phbs'] > 0)->values();

  $ranking = $puskesmasSummary->where('laporan_count','>',0)->sortByDesc('rata_phbs')->values();
  $topPuskesmas = $ranking->first();
  $lowPuskesmas = $ranking->sortBy('rata_phbs')->first();

  $statusTerkirim = $laporan->where('status_laporan','terkirim')->count();
  $statusDraft = $laporan->where('status_laporan','draft')->count();

  $indicatorSummary = collect($indicatorLabels)->map(function($label, $num) use ($laporan, $cellClass, $kategoriName){
    $sasaran = (int) $laporan->sum("ind{$num}_sasaran");
    $jumlah = (int) $laporan->sum("ind{$num}_jumlah");
    $persen = $sasaran > 0 ? round(($jumlah / $sasaran) * 100, 1) : 0;

    return [
      'num'=>$num,
      'label'=>$label,
      'sasaran'=>$sasaran,
      'jumlah'=>$jumlah,
      'persen'=>$persen,
      'class'=>$cellClass($persen, $sasaran <= 0),
      'kategori'=>$sasaran <= 0 ? '-' : $kategoriName($persen),
    ];
  })->values();

  $periodeBulan = $bulan ? ($namaBulan[$bulan] ?? '-') : 'Semua Bulan';
  $selectedPuskesmasName = $pkmId
    ? optional($puskesmasList->firstWhere('id_puskesmas', $pkmId))->nama_puskesmas
    : 'Semua Puskesmas';

  $userName = auth()->user()->nama_user ?? auth()->user()->name ?? 'Admin Dinkes';
  $userRole = ucfirst(auth()->user()->role ?? 'dinkes');
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
            <div class="sb-avatar">{{ strtoupper(substr($userName,0,1)) }}</div>
            <div class="sb-user-info">
                <strong>{{ $userName }}</strong>
                <span>{{ $userRole }} &bull; SIP-PHBS</span>
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
                Ringkasan PHBS
            </div>
            <p class="hero-desc">
                Pemantauan capaian 13 indikator PHBS berdasarkan laporan puskesmas pada periode terpilih.
            </p>
            <div class="hero-badges">
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    {{ $periodeBulan }} {{ $tahun }}
                </span>
                <span class="hero-badge">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                    {{ $selectedPuskesmasName }}
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
            {{-- <div class="rata-card">
                <div class="rata-label">Rata-rata PHBS Periode Ini</div>
                <div class="rata-value">{{ number_format($rataPhbs,1) }}<span style="font-size:22px">%</span></div>
                <div class="rata-bar">
                    <div class="rata-fill" style="width:{{ min($rataPhbs,100) }}%"></div>
                </div>
                <div class="rata-sub">{{ $laporan->count() }} laporan terpantau</div>
            </div> --}}
        </div>
    </div>

    {{-- ── FILTER ── --}}
    <div class="filter-section">
        <div class="filter-title">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM6 10a1 1 0 011-1h10a1 1 0 010 2H7a1 1 0 01-1-1zM9 16a1 1 0 011-1h4a1 1 0 010 2h-4a1 1 0 01-1-1z"/>
            </svg>
            Filter Dashboard
        </div>
        <p class="filter-desc">Pilih tahun, bulan, atau puskesmas untuk menampilkan data sesuai kebutuhan.</p>

        <form method="GET" action="{{ route('phbs.dashboard') }}">
            <div class="filter-row">
                <div class="fg fg-sm">
                    <label>Tahun</label>
                    <select name="tahun">
                        @for($y=2023;$y<=2026;$y++)
                            <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="fg fg-md">
                    <label>Bulan</label>
                    <select name="bulan">
                        <option value="0">Semua Bulan</option>
                        @foreach($namaBulan as $num=>$nm)
                            <option value="{{ $num }}" {{ $bulan==$num?'selected':'' }}>{{ $nm }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="fg fg-lg">
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

                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    Terapkan
                </button>

                <a href="{{ route('phbs.dashboard') }}" class="btn btn-outline">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M4 4v5h.582M20 20v-5h-.581M4.582 9A8 8 0 0119.418 15M19.419 15H15m4.419 0v4.419"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="page-wrap">

        {{-- ── INFO CARDS ── --}}
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon green">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Puskesmas Terbaik</div>
                    <div class="info-value">{{ $topPuskesmas['nama_puskesmas'] ?? 'Belum ada data' }}</div>
                    <div class="info-sub">
                        @if($topPuskesmas)
                            Capaian PHBS tertinggi pada periode terpilih.
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
                    <div class="info-value">Puskesmas Minggir</div>
                    <div class="info-sub">
                        @if($lowPuskesmas)
                            0.0% – capaian terendah
                        @else
                            Belum ada laporan pada periode ini
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon amber">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Status Laporan</div>
                    <div class="info-value">{{ $statusTerkirim }} terkirim • {{ $statusDraft }} draft</div>
                    <div class="info-sub">Jumlah laporan terkirim dan draft pada periode terpilih.</div>
                </div>
            </div>
        </div>

        {{-- ── MATRIKS 13 INDIKATOR ── --}}
        <div class="section">
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
                    <span class="card-badge">{{ $puskesmasSummary->count() }} puskesmas</span>
                </div>

                <div class="table-wrap">
                    @if($puskesmasSummary->isEmpty())
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
                                    @foreach($indicatorLabels as $num=>$label)
                                        <th class="c" title="{{ $label }}">I{{ $num }}</th>
                                    @endforeach
                                    <th class="c">Ind. Terendah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($puskesmasSummary as $pkm)
                                    <tr>
                                        <td class="mtx-name">
                                            {{ $pkm['nama_puskesmas'] }}
                                            <span class="mtx-small">
                                                {{ number_format($pkm['total_kk']) }} KK • {{ number_format($pkm['ber_phbs']) }} ber-PHBS
                                            </span>
                                        </td>
                                        <td class="c mtx-num">{{ $pkm['laporan_count'] }}</td>
                                        <td class="c">
                                            <span class="ic ic-{{ $pkm['class'] }}">
                                                {{ $pkm['laporan_count'] ? $pkm['rata_phbs'].'%' : '-' }}
                                            </span>
                                        </td>

                                        @foreach($pkm['indicators'] as $ind)
                                            <td class="c" title="{{ $ind['label'] }}: {{ number_format($ind['jumlah']) }}/{{ number_format($ind['sasaran']) }}">
                                                <span class="ic ic-{{ $ind['class'] }}">
                                                    {{ $ind['sasaran'] > 0 ? $ind['persen'].'%' : '-' }}
                                                </span>
                                            </td>
                                        @endforeach

                                        <td class="c mtx-num">
                                            @if($pkm['indikator_terendah'])
                                                I{{ $pkm['indikator_terendah']['num'] }} • {{ $pkm['indikator_terendah']['persen'] }}%
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="legend">
                    <span class="good">Baik ≥80%</span>
                    <span class="mid">Cukup 60-79%</span>
                    <span class="low">Kurang &lt;60%</span>
                    <span class="empty">- belum ada sasaran/data</span>
                </div>
            </div>
        </div>

        {{-- ── RINGKASAN 13 INDIKATOR ── --}}
        <div class="section">
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2.5">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12l2 2 4-4"/>
                        </svg>
                        <div>
                            <div class="section-title">Ringkasan 13 Indikator Tingkat Kabupaten</div>
                            <div class="section-sub">Rangkuman capaian tiap indikator dari seluruh laporan pada periode terpilih.</div>
                        </div>
                    </div>
                    <span class="card-badge">{{ $periodeBulan }} {{ $tahun }}</span>
                </div>

                <div class="indicator-grid">
                    @foreach($indicatorSummary as $ind)
                        @php
                            $color = $ind['class']==='good' ? '#22c55e' : ($ind['class']==='mid' ? '#f59e0b' : ($ind['class']==='low' ? '#ef4444' : '#cbd5e1'));
                        @endphp
                        <div class="ind-card">
                            <div class="ind-num">I{{ $ind['num'] }}</div>
                            <div class="ind-title">{{ $ind['label'] }}</div>
                            <div class="ind-pct" style="color:{{ $color }}">
                                {{ $ind['sasaran'] > 0 ? $ind['persen'].'%' : '-' }}
                            </div>
                            <div class="ind-meta">
                                {{ number_format($ind['jumlah']) }}/{{ number_format($ind['sasaran']) }} memenuhi
                            </div>
                            <div class="mini-track">
                                <div class="mini-fill" style="width:{{ min($ind['persen'],100) }}%;background:{{ $color }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="footer-note">
                    Data mengikuti filter yang sedang aktif.
                </div>
            </div>
        </div>

    </div>
</main>
</body>
</html>
