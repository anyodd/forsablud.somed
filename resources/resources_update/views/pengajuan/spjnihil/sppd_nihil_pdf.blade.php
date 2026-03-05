<!DOCTYPE html>
<html>
@include('pengajuan.spjnihil.pdf_head)

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
	  <tr class="font-weight-bold text-center">
			<td class="text-center" style="border-right-style: hidden;" colspan="2">
			  @if (!empty(logo_pemda()))
				<img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
			  @else
				  <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
			  @endif
			</td>
			<td colspan="4">
			  PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
			   SURAT PERMINTAAN PENCAIRAN DANA NIHIL <br>
          (SURAT-PPD NIHIL)<br>
			   NOMOR {{ $spi->No_SPi }}
			</td>
			<td class="text-center" style="border-left-style: hidden;" colspan="2">
			  @if (!empty(logo_blud()))
				<img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
			  @else
				  <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
			  @endif
			</td>
		</tr>
    </tbody> 
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr class="text-center" style="border-top-style: hidden;border-left-style: hidden;border-right-style: hidden;">
        <td class="font-weight-bold" colspan="4">RINGKASAN</td>
      </tr>
      <tr class="text-center">
        <td class="font-weight-bold" colspan="4">Ringkasan DBA/DBAP (3)</td>
      </tr>
      <tr class="text-center">
        <td colspan="2">Jumlah Dana DBA/DBAP</td>
        <td style="border-right-style: hidden;">Rp.</td>
        <td class="text-right">{{number_format($qr_spp1[0]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="text-center">
        <td class="font-weight-bold" colspan="4">Ringkasan Anggaran Kas</td>
      </tr>
      <tr class="text-center font-weight-bold">
        <td>No.</td>
        <td>Anggaran Kas</td>
        <td colspan="2">Jumlah</td>
      </tr>
      <tr>
        <td class="text-center" style="width: 5%">1</td>
        <td class="text-center">Triwulan 1</td>
        <td class="text-center" style="width: 5%;border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 25%">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="text-center">2</td>
        <td class="text-center">Triwulan 2</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="text-center">3</td>
        <td class="text-center">Triwulan 3</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="text-center">4</td>
        <td class="text-center">Triwulan 4</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="2">Jumlah (ii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total*4, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="2">Sisa dana di luar anggaran kas berkenaan dan triwulan sebelumnya (i-ii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[0]->Total-($qr_spp1[1]->Total*4), 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td colspan="2"></td>
      </tr>
      <tr class="text-center">
        <td class="font-weight-bold" colspan="4">Ringkasan Belanja</td>
      </tr>
      <tr>
        <td colspan="2">Belanja UP/GU</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($qr_spp1[2]->Anggaran == 3 ? $qr_spp1[2]->Total : 0, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td colspan="2">Belanja LS</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($qr_spp1[2]->Anggaran == 3 ? $qr_spp1[3]->Total : $qr_spp1[2]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="2">Jumlah (iii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($qr_spp1[2]->Anggaran == 3 ? $qr_spp1[2]->Total+$qr_spp1[3]->Total : $qr_spp1[2]->Total, 2, ',', '.') }}</td>
      </tr>
      <tr class="font-weight-bold">
        <td class="text-right" colspan="2">Sisa Anggaran Kas Triwulan bersangkutan yang belum dibelanjakan (ii - iii)</td>
        <td class="text-center" style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{number_format($qr_spp1[1]->Total*4- ($qr_spp1[2]->Anggaran == 3 ? $qr_spp1[2]->Total+$qr_spp1[3]->Total : $qr_spp1[2]->Total), 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="font-weight-bold" class="text-center">RINCIAN PENGGUNAAN (4)</td>
      </tr>
      <tr>
        <td>
          Program : Pelayanan dan Penunjang Pelayanan BLUD <br>
          Kegiatan : Pelayanan dan Penunjang Pelayanan BLUD <br>
          Subkegiatan : Pelayanan dan Penunjang Pelayanan BLUD
        </td>
      </tr>
    </tbody> 
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold">
        <td style="width: 5%">No</td>
        <td style="width: 20%;">Kode Rekening</td>
        <td>Uraian</td>
        <td colspan="2">Jumlah</td>
      </tr>
    </thead>
    <tbody>
      @if (count($qr_spp) > 0)
      @foreach($qr_spp as $number => $dt)
      <tr class="text-center">
        <td>{{$loop->iteration}}</td>
        <td>{{ $dt->Ko_rkk }}</td>
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
          Jumlah PPD yang diminta <br>
          Terbilang <br>
          Nama dan Nomor Rekening Bank
        </td>
        <td>
          : Rp {{ number_format(collect($qr_spp)->sum('Jumlah'), 2, ",", ".") }} <br>
          : {{ ucwords(terbilang(collect($qr_spp)->sum('Jumlah'))) }} Rupiah<br>
          : {{ empty($qr_spp) ? '-' : 1 }} / {{ $qr_spp[0]->rekan_rekbank ?? "--" }}
        </td>
        <td style="width: 30%;"></td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td class="text-center">
          {{nm_ibukota()}}, {{ Carbon\Carbon::parse($spi->Dt_SPi)->isoFormat('D MMMM Y') }} <br>
          Bendahara Pengeluaran BLUD <br><br><br><br><br>
          {{  $qr_spp[0]->Nm_Ben ?? "--" }} <br> NIP. {{ $qr_spp[0]->NIP_Ben ?? "--" }}
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