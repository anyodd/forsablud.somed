<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 90%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    BUKU KAS UMUM <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Periode <br>
                    {{ date('d-m-Y', strtotime($date1)) . ' - ' . date('d-m-Y', strtotime($date2)) }}
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" id="table-header" style="width: 100%; font-size: 9px">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px">No.</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">No.Bukti</th>
                <th class="text-center">Uraian</th>
                <th class="text-center">Penerimaan</th>
                <th class="text-center">Pengeluaran</th>
                <th class="text-center">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $total = 0;
            $total_penerimaan = 0;
            $total_pengeluaran = 0;
            @endphp
            @if (count($data) > 0)
            @foreach ($data as $item)
            <tr>
                <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                <td>{{ $item->Tgl_Bukti }}</td>
                <td>{{ $item->No_Bukti }}</td>
                <td>{{ $item->Uraian }}</td>
                <td style="text-align: right">{{ number_format($item->Terima,2,',','.') }}</td>
                <td style="text-align: right">{{ number_format($item->Keluar,2,',','.') }}</td>
                <td style="text-align: right">
                    {{ number_format($total += $item->Terima - $item->Keluar,2,',','.') }}
                </td>
            </tr>
            @php
            $total_penerimaan += $item->Terima;
            $total_pengeluaran += $item->Keluar;
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
                <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_pengeluaran, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%">
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
                    Rp {{number_format($total, 0, ',', '.')}}<br>
                    (Terbilang: {{ ucwords(terbilang($total)) }} Rupiah)<br>
                    {{-- terdiri dari : <br>
                    a. Tunai : Rp. ...........<br>
                    b. Bank : Rp. ...........<br> --}}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">
                    <strong>Disetujui oleh,<br>
                        Pengguna Anggara/<br>
                        Kuasa Pengguna Anggaran
                        <br><br><br><br>
                        {{ tb_sub('Nm_Pimp') }}<br>
                        NIP {{ tb_sub('NIP_Pimp') }}
                        <br><br><br></strong>
                </td>
                <td colspan="4" style="text-align: center">
                    <strong>Disiapkan oleh,<br>
                        Bendahara Pengeluaran/<br>
                        Bendahara Pengeluaran Pembantu
                        <br><br><br><br>
                        {{ tb_sub('Nm_Bend') }}<br>
                        NIP {{ tb_sub('NIP_Bend') }}
                        <br><br><br></strong>
                </td>
            </tr>
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