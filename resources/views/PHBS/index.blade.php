<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PHBS – SIP-PHBS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <link rel="stylesheet" href="{{ asset('css/laporanphbs.css') }}">
</head>
<body>
{{-- SIDEBAR --}}
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
    <a href="{{ route('phbs.index') }}" class="nav-item active">
      <i class="fa-solid fa-chart-bar"></i> Laporan PHBS
    </a>
    <a href="{{ route('phbs.form') }}" class="nav-item">
      <i class="fa-solid fa-plus"></i> Input Laporan
    </a>
    <div class="nav-section">Akun</div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item"
        style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </nav>
  <div class="sb-footer">
    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
    <div class="user-role">{{ ucfirst(auth()->user()->role->role ?? 'dinkes') }} • SIP-PHBS</div>
  </div>
</aside>

{{-- MAIN --}}
<div class="main">
  <div class="topbar">
    <div class="tb-left">
      <h2>
        <i class="fa-solid fa-chart-bar" style="color:var(--blue);margin-right:7px"></i>
        Laporan Rekapitulasi PHBS
      </h2>
      <p>Tatanan Rumah Tangga • Tahun {{ $tahun }}</p>
    </div>
    <div class="tb-right">
      <a href="{{ route('phbs.export', request()->query()) }}" class="btn btn-export">
        <i class="fa-solid fa-file-excel"></i> Export Excel
      </a>
      <a href="{{ route('phbs.form') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Input Laporan
      </a>
    </div>
  </div>

  <div class="content">

    {{-- ALERT --}}
    @if(session('success'))
      <div class="alert alert-ok">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
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
        <div class="pbar">
          <div class="pbar-fill" style="width:{{ $rata }}%;background:{{ $barColor }}"></div>
        </div>
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
              <option value="{{ $pkm->id_puskesmas }}"
                {{ $pkmId==$pkm->id_puskesmas?'selected':'' }}>
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
            </tr>
          </thead>
          <tbody>
            @forelse($laporan as $i => $row)
            @php
              $pct = $row->persen_phbs;
              $pc  = $pct >= 80 ? '#166534' : ($pct >= 60 ? '#92400e' : '#991b1b');
              $bk  = $pct >= 80 ? 'b-baik'  : ($pct >= 60 ? 'b-cukup'  : 'b-kurang');
              $kt  = $pct >= 80 ? 'Baik'    : ($pct >= 60 ? 'Cukup'    : 'Kurang');
            @endphp
            <tr>
              <td style="color:var(--s5);font-size:.7rem">{{ $i + 1 }}</td>
              <td class="td-pkm">{{ $row->puskesmas->nama_puskesmas ?? '-' }}</td>
              <td style="font-size:.73rem;color:var(--s5)">
                {{ $namaBulan[$row->bulan] ?? '-' }}
              </td>
              <td style="font-size:.73rem;color:var(--s5)">{{ $row->tahun }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_lk) }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_pr) }}</td>
              <td class="td-num">
                <strong>{{ number_format($row->jumlah_kk_total) }}</strong>
              </td>
              <td class="td-num">{{ number_format($row->ber_phbs) }}</td>
              <td class="td-num">
                <strong style="color:{{ $pc }}">{{ number_format($pct, 1) }}%</strong>
              </td>
              <td><span class="badge {{ $bk }}">{{ $kt }}</span></td>
            </tr>
            @empty
            <tr class="empty">
              <td colspan="10">📭 Belum ada data untuk filter ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

</body>
</html>