<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    BUKU PEMBANTU PER SUB RINCIAN OBJEK <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" id="table-header" style="font-size: 8pt">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px">No.</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">No.Bukti</th>
                <th class="text-center">Uraian</th>
                <th class="text-center">Belanja LS</th>
                <th class="text-center">Belanja UP/GU</th>
                <th class="text-center">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_ls = 0;
                $total_gu = 0;
                $total_sisa = 0;
            @endphp
            @if (count($data) > 0)
                @foreach ($data as $item)
                <tr>
                    <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                    <td>{{ $item->dt_rftrbprc }}</td>
                    <td>{{ $item->No_bp }}</td>
                    <td>{{ $item->Ur_bprc }}</td>
                    <td style="text-align: right">{{ number_format($item->real_LS, 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($item->real_GU, 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($item->sisa, 2, ',', '.') }}
                    </td>
                </tr>
            @php
                $total_ls += $item->real_LS;
                $total_gu += $item->real_GU;
                $total_sisa += $item->sisa;
            @endphp
                @endforeach
            @else
                <tr><td colspan="7" style="text-align: center">Data tidak ada</td></tr>    
            @endif
            </tbody>
            <tfoot style="background-color: #1db790">
                <tr>
                    <th class="text-center" colspan=4>Total</th>
                    <th class="text-right">{{number_format($total_ls, 2, ',', '.')}}</th>
                    <th class="text-right">{{number_format($total_gu, 2, ',', '.')}}</th>
                    <th class="text-right">{{number_format($total_sisa, 2, ',', '.')}}</th>
                </tr>
            </tfoot>
    </table><br><br>
    {{-- <table style="width: 100%">
        <tbody>
            <tr>
                <td colspan="8">Saldo Kas di Bendahara Pengeluaran/Bendahara Pengeluaran
                    Pembantu
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td colspan="7">
                    Rp........<br>
                    (Terbilang: ..............)<br>
                    terdiri dari : <br>
                    a. Tunai : Rp. ...........<br>
                    b. Bank : Rp. ...........<br>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">
                    <strong>Disetujui oleh,<br>
                        Pengguna Anggara/Kuasa<br>
                        Pengguna Anggaran
                        <br><br><br>
                        Nama<br>
                        NIP. ............
                        <br><br><br></strong>
                </td>
                <td colspan="4" style="text-align: center">
                    <strong>Disiapkan oleh,<br>
                        Bendahara Pengeluaran/<br>
                        Bendahara Pengeluaran Pembantu
                        <br><br><br>
                        Nama<br>
                        NIP. ............
                        <br><br><br></strong>
                </td>
            </tr>
        </tbody>
    </table> --}}
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