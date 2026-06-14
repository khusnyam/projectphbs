<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/dinkes.beranda.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/puskesmas.dashboard.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/dinkes.dashboard.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/laporan.css') }}"> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Link ke style.css gabungan Anda --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/dinkes.beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulir.css') }}">
    
</head>
<body>

    
{{-- <div class="flex"> --}}
<aside class="sidebar">
    {{-- DEBUG SEMENTARA - hapus setelah selesai --}}
<div style="background:#fee;padding:8px;font-size:12px;">
    id_role   : {{ auth()->user()->id_role }} ({{ gettype(auth()->user()->id_role) }})<br>
    isPuskesmas: {{ auth()->user()->isPuskesmas() ? 'TRUE' : 'FALSE' }}<br>
    @can('akses-puskesmas') Gate: ✅ LOLOS @else Gate: ❌ GAGAL @endcan
</div>
    <div class="sb-brand">
        <div class="sb-logo">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
            </svg>
        </div>
        <div class="sb-name">
            <strong>SIP-PHBS</strong>
            <span>Sistem Informasi PHBS Sleman</span>
        </div>
    </div>

    <div class="sb-section">
        <span class="sb-label">Menu Utama</span>
        @can('akses-dinkes')
        <a href="{{ route('beranda') }}" class="sb-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>


        <a href="{{ route('dashboard.phbs') }}" class="sb-item {{ request()->routeIs('dashboard.phbs') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          Analisis Indikator
        </a>

        <a href="{{ route('phbs.index') }}" class="sb-item {{ request()->routeIs('phbs.index') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          Laporan
        </a>

        <a href="{{ route('peta.index') }}" class="sb-item {{ request()->routeIs('peta.index') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          Peta
        </a>
        @endcan

        @can('akses-puskesmas')
        <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          Dashboard Puskesmas
        </a>

        <a href="{{ route('formulir.input') }}" class="sb-item {{ request()->routeIs('formulir.input') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          Input Puskesmas
        </a>
        @endcan


        {{-- @if(\Illuminate\Support\Facades\Route::has('phbs.index'))
        <a href="{{ route('phbs.index') }}" class="sb-item {{ request()->routeIs('phbs.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            Laporan Rekapitulasi
        </a>
        @endif

        @if(\Illuminate\Support\Facades\Route::has('peta.index'))
        <a href="{{ route('peta.index') }}" class="sb-item {{ request()->routeIs('peta.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Peta Sebaran
        </a>
        @endif --}}
    </div>

    <div class="sb-section">
        <span class="sb-label">Akun</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-item">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

    @php
$authUser = auth()->user();
$userName = $authUser->name ?? 'Guest';
$userRole = $authUser
    ? ($authUser->id_role == 1 ? 'Dinas Kesehatan' : ($authUser->id_role == 2 ? 'Puskesmas' : 'Role Tidak Dikenal'))
    : 'Tamu';
@endphp

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr($userName, 0, 1)) }}</div>
            <div class="sb-user-info">
                <strong>{{ $userName }}</strong>
                <span>{{ $userRole }}</span>
            </div>
        </div>
    </div>
</aside>

<div class="hero" style="position: sticky; top: 0; z-index: 999; background-color: #1058c4;">
    @yield('top')
</div>

<main class="main">
    @yield('content')
</main>
{{-- </div> --}}
</body>
</html>
