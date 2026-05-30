{{-- resources/views/import/upload.blade.php --}}
@extends('layouts.app')

@section('title', 'Import Data PHBS')

@section('content')
<div style="padding:2rem;max-width:600px;margin:0 auto">

    <div style="margin-bottom:1.5rem">
        <h2 style="font-size:1.1rem;font-weight:700">Import Data PHBS dari CSV</h2>
        <p style="font-size:.8rem;color:var(--text-muted);margin-top:.25rem">
            Setelah import, peta otomatis diperbarui sesuai data terbaru.
        </p>
    </div>

    @if(session('success'))
        <div style="background:rgba(39,174,96,.15);border:1px solid #27ae60;border-radius:8px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.8rem;color:#27ae60">
            {{ session('success') }}
        </div>
    @endif

    @if(session('import_errors'))
        <div style="background:rgba(231,76,60,.1);border:1px solid #e74c3c;border-radius:8px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.78rem;color:#e74c3c">
            <b>Baris yang gagal:</b>
            <ul style="margin:.4rem 0 0 1rem">
                @foreach(session('import_errors') as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form upload --}}
    <form action="{{ route('data-phbs.import') }}" method="POST" enctype="multipart/form-data"
          style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.5rem">
        @csrf

        <div style="margin-bottom:1rem">
            <label style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:.4rem">
                Bulan
            </label>
            <select name="bulan" required style="width:100%;background:var(--bg-card2);border:1px solid var(--border);border-radius:6px;padding:.45rem .7rem;color:var(--text-primary);font-family:inherit;font-size:.82rem;outline:none">
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                    <option value="{{ $b }}" {{ $b == date('n') ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:1rem">
            <label style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:.4rem">
                Tahun
            </label>
            <input type="number" name="tahun" value="{{ date('Y') }}" min="2000" max="2100" required
                   style="width:100%;background:var(--bg-card2);border:1px solid var(--border);border-radius:6px;padding:.45rem .7rem;color:var(--text-primary);font-family:inherit;font-size:.82rem;outline:none">
        </div>

        <div style="margin-bottom:1.25rem">
            <label style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:.4rem">
                File CSV
            </label>
            <input type="file" name="file" accept=".csv,.txt" required
                   style="width:100%;background:var(--bg-card2);border:1px solid var(--border);border-radius:6px;padding:.45rem .7rem;color:var(--text-primary);font-family:inherit;font-size:.82rem">
            <p style="font-size:.68rem;color:var(--text-muted);margin-top:.35rem">
                Format kolom CSV: <code>nama_puskesmas, jumlah_kk, persalinan_nakes, asi_eksklusif, timbang_balita, air_bersih, cuci_tangan, jamban_sehat, tidak_merokok, aktivitas_fisik, makan_buah_sayur, pengelolaan_air_minum, pengelolaan_limbah, buang_sampah, pemberantasan_jentik</code>
            </p>
        </div>

        <div style="display:flex;gap:.75rem;align-items:center">
            <button type="submit"
                    style="background:linear-gradient(135deg,#0ea5e9,#38bdf8);border:none;border-radius:7px;color:#fff;font-family:inherit;font-size:.82rem;font-weight:700;padding:.55rem 1.25rem;cursor:pointer">
                <i class="fa-solid fa-file-import"></i> Import & Update Peta
            </button>
            <a href="{{ route('data-phbs.index') }}"
               style="font-size:.78rem;color:var(--text-muted);text-decoration:none">
                Batal
            </a>
        </div>
    </form>

    {{-- Panduan format CSV --}}
    <div style="margin-top:1.5rem;background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.25rem">
        <div style="font-size:.75rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">
            <i class="fa-solid fa-circle-info"></i> Panduan Format CSV
        </div>
        <ol style="font-size:.75rem;color:var(--text-dim);padding-left:1.25rem;line-height:1.8">
            <li>Baris pertama adalah header kolom (nama kolom)</li>
            <li>Kolom <code>nama_puskesmas</code> harus sama persis dengan data di database</li>
            <li>Nilai indikator diisi jumlah rumah yang <b>memenuhi</b> indikator tersebut</li>
            <li>Pisahkan kolom dengan koma (,)</li>
            <li>Satu baris = satu puskesmas</li>
        </ol>
        <a href="#" style="font-size:.72rem;color:var(--accent);text-decoration:none;display:inline-block;margin-top:.5rem">
            <i class="fa-solid fa-download"></i> Download template CSV
        </a>
    </div>

</div>
@endsection
