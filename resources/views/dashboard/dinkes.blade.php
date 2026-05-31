<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard PHBS - SIP-PHBS</title>
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

/* SIDEBAR */
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
.sb-logo h1{font-size:.85rem;font-weight:800;color:#fff}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.45);margin-top:1px;line-height:1.35}
.sb-nav{padding:14px 10px;flex:1;overflow:auto}
.nav-section{font-size:.58rem;font-weight:800;letter-spacing:.1em;color:rgba(255,255,255,.28);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{
  display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;
  color:rgba(255,255,255,.58);font-size:.8rem;font-weight:600;transition:.15s;margin-bottom:2px;
}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left:3px solid var(--yellow)}
.nav-item i{width:16px;text-align:center}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer .user-name{font-size:.75rem;font-weight:700;color:rgba(255,255,255,.82)}
.sb-footer .user-role{font-size:.62rem;color:rgba(255,255,255,.42);margin-top:2px}

/* MAIN */
.main{margin-left:230px;flex:1;min-width:0}
.content{padding:26px;display:flex;flex-direction:column;gap:18px}
.card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);border:1px solid rgba(15,23,42,.05)}
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:9px;
  padding:9px 13px;font-size:.78rem;font-weight:800;cursor:pointer;font-family:'Segoe UI',sans-serif;
}
.btn-primary{background:var(--blue);color:#fff}
.btn-primary:hover{background:var(--blue-dark)}
.btn-outline{background:#fff;color:#1e3a5f;border:1.5px solid #cbd5e1}
.btn-outline:hover{border-color:var(--blue);color:var(--blue)}
.count-badge{background:#f1f5f9;color:#64748b;font-size:.7rem;font-weight:800;padding:5px 10px;border-radius:999px;white-space:nowrap}

/* 1. HEADER DASHBOARD */
.header-card{
  background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 58%,#0a3d2e 100%);
  color:#fff;border-radius:16px;padding:24px 28px;box-shadow:0 4px 20px rgba(0,51,153,.18);
  display:grid;grid-template-columns:1.45fr .75fr;gap:22px;align-items:center;
}
.header-card h1{font-size:1.35rem;font-weight:900;margin-bottom:8px;letter-spacing:.2px}
.header-card p{font-size:.84rem;color:rgba(255,255,255,.75);line-height:1.55;max-width:820px}
.header-tags{display:flex;flex-wrap:wrap;gap:8px;margin-top:14px}
.header-tag{
  display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.13);
  font-size:.69rem;font-weight:800;padding:6px 10px;border-radius:999px;color:rgba(255,255,255,.92);
}
.header-score{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);border-radius:13px;padding:16px}
.header-score .label{font-size:.64rem;font-weight:900;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.68)}
.header-score .value{font-size:2.05rem;font-weight:900;margin:5px 0;color:#fff}
.progress{height:6px;background:rgba(255,255,255,.24);border-radius:999px;overflow:hidden}
.progress span{display:block;height:100%;border-radius:999px;background:var(--yellow)}

/* 2. FILTER DASHBOARD */
.filter-card{padding:17px 20px}
.section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:14px}
.section-head h3{font-size:.95rem;font-weight:900;color:var(--text);display:flex;align-items:center;gap:8px}
.section-head h3 i{color:var(--blue)}
.section-head p{font-size:.72rem;color:var(--muted);margin-top:3px;line-height:1.45}
.filter-form{display:grid;grid-template-columns:1fr 1fr 1.65fr auto auto;gap:10px;align-items:end}
.fg label{display:block;font-size:.66rem;font-weight:900;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px}
.fg select{
  width:100%;height:41px;border-radius:8px;border:1.5px solid #cbd5e1;background:#fff;
  padding:0 11px;font-size:.8rem;color:var(--text);font-family:'Segoe UI',sans-serif;
}
.fg select:focus{outline:none;border-color:var(--blue)}

