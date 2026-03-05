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
          LAPORAN PERUBAHAN EKUITAS<br>
          {{ $judul_periode }}
          {{-- Per 31 Desember {{ Tahun () }} dan {{ Tahun()-1 }} --}}
        </td>
      </tr>
      <tr><td class="text-right">(Dalam Rupiah)</td></tr>
    </thead>

  </table>

  {{-- Isi --}}

  <table class="table table-sm table-bordered " id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold bg-warning">
        <td>No</td>
        <td>Uraian</td>
        <td>{{ Tahun() }}</td>
        <td>{{ Tahun()-1 }}</td>
      </tr>
    </thead>

    <tbody>
      <tr class="text-right">
        <td class="text-center">1</td>
        <td class="text-left">EKUITAS AWAL</td>
        <td>{{ number_format($neraca_pasiva->where('kode','03.99')->sum('soawal'),2,',','.') }}</td>
        <td>{{ $lpe_1 == null ? '0,00' : number_format($lpe_1->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">2</td>
        <td class="text-left">SURPLUS/(DEFISIT) LO</td>
        @if ($surplus_lo_kini < 0)
          <td>({{ number_format($surplus_lo_kini * -1,2,',','.') }})</td>
        @else
          <td>{{ number_format($surplus_lo_kini,2,',','.') }}</td> 
        @endif

        @if ($lpe_2 == null)
        <td>'0.00</td>
        @elseif ($lpe_2->soaw_Rp < 0)
        <td>({{ number_format($lpe_2->soaw_Rp * -1, 2, ',', '.') }})</td>
        @else
        <td>{{ number_format($lpe_2->soaw_Rp, 2, ',', '.') }}</td>
        @endif
      </tr>
      <tr class="text-right">
        <td class="text-center">3</td>
        <td class="text-left">DAMPAK KUMULATIF PERUBAHAN KEBIJAKAN/KESALAHAN MENDASAR :</td>
        <td>{{ $lain[0]->total < 0 ? '('.number_format($lain[0]->total * -1,2,',','.') .')' : number_format($lain[0]->total,2,',',',') }}</td>
        @php
            $lp3 = $lpe_3 == null ? '0.00' : $lpe_3->soaw_Rp;
            $lp4 = $lpe_4 == null ? '0.00' : $lpe_4->soaw_Rp;
            $lp5 = $lpe_5 == null ? '0.00' : $lpe_5->soaw_Rp;
            $sub = $lp3 + $lp4 + $lp5;
        @endphp
        <td>{{ $sub < 0 ? '('.number_format($sub*-1,2,',','.').')' : number_format($sub,2,',','.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">4</td>
        <td class="text-left">KOREKSI NILAI PERSEDIAAN</td>
        <td>0,00</td>
        <td>{{ $lpe_3 == null ? '0,00' : number_format($lpe_3->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">5</td>
        <td class="text-left">SELISIH REVALUASI ASET TETAP</td>
        <td>0,00</td>
        <td>{{ $lpe_4 == null ? '0,00' : number_format($lpe_4->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">6</td>
        <td class="text-left">LAIN-LAIN</td>
        @if ($lain[0]->total < 0)
          <td>({{ number_format($lain[0]->total * -1,2,',','.') }})</td>
        @else
          <td>{{ number_format($lain[0]->total,2,',','.') }}</td> 
        @endif

        @if ($lpe_5 == null)
        <td>'0.00</td>
        @elseif ($lpe_5->soaw_Rp < 0)
        <td>({{ number_format($lpe_5->soaw_Rp * -1, 2, ',', '.') }})</td>
        @else
        <td>{{ number_format($lpe_5->soaw_Rp, 2, ',', '.') }}</td>
        @endif
      </tr>
      <tr class="text-right font-weight-bold bg-warning"> 
        <td class="text-center">7</td>
        <td class="text-left">EKUITAS AKHIR</td>
        <td>{{ number_format($neraca_pasiva->where('kode','03.99')->sum('soawal') + $surplus_lo_kini + $lain[0]->total,2,',','.') }}</td>
        @php
            $lp1 = $lpe_1 == null ? '0.00' : $lpe_1->soaw_Rp;
            $lp2 = $lpe_2 == null ? '0.00' : $lpe_2->soaw_Rp;
            $lp3 = $lpe_3 == null ? '0.00' : $lpe_3->soaw_Rp;
            $lp4 = $lpe_4 == null ? '0.00' : $lpe_4->soaw_Rp;
            $lp5 = $lpe_5 == null ? '0.00' : $lpe_5->soaw_Rp;
            $sub = $lp3 + $lp4 + $lp5;
            $total = $lp1 + $lp2 + $sub;
        @endphp
        <td>{{ $total < 0 ? '('.number_format($total*-1,2,',','.').')' : number_format($total,2,',','.') }}</td>
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