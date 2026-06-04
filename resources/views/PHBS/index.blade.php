<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan PHBS – SIP-PHBS</title>
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
  --red:#ef4444;
  --amber:#f59e0b;
  --fm:'Segoe UI',sans-serif;
  --mono:'Courier New',monospace;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--fm);background:var(--bg);min-height:100vh;display:flex}

/* SIDEBAR */
.sidebar{width:230px;flex-shrink:0;background:linear-gradient(180deg,#0a1628 0%,#0d2137 60%,#0a3d2e 100%);position:fixed;top:0;left:0;height:100vh;display:flex;flex-direction:column;z-index:100}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sb-logo-row{display:flex;align-items:center;gap:10px}
.sb-icon{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));display:flex;align-items:center;justify-content:center;color:var(--yellow);font-size:16px}
.sb-logo h1{font-size:.85rem;font-weight:800;color:#fff;line-height:1.2}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.45);margin-top:1px}
.sb-nav{padding:14px 10px;flex:1;overflow-y:auto}
.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.25);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.55);font-size:.8rem;font-weight:500;transition:.15s;margin-bottom:2px;text-decoration:none;cursor:pointer}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left:3px solid var(--yellow)}
.nav-item i{width:16px;text-align:center;font-size:.8rem}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer .user-name{font-size:.75rem;font-weight:600;color:rgba(255,255,255,.7)}
.sb-footer .user-role{font-size:.62rem;color:rgba(255,255,255,.3);margin-top:2px}

