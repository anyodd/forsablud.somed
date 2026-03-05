<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN  <br>
                    (SPJ BELANJA - FUNGSIONAL)  <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Bulan {{nm_bulan($bulan)}}<br>
                </td>
            </tr>
        </thead>
    </table>
    {{-- <table class="table table-bordered" style="font-size: 6pt">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px; vertical-align: middle" rowspan="2">Kode Rekening</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Uraian</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Jumlah Anggaran</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">SPJ s.d Lalu</th>
                <th class="text-center" style="vertical-align: middle" colspan ="2">SPJ Ini</th>
                <th class="text-center" style="vertical-align: middle" rowspan ="2">S.D SPJ Ini</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Sisa Pagu Anggaran</th>
            </tr>
            <tr>
                <th class="text-center" style="vertical-align: middle">LS</th>
                <th class="text-center" style="vertical-align: middle">TU/GU Nihil</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
            $total6 = 0;
        @endphp
        @foreach ($data as $item => $list)
            <tr class="text-bold">
                <td colspan="2">{{$item}}</td>
                <td class="text-right">{{number_format($list['sub_anggaran'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_lalu'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_ls'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_gu'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_now'],2,',','.')}}</td>
                <td class="text-right">{{number_format($list['sub_sisa'],2,',','.')}}</td>
            </tr>
            @foreach ($list['rincian'] as $rinci => $ls)
                <tr>
                    <td>{{$ls['uraian']->Ko_Rkk}}</td>
                    <td>{{$rinci}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->Anggaran,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_lalu,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_LS,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_GU,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->real_now,2,',','.')}}</td>
                    <td class="text-right">{{number_format($ls['uraian']->sisa,2,',','.')}}</td>
                </tr>
            @endforeach
            @php
                $total1 += $list['sub_anggaran'];
                $total2 += $list['sub_lalu'];
                $total3 += $list['sub_ls'];
                $total4 += $list['sub_gu'];
                $total5 += $list['sub_now'];
                $total6 += $list['sub_sisa'];
            @endphp
        @endforeach
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan="2">Jumlah</th>
                <th class="text-right">{{number_format($total1, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total2, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total3, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total4, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total5, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total6, 2, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br> --}}
    <table class="table table-bordered" style="font-size: 6pt">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px; vertical-align: middle" rowspan="2">Kode Rekening</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Uraian</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Jumlah Anggaran</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">SPJ s.d Lalu</th>
                <th class="text-center" style="vertical-align: middle" colspan ="2">SPJ Ini</th>
                <th class="text-center" style="vertical-align: middle" rowspan ="2">S.D SPJ Ini</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Sisa Pagu Anggaran</th>
            </tr>
            <tr>
                <th class="text-center" style="vertical-align: middle">LS</th>
                <th class="text-center" style="vertical-align: middle">TU/GU Nihil</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
            $total6 = 0;
        @endphp
        @foreach ($data as $kegiatan => $keg)
            <tr class="text-bold">
                <td colspan="2">{{$kegiatan}}</td>
                <td class="text-right">{{number_format($keg['t_ang'],2,',','.')}}</td>
                <td colspan="5"></td>
            </tr>
            @foreach ($keg['rincian1'] as $aktivitas => $akt)
                <tr class="text-bold">
                    <td colspan="2">&nbsp;&nbsp;{{$aktivitas}}</td>
                    <td class="text-right">{{number_format($akt['t_ang'],2,',','.')}}</td>
                    <td colspan="5"></td>
                </tr>
                @foreach ($akt['rincian2'] as $rk5 => $rk_5)
                    <tr class="text-bold">
                        <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;{{$rk5}}</td>
                        <td class="text-right">{{number_format($rk_5['t_ang'],2,',','.')}}</td>
                        <td colspan="5"></td>
                    </tr>
                    @foreach ($rk_5['rincian3'] as $rk6 => $ls)
                        <tr>
                            <td class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$ls['uraian']->Ko_Rkk}}</td>
                            <td>{{$rk6}}</td>
                            <td class="text-right">{{number_format($ls['t_ang'],2,',','.')}}</td>
                            <td class="text-right">{{number_format($ls['sub_lalu'],2,',','.')}}</td>
                            <td class="text-right">{{number_format($ls['sub_ls'],2,',','.')}}</td>
                            <td class="text-right">{{number_format($ls['sub_gu'],2,',','.')}}</td>
                            <td class="text-right">{{number_format($ls['sub_now'],2,',','.')}}</td>
                            <td class="text-right">{{number_format($ls['sub_sisa'],2,',','.')}}</td>
                        </tr>
                        @php
                            $total1 += $ls['t_ang'];
                            $total2 += $ls['sub_lalu'];
                            $total3 += $ls['sub_ls'];
                            $total4 += $ls['sub_gu'];
                            $total5 += $ls['sub_now'];
                            $total6 += $ls['sub_sisa'];
                        @endphp
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan="2">Jumlah</th>
                <th class="text-right">{{number_format($total1, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total2, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total3, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total4, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total5, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total6, 2, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%;font-size: 6pt">
        <tbody>
            <td colspan="4" style="text-align: center">
                <strong>Disetujui oleh,<br>
                    Pengguna Anggara/Kuasa<br>
                    Pengguna Anggaran
                    <br><br><br><br><br>
                    {{$pegawai[0]->Nm_Pimp}}<br>
                    NIP. {{$pegawai[0]->NIP_Pimp}}
                    <br><br><br></strong>
            </td>
            <td colspan="4" style="text-align: center">
                <strong>Disiapkan oleh,<br>
                    Bendahara Pengeluaran/<br>
                    Bendahara Pengeluaran Pembantu
                    <br><br><br><br><br>
                    {{$pegawai[0]->Nm_Bend}}<br>
                    NIP. {{$pegawai[0]->NIP_Bend}}
                    <br><br><br></strong>
            </td>
        </tbody>
    </table>
    <footer class="pb-0">
        <?php date_default_timezone_set("Asia/Jakarta") ?>
        Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
    </footer>
    
    <!-- menampilan halaman x dari total halaman, config/dompdf -> line 201: "enable_php" => true,  -->
    <script type="text/php">
            if (isset($pdf)) {
          $x = 520;
          $y = 815; // posisi bawah 815
          $text = "Halaman {PAGE_NUM} - {PAGE_COUNT}";
          $font = null;
          $size = 8;
          $color = array(0,0,0);
          $word_space = 0.0;  //  default
          $char_space = 0.0;  //  default
          $angle = 0.0;   //  default
          $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>