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
          {{ $judul }} <br>
          @if($judul != "JURNAL SALDO AWAL")
          Periode {{ Carbon\Carbon::parse($tgl_awal)->isoFormat('D MMMM Y') }} sampai dengan {{ Carbon\Carbon::parse($tgl_akhir)->isoFormat('D MMMM Y') }}
          @else
          Tahun {{ Tahun() }}
          @endif
        </td>
      </tr>
      <tr><td class="text-right">(Dalam Rupiah)</td></tr>
    </thead>

  </table>

  {{-- Isi --}}

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold bg-warning">
        <td>#</td>
        <td>Tanggal</td>
        <td>No Jurnal</td>
        <td>Kode Rekening</td>
        <td>Debet</td>
        <td>Kredit</td>
      </tr>
    </thead>

    <tbody>

      @if (count($jurnal) > 0)
      @foreach($jurnal as $number => $data)
      <tr style="font-size: 0.6rem">
        <td class="text-center">{{ $loop->iteration }}</td>
        <td class="text-center">{{ $data->dt_bukti }}</td>
        <td>{{ $data->no_jurnal }}</td>
        <td>{{ $data->kode }} <br> {{ $data->ur_kode }}</td>
        <td class="text-right">{{ number_format($data->debet, 2, ',', '.') }}</td>
        <td class="text-right">{{ number_format($data->kredit, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="6">Tidak ada data</td>
      </tr>
      @endif

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