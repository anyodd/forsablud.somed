<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.bendahara.penerimaan.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN  <br>
                    (SPJ PENERIMAAN - FUNGSIONAL)  <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Bulan {{nm_bulan($bulan)}}<br>
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" style="font-size: 6pt">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px; vertical-align: middle" rowspan="2">Kode Rekening</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Uraian</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Jumlah Anggaran</th>
                <th class="text-center" style="vertical-align: middle" colspan ="3">Realisasi</th>
                <th class="text-center" style="vertical-align: middle" rowspan="2">Sisa Anggaran Yang Belum Terealisasi/Pelampauan Anggaran</th>
            </tr>
            <tr>
                <th class="text-center" style="vertical-align: middle">S/D Bulan Lalu</th>
                <th class="text-center" style="vertical-align: middle">Bulan Ini</th>
                <th class="text-center" style="vertical-align: middle">S/D Bulan Ini</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total5 = 0;
            @endphp
            @foreach ($data as $item => $list)
                <tr class="text-bold">
                    <td colspan="2">{{$item}}</td>
                    <td class="text-right">{{number_format($list['sub_anggaran'],2,',','.')}}</td>
                    <td class="text-right">{{number_format($list['sub_lalu'],2,',','.')}}</td>
                    <td class="text-right">{{number_format($list['sub_ini'],2,',','.')}}</td>
                    <td class="text-right">{{number_format($list['sub_now'],2,',','.')}}</td>
                    <td class="text-right">{{number_format($list['sub_sisa'],2,',','.')}}</td>
                </tr>
                @foreach ($list['rincian'] as $rinci => $ls)
                    <tr>
                        <td>{{$ls['uraian']->Ko_Rkk}}</td>
                        <td>{{$rinci}}</td>
                        <td class="text-right">{{number_format($ls['uraian']->Anggaran,2,',','.')}}</td>
                        <td class="text-right">{{number_format($ls['uraian']->real_lalu,2,',','.')}}</td>
                        <td class="text-right">{{number_format($ls['uraian']->real_ini,2,',','.')}}</td>
                        <td class="text-right">{{number_format($ls['uraian']->real_now,2,',','.')}}</td>
                        <td class="text-right">{{number_format($ls['uraian']->sisa,2,',','.')}}</td>
                    </tr>
                @endforeach
                @php
                    $total1 += $list['sub_anggaran'];
                    $total2 += $list['sub_lalu'];
                    $total3 += $list['sub_ini'];
                    $total4 += $list['sub_now'];
                    $total5 += $list['sub_sisa'];
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
                    Bendahara Penerimaan/<br>
                    Bendahara Penerimaan Pembantu
                    <br><br><br><br><br>
                    {{-- {{$pegawai[0]->Nm_Bend}}<br>
                    NIP. {{$pegawai[0]->NIP_Bend}} --}}
                    @if (!empty($bendahara[0]))
                        {{$bendahara[0]->Nm_Bend}}<br>
                        NIP. {{$bendahara[0]->NIP_Bend}}
                    @else
                        TTD <br>
                        NIP. -
                    @endif
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