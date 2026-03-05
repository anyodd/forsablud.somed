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
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >RINCIAN BELANJA SKPD</td></tr>
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
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN ANGGARAN BELANJA MENURUT PROGRAM DAN KEGIATAN</td></tr>
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table border="0" cellpadding="2" cellspacing="0" width="100%">
		{{--<tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Nomor DPA</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['dpa_no'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " ></td>
		</tr>--}}
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Urusan Pemerintahan</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kdurusan'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['nmurusan'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Bidang Urusan</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kdbidang'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['nmbidang'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Program</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kdprogram'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['nmprogram'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Kegiatan</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kdkegiatan'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['nmkegiatan'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Organisasi</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_skpd'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['uraian_skpd'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Unit Organisasi</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['kode_unit'] }}</td>
                <td width="63%" style="text-align: left; font-size:12px; " >{{ $data['uraian_unit'] }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Alokasi Tahun-1</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="78%" colspan="2" style="text-align: left; font-size:12px; " >Rp.{{ number_format($data['pagumin'], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Alokasi Tahun</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="78%" colspan="2" style="text-align: left; font-size:12px; " >Rp.{{ number_format($data['paguskg'], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Alokasi Tahun+1</td>
                <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                <td width="78%" colspan="2" style="text-align: left; font-size:12px; " >Rp.{{ number_format($data['paguplus'], 2, ',', '.') }}</td>
            </tr>
        </table>
    </td>
</tr>
<tr><td style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;"><br></td></tr>
</table>
<table border="" cellpadding="2" cellspacing="0" width='100%'>
    <tr>
        <td colspan="3" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">Indikator dan Tolak Ukur Kinerja Kegiatan</td>
    </tr>
    <tr>
        <td width="20%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">Indikator</td>
        <td width="65%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">Tolok Ukur Kinerja</td>
        <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">Target Kinerja</td>
    </tr>
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Masukan</td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">Dana yang dibutuhkan</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">Rp.{{ number_format($data['paguskg'], 2, ',', '.') }}</td>
    </tr>
    @foreach ($data['keluaran'] as $ikeg)
    @if($loop->first)
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Keluaran</td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $ikeg['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($ikeg['target'], 2, ',', '.') }} {{ $ikeg['satuan'] }}</td>
    </tr>
    @else
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $ikeg['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($ikeg['target'], 2, ',', '.') }} {{ $ikeg['satuan'] }}</td>
    </tr>
    @endif
    @endforeach
    @foreach ($data['hasil'] as $iprog)
    @if($loop->first)
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Hasil</td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $iprog['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($iprog['target'], 2, ',', '.') }} {{ $iprog['satuan'] }}</td>
    </tr>
    @else
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $iprog['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($iprog['target'], 2, ',', '.') }} {{ $iprog['satuan'] }}</td>
    </tr>
    @endif
    @endforeach
    <tr height=15>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Kelompok Sasaran</td>
        <td colspan="2" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
    </tr>
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"><br></td>
        <td colspan="2" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
    </tr>
</table>
@if(!empty($data['subkeg']))
@foreach ($data['subkeg'] as $sub)
<table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Sub Kegiatan</td>
        <td colspan="2" width="80%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $sub['kdsubkegiatan'] }} {{ $sub['nmsubkegiatan'] }}</td>
    </tr>
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Sumber Pendanaan</td>
        <td colspan="2" width="80%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $sub['sumberdana'] }}</td>
    </tr>
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Lokasi</td>
        <td colspan="2" width="80%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $sub['lokasi'] }}</td>
    </tr>
    @foreach ($sub['keluaran'] as $isub)
    @if($loop->first)
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Keluaran Sub Kegiatan</td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $isub['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($isub['target'], 2, ',', '.') }} {{ $isub['satuan'] }}</td>
    </tr>
    @else
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
        <td width="65%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">{{ $isub['nmindikator'] }}</td>
        <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($isub['target'], 2, ',', '.') }} {{ $isub['satuan'] }}</td>
    </tr>
    @endif
    @endforeach
    <tr>
        <td width="20%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Waktu Pelaksanaan</td>
        <td colspan="2" width="80%" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">Mulai {{ $sub['mulai'] }} Sampai {{ $sub['akhir'] }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Keterangan</td>
    </tr>
</table>
<table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <thead>
        <tr height=19>
            <td width="10%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >KODE REKENING</td>
            <td width="30%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >URAIAN</td>
            <td width="45%" colspan="4" style="font-size:12px; text-align: center; font-weight: bold;" >RINCIAN PERHITUNGAN</td>
            <td width="10%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;" >JUMLAH (Rp) </td>
        </tr>
        <tr height=19>
            <td width="10%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Koefisien/Volume</td>
            <td width="10%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Satuan</td>
            <td width="15%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >Harga Satuan</td>
            <td width="10%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >PPN</td>
        </tr>
    </thead>
    <tbody>
	<tbody>
        @foreach ($sub['rincian'] as $rinc)
        <?php $jumlahkode = strlen($rinc->kode); ?>
		<?php $kodelevel = $rinc->kdlevel; ?>
            <tr>
                <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1 or $kodelevel==10){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                <?php if($jumlahkode>19) { }else{ ?> {{ $rinc->kode }} <?php } ?>
                </td>
                <td style="font-size:12px;  text-align: justify;  <?php if($kodelevel==1 or $kodelevel==10){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;"> {{ $rinc->uraian }}
                </td>
                <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                <?php if($jumlahkode>26) { ?>
                {{ number_format($rinc->jml_volume, 2, ',', '.') }}
                <?php }else{ } ?>
                </td>
                <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                <?php if($jumlahkode>26) { ?> {{ $rinc->satuan }} <?php }else{ } ?>
                </td>
                <td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?>font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                <?php if($jumlahkode>26) { ?> {{ number_format($rinc->harga, 2, ',', '.') }} <?php }else{ } ?>
                </td>
				<td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?>font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;"></td>
                <td style="text-align: right; <?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?> font-size:12px; font-weight: normal; <?php } ?> font-style:normal;"> {{ number_format($rinc->jumlah, 2, ',', '.') }}
                 </td>
             </tr>
        @endforeach
            <tr>
                <td colspan="2" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">Jumlah Belanja Sub Kegiatan</td>
                <td colspan="5" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">
                            {{ number_format($sub['jumlah'], 2, ',', '.') }}
                </td>
            </tr>
    </tbody>

        {{--@foreach ($sub['rincian'] as $rek1)
            <tr>
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek1['kode_rekening'] }}</td>
                <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek1['nama_rekening'] }}</td>
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td width="10%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek1['jumlah'], 2, ',', '.') }}</td>
            </tr>
            @foreach ($rek1['rek_2'] as $rek2)
                <tr>
                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek2['kode_rekening'] }}</td>
                    <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek2['nama_rekening'] }}</td>
                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                    <td width="10%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                    <td width="20%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek2['jumlah'], 2, ',', '.') }}</td>
                </tr>
                @foreach ($rek2['rek_3'] as $rek3)
                    <tr>
                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek3['kode_rekening'] }}</td>
                        <td width="30%" style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek3['nama_rekening'] }}</td>
                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;"></td>
                        <td width="15%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                        <td width="10%" style="font-size:12px;  text-align: right; font-weight: bold;"></td>
                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: bold;">{{ number_format($rek3['jumlah'], 2, ',', '.') }}</td>
                    </tr>
                    @foreach ($rek3['rek_4'] as $rek4)
                        <tr>
                            <td width="10%" style="font-size:12px;  text-align: left; font-weight: semibold;">{{ $rek4['kode_rekening'] }}</td>
                            <td width="30%" style="font-size:12px;  text-align: justify; font-weight: semibold;">{{ $rek4['nama_rekening'] }}</td>
                            <td width="10%" style="font-size:12px;  text-align: left; font-weight: semibold;"></td>
                            <td width="10%" style="font-size:12px;  text-align: left; font-weight: semibold;"></td>
                            <td width="15%" style="font-size:12px;  text-align: right; font-weight: semibold;"></td>
                            <td width="10%" style="font-size:12px;  text-align: right; font-weight: semibold;"></td>
                            <td width="20%" style="font-size:12px;  text-align: right; font-weight: semibold;">{{ number_format($rek4['jumlah'], 2, ',', '.') }}</td>
                        </tr>
                        @foreach ($rek4['rek_5'] as $rek5)
                            <tr>
                                <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal;">{{ $rek5['kode_rekening'] }}</td>
                                <td width="30%" style="font-size:12px;  text-align: justify; font-weight: normal;">{{ $rek5['nama_rekening'] }}</td>
                                <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal;"></td>
                                <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal;"></td>
                                <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal;"></td>
                                <td width="10%" style="font-size:12px;  text-align: right; font-weight: normal;"></td>
                                <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal;">{{ number_format($rek5['jumlah'], 2, ',', '.') }}</td>
                            </tr>
                            @foreach ($rek5['rek_6'] as $rek6)
                                <tr>
                                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;">{{ $rek6['kode_rekening'] }}</td>
                                    <td width="30%" style="font-size:12px;  text-align: justify; font-weight: normal; font-style:italic;">{{ $rek6['nama_rekening'] }}</td>
                                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;"></td>
                                    <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;"></td>
                                    <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;"></td>
                                    <td width="10%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;"></td>
                                    <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;">{{ number_format($rek6['jumlah'], 2, ',', '.') }}</td>
                                </tr>
                                @foreach ($rek6['aktiv'] as $akt)
                                    <tr>
                                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:italic;"></td>
                                        <td width="70%" colspan="5" style="font-size:12px;  text-align: justify; font-weight: bold; font-style:italic;">{{ $akt['uraian'] }}</td>
                                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:italic;"></td>
                                    </tr>
                                    @foreach ($akt['rincian'] as $rinc)
                                    <tr>
                                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;"></td>
                                        <td width="30%" style="font-size:12px;  text-align: justify; font-weight: normal; font-style:normal;">{{ $rinc['uraian'] }}</td>
                                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;">{{ number_format($rinc['volume'], 2, ',', '.') }}</td>
                                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; font-style:normal;">{{ $rinc['satuan'] }}</td>
                                        <td width="15%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:normal;">{{ number_format($rinc['harga'], 2, ',', '.') }}</td>
                                        <td width="10%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:normal;">{{ number_format(0, 2, ',', '.') }}</td>
                                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal; font-style:normal;">{{ number_format($rinc['jumlah'], 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        @endforeach --}}
    </tbody>
