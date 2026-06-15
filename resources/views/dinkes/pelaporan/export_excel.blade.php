<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 5px 8px; font-size: 9pt; }
        .title-1 { font-size: 14pt; font-weight: bold; text-align: center; border: none; }
        .title-2 { font-size: 11pt; text-align: center; border: none; }
        .th-header { background: #0a2e1a; color: #fff; font-weight: bold; text-align: center; }
        .th-sub { background: #16a34a; color: #fff; font-weight: bold; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-total { background: #dcfce7; font-weight: bold; }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="{{ 9 + ($allIndikator->count() * 2) }}" class="title-1">
                LAPORAN RIWAYAT / HISTORY DATA PHBS TATANAN RUMAH TANGGA
            </td>
        </tr>
        <tr>
            <td colspan="{{ 9 + ($allIndikator->count() * 2) }}" class="title-2">
                Puskesmas: {{ $currentPuskesmas ? $currentPuskesmas->nama_puskesmas : 'Semua Wilayah Puskesmas' }}
            </td>
        </tr>
        <tr></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="th-header">No</th>
                <th rowspan="2" class="th-header">Nama Puskesmas</th>
                <th rowspan="2" class="th-header">Bulan</th>
                <th rowspan="2" class="th-header">Tahun</th>
                <th colspan="3" class="th-header">Jumlah KK</th>
                @foreach($allIndikator as $ind)
                    <th colspan="2" class="th-header">{{ $ind->nama_indikator }} ({{ $ind->kode_indikator ?? 'I-'.$ind->id_indikator }})</th>
                @endforeach
                <th rowspan="2" class="th-header">Ber PHBS</th>
                <th rowspan="2" class="th-header">Persen PHBS</th>
                <th rowspan="2" class="th-header">Kategori</th>
            </tr>
            <tr>
                <th class="th-sub">L</th>
                <th class="th-sub">P</th>
                <th class="th-sub">Total</th>
                @foreach($allIndikator as $ind)
                    <th class="th-sub">Saran</th>
                    <th class="th-sub">Capai</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($historyData as $index => $row)
                @php
                    $totalKk = $row->jumlah_kk_lk + $row->jumlah_kk_pr;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row->puskesmas->nama_puskesmas ?? '-' }}</td>
                    <td class="text-center">{{ $row->bulan }}</td>
                    <td class="text-center">{{ $row->tahun }}</td>
                    <td class="text-right">{{ $row->jumlah_kk_lk }}</td>
                    <td class="text-right">{{ $row->jumlah_kk_pr }}</td>
                    <td class="text-right font-bold">{{ $totalKk }}</td>
                    
                    @foreach($allIndikator as $ind)
                        @php
                            // Cari data detail yang sesuai dengan id_indikator baris ini
                            $detail = $row->details->firstWhere('id_indikator', $ind->id_indikator);
                        @endphp
                        <td class="text-right" style="color: #666;">{{ $detail ? ($detail->jumlah_sasaran ?? $totalKk) : '-' }}</td>
                        <td class="text-right font-bold">{{ $detail ? $detail->jumlah_capaian : 0 }}</td>
                    @endforeach

                    <td class="text-right font-bold" style="background:#f0fdf4;">{{ $row->ber_phbs }}</td>
                    <td class="text-right font-bold" style="background:#f0fdf4;">{{ number_format($row->persen_phbs, 2) }}%</td>
                    <td class="text-center font-bold">{{ $row->kategori_phbs }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 9 + ($allIndikator->count() * 2) }}" class="text-center" style="padding: 20px; color: #999;">
                        Tidak ada data history yang tersedia untuk diexport.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>