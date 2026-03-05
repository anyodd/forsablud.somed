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
          LAPORAN ARUS KAS<br>
          {{ $judul_periode }}<br>
          Metode Langsung
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

    {{--  --}}
    <tbody>
      <tr>
        <td><b>Arus Kas dari Aktivitas Operasi</b></td>
        <td></td>
        <td></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>Arus Masuk Kas:</b></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lak_masuk_operasi) > 0)
      @foreach($lak_masuk_operasi as $number => $lak_masuk_operasi)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_masuk_operasi->ur_rk5 }}</td>
        <td>{{ number_format($lak_masuk_operasi->lak_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lak_masuk_operasi->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Masuk Kas</b></td>
        <td><b>{{ number_format($jum_lak_masuk_operasi_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($jum_lak_masuk_operasi_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>Arus Keluar Kas:</b></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lak_keluar_operasi) > 0)
      @foreach($lak_keluar_operasi as $number => $lak_keluar_operasi)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_keluar_operasi->ur_rk4 }}</td>
        <td>{{ number_format($lak_keluar_operasi->lak_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lak_keluar_operasi->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Keluar Kas</b></td>
        <td><b>{{ number_format($jum_lak_keluar_operasi_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($jum_lak_keluar_operasi_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 75px;"><b>Arus Kas Bersih dari Aktivitas Operasi</b></td>
        @if($jum_lak_bersih_operasi_kini < 0)
        <td><b>({{ number_format($jum_lak_bersih_operasi_kini *-1, 2, ',', '.') }})</b></td>
        @else
        <td><b>{{ number_format($jum_lak_bersih_operasi_kini, 2, ',', '.') }}</b></td>
        @endif
        @if($jum_lak_bersih_operasi_lalu < 0)
        <td><b>({{ number_format($jum_lak_bersih_operasi_lalu *-1, 2, ',', '.') }})</b></td>
        @else
        <td><b>{{ number_format($jum_lak_bersih_operasi_lalu, 2, ',', '.') }}</b></td>
        @endif
      </tr>

      {{--  --}}
      <tr>
        <td><b>Arus Kas dari Aktivitas Investasi</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td><b>Arus Masuk Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      @if(count($lak_masuk_investasi) > 0)
      @foreach($lak_masuk_investasi as $number => $lak_masuk_investasi)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_masuk_investasi->ur_rk5 }}</td>
        <td>{{ number_format($lak_masuk_investasi->lak_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lak_masuk_investasi->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-right">  
        <td class="text-left"  style="text-indent: 25px;">-</td>
        <td>0,00</td>
        <td>0,00</td>
      </tr>
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Masuk Kas</b></td>
        <td><b>{{ number_format($jum_lak_masuk_investasi_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($jum_lak_masuk_investasi_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>Arus Keluar Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      @if(count($lak_keluar_investasi) > 0)
      @foreach($lak_keluar_investasi as $number => $lak_keluar_investasi)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_keluar_investasi->ur_rk3 }}</td>
        <td>{{ number_format($lak_keluar_investasi->lak_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lak_keluar_investasi->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-right">  
        <td class="text-left"  style="text-indent: 25px;">-</td>
        <td>0,00</td>
        <td>0,00</td>
      </tr>
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Keluar Kas</b></td>
        <td><b>{{ number_format($jum_lak_keluar_investasi_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($jum_lak_keluar_investasi_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 75px;"><b>Arus Kas Bersih dari Aktivitas Investasi</b></td>
        @if($jum_lak_bersih_investasi_kini < 0)
          <td><b>({{ number_format($jum_lak_bersih_investasi_kini *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($jum_lak_bersih_investasi_kini, 2, ',', '.') }}</b></td>
        @endif
        @if($jum_lak_bersih_investasi_lalu < 0)
          <td><b>({{ number_format($jum_lak_bersih_investasi_lalu *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($jum_lak_bersih_investasi_lalu, 2, ',', '.') }}</b></td>
        @endif
      </tr>

      {{--  --}}
      <tr>
        <td><b>Arus Kas dari Aktivitas Pendanaan</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td><b>Arus Masuk Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      @if(count($lak_masuk_pendanaan) > 0)
      @foreach($lak_masuk_pendanaan as $number => $lak_masuk_pendanaan)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_masuk_pendanaan->ur_rk3 }}</td>
        <td>
          @if($lak_masuk_pendanaan->lak_kini < 0)
            ({{ number_format($lak_masuk_pendanaan->lak_kini *-1, 2, ',', '.') }})
          @else
            {{ number_format($lak_masuk_pendanaan->lak_kini, 2, ',', '.') }}
          @endif
        </td>
        <td>{{ number_format($lak_masuk_pendanaan->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-right">  
        <td class="text-left"  style="text-indent: 25px;">-</td>
        <td>0,00</td>
        <td>0,00</td>
      </tr>
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Masuk Kas</b></td>
        <td>
          <b>
          @if($jum_lak_masuk_pendanaan_kini < 0)
            ({{ number_format($jum_lak_masuk_pendanaan_kini *-1, 2, ',', '.') }})
          @else
            {{ number_format($jum_lak_masuk_pendanaan_kini, 2, ',', '.') }}
          @endif
          </b>
        </td>
        <td><b>{{ number_format($jum_lak_masuk_pendanaan_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>Arus Keluar Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      @if(count($lak_keluar_pendanaan) > 0)
      @foreach($lak_keluar_pendanaan as $number => $lak_keluar_pendanaan)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lak_keluar_pendanaan->ur_rk3 }}</td>
        <td>{{ number_format($lak_keluar_pendanaan->lak_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lak_keluar_pendanaan->lak_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-right">  
        <td class="text-left"  style="text-indent: 25px;">-</td>
        <td>0,00</td>
        <td>0,00</td>
      </tr>
      @endif
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Masuk Kas</b></td>
        <td><b>{{ number_format($jum_lak_keluar_pendanaan_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($jum_lak_keluar_pendanaan_lalu, 2, ',', '.') }}</b></td>
      </tr>
      {{--  --}}
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 75px;"><b>Arus Kas Bersih dari Aktivitas Pendanaan</b></td>
        @if($jum_lak_bersih_pendanaan_kini < 0)
          <td><b>({{ number_format($jum_lak_bersih_pendanaan_kini *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($jum_lak_bersih_pendanaan_kini, 2, ',', '.') }}</b></td>
        @endif
        @if($jum_lak_bersih_pendanaan_lalu < 0)
          <td><b>({{ number_format($jum_lak_bersih_pendanaan_lalu *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($jum_lak_bersih_pendanaan_lalu, 2, ',', '.') }}</b></td>
        @endif
      </tr>

      {{--  --}}
      <tr>
        <td><b>Arus Kas dari Aktivitas Transitoris</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td><b>Arus Masuk Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">Penerimaan Perhitungan Fihak Ketiga (PFK)</td>
        <td>{{ number_format($masuk_pfk_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($masuk_pfk_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Masuk Kas</b></td>
        <td><b>{{ number_format($masuk_pfk_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($masuk_pfk_lalu, 2, ',', '.') }}</b></td>
      </tr>
      <tr>
        <td><b>Arus Keluar Kas:</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">Pengeluaran Perhitungan Fihak Ketiga (PFK)</td>
        <td>{{ number_format($keluar_pfk_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($keluar_pfk_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 50px;"><b>Jumlah Arus Keluar Kas</b></td>
        <td><b>{{ number_format($keluar_pfk_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($keluar_pfk_lalu, 2, ',', '.') }}</b></td>
      </tr>
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 75px;"><b>Arus Kas Bersih dari Aktivitas Transitoris</b></td>
        @if($jum_lak_bersih_trans_kini < 0)
          <td><b>({{ number_format($jum_lak_bersih_trans_kini *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($jum_lak_bersih_trans_kini, 2, ',', '.') }}</b></td>
        @endif
        <td><b>{{ number_format($jum_lak_bersih_trans_lalu, 2, ',', '.') }}</b></td>
      </tr>

      {{-- --}}
      <tr class="text-right">
        <td class="text-left"><b>Kenaikan/Penurunan Kas BLU</b></td>
        @if($delta_kas_kini < 0)
          <td><b>({{ number_format($delta_kas_kini *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($delta_kas_kini, 2, ',', '.') }}</b></td>
        @endif
        @if($delta_kas_lalu < 0)
          <td><b>({{ number_format($delta_kas_lalu *-1, 2, ',', '.') }})</b></td>
        @else
          <td><b>{{ number_format($delta_kas_lalu, 2, ',', '.') }}</b></td>
        @endif
      </tr>
      <tr class="text-right">
        <td class="text-left"><b>Saldo Awal Kas Setara Kas BLU</b></td>
        <td><b>{{ number_format($awal_kas_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($awal_kas_lalu, 2, ',', '.') }}</b></td>
      </tr>
      <tr class="text-right">
        <td class="text-left"><b>Saldo Akhir Kas Setara Kas BLU</b></td>
        <td><b>{{ number_format($akhir_kas_kini, 2, ',', '.') }}</b></td>
        <td><b>{{ number_format($awal_kas_kini, 2, ',', '.') }}</b></td>
      </tr>
    </tbody>

  </table>
  
  <!-- TTD -->
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        {{--
        <td class="text-center">
          <br>
          Dibuat/Verifikasi Oleh, <br>
          Kasubag Keuangan <br><br><br><br>
          {{ tb_sub('Nm_Keu') }}<br>
          NIP {{ tb_sub('NIP_Keu') }}
        </td>
        --}}
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