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
          LAPORAN OPERASIONAL <br>
          {{ $judul_periode }}
        </td>
      </tr>
      <tr><td class="text-right">(Dalam Rupiah)</td></tr>
    </thead>

  </table>

  {{-- Isi --}}

  <table class="table table-sm table-bordered " id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold bg-warning">
        <td style="vertical-align: middle;">Uraian</td>
        <td style="vertical-align: middle;">{{ Tahun() }}</td>
        <td style="vertical-align: middle;">{{ Tahun()-1 }}</td>
        <td>Kenaikan/ <br>(Penurunan)</td>
        <td style="vertical-align: middle;">(%)</td>
      </tr>
    </thead>

    {{-- KEGIATAN OPERASIONAL start --}}

    <tbody>
      <tr class="font-weight-bold">
        <td>KEGIATAN OPERASIONAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      {{-- PENDAPATAN OPERASIONAL --}}
      <tr class="font-weight-bold">
        <td>PENDAPATAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lo_th_1) > 0)
      @foreach($lo_th_1 as $number => $lo_th_1)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lo_th_1->ur_kode }}</td>
        <td>{{ number_format($lo_th_1->lo_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lo_th_1->lo_lalu, 2, ',', '.') }}</td>
        @if($lo_th_1->delta > 0)
          <td>{{ number_format($lo_th_1->delta, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($lo_th_1->delta * -1, 2, ',', '.') }})</td>
        @endif
        @if($lo_th_1->delta_persen > 0)
        <td>{{ number_format($lo_th_1->delta_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lo_th_1->delta_persen * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @endforeach
      <tr class="text-right font-weight-bold">
        <td class="text-left">JUMLAH PENDAPATAN</td>
        <td>{{ number_format($jum_pdp_opr_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_pdp_opr_lalu, 2, ',', '.') }}</td>
        @if($delta_pdp_opr > 0)
        <td>{{ number_format($delta_pdp_opr, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_pdp_opr * -1, 2, ',', '.') }})</td>
        @endif
        @if( $jum_pdp_opr_lalu != 0 )
          @if( $delta_pdp_opr/$jum_pdp_opr_lalu*100 > 0)
          <td>{{ number_format($delta_pdp_opr/$jum_pdp_opr_lalu*100, 2, ',', '.') }}</td>
          @else
          <td>({{ number_format($delta_pdp_opr/$jum_pdp_opr_lalu*100 * -1, 2, ',', '.') }})</td>
          @endif
        @else
          <td>{{ number_format(0, 2, ',', '.') }}</td>
        @endif
      </tr>
      @else
      @endif
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      {{-- BEBAN OPERASIONAL --}}
      <tr class="font-weight-bold">
        <td>BEBAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lo_th_2) > 0)
      @foreach($lo_th_2 as $number => $lo_th_2)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lo_th_2->ur_kode }}</td>
        <td>{{ number_format($lo_th_2->lo_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lo_th_2->lo_lalu, 2, ',', '.') }}</td>
        @if($lo_th_2->delta > 0)
          <td>{{ number_format($lo_th_2->delta, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($lo_th_2->delta * -1, 2, ',', '.') }})</td>
        @endif
        @if($lo_th_2->delta_persen > 0)
        <td>{{ number_format($lo_th_2->delta_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lo_th_2->delta_persen * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @endforeach
      <tr class="text-right font-weight-bold">
        <td class="text-left">JUMLAH BEBAN</td>
        <td>{{ number_format($jum_beban_opr_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_beban_opr_lalu, 2, ',', '.') }}</td>
        @if($delta_beban_opr > 0)
        <td>{{ number_format($delta_beban_opr, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_beban_opr * -1, 2, ',', '.') }})</td>
        @endif
        @if( $jum_beban_opr_lalu != 0)
          @if($delta_beban_opr/$jum_beban_opr_lalu*100 > 0)
          <td>{{ number_format($delta_beban_opr/$jum_beban_opr_lalu*100, 2, ',', '.') }}</td>
          @else
          <td>({{ number_format($delta_beban_opr/$jum_beban_opr_lalu*100 * -1, 2, ',', '.') }})</td>
          @endif
        @else
          <td>{{ number_format(0, 2, ',', '.') }}</td>
        @endif
      </tr>
      @else
      @endif
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      {{-- SURPLUS/DEFISIT OPERASIONAL --}}
      <tr class="text-right font-weight-bold">
        <td class="text-left">Surplus/(Defisit) Operasional</td>
        @if($surplus_opr_kini > 0)
        <td>{{ number_format($surplus_opr_kini, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($surplus_opr_kini * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($surplus_opr_lalu, 2, ',', '.') }}</td>
        @if($delta_surplus_opr > 0)
        <td>{{ number_format($delta_surplus_opr, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_surplus_opr * -1, 2, ',', '.') }})</td>
        @endif
        @if( $surplus_opr_lalu*100 != 0)
          @if($delta_surplus_opr/$surplus_opr_lalu*100 > 0)
          <td>{{ number_format($delta_surplus_opr/$surplus_opr_lalu*100, 2, ',', '.') }}</td>
          @else
          <td>({{ number_format($delta_surplus_opr/$surplus_opr_lalu*100 * -1, 2, ',', '.') }})</td>
          @endif
        @else
          <td>{{ number_format(0, 2, ',', '.') }}</td>
        @endif
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      {{-- KEGIATAN NON OPERASIONAL --}}
      <tr class="font-weight-bold">
        <td>KEGIATAN NON OPERASIONAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lo_th_3) > 0)
      @foreach($lo_th_3 as $number => $lo_th_3)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lo_th_3->ur_kode }}</td>
        <td>
          @if($lo_th_3->lo_kini < 0)
            ({{ number_format($lo_th_3->lo_kini *-1, 2, ',', '.') }})
          @else
            {{ number_format($lo_th_3->lo_kini, 2, ',', '.') }}
          @endif
        </td>
        <td>
          @if($lo_th_3->lo_lalu < 0)
            ({{ number_format($lo_th_3->lo_lalu *-1, 2, ',', '.') }})
          @else
            {{ number_format($lo_th_3->lo_lalu, 2, ',', '.') }}
          @endif
        </td>
        @if($lo_th_3->delta > 0)
          <td>{{ number_format($lo_th_3->delta, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($lo_th_3->delta * -1, 2, ',', '.') }})</td>
        @endif
        @if($lo_th_3->delta_persen > 0)
        <td>{{ number_format($lo_th_3->delta_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lo_th_3->delta_persen * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @endforeach
      <tr class="text-right font-weight-bold">
        <td class="text-left">SURPLUS/(DEFISIT) DARI KEGIATAN NON OPERASIONAL</td>
        <td>
          @if($surplus_non_opr_kini < 0)
            ({{ number_format($surplus_non_opr_kini *-1, 2, ',', '.') }})
          @else
            {{ number_format($surplus_non_opr_kini, 2, ',', '.') }}
          @endif
        </td>
        <td>
          @if($surplus_non_opr_lalu < 0)
            ({{ number_format($surplus_non_opr_lalu *-1, 2, ',', '.') }})
          @else
            {{ number_format($surplus_non_opr_lalu, 2, ',', '.') }}
          @endif
        </td>
        @if($delta_surplus_non_opr > 0)
        <td>{{ number_format($delta_surplus_non_opr, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_surplus_non_opr * -1, 2, ',', '.') }})</td>
        @endif
        <td>
          @if($surplus_non_opr_lalu == 0)
            0,00
          @else
            @if($delta_surplus_non_opr/$surplus_non_opr_lalu*100 < 0) 
              ({{ number_format($delta_surplus_non_opr/$surplus_non_opr_lalu*100 * -1, 2, ',', '.') }})
            @else
              {{ number_format($delta_surplus_non_opr/$surplus_non_opr_lalu*100 * -1, 2, ',', '.') }}
            @endif
          @endif
        </td>
      </tr>
      @else
      @endif
      <tr>
        <td style="text-indent: 25px;">Surplus/Defisit Penjualan Aset Non Lancar</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>
      <tr>
        <td style="text-indent: 25px;">(Kerugian)/Penurunan Nilai Aset</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>
      <tr>
        <td style="text-indent: 25px;">Surplus/Defisit Kegiatan Non Operasional Lainnya</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>
      <tr class="text-right font-weight-bold">
        <td class="text-left">SURPLUS/(DEFISIT) DARI KEGIATAN NON OPERASIONAL</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>

      {{-- SURPLUS/(DEFISIT) SEBELUM POS LUAR BIASA --}}

      <tr class="text-right font-weight-bold">
        <td class="text-left">SURPLUS/(DEFISIT) SEBELUM POS LUAR BIASA</td>
        @if($surplus_before_lb_kini > 0)
        <td>{{ number_format($surplus_before_lb_kini, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($surplus_before_lb_kini * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($surplus_before_lb_lalu, 2, ',', '.') }}</td>
        @if($delta_surplus_before_lb > 0)
        <td>{{ number_format($delta_surplus_before_lb, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_surplus_before_lb * -1, 2, ',', '.') }})</td>
        @endif
        @if( $surplus_before_lb_lalu != 0)
          @if($delta_surplus_before_lb/$surplus_before_lb_lalu*100 > 0)
          <td>{{ number_format($delta_surplus_before_lb/$surplus_before_lb_lalu*100, 2, ',', '.') }}</td>
          @else
          <td>({{ number_format($delta_surplus_before_lb/$surplus_before_lb_lalu*100 * -1, 2, ',', '.') }})</td>
          @endif
        @else
          <td>{{ number_format(0, 2, ',', '.') }}</td>
        @endif

      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      {{-- POS LUAR BIASA --}}
      <tr class="font-weight-bold">
        <td>POS LUAR BIASA</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lo_th_4) > 0)
      @foreach($lo_th_4 as $number => $lo_th_4)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lo_th_4->ur_kode }}</td>
        <td>{{ number_format($lo_th_4->lo_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lo_th_4->lo_lalu, 2, ',', '.') }}</td>
        @if($lo_th_4->delta > 0)
          <td>{{ number_format($lo_th_4->delta, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($lo_th_4->delta * -1, 2, ',', '.') }})</td>
        @endif
        @if($lo_th_4->delta_persen > 0)
        <td>{{ number_format($lo_th_4->delta_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lo_th_4->delta_persen * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @endforeach
      <tr class="text-right font-weight-bold">
        <td class="text-left">JUMLAH POS LUAR BIASA</td>
        <td>{{ number_format($jum_pos_lb_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_pos_lb_lalu, 2, ',', '.') }}</td>
        @if($delta_pos_lb > 0)
        <td>{{ number_format($delta_pos_lb, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_pos_lb * -1, 2, ',', '.') }})</td>
        @endif
        @if($delta_pos_lb/$jum_pos_lb_lalu*100 > 0)
        <td>{{ number_format($delta_pos_lb/$jum_pos_lb_lalu*100, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_pos_lb/$jum_pos_lb_lalu*100 * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      @else
      @endif
      <tr>
        <td style="text-indent: 25px;">Pendapatan Luar Biasa</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>
      <tr>
        <td style="text-indent: 25px;">Beban Luar Biasa</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>
      <tr class="text-right font-weight-bold">
        <td class="text-left">JUMLAH POS LUAR BIASA</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
        <td class="text-right">0,00</td>
      </tr>

      {{-- SURPLUS/(DEFISIT) LO --}}

      <tr class="text-right font-weight-bold bg-warning">
        <td class="text-left">SURPLUS/(DEFISIT) LO</td>
        @if($surplus_lo_kini > 0)
        <td>{{ number_format($surplus_lo_kini, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($surplus_lo_kini * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($surplus_lo_lalu, 2, ',', '.') }}</td>
        @if($delta_surplus_lo > 0)
        <td>{{ number_format($delta_surplus_lo, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($delta_surplus_lo * -1, 2, ',', '.') }})</td>
        @endif
        @if( $surplus_lo_lalu != 0)
          @if($delta_surplus_lo/$surplus_lo_lalu*100 > 0)
          <td>{{ number_format($delta_surplus_lo/$surplus_lo_lalu*100, 2, ',', '.') }}</td>
          @else
          <td>({{ number_format($delta_surplus_lo/$surplus_lo_lalu*100 * -1, 2, ',', '.') }})</td>
          @endif
        @else
          <td>{{ number_format(0, 2, ',', '.') }}</td>
        @endif

      </tr>

    </tbody>

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