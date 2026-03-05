<!DOCTYPE html>
<html>
@include('laporan.perencanaan.anggaran_kas.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr class="text-center">
        <td class="text-center" style="border-right-style: hidden;">
          @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
        <td>
          PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
          ANGGARAN KAS PENDAPATAN<br>
          TAHUN ANGGARAN {{Tahun()}}
        </td>
        <td class="text-center" style="border-left-style: hidden;">
          @if (!empty(logo_blud()))
            <img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
      </tr>
      <tr>
        <td colspan="2">Urusan Pemerintah :  ............ (3)<br>
            Organisasi        :  ............ (4)
        </td>
      </tr>
    </tbody> 
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr class="text-center">
        <td>Kode Rekening</td>
        <td>Uraian</td>
        <td>Anggaran</td>
        <td>Januari</td>
        <td>Februari</td>
        <td>Maret</td>
        <td>April</td>
        <td>Mei</td>
        <td>Juni</td>
        <td>Juli</td>
        <td>Agustus</td>
        <td>September</td>
        <td>Oktober</td>
        <td>November</td>
        <td>Desember</td>
      </tr>
      <tr>
        <td class="text-center">1</td>
        <td class="text-center">2</td>
        <td class="text-center">3</td>
        <td class="text-center" colspan="3">4</td>
        <td class="text-center" colspan="3">5</td>
        <td class="text-center" colspan="3">6</td>
        <td class="text-center" colspan="3">7</td>
      </tr>
      <tr>
        <td>xx.xx.xx.xx</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="3">Jumlah Penerimaan Kas dari Pendapatan BLUD per Bulan</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
        <td>xx</td>
      </tr>
      <tr>
        <td colspan="3">Jumlah Penerimaan Kas dari Pendapatan BLUD per Triwulan</td>
        <td colspan="3">xx</td>
        <td colspan="3">xx</td>
        <td colspan="3">xx</td>
        <td colspan="3">xx</td>
      </tr>

      <tr class="text-center" style="border-right-style: hidden;border-left-style: hidden; border-bottom-style: hidden;">
        <td colspan="6" style="border-right-style: hidden;"></td>
        <td colspan=9>
          {{nm_ibukota()}}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }} <br>
          Mengesahkan, <br>
          Direktur <br><br><br>
          Nama Direktur <br>
          NIP Direktur
        </td>
      </tr>
    </tbody> 
  </table>


  <!-- menampilan halaman x dari total halaman, config/dompdf -> line 201: "enable_php" => true,  -->
  <script type="text/php">
    if (isset($pdf)) {
      $x = 772;
      $y = 570; // posisi bawah 815
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