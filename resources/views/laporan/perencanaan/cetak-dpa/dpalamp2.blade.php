<html>
    <head>
        <style>
            tr,
            td,
            th,
            tbody,
            thead,
            tfoot {
                font-family: Tahoma, sans-serif;
                page-break-inside: avoid !important;
                padding-left: 5px;
                padding-right: 5px;
            }

            table {
                border-collapse: collapse;
            }

        </style>
    </head>
<?php

if($idjnsdokumen_req==2){ ?>
<body>
@foreach($model as $data)
<br>
<table border="1" cellpadding="4" width="100%">
<tr>
    <td width="75%"  align="center" vertical-align="middle">
        <table border="0" width="100%">
            <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >DOKUMEN PELAKSANAAN ANGGARAN</td></tr>
            <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
        </table>
    </td>
    <td width="25%" rowspan="2"  align="center" vertical-align="middle">
        <table border="0" width="100%">
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >FORMULIR DPA-</td></tr>
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >PENDAPATAN SKPD</td></tr>
        </table>
    </td>
</tr>
<tr>
    <td width="60%" align="center" vertical-align="middle">
        <table border="0" width="100%">
            <tr><td style="text-align: center; font-size:14px; font-weight: bold; text-transform:uppercase;" >{{ $data['nama_pemda'] }}</td></tr>
            <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >TAHUN ANGGARAN {{ $data['tahun'] }}</td></tr>
        </table>
    </td>
</tr>
</table>
<table border="" cellpadding="2" width="100%">
<tr>
    <td>
        <table border="0" cellpadding="2" cellspacing="0">
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >ORGANISASI</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_skpd'] }}</td>
                <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_skpd'] }}</td>
            </tr>
            @if($data['kode_unit'] != NULL)
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >UNIT ORGANISASI</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_unit'] }}</td>
                    <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_unit'] }}</td>
                </tr>
            @endif
        </table>
    </td>
</tr>
<tr>
    <td>
        <table border="0" cellpadding="2" width="100%">
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN DOKUMEN PELAKSANAAN ANGGARAN PENDAPATAN</td></tr>
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
        </table>
    </td>
</tr>
</table>
<table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <thead>
        <tr height=19>
            <td width="10%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >KODE REKENING</td>
            <td width="30%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >URAIAN</td>
            <td width="45%" colspan="3" style="font-size:12px; text-align: center; font-weight: bold;" >RINCIAN PERHITUNGAN</td>
            <td width="15%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >JUMLAH (Rp) </td>
        </tr>
        <tr height=19>
            <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Volume/Koefisien</td>
            <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Satuan</td>
            <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Tarif/Harga</td>
        </tr>
    </thead>
    <tbody>
        @if($data['rek_1'] != NULL)
        @foreach ($data['rek_1'] as $rek1)
            <tr>
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek1['kode_rekening'] }}</td>
                <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek1['nama_rekening'] }}</td>
                <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek1['jumlah'], 2, ',', '.') }}</td>
            </tr>
            @foreach ($rek1['rek_2'] as $rek2)
                <tr>
                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek2['kode_rekening'] }}</td>
                    <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek2['nama_rekening'] }}</td>
                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek2['jumlah'], 2, ',', '.') }}</td>
                </tr>
                @foreach ($rek2['rek_3'] as $rek3)
                    <tr>
                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek3['kode_rekening'] }}</td>
                        <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek3['nama_rekening'] }}</td>
                        <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                        <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                        <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                        <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek3['jumlah'], 2, ',', '.') }}</td>
                    </tr>
                    @foreach ($rek3['rek_4'] as $rek4)
                        <tr>
                            <td width="10%" style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek4['kode_rekening'] }}</td>
                            <td width="30%" style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek4['nama_rekening'] }}</td>
                            <td width="15%" style="font-size:12px;  text-align: left; font-weight: semibold;"></td>
                            <td width="15%" style="font-size:12px;  text-align: left; font-weight: semibold;"></td>
                            <td width="15%" style="font-size:12px;  text-align: right; font-weight: semibold;"></td>
                            <td width="15%" style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek4['jumlah'], 2, ',', '.') }}</td>
                        </tr>
                        @foreach ($rek4['rek_5'] as $rek5)
                            <tr>
                                <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek5['kode_rekening'] }}</td>
                                <td width="30%" style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek5['nama_rekening'] }}</td>
                                <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal;"></td>
                                <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal;"></td>
                                <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal;"></td>
                                <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek5['jumlah'], 2, ',', '.') }}</td>
                            </tr>
                            @foreach ($rek5['rek_6'] as $rek6)
                                <tr>
                                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;">{{ $rek6['kode_rekening'] }}</td>
                                    <td width="30%" style="font-size:12px;  text-align: justify; font-weight: normal; font-style:normal;">{{ $rek6['nama_rekening'] }}</td>
                                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;">{{ number_format($rek6['volume'], 2, ',', '.') }}</td>
                                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;">{{ $rek6['satuan'] }}</td>
                                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:normal;">{{ number_format($rek6['harga'], 2, ',', '.') }}</td>
                                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:normal;">{{ number_format($rek6['jumlah'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
        @else
        <tr>
            <td colspan="6" style="font-size:12px;  text-align: center; font-weight: bold;">TIDAK ADA DATA</td>
        </tr>
        @endif
    </tbody>
