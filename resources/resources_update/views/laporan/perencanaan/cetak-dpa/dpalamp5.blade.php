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
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >PEMBIAYAAN SKPD</td></tr>
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
        <table border="0" cellpadding="2" width="100%">
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN DOKUMEN PELAKSANAAN ANGGARAN PENERIMAAN PENGELUARAN PEMBIAYAAN</td></tr>
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
        </table>
    </td>
</tr>
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
</table>
<table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <thead>
        <tr height=19>
            <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >KODE REKENING</td>
            <td width="60%" style="font-size:12px; text-align: center; font-weight: bold;" >URAIAN</td>
            <td width="25%" style="font-size:12px; text-align: center; font-weight: bold;" >JUMLAH (Rp) </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;">6</td>
            <td width="60%" style="font-size:12px;  text-align: justify; font-weight: bold;">PEMBIAYAAN DAERAH</td>
            <td width="25%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
        </tr>
            @foreach ($data['rek_terima'] as $rek2)
                <tr>
                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek2['kode_rekening'] }}</td>
                    <td width="60%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek2['nama_rekening'] }}</td>
                    <td width="25%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek2['jumlah'], 2, ',', '.') }}</td>
                </tr>
                @foreach ($rek2['rek_3'] as $rek3)
                    <tr>
                        <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek3['kode_rekening'] }}</td>
                        <td width="60%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek3['nama_rekening'] }}</td>
                        <td width="25%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek3['jumlah'], 2, ',', '.') }}</td>
                    </tr>
                    @foreach ($rek3['rek_4'] as $rek4)
                        <tr>
                            <td width="15%" style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek4['kode_rekening'] }}</td>
                            <td width="60%" style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek4['nama_rekening'] }}</td>
                            <td width="25%" style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek4['jumlah'], 2, ',', '.') }}</td>
                        </tr>
                        @foreach ($rek4['rek_5'] as $rek5)
                            <tr>
                                <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek5['kode_rekening'] }}</td>
                                <td width="60%" style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek5['nama_rekening'] }}</td>
                                <td width="25%" style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek5['jumlah'], 2, ',', '.') }}</td>
                            </tr>
                            @foreach ($rek5['rek_6'] as $rek6)
                                <tr>
                                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;">{{ $rek6['kode_rekening'] }}</td>
                                    <td width="60%" style="font-size:12px;  text-align: justify; font-weight: normal; font-style:italic;">{{ $rek6['nama_rekening'] }}</td>
                                    <td width="25%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek6['jumlah'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        <tr>
            <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
            <td width="60%" style="font-size:12px;  text-align: left; font-weight: bold;">JUMLAH PENERIMAAN PEMBIAYAAN</td>
            <td width="25%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_terima'] ?? 0, 2, ',', '.') }}</td>
        </tr>
            @foreach ($data['rek_keluar'] as $rek21)
                <tr>
                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek21['kode_rekening'] }}</td>
                    <td width="60%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek21['nama_rekening'] }}</td>
                    <td width="25%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek21['jumlah'], 2, ',', '.') }}</td>
                </tr>
                @foreach ($rek21['rek_3'] as $rek31)
                    <tr>
                        <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek31['kode_rekening'] }}</td>
                        <td width="60%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek31['nama_rekening'] }}</td>
                        <td width="25%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek31['jumlah'], 2, ',', '.') }}</td>
                    </tr>
                    @foreach ($rek31['rek_4'] as $rek41)
                        <tr>
                            <td width="15%" style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek41['kode_rekening'] }}</td>
                            <td width="60%" style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek41['nama_rekening'] }}</td>
                            <td width="25%" style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek41['jumlah'], 2, ',', '.') }}</td>
                        </tr>
                        @foreach ($rek41['rek_5'] as $rek51)
                            <tr>
                                <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek51['kode_rekening'] }}</td>
                                <td width="60%" style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek51['nama_rekening'] }}</td>
                                <td width="25%" style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek51['jumlah'], 2, ',', '.') }}</td>
                            </tr>
                            @foreach ($rek51['rek_6'] as $rek61)
                                <tr>
                                    <td width="15%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;">{{ $rek61['kode_rekening'] }}</td>
                                    <td width="60%" style="font-size:12px;  text-align: justify; font-weight: normal; font-style:italic;">{{ $rek61['nama_rekening'] }}</td>
                                    <td width="25%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek61['jumlah'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        <tr>
            <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
            <td width="60%" style="font-size:12px;  text-align: left; font-weight: bold;">JUMLAH PENGELUARAN PEMBIAYAAN</td>
            <td width="25%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_keluar'] ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td width="15%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
            <td width="60%" style="font-size:12px;  text-align: left; font-weight: bold;">PEMBIAYAAN NETTO</td>
            @if($data['jml_biaya_netto'] < 0)
                <td width="25%" style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($data['jml_biaya_netto']*-1, 2, ',', '.') }})</td>
            @else
                <td width="25%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_biaya_netto'], 2, ',', '.') }}</td>
            @endif
        </tr>
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
			<td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PAjab'] }}</td>
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
			<td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PAnama'] }}</td>
		</tr>
		<tr>
			<td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
			<td style="border:0px solid black;text-align: right; font-size:12px;" >
				Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
			<td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PAnip'] }}</td>
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
			<td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PPKDnama'] }}</td>
		</tr>
		<tr>
			<td style="border:0px solid black; text-align: right; font-size:12px;" >Jumlah</td>
			<td style="border:0px solid black; text-align: right; font-size:12px;" >
				<?php $totalpenarikan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
				+$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
				+$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
				+$data['query_penerimaan_penarikan'][0]->total_des; ?>
				Rp. {{format_money($totalpenarikan,2)}}
			</td>
			<td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
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

		<tr><td colspan="5" style="font-size:12px; text-align: center; font-weight: normal;">Tim Anggaran Pemerintah Daerah</td></tr>
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
		<td width="100%" style="text-align: justify; font-size:12px; " >*) Sesuai dengan periodisasi SPD</td>
		</tr>
		</table>--}}

