<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard – SIP-PHBS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
:root{
  --blue-dark:#002277;
  --blue:#003399;
  --blue-mid:#0044cc;
  --yellow:#FFCC00;
  --yellow-light:#fff8cc;
  --bg:#f0f4ff;
  --s9:#0a1628;
  --s7:#1e3a5f;
  --s5:#64748b;
  --s3:#cbd5e1;
  --s1:#f1f5f9;
  --fm:'Segoe UI',sans-serif
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--fm);background:var(--bg);min-height:100vh;display:flex}

/* SIDEBAR */
.sidebar{width:230px;flex-shrink:0;background:linear-gradient(180deg,#0a1628 0%,#0d2137 60%,#0a3d2e 100%);position:fixed;top:0;left:0;height:100vh;display:flex;flex-direction:column;z-index:100}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sb-logo-row{display:flex;align-items:center;gap:10px}
.sb-icon{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));display:flex;align-items:center;justify-content:center;color:var(--yellow);font-size:16px}
.sb-logo h1{font-size:.85rem;font-weight:800;color:#fff}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.4);margin-top:1px}
.sb-nav{padding:14px 10px;flex:1}
.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.25);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.55);font-size:.8rem;font-weight:500;transition:.15s;margin-bottom:2px;text-decoration:none;cursor:pointer}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left:3px solid var(--yellow)}
.nav-item i{width:16px;text-align:center}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer .user-name{font-size:.75rem;font-weight:600;color:rgba(255,255,255,.7)}
.sb-footer .user-role{font-size:.62rem;color:rgba(255,255,255,.3);margin-top:2px}

/* MAIN */
.main{margin-left:230px;flex:1;display:flex;flex-direction:column}
.topbar{background:#fff;border-bottom:1px solid #e5e7eb;padding:13px 26px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.topbar-left h2{font-size:.95rem;font-weight:800;color:var(--s9)}
.topbar-left p{font-size:.72rem;color:var(--s5);margin-top:1px}
.topbar-right{display:flex;align-items:center;gap:10px}
.topbar-badge{background:var(--yellow-light);border:1px solid var(--yellow);color:var(--blue-dark);font-size:.7rem;font-weight:700;padding:4px 10px;border-radius:20px}

/* CONTENT */
.content{padding:26px}
.welcome{
  background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 60%,#0a3d2e 100%);
  border-radius:16px;padding:24px 28px;margin-bottom:22px;
  display:flex;align-items:center;justify-content:space-between;
  box-shadow:0 4px 20px rgba(0,51,153,0.2);
}
.welcome-text h3{font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:6px}
.welcome-text p{font-size:.82rem;color:rgba(255,255,255,.6);line-height:1.5}
.welcome-icon{font-size:2.5rem;opacity:0.4}

/* STATS */
.stat-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
.sc{background:#fff;border-radius:14px;padding:18px 20px;box-shadow:0 1px 6px rgba(0,0,0,.06);border:1px solid rgba(0,0,0,.04);transition:.2s}
.sc:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,51,153,.1)}
.sc .lbl{font-size:.68rem;font-weight:700;color:var(--s5);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px}
.sc .val{font-size:1.8rem;font-weight:800;color:var(--s9)}
.sc .sub{font-size:.7rem;color:var(--s5);margin-top:4px}
.sc .ico{font-size:1.4rem;margin-bottom:8px}
.sc-yellow .ico{color:var(--yellow)}
.sc-yellow .val{color:var(--blue)}
.sc-blue .ico{color:var(--blue)}
.sc-blue .val{color:var(--blue)}

/* QUICK CARDS */
.quick{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
.qc{background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 6px rgba(0,0,0,.06);text-decoration:none;display:flex;align-items:center;gap:16px;transition:.2s;border:1.5px solid transparent}
.qc:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,51,153,.1)}
.qc-ico{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.qc-ico-blue{background:#eef2ff;color:var(--blue)}
.qc-ico-yellow{background:var(--yellow-light);color:#92700a}
.qc h4{font-size:.85rem;font-weight:700;color:var(--s9)}
.qc p{font-size:.72rem;color:var(--s5);margin-top:3px}
</style>
</head>
<body>

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
    <a href="{{ route('dashboard') }}" class="nav-item active">
      <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('phbs.index') }}" class="nav-item">
      <i class="fa-solid fa-chart-bar"></i> Laporan PHBS
    </a>
    <a href="{{ route('phbs.form') }}" class="nav-item">
      <i class="fa-solid fa-plus"></i> Input Laporan
    </a>
    <div class="nav-section">Akun</div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;background:none;border:none;text-align:left">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </nav>
  <div class="sb-footer">
    <div class="user-name">{{ auth()->user()->nama_user ?? 'User' }}</div>
    <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'dinkes') }} • SIP-PHBS</div>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <h2><i class="fa-solid fa-house" style="color:var(--blue);margin-right:7px"></i>Dashboard</h2>
      <p>Selamat datang, {{ auth()->user()->nama_user ?? 'Admin' }} • {{ date('l, d F Y') }}</p>
    </div>
    <div class="topbar-right">
      <div class="topbar-badge"><i class="fa-solid fa-circle" style="font-size:7px;margin-right:5px;color:#16a34a"></i>Online</div>
    </div>
  </div>

  <div class="content">
    <div class="welcome">
      <div class="welcome-text">
        <h3>👋 Selamat Datang di SIP-PHBS!</h3>
        <p>Sistem Informasi Pelaporan PHBS Tatanan Rumah Tangga</p>
      </div>
      <div class="welcome-icon">🏥</div>
    </div>

    <div class="stat-row">
      <div class="sc sc-blue">
        <div class="ico"><i class="fa-solid fa-hospital"></i></div>
        <div class="lbl">Total Puskesmas</div>
        <div class="val">{{ $stats['total_puskesmas'] }}</div>
        <div class="sub">Terdaftar di sistem</div>
      </div>
      <div class="sc sc-blue">
        <div class="ico"><i class="fa-solid fa-clipboard-list"></i></div>
        <div class="lbl">Laporan Tahun Ini</div>
        <div class="val">{{ $stats['total_laporan'] }}</div>
        <div class="sub">{{ date('Y') }}</div>
      </div>
      <div class="sc sc-yellow">
        <div class="ico"><i class="fa-solid fa-house"></i></div>
        <div class="lbl">Total KK Dipantau</div>
        <div class="val">{{ number_format($stats['total_kk']) }}</div>
        <div class="sub">Kepala Keluarga</div>
      </div>
      <div class="sc sc-yellow">
        <div class="ico"><i class="fa-solid fa-chart-pie"></i></div>
        <div class="lbl">Rata-rata PHBS</div>
        <div class="val">{{ $stats['rata_phbs'] }}%</div>
        <div class="sub">Keseluruhan data</div>
      </div>
    </div>

    <div class="quick">
      <a href="{{ route('phbs.index') }}" class="qc">
        <div class="qc-ico qc-ico-blue"><i class="fa-solid fa-chart-bar"></i></div>
        <div>
          <h4>Lihat Laporan PHBS</h4>
          <p>Rekap data seluruh puskesmas</p>
        </div>
      </a>
      <a href="{{ route('phbs.form') }}" class="qc">
        <div class="qc-ico qc-ico-yellow"><i class="fa-solid fa-plus"></i></div>
        <div>
          <h4>Input Laporan Baru</h4>
          <p>Tambah data laporan bulanan</p>
        </div>
      </a>
    </div>
  </div>
</div>

</body>
</html>