/* 3. QUICK INSIGHT */
.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.quick{padding:16px 18px;display:flex;align-items:center;gap:13px;min-height:96px}
.qico{width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0}
.qico.good{background:#dcfce7;color:#166534}
.qico.bad{background:#fee2e2;color:#991b1b}
.qico.warn{background:#fef3c7;color:#92400e}
.quick .label{font-size:.65rem;font-weight:900;color:var(--muted);text-transform:uppercase;letter-spacing:.08em}
.quick .value{font-size:.98rem;font-weight:900;color:var(--text);margin-top:4px;line-height:1.25}
.quick .sub{font-size:.7rem;color:var(--muted);margin-top:4px;line-height:1.35}

/* 4. MATRIKS */
.matrix-card{padding:17px 18px}
.matrix-wrap{overflow:auto;border:1px solid var(--line);border-radius:12px;max-height:470px;background:#fff}
.matrix{width:100%;border-collapse:separate;border-spacing:0;min-width:1260px}
.matrix th{
  position:sticky;top:0;background:linear-gradient(135deg,var(--blue-dark),var(--blue));
  color:#fff;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;
  padding:10px 9px;text-align:center;z-index:2;white-space:nowrap;
}
.matrix th:first-child{left:0;z-index:3;text-align:left}
.matrix td{padding:9px;border-bottom:1px solid #f1f5f9;font-size:.72rem;text-align:center;background:#fff;white-space:nowrap}
.matrix td:first-child{position:sticky;left:0;z-index:1;text-align:left;background:#fff;min-width:235px;font-weight:900;color:var(--blue)}
.matrix tr:hover td{background:#f8faff}
.matrix tr:hover td:first-child{background:#f8faff}
.pkm-small{display:block;color:var(--muted);font-weight:600;font-size:.65rem;margin-top:2px}
.cell{display:inline-flex;min-width:49px;justify-content:center;padding:4px 8px;border-radius:999px;font-size:.67rem;font-weight:900}
.cell.good{background:#dcfce7;color:#166534}
.cell.mid{background:#fef3c7;color:#92400e}
.cell.low{background:#fee2e2;color:#991b1b}
.cell.empty{background:#f1f5f9;color:#64748b}
.legend{display:flex;flex-wrap:wrap;gap:8px;margin-top:11px}
.legend span{font-size:.68rem;font-weight:900;padding:5px 9px;border-radius:999px}
.legend .good{background:#dcfce7;color:#166534}
.legend .mid{background:#fef3c7;color:#92400e}
.legend .low{background:#fee2e2;color:#991b1b}
.legend .empty{background:#f1f5f9;color:#64748b}
.empty-state{text-align:center;padding:36px;color:var(--muted)}
.empty-state i{font-size:1.4rem;color:#cbd5e1;display:block;margin-bottom:8px}

/* 5. RINGKASAN 13 INDIKATOR */
.indicator-card{padding:17px 18px}
.indicator-grid{display:grid;grid-template-columns:repeat(13,minmax(158px,1fr));gap:10px;overflow:auto;padding-bottom:4px}
.ind-card{border:1px solid var(--line);border-radius:12px;background:#fff;padding:12px}
.ind-num{
  width:28px;height:28px;border-radius:8px;background:#eef2ff;color:var(--blue);
  font-size:.72rem;font-weight:900;display:flex;align-items:center;justify-content:center;margin-bottom:8px;
}
.ind-title{font-size:.72rem;line-height:1.34;font-weight:900;color:var(--text);min-height:39px}
.ind-pct{font-size:1.35rem;font-weight:900;margin:7px 0 2px}
.ind-meta{font-size:.65rem;color:var(--muted)}
.mini-track{height:6px;background:#f1f5f9;border-radius:999px;overflow:hidden;margin-top:8px}
.mini-fill{height:100%;border-radius:999px}
.footer-note{
  font-size:.72rem;color:var(--muted);line-height:1.55;background:#f8fafc;border:1px dashed #cbd5e1;
  border-radius:10px;padding:10px 12px;margin-top:12px;
}

@media(max-width:1100px){
  .header-card{grid-template-columns:1fr}
  .quick-grid{grid-template-columns:1fr}
  .filter-form{grid-template-columns:1fr 1fr}
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
  })->values();

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
@endphp

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
    <a href="{{ route('dashboard') }}" class="nav-item">
      <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('dashboard.dinkes') }}" class="nav-item active">
      <i class="fa-solid fa-chart-line"></i> Dashboard PHBS
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
    <div class="user-name">{{ auth()->user()->nama_user ?? 'Admin Dinkes' }}</div>
    <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'dinkes') }} • SIP-PHBS</div>
  </div>
</aside>

<main class="main">
  <div class="content">

    <!-- 1. HEADER DASHBOARD -->
    <section class="header-card">
      <div>
        <h1><i class="fa-solid fa-chart-line"></i> Dashboard PHBS</h1>
        <p>
          Pemantauan capaian 13 indikator PHBS berdasarkan laporan puskesmas pada periode terpilih.
        </p>
        <div class="header-tags">
          <span class="header-tag"><i class="fa-solid fa-calendar-days"></i> {{ $periodeBulan }} {{ $tahun }}</span>
          <span class="header-tag"><i class="fa-solid fa-hospital"></i> {{ $selectedPuskesmasName }}</span>
          <span class="header-tag"><i class="fa-solid fa-table-cells-large"></i> 13 Indikator PHBS</span>
        </div>
      </div>

      <div class="header-score">
        <div class="label">Rata-rata PHBS periode ini</div>
        <div class="value">{{ number_format($rataPhbs,1) }}%</div>
        <div class="progress"><span style="width:{{ min($rataPhbs,100) }}%"></span></div>
        <p style="font-size:.7rem;color:rgba(255,255,255,.75);margin-top:8px">
          {{ $laporan->count() }} laporan terpantau
        </p>
      </div>
    </section>

    <!-- 2. FILTER DASHBOARD -->
    <section class="card filter-card">
      <div class="section-head">
        <div>
          <h3><i class="fa-solid fa-sliders"></i> Filter Dashboard</h3>
          <p>Pilih tahun, bulan, atau puskesmas untuk menampilkan data sesuai kebutuhan.</p>
        </div>
      </div>

      <form method="GET" action="{{ route('dashboard.dinkes') }}" class="filter-form">
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

        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-magnifying-glass-chart"></i> Terapkan
        </button>
        <a href="{{ route('dashboard.dinkes') }}" class="btn btn-outline">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </a>
      </form>
    </section>

    <!-- 3. PUSKESMAS TERBAIK, PERLU PERHATIAN, STATUS LAPORAN -->
    <section class="quick-grid">
      <div class="card quick">
        <div class="qico good"><i class="fa-solid fa-trophy"></i></div>
        <div>
          <div class="label">Puskesmas Terbaik</div>
          <div class="value">{{ $topPuskesmas['nama_puskesmas'] ?? 'Belum ada data' }}</div>
          <div class="sub">
            @if($topPuskesmas)
              Capaian PHBS tertinggi pada periode terpilih.
            @else
              Belum ada laporan pada periode ini
            @endif
          </div>
        </div>
      </div>

      <div class="card quick">
        <div class="qico bad"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div>
          <div class="label">Perlu Perhatian</div>
          <div class="value">{{ $lowPuskesmas['nama_puskesmas'] ?? 'Belum ada data' }}</div>
          <div class="sub">
            @if($lowPuskesmas)
              Puskesmas dengan capaian terendah untuk prioritas pemantauan.
            @else
              Belum ada laporan pada periode ini
            @endif
          </div>
        </div>
      </div>

      <div class="card quick">
        <div class="qico warn"><i class="fa-solid fa-paper-plane"></i></div>
        <div>
          <div class="label">Status Laporan</div>
          <div class="value">{{ $statusTerkirim }} terkirim • {{ $statusDraft }} draft</div>
          <div class="sub">Jumlah laporan terkirim dan draft pada periode terpilih.</div>
        </div>
      </div>
    </section>

    <!-- 4. MATRIKS 13 INDIKATOR PHBS PER PUSKESMAS -->
    <section class="card matrix-card">
      <div class="section-head">
        <div>
          <h3><i class="fa-solid fa-table-cells-large"></i> Matriks 13 Indikator PHBS per Puskesmas</h3>
          <p>
            Tabel ini menampilkan persentase capaian setiap indikator PHBS per puskesmas.
          </p>
        </div>
        <span class="count-badge">{{ $puskesmasSummary->count() }} puskesmas</span>
      </div>

      <div class="matrix-wrap">
        <table class="matrix">
          <thead>
            <tr>
              <th>Puskesmas</th>
              <th>Laporan</th>
              <th>Rata-rata</th>
              @foreach($indicatorLabels as $num=>$label)
                <th title="{{ $label }}">I{{ $num }}</th>
              @endforeach
              <th>Indikator Terendah</th>
            </tr>
          </thead>

          <tbody>
            @forelse($puskesmasSummary as $pkm)
              <tr>
                <td>
                  {{ $pkm['nama_puskesmas'] }}
                  <span class="pkm-small">
                    {{ number_format($pkm['total_kk']) }} KK dipantau • {{ number_format($pkm['ber_phbs']) }} ber-PHBS
                  </span>
                </td>
                <td>{{ $pkm['laporan_count'] }}</td>
                <td>
                  <span class="cell {{ $pkm['class'] }}">
                    {{ $pkm['laporan_count'] ? $pkm['rata_phbs'].'%' : '-' }}
                  </span>
                </td>

                @foreach($pkm['indicators'] as $ind)
                  <td title="{{ $ind['label'] }}: {{ number_format($ind['jumlah']) }}/{{ number_format($ind['sasaran']) }}">
                    <span class="cell {{ $ind['class'] }}">
                      {{ $ind['sasaran'] > 0 ? $ind['persen'].'%' : '-' }}
                    </span>
                  </td>
                @endforeach

                <td>
                  @if($pkm['indikator_terendah'])
                    I{{ $pkm['indikator_terendah']['num'] }} • {{ $pkm['indikator_terendah']['persen'] }}%
                  @else
                    -
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="17">
                  <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    Belum ada data puskesmas untuk periode ini.
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="legend">
        <span class="good">Baik ≥80%</span>
        <span class="mid">Cukup 60-79%</span>
        <span class="low">Kurang &lt;60%</span>
        <span class="empty">- belum ada sasaran/data</span>
      </div>
    </section>

    <!-- 5. RINGKASAN 13 INDIKATOR TINGKAT KABUPATEN -->
    <section class="card indicator-card">
      <div class="section-head">
        <div>
          <h3><i class="fa-solid fa-list-check"></i> Ringkasan 13 Indikator Tingkat Kabupaten</h3>
          <p>
            Rangkuman capaian tiap indikator dari seluruh laporan pada periode terpilih.
          </p>
        </div>
        <span class="count-badge">{{ $periodeBulan }} {{ $tahun }}</span>
      </div>

      <div class="indicator-grid">
        @foreach($indicatorSummary as $ind)
          @php
            $color = $ind['class']==='good' ? '#16a34a' : ($ind['class']==='mid' ? '#f59e0b' : ($ind['class']==='low' ? '#ef4444' : '#cbd5e1'));
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
    </section>

  </div>
</main>

</body>
</html>
