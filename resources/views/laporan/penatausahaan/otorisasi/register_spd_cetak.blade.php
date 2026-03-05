<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.bendahara.penerimaan.pdf_head')

<body>
    <table class="table table-borderless" style="width: 90%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    REGISTER SPD <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Periode <br>
                    {{ date('d-m-Y', strtotime($date1)) . ' - ' . date('d-m-Y', strtotime($date2)) }}
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" id="table-header" style="width: 90%">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="vertical-align: middle;width: 3px">No.
                </th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Nomor</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian</th>
                <th colspan="3" class="text-center" style="vertical-align: middle;">Jumlah</th>
                </th>
            </tr>
            <tr>
                <th class="text-center">UP</th>
                <th class="text-center">GU</th>
                <th class="text-center">LS</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no=1;
            $total_up=0;
            $total_gu=0;
            $total_ls=0;
            @endphp
            @if (count($regSpd) > 0)
            @foreach ($regSpd as $item)
            <tr>
                <td style="text-align: center">{{ $no++ }}</td>
                <td>{{ $item->dt_byro }}</td>
                <td>{{ $item->No_byro }}</td>
                <td>{{ $item->Ur_byro }}</td>
                <td style="text-align: right">{{ number_format($item->UP) }}</td>
                <td style="text-align: right">{{ number_format($item->GU) }}</td>
                <td style="text-align: right">{{ number_format($item->LS) }}</td>
            </tr>
            @php
            $total_up += $item->UP;
            $total_gu += $item->GU;
            $total_ls += $item->LS;
            @endphp
            @endforeach
            @else
            <tr>
                <td colspan="7" style="text-align: center">Data tidak ada</td>
            </tr>
            @endif
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan=4>Total</th>
                <th class="text-right">{{number_format($total_up, 0, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_gu, 0, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_ls, 0, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%">
        <tbody>
            <td colspan="8" style="text-align: center; width: 100%"></td>
            <td colspan="4" style="text-align: center">
                <strong>
                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }} <br><br><br>
                    Pejabat Keuangan BLUD
                    <br><br><br>
                    Nama<br>
                    NIP. ............
                    <br><br><br>
                </strong>
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