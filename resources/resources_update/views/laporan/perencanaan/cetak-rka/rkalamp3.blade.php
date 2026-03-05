<html>

<head>
    <style>
        table,
        tr,
        td,
        th,
        tbody,
        thead,
        tfoot {
            border-collapse: collapse;
            font-family: Tahoma, sans-serif;
        }

        tr,
        th,
        tbody,
        thead,
        tfoot {
            page-break-inside: avoid !important;
        }

    </style>
</head>
<?php
// dd($rkaperubahan_req);
if($rkaperubahan_req==null){ ?>

<body>
    @foreach ($model as $data)
        <br>
        <table border="1" cellpadding="4" width="100%">
            <tr>
                <td width="75%" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr><td style="text-align: center; font-size:14px; font-weight: bold;">RENCANA KERJA DAN ANGGARAN</td></tr>
                        <tr><td style="text-align: center; font-size:14px; font-weight: bold;">SATUAN KERJA PERANGKAT DAERAH</td></tr>
                    </table>
                </td>
                <td width="25%" rowspan="2" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr><td style="font-size:14px; text-align: center; font-weight: bold;">REKAPITULASI</td></tr>
                        <tr><td style="font-size:14px; text-align: center; font-weight: bold;">RKA BELANJA SKPD</td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="60%" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr><td style="text-align: center; font-size:14px; font-weight: bold; text-transform:uppercase;">{{ $data['nama_pemda'] }}</td></tr>
                        <tr><td style="text-align: center; font-size:14px; font-weight: bold;">TAHUN ANGGARAN {{ $data['tahun'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table border="" cellpadding="2" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="2" cellspacing="0">
                        <tr>
                            <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">ORGANISASI</td>
                            <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                            <td width="20%" style="text-align: left; font-size:12px; ">{{ $data['kode_skpd'] }}</td>
                            <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_skpd'] }}</td>
                        </tr>
                        @if ($data['kode_unit'] != null)
                         <tr>
                            <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">UNIT ORGANISASI</td>
                            <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                            <td width="20%" style="text-align: left; font-size:12px; ">{{ $data['kode_unit'] }}</td>
                            <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_unit'] }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="2" width="100%">
                        <tr><td style="text-align: center; font-size:12px; font-weight: bold;">REKAPITULASI ANGGARAN BELANJA BERDASARKAN PROGRAM DAN KEGIATAN</td></tr>
                        <tr><td style="text-align: center; font-size:12px; font-weight: bold;">SATUAN KERJA PERANGKAT DAERAH</td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <table border="1" cellpadding="4" cellspacing="0" width='100%'>
            <thead>
                <tr height=19>
                    <td width="8%" rowspan="3"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">KODE</td>
                    <td width="18%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;">URAIAN
                    </td>
                    <td width="10%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;">SUMBER
                        DANA</td>
                    <td width="10%" rowspan="3" style="font-size:12px; text-align: center; font-weight: bold;">LOKASI
                    </td>
                    <td width="54%" colspan="7" style="font-size:12px; text-align: center; font-weight: bold;">JUMLAH
                        (Rp) </td>
                </tr>
                <tr height=19>
                    <td width="7%" rowspan="2"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">TAHUN-1
                    </td>
                    <td width="40%" colspan="5"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">TAHUN N
                    </td>
                    <td width="7%" rowspan="2"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">TAHUN+1
                    </td>
                </tr>
                <tr height=19>
                    <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                        BELANJA OPERASI</td>
                    <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                        BELANJA MODAL</td>
                    <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                        BELANJA TIDAK TERDUGA</td>
                    <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                        BELANJA TRANSFER</td>
                    <td width="8%" style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">
                        JUMLAH</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['urusan'] as $urs)
                    <?php $jumlahkode = strlen($urs->kode); ?>
                    <tr>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ $urs->kode }}</td>
                        <?php if($jumlahkode<=12){ ?>
                        <td width="18%" colspan="3"
                            style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ $urs->uraian }}</td>
                        <?php }else{ ?>
                        <td width="18%"
                            style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ $urs->uraian }}</td>
                        <td width="10%"
                            style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ $urs->sumberdana }}</td>
                        <td width="10%"
                            style="font-size:12px; vertical-align:top; text-align: left; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ $urs->lokasi }}</td>
                        <?php } ?>
                        <td width="7%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            <?php if($jumlahkode<=12){ ?>
                            <?php }else{ ?>
                            {{ number_format($urs->pagu_min, 2, ',', '.') }}
                            <?php } ?>
                        </td>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ number_format($urs->jml_operasi, 2, ',', '.') }}</td>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ number_format($urs->jml_modal, 2, ',', '.') }}</td>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ number_format($urs->jml_tidak, 2, ',', '.') }}</td>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ number_format($urs->jml_transfer, 2, ',', '.') }}</td>
                        <td width="8%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            {{ number_format($urs->jml_belanja, 2, ',', '.') }}</td>
                        <td width="7%"
                            style="font-size:12px; vertical-align:top; text-align: right; <?php if($jumlahkode<=4){ ?> font-weight: bold; <?php }else{?> font-weight: semibold;<?php } ?>">
                            <?php if($jumlahkode<=12){ ?>
                            <?php }else{ ?>
                            {{ number_format($urs->pagu_plus, 2, ',', '.') }}
                            <?php } ?>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td width="8%" colspan="4" style="font-size:12px; text-align: right; font-weight: semibold;">JUMLAH
                    </td>
                    <td width="7%" style="font-size:12px; text-align: right; font-weight: bold;"></td>
                    <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['operasi'], 2, ',', '.') }}</td>
                    <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['modal'], 2, ',', '.') }}</td>
                    <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['tidak_terduga'], 2, ',', '.') }}</td>
                    <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['transfer'], 2, ',', '.') }}</td>
                    <td width="8%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['belanja'], 2, ',', '.') }}</td>
                    <td width="7%" style="font-size:12px; text-align: right; font-weight: bold;"></td>
                </tr>
            </tbody>
        </table>
        <table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
		{{--<tr>
                <td colspan="5"><br>
                    <table style="font-size:12px; font-weight: bold;" width="100%">
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center; font-weight: normal;">{{ $kota }},
                                {{ date_indo($tgl_ttd) }}</td>
                        </tr>
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center;">{{ $jabatan }}</td>
                        </tr>
                        <tr>
                            <td height="60"></td>
                        </tr>
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center;">{{ $pejabat }}</td>
                        </tr>
                    </table>
                </td>
		</tr>--}}
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: bold;">Pembahasan </td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Tanggal :</td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Catatan :</td>
            </tr>
            <tr height="100">
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: center; font-weight: normal;">Tim Anggaran Pemerintah
                    Daerah</td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">No</td>
                <td width="25" style="font-size:12px; text-align: center; font-weight: bold;">Nama</td>
                <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">NIP</td>
                <td width="30%" style="font-size:12px; text-align: center; font-weight: bold;">Jabatan</td>
                <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">Tanda Tangan</td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">1</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">2</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">3</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">4</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">5</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">6</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
        </table>
    @endforeach
