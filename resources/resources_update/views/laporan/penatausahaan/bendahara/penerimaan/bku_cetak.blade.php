<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.bendahara.penerimaan.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
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
    <table class="table table-sm table-bordered" style="width: 100%; font-size: 9px" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center" style="width: 3%">No.</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">No.Bukti</th>
                <th class="text-center">Kode Rekening</th>
                <th class="text-center">Uraian</th>
                <th class="text-center">Penerimaan</th>
                <th class="text-center">Pengeluaran</th>
                <th class="text-center">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            $total_penerimaan = 0;
            $total_pengeluaran = 0;
            @endphp
            @if (count($data) > 0)
            @foreach ($data as $item)
            <tr>
                <td class="text-center">{{$loop->iteration}}.</td>
                <td class="text-center">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
                <td>{{$item->No_Bukti}}</td>
                <td class="text-center">{{$item->Ko_Rkk}}</td>
                <td>{{$item->Ur_bprc}}</td>
                <td class="text-right">{{number_format($item->Terima, 2, ',', '.')}}</td>
                <td class="text-right">{{number_format($item->Keluar, 2, ',', '.')}}</td>
                <td class="text-right">{{number_format($total +=$item->Terima - $item->Keluar, 2, ',', '.')}}</td>
            </tr>
            @php
            $total_penerimaan += $item->Terima;
            $total_pengeluaran += $item->Keluar;
            @endphp
            @endforeach
            @else
            <tr>
                <td colspan="8" style="text-align: center">Data tidak ada</td>
            </tr>
            @endif
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan="5">Total</th>
                <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total_pengeluaran, 2, ',', '.')}}</th>
                <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td colspan="8">Saldo Kas di Bendahara Penerimaan/Bendahara Penerimaan Pembantu <br>
                </td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td colspan="7">
                    Rp. {{number_format($total,2,',', '.')}}<br>
                    (Terbilang {{ucwords(terbilang($total))}} Rupiah)<br>
                    {{-- terdiri dari : <br>
                    a. Tunai : Rp. ...........<br>
                    b. Bank : Rp. ...........<br> --}}
                </td>
            </tr>
            <tr>
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