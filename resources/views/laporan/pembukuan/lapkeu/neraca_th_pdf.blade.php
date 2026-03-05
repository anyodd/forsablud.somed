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
          NERACA <br>
          Per 31 Desember {{ Tahun () }} dan {{ Tahun()-1 }}
        </td>
      </tr>
      <tr><td class="text-right">(Dalam Rupiah)</td></tr>
    </thead>

  </table>

  {{-- Isi --}}

  <table class="table table-sm table-bordered " id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold bg-warning">
        <td>Uraian</td>
        <td>{{ Tahun() }}</td>
        <td>{{ Tahun()-1 }}</td>
      </tr>
    </thead>

    {{-- ASET start --}}

    <tbody>
      @if (count($neraca_aktiva) > 0)
      @foreach($neraca_aktiva as $number => $neraca_aktiva)


      {{-- Judul RK1 --}}
      @if(strlen($neraca_aktiva->kode) == 2) 
      <tr class="font-weight-bold bg-warning">
        <td>{{ $neraca_aktiva->uraian }}</td>
        <td></td>
        <td></td>
      </tr>

      {{-- Judul RK2 --}}
      @elseif(strlen($neraca_aktiva->kode) == 5 && substr($neraca_aktiva->kode, 3, 2) != "99") 
      <tr class="font-weight-bold">
        <td>{{ ucwords(strtolower($neraca_aktiva->uraian)) }}</td>
        <td></td>
        <td></td>
      </tr>

      {{-- RK3 --}}
      @elseif(strlen($neraca_aktiva->kode) == 8 && substr($neraca_aktiva->kode, 6, 2) != "99")
      <tr>
        <td style="text-indent: 25px;">{{ $neraca_aktiva->uraian }}</td>
        @if($neraca_aktiva->soakhir < 0)
          <td class="text-right">({{ number_format($neraca_aktiva->soakhir * -1, 2, ",", ".") }})</td>
        @else
          <td class="text-right">{{ number_format($neraca_aktiva->soakhir, 2, ",", ".") }}</td>
        @endif

        @if($neraca_aktiva->soawal < 0)
          <td class="text-right">({{ number_format($neraca_aktiva->soawal * -1, 2, ",", ".") }})</td>
        @else
          <td class="text-right">{{ number_format($neraca_aktiva->soawal, 2, ",", ".") }}</td>
        @endif
      </tr>

      {{-- Jumlah RK1 --}}
      @elseif(substr($neraca_aktiva->kode, 3, 2) == "99")
      <tr class="font-weight-bold">
        <td>{{ $neraca_aktiva->uraian }}</td>
        @if($neraca_aktiva->soakhir < 0)
        <td class="text-right">({{ number_format($neraca_aktiva->soakhir * -1, 2, ",", ".") }})</td>
        @else
        <td class="text-right">{{ number_format($neraca_aktiva->soakhir, 2, ",", ".") }}</td>
        @endif
        <td class="text-right">{{ number_format($neraca_aktiva->soawal, 2, ",", ".") }}</td>
      </tr>

      {{-- Jumlah RK2 --}}
      @elseif(substr($neraca_aktiva->kode, 6, 2) == "99")
      <tr class="font-weight-bold">
        <td>{{ ucwords(strtolower($neraca_aktiva->uraian)) }}</td>
        <td class="text-right">{{ number_format($neraca_aktiva->soakhir, 2, ",", ".") }}</td>
        <td class="text-right">{{ number_format($neraca_aktiva->soawal, 2, ",", ".") }}</td>
      </tr>

      @else
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @endif

      @endforeach
      @endif
    </tbody>

    {{-- ASET end --}}

    {{-- KEWAJIBAN DAN EKUITAS start --}}

   <tbody>
      @if (count($neraca_pasiva) > 0)
      @foreach($neraca_pasiva as $number => $neraca_pasiva)


      {{-- Judul RK1 --}}
      @if(strlen($neraca_pasiva->kode) == 2) 
      <tr class="font-weight-bold bg-warning">
        <td>{{ $neraca_pasiva->uraian }}</td>
        <td></td>
        <td></td>
      </tr>

      {{-- Judul RK2 --}}
      @elseif(strlen($neraca_pasiva->kode) == 5 && substr($neraca_pasiva->kode, 3, 2) != "99") 
      <tr class="font-weight-bold">
        <td>{{ ucwords(strtolower($neraca_pasiva->uraian)) }}</td>
        <td></td>
        <td></td>
      </tr>

      {{-- RK3 --}}
      @elseif(strlen($neraca_pasiva->kode) == 8 && substr($neraca_pasiva->kode, 6, 2) != "99")
      <tr>
        <td style="text-indent: 25px;">{{ $neraca_pasiva->uraian }}</td>
        @if($neraca_pasiva->soakhir < 0)
          <td class="text-right">({{ number_format($neraca_pasiva->soakhir * -1, 2, ",", ".") }})</td>
        @else
          <td class="text-right">{{ number_format($neraca_pasiva->soakhir, 2, ",", ".") }}</td>
        @endif

        @if($neraca_pasiva->soawal < 0)
          <td class="text-right">({{ number_format($neraca_pasiva->soawal * -1, 2, ",", ".") }})</td>
        @else
          <td class="text-right">{{ number_format($neraca_pasiva->soawal, 2, ",", ".") }}</td>
        @endif
      </tr>

      {{-- Jumlah RK1 --}}
      @elseif(substr($neraca_pasiva->kode, 3, 2) == "99")
      <tr class="font-weight-bold">
        <td>{{ $neraca_pasiva->uraian }}</td>
        @if($neraca_pasiva->soakhir < 0)
        <td class="text-right">({{ number_format($neraca_pasiva->soakhir * -1, 2, ",", ".") }})</td>
        @else
        <td class="text-right">{{ number_format($neraca_pasiva->soakhir, 2, ",", ".") }}</td>
        @endif
        <td class="text-right">{{ number_format($neraca_pasiva->soawal, 2, ",", ".") }}</td>
      </tr>

      {{-- Jumlah RK2 --}}
      @elseif(substr($neraca_pasiva->kode, 6, 2) == "99")
      <tr class="font-weight-bold">
        <td>{{ ucwords(strtolower($neraca_pasiva->uraian)) }}</td>
        <td class="text-right">{{ number_format($neraca_pasiva->soakhir, 2, ",", ".") }}</td>
        <td class="text-right">{{ number_format($neraca_pasiva->soawal, 2, ",", ".") }}</td>
      </tr>

      @else
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @endif

      @endforeach
      @endif

      {{-- JUMLAH KEWAJIBAN DAN EKUITAS --}}
      <tr class="font-weight-bold">
        <td>Jumlah KEWAJIBAN DAN EKUITAS</td>
        @if($jum_kewajiban_ekuitas_kini < 0)
          <td class="text-right">({{ number_format($jum_kewajiban_ekuitas_kini * -1, 2, ",", ".") }})</td>
        @else
          <td class="text-right">{{ number_format($jum_kewajiban_ekuitas_kini, 2, ",", ".") }}</td>
        @endif
        <td class="text-right">{{ number_format($jum_kewajiban_ekuitas_lalu, 2, ",", ".") }}</td>
      </tr>
    </tbody>

    {{-- KEWAJIBAN DAN EKUITAS END --}}

  </table>
  
  <!-- TTD -->
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td style="width:50%"></td>
        <td class="text-center">
          {{nm_ibukota()}}, {{ Carbon\Carbon::parse($tgl_lap)->isoFormat('D MMMM Y') }}<br>
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