@extends('layouts.sidebar')
@section('title','Formulir - SIP-PHBS')
@section('top')
  <div class="hero-left">
    <div class="hero-title">
        Formulir
    </div>
      <p class="hero-desc">
       Input Data PHBS Tatanan Rumah Tangga.
      </p>
</div>
<div class="phbs-tabs" style="width: 23%; margin:2px">
      <button class="phbs-tab" id="tab-input" onclick="switchTab('input')">
        <i class="fa-solid fa-pen-to-square"></i> Input Data
      </button>
      <button class="phbs-tab" id="tab-history" onclick="switchTab('history')">
        <i class="fa-solid fa-clock-rotate-left"></i> History
        @php $totalHistory = $historyData->total(); @endphp
        @if($totalHistory > 0)
          <span style="background:var(--primary-lt);color:var(--primary);font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;">{{ $totalHistory }}</span>
        @endif
      </button>
    </div>
@endsection

@section('content')
<main class="main">
  <div class="content">
    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
    @endif
    
    {{-- ═══ TAB INPUT ═══ --}}
    <section class="tab-section" id="section-input">
      {{-- Form Manual --}}
      <div id="manualBox" class="form-panel">
        <form method="POST" action="{{ route('formulir.store') }}" id="formInput">
          @csrf

          <div class="filter-section">
            <div class="section-head" style="margin-top: -15px;margin-left:-15px;">
              <div>
                <h3>Perhatian!</h3>
                <p>Lengkapi data utama laporan sebelum mengisi capaian indikator.</p>
              </div>
              <div class="method-actions" onclick="showImport()">
              <button type="button" class="btn btn-green btn-sm"><i class="fa-solid fa-folder-open"></i>Import Excel</button>
            </div>
            </div>

            <div class="kk-grid">
              <div class="fg">
                <label>Bulan</label>
                <select name="bulan" required>
                  @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                    <option value="{{ $bln }}" {{ old('bulan') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                  @endforeach
                </select>
              </div>
              <div class="fg">
                <label>Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
              </div>
              <div class="fg">
                <label>Jumlah KK Laki-laki</label>
                <input type="number" name="jumlah_kk_lk" id="kk_lk" value="{{ old('jumlah_kk_lk', 0) }}" min="0" oninput="updateKkTotal()" required>
              </div>
              <div class="fg">
                <label>Jumlah KK Perempuan</label>
                <input type="number" name="jumlah_kk_pr" id="kk_pr" value="{{ old('jumlah_kk_pr', 0) }}" min="0" oninput="updateKkTotal()" required>
              </div>
              {{-- <div class="kk-total-badge"> --}}
                <button type="button" class="tab-input" onclick="isiOtomatisSasaran();" style="background:linear-gradient(135deg, #2563eb, #1d4ed8";color:#fff;padding: 12px 24px;>
                    Total KK: <span id="kk_total_display">0</span><br>
                </button>
              {{-- </div> --}}
            </div>
            </div>

          {{-- Tabel 13 indikator --}}
          <div class="section" style="margin: 15px;margin-top:-5px">
          <div class="section-card">
            <div class="section-head">
              <div>
                <div class="section-title">Indikator PHBS</div>
                <div class="section-sub">Input sasaran dan capaian. Persentase dihitung otomatis per baris.</div>
              </div>
            </div>

            <div class="table-wrap" style="margin: 15px">
              <table>
                <thead>
                  <tr>
                    <th style="width:44px;color:#1e3a5f">No</th>
                    <th>Indikator</th>
                    <th style="text-align:center;width:110px">Sasaran</th>
                    <th style="text-align:center;width:110px">Capaian</th>
                    <th style="text-align:center;width:90px">Persentase</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($allIndikator as $ind)
                    <tr>
                      <td><span class="num-badge">{{ $ind->id_indikator }}</span></td>
                      <td style="font-weight:600;color:#1e3a5f">{{ $ind->nama_indikator }}</td>
                      <td style="text-align:center">
                        {{--
                          target_nasional TIDAK ADA di DB/model NewIndikator.
                          Sasaran selalu diisi manual oleh user.
                          Indikator 1-3: isi sesuai sasaran spesifik (ibu hamil, bayi, balita)
                          Indikator 4-13: jika dikosongkan (0), controller pakai total KK
                        --}}
                        <input
                          type="number"
                          name="sasaran_input[{{ $ind->id_indikator }}]"
                          value="{{ old('sasaran_input.'.$ind->id_indikator, 0) }}"
                          class="input-sm sasaran-inp"
                          min="0"
                          placeholder="{{ $ind->id_indikator <= 3 ? 'opsional' : '' }}"
                          {{ $ind->id_indikator >= 4 ? 'readonly' : '' }}
                        >
                      </td>
                      <td style="text-align:center">
                        <input
                          type="number"
                          name="jumlah_input[{{ $ind->id_indikator }}]"
                          value="{{ old('jumlah_input.'.$ind->id_indikator, 0) }}"
                          class="input-sm capaian-inp"
                          min="0"
                        >
                      </td>
                      <td style="text-align:center">
                        <span class="pct-pill zero pct-display">0%</span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

            <div class="footer-actions">
              <button type="reset" class="btn btn-outline" onclick="resetPercent()">
                <i class="fa-solid fa-rotate-left"></i> Reset
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data
              </button>
            </div>
          </div>
        </form>
      </div>

      {{-- Import Excel --}}
      <div id="importBox" class="is-hidden">
        <div class="detail-panel import-box">
            <div style="margin-bottom:16px; text-align:left;">
            <button type="button" class="btn btn-outline" onclick="showManual()">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </button>
        </div>
          <div class="upload-icon"><i class="fa-solid fa-file-excel"></i></div>
          <h2>Upload Excel PHBS</h2>
          <p>Import file Excel format .xlsx / .xls sesuai template.</p>
          <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="drop-zone">
              <i class="fa-solid fa-cloud-arrow-up" style="font-size:2rem;color:var(--text-muted)"></i>
              <input type="file" name="file" accept=".xlsx,.xls" style="font-size:13px">
              <button type="submit" class="btn btn-green">
                <i class="fa-solid fa-upload"></i> Upload & Proses
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    {{-- ═══ TAB HISTORY ═══ --}}
    <section class="tab-section" id="section-history">

      {{-- Filter --}}
      <div class="filter-section">
        <form method="GET" action="{{ route('formulir.input') }}" class="filter-row" id="filterForm">
          <input type="hidden" name="tab" value="history">
          <div class="fg">
            <label>Bulan</label>
            <select name="bulan" required>
              <option value="" disabled {{ old('bulan') ? '' : 'selected' }}>-- Pilih Bulan --</option>
              @php
                  $daftarBulan = [
                      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
              @endphp

              @foreach($daftarBulan as $bulan)
                  <option value="{{ $bulan }}" {{ old('bulan') == $bulan ? 'selected' : '' }}>
                      {{ $bulan }}
                  </option>
              @endforeach
          </select>
          </div>
          <div class="fg">
            <label>Tahun</label>
            <input type="number" name="tahun" placeholder="Tahun" value="{{ request('tahun') }}">
          </div>

          {{--
            PERBAIKAN: cek id_role langsung dari kolom, bukan via relasi role->nama_role
            karena relasi role di User masih di-comment
          --}}
          @if(!Auth::check() || Auth::user()->id_role != 2)
          <div class="fg">
            <label>Puskesmas</label>
            <select name="puskesmas">
              <option value="">Semua Puskesmas</option>
              @foreach($puskesmas as $pkm)
                <option value="{{ $pkm->id_puskesmas }}" {{ request('puskesmas') == $pkm->id_puskesmas ? 'selected' : '' }}>
                  {{ $pkm->nama_puskesmas }}
                </option>
              @endforeach
            </select>
          </div>
          @endif

          <div style="display:flex;gap:8px">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
            <a href="{{ route('formulir.input', ['tab'=>'history']) }}" class="btn btn-outline"><i class="fa-solid fa-xmark"></i></a>
          </div>
        </form>
      </div>

      {{-- Report list --}}
      <div class="report-list" style="padding: 0px 15px 15px 15px">
        @forelse($historyData as $item)
          @php
            $terpenuhi  = $item->details->where('jumlah_capaian', '>', 0)->count();
            $pctTotal   = round(($terpenuhi / 13) * 100, 1);
            $badgeClass = strtolower($item->kategori_phbs ?? 'kurang');
          @endphp

          <div class="report-card">
            <div class="report-head" onclick="toggleReport({{ $item->id_phbs }})" style="cursor:pointer">
              <div>
                <h2><i class="fa-solid fa-hospital"></i> {{ $item->puskesmas->nama_puskesmas ?? '—' }}</h2>
                <p>
                  <i class="fa-regular fa-calendar"></i> {{ $item->bulan }} {{ $item->tahun }}
                  &nbsp;·&nbsp; KK: {{ $item->jumlah_kk_total }}
                  (L: {{ $item->jumlah_kk_lk }} / P: {{ $item->jumlah_kk_pr }})
                </p>
              </div>
              <span class="report-badge {{ $badgeClass }}">
                <i class="fa-solid fa-tag"></i> {{ $item->kategori_phbs ?? '—' }}
              </span>
            </div>

            <div class="report-body is-hidden" id="report-body-{{ $item->id_phbs }}">

              {{-- Quick stats --}}
              <div class="quick-grid">
                <div class="quick">
                  <div class="label">Total KK</div>
                  <div class="value">{{ $item->jumlah_kk_total }}</div>
                  <div class="sub">L {{ $item->jumlah_kk_lk }} / P {{ $item->jumlah_kk_pr }}</div>
                </div>
                <div class="quick">
                  <div class="label">Indikator Terpenuhi</div>
                  <div class="value">{{ $terpenuhi }} <span style="font-size:14px;font-weight:500;color:var(--text-muted)">/ 13</span></div>
                  <div class="sub">{{ $pctTotal }}% indikator aktif</div>
                </div>
                <div class="quick">
                  <div class="label">Rata-rata Capaian</div>
                  <h2>{{ round($item->details->avg('persentase'), 1) }}%</h2>
                </div>
              </div>

              {{-- Progress bar per indikator --}}
              <div>
                <div class="section-head" style="margin-bottom:10px">
                  <h3 style="font-size:13px"><i class="fa-solid fa-list-check"></i> Progress Indikator</h3>
                </div>
                <div class="indicator-grid">
                  @foreach($item->details->sortBy('id_indikator') as $detail)
                    <div class="ind-card">
                      <div class="ind-row">
                        <span class="ind-name">{{ $detail->indikator->nama_indikator ?? '—' }}</span>
                        <span class="ind-pct">{{ $detail->persentase }}%</span>
                      </div>
                      <div class="track">
                        <div class="fill" style="width:{{ min($detail->persentase, 100) }}%"></div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              {{-- Tabel detail --}}
              <div class="table-card">
                <div class="table-header">
                  <div class="table-title"><i class="fa-solid fa-table"></i> Detail per Indikator</div>
                </div>
                <div class="table-wrap" style="margin-top: 1px">
                  <table>
                    <thead>
                      <tr>
                        <th>Indikator</th>
                        <th style="text-align:center">Sasaran</th>
                        <th style="text-align:center">Capaian</th>
                        <th style="text-align:center">Persentase</th>
                        <th style="text-align:center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($item->details->sortBy('id_indikator') as $detail)
                        @php
                          $pct      = $detail->persentase;
                          $pctClass = $pct >= 80 ? 'high' : ($pct >= 50 ? 'mid' : ($pct > 0 ? 'low' : 'zero'));
                          $status   = $pct >= 80 ? 'Tinggi' : ($pct >= 50 ? 'Sedang' : ($pct > 0 ? 'Rendah' : '—'));
                        @endphp
                        <tr>
                          <td style="font-weight:600;color:#1e3a5f">
                            <span class="num-badge" style="margin-right:6px;background:#e2e8f0;color:#475569">{{ $detail->id_indikator }}</span>
                            {{ $detail->indikator->nama_indikator ?? '—' }}
                          </td>
                          <td style="text-align:center;font-family:var(--mono)">
                            {{ $detail->jumlah_sasaran ?? $item->jumlah_kk_total }}
                          </td>
                          <td style="text-align:center;font-weight:700;font-family:var(--mono)">{{ $detail->jumlah_capaian }}</td>
                          <td style="text-align:center"><span class="pct-pill {{ $pctClass }}">{{ $pct }}%</span></td>
                          <td style="text-align:center"><span class="pct-pill {{ $pctClass }}" style="font-family:'Inter'">{{ $status }}</span></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              {{-- Actions --}}
              <div class="actions">
                <a href="{{ route('formulir.edit', $item->id_phbs) }}" class="btn btn-warning btn-sm">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <form id="delForm{{ $item->id_phbs }}" action="{{ route('formulir.destroy', $item->id_phbs) }}" method="POST" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" onclick="openDeleteModal({{ $item->id_phbs }})" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
              </div>

            </div>
          </div>
        @empty
          <div class="empty-state">
            <i class="fa-solid fa-box-open"></i>
            <p>Belum ada data PHBS yang tersimpan.</p>
          </div>
        @endforelse
      </div>
    </section>
    <div>
    </div>
  </div>
</main>

{{-- Delete modal --}}
<div id="deleteModal" class="modal hidden">
  <div class="modal-box">
    <h2><i class="fa-solid fa-triangle-exclamation" style="color:var(--red)"></i> Hapus Data?</h2>
    <p>Data PHBS yang dihapus tidak dapat dipulihkan, termasuk semua detail indikatornya.</p>
    <div class="modal-actions">
      <button onclick="closeDeleteModal()" class="btn btn-outline">Batal</button>
      <button id="confirmDeleteBtn" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
    </div>
  </div>
</div>

<script>
function isiOtomatisSasaran() {
    // 1. Ambil angka Total KK dari display span
    let totalKkText = document.getElementById('kk_total_display').innerText;
    let totalKk = parseInt(totalKkText) || 0;

    // 2. Isi ke kolom input sasaran indikator 4 sampai 13 secara lokal di browser
    for (let i = 4; i <= 13; i++) {
        // Mencari input berdasarkan name="sasaran_input[4]" sampai name="sasaran_input[13]"
        let inputSasaran = document.querySelector(`input[name="sasaran_input[${i}]"]`);
        
        if (inputSasaran) {
            // Mengisi nilai input di layar
            inputSasaran.value = totalKk;
            
            // Opsional: Beri warna abu-abu tipis sebagai penanda bahwa ini terisi otomatis
            inputSasaran.style.backgroundColor = '#f3f4f6'; 
        }
    }
}

function toggleReport(id) {
    const body = document.getElementById('report-body-' + id);
    const arrow = document.getElementById('arrow-' + id);

    body.classList.toggle('is-hidden');

    arrow.classList.toggle('fa-chevron-down');
    arrow.classList.toggle('fa-chevron-up');
}

function switchTab(tab) {
  ['input','history'].forEach(t => {
    document.getElementById('tab-' + t).classList.toggle('active', t === tab);
    document.getElementById('section-' + t).classList.toggle('active', t === tab);
  });
  sessionStorage.setItem('phbs_tab', tab);
}

(function(){
  const serverTab = '{{ request("tab", session("active_tab", "")) }}';
  const stored    = sessionStorage.getItem('phbs_tab');
  const hasError  = {{ $errors->any() ? 'true' : 'false' }};
  const tab       = serverTab || (hasError ? 'input' : stored) || 'input';
  switchTab(tab);
})();

function showManual() {
  document.getElementById('manualBox').classList.remove('is-hidden');
  document.getElementById('importBox').classList.add('is-hidden');
  document.getElementById('card-manual').classList.add('selected');
  document.getElementById('card-import').classList.remove('selected');
}
function showImport() {
  document.getElementById('importBox').classList.remove('is-hidden');
  document.getElementById('manualBox').classList.add('is-hidden');
  document.getElementById('card-import').classList.add('selected');
  document.getElementById('card-manual').classList.remove('selected');
}

function updateKkTotal() {
  const lk = parseInt(document.getElementById('kk_lk').value) || 0;
  const pr = parseInt(document.getElementById('kk_pr').value) || 0;
  const total = lk + pr;
  document.getElementById('kk_total_display').textContent = (lk + pr).toLocaleString('id-ID');

  for (let i = 4; i <= 13; i++) {
    const sasaranInput = document.getElementById('sasaran_' + i);
    if (sasaranInput) {
      sasaranInput.value = total;
      
      // Mentrigger event 'input' agar perhitungan persentase di baris tersebut ikut terupdate
      sasaranInput.dispatchEvent(new Event('input'));
    }
  }
}
updateKkTotal();

function updatePct(row) {
  const sasaran = parseFloat(row.querySelector('.sasaran-inp').value) || 0;
  const capaian = parseFloat(row.querySelector('.capaian-inp').value) || 0;
  const pct = sasaran > 0 ? (capaian / sasaran) * 100 : 0;
  const pill = row.querySelector('.pct-display');
  pill.textContent = pct.toFixed(1) + '%';
  pill.className = 'pct-pill pct-display ' + (pct === 0 ? 'zero' : pct >= 80 ? 'high' : pct >= 50 ? 'mid' : 'low');
}

document.querySelectorAll('.sasaran-inp, .capaian-inp').forEach(inp => {
  inp.addEventListener('input', function() { updatePct(this.closest('tr')); });
});

function resetPercent() {
  document.querySelectorAll('.pct-display').forEach(p => {
    p.textContent = '0%'; p.className = 'pct-pill pct-display zero';
  });
  updateKkTotal();
}

let selectedDeleteId = null;
function openDeleteModal(id) {
  selectedDeleteId = id;
  document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() {
  document.getElementById('deleteModal').classList.add('hidden');
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  // Jika ID kosong/tidak ada, baru batalkan proses (return)
  if (!selectedDeleteId) return; 
  
  // Jika ID ada, kirim form ke Controller
  document.getElementById('delForm' + selectedDeleteId).submit();
});
document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

@if($errors->any())
  showManual();
@endif
</script>

@endsection