</body>
<?php }// punya if centang perubahan 0
else{ ?>

<body>
    @foreach ($model as $data)
        <br>
        <table border="1" cellpadding="4" width="100%">
            <tr>
                <td width="75%" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr>
                            <td style="text-align: center; font-size:14px; font-weight: bold;">RENCANA KERJA ANGGARAN
                                PERUBAHAN</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-size:14px; font-weight: bold;">SATUAN KERJA PERANGKAT
                                DAERAH</td>
                        </tr>
                    </table>
                </td>
                <td width="25%" rowspan="2" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr>
                            <td style="font-size:14px; text-align: center; font-weight: bold;">REKAPITULASI</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px; text-align: center; font-weight: bold;">RKAP BELANJA SKPD</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="60%" align="center" vertical-align="middle">
                    <table border="0" width="100%">
                        <tr>
                            <td
                                style="text-align: center; font-size:14px; font-weight: bold; text-transform:uppercase;">
                                {{ $data['nama_pemda'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-size:14px; font-weight: bold;">TAHUN ANGGARAN
                                {{ $data['tahun'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table border="" cellpadding="2" width="100%">
            <tr>
                <td>
                    <table border="0" cellpadding="2" cellspacing="0">
                        <tr>
                            <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">ORGANISASI</td>
                            <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                            <td width="20%" style="text-align: left; font-size:12px; ">{{ $data['kode_skpd'] }}</td>
                            <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_skpd'] }}
                            </td>
                        </tr>
                        @if ($data['kode_unit'] != null)
                            <tr>
                                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">UNIT
                                    ORGANISASI</td>
                                <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                                <td width="20%" style="text-align: left; font-size:12px; ">{{ $data['kode_unit'] }}
                                </td>
                                <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_unit'] }}
                                </td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="2" width="100%">
                        <tr>
                            <td style="text-align: center; font-size:12px; font-weight: bold;">REKAPITULASI RENCANA
                                KERJA ANGGARAN PERUBAHAN BELANJA BERDASARKAN PROGRAM DAN KEGIATAN</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-size:12px; font-weight: bold;">SATUAN KERJA PERANGKAT
                                DAERAH</td>
                        </tr>
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
        <table border="1" cellpadding="4" cellspacing="0" width='100%' style="page-break-inside: avoid !important;">
		{{--<tr>
                <td colspan="5"><br>
                    <table style="font-size:12px; font-weight: bold;" width="100%">
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center; font-weight: normal;">{{ $kota }},
                                {{ date_indo($tgl_ttd) }}</td>
                        </tr>
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center;">{{ $jabatan }}</td>
                        </tr>
                        <tr>
                            <td height="60"></td>
                        </tr>
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" style="text-align: center;">{{ $pejabat }}</td>
                        </tr>
                    </table>
                </td>
		</tr>--}}
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: bold;">Pembahasan </td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Tanggal :</td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;">Catatan :</td>
            </tr>
            <tr height="100">
                <td colspan="5" style="font-size:12px; text-align: left; font-weight: normal;"></td>
            </tr>
            <tr>
                <td colspan="5" style="font-size:12px; text-align: center; font-weight: normal;">Tim Anggaran Pemerintah
                    Daerah</td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">No</td>
                <td width="25" style="font-size:12px; text-align: center; font-weight: bold;">Nama</td>
                <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">NIP</td>
                <td width="30%" style="font-size:12px; text-align: center; font-weight: bold;">Jabatan</td>
                <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">Tanda Tangan</td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">1</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">2</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">3</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">4</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">5</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
            <tr>
                <td width="5%" style="font-size:12px; text-align: left; font-weight: bold;">6</td>
                <td width="25" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="30%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="20%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            </tr>
        </table>
    @endforeach
</body>
<?php } ?>
