@extends('layouts.sidebar')
@section('title','Pelaporan - SIP-PHBS')
@section('top')
  {{-- HERO --}}
    <div class="hero-left">
      <div class="hero-title">
        Laporan Rekapitulasi PHBS
      </div>
      <div class="hero-desc">
        Laporan tahun {{ $tahun }}
      </div>
    </div>
    <div class="hero-badges">
        <span class="hero-badge">
          <a href="{{ route('formulir.export_history', request()->query()) }}"
           class="btn btn-export" style="padding:3px 10px;font-size:12px">
          <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
        </span>        
    </div>
@endsection
@section('content')

{{-- MAIN --}}
<div class="main">
  <div class="page-wrap">

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

    {{-- FILTER --}}
    <div class="filter-section" style="margin: 10px -25px 10px -25px;">
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
    <div class="section-card">
      <div class="section-head">
        <div class="section-title">
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
              <td style="color:var(--text-muted);font-size:12px">{{ $row->bulan ?? '-' }}</td>
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

@endsection