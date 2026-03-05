<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 90%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    DAFTAR TAGIHAN <br>
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
                <td rowspan="2" class="text-center" style="width: 2px">No</td>
                <td colspan="7" class="text-center">Uraian</td>
                <td rowspan="2" class="text-center">Nilai</td>
            </tr>
            <tr>
                <td class="text-center">Uraian</td>
                <td class="text-center">Tanggal Tagihan</td>
                <td class="text-center">Tanggal JT</td>
                <td class="text-center">Nama Pihak Ketiga</td>
                <td class="text-center">Uraian Kegiatan/Belanja</td>
                <td class="text-center">Kode Rek</td>
                <td class="text-center">Uraian Rek</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 3px">1</td>
                <td class="text-center" style="width: 4px">2</td>
                <td class="text-center">3</td>
                <td class="text-center">4</td>
                <td class="text-center">5</td>
                <td class="text-center">6</td>
                <td class="text-center">7</td>
                <td class="text-center">8</td>
                <td class="text-center">9</td>
            </tr>
        </thead>
        <tbody>
            @if (count($gbtagih) > 0)
            @foreach ($gbtagih as $gr => $tagih)
            <tr>
                <td style="text-align: left">{{ $loop->iteration }}.</td>
                <td colspan="6"><strong style="color: black"> {{ $gr }} -
                        {{ $tagih['jns'] }} </strong>
                </td>
                <td colspan="5" style="text-align: right"> <strong style="color: black">
                        {{ number_format($tagih['subtotal']) }} </strong> </td>
            </tr>
            @foreach ($tagih['rincian'] as $item)
            <tr>
                <td style="text-align: left"></td>
                <td style="text-align: left">({{ $loop->iteration }} ).</td>
                <td>{{ $item->dt_bp }}</td>
                <td>{{ $item->dt_jt }}</td>
                <td>{{ $item->Nm_BUcontr }}</td>
                <td style="text-align: left">{{ $item->Ur_KegBL2 }}</td>
                <td style="text-align: left">{{ $item->Ko_Rkk }}</td>
                <td style="text-align: left">{{ $item->Ur_Rk6 }}</td>
                <td style="text-align: right">
                    {{ number_format($item->Total) }}
                </td>
            </tr>
            @endforeach
            @endforeach
            @else
            <tr>
                <td colspan="9" style="text-align: center">Data tidak ada</td>
            </tr>
            @endif
        
            <tr>
                <td style="text-align: left"></td>
                <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                <td colspan="5" style="text-align: right"> <strong style="color: blue">{{ number_format($total) }} </strong>
                </td>
            </tr>
        </tbody>
        {{-- alternatif 3 --}}
        <tfoot>
            <tr>
                <td style="text-align: left"></td>
                <td colspan="6"> <strong style="color: blue"> </strong></td>
                <td colspan="5" style="text-align: center"> <strong>
                        {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                        <br>
                        Direktur {{ nm_unit() }}
                        <br><br><br>
                        ttd
                        <br><br>
                        {{ $footer[0]->Nm_Pimp }}
                        <br>
                        {{ $footer[0]->NIP_Pimp }}
                    </strong>
                </td>
            </tr>
        
        </tfoot>
    </table><br><br>
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