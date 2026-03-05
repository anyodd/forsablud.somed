<!DOCTYPE html>
<html>
@include('laporan.pembukuan.lapkeu.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  

  {{-- Header --}}

  <table class="table table-sm table-borderless " id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center">
        <td>Pemerintah {{ nm_pemda() }} <br>
          {{ nm_unit() }} <br>
          NERACA SALDO <br>
          Untuk Tahun yang Berakhir 31 Desember {{ Tahun () }} dan {{ Tahun()-1 }}
        </td>
      </tr>
      <tr><td class="text-right">(Dalam Rupiah)</td></tr>
    </thead>

  </table>

  {{-- Isi --}}

  <table class="table table-sm table-bordered " id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold bg-warning">
        <td>Kode Rekening</td>
        <td style="vertical-align: middle;">Uraian</td>
        <td style="vertical-align: middle;">Saldo Awal</td>
        <td style="vertical-align: middle;">Debet</td>
        <td style="vertical-align: middle;">Kredit</td>
        <td style="vertical-align: middle;">Saldo Akhir</td>
      </tr>
    </thead>

    <tbody> 
      @if (count($nrcsaldo_rek3) > 0)
      @foreach($nrcsaldo_rek3 as $number => $nrcsaldo_rek3)
      <tr>
        <td class="text-center">{{ $nrcsaldo_rek3->kode }}</td>
        <td>{{ $nrcsaldo_rek3->uraian }}</td>
        @if($nrcsaldo_rek3->soawal > 0)
          <td class="text-right">{{ number_format($nrcsaldo_rek3->soawal, 2, ',', '.') }}</td>
        @else
          <td class="text-right">({{ number_format($nrcsaldo_rek3->soawal * -1, 2, ',', '.') }})</td>
        @endif

        <td class="text-right">{{ number_format($nrcsaldo_rek3->mutasi_d, 2, ',', '.') }}</td>
        <td class="text-right">{{ number_format($nrcsaldo_rek3->mutasi_k, 2, ',', '.') }}</td>

        @if($nrcsaldo_rek3->soakhir > 0)
          <td class="text-right">{{ number_format($nrcsaldo_rek3->soakhir, 2, ',', '.') }}</td>
        @else
          <td class="text-right">({{ number_format($nrcsaldo_rek3->soakhir * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="6">Tidak ada data</td>
      </tr>
      @endif
    </tbody>

    <tfoot>
      <tr class="font-weight-bold bg-warning">
        <td colspan="2" class="text-center">Jumlah</td>
        <td></td>
        <td class="text-right">{{ number_format($jum_debet, 2, ',', '.') }}</td>
        <td class="text-right">{{ number_format($jum_kredit, 2, ',', '.') }}</td>
        <td></td>
      </tr>
    </tfoot>

  </table>
  
  <!-- TTD -->
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="text-center">
          <br>
          Dibuat/Verifikasi Oleh, <br>
          Kasubag Keuangan <br><br><br><br>
          {{ tb_sub('Nm_Keu') }}<br>
          NIP {{ tb_sub('NIP_Keu') }}
        </td>
        <td class="text-center">
          {{nm_ibukota()}}, {{ Carbon\Carbon::parse($tgl_lap)->isoFormat('D MMMM Y') }}<br>
          Menyetujui, <br>
          Direktur {{ nm_unit() }} <br><br><br><br>
          {{ tb_sub('Nm_Pimp') }}<br>
          NIP {{ tb_sub('NIP_Pimp') }}
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