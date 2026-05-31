<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP PHBS</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-56 bg-[#1e3a8a] text-white flex flex-col p-5">

        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-10">

            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">

                <i class="fa-solid fa-heart-pulse text-xl"></i>

            </div>

            <div>

                <h1 class="text-xl font-bold">
                    SIP-PHBS
                </h1>

                <p class="text-xs text-blue-100">
                    Sistem Informasi Pelaporan PHBS
                </p>

            </div>

        </div>

        <!-- MENU -->
        <nav class="space-y-2">

            <a href="{{ route('phbs.create') }}"
            class="flex items-center gap-3 bg-yellow-400 text-slate-900 px-4 py-3 rounded-2xl font-semibold shadow">

                <i class="fa-solid fa-file-pen"></i>

                Input PHBS

            </a>

            <a href="{{ route('phbs.history') }}"
            class="flex items-center gap-3 hover:bg-white/10 px-4 py-3 rounded-2xl transition">

                <i class="fa-solid fa-clock-rotate-left"></i>

                History

            </a>

        </nav>

        <!-- CARD -->
        <div class="mt-auto bg-white/10 rounded-3xl p-4">

            <h3 class="font-semibold mb-2 text-sm">
                Sistem PHBS
            </h3>

            <p class="text-xs text-blue-100 leading-relaxed">
                Pelaporan indikator PHBS seluruh Puskesmas Kabupaten Sleman.
            </p>

        </div>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6 overflow-y-auto">

        <!-- HEADER -->
        <div class="bg-white rounded-3xl p-6 shadow-sm mb-5">

            <h1 class="text-3xl font-bold text-slate-800">
                Input Data PHBS
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Input laporan indikator PHBS per Puskesmas
            </p>

        </div>

        <!-- ALERT -->
        @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-2xl mb-5">

            {{ session('success') }}

        </div>

        @endif

        @if($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-2xl mb-5">

            {{ $errors->first() }}

        </div>

        @endif

        <!-- TAB -->
        <div class="flex gap-3 mb-5">

            <button type="button"
            onclick="showManual()"
            id="manualBtn"
            class="bg-[#1e3a8a] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow">

                <i class="fa-solid fa-keyboard mr-2"></i>
                Input Manual

            </button>

            <button type="button"
            onclick="showImport()"
            id="excelBtn"
            class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold">

                <i class="fa-solid fa-file-excel mr-2 text-green-600"></i>
                Import Excel

            </button>

        </div>

        <!-- ================= MANUAL ================= -->
        <div id="manualBox">

        <form method="POST"
        action="{{ route('phbs.store') }}">

        @csrf

        <!-- INFORMASI -->
        <div class="bg-white rounded-3xl shadow-sm p-5 mb-5">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Informasi Laporan
                    </h2>

                    <p class="text-slate-500 text-sm">
                        Lengkapi data utama laporan
                    </p>

                </div>

                <div class="bg-blue-100 text-[#1e3a8a] text-xs font-semibold px-3 py-2 rounded-full">

                    Data Utama

                </div>

            </div>

            <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-4">

                <!-- PUSKESMAS -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Puskesmas
                    </label>

                    <select name="id_puskesmas"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

                        <option value="">
                            Pilih Puskesmas
                        </option>

                        @foreach($puskesmas as $item)

                        <option value="{{ $item->id_puskesmas }}">

                            {{ $item->nama_puskesmas }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <!-- BULAN -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Bulan
                    </label>

                    <select name="bulan"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>

                    </select>

                </div>

                <!-- TAHUN -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tahun
                    </label>

                    <input type="number"
                    name="tahun"
                    value="2026"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

                </div>

                <!-- JUMLAH KK -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah KK
                    </label>

                    <input type="number"
                    name="jumlah_kk"
                    value="0"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

                </div>

            </div>

        </div>

        <!-- INDIKATOR -->
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <!-- HEADER -->
            <div class="bg-[#1e3a8a] px-6 py-4 text-white">

                <div class="flex justify-between items-center">

                    <div>

                        <h2 class="text-xl font-bold">
                            13 Indikator PHBS
                        </h2>

                        <p class="text-blue-100 text-sm">
                            Input sasaran dan capaian
                        </p>

                    </div>

                    <div class="bg-white/10 px-3 py-2 rounded-xl text-xs">

                        Auto Persentase

                    </div>

                </div>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-100 text-slate-700">

                        <tr>

                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Indikator</th>
                            <th class="px-4 py-3 text-center">Sasaran</th>
                            <th class="px-4 py-3 text-center">Capaian</th>
                            <th class="px-4 py-3 text-center">%</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

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

                        <tr class="hover:bg-slate-50 transition">

                            <!-- NOMOR -->
                            <td class="px-4 py-3">

                                <div class="w-8 h-8 rounded-xl bg-[#1e3a8a] text-white text-xs font-bold flex items-center justify-center">

                                    {{ $key + 1 }}

                                </div>

                            </td>

                            <!-- INDIKATOR -->
                            <td class="px-4 py-3 text-slate-700 font-medium">

                                {{ $item }}

                            </td>

                            <!-- SASARAN -->
                            <td class="px-4 py-3 text-center">

                                <input type="number"
                                name="sasaran_input[{{ $key+1 }}]"
                                value="0"
                                class="w-20 border border-slate-200 rounded-lg px-2 py-2 text-center text-sm focus:ring-2 focus:ring-blue-200 outline-none sasaran">

                            </td>

                            <!-- CAPAIAN -->
                            <td class="px-4 py-3 text-center">

                                <input type="number"
                                name="jumlah_input[{{ $key+1 }}]"
                                value="0"
                                class="w-20 border border-slate-200 rounded-lg px-2 py-2 text-center text-sm focus:ring-2 focus:ring-blue-200 outline-none jumlah">

                            </td>

                            <!-- PERSENTASE -->
                            <td class="px-4 py-3 text-center">

                                <span class="percent font-bold text-[#1e3a8a]">

                                    0%

                                </span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- FOOTER -->
            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">

                <button type="reset"
                class="bg-slate-200 hover:bg-slate-300 transition px-5 py-2.5 rounded-xl text-sm font-semibold">

                    Reset

                </button>

                <button type="submit"
                class="bg-[#1e3a8a] hover:bg-[#172554] transition text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow">

                    <i class="fa-solid fa-floppy-disk mr-2"></i>

                    Simpan

                </button>

            </div>

        </div>

        </form>

        </div>

        <!-- ================= IMPORT EXCEL ================= -->
        <div id="importBox" class="hidden">

            <div class="bg-white rounded-3xl shadow-sm p-10">

                <div class="text-center">

                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">

                        <i class="fa-solid fa-file-excel text-4xl text-green-600"></i>

                    </div>

                    <h2 class="text-2xl font-bold text-slate-800 mb-2">

                        Upload Excel PHBS

                    </h2>

                    <p class="text-slate-500 text-sm mb-8">

                        Import file Excel format .xlsx / .xls

                    </p>

                </div>

                <form method="POST"
                action="#"
                enctype="multipart/form-data">

                    @csrf

                    <div class="border-2 border-dashed border-slate-300 rounded-3xl p-10 text-center bg-slate-50">

                        <input type="file"
                        name="file"
                        class="mb-5 text-sm">

                        <br>

                        <button type="submit"
                        class="bg-[#1e3a8a] hover:bg-[#172554] transition text-white px-6 py-3 rounded-xl text-sm font-semibold shadow">

                            <i class="fa-solid fa-upload mr-2"></i>

                            Upload Excel

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

<!-- SCRIPT -->
<script>

function showImport(){

    document.getElementById('manualBox')
    .classList.add('hidden');

    document.getElementById('importBox')
    .classList.remove('hidden');

    document.getElementById('manualBtn')
    .className =
    "bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold";

    document.getElementById('excelBtn')
    .className =
    "bg-[#1e3a8a] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow";

}

function showManual(){

    document.getElementById('manualBox')
    .classList.remove('hidden');

    document.getElementById('importBox')
    .classList.add('hidden');

    document.getElementById('manualBtn')
    .className =
    "bg-[#1e3a8a] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow";

    document.getElementById('excelBtn')
    .className =
    "bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold";

}

// HITUNG %
document.querySelectorAll('.sasaran, .jumlah').forEach(input => {

    input.addEventListener('input', function(){

        let row = this.closest('tr');

        let sasaran =
        parseInt(row.querySelector('.sasaran').value) || 0;

        let jumlah =
        parseInt(row.querySelector('.jumlah').value) || 0;

        let persen = 0;

        if(sasaran > 0){

            persen = (jumlah / sasaran) * 100;

        }

        row.querySelector('.percent').innerHTML =
        persen.toFixed(1) + '%';

    });

});

</script>

</body>
</html>