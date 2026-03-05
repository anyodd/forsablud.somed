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
          LAPORAN REALISASI ANGGARAN <br>
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
        <td style="vertical-align: middle;">Anggaran <br>{{ Tahun() }}</td>
        <td style="vertical-align: middle;">Realisasi <br>{{ Tahun() }}</td>
        <td style="vertical-align: middle;">(%)</td>
        <td style="vertical-align: middle;">Realisasi <br>{{ Tahun()-1 }}</td>
      </tr>
    </thead>

    <tbody>
      <tr class="font-weight-bold">
        <td>PENDAPATAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lra_pendapatan) > 0)
      @foreach($lra_pendapatan as $number => $lra_pendapatan)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lra_pendapatan->ur_kode }}</td>
        <td>{{ number_format($lra_pendapatan->ang_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lra_pendapatan->lra_kini, 2, ',', '.') }}</td>
        @if($lra_pendapatan->realisasi_persen >= 0)
        <td>{{ number_format($lra_pendapatan->realisasi_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lra_pendapatan->realisasi_persen * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($lra_pendapatan->lra_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @endif
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Pendapatan</td>
        <td>{{ number_format($jum_lra_pendapatan_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_pendapatan_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_pendapatan, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_pendapatan_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>BELANJA</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>BELANJA OPERASI</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lra_belanja_operasi) > 0)
      @foreach($lra_belanja_operasi as $number => $lra_belanja_operasi)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lra_belanja_operasi->ur_kode }}</td>
        <td>{{ number_format($lra_belanja_operasi->ang_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lra_belanja_operasi->lra_kini, 2, ',', '.') }}</td>
        @if($lra_belanja_operasi->realisasi_persen >= 0)
        <td>{{ number_format($lra_belanja_operasi->realisasi_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lra_belanja_operasi->realisasi_persen * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($lra_belanja_operasi->lra_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @endif
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Belanja Operasi</td>
        <td>{{ number_format($jum_lra_belanja_operasi_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_operasi_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_belanja_operasi, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_operasi_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>BELANJA MODAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lra_belanja_modal) > 0)
      @foreach($lra_belanja_modal as $number => $lra_belanja_modal)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lra_belanja_modal->ur_kode }}</td>
        <td>{{ number_format($lra_belanja_modal->ang_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lra_belanja_modal->lra_kini, 2, ',', '.') }}</td>
        @if($lra_belanja_modal->realisasi_persen >= 0)
        <td>{{ number_format($lra_belanja_modal->realisasi_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lra_belanja_modal->realisasi_persen * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($lra_belanja_modal->lra_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @endif
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Belanja Modal</td>
        <td>{{ number_format($jum_lra_belanja_modal_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_modal_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_belanja_modal, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_modal_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Belanja</td>
        <td>{{ number_format($jum_lra_belanja_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_belanja, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_belanja_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold text-right">
        <td class="text-left">SURPLUS/(DEFISIT)</td>
        @if($surplus_ang >= 0)
          <td>{{ number_format($surplus_ang, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($surplus_ang * -1, 2, ',', '.') }})</td>
        @endif
        @if($surplus_kini >= 0)
          <td>{{ number_format($surplus_kini, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($surplus_kini * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($persen_surplus, 2, ',', '.') }}</td>
        @if($surplus_lalu >= 0)
          <td>{{ number_format($surplus_lalu, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($surplus_lalu * -1, 2, ',', '.') }})</td>
        @endif
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>PEMBIAYAAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>PENERIMAAN PEMBIAYAAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lra_terima_biaya) > 0)
      @foreach($lra_terima_biaya as $number => $lra_terima_biaya)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lra_terima_biaya->ur_kode }}</td>
        <td>{{ number_format($lra_terima_biaya->ang_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lra_terima_biaya->lra_kini, 2, ',', '.') }}</td>
        @if($lra_terima_biaya->realisasi_persen >= 0)
        <td>{{ number_format($lra_terima_biaya->realisasi_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lra_terima_biaya->realisasi_persen * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($lra_terima_biaya->lra_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @endif
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Penerimaan Pembiayaan</td>
        <td>{{ number_format($jum_lra_terima_biaya_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_terima_biaya_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_terima_biaya, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_terima_biaya_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="font-weight-bold">
        <td>PENGELUARAN PEMBIAYAAN</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      @if(count($lra_keluar_biaya) > 0)
      @foreach($lra_keluar_biaya as $number => $lra_keluar_biaya)
      <tr class="text-right">
        <td class="text-left"  style="text-indent: 25px;">{{ $lra_keluar_biaya->ur_kode }}</td>
        <td>{{ number_format($lra_keluar_biaya->ang_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($lra_keluar_biaya->lra_kini, 2, ',', '.') }}</td>
        @if($lra_keluar_biaya->realisasi_persen >= 0)
        <td>{{ number_format($lra_keluar_biaya->realisasi_persen, 2, ',', '.') }}</td>
        @else
        <td>({{ number_format($lra_keluar_biaya->realisasi_persen * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($lra_keluar_biaya->lra_lalu, 2, ',', '.') }}</td>
      </tr>
      @endforeach
      @endif
      <tr class="font-weight-bold text-right">
        <td class="text-left">Jumlah Penerimaan Pembiayaan</td>
        <td>{{ number_format($jum_lra_keluar_biaya_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_keluar_biaya_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_keluar_biaya, 2, ',', '.') }}</td>
        <td>{{ number_format($jum_lra_keluar_biaya_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold text-right">
        <td class="text-left">PEMBIAYAAN NETTO</td>
        <td>{{ number_format($biaya_netto_ang, 2, ',', '.') }}</td>
        <td>{{ number_format($biaya_netto_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_keluar_biaya, 2, ',', '.') }}</td>
        <td>{{ number_format($biaya_netto_lalu, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold text-right bg-warning">
        <td class="text-left">SISA LEBIH PEMBIAYAAN ANGGARAN TAHUN BERKENAAN (SILPA)</td>
        @if($silpa_ang >= 0)
          <td>{{ number_format($silpa_ang, 2, ',', '.') }}</td>
        @else
          <td>({{ number_format($silpa_ang * -1, 2, ',', '.') }})</td>
        @endif
        <td>{{ number_format($silpa_kini, 2, ',', '.') }}</td>
        <td>{{ number_format($persen_silpa, 2, ',', '.') }}</td>
        <td>{{ number_format($silpa_lalu, 2, ',', '.') }}</td>
      </tr>
    </tbody>

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