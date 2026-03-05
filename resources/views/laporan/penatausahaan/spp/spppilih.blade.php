<div class="container py-4" style="background: white">
    <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
    <h4 class="my-0" style="text-align: center"><b>SURAT PERMINTAAN PEMBAYARAN {{ $spirc[0]->Ur_spi }}</b></h4>
    <h5 class="my-0" style="text-align: center">Nomor : {{ $spirc[0]->No_spi }}</h5><br>

    <div class="container px-4" style="font-size: 13pt">
        <div class="row">
            <p>Yth. Pemimpin BLUD</p>
            <p class="paragraph mb-0" style="text-align: justify">Dengan memperhatikan RBA <b>{{ nm_unit() }}</b> Nomor
                ..... tanggal .....,
                bersama
                ini kami mengajukan
                permintaan pembayaran sebagai berikut:</p>
        </div>
        <div class="row">
            <table class="table-borderless" style="width: 100%">
                <thead>
                    <tr>
                        <td class="td pl-0">a.</td>
                        <td>Subkegiatan</td>
                        <td>:</td>
                        <td>{{ $spirc[0]->Ko_sKeg2 }}</td>
                    </tr>
                    <tr>
                        <td class="td pl-0">b.</td>
                        <td>Tahun Anggaran</td>
                        <td>:</td>
                        <td>{{ $spirc[0]->Ko_Period }}</td>
                    </tr>
                    <tr>
                        <td class="td pl-0">c.</td>
                        <td>Pembayaran yang Diminta</td>
                        <td>:</td>
                        <td>{{ number_format($spirc[0]->total, 2, ",", ".") }}</td>
                    </tr>
                    <tr>
                        <td class="td pl-0"></td>
                        <td></td>
                        <td></td>
                        <td>(terbilang: <b>{{ terbilang(number_format($spirc[0]->total, 0, "", "")) . ' rupiah'
                                }}</b>)
                        </td>
                    </tr>
                    <tr>
                        <td class="td pl-0">d.</td>
                        <td>Nama dan Nomor Rekening Bank</td>
                        <td>:</td>
                        <td>........................................</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="row pt-2">
            <p class="paragraph" style="text-align: justify">Rincian belanja sebagai berikut:</p>
        </div>
        <div class="row">
            <div class="col-sm-6 pr-0pl-0">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" width="100%">
                        <thead style="text-align: center">
                            <tr style="height: 56pt">
                                <th rowspan="2" style="vertical-align: middle">No.</th>
                                <th rowspan="2" style="vertical-align: middle">Kode<br>Rekening</th>
                                <th rowspan="2" style="vertical-align: middle">Uraian</th>
                                <th rowspan="2" style="vertical-align: middle">Jumlah<br>Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                $total = 0;
                                ?>
                            @foreach ($spirc as $row)
                            <tr>
                                <td style="text-align: center">{{ $no }}</td>
                                <td style="text-align: center">{{ $row->Ko_Rkk }}</td>
                                <td style="text-align: left">{{ $row->ur_rk6 }}</td>
                                <td style="text-align: right">{{ number_format($row->spirc_Rp, 2, ",", '.') }}</td>
                            </tr>
                            <?php 
                            $no++;
                            $total += $row->spirc_Rp;
                            ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: center">TOTAL</th>
                                <th style="text-align: right">{{ number_format($total, 2, ",", ".") }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-sm-6 pl-1">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" width="100%">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="5">Potongan</th>
                            </tr>
                            <tr>
                                <th>PPN</th>
                                <th>PPh 21</th>
                                <th>PPh 22</th>
                                <th>PPh 23</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tax as $row)
                            <?php 
                            $ppn = 0;
                            $pph21 = 0;
                            $pph22 = 0;
                            $pph23 = 0;
                            $total = 0;
                            ?>
                            <tr>
                                <td style="text-align: right">{{ number_format($row->ppn, 2, ",", ".") != 0 ?
                                    number_format($row->ppn, 2, ",", ".") : '-' }}</td>
                                <td style="text-align: right">{{ number_format($row->pph21, 2, ",", ".") != 0 ?
                                    number_format($row->pph21, 2, ",", ".") : '-' }}</td>
                                <td style="text-align: right;">{{ number_format($row->pph22, 2, ",", ".") != 0 ?
                                    number_format($row->pph22, 2, ",", ".") : '-' }}</td>
                                <td style="text-align: right">{{ number_format($row->pph23, 2, ",", ".") != 0 ?
                                    number_format($row->pph23, 2, ",", ".") : '-' }}</td>
                                <td style="text-align: right">{{ number_format($row->total, 2, ",", ".") != 0 ?
                                    number_format($row->total, 2, ",", ".") : '-' }}</td>
                            </tr>
                            <?php 
                            $ppn += $row->ppn;
                            $pph21 += $row->pph21;
                            $pph22 += $row->pph22;
                            $pph23 += $row->pph23;
                            $total = $row->total;
                            ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align: right">{{ number_format($ppn, 2, ",", ".") != 0 ?
                                    number_format($ppn, 2, ",", ".") : '-' }}</th>
                                <th style="text-align: right">{{ number_format($pph21, 2, ",", ".") != 0 ?
                                    number_format($pph21, 2, ",", ".") : '-' }}</th>
                                <th style="text-align: right">{{ number_format($pph22, 2, ",", ".") != 0 ?
                                    number_format($pph22, 2, ",", ".") : '-' }}</th>
                                <th style="text-align: right">{{ number_format($pph23, 2, ",", ".") != 0 ?
                                    number_format($pph23, 2, ",", ".") : '-' }}</th>
                                <th style="text-align: right">{{ number_format($total, 2, ",", ".") != 0 ?
                                    number_format($total, 2, ",", ".") : '-' }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td style="text-align: center; padding-left: 0px">Disetujui Oleh<br>Pemimpin BLUD<br><br><br>{{
                            $spirc[0]->Nm_Pimp
                            }}<br>NIP. {{ $spirc[0]->NIP_Pimp }}</td>
                        <td></td>
                        <td style="text-align: center">Diverifikasi Oleh<br>Pejabat Keuangan<br><br><br>{{
                            $spirc[0]->Nm_Keu }}<br>NIP.
                            {{ $spirc[0]->NIP_Keu }}</td>
                        <td></td>
                        <td style="text-align: center; padding-right: 0px">{{ nm_ibukota() }}, {{
                            Carbon\Carbon::parse($spirc[0]->Dt_SPi)->format('j F Y')
                            }}<br>Pejabat
                            Keuangan<br><br><br>{{ $spirc[0]->Nm_Bend }}<br>NIP. {{ $spirc[0]->NIP_Bend }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>