<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Input Data PHBS - SIP-PHBS</title>
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
body{font-family:'Segoe UI',sans-serif;background:var(--bg);min-height:100vh;color:var(--text)}
a{text-decoration:none;color:inherit}
button,input,select{font-family:'Segoe UI',sans-serif}

/* SIDEBAR */
.sidebar{
  width:230px;flex-shrink:0;position:fixed;left:0;top:0;bottom:0;z-index:100;
  background:linear-gradient(180deg,#0a1628 0%,#0d2137 60%,#0a3d2e 100%);
  color:#fff;display:flex;flex-direction:column;
}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sb-logo-row{display:flex;align-items:center;gap:10px}
.sb-icon{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));color:var(--yellow);display:flex;align-items:center;justify-content:center;font-size:16px}
.sb-logo h1{font-size:.9rem;font-weight:700;color:#fff}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.48);margin-top:1px;line-height:1.35}
.sb-nav{padding:14px 10px;flex:1;overflow:auto}
.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.28);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.62);font-size:.8rem;font-weight:600;transition:.15s;margin-bottom:2px;border-left:3px solid transparent}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left-color:var(--yellow)}
.nav-item i{width:16px;text-align:center}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer h3{font-size:.75rem;font-weight:700;color:rgba(255,255,255,.86);margin-bottom:4px}
.sb-footer p{font-size:.62rem;color:rgba(255,255,255,.46);line-height:1.45}

/* MAIN */
.main{margin-left:230px;min-height:100vh;min-width:0}
.content{padding:26px;display:flex;flex-direction:column;gap:18px}
.card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);border:1px solid rgba(15,23,42,.05)}
.header-card{background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 58%,#0a3d2e 100%);color:#fff;border-radius:16px;padding:24px 28px;box-shadow:0 4px 20px rgba(0,51,153,.18);display:flex;align-items:center;justify-content:space-between;gap:18px}
.header-card h1{font-size:1.35rem;font-weight:700;margin-bottom:8px;letter-spacing:.2px;display:flex;align-items:center;gap:10px}
.header-card p{font-size:.84rem;color:rgba(255,255,255,.75);line-height:1.55}
.header-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.13);font-size:.7rem;font-weight:800;padding:7px 11px;border-radius:999px;color:rgba(255,255,255,.92);white-space:nowrap}

