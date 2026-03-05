<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.pengajuan.sppd.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="text-center font-weight-bold" colspan="3">
          PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
          SURAT PERMINTAAN PENCAIRAN DANA UANG PERSEDIAAN <br>
          (SURAT-PPD UP)<br>
          NOMOR {{ $spi->No_SPi }}
        </td>
      </tr>
      <tr><td></td></tr>
      <tr class="text-justify">
        <td colspan="3">Berdasarkan Keputusan Pemimpin BLUD  {{ nm_unit() }} Nomor ... Tanggal ... (3) tentang Penetapan Jumlah Uang Persediaan untuk BLUD {{nm_unit()}}, bersama ini kami mengajukan Surat Permintaan Pencairan Dana Uang Persediaan sejumlah Rp {{ number_format(collect($qr_spp)->sum('Jumlah'), 2, ",", ".") }}
        </td>
      </tr> 
      <tr>
        <td style="width: 20%">Terbilang</td>
        <td colspan="2">: {{ ucwords(terbilang(collect($qr_spp)->sum('Jumlah'))) }} Rupiah</td>
      </tr>
      <tr>
        <td>Nama Bendahara</td>
        <td colspan="2">: {{ $qr_spp[0]->Nm_Ben }}</td>
      </tr>
      <tr>
        <td>Nomor Rekening Bank</td>
        <td colspan="2">: {{ $bank->Ur_Bank ?? '?' }} - {{ $bank->No_Rek ?? '??' }}</td>
      </tr>
      <tr><td></td></tr>
      <tr>
        <td colspan="2"></td>
        <td class="text-center">
          {{nm_ibukota()}}, {{ Carbon\Carbon::parse($spi->Dt_SPi)->isoFormat('D MMMM Y') }} <br>
          Bendahara Pengeluaran BLUD <br><br><br>
          {{ $qr_spp[0]->Nm_Ben }} <br> NIP. {{ $qr_spp[0]->NIP_Ben}}
        </td>
      </tr>




      

    </tbody>
  </table>




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