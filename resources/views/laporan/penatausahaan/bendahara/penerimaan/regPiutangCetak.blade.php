<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.bendahara.penerimaan.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    REGISTER STS <br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Periode <br>
                    {{ date('d-m-Y', strtotime($date1)) . ' - ' . date('d-m-Y', strtotime($date2)) }}
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered" id="table-header" style="font-size: 9px" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center" style="width: 3px; vertical-align: middle;">No</th>
                <th class="text-center" style="vertical-align: middle;">No. Bukti</th>
                <th class="text-center" style="vertical-align: middle;">Tgl. Bukti</th>
                <th class="text-center" style="vertical-align: middle;">No. Bukti Setor</th>
                <th class="text-center" style="vertical-align: middle;">Tgl. Setor</th>
                <th class="text-center" style="vertical-align: middle;">No. Rincian</th>
                <th class="text-center" style="vertical-align: middle;">Kode Rekening</th>
                <th class="text-center" style="vertical-align: middle;">Uraian Rekening</th>
                <th class="text-center" style="vertical-align: middle;">Jumlah<br>Piutang (Rp)</th>
                <th class="text-center" style="vertical-align: middle;">Jumlah<br>Dibayar (Rp)</th>
                <th class="text-center" style="vertical-align: middle;">Sisa (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $total_piutang = 0;
            $total_setor = 0;
            $total_blm_setor = 0;
            @endphp
            @if (count($data) > 0)
            @foreach ($data as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item->No_Bukti }}</td>
                <td class="text-left">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
                <td class="text-center">{{ $item->No_Setor }}</td>
                <td class="text-left">{{ date('d M Y', strtotime($item->Tgl_Setor)) }}</td>
                <td class="text-left">{{ $item->Ko_bprc }}</td>
                <td class="text-center">{{ $item->Ko_Rkk }}</td>
                <td class="text-left">{{ $item->Ur_Rk6 }}</td>
                <td class="text-right">{{ number_format($item->Piutang, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->Setor, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->Blm_Setor, 2, ',', '.') }}</td>
            </tr>
            @php
            $total_piutang += $item->Piutang;
            $total_setor += $item->Setor;
            $total_blm_setor += $item->Blm_Setor;
            @endphp
            @endforeach
            @else
            <tr>
                <td colspan="11" style="text-align: center">Data tidak ada</td>
            </tr>
            @endif
        </tbody>
        <tfoot style="background-color: #1db790">
            <tr>
                <th class="text-center" colspan=8 style="font-size: 10pt">Total</th>
                <th class="text-right" style="font-size: 9pt">{{number_format($total_piutang, 2, ',', '.')}}</th>
                <th class="text-right" style="font-size: 9pt">{{number_format($total_setor, 2, ',', '.')}}</th>
                <th class="text-right" style="font-size: 9pt">{{number_format($total_blm_setor, 2, ',', '.')}}</th>
            </tr>
        </tfoot>
    </table><br><br>
    <table style="width: 100%">
        <tbody>
            <td colspan="4" style="text-align: center">
                <strong>Disetujui oleh,<br>
                    Pengguna Anggara/Kuasa<br>
                    Pengguna Anggaran
                    <br><br><br>
                    {{-- Nama<br>
                    NIP. ............ --}}
                    {{$pegawai[0]->Nm_Pimp}}<br>
                    NIP. {{$pegawai[0]->NIP_Pimp}}
                    <br><br><br></strong>
            </td>
            <td colspan="4" style="text-align: center">
                <strong>Disiapkan oleh,<br>
                    Bendahara Penerimaan/<br>
                    Bendahara Penerimaan Pembantu
                    <br><br><br>
                    {{-- Nama<br>
                    NIP. ............ --}}
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