</table>
{{-- <table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <tr>
        <tr>
            <td width="85%" colspan="2" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">Jumlah Belanja Sub Kegiatan</td>
            <td width="15%"  style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">{{ number_format($sub['jumlah'], 2, ',', '.') }}</td>
        </tr>
    </tr>
    <tr>
        <tr>
            <td width="85%" colspan="2" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;"><br></td>
            <td width="15%" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;"><br></td>
        </tr>
    </tr>
</table>  --}}
@endforeach
@else
<table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
    <tr>
        <td width="100%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;"><br>TIDAK ADA DATA<br></td>
    </tr>
</table>
@endif
{{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Penarikan Dana per Bulan *)</td>
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
        <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >Jumlah</td>
        <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >
            <?php $totalpenarikan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
            +$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
            +$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
            +$data['query_penerimaan_penarikan'][0]->total_des; ?>
            Rp. {{format_money($totalpenarikan,2)}}
        </td>
        <td style="border-bottom:0px solid black;border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
    </tr>

</table>
<table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">

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
	</table>--}}
@endforeach
</body>
<?php }//tutup jika idjnsdokumen=2
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
                <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >RINCIAN BELANJA SKPD</td></tr>
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
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >RINCIAN PERUBAHAN ANGGARAN BELANJA MENURUT PROGRAM DAN KEGIATAN</td></tr>
                <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" cellpadding="2" cellspacing="0" width="100%">
			{{--<tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;" >Nomor DPPA</td>
                    <td width="2%" style="text-align: center; font-size:12px; " >:</td>
                    <td width="15%" style="text-align: left; font-size:12px; " >{{ $data['dpa_no'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; " ></td>
			</tr>--}}
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Urusan
                        Pemerintahan</td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kdurusan'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['nmurusan'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Bidang Urusan
                    </td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kdbidang'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['nmbidang'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Program</td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kdprogram'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['nmprogram'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Kegiatan</td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kdkegiatan'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['nmkegiatan'] }}</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Organisasi</td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kode_skpd'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['uraian_skpd'] }}
                    </td>
                </tr>
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Unit Organisasi
                    </td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="15%" style="text-align: left; font-size:12px; ">{{ $data['kode_unit'] }}</td>
                    <td width="63%" style="text-align: left; font-size:12px; ">{{ $data['uraian_unit'] }}
                    </td>
                </tr>
                {{-- <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Alokasi Tahun-1
                    </td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="78%" colspan="2" style="text-align: left; font-size:12px; ">
                        Rp.{{ number_format($data['pagumin'], 2, ',', '.') }}</td>
                </tr> --}}
                <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Jumlah Anggaran
                    </td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="78%" colspan="2" style="text-align: left; font-size:12px; ">
                        {{-- Rp.{{ number_format($data['paguskg'], 2, ',', '.') }} --}}
                        Rp.{{ number_format($data['paguskg'], 2, ',', '.') }}
                    </td>
                </tr>
                {{-- <tr>
                    <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Alokasi Tahun+1
                    </td>
                    <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                    <td width="78%" colspan="2" style="text-align: left; font-size:12px; ">
                        Rp.{{ number_format($data['paguplus'], 2, ',', '.') }}</td>
                </tr> --}}
            </table>
        </td>
    </tr>
    <tr><td style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;"><br></td></tr>
    </table>
    <table border="" cellpadding="2" cellspacing="0" width='100%'>
        <tr>
            <td width="20%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Indikator</td>
            <td width="64%" colspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Tolok Ukur Kinerja</td>
            <td width="16%" colspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Target Kinerja</td>
        </tr>
        <tr>
            <td width="32%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Sebelum Perubahan</td>
            <td width="32%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Setelah Perubahan</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Sebelum Perubahan</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                Setelah Perubahan</td>
        </tr>
        <tr>
            <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
                Masukan</td>
            <td colspan="2" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                Dana yang dibutuhkan</td>
            <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                Rp.{{ number_format($data['paguskg_sebelum'], 2, ',', '.') }}</td>
            <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                Rp.{{ number_format($data['paguskg'], 2, ',', '.') }}</td>
        </tr>
        @foreach ($data['keluaran'] as $ikeg)
            @if ($loop->first)
                <tr>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Keluaran
                    </td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $ikeg['nmindikator_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                    {{ $ikeg['nmindikator_sesudah'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($ikeg['target_sebelum'], 2, ',', '.') }} {{ $ikeg['satuan_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($ikeg['target_sesudah'], 2, ',', '.') }} {{ $ikeg['satuan_sesudah'] }}</td>
                </tr>
            @else
                <tr>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $ikeg['nmindikator_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $ikeg['nmindikator_sesudah'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($ikeg['target_sebelum'], 2, ',', '.') }} {{ $ikeg['satuan_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($ikeg['target_sesudah'], 2, ',', '.') }} {{ $ikeg['satuan_sesudah'] }}</td>
                </tr>
            @endif
        @endforeach
        @foreach ($data['hasil'] as $iprog)
            @if ($loop->first)
                <tr>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Hasil
                    </td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $iprog['nmindikator_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $iprog['nmindikator_sesudah'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                    {{ number_format($iprog['target_sebelum'], 2, ',', '.') }} {{ $iprog['satuan_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($iprog['target_sesudah'], 2, ',', '.') }} {{ $iprog['satuan_sesudah'] }}</td>
                </tr>
            @else
                <tr>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"></td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $iprog['nmindikator_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                        {{ $iprog['nmindikator_sesudah'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($iprog['target_sebelum'], 2, ',', '.') }} {{ $iprog['satuan_sebelum'] }}</td>
                    <td style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                        {{ number_format($iprog['target_sesudah'], 2, ',', '.') }} {{ $iprog['satuan_sesudah'] }}</td>
                    </tr>
            @endif
        @endforeach
        <tr height=15>
            <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
                Kelompok Sasaran</td>
            <td colspan="4" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
            </td>
        </tr>
        <tr>
            <td style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;"><br>
            </td>
            <td colspan="4" style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
            </td>
        </tr>
    </table>
    @if(!empty($data['subkeg']))
    @foreach ($data['subkeg'] as $sub)
    <table border="1" cellpadding="4" cellspacing="0" width='100%'
                    style="page-break-inside: avoid !important;">
                    <tr>
                        <td width="20%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Sub
                            Kegiatan</td>
                        <td colspan="2" width="80%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                            {{ $sub['kdsubkegiatan'] }} {{ $sub['nmsubkegiatan'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Sumber
                            Pendanaan</td>
                        <td colspan="2" width="80%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                            {{ $sub['sumberdana'] }}</td>
                    </tr>
                    <tr>
                        <td width="20%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Lokasi
                        </td>
                        <td colspan="2" width="80%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                            {{ $sub['lokasi'] }}</td>
                    </tr>
                    @foreach ($sub['keluaran'] as $isub)
                        @if ($loop->first)
                            <tr>
                                <td width="20%"
                                    style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
                                    Keluaran Sub Kegiatan</td>
                                <td width="65%"
                                    style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                                    {{ $isub['nmindikator'] }}</td>
                                <td width="15%"
                                    style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                                    {{ number_format($isub['target'], 2, ',', '.') }} {{ $isub['satuan'] }}</td>
                            </tr>
                        @else
                            <tr>
                                <td width="20%"
                                    style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
                                </td>
                                <td width="65%"
                                    style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">
                                    {{ $isub['nmindikator'] }}</td>
                                <td width="15%"
                                    style="font-size:12px; text-align: right; vertical-align:middle; font-weight: normal;">
                                    {{ number_format($isub['target'], 2, ',', '.') }} {{ $isub['satuan'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td width="20%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">Waktu
                            Pelaksanaan</td>
                        <td colspan="2" width="80%"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: normal;">Mulai
                            {{ $sub['mulai'] }} Sampai {{ $sub['akhir'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"
                            style="font-size:12px; text-align: left; vertical-align:middle; font-weight: bold;">
                            Keterangan</td>
                    </tr>
                </table>
                <table border="1" cellpadding="4" cellspacing="0" width='100%'>
                    <thead>
                        <tr height=19>
                            <td width="10%" rowspan="3"
                                style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                KODE REKENING</td>
                            <td width="30%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;">
                                URAIAN</td>
                            <td width="22%" colspan="4" style="font-size:12px; text-align: center; font-weight: bold;">
                                SEBELUM PERUBAHAN</td>
                            <td width="22%" colspan="4" style="font-size:12px; text-align: center; font-weight: bold;">
                                SETELAH PERUBAHAN</td>
                            <td width="16%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;">
                                BERTAMBAH / BERKURANG </td>
                        </tr>
                        <tr height=19>
                            <td width="15%" colspan="3" style="font-size:12px; text-align: center; font-weight: bold;">
                                RINCIAN PERHITUNGAN</td>
                            <td width="7%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">
                                JUMLAH</td>
                            <td width="15%" colspan="3" style="font-size:12px; text-align: center; font-weight: bold;">
                                RINCIAN PERHITUNGAN</td>
                            <td width="7%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">
                                JUMLAH</td>
                            <td width="8%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">
                                (RP)</td>
                            <td width="8%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">
                                %</td>
                        </tr>
                        <tr height=19>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                VOLUME</td>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                SATUAN</td>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                HARGA SATUAN</td>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                VOLUME</td>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                SATUAN</td>
                            <td width="5%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                                HARGA SATUAN</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub['rincian'] as $rinc)
                        <?php $jumlahkode = strlen($rinc->kode); ?>
						<?php $kodelevel = $rinc->kdlevel; ?>
                        <tr>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1 or $kodelevel==10){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>19) {
                                }else{ ?>
                                {{ $rinc->kode }}
                                <?php } ?>
                            </td>
                            <td style="font-size:12px;  text-align: justify;  <?php if($kodelevel==1 or $kodelevel==10){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                {{ $rinc->uraian }}
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ number_format($rinc->jml_volume_sebelum, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ $rinc->satuan_sebelum }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?>font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ number_format($rinc->harga_sebelum, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; <?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?> font-size:12px; font-weight: normal; <?php } ?> font-style:normal;">
                                {{ number_format($rinc->jumlah_sebelum, 2, ',', '.') }}
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ number_format($rinc->jml_volume_setelah, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="font-size:12px;  text-align: left; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?> font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ $rinc->satuan_setelah }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; font-size:12px; <?php if($kodelevel==1){ ?> font-weight: bold; <?php }else{?> font-weight: normal; <?php } ?>text-align: right; font-style:normal;">
                                <?php if($jumlahkode>26) { ?>
                                    {{ number_format($rinc->harga_setelah, 2, ',', '.') }}
                                <?php }else{ } ?>
                            </td>
                            <td style="text-align: right; <?php if($kodelevel==1){ ?> font-size:11.5px;  font-weight: bold; <?php }else{?> font-size:12px; font-weight: normal; <?php } ?> font-style:normal;">
                                {{ number_format($rinc->jumlah_setelah, 2, ',', '.') }}
                            </td>
                            @if ($rinc->bertambah_berkurang < 0)
                            <td
                                style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                ({{ number_format($rinc->bertambah_berkurang * -1, 2, ',', '.') }})</td>
                            @else
                                <td
                                    style="<?php if($kodelevel==1){ ?>font-size:11.5px; font-weight: bold; <?php }else{?>font-size:12px; font-weight: normal; <?php } ?>vertical-align:top; text-align: right;">
                                    {{ number_format($rinc->bertambah_berkurang, 2, ',', '.') }}</td>
                            @endif

                            <?php
                            if ($rinc->jumlah_sebelum == 0) {
                                $persen = 0;
                            } else {
                                $persen = ($rinc->bertambah_berkurang / $rinc->jumlah_sebelum) * 100;
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
                    @endforeach
                    <tr>
                        <td colspan="2" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">Jumlah Belanja Sub Kegiatan</td>
                        <td colspan="4" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">
                            {{-- {{ number_format($sub['jumlah'], 2, ',', '.') }} --}}
                            {{ number_format($sub['jumlah_sebelum'], 2, ',', '.') }}
                        </td>
                        <td colspan="4" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;">
                            {{-- {{ number_format($sub['jumlah'], 2, ',', '.') }} --}}
                            {{ number_format($sub['jumlah_setelah'], 2, ',', '.') }}
                        </td>
                        <td colspan="2" style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;"></td>
                    </tr>
                    </tbody>
                </table>
                <table border="1" cellpadding="4" cellspacing="0" width='100%'>
                    <tr>
                        <td colspan='4' style="font-size:12px; text-align: right; vertical-align:middle; font-weight: bold;"><br>
                        </td>
                    </tr>
                </table>
            @endforeach
        @else
            <table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
                <tr>
                    <td width="100%"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;"><br>TIDAK
                        ADA DATA<br></td>
                </tr>
            </table>
        @endif
		{{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
        <tr>
            <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Penarikan Dana per Bulan *)</td>
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
            <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >Jumlah</td>
            <td style="border:0px solid black; text-align: right; font-size:12px; font-weight: bold;" >
                <?php $totalpenarikan=$data['query_penerimaan_penarikan'][0]->total_jan+$data['query_penerimaan_penarikan'][0]->total_feb+$data['query_penerimaan_penarikan'][0]->total_mar
                +$data['query_penerimaan_penarikan'][0]->total_apr+$data['query_penerimaan_penarikan'][0]->total_mei+$data['query_penerimaan_penarikan'][0]->total_jun+$data['query_penerimaan_penarikan'][0]->total_jul
                +$data['query_penerimaan_penarikan'][0]->total_aug+$data['query_penerimaan_penarikan'][0]->total_sep+$data['query_penerimaan_penarikan'][0]->total_okt+$data['query_penerimaan_penarikan'][0]->total_nov
                +$data['query_penerimaan_penarikan'][0]->total_des; ?>
                Rp. {{format_money($totalpenarikan,2)}}
            </td>
            <td style="border-bottom:0px solid black;border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
        </tr>

    </table>
    <table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">

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
		</table>--}}
    @endforeach
    </body>
<?php }// else jika idjnsdokumen selain 26
?>
