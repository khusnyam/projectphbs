<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan PHBS – SIP-PHBS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
  <div class="sb-brand">
    <div class="sb-logo">
      <i class="fa-solid fa-heart-pulse"></i>
    </div>
    <div class="sb-name">
      <strong>SIP-PHBS</strong>
      <span>Sistem Informasi Pelaporan PHBS</span>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="sb-section">
      <span class="sb-label">Menu Utama</span>
      <a href="{{ route('beranda') }}" class="sb-item">
        <i class="fa-solid fa-house"></i> Beranda
      </a>
      <a href="{{ route('phbs.dashboard') }}" class="sb-item">
        <i class="fa-solid fa-chart-line"></i> Dashboard
      </a>
      <a href="{{ route('phbs.index') }}" class="sb-item active">
        <i class="fa-solid fa-table-list"></i> Laporan PHBS
      </a>
      <a href="{{ route('peta.index') }}" class="sb-item">
        <i class="fa-solid fa-map-location-dot"></i> Peta PHBS
      </a>
    </div>
    <div class="sb-section">
      <span class="sb-label">Akun</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sb-item">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
      </form>
    </div>
  </nav>
  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
      </div>
      <div class="sb-user-info">
        <strong>{{ auth()->user()->name ?? 'User' }}</strong>
        <span>{{ ucfirst(auth()->user()->role->role ?? 'dinkes') }}</span>
      </div>
    </div>
  </div>
</aside>

