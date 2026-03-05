<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.belanja.pdf_head')

<body>
    <table class="table table-borderless" style="width: 100%">
        <thead>
            @include('laporan.penatausahaan.header_laporan')
            <tr>
                <td class="text-center text-bold" colspan="12">
                    PENELITIAN KELENGKAPAN DOKUMEN S-PPD GU<br>
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-sm table-bordered" style="width: 95%">
        <tr>
            <td style="width: 4%"></td>
            <td style="border-bottom-style: hidden;border-top-style: hidden;border-right-style: hidden">Salinan Anggaran Kas BLUD</td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="width: 95%">
        <tr>
            <td style="width: 4%"></td>
            <td style="border-bottom-style: hidden;border-top-style: hidden;border-right-style: hidden">Surat - PPD GU</td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="width: 95%">
        <tr>
            <td style="width: 4%;font-size: 8pt"></td>
            <td style="border-bottom-style: hidden;border-top-style: hidden;border-right-style: hidden;">Draft surat pernyataan untuk ditandatangani oleh Pemimpin BLUD yang  menyatakan bahwa uang yang diminta tidak dipergunakan untuk keperluan selain ganti uang persediaan saat pengajuan S-PD</td>
        </tr>
    </table>
    <table class="table table-sm table-bordered" style="width: 95%">
        <tr>
            <td style="width: 4%"></td>
            <td style="border-bottom-style: hidden;border-top-style: hidden;border-right-style: hidden">Lampiran lain yang diperlukan</td>
        </tr>
    </table>
    <table class="table-borderless">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{\Carbon\Carbon::parse($pegawai->Dt_SPi)->format('d F Y')}}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{$pegawai->Nm_Keu}}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{$pegawai->NIP_Keu}}</td>
            </tr>
            <tr>
                <td>Tanda Tangan</td>
                <td>:</td>
                <td></td>
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