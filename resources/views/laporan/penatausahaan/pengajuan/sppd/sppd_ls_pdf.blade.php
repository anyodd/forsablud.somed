<!DOCTYPE html>
<html>
@include('laporan.penatausahaan.pengajuan.sppd.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="font-weight-bold text-center">
          PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
          SURAT PERMINTAAN PENCAIRAN DANA LANGSUNG <br>
          (SURAT-PPD LS)<br>
          NOMOR {{ $spi->No_SPi }}
        </td>
      </tr>
    </tbody> 
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="font-weight-bold text-center" colspan="6" style="border-bottom-style: hidden;">RINGKASAN KEGIATAN</td>
      </tr>
      <tr>
        <td class="text-center" style="border-right-style: hidden;">
          1. <br>
          2. <br>
          3. <br>
          4. <br>
          5. <br>
          6. <br>
          7. <br>
          8. <br>
          9. <br>
          10.<br>
          11.<br>
          12.<br>
          13.
        </td>
        <td style="border-right-style: hidden;">
          Program <br>
          Kegiatan <br>
          Sub Kegiatan <br>
          Nomor dan Tanggal DBA/DBAP <br>
          Nama Perusahaan <br>
          Bentuk Perusahaan <br>
          Alamat Perusahaan <br>
          Nama Pimpinan Perusahaan <br>
          Nama dan Nomor Rekening Bank <br>
          Nomor Kontrak <br>
          Kegiatan Lanjutan <br>
          Waktu Pelaksanaan Kegiatan <br>
          Deskripsi Pekerjaan
        </td>
        <td colspan="4">
          : Pelayanan dan Penunjang Pelayanan BLUD <br>
          : Pelayanan dan Penunjang Pelayanan BLUD <br>
          : Pelayanan dan Penunjang Pelayanan BLUD <br>
          : ............................................ (6) <br>
          : {{ $qr_spp[0]->rekan_nm ?? "--" }} <br>
          : {{ $qr_spp[0]->ur_usaha ?? "--" }} <br>
          : {{ $qr_spp[0]->rekan_adr ?? "--" }}<br>
          : ............................................ (10) <br>
          : {{ $qr_spp[0]->rekan_nmbank ?? "--" }} / {{ $qr_spp[0]->rekan_rekbank ?? "--" }}<br>
          : {{ $qr_spp[0]->No_contr ?? "--" }}<br>
          : Ya / Bukan (13) <br>
          : ............................................ (14) <br>
          : ............................................ (15) <br>
        </td>
      </tr>

      <tr class="text-center">
        <td class="font-weight-bold" colspan="6">Ringkasan DBA/DBAP</td>
      </tr>
      <tr class="text-center">
        <td colspan="4">Jumlah Dana DBA/DBAP (i)</td>
        <td style="border-right-style: hidden;">Rp.</td>
        <td class="text-right">{{number_format($qr_spp1[0]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-center">
        <td class="font-weight-bold" colspan="6">Ringkasan Anggaran Kas</td>
      </tr>
      <tr class="text-center font-weight-bold">
        <td>No.</td>
        <td colspan="3">Anggaran Kas</td>
        <td colspan="2">Jumlah</td>
      </tr>
      <tr>
        <td class="text-center" style="width: 3%">1</td>
        <td class="text-center" colspan="3">Triwulan 1</td>
        <td class="text-center" style="width: 5%;border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 25%">
          @if ($qr_spp1[1]->Total == 0)
            {{ number_format($qr_spp1[0]->Total, 2, ',', '.') }}
          @else
            {{ number_format($qr_spp1[1]->Total, 2, ',', '.') }}
          @endif
        </td>
      </tr>
      <tr>
        <td class="text-center">2</td>
        <td class="text-center" colspan="3">Triwulan 2</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="text-center">3</td>
        <td class="text-center" colspan="3">Triwulan 3</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="text-center">4</td>
        <td class="text-center" colspan="3">Triwulan 4</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="4">Jumlah (ii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
          @if ($qr_spp1[1]->Total == 0)
            {{ number_format($qr_spp1[0]->Total, 2, ',', '.') }}
          @else
            {{number_format($qr_spp1[1]->Total*4, 2, ',', '.') }}
          @endif
        </td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="4">Sisa dana di luar anggaran kas berkenaan dan triwulan sebelumnya (i-ii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
		  @if ($qr_spp1[1]->Total == 0)
            {{number_format($qr_spp1[0]->Total-($qr_spp1[0]->Total), 2, ',', '.') }}
          @else
            {{number_format($qr_spp1[0]->Total-($qr_spp1[1]->Total*4), 2, ',', '.') }}
          @endif
		</td>
      </tr>
      <tr>
        <td colspan="4"></td>
        <td colspan="2"></td>
      </tr>
      <tr class="text-center">
        <td class="font-weight-bold" colspan="6">Ringkasan Belanja</td>
      </tr>
      <tr>
        <td colspan="4">Belanja UP/GU</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
          @if (empty($qr_spp2[0]->Kode == 3))
            0,00
          @else
			{{ number_format($qr_spp2[0]->Kode == 3 ? $qr_spp2[0]->Total : 0, 2, ',', '.') }}
          @endif
        </td>
      </tr>
      <tr>
        <td colspan="4">Belanja LS</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
          @if (empty($qr_spp2[1]->Kode == 4))
            0,00
          @else
			{{ number_format($qr_spp2[1]->Kode == 4 ? $qr_spp2[1]->Total : 0,2,',', '.') }}
          @endif
        </td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="4">Jumlah (iii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
          @if (empty($qr_spp2[0]) || empty($qr_spp2[1]))
              0,00
          @else
            {{ number_format($qr_spp2[0]->Total + $qr_spp2[1]->Total,2,',','.') }}
          @endif
        </td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="4">Sisa Anggaran Kas Triwulan bersangkutan yang belum dibelanjakan (ii - iii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        {{-- <td class="text-right">{{number_format($qr_spp1[1]->Total*4- ($qr_spp1[2]->Anggaran == 3 ? $qr_spp1[2]->Total+$qr_spp1[3]->Total : $qr_spp1[2]->Total), 2, ',', '.') }}</td> --}}
        <td class="text-right">
          @if ($qr_spp1[1]->Total == 0)
			{{number_format($qr_spp1[0]->Total - ($qr_spp2[0]->Total + $qr_spp2[1]->Total), 2, ',', '.') }}
          @else
            {{number_format($qr_spp1[1]->Total*4 - ($qr_spp2[0]->Total + $qr_spp2[1]->Total), 2, ',', '.') }}
          @endif
        </td>
      </tr>
    </tbody>
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="font-weight-bold text-center" colspan="5">RINCIAN RENCANA PENGGUNAAN</td>
      </tr>
    </tbody>
    <thead>
      <tr class="text-center font-weight-bold">
        <td>No</td>
        <td>Kode Rekening</td>
        <td>Uraian</td>
        <td colspan="2">Jumlah</td>
      </tr>
    </thead>
    <tbody>
      @if (count($qr_spp) > 0)
      @foreach($qr_spp as $number => $dt)
      <tr class="text-center">
        <td style="width: 5%">{{$loop->iteration}}</td>
        <td style="width: 20%;">{{ $dt->Ko_rkk }}</td>
        <td class="text-left">{{ $dt->ur_rk6}}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 25%">{{ number_format($dt->Jumlah, 2, ",", ".") }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-center">
        <td>-</td>
        <td>-</td>
        <td class="text-left">-</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 25%">{{ number_format(0, 2, ",", ".") }}</td>
      </tr>
      @endif

      <tr class="text-right font-weight-bold">
        <td colspan="3">Total</td>
        <td class="text-center" style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 25%">{{ number_format(collect($qr_spp)->sum('Jumlah'), 2, ",", ".") }}</td>
      </tr>
    </tbody> 
  </table>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td style="width: 30%;">
          Nama dan Nomor Rekening Bank <br>
          Jumlah PPD yang diminta <br>
          Terbilang
        </td>
        <td style="width: 70%">
          : {{ $bank->Ur_Bank ?? "-" }} / {{ $bank->No_Rek ?? "--" }} <br>
          : Rp {{ number_format(collect($qr_spp)->sum('Jumlah'), 2, ",", ".") }} <br>
          : {{ ucwords(terbilang(collect($qr_spp)->sum('Jumlah'))) }} Rupiah
        </td>
      </tr>
    </tbody>
  </table>
  
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td colspan="2" class="text-center">
          <br>
          Mengetahui, <br>
          Pejabat Teknis Kegiatan <br><br><br><br>
          {{ $qr_spp[0]->Nm_PP ?? "--" }} <br>
          {{ $qr_spp[0]->NIP_PP ?? "--" }}
        </td>
        <td class="text-center">
          {{nm_ibukota()}}, {{  Carbon\Carbon::parse($spi->Dt_SPi)->isoFormat('D MMMM Y') }} <br>
          Bendahara Pengeluaran BLUD <br><br><br><br><br>
          {{ $qr_spp[0]->Nm_Ben ?? "--" }} <br> NIP. {{ empty($qr_spp) ? "-" : $qr_spp[0]->NIP_Ben}}
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