<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History PHBS</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-56 bg-[#1e3a8a] text-white flex flex-col p-5">

    <div class="flex items-center gap-3 mb-10">
        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">
            <i class="fa-solid fa-heart-pulse text-xl"></i>
        </div>

        <div>
            <h1 class="text-xl font-bold">SIP-PHBS</h1>
            <p class="text-xs text-blue-100">Sistem Informasi Pelaporan PHBS</p>
        </div>
    </div>

    <nav class="space-y-2">

        <a href="{{ route('phbs.create') }}"
           class="flex items-center gap-3 hover:bg-white/10 px-4 py-3 rounded-2xl transition">
            <i class="fa-solid fa-file-pen"></i>
            Input PHBS
        </a>

        <a href="{{ route('phbs.history') }}"
           class="flex items-center gap-3 bg-yellow-400 text-slate-900 px-4 py-3 rounded-2xl font-semibold shadow">
            <i class="fa-solid fa-clock-rotate-left"></i>
            History
        </a>

    </nav>
</aside>

<!-- MAIN -->
<main class="flex-1 p-6">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl p-6 shadow-sm mb-5">
        <h1 class="text-3xl font-bold text-slate-800">
            History Monitoring PHBS
        </h1>
        <p class="text-slate-500 mt-1">
            Rekap Data PHBS per Puskesmas
        </p>
    </div>

    <!-- FILTER -->
<div class="bg-white rounded-3xl p-5 shadow-sm mb-5">

    <form method="GET" action="{{ route('phbs.history') }}">

        <div class="grid md:grid-cols-3 gap-4">

            <!-- BULAN -->
            <select name="bulan" class="border rounded-xl px-4 py-3">
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

            <!-- TAHUN -->
            <input type="number"
                   name="tahun"
                   placeholder="Tahun"
                   class="border rounded-xl px-4 py-3">

            <button type="submit"
                    class="bg-[#1e3a8a] text-white rounded-xl px-4 py-3">
                Filter
            </button>

        </div>

    </form>

</div>

    <!-- DATA -->
    <div class="space-y-5">

        @forelse($data as $item)

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <!-- HEADER CARD -->
            <div class="bg-gradient-to-r from-[#1e3a8a] to-[#2563eb] text-white p-6">

                <div class="flex justify-between items-center">

                    <div>
                        <h2 class="text-xl font-bold">
                            {{ $item->puskesmas->nama_puskesmas ?? '-' }}
                        </h2>

                        <p class="text-blue-100 text-sm">
                            {{ $item->bulan }} {{ $item->tahun }}
                        </p>
                    </div>

                    <div class="bg-white/20 px-4 py-2 rounded-full text-sm">
                        {{ $item->kategori_phbs }}
                    </div>

                </div>
            </div>

            <!-- BODY -->
            <div class="p-6">

                <!-- INFO -->
                <div class="grid md:grid-cols-3 gap-4 mb-6">

                    <div class="bg-slate-50 rounded-2xl p-5 text-center">
                        <p class="text-sm text-slate-500">Jumlah KK</p>
                        <h3 class="text-3xl font-bold">{{ $item->jumlah_kk }}</h3>
                    </div>

                    @php
$totalIndikator = 13;

$terpenuhi = $item->details->where('jumlah_capaian', '>', 0)->count();

$persentaseTotal = $totalIndikator > 0
    ? ($terpenuhi / $totalIndikator) * 100
    : 0;
@endphp

<div class="bg-slate-50 rounded-2xl p-5 text-center">

    <p class="text-sm text-slate-500">
        Capaian PHBS (Indikator Terpenuhi)
    </p>

    <h3 class="text-3xl font-bold text-[#1e3a8a]">
        {{ $terpenuhi }} / {{ $totalIndikator }}
    </h3>

    <p class="text-sm text-slate-500 mt-1">
        {{ number_format($persentaseTotal,1) }}%
    </p>

</div>

                    <div class="bg-slate-50 rounded-2xl p-5 text-center">
                        <p class="text-sm text-slate-500">Kategori</p>
                        <h3 class="text-3xl font-bold text-[#1e3a8a]">
                            {{ $item->kategori_phbs }}
                        </h3>
                    </div>

                </div>

                <!-- TOTAL RATA-RATA PHBS -->
                <div class="bg-slate-50 rounded-2xl p-5 mb-6 text-center">
                    <p class="text-sm text-slate-500">Rata-rata Capaian PHBS</p>
                    <h2 class="text-3xl font-bold text-[#1e3a8a]">
                        {{ round($item->details->avg('persentase'),1) }}%
                    </h2>
                </div>

        

                   <!-- DETAIL INDIKATOR GRID -->
<div class="grid md:grid-cols-2 gap-4 mt-4">

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

@foreach($item->details as $detail)

<div class="bg-slate-50 rounded-2xl p-4 border">

    <div class="flex justify-between mb-2">

        <span class="text-sm font-medium text-slate-700">
            {{ $namaIndikator[$detail->id_indikator] ?? '-' }}
        </span>

        <span class="text-sm font-bold text-[#1e3a8a]">
            {{ $detail->persentase }}%
        </span>

    </div>

    <div class="w-full bg-slate-200 rounded-full h-2">
        <div class="bg-[#1e3a8a] h-2 rounded-full"
             style="width: {{ $detail->persentase }}%">
        </div>
    </div>

</div>

@endforeach

</div>


<!-- ========================= -->
<!-- TABEL REKAP (FIX FINAL) -->
<!-- ========================= -->

<div class="mt-6 overflow-x-auto">

<table class="w-full text-sm border">

    <thead class="bg-slate-100">
        <tr>
            <th class="px-4 py-2 text-left">Indikator</th>
            <th class="px-4 py-2 text-center">Sasaran</th>
            <th class="px-4 py-2 text-center">Capaian</th>
            <th class="px-4 py-2 text-center">Persentase</th>
        </tr>
    </thead>

    <tbody>

    @foreach($item->details as $detail)

        <tr class="border-t">

            <td class="px-4 py-2">
                {{ $namaIndikator[$detail->id_indikator] ?? '-' }}
            </td>

            <td class="px-4 py-2 text-center">
                {{ $detail->jumlah_sasaran }}
            </td>

            <td class="px-4 py-2 text-center font-semibold">
                {{ $detail->jumlah_capaian }}
            </td>

            <td class="px-4 py-2 text-center text-[#1e3a8a] font-bold">
                {{ $detail->persentase }}%
            </td>

        </tr>

    @endforeach

    </tbody>

</table>

</div>

                <!-- AKSI -->
                <div class="flex justify-end gap-2 mt-6">

                    <a href="{{ route('phbs.edit', $item->id_phbs) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm">
                        Edit
                    </a>

                    <form id="deleteForm{{ $item->id_phbs }}"
                          action="{{ route('phbs.destroy', $item->id_phbs) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                                onclick="openDeleteModal({{ $item->id_phbs }})"
                                class="bg-red-600 text-white px-4 py-2 rounded-xl text-sm">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @empty

        <div class="bg-white p-10 text-center rounded-3xl">
            Data tidak ditemukan
        </div>

        @endforelse

    </div>
</main>

</div>


<!-- MODAL DELETE -->
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-3xl w-full max-w-md">

        <h2 class="text-xl font-bold mb-4">Hapus Data?</h2>

        <div class="flex justify-end gap-3">

            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-slate-200 rounded-xl">
                Batal
            </button>

            <button id="confirmDeleteBtn"
                    class="px-4 py-2 bg-red-600 text-white rounded-xl">
                Hapus
            </button>

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
