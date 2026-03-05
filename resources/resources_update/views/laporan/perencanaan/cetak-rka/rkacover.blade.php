<html>
<head>
<style>
    table, tr, td, th, tbody, thead, tfoot {
        border-collapse : collapse;
        font-family: Tahoma, sans-serif;
    }
    tr, th, tbody, thead, tfoot {
        page-break-inside: avoid !important;
    }
</style>
</head>
<body>


<p style="text-align:center">
   {{-- @if (check_file('logo', @$pemda->nmlogo))
		<img src="data:image/png;base64,{{ base64_encode(@file_get_contents(get_file('logo', @$pemda->nmlogo))) }}" class="header-image" alt="{{ @$pemda->nmpemda }}">
		@else
		<img src="data:image/png;base64,{{ base64_encode(asset('assetsberanda/img/logopemda.png')) }}" class="header-image" alt="Logo Pemerintah Daerah">
    @endif --}}
</p>

@foreach($model as $data)
<br>
{{-- <span style="text-align: center;"><img src="'.$image_file.'" style="height:70; width:auto;"></span> --}}
<div style="text-align: center; font-size:20px; font-weight: bold;" >{{ $data['nama_pemda'] }}</div>
<br>
<br>
<br>
<div style="text-align: center; font-size:16px; font-weight: bold;" >RENCANA KERJA ANGGARAN</div>
<div style="text-align: center; font-size:16px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</div>
<div style="text-align: center; font-size:16px; font-weight: bold;" >( RKA SKPD )</div><br><br>
<div style="text-align: center; font-size:16px; font-weight: bold;" >TAHUN ANGGARAN {{ $data['tahun'] }} </div>
<br>
<br>
<br>
<br>
<table border="0" cellpadding="2" cellspacing="0" width=100%>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >URUSAN PEMERINTAHAN</td>
        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
        <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_urusan'] }}</td>
        <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['nama_urusan'] }}</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >BIDANG URUSAN</td>
        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
        <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_bidang'] }}</td>
        <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['nama_bidang'] }}</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >ORGANISASI</td>
        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
        <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_skpd'] }}</td>
        <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_skpd'] }}</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >UNIT ORGANISASI</td>
        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
        <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_unit'] }}</td>
        <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_unit'] }}</td>
    </tr>
</table>
<br>
<br>
<table border="0" cellpadding="2" cellspacing="0" width=100%>
    <tr>
        <td width="25%" style="text-align: left; font-size:14px; font-weight: bold;" >Pengguna Anggaran</td>
        <td width="3%" style="text-align: center; font-size:14px; " >:</td>
        <td width="7%" style="text-align: left; font-size:12px; " ></td>
        <td width="65%" style="text-align: left; font-size:12px; " ></td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >a. Nama</td>
        <td width="3%" style="text-align: center; font-size:12px; " >:</td>
        <td width="72%" style="text-align: left; font-size:12px; " >.............................</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >b. N I P</td>
        <td width="3%" style="text-align: center; font-size:12px; " >:</td>
        <td width="72%" style="text-align: left; font-size:12px; " >.............................</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >c. Jabatan</td>
        <td width="3%" style="text-align: center; font-size:12px; " >:</td>
        <td width="72%" style="text-align: left; font-size:12px; " >PENGGUNA ANGGARAN</td>
    </tr>
</table>
<br>
<br>
<br>
<table border="1" cellpadding="6" cellspacing="1" width=100%>
    <tr>
        <td width="25%" style="text-align: center; font-size:12px; font-weight: bold;" >KODE</td>
        <td width="75%" style="text-align: center; font-size:12px; font-weight: bold;" >NAMA FORMULIR</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >RKA - PENDAPATAN SKPD</td>
        <td width="75%" style="text-align: justify; font-size:12px; " >Rincian Anggaran Pendapatan Satuan Kerja Perangkat Daerah</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >RKA - BELANJA SKPD</td>
        <td width="75%" style="text-align: justify; font-size:12px; " >Rincian Anggaran Belanja Satuan Kerja Perangkat Daerah</td>
    </tr>
    <tr>
        <td width="25%" style="text-align: left; font-size:12px; font-weight: bold;" >RKA - PEMBIAYAAN SKPD</td>
        <td width="75%" style="text-align: justify; font-size:12px; " >Rincian Anggaran Pembiayaan Daerah SKPD</td>
    </tr>
</table>
<br>
<br>
<br>
<table border="1" cellpadding="6" cellspacing="1" width=100%>
    <tr>
        <td width="100%" style="text-align: center; font-size:12px; font-weight: bold;" >RKA REKAPITULASI *)</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >Ringkasan APBD</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >Rekapitulasi Belanja Per Urusan</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >Rekapitulasi Belanja Per Urusan dan Program</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >Rekapitulasi Belanja Per Urusan, Program dan Kegiatan</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >Rekapitulasi Belanja Per Jenis Belanja</td>
    </tr>
</table>
<br>
<br>
<br>
<table border="0" cellpadding="2" cellspacing="0" width=100%>
    <tr>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >Disetujui Oleh</td>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >Disiapkan Oleh</td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >Pengguna Anggaran</td>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >Sub Bagian Program</td>
    </tr>
    <tr height="80">
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" ></td>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" ></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >.................................</td>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >.................................</td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >NIP .................................</td>
        <td width="50%" style="text-align: center; font-size:12px; font-weight: bold;" >NIP .................................</td>
    </tr>
</table>
<br>
<br>
<table border="0" cellpadding="2" cellspacing="6" width=100%>
    <tr>
        <td width="100%" style="text-align: left; font-size:12px; font-weight: bold;" >Keterangan :</td>
    </tr>
    <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >*) Jumlah dan jenis informasi dalam RKA REKAPITULASI dapat disesuaikan dan ditambahkan sesuai kebutuhan.</td>
    </tr>
</table>
</tbody>
@endforeach
</body>
