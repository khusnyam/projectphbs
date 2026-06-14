@extends('layouts.sidebar')
@section('title','Edit Formulir - SIP-PHBS')
@section('top')
  <div class="hero-left">
    <div class="hero-title">
        Edit Formulir
    </div>
      <p class="hero-desc">
       Edit Data PHBS Tatanan Rumah Tangga.
      </p>
  </div>
  <div class="phbs-tabs" style="width: auto; margin:5px; padding: 0 15px;">
      <a href="{{ route('formulir.input', ['tab' => 'history']) }}" class="btn btn-outline" style="text-decoration:none;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke History
      </a>
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
    
    <section class="tab-section active" id="section-input">
      {{-- Form Manual (Edit) --}}
      <div id="manualBox" class="form-panel">
        <form method="POST" action="{{ route('formulir.update', $phbs->id_phbs) }}" id="formEdit">
          @csrf
          @method('PUT')

          <div class="filter-section">
            <div class="section-head" style="margin-top: -15px;margin-left:-15px;">
              <div>
                <h3>Perbarui Data</h3>
                <p>Ubah data laporan bulan {{ $phbs->bulan }} {{ $phbs->tahun }}.</p>
              </div>
            </div>

            <div class="kk-grid">
              <div class="fg">
                <label>Bulan</label>
                <select name="bulan" required>
                  @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                    <option value="{{ $bln }}" {{ old('bulan', $phbs->bulan) == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                  @endforeach
                </select>
              </div>
              <div class="fg">
                <label>Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', $phbs->tahun) }}" min="2000" max="2100" required>
              </div>
              <div class="fg">
                <label>Jumlah KK Laki-laki</label>
                <input type="number" name="jumlah_kk_lk" id="kk_lk" value="{{ old('jumlah_kk_lk', $phbs->jumlah_kk_lk) }}" min="0" oninput="updateKkTotal()" required>
              </div>
              <div class="fg">
                <label>Jumlah KK Perempuan</label>
                <input type="number" name="jumlah_kk_pr" id="kk_pr" value="{{ old('jumlah_kk_pr', $phbs->jumlah_kk_pr) }}" min="0" oninput="updateKkTotal()" required>
              </div>
              <div class="kk-total-badge">
                Total KK: <span id="kk_total_display">0</span>
                <span style="font-size:12px;font-weight:400;color:darkblue;margin-left:4px">(otomatis)</span>
              </div>
            </div>
          </div>

          {{-- Tabel 13 indikator --}}
          <div class="section" style="margin: 15px;margin-top:-5px">
            <div class="section-card">
              <div class="section-head">
                <div>
                  <div class="section-title">Indikator PHBS</div>
                  <div class="section-sub">Perbarui sasaran dan capaian. Persentase dihitung otomatis per baris.</div>
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
                      @php
                        // Mencari data detail capaian sebelumnya berdasarkan id_indikator
                        $detail = $phbs->details->where('id_indikator', $ind->id_indikator)->first();
                        $sasaranLama = $detail ? $detail->jumlah_sasaran : '';
                        $capaianLama = $detail ? $detail->jumlah_capaian : 0;
                      @endphp
                      <tr class="indicator-row">
                        <td><span class="num-badge">{{ $ind->id_indikator }}</span></td>
                        <td style="font-weight:600;color:#1e3a5f">{{ $ind->nama_indikator }}</td>
                        <td style="text-align:center">
                          <input
                            type="number"
                            name="sasaran_input[{{ $ind->id_indikator }}]"
                            value="{{ old('sasaran_input.'.$ind->id_indikator, $sasaranLama) }}"
                            class="input-sm sasaran-inp"
                            min="0"
                            placeholder="{{ $ind->id_indikator <= 3 ? 'opsional' : '' }}"
                          >
                        </td>
                        <td style="text-align:center">
                          <input
                            type="number"
                            name="jumlah_input[{{ $ind->id_indikator }}]"
                            value="{{ old('jumlah_input.'.$ind->id_indikator, $capaianLama) }}"
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
              <a href="{{ route('formulir.input', ['tab' => 'history']) }}" class="btn btn-outline">
                Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
              </button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>

<script>
function updateKkTotal() {
  const lk = parseInt(document.getElementById('kk_lk').value) || 0;
  const pr = parseInt(document.getElementById('kk_pr').value) || 0;
  document.getElementById('kk_total_display').textContent = (lk + pr).toLocaleString('id-ID');
}

function updatePct(row) {
  // Jika sasaran kosong, dihitung menggunakan total KK seperti logika di controller
  let sasaran = parseFloat(row.querySelector('.sasaran-inp').value);
  if (isNaN(sasaran) || sasaran <= 0) {
      const lk = parseInt(document.getElementById('kk_lk').value) || 0;
      const pr = parseInt(document.getElementById('kk_pr').value) || 0;
      sasaran = lk + pr;
  }
  
  const capaian = parseFloat(row.querySelector('.capaian-inp').value) || 0;
  const pct = sasaran > 0 ? (capaian / sasaran) * 100 : 0;
  const pill = row.querySelector('.pct-display');
  pill.textContent = pct.toFixed(1) + '%';
  pill.className = 'pct-pill pct-display ' + (pct === 0 ? 'zero' : pct >= 80 ? 'high' : pct >= 50 ? 'mid' : 'low');
}

// Event listener saat input diubah
document.querySelectorAll('.sasaran-inp, .capaian-inp, #kk_lk, #kk_pr').forEach(inp => {
  inp.addEventListener('input', function() { 
      // Update persentase baris yang bersangkutan atau semua baris jika KK berubah
      document.querySelectorAll('.indicator-row').forEach(row => updatePct(row));
  });
});

// Jalankan otomatis saat pertama kali halaman Edit dimuat agar persentase tidak 0%
document.addEventListener('DOMContentLoaded', function() {
    updateKkTotal();
    document.querySelectorAll('.indicator-row').forEach(row => updatePct(row));
});
</script>

@endsection