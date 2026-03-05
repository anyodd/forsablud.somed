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
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >FORMULIR</td></tr>
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >DPA-BELANJA SKPD</td></tr>
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
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >REKAPITULASI DOKUMEN PELAKSANAAN ANGGARAN BELANJA BERDASARKAN PROGRAM, KEGIATAN DAN SUBKEGIATAN</td></tr>
            {{-- <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr> --}}
        </table>
    </td>
</tr>
</table>
<table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <thead>
        <tr height=19>
            <td width="8%" rowspan="3" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >KODE</td>
            <td width="18%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;" >URAIAN</td>
            <td width="10%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;" >SUMBER DANA</td>
            <td width="10%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;" >LOKASI</td>
            <td width="54%" colspan="7" style="font-size:12px; text-align: center; font-weight: bold;" >JUMLAH (Rp) </td>
        </tr>
        <tr height=19>
            <td width="7%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >TAHUN-1</td>
            <td width="40%" colspan="5" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >TAHUN N</td>
            <td width="7%" rowspan="2" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >TAHUN+1</td>
        </tr>
        <tr height=19>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >BELANJA OPERASI</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >BELANJA MODAL</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >BELANJA TIDAK TERDUGA</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >BELANJA TRANSFER</td>
            <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;" >JUMLAH</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['urusan'] as $urs)
        <?php $jumlahkode=strlen($urs->kode);?>
            <tr>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ $urs->kode }}</td>
                <?php if($jumlahkode<=12){ ?>
                <td width="18%" colspan="3" style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ $urs->uraian }}</td>
                <?php }else{ ?>
                    <td width="18%" style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ $urs->uraian }}</td>
                    <td width="10%" style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ $urs->sumberdana }}</td>
                    <td width="10%" style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ $urs->lokasi }}</td>
                <?php } ?>
                <td width="7%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    <?php if($jumlahkode<=12){ ?>
                    <?php }else{ ?>
                        {{ number_format($urs->pagu_min, 2, ',', '.') }}
                    <?php } ?>
                </td>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ number_format($urs->jml_operasi, 2, ',', '.') }}</td>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ number_format($urs->jml_modal, 2, ',', '.') }}</td>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ number_format($urs->jml_tidak, 2, ',', '.') }}</td>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ number_format($urs->jml_transfer, 2, ',', '.') }}</td>
                <td width="8%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">{{ number_format($urs->jml_belanja, 2, ',', '.') }}</td>
                <td width="7%" style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    <?php if($jumlahkode<=12){ ?>
                    <?php }else{ ?>
                        {{ number_format($urs->pagu_plus, 2, ',', '.') }}
                    <?php } ?>
                </td>
            </tr>
        @endforeach
        <tr>
            <td width="8%" colspan="4" style="font-size:12px; text-align: right; font-weight: bold;">JUMLAH</td>
            <td width="7%" style="font-size:12px; text-align: right; font-weight: bold;"></td>
            <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['operasi'], 2, ',', '.') }}</td>
            <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['modal'], 2, ',', '.') }}</td>
            <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['tidak_terduga'], 2, ',', '.') }}</td>
            <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['transfer'], 2, ',', '.') }}</td>
            <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">{{ number_format($data['belanja'], 2, ',', '.') }}</td>
            <td width="7%" style="font-size:12px; text-align: right; font-weight: bold;"></td>
        </tr>
    </tbody>
</table>

