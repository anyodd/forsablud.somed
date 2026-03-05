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
                        <tr>
                            <td style="text-align: center; font-size:14px; font-weight: bold;">RENCANA KERJA DAN
                                ANGGARAN</td>
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
                            <td style="font-size:14px; text-align: center; font-weight: bold;">FORMULIR</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px; text-align: center; font-weight: bold;">RKA SKPD</td>
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
                            <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_skpd'] }}</td>
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
                            <td style="text-align: center; font-size:12px; font-weight: bold;">RINGKASAN ANGGARAN
                                PENDAPATAN, BELANJA DAN PEMBIAYAAN</td>
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
                    <td width="10%"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">KODE
                        REKENING</td>
                    <td width="70%" style="font-size:12px; text-align: center; font-weight: bold;">URAIAN</td>
                    <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">JUMLAH (Rp) </td>
                </tr>
                <tr height=19>
                    <td width="10%"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">1</td>
                    <td width="70%" style="font-size:12px; text-align: center; font-weight: bold;">2</td>
                    <td width="20%" style="font-size:12px; text-align: center; font-weight: bold;">3</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['rek_1'] as $rek1)
                    <tr nobr="true">
                        <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">
                            {{ $rek1['kode_rekening'] }}</td>
                        <td width="70%" style="font-size:12px;  text-align: justify; font-weight: bold;">
                            {{ $rek1['nama_rekening'] }}</td>
                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: bold;">
                            {{ number_format($rek1['jumlah'], 2, ',', '.') }}</td>
                    </tr>
            <tbody>
                @foreach ($rek1['rek_2'] as $rek2)
                    <tr nobr="true">
                        <td width="10%"
                            style="font-size:12px;  text-align: left; font-weight: semibold; text-indent:5px;">
                            {{ $rek2['kode_rekening'] }}</td>
                        <td width="70%" style="font-size:12px;  text-align: justify; font-weight: semibold; ">
                            <p style="margin-left: 5px;">{{ $rek2['nama_rekening'] }}</p>
                        </td>
                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: semibold;">
                            {{ number_format($rek2['jumlah'], 2, ',', '.') }}</td>
                    </tr>
            <tbody>
                @foreach ($rek2['rek_3'] as $rek3)
                    <tr nobr="true">
                        <td width="10%"
                            style="font-size:12px;  text-align: left; font-weight: normal; text-indent:12px;">
                            {{ $rek3['kode_rekening'] }}</td>
                        <td width="70%" style="font-size:12px;  text-align: justify; font-weight: normal;">
                            <p style="margin-left: 12px;">{{ $rek3['nama_rekening'] }}</p>
                        </td>
                        <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal;">
                            {{ number_format($rek3['jumlah'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
    @endforeach
    </tbody>
    @endforeach
    </tbody>
    <tbody>
        <tr nobr="true">
            <td width="10%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            <td width="70%" style="font-size:12px; text-align: right; font-weight: bold;">SURPLUS / ( DEFISIT )</td>
            @if ($data['surplus'] < 0)
                <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['surplus'] * -1, 2, ',', '.') }})</td>
            @else
                <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['surplus'], 2, ',', '.') }}</td>
            @endif
        </tr>
    </tbody>
    <tbody>
        @foreach ($data['rek_16'] as $rek16)
            <tr nobr="true">
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: bold;">
                    {{ $rek16['kode_rekening'] }}</td>
                <td width="70%" style="font-size:12px;  text-align: justify; font-weight: bold;">
                    {{ $rek16['nama_rekening'] }}</td>
                <td width="20%" style="font-size:12px;  text-align: right; font-weight: bold;">
                    {{ number_format($rek16['jumlah'], 2, ',', '.') }}</td>
            </tr>
    <tbody>
        @foreach ($rek16['rek_2'] as $rek26)
            <tr nobr="true">
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: semibold; text-indent:5px;">
                    {{ $rek26['kode_rekening'] }}</td>
                <td width="70%" style="font-size:12px;  text-align: justify; font-weight: semibold;">
                    <p style="margin-left: 5px;">{{ $rek26['nama_rekening'] }}</p>
                </td>
                <td width="20%" style="font-size:12px;  text-align: right; font-weight: semibold;">
                    {{ number_format($rek26['jumlah'], 2, ',', '.') }}</td>
            </tr>
    <tbody>
        @foreach ($rek26['rek_3'] as $rek36)
            <tr nobr="true">
                <td width="10%" style="font-size:12px;  text-align: left; font-weight: normal; text-indent:12px;">
                    {{ $rek36['kode_rekening'] }}</td>
                <td width="70%" style="font-size:12px;  text-align: justify; font-weight: normal; ">
                    <p style="margin-left: 12px;">{{ $rek36['nama_rekening'] }}</p>
                </td>
                <td width="20%" style="font-size:12px;  text-align: right; font-weight: normal;">
                    {{ number_format($rek36['jumlah'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    @endforeach
    </tbody>
    @endforeach
    </tbody>
    <tbody>
        @if ($data['jml_biaya_netto'] != null)
            <tr nobr="true">
                <td width="10%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td width="70%" style="font-size:12px; text-align: right; font-weight: bold;">PEMBIAYAAN NETO</td>
                @if ($data['jml_biaya_netto'] < 0)
                    <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($data['jml_biaya_netto'] * -1, 2, ',', '.') }})</td>
                @else
                    <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['jml_biaya_netto'], 2, ',', '.') }}</td>
                @endif
            </tr>
        @endif
    </tbody>
    <tbody>
        <tr nobr="true">
            <td width="10%" style="font-size:12px; text-align: left; font-weight: bold;"></td>
            <td width="70%" style="font-size:12px; text-align: right; font-weight: bold;">SISA LEBIH PEMBIAYAAN ANGGARAN
                TAHUN BERJALAN</td>
            @if ($data['silpa'] < 0)
                <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['silpa'] * -1, 2, ',', '.') }})</td>
            @else
                <td width="20%" style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['silpa'], 2, ',', '.') }}</td>
            @endif
        </tr>
    </tbody>
    </table>
    <br>
    <br nobr="true">
    {{--<table style="font-size:12px; font-weight: bold; page-break-inside: avoid !important;" nobr="true" width="100%">
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
    </table>--}}
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
                            <td style="font-size:14px; text-align: center; font-weight: bold;">FORMULIR</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px; text-align: center; font-weight: bold;">RKAP SKPD</td>
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
                            <td width="58%" style="text-align: left; font-size:12px; ">{{ $data['uraian_skpd'] }}</td>
                        </tr>
                        @if ($data['kode_unit'] != null)
                            <tr>
                                <td width="20%" style="text-align: left; font-size:12px; font-weight: bold;">Unit
                                    Organisasi</td>
                                <td width="2%" style="text-align: center; font-size:12px; ">:</td>
                                <td width="20%" style="text-align: left; font-size:12px; ">{{ $data['kode_unit'] }}
                                </td>
                                <td width="78%" style="text-align: left; font-size:12px; ">{{ $data['uraian_unit'] }}
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
                            <td style="text-align: center; font-size:12px; font-weight: bold;">RINGKASAN RENCANA KERJA
                                ANGGARAN PERUBAHAN</td>
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
                    <td width="10%" rowspan="2"
                        style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">KODE
                        REKENING</td>
                    <td width="40%" rowspan="2" style="font-size:12px; text-align: center; font-weight: bold;">URAIAN
                    </td>
                    <td width="30%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;">JUMLAH
                        (Rp)</td>
                    <td width="20%" colspan="2" style="font-size:12px; text-align: center; font-weight: bold;">BERTAMBAH
                        / (BERKURANG)</td>
                </tr>
                <tr height=19>
                    <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;">SEBELUM PERUBAHAN
                    </td>
                    <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;">SETELAH PERUBAHAN
                    </td>
                    <td width="15%" style="font-size:12px; text-align: center; font-weight: bold;">(Rp)</td>
                    <td width="5%" style="font-size:12px; text-align: center; font-weight: bold;">%</td>
                </tr>
                <tr height=19>
                    <td style="font-size:12px; text-align: center; vertical-align:middle; font-weight: bold;">1</td>
                    <td style="font-size:12px; text-align: center; font-weight: bold;">2</td>
                    <td style="font-size:12px; text-align: center; font-weight: bold;">3</td>
                    <td style="font-size:12px; text-align: center; font-weight: bold;">4</td>
                    <td style="font-size:12px; text-align: center; font-weight: bold;">5</td>
                    <td style="font-size:12px; text-align: center; font-weight: bold;">6</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['rek_1'] as $rek1)
                    <tr nobr="true">
                        <td style="font-size:12px;  text-align: left; font-weight: bold;">
                            {{ $rek1['kode_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: justify; font-weight: bold;">
                            {{ $rek1['nama_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">
                            {{ number_format($rek1['jumlah_sebelum'], 2, ',', '.') }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: bold;">
                            {{ number_format($rek1['jumlah_setelah'], 2, ',', '.') }}</td>
                        @if ($rek1['bertambah_berkurang'] < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">
                                ({{ number_format($rek1['bertambah_berkurang'] * -1, 2, ',', '.') }})
                            </td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">
                                {{ number_format($rek1['bertambah_berkurang'], 2, ',', '.') }}</td>
                        @endif

                        <?php
                        if ($rek1['jumlah_sebelum'] == 0) {
                            $persen = 0;
                        } else {
                            $persen = ($rek1['bertambah_berkurang'] / $rek1['jumlah_sebelum']) * 100;
                        } ?>
                        @if ($persen < 0)
                            <td style="font-size:12px; text-align: right; font-weight: bold;">
                                ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: bold;">
                                {{ number_format($persen, 2, ',', '.') }}</td>
                        @endif
                    </tr>
            <tbody>
                @foreach ($rek1['rek_2'] as $rek2)
                    <tr nobr="true">
                        <td style="font-size:12px;  text-align: left; font-weight: semibold; text-indent:5px;">
                            {{ $rek2['kode_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: justify; font-weight: semibold; ">
                            <p style="margin-left: 5px;">{{ $rek2['nama_rekening'] }}</p>
                        </td>
                        <td style="font-size:12px;  text-align: right; font-weight: semibold;">
                            {{ number_format($rek2['jumlah_sebelum'], 2, ',', '.') }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: semibold;">
                            {{ number_format($rek2['jumlah_setelah'], 2, ',', '.') }}</td>
                        @if ($rek2['bertambah_berkurang'] < 0)
                            <td style="font-size:12px; text-align: right; font-weight: semibold;">
                                ({{ number_format($rek2['bertambah_berkurang'] * -1, 2, ',', '.') }})
                            </td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: semibold;">
                                {{ number_format($rek2['bertambah_berkurang'], 2, ',', '.') }}</td>
                        @endif

                        <?php
                        if ($rek2['jumlah_sebelum'] == 0) {
                            $persen = 0;
                        } else {
                            $persen = ($rek2['bertambah_berkurang'] / $rek2['jumlah_sebelum']) * 100;
                        } ?>
                        @if ($persen < 0)
                            <td style="font-size:12px; text-align: right; font-weight: semibold;">
                                ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: semibold;">
                                {{ number_format($persen, 2, ',', '.') }}</td>
                        @endif
                    </tr>
            <tbody>
                @foreach ($rek2['rek_3'] as $rek3)
                    <tr nobr="true">
                        <td style="font-size:12px;  text-align: left; font-weight: normal; text-indent:12px;">
                            {{ $rek3['kode_rekening'] }}</td>
                        <td style="font-size:12px;  text-align: justify; font-weight: normal;">
                            <p style="margin-left: 12px;">{{ $rek3['nama_rekening'] }}</p>
                        </td>
                        <td style="font-size:12px;  text-align: right; font-weight: normal;">
                            {{ number_format($rek3['jumlah_sebelum'], 2, ',', '.') }}</td>
                        <td style="font-size:12px;  text-align: right; font-weight: normal;">
                            {{ number_format($rek3['jumlah_setelah'], 2, ',', '.') }}</td>
                        @if ($rek3['bertambah_berkurang'] < 0)
                            <td style="font-size:12px; text-align: right; font-weight: normal;">
                                ({{ number_format($rek3['bertambah_berkurang'] * -1, 2, ',', '.') }})
                            </td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: normal;">
                                {{ number_format($rek3['bertambah_berkurang'], 2, ',', '.') }}</td>
                        @endif

                        <?php
                        if ($rek3['jumlah_sebelum'] == 0) {
                            $persen = 0;
                        } else {
                            $persen = ($rek3['bertambah_berkurang'] / $rek3['jumlah_sebelum']) * 100;
                        } ?>
                        @if ($persen < 0)
                            <td style="font-size:12px; text-align: right; font-weight: normal;">
                                ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                        @else
                            <td style="font-size:12px; text-align: right; font-weight: normal;">
                                {{ number_format($persen, 2, ',', '.') }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
    @endforeach
    </tbody>
    @endforeach
    </tbody>
    <tbody>
        <tr nobr="true">
            <td style="font-size:12px; text-align: left; font-weight: bold;"></td>
            <td style="font-size:12px; text-align: right; font-weight: bold;">SURPLUS / ( DEFISIT )</td>
            @if ($data['surplus_sebelum'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['surplus_sebelum'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['surplus_sebelum'], 2, ',', '.') }}</td>
            @endif

            @if ($data['surplus_setelah'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['surplus_setelah'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['surplus_setelah'], 2, ',', '.') }}</td>
            @endif

            @if ($data['surplus_bertambah_berkurang'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['surplus_bertambah_berkurang'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['surplus_bertambah_berkurang'], 2, ',', '.') }}</td>
            @endif

            <?php if ($data['surplus_sebelum'] == 0) {
                $persen = 0;
            } else {
                $persen = ($data['surplus_bertambah_berkurang'] / $data['surplus_sebelum']) * 100;
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
    <tbody>
        @foreach ($data['rek_16'] as $rek16)
            <tr nobr="true">
                <td style="font-size:12px;  text-align: left; font-weight: bold;">{{ $rek16['kode_rekening'] }}</td>
                <td style="font-size:12px;  text-align: justify; font-weight: bold;">{{ $rek16['nama_rekening'] }}
                </td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;">
                    {{ number_format($rek16['jumlah_sebelum'], 2, ',', '.') }}</td>
                <td style="font-size:12px;  text-align: right; font-weight: bold;">
                    {{ number_format($rek16['jumlah_setelah'], 2, ',', '.') }}</td>
                @if ($rek16['bertambah_berkurang'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($rek16['bertambah_berkurang'] * -1, 2, ',', '.') }})
                    </td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($rek16['bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif


                <?php
                if ($rek16['jumlah_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen = ($rek16['bertambah_berkurang'] / $rek16['jumlah_sebelum']) * 100;
                } ?>
                @if ($persen < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
    <tbody>
        @foreach ($rek16['rek_2'] as $rek26)
            <tr nobr="true">
                <td style="font-size:12px;  text-align: left; font-weight: semibold; text-indent:5px;">
                    {{ $rek26['kode_rekening'] }}</td>
                <td style="font-size:12px;  text-align: justify; font-weight: semibold;">
                    <p style="margin-left: 5px;">{{ $rek26['nama_rekening'] }}</p>
                </td>
                <td style="font-size:12px;  text-align: right; font-weight: semibold;">
                    {{ number_format($rek26['jumlah_sebelum'], 2, ',', '.') }}</td>
                <td style="font-size:12px;  text-align: right; font-weight: semibold;">
                    {{ number_format($rek26['jumlah_setelah'], 2, ',', '.') }}</td>
                @if ($rek26['bertambah_berkurang'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: semibold;">
                        ({{ number_format($rek26['bertambah_berkurang'] * -1, 2, ',', '.') }})
                    </td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: semibold;">
                        {{ number_format($rek26['bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php
                if ($rek26['jumlah_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen = ($rek26['bertambah_berkurang'] / $rek26['jumlah_sebelum']) * 100;
                } ?>
                @if ($persen < 0)
                    <td style="font-size:12px; text-align: right; font-weight: semibold;">
                        ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: semibold;">
                        {{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
    <tbody>
        @foreach ($rek26['rek_3'] as $rek36)
            <tr nobr="true">
                <td style="font-size:12px;  text-align: left; font-weight: normal; text-indent:12px;">
                    {{ $rek36['kode_rekening'] }}</td>
                <td style="font-size:12px;  text-align: justify; font-weight: normal; ">
                    <p style="margin-left: 12px;">{{ $rek36['nama_rekening'] }}</p>
                </td>
                <td style="font-size:12px;  text-align: right; font-weight: normal;">
                    {{ number_format($rek36['jumlah_sebelum'], 2, ',', '.') }}</td>
                <td style="font-size:12px;  text-align: right; font-weight: normal;">
                    {{ number_format($rek36['jumlah_setelah'], 2, ',', '.') }}</td>
                @if ($rek36['bertambah_berkurang'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: normal;">
                        ({{ number_format($rek36['bertambah_berkurang'] * -1, 2, ',', '.') }})
                    </td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: normal;">
                        {{ number_format($rek36['bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php
                if ($rek36['jumlah_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen = ($rek36['bertambah_berkurang'] / $rek36['jumlah_sebelum']) * 100;
                } ?>
                @if ($persen < 0)
                    <td style="font-size:12px; text-align: right; font-weight: normal;">
                        ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: normal;">
                        {{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
    @endforeach
    </tbody>
    @endforeach
    </tbody>
    <tbody>
        @if ($data['jml_biaya_netto_sebelum'] != null || $data['jml_biaya_netto_setelah'] != null)
            <tr nobr="true">
                <td style="font-size:12px; text-align: left; font-weight: bold;"></td>
                <td style="font-size:12px; text-align: right; font-weight: bold;">PEMBIAYAAN NETO</td>
                @if ($data['jml_biaya_netto_sebelum'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($data['jml_biaya_netto_sebelum'] * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['jml_biaya_netto_sebelum'], 2, ',', '.') }}</td>
                @endif

                @if ($data['jml_biaya_netto_setelah'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($data['jml_biaya_netto_setelah'] * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['jml_biaya_netto_setelah'], 2, ',', '.') }}</td>
                @endif

                @if ($data['jml_biaya_netto_bertambah_berkurang'] < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($data['jml_biaya_netto_bertambah_berkurang'] * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($data['jml_biaya_netto_bertambah_berkurang'], 2, ',', '.') }}</td>
                @endif

                <?php if ($data['jml_biaya_netto_sebelum'] == 0) {
                    $netto_sebelumtidaknol = 1;
                } else {
                    $netto_sebelumtidaknol = $data['jml_biaya_netto_sebelum'];
                } ?>

                <?php
                if ($data['jml_biaya_netto_sebelum'] == 0) {
                    $persen = 0;
                } else {
                    $persen = ($data['jml_biaya_netto_bertambah_berkurang'] / $data['jml_biaya_netto_sebelum']) * 100;
                } ?>

                @if ($persen < 0)
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        ({{ number_format($persen * -1, 2, ',', '.') }})</td>
                @else
                    <td style="font-size:12px; text-align: right; font-weight: bold;">
                        {{ number_format($persen, 2, ',', '.') }}</td>
                @endif
            </tr>
        @endif
    </tbody>
    <tbody>
        <tr nobr="true">
            <td style="font-size:12px; text-align: left; font-weight: bold;"></td>
            <td style="font-size:12px; text-align: right; font-weight: bold;">SISA LEBIH PEMBIAYAAN ANGGARAN TAHUN
                BERJALAN</td>
            @if ($data['silpa_sebelum'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['silpa_sebelum'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['silpa_sebelum'], 2, ',', '.') }}</td>
            @endif

            @if ($data['silpa_setelah'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['silpa_setelah'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['silpa_setelah'], 2, ',', '.') }}</td>
            @endif

            @if ($data['silpa_bertambah_berkurang'] < 0)
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    ({{ number_format($data['silpa_bertambah_berkurang'] * -1, 2, ',', '.') }})</td>
            @else
                <td style="font-size:12px; text-align: right; font-weight: bold;">
                    {{ number_format($data['silpa_bertambah_berkurang'], 2, ',', '.') }}</td>
            @endif

            <?php
            if ($data['silpa_sebelum'] == 0) {
                $persen = 0;
            } else {
                $persen = ($data['silpa_bertambah_berkurang'] / $data['silpa_sebelum']) * 100;
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
    <br>
    <br nobr="true">
    {{--<table style="font-size:12px; font-weight: bold; page-break-inside: avoid !important;" nobr="true" width="100%">
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
    </table>--}}
    @endforeach
</body>
<?php } ?>
