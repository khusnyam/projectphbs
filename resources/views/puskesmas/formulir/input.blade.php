@extends('layouts.sidebar')
@section('title','Formulir - SIP-PHBS')
@section('content')

<main class="main">
  <div class="content">

    {{-- Hero --}}
    <div class="header-card" style="align-items:flex-start">
  <div style="flex:1">
    <h1 style="margin:0 0 6px"><i class="fa-solid fa-notes-medical"></i> Data PHBS Puskesmas</h1>
    <p style="margin:0">Input laporan baru dan pantau riwayat capaian indikator PHBS dalam satu halaman.</p>
  </div>
  <span class="header-badge" style="margin-top:4px;flex-shrink:0"><i class="fa-solid fa-database"></i> Pelaporan Terpadu</span>
</div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    {{-- Tab switcher --}}
    <div class="phbs-tabs">
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

    {{-- ═══ TAB INPUT ═══ --}}
    <section class="tab-section" id="section-input">

      <div class="method-grid">
        <div class="chart-card method-card" id="card-manual" onclick="showManual()">
          <div>
            <div class="chart-title"><i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Input Manual</div>
            <div class="chart-sub" style="margin-top:6px">Isi data utama dan 13 indikator PHBS langsung melalui formulir.</div>
          </div>
          <div class="method-actions">
            <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-lines"></i> Buka Formulir</button>
          </div>
        </div>
        <div class="chart-card method-card" id="card-import" onclick="showImport()">
          <div>
            <div class="chart-title"><i class="fa-solid fa-file-excel" style="color:#16a34a"></i> Import Excel</div>
            <div class="chart-sub" style="margin-top:6px">Upload file .xlsx / .xls sesuai format template pelaporan PHBS.</div>
          </div>
          <div class="method-actions">
            <button type="button" class="btn btn-green btn-sm"><i class="fa-solid fa-folder-open"></i> Buka Import</button>
          </div>
        </div>
      </div>

      {{-- Form Manual --}}
      <div id="manualBox" class="form-panel is-hidden">
        <form method="POST" action="{{ route('phbs.store') }}" id="formInput">
          @csrf

          <div class="detail-panel">
            <div class="section-head">
              <div>
                <h3><i class="fa-solid fa-clipboard-list"></i> Informasi Laporan</h3>
                <p>Lengkapi data utama laporan sebelum mengisi capaian indikator.</p>
              </div>
              <span class="count-badge">Data Utama</span>
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
            </div>

            <div style="margin-top:14px">
              <div class="kk-total-badge">
                <i class="fa-solid fa-house-user"></i>
                Total KK: <span id="kk_total_display">0</span>
                <span style="font-size:12px;font-weight:400;color:#15803d;margin-left:4px">(otomatis)</span>
              </div>
            </div>
          </div>

          {{-- Tabel 13 indikator --}}
          <div class="table-card">
            <div class="table-header">
              <div>
                <div class="table-title"><i class="fa-solid fa-list-check"></i> 13 Indikator PHBS</div>
                <div class="table-sub">Input sasaran dan capaian. Persentase dihitung otomatis per baris.</div>
              </div>
              <span class="count-badge" style="background:var(--green-bg);color:#15803d">
                <i class="fa-solid fa-percent"></i> Auto %
              </span>
            </div>

            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th style="width:44px">No</th>
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
      <div class="filter-card">
        <div class="section-head" style="margin-bottom:0">
          <div>
            <h3><i class="fa-solid fa-sliders"></i> Filter History</h3>
            <p>Saring data berdasarkan periode.</p>
          </div>
        </div>
        {{--
          PERBAIKAN: action pakai route('puskesmas.formulir.input')
          bukan route('phbs.index') yang sekarang tidak ada
        --}}
        <form method="GET" action="{{ route('puskesmas.formulir.input') }}" class="filter-form" id="filterForm">
          <input type="hidden" name="tab" value="history">
          <div class="fg">
            <label>Bulan</label>
            <select name="bulan">
              <option value="">Semua Bulan</option>
              @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
              @endforeach
            </select>
          </div>
          <div class="fg">
            <label>Tahun</label>
            <input type="number" name="tahun" placeholder="Tahun" value="{{ request('tahun') }}">
          </div>

          {{--
            PERBAIKAN: cek id_role langsung dari kolom, bukan via relasi role->nama_role
            karena relasi role di NewUser masih di-comment
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
            <a href="{{ route('puskesmas.formulir.input', ['tab'=>'history']) }}" class="btn btn-outline"><i class="fa-solid fa-xmark"></i></a>
          </div>
        </form>
      </div>

      {{-- Report list --}}
      <div class="report-list">
        @forelse($historyData as $item)
          @php
            $terpenuhi  = $item->details->where('jumlah_capaian', '>', 0)->count();
            $pctTotal   = round(($terpenuhi / 13) * 100, 1);
            $badgeClass = strtolower($item->kategori_phbs ?? 'kurang');
          @endphp

          <div class="report-card">
            <div class="report-head">
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

            <div class="report-body">

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
                <div class="table-wrap">
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
                <a href="{{ route('phbs.edit', $item->id_phbs) }}" class="btn btn-warning btn-sm">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <form id="delForm{{ $item->id_phbs }}" action="{{ route('phbs.destroy', $item->id_phbs) }}" method="POST" style="display:inline">
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

      @if($historyData->hasPages())
        <div class="pagination-wrap">
          {{ $historyData->links() }}
        </div>
      @endif

    </section>

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
  document.getElementById('kk_total_display').textContent = (lk + pr).toLocaleString('id-ID');
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
  if (selectedDeleteId) document.getElementById('delForm' + selectedDeleteId).submit();
});
document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

@if($errors->any())
  showManual();
@endif
</script>

@endsection