/* MAIN */
.main{margin-left:230px;flex:1;display:flex;flex-direction:column}
.topbar{background:#fff;border-bottom:1px solid #e5e7eb;padding:13px 26px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.tb-left h2{font-size:.95rem;font-weight:800;color:var(--s9)}
.tb-left p{font-size:.72rem;color:var(--s5);margin-top:1px}
.tb-right{display:flex;gap:9px;align-items:center}
.btn{display:inline-flex;align-items:center;gap:7px;padding:8px 15px;border-radius:9px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:var(--fm);transition:.15s;text-decoration:none}
.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue-dark)}
.btn-export{background:var(--yellow);color:var(--blue-dark)}.btn-export:hover{opacity:.9}
.btn-outline{background:#fff;color:var(--s7);border:1.5px solid var(--s3)}.btn-outline:hover{border-color:var(--blue)}
.btn-sm-edit{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:6px;font-size:.7rem;font-weight:600;background:var(--blue);color:#fff;text-decoration:none}
.btn-sm-del{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:6px;font-size:.7rem;font-weight:600;background:var(--red);color:#fff;border:none;cursor:pointer;font-family:var(--fm)}

.content{padding:22px 26px;flex:1}

/* ALERT */
.alert{padding:11px 15px;border-radius:9px;font-size:.8rem;font-weight:500;margin-bottom:18px;display:flex;align-items:center;gap:9px}
.alert-ok{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.alert-err{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

/* STAT CARDS */
.stat-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.sc{background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 6px rgba(0,0,0,.06);border:1px solid rgba(0,0,0,.04);transition:.2s}
.sc:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,51,153,.1)}
.sc .sc-top{display:flex;align-items:flex-start;justify-content:space-between}
.sc .sc-ico{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem}
.sc-ico-blue{background:#eef2ff;color:var(--blue)}
.sc-ico-yellow{background:var(--yellow-light);color:#92700a}
.sc .lbl{font-size:.68rem;font-weight:700;color:var(--s5);text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px}
.sc .val{font-size:1.65rem;font-weight:800;color:var(--s9);line-height:1}
.sc .sub{font-size:.68rem;color:var(--s5);margin-top:4px}
.pbar{height:5px;background:var(--s1);border-radius:99px;margin-top:8px;overflow:hidden}
.pbar-fill{height:100%;border-radius:99px}

/* FILTER */
.filter-card{background:#fff;border-radius:14px;padding:16px 20px;box-shadow:0 1px 4px rgba(0,0,0,.06);margin-bottom:18px}
.filter-card form{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap}
.fg{display:flex;flex-direction:column;gap:4px}
.fg label{font-size:.68rem;font-weight:700;color:var(--s5);text-transform:uppercase;letter-spacing:.04em}
.fg select{padding:7px 11px;border-radius:8px;border:1.5px solid var(--s3);font-size:.8rem;font-family:var(--fm);color:var(--s9);min-width:130px;background:#fff}
.fg select:focus{outline:none;border-color:var(--blue)}

/* TABLE */
.table-card{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden}
.table-head{padding:14px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--s1)}
.table-head h3{font-size:.85rem;font-weight:700;color:var(--s9)}
.count-badge{font-size:.72rem;color:var(--s5);background:var(--s1);padding:3px 10px;border-radius:99px}
.tw{overflow-x:auto}
table{width:100%;border-collapse:collapse}
thead th{background:linear-gradient(135deg,var(--blue-dark),var(--blue));color:rgba(255,255,255,.9);font-size:.65rem;font-weight:600;letter-spacing:.04em;padding:10px 13px;text-align:left;white-space:nowrap;text-transform:uppercase}
tbody tr{border-bottom:1px solid var(--s1);transition:.1s}
tbody tr:hover{background:#f8faff}
tbody tr:last-child{border-bottom:none}
tbody td{padding:10px 13px;font-size:.78rem;vertical-align:middle}
.td-pkm{font-weight:700;color:var(--blue)}
.td-num{font-family:var(--mono);text-align:right;font-size:.75rem}
.badge{display:inline-flex;align-items:center;padding:2px 9px;border-radius:99px;font-size:.67rem;font-weight:700}
.b-baik{background:#dcfce7;color:#166534}
.b-cukup{background:#fef3c7;color:#92400e}
.b-kurang{background:#fee2e2;color:#991b1b}
.b-draft{background:var(--s1);color:var(--s5)}
.b-kirim{background:#eef2ff;color:var(--blue)}
.acts{display:flex;gap:5px}
.empty td{text-align:center;padding:40px;color:var(--s5)}
</style>
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
    @can('akses-dinkes')
    <a href="{{ route('phbs.dashboard') }}" class="nav-item">
      <i class="fa-solid fa-chart-bar"></i> Ringkasan PHBS
    </a>
    <a href="{{ route('phbs.index') }}" class="nav-item active">
      <i class="fa-solid fa-chart-bar"></i> Laporan PHBS
    </a>
    <a href="{{ route('phbs.form') }}" class="nav-item">
      <i class="fa-solid fa-plus"></i> Input Laporan
    </a>
    @endcan
    <div class="nav-section">Akun</div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </nav>
  <div class="sb-footer">
    <div class="user-name">{{ auth()->user()->nama_user ?? 'User' }}</div>
    <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'dinkes') }} • SIP-PHBS</div>
  </div>
</aside>

{{-- MAIN --}}
<div class="main">
  <div class="topbar">
    <div class="tb-left">
      <h2><i class="fa-solid fa-chart-bar" style="color:var(--blue);margin-right:7px"></i>Laporan Rekapitulasi PHBS</h2>
      <p>Tatanan Rumah Tangga • Tahun {{ $tahun }}</p>
    </div>
    <div class="tb-right">
      <a href="{{ route('phbs.export', request()->query()) }}" class="btn btn-export">
        <i class="fa-solid fa-file-excel"></i> Export Excel
      </a>
      {{-- <a href="{{ route('phbs.form') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Input Laporan
      </a> --}}
    </div>
  </div>

  <div class="content">

    {{-- ALERT --}}
    @if(session('success'))
      <div class="alert alert-ok"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
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
        <div class="pbar"><div class="pbar-fill" style="width:{{ $rata }}%;background:{{ $barColor }}"></div></div>
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
              <option value="{{ $pkm->id_puskesmas }}" {{ $pkmId==$pkm->id_puskesmas?'selected':'' }}>
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
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($laporan as $i=>$row)
            @php
              $pct = $row->persen_phbs;
              $pc  = $pct>=80?'#166534':($pct>=60?'#92400e':'#991b1b');
              $bk  = $pct>=80?'b-baik':($pct>=60?'b-cukup':'b-kurang');
              $kt  = $pct>=80?'Baik':($pct>=60?'Cukup':'Kurang');
            @endphp
            <tr>
              <td style="color:var(--s5);font-size:.7rem">{{ $i+1 }}</td>
              <td class="td-pkm">{{ $row->nama_puskesmas }}</td>
              <td style="font-size:.73rem;color:var(--s5)">{{ $namaBulan[$row->bulan]??'-' }}</td>
              <td style="font-size:.73rem;color:var(--s5)">{{ $row->tahun }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_l) }}</td>
              <td class="td-num">{{ number_format($row->jumlah_kk_p) }}</td>
              <td class="td-num"><strong>{{ number_format($row->jumlah_kk_total) }}</strong></td>
              <td class="td-num">{{ number_format($row->ber_phbs) }}</td>
              <td class="td-num"><strong style="color:{{ $pc }}">{{ number_format($pct,1) }}%</strong></td>
              <td><span class="badge {{ $bk }}">{{ $kt }}</span></td>
              <td>
                <span class="badge {{ $row->status_laporan=='terkirim'?'b-kirim':'b-draft' }}">
                  {{ $row->status_laporan=='terkirim'?'Terkirim':'Draft' }}
                </span>
              </td>
              <td>
                <div class="acts">
                  <a href="{{ route('phbs.edit',$row->id_data) }}" class="btn-sm-edit">
                    <i class="fa-solid fa-pen"></i> Edit
                  </a>
                  <form method="POST" action="{{ route('phbs.destroy',$row->id_data) }}"
                        onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm-del">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr class="empty"><td colspan="12">📭 Belum ada data untuk filter ini.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
</body>
</html>