<!DOCTYPE html>
<html>
@include('transaksi.penerimaan.realisasi.pdf_head')

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
        <td colspan="4" >
          PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
		  {{ strtoupper(nm_unit()) }} <br>
           SURAT BUKTI PEMBAYARAN <br>
		   (TBP)  <br>
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

  <table class="table table-sm table-borderedless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td style="border-right-style: hidden;width: 30%" >
          a. Nomor TBP <br>
		  telah menerima uang sebesar <br>
          Dengan Huruf <br>
        </td>
       
        <td colspan="4">
          : {{ $data[0]->No_bp }} <br>
          : Rp. {{number_format($jml,2,',','.')}}<br>
          : {{ucwords(terbilang($jml))}} Rupiah<br>
        </td>
      </tr>
	  <tr>
        <td style="border-right-style: hidden;width: 30%" >
          b. Dari <br>
		     Nama <br>
             Alamat <br>
        </td>
       
        <td colspan="4">
          <br>
          : Terlampir<br>
          : Terlampir<br>
        </td>
      </tr>
	   <tr>
        <td style="border-right-style: hidden;width: 30%" >
          c. Sebagai Pembayaran <br>
        </td>
       
        <td colspan="4">
          : {{ $data[0]->Ur_byr }} <br>
        </td>
      </tr>
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center font-weight-bold">
        <td width="15%">Kode Rekening</td>
        <td>Uraian Rincian Objek</td>
        <td width="20%">Jumlah</td>
      </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
      @foreach ($data as $item)
          <tr>
            <td>{{$item->Ko_Rkk}}</td>
            <td>{{$item->Ur_byr}} - {{$item->Ur_bprc}}</td>
            <td class="text-right">{{number_format($item->Nilai,2,',','.')}}</td>  
          </tr>Nilai
          @php
              $total += $item->Nilai;
          @endphp
      @endforeach
      <tr class="text-right font-weight-bold">
        <td colspan="2" class="text-center">Jumlah</td>
        <td class="text-right">Rp {{number_format($total,2,',','.')}}</td>
      </tr>
    </tbody> 
  </table>
  
  <table class="table table-sm table-borderedless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td style="border-right-style: hidden;width: 30%" >
          d. Tanggal uang dlterlma<br>
        </td>
       
        <td colspan="4">
          : {{  Carbon\Carbon::parse($data[0]->dt_byr)->isoFormat('D MMMM Y') }} <br>
        </td>
      </tr>
  </table>
  
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td colspan="2" class="text-center">
          Mengetahui, <br>
          Bendahara Penerimaan <br><br><br><br><br>
          @if (!empty($bendahara[0]))
              {{$bendahara[0]->Nm_Bend}}<br>
              NIP. {{$bendahara[0]->NIP_Bend}}
          @else
              TTD <br>
              NIP. -
          @endif
        </td>
        <td class="text-center">
          <br>
          Pembayar/Penyetor/Kasir <br><br><br><br>
          TTD <br>
		  <br>
        </td>
      </tr>
      
    </tbody> 
  </table>
  
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      
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