.section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px}
.section-head h3{font-size:.96rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.section-head h3 i{color:var(--blue)}
.section-head p{font-size:.72rem;color:var(--muted);margin-top:3px;line-height:1.45}
.count-badge{background:#f1f5f9;color:#64748b;font-size:.7rem;font-weight:800;padding:6px 10px;border-radius:999px;white-space:nowrap}

.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:9px;padding:10px 14px;font-size:.78rem;font-weight:700;cursor:pointer;transition:.15s}
.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue-dark)}
.btn-outline{background:#fff;color:#1e3a5f;border:1.5px solid #cbd5e1}.btn-outline:hover{border-color:var(--blue);color:var(--blue)}
.btn-danger{background:#ef4444;color:#fff}.btn-danger:hover{background:#dc2626}

.alert{padding:12px 14px;border-radius:12px;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:8px}
.alert-success{background:#dcfce7;border:1px solid #bbf7d0;color:#166534}
.alert-error{background:#fee2e2;border:1px solid #fecaca;color:#991b1b}

.tab-card{padding:14px 16px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.tab-btn{background:#fff;color:#1e3a5f;border:1.5px solid #cbd5e1;border-radius:10px;padding:9px 13px;font-size:.78rem;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:.15s}
.tab-btn.active{background:var(--blue);color:#fff;border-color:var(--blue);box-shadow:0 4px 14px rgba(0,51,153,.16)}
.tab-btn:hover{border-color:var(--blue);color:var(--blue)}
.tab-btn.active:hover{color:#fff}

.form-card{padding:18px 20px}
.form-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.fg label{display:block;font-size:.68rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
.fg input,.fg select{width:100%;height:42px;border-radius:8px;border:1.5px solid #cbd5e1;background:#fff;padding:0 11px;font-size:.82rem;color:var(--text);outline:none;transition:.15s}
.fg input:focus,.fg select:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(0,51,153,.08)}

.table-card{overflow:hidden}
.table-top{background:linear-gradient(135deg,var(--blue-dark),var(--blue));color:#fff;padding:17px 20px;display:flex;justify-content:space-between;align-items:center;gap:12px}
.table-top h3{font-size:.98rem;font-weight:700;display:flex;align-items:center;gap:8px}.table-top p{font-size:.72rem;color:rgba(255,255,255,.72);margin-top:3px}
.table-top .pill{background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.16);border-radius:999px;padding:6px 10px;font-size:.68rem;font-weight:800;color:#fff}
.table-wrap{overflow:auto;background:#fff}
table{width:100%;border-collapse:separate;border-spacing:0;min-width:880px}
th{background:#f8fafc;color:var(--muted);font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;padding:11px 12px;text-align:left;border-bottom:1px solid var(--line)}
td{padding:10px 12px;border-bottom:1px solid #f1f5f9;font-size:.78rem;color:var(--text);vertical-align:middle}
tr:hover td{background:#f8faff}
.num-badge{width:30px;height:30px;border-radius:9px;background:#eef2ff;color:var(--blue);font-size:.73rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center}
.input-sm{width:88px;height:34px;border-radius:8px;border:1.5px solid #cbd5e1;text-align:center;font-size:.78rem;outline:none;padding:0 6px}.input-sm:focus{border-color:var(--blue)}
.percent{display:inline-flex;min-width:52px;justify-content:center;background:#eef2ff;color:var(--blue);border-radius:999px;padding:5px 8px;font-size:.72rem;font-weight:800}
.table-footer{background:#f8fafc;padding:14px 18px;display:flex;justify-content:flex-end;gap:10px;border-top:1px solid var(--line)}

.import-box{padding:34px 22px;text-align:center}.import-icon{width:76px;height:76px;margin:0 auto 14px;border-radius:22px;background:#dcfce7;color:#166534;display:flex;align-items:center;justify-content:center;font-size:2rem}.import-box h2{font-size:1.15rem;margin-bottom:6px}.import-box p{font-size:.8rem;color:var(--muted);margin-bottom:18px}.drop-zone{border:2px dashed #cbd5e1;background:#f8fafc;border-radius:16px;padding:28px;max-width:620px;margin:0 auto}
.is-hidden{display:none!important}

@media(max-width:1100px){.form-grid{grid-template-columns:repeat(2,1fr)}.header-card{align-items:flex-start;flex-direction:column}}
@media(max-width:760px){.sidebar{position:relative;width:100%;height:auto}.main{margin-left:0}.content{padding:16px}.form-grid{grid-template-columns:1fr}body{display:block}}
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
    <a href="{{ route('phbs.create') }}" class="nav-item active">
      <i class="fa-solid fa-file-pen"></i> Input PHBS
    </a>
    <a href="{{ route('phbs.history') }}" class="nav-item">
      <i class="fa-solid fa-clock-rotate-left"></i> History
    </a>
  </nav>

  <div class="sb-footer">
    <h3>Sistem PHBS</h3>
    <p>Pelaporan indikator PHBS seluruh Puskesmas Kabupaten Sleman.</p>
  </div>
</aside>

<main class="main">
  <div class="content">

    <section class="header-card">
      <div>
        <h1><i class="fa-solid fa-file-circle-plus"></i> Input Data PHBS</h1>
        <p>Input laporan indikator PHBS per puskesmas dengan metode manual atau import Excel.</p>
      </div>
      <span class="header-badge"><i class="fa-solid fa-shield-heart"></i> SIP-PHBS</span>
    </section>

    @if(session('success'))
      <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    <section class="card tab-card">
      <button type="button" onclick="showManual()" id="manualBtn" class="tab-btn active">
        <i class="fa-solid fa-keyboard"></i> Input Manual
      </button>
      <button type="button" onclick="showImport()" id="excelBtn" class="tab-btn">
        <i class="fa-solid fa-file-excel"></i> Import Excel
      </button>
    </section>

    <div id="manualBox">
      <form method="POST" action="{{ route('phbs.store') }}">
        @csrf

        <section class="card form-card">
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
              <input type="number" name="jumlah_kk_total" value="0">
            </div>
          </div>
        </section>

        <section class="card table-card">
          <div class="table-top">
            <div>
              <h3><i class="fa-solid fa-list-check"></i> 13 Indikator PHBS</h3>
              <p>Input sasaran dan capaian. Persentase dihitung otomatis.</p>
            </div>
            <span class="pill"><i class="fa-solid fa-percent"></i> Auto Persentase</span>
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
                    <td><span class="num-badge">{{ $key + 1 }}</span></td>
                    <td style="font-weight:600;color:#1e3a5f">{{ $item }}</td>
                    <td style="text-align:center">
                      <input type="number" name="sasaran_input[{{ $key+1 }}]" value="0" class="input-sm sasaran">
                    </td>
                    <td style="text-align:center">
                      <input type="number" name="jumlah_input[{{ $key+1 }}]" value="0" class="input-sm jumlah">
                    </td>
                    <td style="text-align:center"><span class="percent">0%</span></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="table-footer">
            <button type="reset" class="btn btn-outline"><i class="fa-solid fa-rotate-left"></i> Reset</button>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
          </div>
        </section>
      </form>
    </div>

    <div id="importBox" class="is-hidden">
      <section class="card import-box">
        <div class="import-icon"><i class="fa-solid fa-file-excel"></i></div>
        <h2>Upload Excel PHBS</h2>
        <p>Import file Excel format .xlsx / .xls.</p>

        <form method="POST" action="#" enctype="multipart/form-data">
          @csrf
          <div class="drop-zone">
            <input type="file" name="file" style="font-size:.82rem;margin-bottom:16px">
            <br>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Upload Excel</button>
          </div>
        </form>
      </section>
    </div>

  </div>
</main>

<script>
function setTab(active){
  document.getElementById('manualBtn').classList.toggle('active', active === 'manual');
  document.getElementById('excelBtn').classList.toggle('active', active === 'excel');
}
function showImport(){
  document.getElementById('manualBox').classList.add('is-hidden');
  document.getElementById('importBox').classList.remove('is-hidden');
  setTab('excel');
}
function showManual(){
  document.getElementById('manualBox').classList.remove('is-hidden');
  document.getElementById('importBox').classList.add('is-hidden');
  setTab('manual');
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
