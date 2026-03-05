<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK<br>
                    Nomor : 
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-sm table-borderless" style="width: 100%">
        <thead>
            <tr>
                <td style="width: 12%">Nama SKPD</td>
                <td>:</td>
                <td style="width: 90%">{{$unit->Ur_Unit}} {{ nm_unit() }}</td>
            </tr>
            <tr>
                <td style="width: 12%">Jenis Belanja</td>
                <td>:</td>
                <td style="width: 90%">{{$data->Ur_spi}}</td>
            </tr>
        </thead>
    </table>
    <table class="table table-sm table-borderless" style="width: 100%">
        <tr>
            <td>Yang bertanda tangan dibawah ini Pemimpin BLUD {{ nm_unit() }} <br>
                Menyatakan bahwa saya bertanggung jawab mutlak atas segala pengeluaran yang telah dibayar lunas oleh Bendahara
                Pengeluaran BLUD kepada yang berhak menerima dengan perincian sebagaimana terlampir dalam ringkasan sebagai berikut : <br>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="width: 95%">
        <tr>
            <td class="text-center">Nomor</td>
            <td class="text-center">Tanggal</td>
            <td class="text-center">Jumlah</td>
        </tr>
        <tr>
            <td class="text-center">{{$data->No_SPi}}</td>
            <td class="text-center">{{\Carbon\Carbon::parse($data->Dt_SPi)->format('d F Y')}}</td>
            <td class="text-right">Rp. {{number_format($data->t_rp,2,',','.')}}</td>
        </tr>
    </table>
    <table class="table table-sm table-borderless" style="width: 100%">
        <tr>
            <td>Bukti-bukti Belanja yang menjadi lampiran pengesahan SPJ disimpan sesuai ketentuan yang berlaku pada {{ nm_unit() }} untuk kelengkapan administrasi dan keperluan pemeriksaan aparat pengawasan fungsional. 
            </td>
        </tr>
    </table>
    <table class="table table-sm table-borderless" style="width: 100%">
        <tr>
            <td>Demikian surat pernyataan ini dibuat dengan sebenarnya.</td>
        </tr>
    </table>

    <table style="width: 100%">
        <tr>
            <td style="width: 50%"></td>
            <td colspan="4" style="text-align: center">{{nm_ibukota()}}, {{ Carbon\Carbon::parse(today())->isoFormat('D MMMM Y') }}<br></td>
        </tr>
        <tr>
            <td style="width: 60%"></td>
            <td colspan="4" style="text-align: center">
                Pimpinan BLUD<br>
                <br><br><br>
                {{ tb_sub('Nm_Pimp') }}<br>
                NIP {{ tb_sub('NIP_Pimp') }}
                <br><br><br>
            </td>
        </tr>
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