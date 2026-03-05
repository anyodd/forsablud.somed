<div class="container py-4" style="background: white">
    <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
    <h4 class="my-0" style="text-align: center"><b>SURAT PERINTAH MEMBAYAR {{ $oto[0]->Ur_spi }}</b></h4>
    <h5 class="my-0" style="text-align: center">TAHUN ANGGARAN {{ Tahun() }}</h5><br>

    <div class="container px-4" style="font-size: 13pt">
        <div class="row justify-content-end">
            <p class="mb-0">Nomor: {{ $oto[0]->No_oto }}</p>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" width="100%">
                    <tbody>
                        <tr>
                            <td colspan="3" style="padding-top: 0; padding-bottom: 0">Kepada Pejabat Keuangan<br>{{
                                nm_unit() }}<br>{{
                                nm_ibukota() }}</td>
                            <td colspan="4" style="padding-top: 0; padding-bottom: 0">Potongan-Potongan</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">Supaya
                                membayarkan<br>{{ $oto[0]->Ur_spi }}<br>kepada: {{ $oto[0]->Trm_Nm }}</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                No.</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Kode<br>Rekening</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Uraian</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah<br>(Rp)</td>
                        </tr>
                        <?php 
                        $no = 1;
                        $total_tax = 0;
                        ?>
                        @foreach ($tax as $row)
                        @if ($no == 1)
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Bendahara Pengeluaran/Pihak Ketiga<br>{{ nm_unit() }}</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $no }}</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->Ko_Rkk }}</td>
                            <td style="text-align: left; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->ur_rk6 }}</td>
                            <td style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ number_format($row->tax_Rp, 2, ",", ".") }}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0"></td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $no }}</td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->Ko_Rkk }}</td>
                            <td style="text-align: left; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->ur_rk6 }}</td>
                            <td style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ number_format($row->tax_Rp, 2, ",", ".") }}</td>
                        </tr>
                        @endif
                        <?php
                        $no++;
                        $total_tax += $row->tax_Rp;
                        ?>
                        @endforeach
                        <tr>
                            <td rowspan="3" colspan="3"
                                style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Nomor
                                Rekening:<br>{{ $oto[0]->Trm_rek }}<br>Bank:<br>{{ $oto[0]->Trm_bank }}<br>NPWP:<br>{{
                                $oto[0]->Trm_NPWP }}
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Dasar Pembayaran:<br>......................
                            </td>
                            <td colspan="3"
                                style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah
                            </td>
                            <td colspan=""
                                style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ number_format($total_tax, 2, ",", ".") }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Untuk Keperluan:<br>{{ $oto[0]->keperluan }}
                            </td>
                            <td rowspan="2" colspan="4"
                                style="text-align: left; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                <b>Catatan:<br>Tidak mengurangi jumlah pembayaran SPM
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Pembebanan pada kode rekening:
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Kode<br>Rekening
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Uraian
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah<br>(Rp)
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                No.
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Kode<br>Rekening
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Uraian
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah<br>(Rp)
                            </td>
                            <?php 
                            $total = 0;
                            ?>
                            @foreach ($oto as $row)
                        <tr>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->Ko_Rkk }}
                            </td>
                            <td style="text-align: left; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ $row->ur_rk6 }}
                            </td>
                            <td style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ number_format($row->spirc_Rp, 2, ",", ".") }}
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                .....
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                .....
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                .....
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                .....
                            </td>
                        </tr>

                        <?php 
                            $total += $row->spirc_Rp    
                            ?>
                        @endforeach
                        <tr>
                            <td colspan="2"
                                style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah SPP yang diminta
                            </td>
                            <td style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                {{ number_format($total, 2, ",", ".") }}
                            </td>
                            <td colspan="3"
                                style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Jumlah SPM
                            </td>
                            <td style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                ..........
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Nomor dan Tanggal SPP:<br>{{ $oto[0]->No_SPi }}, {{
                                Carbon\Carbon::parse($oto[0]->Dt_SPi)->format('j F Y') }}
                            </td>
                            <td colspan="4" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                Terbilang:<br>{{ terbilang(number_format($total, 0, "", "")) . ' rupiah'
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                            </td>
                            <td colspan="4" style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                {{ nm_ibukota() }}, {{ Carbon\Carbon::parse($oto[0]->Dt_oto)->format('j F Y')
                                }}<br>Pimpinan
                                BLUD<br><br><br>{{ $oto[0]->Nm_Pimp }}<br>NIP. {{ $oto[0]->NIP_Pimp }}</td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>