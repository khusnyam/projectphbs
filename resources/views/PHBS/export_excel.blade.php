<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel">
<head><meta charset="UTF-8">
<style>
body{font-family:Arial,sans-serif;font-size:10pt}
table{border-collapse:collapse;width:100%}
th,td{border:1px solid #999;padding:4px 7px;font-size:9pt}
.t1{font-size:13pt;font-weight:bold;text-align:center;border:none}
.t2{font-size:10pt;text-align:center;border:none}
.th1{background:#0a2e1a;color:#fff;font-weight:bold;text-align:center}
.th2{background:#16a34a;color:#fff;font-weight:bold;text-align:center}
.tr{text-align:right}.tc{text-align:center}.tb{font-weight:bold}
.total{background:#dcfce7;font-weight:bold}
</style>
</head>
<body>
@php
$inds=[1=>'Persalinan Nakes',2=>'ASI Eksklusif',3=>'Timbang Balita',
       4=>'Air Bersih',5=>'CTPS',6=>'Kelola Air Minum',
       7=>'Jamban Sehat',8=>'Limbah Cair',9=>'Tempat Sampah',
       10=>'Bebas Jentik',11=>'Sayur & Buah',12=>'Aktivitas Fisik',13=>'Tdk Merokok'];
$cols = 7 + count($inds)*2 + 2;
$tL=$tP=$tT=$tBer=0;
foreach($laporan as $r){$tL+=$r->jumlah_kk_total_l;$tP+=$r->jumlah_kk_total_p;$tT+=$r->jumlah_kk_total_total;$tBer+=$r->ber_phbs;}
$avg = $tT>0 ? round(($tBer/$tT)*100,2) : 0;
@endphp
<table>
  <tr><td colspan="{{ $cols }}" class="t1">REKAPITULASI HASIL PEMANTAUAN PHBS TATANAN RUMAH TANGGA</td></tr>
  <tr><td colspan="{{ $cols }}" class="t2">KABUPATEN SLEMAN TAHUN {{ $tahun }}{{ $bulan?' – '.($namaBulan[$bulan]??''):'' }}</td></tr>
  <tr><td colspan="{{ $cols }}" style="border:none">&nbsp;</td></tr>
  <tr>
    <th class="th1" rowspan="3">No</th>
    <th class="th1" rowspan="3">Puskesmas</th>
    <th class="th1" rowspan="3">Bulan</th>
    <th class="th1" rowspan="3">Tahun</th>
    <th class="th1" colspan="3">Jumlah KK</th>
    @foreach($inds as $n=>$nm)<th class="th2" colspan="2">Ind.{{ $n }}</th>@endforeach
    <th class="th1" rowspan="3">Ber-PHBS</th>
    <th class="th1" rowspan="3">% PHBS</th>
  </tr>
  <tr>
    <th class="th2">L</th><th class="th2">P</th><th class="th2">Total</th>
    @foreach($inds as $n=>$nm)<th class="th2" colspan="2">{{ $nm }}</th>@endforeach
  </tr>
  <tr>
    <th class="th2">&nbsp;</th><th class="th2">&nbsp;</th><th class="th2">&nbsp;</th>
    @foreach($inds as $n=>$nm)<th class="th2">Ssrn</th><th class="th2">Jml</th>@endforeach
  </tr>
  @foreach($laporan as $i=>$row)
  <tr>
    <td class="tc">{{ $i+1 }}</td>
    <td class="tb">{{ $row->nama_puskesmas }}</td>
    <td class="tc">{{ $namaBulan[$row->bulan]??'-' }}</td>
    <td class="tc">{{ $row->tahun }}</td>
<<<<<<< Updated upstream
    <td class="tr">{{ number_format($row->jumlah_kk_l) }}</td>
    <td class="tr">{{ number_format($row->jumlah_kk_p) }}</td>
    <td class="tr tb">{{ number_format($row->jumlah_kk_total) }}</td>
    {{-- @for($n=1;$n<=13;$n++)
=======
    <td class="tr">{{ number_format($row->jumlah_kk_total_l) }}</td>
    <td class="tr">{{ number_format($row->jumlah_kk_total_p) }}</td>
    <td class="tr tb">{{ number_format($row->jumlah_kk_total_total) }}</td>
    @for($n=1;$n<=13;$n++)
>>>>>>> Stashed changes
      <td class="tr">{{ number_format($row->{'ind'.$n.'_sasaran'}) }}</td>
      <td class="tr">{{ number_format($row->{'ind'.$n.'_jumlah'}) }}</td>
    @endfor --}}
    <td class="tr tb">{{ number_format($row->ber_phbs) }}</td>
    <td class="tr tb">{{ number_format($row->persen_phbs,2) }}%</td>
  </tr>
  @endforeach
  <tr class="total">
    <td colspan="4" class="tc">TOTAL</td>
    <td class="tr">{{ number_format($tL) }}</td>
    <td class="tr">{{ number_format($tP) }}</td>
    <td class="tr">{{ number_format($tT) }}</td>
    {{-- @for($n=1;$n<=13;$n++)
      <td class="tr">{{ number_format($laporan->sum('ind'.$n.'_sasaran')) }}</td>
      <td class="tr">{{ number_format($laporan->sum('ind'.$n.'_jumlah')) }}</td>
    @endfor --}}
    <td class="tr">{{ number_format($tBer) }}</td>
    <td class="tr">{{ number_format($avg,2) }}%</td>
  </tr>
</table>
</body></html>