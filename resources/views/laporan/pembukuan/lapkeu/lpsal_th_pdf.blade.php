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
          LAPORAN PERUBAHAN SALDO ANGGARAN LEBIH <br>
          {{ $judul_periode }}
          {{-- Untuk Tahun yang Berakhir 31 Desember {{ Tahun () }} dan {{ Tahun()-1 }} --}}
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
        <td class="text-left">Saldo Anggaran Lebih Awal</td>
        <td>{{ number_format($silpa_lalu, 2, ',', '.') }}</td>
        <td>{{ $lpsal_1 == null ? '0,00' : number_format($lpsal_1->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">2</td>
        <td class="text-left">Penggunaan SAL</td>
        <td>{{ number_format($lra_kini, 2, ',', '.') }}</td>
        <td>{{ $lpsal_2 == null ? '0,00' : number_format($lpsal_2->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">3</td>
        <td class="text-left">&nbsp;Sub Total (1 - 2)</td>
        <td>{{ number_format($silpa_lalu-$lra_kini, 2, ',', '.') }}</td>
        @php
            $lp1 = $lpsal_1 == null ? '0.00' : $lpsal_1->soaw_Rp;
            $lp2 = $lpsal_2 == null ? '0.00' : $lpsal_2->soaw_Rp;
            $sub1 = $lp1 - $lp2;
        @endphp
        <td>{{ $sub1 < 0 ? '('.number_format($sub1*-1,2,',','.').')' : number_format($sub1,2,',','.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">4</td>
        <td class="text-left">Sisa Lebih/Kurang Pembiayaan Anggaran (SILPA/SIKPA)</td>
        <td>{{ number_format($silpa_kini+$lain_kini, 2, ',', '.') }}</td>
        <td>{{ $lpsal_3 == null ? '0,00' : number_format($lpsal_3->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">5</td>
        <td class="text-left">&nbsp;Sub Total (3 + 4)</td>
        <td>{{ number_format(($silpa_lalu-$lra_kini)+$silpa_kini+$lain_kini, 2, ',', '.') }}</td>
        @php
            $lp1 = $lpsal_1 == null ? '0.00' : $lpsal_1->soaw_Rp;
            $lp2 = $lpsal_2 == null ? '0.00' : $lpsal_2->soaw_Rp;
            $lp3 = $lpsal_3 == null ? '0.00' : $lpsal_3->soaw_Rp;
            $sub1 = $lp1 - $lp2;
            $sub2 = $sub1 + $lp3;
        @endphp
        <td>{{ $sub2 < 0 ? '('.number_format($sub2*-1,2,',','.').')' : number_format($sub2,2,',','.') }}<</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">6</td>
        <td class="text-left">Koreksi Kesalahan Pembukuan Tahun Sebelumnya</td>
        <td>0,00</td>
        <td>{{ $lpsal_4 == null ? '0,00' : number_format($lpsal_4->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-center">7</td>
        <td class="text-left">Lain-lain</td>
        <td>{{ $lain_kini == null ? '0,00' : '('. number_format($lain_kini,2,',','.') .')' }}</td>
        {{-- <td>{{ $lpsal_5 == null ? '0,00' : ( $lpsal_5->soaw_Rp == null ? '0,00' : number_format($lpsal_4->soaw_Rp, 2, ',', '.') ) }}</td> --}}
        <td>{{ $lpsal_5 == null ? '0,00' : number_format($lpsal_5->soaw_Rp, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right bg-warning font-weight-bold">
        <td class="text-center">8</td>
        <td class="text-left">&nbsp;Saldo Anggaran Lebih Akhir (5 + 6 + 7)</td>
        <td>{{ number_format(($silpa_lalu-$lra_kini)+$silpa_kini, 2, ',', '.') }}</td>
        @php
        $lp1 = $lpsal_1 == null ? '0.00' : $lpsal_1->soaw_Rp;
        $lp2 = $lpsal_2 == null ? '0.00' : $lpsal_2->soaw_Rp;
        $lp3 = $lpsal_3 == null ? '0.00' : $lpsal_3->soaw_Rp;
        $lp4 = $lpsal_4 == null ? '0.00' : $lpsal_4->soaw_Rp;
        $lp5 = $lpsal_5 == null ? '0.00' : $lpsal_5->soaw_Rp;
        $sub1 = $lp1 - $lp2;
        $sub2 = $sub1 + $lp3;
        $total = $sub2 + $lp4 + $lp5;
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