{{-- MAIN --}}
<div class="main">

  {{-- HERO --}}
  <div class="hero">
    <div class="hero-left">
      <div class="hero-title">
        <i class="fa-solid fa-table-list"></i>
        Laporan Rekapitulasi PHBS
      </div>
      <div class="hero-desc">
        Tatanan Rumah Tangga • Tahun {{ $tahun }}
      </div>
      <div class="hero-badges">
        <span class="hero-badge">
          <i class="fa-solid fa-calendar"></i> Tahun {{ $tahun }}
        </span>
        <span class="hero-badge">
          <i class="fa-solid fa-file-lines"></i> {{ $stats['total_laporan'] }} Laporan
        </span>
        @if($role === 'dinkes')
        <a href="{{ route('phbs.export', request()->query()) }}"
           class="btn btn-export" style="padding:5px 14px;font-size:12px">
          <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
        @endif
      </div>
    </div>
    <div class="hero-right">
      <div class="rata-card">
        <div class="rata-label">Rata-rata PHBS</div>
        @php
          $rata     = $stats['rata_phbs'] ?? 0;
          $barColor = $rata >= 80 ? '#22c55e' : ($rata >= 60 ? '#f59e0b' : '#ef4444');
          $katTxt   = $rata >= 80 ? 'Kategori Baik' : ($rata >= 60 ? 'Kategori Cukup' : 'Kategori Kurang');
        @endphp
        <div class="rata-value">{{ $rata }}%</div>
        <div class="rata-bar">
          <div class="rata-fill" style="width:{{ $rata }}%;background:{{ $barColor }}"></div>
        </div>
        <div class="rata-sub">{{ $katTxt }}</div>
      </div>
    </div>
  </div>

  <div class="content">

    {{-- ALERT --}}
    @if(session('success'))
      <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
      </div>
    @endif

    {{-- STAT GRID --}}
    <div class="stat-grid">
      <div class="stat-card green">
        <div class="stat-label">Total Laporan</div>
        <div class="stat-value">{{ $stats['total_laporan'] }}</div>
        <div class="stat-sub">Periode ditampilkan</div>
      </div>
      <div class="stat-card teal">
        <div class="stat-label">Total KK Dipantau</div>
        <div class="stat-value">{{ number_format($stats['total_kk']) }}</div>
        <div class="stat-sub">Kepala Keluarga</div>
      </div>
      <div class="stat-card amber">
        <div class="stat-label">KK Ber-PHBS</div>
        <div class="stat-value">{{ number_format($stats['total_ber_phbs']) }}</div>
        <div class="stat-sub">Memenuhi indikator</div>
      </div>
      <div class="stat-card primary">
        <div class="stat-label">Rata-rata % PHBS</div>
        <div class="stat-value" style="color:{{ $barColor }}">{{ $rata }}%</div>
        <div class="pbar">
          <div class="pbar-fill" style="width:{{ $rata }}%;background:{{ $barColor }}"></div>
        </div>
        <div class="stat-sub">{{ $katTxt }}</div>
      </div>
    </div>

    {{-- FILTER --}}
    <div class="filter-section">
      <div class="filter-title">
        <i class="fa-solid fa-filter"></i> Filter Data
      </div>
      <div class="filter-desc">Pilih tahun, bulan, puskesmas, atau kategori untuk menampilkan data.</div>
      <form method="GET" action="{{ route('phbs.index') }}">
        <div class="filter-row">
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
          @if($role === 'dinkes')
          <div class="fg">
            <label>Puskesmas</label>
            <select name="puskesmas_id" style="min-width:200px">
              <option value="0">Semua Puskesmas</option>
              @foreach($puskesmasList as $pkm)
                <option value="{{ $pkm->id_puskesmas }}"
                  {{ $pkmId==$pkm->id_puskesmas?'selected':'' }}>
                  {{ $pkm->nama_puskesmas }}
                </option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="fg">
            <label>Kategori</label>
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
        </div>
      </form>
    </div>

    {{-- TABEL --}}
    <div class="table-card">
      <div class="table-head">
        <div class="card-title">
          <i class="fa-solid fa-table" style="color:var(--primary);margin-right:6px"></i>
          Data Laporan PHBS
        </div>
        <span class="count-badge">{{ $laporan->count() }} data</span>
      </div>
      <div class="table-wrap">
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
              @if($role === 'dinkes')
              <th>Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @forelse($laporan as $i => $row)
            @php
              $pct = $row->persen_phbs;
              $pc  = $pct >= 80 ? '#15803d' : ($pct >= 60 ? '#a16207' : '#c2410c');
              $bk  = $pct >= 80 ? 'b-baik'  : ($pct >= 60 ? 'b-cukup'  : 'b-kurang');
              $kt  = $pct >= 80 ? 'Baik'    : ($pct >= 60 ? 'Cukup'    : 'Kurang');
            @endphp
            <tr>
              <td style="color:var(--text-muted);font-size:12px">{{ $i + 1 }}</td>
              <td class="td-pkm">{{ $row->puskesmas->nama_puskesmas ?? '-' }}</td>
              <td style="color:var(--text-muted);font-size:12px">{{ $namaBulan[$row->bulan] ?? '-' }}</td>
              <td style="color:var(--text-muted);font-size:12px">{{ $row->tahun }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_lk) }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_pr) }}</td>
              <td class="td-num"><strong>{{ number_format($row->jumlah_kk_total) }}</strong></td>
              <td class="td-num">{{ number_format($row->ber_phbs) }}</td>
              <td>
                <div class="prog-wrap">
                  <div class="prog-bar">
                    <div class="prog-fill" style="width:{{ $pct }}%;background:{{ $pc }}"></div>
                  </div>
                  <span class="prog-pct" style="color:{{ $pc }}">{{ $pct }}%</span>
                </div>
              </td>
              <td><span class="badge {{ $bk }}">{{ $kt }}</span></td>
              @if($role === 'dinkes')
              <td>
                <div class="acts">
                  <a href="{{ route('laporan.edit', $row->id_phbs) }}" class="btn-sm-edit">
                    <i class="fa-solid fa-pen"></i>
                  </a>
                  <form method="POST" action="{{ route('laporan.destroy', $row->id_phbs) }}"
                    onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm-del">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
              @endif
            </tr>
            @empty
            <tr>
              <td colspan="{{ $role === 'dinkes' ? 11 : 10 }}" class="empty">
                <i class="fa-solid fa-inbox" style="font-size:2rem;opacity:.3;display:block;margin-bottom:8px"></i>
                Belum ada data untuk filter ini.
              </td>
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