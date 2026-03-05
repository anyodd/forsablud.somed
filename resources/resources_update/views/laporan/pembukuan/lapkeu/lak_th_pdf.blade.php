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

    <tbody>
      <tr>
        <td><b>Arus Kas dari Aktivitas Operasi</b></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Masuk Kas :</b></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan APBN</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan jasa layanan dari masyarakat</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan jasa layanan dari entitas akuntansi / entitas pelaporan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan hasil kerja sama</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan hibah</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pendapatan usaha lainnya</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Masuk Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>&nbsp;Arus Kas Keluar :</b></td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran pegawai</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran pemeliharaan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran langganan daya dan jasa</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran perjalanan dinas</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran bunga</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Keluar Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Arus Kas Bersih dari Aktivitas Operasi</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>Arus Kas dari Aktivitas Investasi</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Masuk Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penjualan atas tanah</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penjualan atas Peralatan dan Mesin</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penjualan atas Gedung dan Bangunan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penjualan atas Jalan, Irigasi, dan Jaringan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penjualan Aset Lainnya</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penerimaan dari Divestasi</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penerimaan Penjualan Investasi dalam Bentuk Sekuritas</td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Masuk Kas</b></td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      {{--  --}}
      <tr>
        <td><b>&nbsp;Arus Keluar Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Tanah</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Peralatan dan Mesin</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Gedung dan Bangunan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Jalan, Irigasi, dan Jaringan</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Aset Tetap Lainnya</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perolehan Aset Lainnya</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pengeluaran Penyertaan Modal-BLU</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pengeluaran Pembelian Investasi dalam Bentuk Sekuritas</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;<b>Jumlah Arus Keluar Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td>&nbsp;<b>Arus Kas Bersih dari Aktivitas Investasi</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Arus Kas dari Aktivitas Pendanaan</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;<b>Arus Masuk Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penerimaan Pinjaman</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penerimaan Kembali Pinjaman kepada Pihak Lain</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Masuk Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Keluar Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pembayaran Pokok Pinjaman</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pemberiaan Pinjaman kepada pihak lain</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Keluar Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Kas Bersih dari Aktivitas Pendanaan</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Arus Kas dari Aktivitas Transitoris</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Masuk Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Penerimaan Perhitungan Fihak Ketiga (PFK)</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Masuk Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>&nbsp;Arus Keluar Kas :</b></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pengeluaran Perhitungan Fihak Ketiga (PFK)</td>
        <td class="text-center">xxx</td>
        <td class="text-center">xxx</td>
      </tr>
      <tr>
        <td><b>&nbsp;Jumlah Arus Keluar Kas</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Arus Kas Bersih dari Aktivitas Transitoris</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Kenaikan/Penurunan Kas BLU</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Saldo Awal Kas Setara Kas BLU</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
      </tr>
      <tr>
        <td><b>Saldo Akhir Kas Setara Kas BLU</b></td>
        <td class="text-center"><b>xxx</b></td>
        <td class="text-center"><b>xxx</b></td>
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