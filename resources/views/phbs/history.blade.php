<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>History PHBS - SIP-PHBS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root{
  --blue-dark:#002277;
  --blue:#003399;
  --blue-mid:#0044cc;
  --yellow:#FFCC00;
  --green:#16a34a;
  --red:#ef4444;
  --orange:#f59e0b;
  --bg:#f0f4ff;
  --text:#0f172a;
  --muted:#64748b;
  --line:#e5e7eb;
  --soft:#f8fafc;
  --card:#ffffff;
  --shadow:0 1px 7px rgba(15,23,42,.07);
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:var(--bg);min-height:100vh;color:var(--text)}
a{text-decoration:none;color:inherit}button,input,select{font-family:'Segoe UI',sans-serif}

.sidebar{width:230px;flex-shrink:0;position:fixed;left:0;top:0;bottom:0;z-index:100;background:linear-gradient(180deg,#0a1628 0%,#0d2137 60%,#0a3d2e 100%);color:#fff;display:flex;flex-direction:column}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}.sb-logo-row{display:flex;align-items:center;gap:10px}.sb-icon{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));color:var(--yellow);display:flex;align-items:center;justify-content:center;font-size:16px}.sb-logo h1{font-size:.9rem;font-weight:700}.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.48);margin-top:1px;line-height:1.35}.sb-nav{padding:14px 10px;flex:1;overflow:auto}.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.28);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}.nav-item{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.62);font-size:.8rem;font-weight:600;transition:.15s;margin-bottom:2px;border-left:3px solid transparent}.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}.nav-item.active{background:rgba(255,204,0,.12);color:var(--yellow);border-left-color:var(--yellow)}.nav-item i{width:16px;text-align:center}.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}.sb-footer h3{font-size:.75rem;font-weight:700;color:rgba(255,255,255,.86);margin-bottom:4px}.sb-footer p{font-size:.62rem;color:rgba(255,255,255,.46);line-height:1.45}

.main{margin-left:230px;min-height:100vh;min-width:0}.content{padding:26px;display:flex;flex-direction:column;gap:18px}.card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);border:1px solid rgba(15,23,42,.05)}
.header-card{background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 58%,#0a3d2e 100%);color:#fff;border-radius:16px;padding:24px 28px;box-shadow:0 4px 20px rgba(0,51,153,.18);display:flex;align-items:center;justify-content:space-between;gap:18px}.header-card h1{font-size:1.35rem;font-weight:700;margin-bottom:8px;letter-spacing:.2px;display:flex;align-items:center;gap:10px}.header-card p{font-size:.84rem;color:rgba(255,255,255,.75);line-height:1.55}.header-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.13);font-size:.7rem;font-weight:800;padding:7px 11px;border-radius:999px;color:rgba(255,255,255,.92);white-space:nowrap}
.section-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px}.section-head h3{font-size:.96rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}.section-head h3 i{color:var(--blue)}.section-head p{font-size:.72rem;color:var(--muted);margin-top:3px;line-height:1.45}.count-badge{background:#f1f5f9;color:#64748b;font-size:.7rem;font-weight:800;padding:6px 10px;border-radius:999px;white-space:nowrap}

.filter-card{padding:17px 20px}.filter-form{display:grid;grid-template-columns:1fr 1fr auto;gap:10px;align-items:end}.fg label{display:block;font-size:.68rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}.fg input,.fg select{width:100%;height:42px;border-radius:8px;border:1.5px solid #cbd5e1;background:#fff;padding:0 11px;font-size:.82rem;color:var(--text);outline:none;transition:.15s}.fg input:focus,.fg select:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(0,51,153,.08)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:9px;padding:10px 14px;font-size:.78rem;font-weight:700;cursor:pointer;transition:.15s}.btn-primary{background:var(--blue);color:#fff}.btn-primary:hover{background:var(--blue-dark)}.btn-warning{background:#f59e0b;color:#fff}.btn-danger{background:#ef4444;color:#fff}.btn-outline{background:#fff;color:#1e3a5f;border:1.5px solid #cbd5e1}

.report-card{overflow:hidden}.report-head{background:linear-gradient(135deg,var(--blue-dark),var(--blue));color:#fff;padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:14px}.report-head h2{font-size:1.05rem;font-weight:700;display:flex;align-items:center;gap:9px}.report-head p{font-size:.72rem;color:rgba(255,255,255,.72);margin-top:4px}.report-badge{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:7px 12px;font-size:.72rem;font-weight:800}.report-body{padding:18px 20px}.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:16px}.quick{background:#f8fafc;border:1px solid #eef2f7;border-radius:13px;padding:15px 16px;text-align:center}.quick .label{font-size:.68rem;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.06em}.quick .value{font-size:1.55rem;font-weight:800;color:var(--blue);margin-top:5px}.quick .sub{font-size:.7rem;color:var(--muted);margin-top:2px}.avg-card{background:#f8fafc;border:1px dashed #cbd5e1;border-radius:13px;padding:15px 16px;text-align:center;margin-bottom:16px}.avg-card p{font-size:.72rem;color:var(--muted);font-weight:700}.avg-card h2{font-size:1.7rem;color:var(--blue);margin-top:4px}
.indicator-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:10px}.ind-card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:12px}.ind-row{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:8px}.ind-name{font-size:.76rem;font-weight:700;color:#1e3a5f}.ind-pct{font-size:.72rem;font-weight:800;color:var(--blue);background:#eef2ff;border-radius:999px;padding:4px 8px}.track{height:7px;background:#e2e8f0;border-radius:999px;overflow:hidden}.fill{height:100%;background:var(--blue);border-radius:999px}.table-wrap{overflow:auto;margin-top:16px;border:1px solid var(--line);border-radius:12px;background:#fff}table{width:100%;border-collapse:separate;border-spacing:0;min-width:650px}th{background:#f8fafc;color:var(--muted);font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;padding:11px 12px;text-align:left;border-bottom:1px solid var(--line)}td{padding:10px 12px;border-bottom:1px solid #f1f5f9;font-size:.78rem;color:var(--text);vertical-align:middle}tr:hover td{background:#f8faff}.actions{display:flex;justify-content:flex-end;gap:8px;margin-top:16px}.empty-state{text-align:center;padding:38px;color:var(--muted)}.empty-state i{font-size:1.5rem;color:#cbd5e1;display:block;margin-bottom:8px}
.modal{position:fixed;inset:0;background:rgba(15,23,42,.55);display:flex;align-items:center;justify-content:center;z-index:200}.modal.hidden{display:none}.modal-box{background:#fff;border-radius:16px;box-shadow:0 20px 45px rgba(15,23,42,.22);width:100%;max-width:420px;padding:22px}.modal-box h2{font-size:1.05rem;margin-bottom:8px;display:flex;align-items:center;gap:8px}.modal-box p{font-size:.8rem;color:var(--muted);line-height:1.45}.modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:18px}

@media(max-width:1100px){.quick-grid,.indicator-grid{grid-template-columns:1fr}.filter-form{grid-template-columns:1fr 1fr}.header-card{align-items:flex-start;flex-direction:column}}
@media(max-width:760px){.sidebar{position:relative;width:100%;height:auto}.main{margin-left:0}.content{padding:16px}.filter-form{grid-template-columns:1fr}body{display:block}}
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
    <a href="{{ route('phbs.create') }}" class="nav-item">
      <i class="fa-solid fa-file-pen"></i> Input PHBS
    </a>
    <a href="{{ route('phbs.history') }}" class="nav-item active">
      <i class="fa-solid fa-clock-rotate-left"></i> History
    </a>
  </nav>

  <div class="nav-section">Akun</div>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item" style="width:100%;background:none;border:none;text-align:left">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
        </form>
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
        <h1><i class="fa-solid fa-clock-rotate-left"></i> History Monitoring PHBS</h1>
        <p>Rekap data PHBS per puskesmas berdasarkan periode bulan dan tahun.</p>
      </div>
      <span class="header-badge"><i class="fa-solid fa-database"></i> Rekap Data</span>
    </section>

    <section class="card filter-card">
      <div class="section-head">
        <div>
          <h3><i class="fa-solid fa-sliders"></i> Filter History</h3>
          <p>Pilih bulan dan tahun untuk menampilkan data sesuai kebutuhan.</p>
        </div>
      </div>

      <form method="GET" action="{{ route('phbs.history') }}" class="filter-form">
        <div class="fg">
          <label>Bulan</label>
          <select name="bulan">
            <option value="">Semua Bulan</option>
            <option value="Januari">Januari</option>
            <option value="Februari">Februari</option>
            <option value="Maret">Maret</option>
            <option value="April">April</option>
            <option value="Mei">Mei</option>
            <option value="Juni">Juni</option>
            <option value="Juli">Juli</option>
            <option value="Agustus">Agustus</option>
            <option value="September">September</option>
            <option value="Oktober">Oktober</option>
            <option value="November">November</option>
            <option value="Desember">Desember</option>
          </select>
        </div>

        <div class="fg">
          <label>Tahun</label>
          <input type="number" name="tahun" placeholder="Tahun">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass-chart"></i> Filter</button>
      </form>

      

    </section>

    <div class="report-list">
      @forelse($data as $item)
        <section class="card report-card">
          <div class="report-head">
            <div>
              <h2><i class="fa-solid fa-hospital"></i> {{ $item->puskesmas->nama_puskesmas ?? '-' }}</h2>
              <p><i class="fa-regular fa-calendar"></i> {{ $item->bulan }} {{ $item->tahun }}</p>
            </div>
            <div class="report-badge"><i class="fa-solid fa-tag"></i> {{ $item->kategori_phbs }}</div>
          </div>

          <div class="report-body">
            @php
              $totalIndikator = 13;
              $terpenuhi = $item->details->where('jumlah_capaian', '>', 0)->count();
              $persentaseTotal = $totalIndikator > 0 ? ($terpenuhi / $totalIndikator) * 100 : 0;
            @endphp

            <div class="quick-grid">
              <div class="quick">
                <div class="label">Jumlah KK</div>
                <div class="value">{{ $item->jumlah_kk_total }}</div>
              </div>

              <div class="quick">
                <div class="label">Indikator Terpenuhi</div>
                <div class="value">{{ $terpenuhi }} / {{ $totalIndikator }}</div>
                <div class="sub">{{ number_format($persentaseTotal,1) }}%</div>
              </div>

              <div class="quick">
                <div class="label">Kategori</div>
                <div class="value">{{ $item->kategori_phbs }}</div>
              </div>
            </div>

            <div class="avg-card">
              <p>Rata-rata Capaian PHBS</p>
              <h2>{{ round($item->details->avg('persentase'),1) }}%</h2>
            </div>

            @php
              $namaIndikator = [
                1 => 'Persalinan Nakes',
                2 => 'ASI Eksklusif',
                3 => 'Timbang Balita',
                4 => 'Air Bersih',
                5 => 'Cuci Tangan',
                6 => 'Pengelolaan Air Minum',
                7 => 'Jamban Sehat',
                8 => 'Pengelolaan Limbah',
                9 => 'Buang Sampah',
                10 => 'Pemberantasan Jentik',
                11 => 'Makan Buah Sayur',
                12 => 'Aktivitas Fisik',
                13 => 'Tidak Merokok',
              ];
            @endphp

            <div class="section-head" style="margin-top:4px;margin-bottom:10px">
              <div>
                <h3><i class="fa-solid fa-list-check"></i> Detail Indikator</h3>
                <p>Capaian masing-masing indikator PHBS.</p>
              </div>
              <span class="count-badge">13 Indikator</span>
            </div>

            <div class="indicator-grid">
              @foreach($item->details as $detail)
                <div class="ind-card">
                  <div class="ind-row">
                    <span class="ind-name">{{ $namaIndikator[$detail->id_indikator] ?? '-' }}</span>
                    <span class="ind-pct">{{ $detail->persentase }}%</span>
                  </div>
                  <div class="track">
                    <div class="fill" style="width: {{ $detail->persentase }}%"></div>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Indikator</th>
                    <th style="text-align:center">Sasaran</th>
                    <th style="text-align:center">Capaian</th>
                    <th style="text-align:center">Persentase</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($item->details as $detail)
                    <tr>
                      <td style="font-weight:600;color:#1e3a5f">{{ $namaIndikator[$detail->id_indikator] ?? '-' }}</td>
                      <td style="text-align:center">{{ $detail->jumlah_sasaran }}</td>
                      <td style="text-align:center;font-weight:700">{{ $detail->jumlah_capaian }}</td>
                      <td style="text-align:center;color:var(--blue);font-weight:800">{{ $detail->persentase }}%</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="actions">
              <a href="{{ route('phbs.edit', $item->id_phbs) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

              <form id="deleteForm{{ $item->id_phbs }}" action="{{ route('phbs.destroy', $item->id_phbs) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteModal({{ $item->id_phbs }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
              </form>
            </div>
          </div>
        </section>
      @empty
        <section class="card empty-state">
          <i class="fa-solid fa-box-open"></i>
          Data tidak ditemukan
        </section>
      @endforelse
    </div>
  </div>
</main>

<div id="deleteModal" class="modal hidden">
  <div class="modal-box">
    <h2><i class="fa-solid fa-triangle-exclamation" style="color:#ef4444"></i> Hapus Data?</h2>
    <p>Data PHBS yang dihapus tidak akan tampil lagi pada halaman history.</p>
    <div class="modal-actions">
      <button onclick="closeDeleteModal()" class="btn btn-outline">Batal</button>
      <button id="confirmDeleteBtn" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
    </div>
  </div>
</div>

<script>
let selectedDeleteId = null;

function openDeleteModal(id){
  selectedDeleteId = id;
  document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal(){
  document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function(){
  document.getElementById('deleteForm' + selectedDeleteId).submit();
});
</script>

</body>
</html>