</table>

{{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Realisasi Pendapatan per Bulan *)</td>
        <td style="border-right:0px solid black;border-top:0px solid black;text-align: center; width:30%; font-size:12px;">{{ $data['nmibukota'] }}, {{ date_indo($tgl_ttd) }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; width:7%; font-size:12px;" >Januari</td>
        <td style="border:0px solid black;text-align: right; width:18%; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jan,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Pengguna Anggaran</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Februari</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_feb,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PAjab']}}</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Maret</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mar,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >April</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_apr,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Mei</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mei,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PAnama']}}</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{$data['PAnip']}}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Juli</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jul,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Agustus</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_aug,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Mengesahkan,</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >September</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_sep,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >PPKD</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Oktober</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_okt,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >November</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_nov,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Desember</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
            Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_des,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PPKDnama']}}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >Jumlah</td>
        <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >
            <?php $totalpenerimaan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
            +$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
            +$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
            +$data['query_penerimaan_penarikan'][0]->total_des; ?>
            Rp. {{format_money($totalpenerimaan,2)}}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{$data['PPKDnip']}}</td>
    </tr>

</table>

<table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
    {{-- <tr><td colspan="5"><br>
        <table style="font-size:12px; font-weight: bold;" width="100%">
			<tr><td width="60%"></td><td width="40%" style="text-align: center; font-weight: normal;">{{ $kota }}, {{ date_indo($tgl_ttd) }}</td></tr>
			<tr><td width="60%"></td><td width="40%" style="text-align: center;">Kepala SKPD</td></tr>
			<tr><td height="60"></td></tr>
			<tr><td width="60%"></td><td width="40%" style="text-align: center;">.............................</td></tr>
			<tr><td width="60%"></td><td width="40%" style="text-align: center;">NIP .......................</td></tr>
		</table>
	</td></tr>

    {<tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: bold;">Pembahasan </td></tr>
    <tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Tanggal :</td></tr>
    <tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Catatan :</td></tr>
    <tr height="100"><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td></tr>


    <tr height="20"><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td></tr>

    <tr><td colspan="5" style="font-size:12px; text-align: center; font-weight: bold;">Tim Anggaran Pemerintah Daerah</td></tr>
    <tr>
        <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">No</td>
        <td width="25" style="font-size:12px; text-align: center; font-weight: bold;">Nama</td>
        <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">NIP</td>
        <td width="30%" style="font-size:12px; text-align: center; font-weight: bold;">Jabatan</td>
        <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">Tanda Tangan</td>
    </tr>
    <?php
    if(count($data['ambiltapd'])){
    $nouruttapd=1;
    $jumlahloop=count($data['ambiltapd']);
    ?>
	<?php for($i=0;$i<$jumlahloop;$i++) { ?>

	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >{{$nouruttapd}}</td>
	<td style="width:35%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nama}}</td>
	<td style="width:20%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nip}}</td>
	<td style="width:25%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nmjabatan}}</td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<?php $nouruttapd=$nouruttapd+1; ?>
	<?php } }else{ ?>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >1.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >2.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >3.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >4.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >5.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<tr>
	<td style="width:5%;text-align: center; font-size:12px;" >6.</td>
	<td style="width:35%;text-align: left; font-size:12px;" ></td>
	<td style="width:20%;text-align: left; font-size:12px;" ></td>
	<td style="width:25%;text-align: left; font-size:12px;" ></td>
	<td style="width:15%;text-align: left; font-size:12px;" ></td>
	</tr>
	<?php } ?>
	</table>
	<br>
	<table border="0" cellpadding="2" cellspacing="6" width=100%>
		<tr>
		<td width="100%" style="text-align: justify; font-size:12px; " >*) Sesuai periodisasi SPD</td>
		</tr>
	</table>--}}
@endforeach
</body>
<?php }//tutup jika idjnsdokumen=26
else{
?>
<body>
    @foreach($model as $data)
    <br>
    <table border="1" cellpadding="4" width="100%">
    <tr>
        <td width="75%"  align="center" vertical-align="middle">
            <table border="0" width="100%">
                <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN</td></tr>
                <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
            </table>
        </td>
        <td width="25%" rowspan="2"  align="center" vertical-align="middle">
            <table border="0" width="100%">
                <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >FORMULIR DPPA-</td></tr>
                <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >PENDAPATAN SKPD</td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="60%" align="center" vertical-align="middle">
            <table border="0" width="100%">
                <tr><td style="text-align: center; font-size:14px; font-weight: bold; text-transform:uppercase;" >{{ $data['nama_pemda'] }}</td></tr>
                <tr><td style="text-align: center; font-size:14px; font-weight: bold;" >TAHUN ANGGARAN {{ $data['tahun'] }}</td></tr>
            </table>
        </td>
    </tr>
    </table>
    <table border="" cellpadding="2" width="100%">
    <tr>
        <td>
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >ORGANISASI</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_skpd'] }}</td>
                    <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_skpd'] }}</td>
                </tr>
                @if($data['kode_unit'] != NULL)
                    <tr>
                        <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >UNIT ORGANISASI</td>
                        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                        <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_unit'] }}</td>
                        <td width="58%" style="text-align: left; font-size:12px; " >{{ $data['uraian_unit'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="30%" style="text-align: left; font-size:12px;" >Latar belakang Perubahan / dianggarkan</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="68%" style="text-align: left; font-size:12px; " ></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-size:12px;" >Dalam Perubahan APBD</td>
                    <td style="text-align: center; font-size:12px; " ></td>
                    <td style="text-align: left; font-size:12px; " ></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" cellpadding="2" width="100%">
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN PENDAPATAN</td></tr>
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
            </table>
        </td>
    </tr>
    </table>
    <table border="1" cellpadding="4" cellspacing="0" width='100%'>
        <thead>
            <tr height=19>
                <td width="10%" rowspan="3" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">
                    KODE
                    REKENING</td>
                <td width="30%" rowspan="3" style=" text-align: center; font-size:12px; font-weight: bold;">URAIAN
                </td>
                <td width="20%" colspan="4" style=" text-align: center; font-size:12px; font-weight: bold;">SEBELUM
                    PERUBAHAN</td>
                <td width="20%" colspan="4" style=" text-align: center; font-size:12px; font-weight: bold;">SETELAH
                    PERUBAHAN</td>
                <td width="20%" colspan="2" style=" text-align: center; font-size:12px; font-weight: bold;">BERTAMBAH
                    / (BERKURANG)</td>
            </tr>
            <tr height=19>
                <td width="45%" colspan="3" style=" text-align: center; font-size:12px; font-weight: bold;">RINCIAN
                    PERHITUNGAN</td>
                <td width="8%" rowspan="2" style=" text-align: center; font-size:12px; font-weight: bold;">JUMLAH
                    (Rp) </td>
                <td width="45%" colspan="3" style=" text-align: center; font-size:12px; font-weight: bold;">RINCIAN
                    PERHITUNGAN 2</td>
                <td width="8%" rowspan="2" style=" text-align: center; font-size:12px; font-weight: bold;">JUMLAH
                    (Rp) </td>
                <td width="8%" rowspan="2" style=" text-align: center; font-size:12px; font-weight: bold;">Rupiah
                </td>
                <td width="8%" rowspan="2" style=" text-align: center; font-size:12px; font-weight: bold;">%</td>
            </tr>
            <tr height=19>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">
                    Volume</td>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">Satuan
                </td>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">
                    Tarif/Harga</td>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">
                    Volume</td>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">Satuan
                </td>
                <td width="5%" style=" text-align: center; vertical-align:middle; font-size:12px; font-weight: bold;">
                    Tarif/Harga</td>
            </tr>
        </thead>
        <tbody>
            @if ($data['pendapatan_perubahan'] != null)
                @foreach ($data['pendapatan_perubahan'] as $pdt_rub)
                    <?php $jumlahkode = strlen($pdt_rub->kode); ?>
					<?php $kodelevel = $pdt_rub->kdlevel; ?>
					<tr>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1 or $kodelevel==5 or $kodelevel==6){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>17) {
                                }else{ ?>
                                {{ $pdt_rub->kode }}
                                <?php } ?>
                            </td>
                            <td style="font-size:12px;  text-align: justify;  <?php if($kodelevel==1 or $kodelevel==5 or $kodelevel==6){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                {{ $pdt_rub->uraian }}
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ number_format($pdt_rub->jml_volume_sebelum, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ $pdt_rub->satuan_sebelum }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?>font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ number_format($pdt_rub->harga_sebelum, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; <?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?> font-size:12px; font-weight: normal; <?php } ?> font-style:normal;">
                                {{ number_format($pdt_rub->jumlah_sebelum, 2, ',', '.') }}
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ number_format($pdt_rub->jml_volume_setelah, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ $pdt_rub->satuan_setelah }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?>text-align: right; font-style:normal;">
                                <?php if($jumlahkode>12) { ?>
                                    {{ number_format($pdt_rub->harga_setelah, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; <?php if($kodelevel==1){ ?> font-size:11.5px;  font-weight: bold; <?php }else{?> font-size:12px; font-weight: normal; <?php } ?> font-style:normal;">
                                {{ number_format($pdt_rub->jumlah_setelah, 2, ',', '.') }}
                            </td>
                            @if ($pdt_rub->bertambah_berkurang < 0)
                            <td
                                style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                ({{ number_format($pdt_rub->bertambah_berkurang * -1, 2, ',', '.') }})</td>
                            @else
                                <td
                                    style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    {{ number_format($pdt_rub->bertambah_berkurang, 2, ',', '.') }}</td>
                            @endif

                            <?php
                            if ($pdt_rub->jumlah_sebelum == 0) {
                                $persen = 0;
                            } else {
                                $persen = ($pdt_rub->bertambah_berkurang / $pdt_rub->jumlah_sebelum) * 100;
                            } ?>

                            @if ($persen < 0)
                                <td
                                    style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                            @else
                                <td
                                    style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    {{ number_format($persen, 2, ',', '.') }}</td>
                            @endif
                        </tr>
						
                   {{-- <tr>
                        <td width="10%" style="  text-align: left; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; 
						<?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ $pdt_rub->kode }}</td>
                        <td width="27%" style="  text-align: justify; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ $pdt_rub->uraian }}</td>
                        <td width="3%" style="  text-align: left; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; 
						<?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            <?php
                    if ($pdt_rub->jml_volume_sebelum == 0) {
                    } else { ?>
                            {{ number_format($pdt_rub->jml_volume_sebelum, 2, ',', '.') }}
                            <?php } ?>
                        </td>
                        <td width="2%" style="  text-align: left; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ $pdt_rub->satuan_sebelum }}</td>
                        <td width="5%" style="  text-align: right; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->harga_sebelum, 2, ',', '.') }}</td>
                        <td width="8%" style="  text-align: right; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->jumlah_sebelum, 2, ',', '.') }}</td>
                        <td width="3%" style="  text-align: left; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->jml_volume_setelah, 2, ',', '.') }}</td>
                        <td width="2%" style="  text-align: left; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ $pdt_rub->satuan_setelah }}</td>
                        <td width="5%" style="  text-align: right; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->harga_setelah, 2, ',', '.') }}</td>
                        <td width="8%" style="  text-align: right; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->jumlah_setelah, 2, ',', '.') }}</td>
                        <td width="5%" style="  text-align: right; <?php if($jumlahkode<=6){ ?> font-weight: bold; <?php }else{?> font-weight: normal;<?php } ?>; <?php if($jumlahkode<=12){ ?> font-style:normal; <?php }else{?> font-style: normal;<?php } ?>">
                            {{ number_format($pdt_rub->bertambah_berkurang, 2, ',', '.') }}</td>
                        <?php
                        if ($pdt_rub->jumlah_sebelum == 0) {
                            $persen = 0;
                        } else {
                            $persen = ($pdt_rub->bertambah_berkurang / $pdt_rub->jumlah_sebelum) * 100;
                        } ?>
						@if ($persen < 0)
                                <td
                                    style="<?php if($jumlahkode<=6){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                            @else
                                <td
                                    style="<?php if($jumlahkode<=6){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    {{ number_format($persen, 2, ',', '.') }}</td>
                            @endif
							
                        
                    </tr> --}}
                @endforeach
            @else
                <tr>
                    <td colspan="12" style="font-size:12px;  text-align: center; font-weight: bold;">TIDAK ADA DATA
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    {{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
        <tr>
            <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Realisasi Pendapatan per Bulan *)</td>
            <td style="border-right:0px solid black;border-top:0px solid black;text-align: center; width:30%; font-size:12px;">{{ $data['nmibukota'] }}, {{ date_indo($tgl_ttd) }}</td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; width:7%; font-size:12px;" >Januari</td>
            <td style="border:0px solid black;text-align: right; width:18%; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jan,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Pengguna Anggaran</td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >Februari</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_feb,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PAjab']}}</td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >Maret</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mar,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >April</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_apr,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >Mei</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mei,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PAnama']}}</td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{$data['PAnip']}}</td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >Juli</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jul,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >Agustus</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_aug,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Mengesahkan,</td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >September</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_sep,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >PPKD</td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >Oktober</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_okt,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >November</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_nov,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: left; font-size:12px;" >Desember</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_des,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{$data['PPKDnama']}}</td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >Jumlah</td>
            <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >
                <?php $totalpenerimaan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
                +$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
                +$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
                +$data['query_penerimaan_penarikan'][0]->total_des; ?>
                Rp. {{format_money($totalpenerimaan,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{$data['PPKDnip']}}</td>
        </tr>

    </table>

    <table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
        <tr><td colspan="5"><br>
            <table style="font-size:12px; font-weight: bold;" width="100%">
				<tr><td width="60%"></td><td width="40%" style="text-align: center; font-weight: normal;">{{ $kota }}, {{ date_indo($tgl_ttd) }}</td></tr>
				<tr><td width="60%"></td><td width="40%" style="text-align: center;">Kepala SKPD</td></tr>
				<tr><td height="60"></td></tr>
				<tr><td width="60%"></td><td width="40%" style="text-align: center;">.............................</td></tr>
				<tr><td width="60%"></td><td width="40%" style="text-align: center;">NIP .......................</td></tr>
			</table>
		</td></tr>

        <tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: bold;">Pembahasan </td></tr>
        <tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Tanggal :</td></tr>
        <tr><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Catatan :</td></tr>
        <tr height="100"><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td></tr>


        <tr height="20"><td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td></tr>

        <tr><td colspan="5" style="font-size:12px; text-align: center; font-weight: bold;">Tim Anggaran Pemerintah Daerah</td></tr>
        <tr>
            <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">No</td>
            <td width="25" style="font-size:12px; text-align: center; font-weight: bold;">Nama</td>
            <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">NIP</td>
            <td width="30%" style="font-size:12px; text-align: center; font-weight: bold;">Jabatan</td>
            <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">Tanda Tangan</td>
        </tr>
        <?php
        if(count($data['ambiltapd'])){
        $nouruttapd=1;
        $jumlahloop=count($data['ambiltapd']);
        ?>
		<?php for($i=0;$i<$jumlahloop;$i++) { ?>

		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >{{$nouruttapd}}</td>
		<td style="width:35%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nama}}</td>
		<td style="width:20%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nip}}</td>
		<td style="width:25%;text-align: left; font-size:12px;" >{{$data['ambiltapd'][$i]->nmjabatan}}</td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<?php $nouruttapd=$nouruttapd+1; ?>
		<?php } }else{ ?>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >1.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >2.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >3.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >4.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >5.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<tr>
		<td style="width:5%;text-align: center; font-size:12px;" >6.</td>
		<td style="width:35%;text-align: left; font-size:12px;" ></td>
		<td style="width:20%;text-align: left; font-size:12px;" ></td>
		<td style="width:25%;text-align: left; font-size:12px;" ></td>
		<td style="width:15%;text-align: left; font-size:12px;" ></td>
		</tr>
		<?php } ?>
		</table>
    <br>
    <table border="0" cellpadding="2" cellspacing="6" width=100%>
        <tr>
        <td width="100%" style="text-align: justify; font-size:12px; " >*) Sesuai periodisasi SPD</td>
        </tr>
    </table>--}}
    @endforeach
    </body>
<?php }// else jika idjnsdokumen selain 26
?>
