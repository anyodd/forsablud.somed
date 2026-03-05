<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    REGISTER KONTRAK <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Periode <br>
                    {{ date('d-m-Y', strtotime($date1)) . ' - ' . date('d-m-Y', strtotime($date2)) }}
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" id="table-header" style="font-size: 9pt">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px; vertical-align: middle">No.</th>
                <th class="text-center" style="vertical-align: middle">No.<br>Kontrak</th>
                <th class="text-center" style="vertical-align: middle">Tgl.<br>Kontrak</th>
                <th class="text-center" style="vertical-align: middle">Uraian</th>
                <th class="text-center" style="vertical-align: middle">Nama<br>Rekanan</th>
                <th class="text-center" style="vertical-align: middle">Kode<br>Kegiatan</th>
                <th class="text-center" style="vertical-align: middle">Uraian<br>Kegiatan</th>
                <th class="text-center" style="vertical-align: middle">Nilai<br>Kontrak (Rp)</th>
                <th class="text-center" style="vertical-align: middle">Nilai<br>Termin (Rp)</th>
                <th class="text-center" style="vertical-align: middle">Nilai<br>OPD (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_kontrak = 0;
            $total_termin = 0;
            $total_spm = 0;
            @endphp
            @if (count($regKontrak) > 0)
            @foreach ($regKontrak as $item)
            <tr>
                <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}</td>
                <td>{{ $item->No_contr }}</td>
                <td class="text-center">{{ $item->dt_contr }}</td>
                <td>{{ $item->Ur_contr }}</td>
                <td>{{ $item->rekan_nm }}</td>
                <td class="text-center">{{ $item->Ko_Rkk }}</td>
                <td>{{ $item->Ur_Rk6 }}</td>
                <td style="text-align: right">{{ number_format($item->Nilai_Kontrak) }}</td>
                <td style="text-align: right">{{ number_format($item->Nilai_Termin) }}</td>
                <td style="text-align: right">{{ number_format($item->Nilai_SPM) }}</td>
            </tr>
            @php
            $total_kontrak += $item->Nilai_Kontrak;
            $total_termin += $item->Nilai_Termin;
            $total_spm += $item->Nilai_SPM;
            @endphp
            @endforeach
            @else
            <tr>
                <td colspan="10" style="text-align: center">Data tidak ada</td>
            </tr>
            @endif
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan=7>Total</th>
                <th class="text-right">{{number_format($total_kontrak, 0, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_termin, 0, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_spm, 0, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%">
        <tbody>
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