{{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Penarikan Dana per Bulan *)</td>
        <td colspan="2" style="border-right:0px solid black;border-top:0px solid black;text-align: center; width:30%; font-size:12px;"></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; width:7%; font-size:12px;" >Januari</td>
        <td style="border:0px solid black;text-align: right; width:18%; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jan,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['nmibukota'] }}, {{ date_indo($tgl_ttd) }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Februari</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_feb,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Maret</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mar,2)}}</td>
        <td style="text-align: center; font-size:12px;" >Disetujui oleh,</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Disiapkan oleh,</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >April</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_apr,2)}}</td>
        <td style="text-align: center; font-size:12px;" >Pengguna Anggaran</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >PPKD</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Mei</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mei,2)}}</td>
        <td style="text-align: center; font-size:12px;" >{{ $data['PAjab'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Juli</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jul,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Agustus</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_aug,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >September</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_sep,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Oktober</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_okt,2)}}</td>
        <td style="text-align: center; font-size:12px;" >{{ $data['PAnama'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PPKDnama'] }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >November</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_nov,2)}}</td>
        <td style="text-align: center; font-size:12px;" >NIP {{ $data['PAnip'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Desember</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_des,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
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
        <td colspan="2" style="border-right:0px solid black;border-bottom:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>

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
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >FORMULIR</td></tr>
            <tr><td style="font-size:14px; text-align: center; font-weight: bold;" >DPPA-BELANJA SKPD</td></tr>
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
            <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >REKAPITULASI DOKUMEN PELAKSANAAN PERUBAHAN ANGGARAN BELANJA BERDASARKAN PROGRAM, KEGIATAN DAN SUBKEGIATAN</td></tr>
            {{-- <tr><td style="text-align: center; font-size:12px; font-weight: bold;" >SATUAN KERJA PERANGKAT DAERAH</td></tr> --}}
        </table>
    </td>
</tr>
</table>

<table border="1" cellpadding="4" cellspacing="0" width='100%'>
    <thead>
        <tr height=19>
            <td width="8%" rowspan="2"
                style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">KODE</td>
            <td width="33%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">URAIAN
            </td>
            <td width="15%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">SUMBER
                DANA</td>
            <td width="12%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">LOKASI
            </td>
            <td width="18%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;">JUMLAH
                (Rp)</td>
            <td width="14%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;">BERTAMBAH
                / (BERKURANG)</td>
        </tr>
        <tr height=19>
            <td width="9%" style="font-size:12px; text-align: center; font-weight: bold;">SEBELUM PERUBAHAN</td>
            <td width="9%" style="font-size:12px; text-align: center; font-weight: bold;">SETELAH PERUBAHAN</td>
            <td width="9%" style="font-size:12px; text-align: center; font-weight: bold;">Rp</td>
            <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">%</td>
        </tr>
        <tr height=19>
            <td style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">1</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">2</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">3</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">4</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">5</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">6</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">7</td>
            <td style="font-size:12px; text-align: center; font-weight: bold;">8</td>
        </tr>
    </thead>
    <tbody>
        <?php $total_sebelum = $total_setelah = $total_bertambah_berkurang = 0; ?>
        @foreach ($data['urusan'] as $urs)
            <?php $jumlahkode = strlen($urs->kode); ?>
            <tr>
                <td
                    style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ $urs->kode }}</td>
                <?php if($jumlahkode<=12){ ?>
                <td colspan="3"
                    style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ $urs->uraian }}</td>
                <?php }else{ ?>
                <td
                    style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ $urs->uraian }}</td>
                <td
                    style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ $urs->sumberdana }}</td>
                <td
                    style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ $urs->lokasi }}</td>
                <?php } ?>
                <td
                    style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ number_format($urs->jumlah_sebelum, 2, ',', '.') }}</td>
                <td
                    style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                    {{ number_format($urs->jumlah_setelah, 2, ',', '.') }}</td>
                @if ($urs->bertambah_berkurang < 0)
                    <td
                        style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                        ({{ number_format($urs->bertambah_berkurang * -1, 2, ',', '.') }})</td>
                @else
                    <td
                        style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                        {{ number_format($urs->bertambah_berkurang, 2, ',', '.') }}</td>
                @endif

                <?php
                if ($urs->jumlah_sebelum == 0) {
                    $persen = 0;
                } else {
                    $persen = ($urs->bertambah_berkurang / $urs->jumlah_sebelum) * 100;
                } ?>

                @if ($persen < 0)
                    <td
                        style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                        ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                @else
                    <td
                        style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                        {{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
            <?php
            if ($jumlahkode == 1) {
                $total_sebelum = $total_sebelum + $urs->jumlah_sebelum;
                $total_setelah = $total_setelah + $urs->jumlah_setelah;
                $total_bertambah_berkurang = $total_bertambah_berkurang + $urs->bertambah_berkurang;
            } ?>
        @endforeach
        <tr>
            <td colspan="4" style="font-size:12px; text-align: right; font-weight: bold;">JUMLAH</td>
            <td style="font-size:12px; text-align: right; font-weight: bold;">
                {{ number_format($total_sebelum, 2, ',', '.') }}</td>
            <td style="font-size:12px; text-align: right; font-weight: bold;">
                {{ number_format($total_setelah, 2, ',', '.') }}</td>
            @if ($total_bertambah_berkurang < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($total_bertambah_berkurang * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($total_bertambah_berkurang, 2, ',', '.') }}</td>
            @endif

            <?php
            if ($total_sebelum == 0) {
                $persen = 0;
            } else {
                $persen = ($total_bertambah_berkurang / $total_sebelum) * 100;
            } ?>

            @if ($persen < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($persen * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($persen, 2, ',', '.') }}</td>
            @endif
        </tr>
    </tbody>
</table>

{{--<table border="0" cellpadding="4" cellspacing="0" width="100%" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2" style="border:0px solid black;text-align: center; width:70%; font-size:12px; font-weight: bold;" >Rencana Penarikan Dana per Bulan *)</td>
        <td colspan="2" style="border-right:0px solid black;border-top:0px solid black;text-align: center; width:30%; font-size:12px;"></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; width:7%; font-size:12px;" >Januari</td>
        <td style="border:0px solid black;text-align: right; width:18%; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jan,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['nmibukota'] }}, {{ date_indo($tgl_ttd) }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Februari</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_feb,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Maret</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mar,2)}}</td>
        <td style="text-align: center; font-size:12px;" >Disetujui oleh,</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >Disiapkan oleh,</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >April</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_apr,2)}}</td>
        <td style="text-align: center; font-size:12px;" >Pengguna Anggaran</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >PPKD</td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Mei</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_mei,2)}}</td>
        <td style="text-align: center; font-size:12px;" >{{ $data['PAjab'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black;text-align: left; font-size:12px;" >Juni</td>
        <td style="border:0px solid black;text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jun,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Juli</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_jul,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Agustus</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_aug,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >September</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_sep,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Oktober</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_okt,2)}}</td>
        <td style="text-align: center; font-size:12px;" >{{ $data['PAnama'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >{{ $data['PPKDnama'] }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >November</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_nov,2)}}</td>
        <td style="text-align: center; font-size:12px;" >NIP {{ $data['PAnip'] }}</td>
        <td style="border-right:0px solid black;text-align: center; font-size:12px;" >NIP {{ $data['PPKDnip'] }}</td>
    </tr>
    <tr>
        <td style="border:0px solid black; text-align: left; font-size:12px;" >Desember</td>
        <td style="border:0px solid black; text-align: right; font-size:12px;" >
                Rp. {{format_money($data['query_penerimaan_penarikan'][0]->total_des,2)}}</td>
        <td colspan="2" style="border-right:0px solid black;text-align: center; font-size:12px;" ></td>
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
        <td colspan="2" style="border-right:0px solid black;border-bottom:0px solid black;text-align: center; font-size:12px;" ></td>
    </tr>

</table>

<br>
<table border="0" cellpadding="2" cellspacing="6" width=100%>
    <tr>
    <td width="100%" style="text-align: justify; font-size:12px; " >*) Sesuai dengan periodisasi SPD</td>
    </tr>
</table>--}}

@endforeach
</body>
<?php }// else jika idjnsdokumen selain 2
?>