@endforeach
</body>
<?php }//tutup jika idjnsdokumen=2
else{ ?>
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
                <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >PEMBIAYAAN SKPD</td></tr>
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
                @if($data['kode_skpd'] != NULL)
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Urusan Pemerintahan</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kdurusan'] }}</td>
                    <td width="78%" style="text-align: left; font-size:12px; " >{{ $data['nmurusan'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Bidang Urusan</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kdbidang'] }}</td>
                    <td width="78%" style="text-align: left; font-size:12px; " >{{ $data['nmbidang'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Organisasi</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_skpd'] }}</td>
                    <td width="78%" style="text-align: left; font-size:12px; " >{{ $data['uraian_skpd'] }}</td>
                </tr>
                @endif
                @if($data['kode_unit'] != NULL)
                    <tr>
                        <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Unit Organisasi</td>
                        <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                        <td width="20%" style="text-align: left; font-size:12px; " >{{ $data['kode_unit'] }}</td>
                        <td width="78%" style="text-align: left; font-size:12px; " >{{ $data['uraian_unit'] }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
    <tr>
        <td>
             <table border="0" cellpadding="2" cellspacing="0">
                    <tr>
                        <td width="30%" style="text-align: left; font-size:12px;" >Latar belakang perubahan / dianggarkan</b></td>
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
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN PEMBIAYAAN</td></tr>
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
            </table>
        </td>
    </tr>
    </table>
    <table border="1" cellpadding="4" cellspacing="0" width='100%'>
        <thead>
            <tr height=19>
                <td width="10%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >KODE REKENING</td>
                <td width="40%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >URAIAN</td>
                <td width="30%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >JUMLAH (Rp)</td>
                <td width="20%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >BERTAMBAH / (BERKURANG)</td>
            </tr>
            <tr height=19>
                <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;" >SEBELUM PERUBAHAN</td>
                <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;" >SETELAH PERUBAHAN</td>
                <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;" >(Rp)</td>
                <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;" >%</td>
            </tr>
            <tr height=19>
                <td style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >1</td>
                <td style="font-size:12px; text-align: center; font-weight: bold;" >2</td>
                <td style="font-size:12px; text-align: center; font-weight: bold;" >3</td>
                <td style="font-size:12px; text-align: center; font-weight: bold;" >4</td>
                <td style="font-size:12px; text-align: center; font-weight: bold;" >5</td>
                <td style="font-size:12px; text-align: center; font-weight: bold;" >6</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size:12px;  text-align: left; font-weight: bold;">6</td>
                <td style="font-size:12px;  text-align: justify; font-weight: bold;">PEMBIAYAAN DAERAH</td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;"></td>
            </tr>
                @foreach ($data['rek_terima'] as $rek2)
                    <tr>
                        <td style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek2['kode_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek2['nama_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek2['jumlah_sebelum'], 2, ',', '.') }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek2['jumlah_setelah'], 2, ',', '.') }}</td>
                        @if($rek2['bertambah_berkurang'] < 0)
                        <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($rek2['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                        @else
                        <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($rek2['bertambah_berkurang'], 2, ',', '.') }}</td>
                        @endif

                        <?php
                        if ($rek2['jumlah_sebelum'] == 0) {
                            $persen = 0;
                        } else {
                            $persen=$rek2['bertambah_berkurang']/$rek2['jumlah_sebelum']*100;
                        } ?>

                        @if($persen < 0)
                        <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                        @else
                        <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                        @endif
                    </tr>
                    @foreach ($rek2['rek_3'] as $rek3)
                        <tr>
                            <td style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek3['kode_rekening'] }}</td>
                            <td style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek3['nama_rekening'] }}</td>
                            <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek3['jumlah_sebelum'], 2, ',', '.') }}</td>
                            <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek3['jumlah_setelah'], 2, ',', '.') }}</td>
                            @if($rek3['bertambah_berkurang'] < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($rek3['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                            @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($rek3['bertambah_berkurang'], 2, ',', '.') }}</td>
                            @endif

                            <?php
                            if ($rek3['jumlah_sebelum'] == 0) {
                                $persen = 0;
                            } else {
                                $persen=$rek3['bertambah_berkurang']/$rek3['jumlah_sebelum']*100;
                            } ?>

                            @if($persen < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                            @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                            @endif
                        </tr>
                        @foreach ($rek3['rek_4'] as $rek4)
                            <tr>
                                <td style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek4['kode_rekening'] }}</td>
                                <td style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek4['nama_rekening'] }}</td>
                                <td style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek4['jumlah_sebelum'], 2, ',', '.') }}</td>
                                <td style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek4['jumlah_setelah'], 2, ',', '.') }}</td>
                                @if($rek4['bertambah_berkurang'] < 0)
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">({{ number_format($rek4['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                @else
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">{{ number_format($rek4['bertambah_berkurang'], 2, ',', '.') }}</td>
                                @endif

                                <?php
                                if ($rek4['jumlah_sebelum'] == 0) {
                                    $persen = 0;
                                } else {
                                    $persen=$rek4['bertambah_berkurang']/$rek4['jumlah_sebelum']*100;
                                } ?>

                                @if($persen < 0)
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                @else
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">{{ number_format($persen, 2, ',', '.') }}</td>
                                @endif
                            </tr>
                            @foreach ($rek4['rek_5'] as $rek5)
                                <tr>
                                    <td style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek5['kode_rekening'] }}</td>
                                    <td style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek5['nama_rekening'] }}</td>
                                    <td style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek5['jumlah_sebelum'], 2, ',', '.') }}</td>
                                    <td style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek5['jumlah_setelah'], 2, ',', '.') }}</td>
                                    @if($rek5['bertambah_berkurang'] < 0)
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">({{ number_format($rek5['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                    @else
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">{{ number_format($rek5['bertambah_berkurang'], 2, ',', '.') }}</td>
                                    @endif

                                    <?php
                                    if ($rek5['jumlah_sebelum'] == 0) {
                                        $persen = 0;
                                    } else {
                                        $persen=$rek5['bertambah_berkurang']/$rek5['jumlah_sebelum']*100;
                                    } ?>

                                    @if($persen < 0)
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                    @else
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">{{ number_format($persen, 2, ',', '.') }}</td>
                                    @endif
                                </tr>
                                @foreach ($rek5['rek_6'] as $rek6)
                                    <tr>
                                        <td style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;">{{ $rek6['kode_rekening'] }}</td>
                                        <td style="font-size:12px;  text-align: justify; font-weight: normal; font-style:italic;">{{ $rek6['nama_rekening'] }}</td>
                                        <td style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek6['jumlah_sebelum'], 2, ',', '.') }}</td>
                                        <td style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek6['jumlah_setelah'], 2, ',', '.') }}</td>
                                        @if($rek6['bertambah_berkurang'] < 0)
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">({{ number_format($rek6['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                        @else
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek6['bertambah_berkurang'], 2, ',', '.') }}</td>
                                        @endif

                                        <?php
                                        if ($rek6['jumlah_sebelum'] == 0) {
                                            $persen = 0;
                                        } else {
                                            $persen=$rek6['bertambah_berkurang']/$rek6['jumlah_sebelum']*100;
                                        } ?>

                                        @if($persen < 0)
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                        @else
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">{{ number_format($persen, 2, ',', '.') }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            <tr>
                <td style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: left; font-weight: bold;">JUMLAH PENERIMAAN PEMBIAYAAN</td>
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_terima_sebelum'] ?? 0, 2, ',', '.') }}</td>
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_terima_setelah'] ?? 0, 2, ',', '.') }}</td>
                @if($data['jml_terima_bertambah_berkurang'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold">({{ number_format($data['jml_terima_bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                @else
                <td style="font-size:12px; text-align: right; font-weight: bold">{{ number_format($data['jml_terima_bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php
                if ($data['jml_terima_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen=$data['jml_terima_bertambah_berkurang']/$data['jml_terima_sebelum']*100;
                } ?>

                @if($persen < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                @else
                <td style="font-size:12px; text-align: right; font-weight: bold">{{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
                @foreach ($data['rek_keluar'] as $rek21)
                    <tr>
                        <td style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek21['kode_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek21['nama_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek21['jumlah_sebelum'], 2, ',', '.') }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek21['jumlah_setelah'], 2, ',', '.') }}</td>
                        @if($rek21['bertambah_berkurang'] < 0)
                        <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($rek21['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                        @else
                        <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($rek21['bertambah_berkurang'], 2, ',', '.') }}</td>
                        @endif

                        <?php
                        if ($rek21['jumlah_sebelum'] == 0) {
                            $persen = 0;
                        } else {
                            $persen=$rek21['bertambah_berkurang']/$rek21['jumlah_sebelum']*100;
                        } ?>

                        @if($persen < 0)
                        <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                        @else
                        <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                        @endif
                    </tr>
                    @foreach ($rek21['rek_3'] as $rek31)
                        <tr>
                            <td style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek31['kode_rekening'] }}</td>
                            <td style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek31['nama_rekening'] }}</td>
                            <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek31['jumlah_sebelum'], 2, ',', '.') }}</td>
                            <td style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek31['jumlah_setelah'], 2, ',', '.') }}</td>
                            @if($rek31['bertambah_berkurang'] < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($rek31['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                            @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($rek31['bertambah_berkurang'], 2, ',', '.') }}</td>
                            @endif

                            <?php
                            if ($rek31['jumlah_sebelum'] == 0) {
                                $persen = 0;
                            } else {
                                $persen=$rek31['bertambah_berkurang']/$rek31['jumlah_sebelum']*100;
                            } ?>

                            @if($persen < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                            @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                            @endif
                        </tr>
                        @foreach ($rek31['rek_4'] as $rek41)
                            <tr>
                                <td style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek41['kode_rekening'] }}</td>
                                <td style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek41['nama_rekening'] }}</td>
                                <td style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek41['jumlah_sebelum'], 2, ',', '.') }}</td>
                                <td style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek41['jumlah_setelah'], 2, ',', '.') }}</td>
                                @if($rek41['bertambah_berkurang'] < 0)
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">({{ number_format($rek41['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                @else
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">{{ number_format($rek41['bertambah_berkurang'], 2, ',', '.') }}</td>
                                @endif

                                <?php
                                if ($rek41['jumlah_sebelum'] == 0) {
                                    $persen = 0;
                                } else {
                                    $persen=$rek41['bertambah_berkurang']/$rek41['jumlah_sebelum']*100;
                                } ?>

                                @if($persen < 0)
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                @else
                                <td style="font-size:12px; text-align: right; font-weight: semibold;">{{ number_format($persen, 2, ',', '.') }}</td>
                                @endif
                            </tr>
                            @foreach ($rek41['rek_5'] as $rek51)
                                <tr>
                                    <td style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek51['kode_rekening'] }}</td>
                                    <td style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek51['nama_rekening'] }}</td>
                                    <td style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek51['jumlah_sebelum'], 2, ',', '.') }}</td>
                                    <td style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek51['jumlah_setelah'], 2, ',', '.') }}</td>
                                    @if($rek51['bertambah_berkurang'] < 0)
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">({{ number_format($rek51['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                    @else
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">{{ number_format($rek51['bertambah_berkurang'], 2, ',', '.') }}</td>
                                    @endif

                                    <?php
                                    if ($rek51['jumlah_sebelum'] == 0) {
                                        $persen = 0;
                                    } else {
                                        $persen=$rek51['bertambah_berkurang']/$rek51['jumlah_sebelum']*100;
                                    } ?>

                                    @if($persen < 0)
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                    @else
                                    <td style="font-size:12px; text-align: right; font-weight: normal;">{{ number_format($persen, 2, ',', '.') }}</td>
                                    @endif
                                </tr>
                                @foreach ($rek51['rek_6'] as $rek61)
                                    <tr>
                                        <td style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;">{{ $rek61['kode_rekening'] }}</td>
                                        <td style="font-size:12px;  text-align: justify; font-weight: normal; font-style:italic;">{{ $rek61['nama_rekening'] }}</td>
                                        <td style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek61['jumlah_sebelum'], 2, ',', '.') }}</td>
                                        <td style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek61['jumlah_setelah'], 2, ',', '.') }}</td>
                                        @if($rek61['bertambah_berkurang'] < 0)
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">({{ number_format($rek61['bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                                        @else
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek61['bertambah_berkurang'], 2, ',', '.') }}</td>
                                        @endif

                                        <?php
                                        if ($rek61['jumlah_sebelum'] == 0) {
                                            $persen = 0;
                                        } else {
                                            $persen=$rek61['bertambah_berkurang']/$rek61['jumlah_sebelum']*100;
                                        } ?>

                                        @if($persen < 0)
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                                        @else
                                        <td style="font-size:12px; text-align: right; font-weight: normal; font-style:italic;">{{ number_format($persen, 2, ',', '.') }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            <tr>
                <td style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: left; font-weight: bold;">JUMLAH PENGELUARAN PEMBIAYAAN</td>
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_keluar_sebelum'] ?? 0, 2, ',', '.') }}</td>
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_keluar_setelah'] ?? 0, 2, ',', '.') }}</td>
                @if($data['jml_keluar_bertambah_berkurang'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($data['jml_keluar_bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_keluar_bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php
                if ($data['jml_keluar_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen=$data['jml_keluar_bertambah_berkurang']/$data['jml_keluar_sebelum']*100;
                } ?>

                @if($persen < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
            <tr>
                <td style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td style="font-size:12px;  text-align: left; font-weight: bold;">PEMBIAYAAN NETTO</td>
                @if($data['jml_biaya_netto_sebelum'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($data['jml_biaya_netto_sebelum']*-1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_biaya_netto_sebelum'], 2, ',', '.') }}</td>
                @endif

                @if($data['jml_biaya_netto_setelah'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($data['jml_biaya_netto_setelah']*-1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_biaya_netto_setelah'], 2, ',', '.') }}</td>
                @endif

                @if($data['jml_biaya_netto_bertambah_berkurang'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($data['jml_biaya_netto_bertambah_berkurang']*-1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['jml_biaya_netto_bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php
                if ($data['jml_biaya_netto_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen=$data['jml_biaya_netto_bertambah_berkurang']/$data['jml_biaya_netto_sebelum']*100;
                } ?>

                @if($persen < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">({{ number_format($persen*-1, 2, ',', '.') }})</td>
                @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
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
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PAjab'] }}</td>
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
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PAnama'] }}</td>
        </tr>
        <tr>
            <td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
            <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PAnip'] }}</td>
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
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PPKDnama'] }}</td>
        </tr>
        <tr>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >Jumlah</td>
            <td style="border:0px solid black; text-align: right; font-size:12px;" >
                <?php $totalpenarikan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
                +$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
                +$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
                +$data['query_penerimaan_penarikan'][0]->total_des; ?>
                Rp. {{format_money($totalpenarikan,2)}}
            </td>
            <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
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

        <tr><td colspan="5" style="font-size:12px; text-align: center; font-weight: normal;">Tim Anggaran Pemerintah Daerah</td></tr>
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
			<td width="100%" style="text-align: justify; font-size:12px; " >*) Sesuai dengan periodisasi SPD</td>
			</tr>
	</table>--}}

    @endforeach
    </body>
<?php }// else jika idjnsdokumen selain 2 ?>
