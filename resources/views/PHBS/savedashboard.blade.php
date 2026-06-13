<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard PHBS Rumah Tangga — Kabupaten Sleman 2025</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap');

  :root {
    --green:      #003399;
    --green-light:#1a4db3;
    --green-pale: #e6ebf7;
    --teal:       #FFCC00;
    --sky:        #003399;
    --amber:      #d97706;
    --red:        #dc2626;
    --bg:         #f0f4ff;
    --surface:    #ffffff;
    --surface2:   #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --text-muted: #64748b;
    --radius:     14px;
    --shadow:     0 2px 16px rgba(0,0,0,.07);
    --shadow-lg:  0 8px 32px rgba(0,0,0,.12);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
  }

  /* ─── TOP BAR ─── */
  .topbar {
    background: var(--green);
    color: #fff;
    padding: 0 28px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(22,163,74,.4);
  }
  .topbar-left { display: flex; align-items: center; gap: 12px; }
  .topbar-logo {
    width: 34px; height: 34px;
    background: rgba(255,255,255,.2);
    border-radius: 8px;
    display: grid; place-items: center;
    font-size: 18px;
  }
  .topbar-title { font-weight: 700; font-size: 15px; letter-spacing: -.3px; }
  .topbar-sub   { font-size: 11px; opacity: .8; }
  .topbar-right { display: flex; align-items: center; gap: 10px; font-size: 13px; opacity: .9; }
  .topbar-badge {
    background: rgba(255,255,255,.2);
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 600;
  }

  /* ─── LAYOUT ─── */
  .layout { display: flex; min-height: calc(100vh - 58px); }

  /* ─── SIDEBAR ─── */
  .sidebar {
    width: 220px;
    flex-shrink: 0;
    background: var(--surface);
    border-right: 1px solid var(--border);
    padding: 20px 0;
    position: sticky;
    top: 58px;
    height: calc(100vh - 58px);
    overflow-y: auto;
  }
  .sidebar-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--text-muted);
    padding: 6px 18px 4px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    color: var(--text-muted);
    border-left: 3px solid transparent;
  }
  .nav-item:hover { background: var(--green-pale); color: var(--green); }
  .nav-item.active {
    background: var(--green-pale);
    color: var(--green);
    border-left-color: var(--green);
    font-weight: 600;
  }
  .nav-item .icon { font-size: 15px; }
  .nav-divider { height: 1px; background: var(--border); margin: 10px 18px; }

  /* ─── MAIN CONTENT ─── */
  .main { flex: 1; padding: 28px; overflow: hidden; }

  /* ─── PAGE SECTIONS ─── */
  .page { display: none; }
  .page.active { display: block; }

  /* ─── STAT CARDS ─── */
  .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 22px;
    box-shadow: var(--shadow);
    display: flex; flex-direction: column; gap: 6px;
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
  .stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 14px 14px 0 0;
  }
  .stat-card.green::before  { background: var(--green); }
  .stat-card.teal::before   { background: var(--teal); }
  .stat-card.sky::before    { background: var(--sky); }
  .stat-card.amber::before  { background: var(--amber); }
  .stat-icon {
    font-size: 28px;
    position: absolute; right: 18px; top: 18px;
    opacity: .15;
  }
  .stat-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
  .stat-value { font-size: 30px; font-weight: 800; font-family: 'JetBrains Mono', monospace; letter-spacing: -1px; }
  .stat-sub   { font-size: 12px; color: var(--text-muted); }

  /* ─── CHART CARDS ─── */
  .chart-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
  .chart-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 22px;
  }
  .chart-card.wide { grid-column: 1 / -1; }
  .chart-title { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
  .chart-sub   { font-size: 12px; color: var(--text-muted); margin-bottom: 18px; }
  .chart-wrap  { position: relative; }

  /* ─── TABLE ─── */
  .table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .table-header {
    padding: 18px 22px 14px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .table-title { font-size: 14px; font-weight: 700; }
  .table-search {
    padding: 7px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    width: 220px;
    transition: border-color .2s;
  }
  .table-search:focus { border-color: var(--green); }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  thead th {
    background: var(--surface2);
    padding: 11px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    user-select: none;
    white-space: nowrap;
  }
  thead th:hover { background: var(--green-pale); color: var(--green); }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:hover { background: #f8fffe; }
  tbody td { padding: 11px 16px; }
  .rank { font-family: 'JetBrains Mono', monospace; font-weight: 600; font-size: 12px; color: var(--text-muted); }

  /* progress bar */
  .pbar-wrap { display: flex; align-items: center; gap: 10px; }
  .pbar { flex: 1; height: 7px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
  .pbar-fill { height: 100%; border-radius: 4px; transition: width .6s; }
  .pbar-val { font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 600; width: 44px; text-align: right; }

  /* badge */
  .badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
  }
  .badge-green  { background: var(--green-pale); color: var(--green); }
  .badge-amber  { background: #fef3c7; color: var(--amber); }
  .badge-red    { background: #fee2e2; color: var(--red); }

  /* ─── FILTER BAR ─── */
  .filter-bar {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
    margin-bottom: 20px;
  }
  .filter-bar label { font-size: 12px; font-weight: 600; color: var(--text-muted); }
  .filter-bar select, .filter-bar input {
    padding: 7px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    background: var(--surface);
    transition: border-color .2s;
  }
  .filter-bar select:focus, .filter-bar input:focus { border-color: var(--green); }
  .btn-green {
    padding: 7px 18px;
    background: var(--green);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background .15s;
  }
  .btn-green:hover { background: #15803d; }

  /* ─── DETAIL PANEL ─── */
  .detail-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 24px;
    margin-bottom: 24px;
  }
  .detail-name { font-size: 22px; font-weight: 800; margin-bottom: 4px; }
  .detail-meta { font-size: 13px; color: var(--text-muted); margin-bottom: 20px; }

  /* ─── INDICATOR TABLE ─── */
  .ind-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .ind-table th {
    background: var(--surface2);
    padding: 9px 14px;
    text-align: left;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
  }
  .ind-table td { padding: 9px 14px; border-bottom: 1px solid var(--border); }
  .ind-table tr:last-child td { border-bottom: none; }

  /* ─── PAGE HEADER ─── */
  .page-header { margin-bottom: 22px; }
  .page-header h2 { font-size: 22px; font-weight: 800; }
  .page-header p  { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 1100px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
    .chart-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 760px) {
    .sidebar { display: none; }
    .stat-grid { grid-template-columns: 1fr 1fr; }
  }

  /* ─── SECTION TITLE ─── */
  .section-title {
    font-size: 13px; font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 12px;
  }

  /* scrollbar */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
</style>
</head>
<body>

<!-- ════════════════════ MAIN APP ════════════════════ -->
<div id="app">
  <!-- TOP BAR -->
  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-logo">🏥</div>
      <div>
        <div class="topbar-title">Dashboard PHBS Rumah Tangga</div>
        <div class="topbar-sub">Kabupaten Sleman — 2025</div>
      </div>
    </div>
    <div class="topbar-right">
      <span class="topbar-badge" id="topbar-user">admin</span>
      <span class="topbar-badge">25 Puskesmas</span>

    </div>
  </div>

  <div class="layout">
    <!-- SIDEBAR -->
    <nav class="sidebar">
      <div class="sidebar-label">Menu Utama</div>
      <div class="nav-item active" onclick="showPage('dashboard')">
        <span class="icon">📊</span> Dashboard
      </div>
      <div class="nav-item" onclick="showPage('input-data')">
        <span class="icon">📋</span> Input Data
      </div>
      <div class="nav-item" onclick="showPage('tabel-puskesmas')">
        <span class="icon">🏥</span> Data Puskesmas
      </div>
      <div class="nav-item" onclick="showPage('lihat-history')">
        <span class="icon">📅</span> Lihat History
      </div>
      <div class="nav-divider"></div>
      <div class="sidebar-label">Analisis</div>
      <div class="nav-item" onclick="showPage('per-indikator')">
        <span class="icon">📈</span> Per Indikator
      </div>
      <div class="nav-item" onclick="showPage('perbandingan')">
        <span class="icon">⚖️</span> Perbandingan
      </div>
      <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;background:none;border:none;text-align:left">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
      </form>
    </nav>

    <!-- MAIN -->
    <div class="main">

      <!-- ── PAGE: DASHBOARD ── -->
      <div id="page-dashboard" class="page active">
        <div class="page-header">
          <h2>📊 Dashboard Kabupaten</h2>
          <p>Rekapitulasi PHBS Tatanan Rumah Tangga — Sleman 2025</p>
        </div>

        <!-- Stats -->
        <div class="stat-grid">
          <div class="stat-card green">
            <span class="stat-icon">🏠</span>
            <div class="stat-label">Total KK Diperiksa</div>
            <div class="stat-value" id="stat-kk">0</div>
            <div class="stat-sub">seluruh puskesmas</div>
          </div>
          <div class="stat-card teal">
            <span class="stat-icon">✅</span>
            <div class="stat-label">KK Ber-PHBS</div>
            <div class="stat-value" id="stat-phbs">0</div>
            <div class="stat-sub">memenuhi kriteria PHBS</div>
          </div>
          <div class="stat-card sky">
            <span class="stat-icon">📊</span>
            <div class="stat-label">% Ber-PHBS</div>
            <div class="stat-value" id="stat-pct">0%</div>
            <div class="stat-sub">rata-rata kabupaten</div>
          </div>
          <div class="stat-card amber">
            <span class="stat-icon">🏥</span>
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
              <canvas id="chart-donut"></canvas>
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
          <h2>📋 Input Data PHBS</h2>
          <p>Masukkan data rekapitulasi PHBS bulanan per puskesmas</p>
        </div>

        <div class="filter-bar" style="margin-bottom:24px;">
          <div style="background:var(--green-pale);border-radius:10px;padding:14px 20px;font-size:13px;color:var(--green);font-weight:600;border:1px solid #bbf7d0;">
            💡 Pilih metode input data:
          </div>
        </div>

        <div class="chart-grid">
          <div class="chart-card">
            <div class="chart-title">📤 Import Excel</div>
            <div class="chart-sub">Upload file Excel sesuai format Dashboard_PHBS_RT_2025.xlsx</div>
            <div style="margin-top:12px;">
              <input type="file" id="excel-file" accept=".xlsx,.xls" style="display:none;" onchange="previewExcel(this)">
              <button class="btn-green" onclick="document.getElementById('excel-file').click()">📂 Pilih File Excel</button>
              <div id="excel-status" style="margin-top:12px;font-size:13px;color:var(--text-muted);"></div>
            </div>
          </div>
          <div class="chart-card">
            <div class="chart-title">✏️ Input Manual</div>
            <div class="chart-sub">Isi data langsung lewat formulir di bawah</div>
            <div style="margin-top:12px;">
              <button class="btn-green" onclick="showManualForm()">📝 Buka Formulir</button>
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
            <button class="btn-green" onclick="saveManual()">💾 Simpan Data</button>
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
          <h2>🏥 Data Per Puskesmas</h2>
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
          <h2>📅 History per Bulan / Tahun</h2>
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
          <h2>📈 Analisis Per Indikator</h2>
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
          <h2>⚖️ Perbandingan Antar Puskesmas</h2>
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

    </div><!-- /main -->
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
const COLORS = ['#16a34a','#0d9488','#0284c7','#d97706','#9333ea','#e11d48','#059669','#7c3aed','#ea580c','#0891b2','#65a30d','#c2410c'];

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
      borderColor:'#16a34a',backgroundColor:'rgba(22,163,74,.1)',
      fill:true, tension:.4, pointBackgroundColor:'#16a34a', pointRadius:4
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
    options:{responsive:false,cutout:'65%',plugins:{legend:{display:false}},
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
      <td><button onclick="showPuskDetail('${r.name}')" style="padding:5px 12px;background:var(--green);color:#fff;border:none;border-radius:6px;font-size:12px;font-family:inherit;cursor:pointer;">Detail</button></td>
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
  document.getElementById('detail-name').textContent = '🏥 ' + name;
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
      document.getElementById('excel-status').textContent = `✅ ${result.message}`;
    } else {
      document.getElementById('excel-status').textContent = `❌ Gagal menyimpan data.`;
    }
  } catch(err) {
    document.getElementById('excel-status').textContent = `❌ Error: ${err.message}`;
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
      style="padding:4px 10px;border:1px solid #dc2626;border-radius:6px;color:#dc2626;background:#fff;cursor:pointer;font-size:12px;">Hapus</button></td>
  </tr>`).join('');
}

// ─── EXCEL PREVIEW (stub) ───
function previewExcel(input){
  const file = input.files[0];
  if(!file) return;
  document.getElementById('excel-status').textContent = `📄 File dipilih: ${file.name} (${(file.size/1024).toFixed(1)} KB). Untuk integrasi penuh gunakan SheetJS atau server-side PHP.`;
}

</script>
</body>
</html>