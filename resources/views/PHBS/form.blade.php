<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $data ? 'Edit' : 'Input' }} Laporan PHBS – SIP-PHBS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
:root{--g9:#0a2e1a;--g7:#0d3d20;--g6:#16a34a;--g5:#22c55e;--g4:#4ade80;--g1:#dcfce7;--g0:#f0fdf4;--s9:#0f172a;--s7:#334155;--s5:#64748b;--s3:#cbd5e1;--s1:#f1f5f9;--fm:'Segoe UI',sans-serif;--mono:'Courier New',monospace}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--fm);background:#f0f7f3;min-height:100vh;display:flex}
.sidebar{width:230px;flex-shrink:0;background:var(--g9);position:fixed;top:0;left:0;height:100vh;display:flex;flex-direction:column;z-index:100}
.sb-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sb-logo-row{display:flex;align-items:center;gap:10px}
.sb-icon{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#16a34a,#0d3d20);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px}
.sb-logo h1{font-size:.85rem;font-weight:800;color:#fff}
.sb-logo p{font-size:.62rem;color:rgba(255,255,255,.45);margin-top:1px}
.sb-nav{padding:14px 10px;flex:1}
.nav-section{font-size:.58rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.3);text-transform:uppercase;padding:0 10px;margin:14px 0 5px}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:8px;color:rgba(255,255,255,.6);font-size:.8rem;font-weight:500;transition:.15s;margin-bottom:2px;text-decoration:none}
.nav-item:hover,.nav-item.active{background:rgba(255,255,255,.1);color:#fff}
.nav-item.active{background:rgba(74,222,128,.15);color:var(--g4)}
.nav-item i{width:16px;text-align:center;font-size:.8rem}
.sb-footer{padding:14px 20px;border-top:1px solid rgba(255,255,255,.08)}
.sb-footer p{font-size:.62rem;color:rgba(255,255,255,.3)}
.main{margin-left:230px;flex:1;display:flex;flex-direction:column}
.topbar{background:#fff;border-bottom:1px solid var(--s1);padding:13px 26px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.tb-left h2{font-size:.95rem;font-weight:800;color:var(--s9)}
.tb-left p{font-size:.72rem;color:var(--s5);margin-top:1px}
.btn{display:inline-flex;align-items:center;gap:7px;padding:8px 15px;border-radius:9px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:var(--fm);transition:.15s;text-decoration:none}
.btn-primary{background:var(--g6);color:#fff}.btn-primary:hover{background:#15803d}
.btn-outline{background:#fff;color:var(--s7);border:1.5px solid var(--s3)}
.content{padding:22px 26px}
.fc{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;margin-bottom:18px}
.fc-hdr{padding:14px 22px;border-bottom:1px solid var(--s1);display:flex;align-items:center;gap:10px}
.fc-hdr h3{font-size:.85rem;font-weight:700}
.fc-badge{font-size:.68rem;background:var(--g1);color:#166534;padding:2px 10px;border-radius:99px;font-weight:600}
.fc-body{padding:18px 22px}
.fr3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:14px}
.fr2{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:14px}
.fg{display:flex;flex-direction:column;gap:4px}
.fg label{font-size:.68rem;font-weight:700;color:var(--s5);text-transform:uppercase;letter-spacing:.04em}
.fg label span{color:#ef4444}
.fg input,.fg select{padding:9px 11px;border-radius:8px;border:1.5px solid var(--s3);font-size:.82rem;font-family:var(--fm);color:var(--s9);background:#fff;transition:.18s}
.fg input:focus,.fg select:focus{outline:none;border-color:var(--g6);box-shadow:0 0 0 3px rgba(22,163,74,.1)}
.fg input[type=number]{font-family:var(--mono)}
.fg .hint{font-size:.65rem;color:var(--s5);margin-top:3px}
.err-msg{background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:9px 13px;font-size:.75rem;color:#dc2626;margin-bottom:14px}
.ind-tbl{width:100%;border-collapse:collapse}
.ind-tbl th{background:var(--g9);color:rgba(255,255,255,.8);font-size:.65rem;font-weight:600;letter-spacing:.04em;padding:9px 13px;text-align:left;text-transform:uppercase}
.ind-tbl td{padding:8px 13px;border-bottom:1px solid var(--s1);vertical-align:middle;font-size:.78rem}
.ind-tbl tr:last-child td{border-bottom:none}
.ind-tbl tr:hover td{background:var(--g0)}
.ind-no{display:inline-flex;align-items:center;justify-content:center;width:21px;height:21px;border-radius:50%;background:var(--g6);color:#fff;font-size:.65rem;font-weight:700;margin-right:7px;flex-shrink:0}
.ind-tbl input[type=number]{width:88px;padding:5px 9px;border:1.5px solid var(--s3);border-radius:6px;font-family:var(--mono);font-size:.78rem;text-align:right}
.ind-tbl input:focus{outline:none;border-color:var(--g6)}
.fc-foot{display:flex;gap:10px;padding:14px 22px;border-top:1px solid var(--s1);background:var(--s1)}
#pct-info{margin-top:8px;padding:9px 13px;background:var(--g0);border-radius:8px;font-size:.8rem;color:#166534;font-weight:600;display:none}
</style>
</head>
<body>
<aside class="sidebar">
  <div class="sb-logo">
    <div class="sb-logo-row">
      <div class="sb-icon"><i class="fa-solid fa-heart-pulse"></i></div>
      <div><h1>SIP-PHBS</h1><p>Sistem Informasi Pelaporan PHBS</p></div>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="nav-section">Menu Utama</div>
    <a href="{{ route('dashboard') }}" class="nav-item"><i class="fa-solid fa-house"></i> Beranda</a>
    <a href="{{ route('phbs.index') }}" class="nav-item"><i class="fa-solid fa-chart-bar"></i> Laporan PHBS</a>
    <a href="{{ route('phbs.form') }}" class="nav-item active"><i class="fa-solid fa-plus"></i> Input Laporan</a>
  </nav>
  <div class="sb-footer"><p>{{ auth()->user()->nama_user ?? 'User' }}</p></div>
</aside>

<div class="main">
  <div class="topbar">
    <div class="tb-left">
      <h2>{{ $data ? 'Edit' : 'Input' }} Laporan PHBS</h2>
      <p>Tatanan Rumah Tangga • Kabupaten Sleman</p>
    </div>
    <a href="{{ route('phbs.index') }}" class="btn btn-outline">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="content">
    @php
      $action = $data ? route('phbs.update',$data->id_data) : route('phbs.store');
      $v = fn($k,$d='') => old($k, $data?->{$k} ?? $d);
      $inds = [
        1=>'Persalinan ditolong oleh Nakes',
        2=>'Memberi bayi ASI Eksklusif',
        3=>'Menimbang balita setiap bulan',
        4=>'Menggunakan air bersih',
        5=>'Mencuci tangan dg air bersih & sabun (CTPS)',
        6=>'Pengelolaan air minum & makan di rumah tangga',
        7=>'Menggunakan jamban sehat',
        8=>'Pengelolaan limbah cair di rumah tangga',
        9=>'Membuang sampah di tempat sampah',
        10=>'Memberantas jentik di rumah',
        11=>'Makan sayur dan buah setiap hari',
        12=>'Melakukan aktivitas fisik setiap hari',
        13=>'Tidak merokok di dalam rumah',
      ];
    @endphp

    <form method="POST" action="{{ $action }}">
      @csrf
      @if($data) @method('PUT') @endif

      @if($errors->any())
        <div class="err-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
      @endif

      {{-- IDENTITAS --}}
      <div class="fc">
        <div class="fc-hdr"><h3>Identitas Laporan</h3><span class="fc-badge">Data Umum</span></div>
        <div class="fc-body">
          <div class="fr3">
            <div class="fg">
              <label>Puskesmas <span>*</span></label>
              <select name="id_puskesmas" required>
                <option value="">-- Pilih Puskesmas --</option>
                @foreach($puskesmasList as $pkm)
                  <option value="{{ $pkm->id_puskesmas }}" {{ $v('id_puskesmas')==$pkm->id_puskesmas?'selected':'' }}>
                    {{ $pkm->nama_puskesmas }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="fg">
              <label>Bulan <span>*</span></label>
              <select name="bulan" required>
                <option value="">-- Pilih Bulan --</option>
                @foreach($namaBulan as $num=>$nm)
                  <option value="{{ $num }}" {{ $v('bulan')==$num?'selected':'' }}>{{ $nm }}</option>
                @endforeach
              </select>
            </div>
            <div class="fg">
              <label>Tahun <span>*</span></label>
              <select name="tahun" required>
                @for($y=2023;$y<=2026;$y++)
                  <option value="{{ $y }}" {{ $v('tahun',date('Y'))==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="fr3">
            <div class="fg">
              <label>KK Laki-laki <span>*</span></label>
              <input type="number" name="jumlah_kk_l" id="kk_l" min="0" value="{{ $v('jumlah_kk_l',0) }}" required oninput="hitungTotal()">
            </div>
            <div class="fg">
              <label>KK Perempuan <span>*</span></label>
              <input type="number" name="jumlah_kk_p" id="kk_p" min="0" value="{{ $v('jumlah_kk_p',0) }}" required oninput="hitungTotal()">
            </div>
            <div class="fg">
              <label>Total KK</label>
              <input type="number" name="jumlah_kk_total" id="kk_total" min="0" value="{{ $v('jumlah_kk_total',0) }}" required readonly style="background:var(--g0);font-weight:700;color:#166534">
              <div class="hint">Otomatis = KK L + KK P</div>
            </div>
          </div>
          <div class="fr2">
            <div class="fg">
              <label>KK Ber-PHBS <span>*</span></label>
              <input type="number" name="ber_phbs" id="ber_phbs" min="0" value="{{ $v('ber_phbs',0) }}" required oninput="hitungPct()">
            </div>
            <div class="fg">
              <label>Status Laporan</label>
              <select name="status_laporan">
                <option value="draft"    {{ $v('status_laporan','draft')!='terkirim'?'selected':'' }}>Draft</option>
                <option value="terkirim" {{ $v('status_laporan')=='terkirim'?'selected':'' }}>Terkirim ke Dinkes</option>
              </select>
            </div>
          </div>
          <div id="pct-info">
            <i class="fa-solid fa-chart-pie"></i>
            Persentase PHBS: <span id="pct-val" style="font-family:var(--mono)">0%</span>
          </div>
        </div>
      </div>

      {{-- 13 INDIKATOR --}}
      <div class="fc">
        <div class="fc-hdr"><h3>13 Indikator PHBS</h3><span class="fc-badge">Sasaran & Jumlah</span></div>
        <div class="fc-body" style="padding:0">
          <table class="ind-tbl">
            <thead>
              <tr>
                <th style="width:58%">Indikator</th>
                <th style="text-align:right">Sasaran</th>
                <th style="text-align:right">Jumlah Memenuhi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($inds as $n=>$nm)
              <tr>
                <td><span class="ind-no">{{ $n }}</span>{{ $nm }}</td>
                <td style="text-align:right">
                  <input type="number" name="ind{{ $n }}_sasaran" value="{{ $v('ind'.$n.'_sasaran',0) }}" min="0">
                </td>
                <td style="text-align:right">
                  <input type="number" name="ind{{ $n }}_jumlah" value="{{ $v('ind'.$n.'_jumlah',0) }}" min="0">
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="fc-foot">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk"></i>
          {{ $data ? 'Simpan Perubahan' : 'Simpan Laporan' }}
        </button>
        <a href="{{ route('phbs.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>

<script>
function hitungTotal(){
  const l=parseInt(document.getElementById('kk_l').value)||0;
  const p=parseInt(document.getElementById('kk_p').value)||0;
  document.getElementById('kk_total').value=l+p;
  hitungPct();
}
function hitungPct(){
  const t=parseInt(document.getElementById('kk_total').value)||0;
  const b=parseInt(document.getElementById('ber_phbs').value)||0;
  const el=document.getElementById('pct-info');
  const v=document.getElementById('pct-val');
  if(t>0){
    const p=((b/t)*100).toFixed(1);
    v.textContent=p+'%';
    v.style.color=p>=80?'#166534':(p>=60?'#92400e':'#dc2626');
    el.style.display='block';
  } else el.style.display='none';
}
hitungTotal();
</script>
</body>
</html>