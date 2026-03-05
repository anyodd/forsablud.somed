<!DOCTYPE html>
<html>
@include('pengesahan.sp3b.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="text-center" style="border-right-style: hidden;">
          @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
        <td class="text-center" colspan="4">
          PEMERINTAH {{ nm_pemda() }} <br>
          {{ nm_unit() }} <br>
          SURAT PERMINTAAN PENGESAHAN PENDAPATAN, BELANJA, DAN PEMBIAYAAN BADAN LAYANAN UMUM DAERAH <br>
          Tanggal {{ Carbon\Carbon::parse($sp3b->Dt_sp3)->isoFormat('D MMMM Y') }} Nomor {{ $sp3b->No_sp3 }}
        </td>
        <td class="text-center" style="border-left-style: hidden;">
          @if (!empty(logo_blud()))
            <img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
      </tr>
      <tr>
        <td class="text-justify" colspan="6">Kepala SKPD {{ nm_unit() }} memohon kepada Bendahara Umum Daerah selaku PPKD agar mengesahkan dan membukukan pendapatan, belanja, dan pembiayaan sejumlah:
        </td>
      </tr> 
      <tr style="border-top-style: hidden;">
        <td colspan="2">
          1. Saldo bulan sebelumnya* <br> 
          2. Pendapatan <br>
          3. Belanja <br>
          4. Pembiayaan Netto* <br>
          5. Penyesuaian : <br>
          &nbsp;&nbsp;&nbsp;&nbsp;- Penerimaan <br>
          &nbsp;&nbsp;&nbsp;&nbsp;- Penyetoran <br>
          6. Saldo bulan berkenaan
        </td>
        <td style="border-left-style: hidden;">
          Rp <br>
          Rp <br>
          Rp <br>
          Rp <br>
          <br>
          Rp <br>
          Rp <br>
          Rp
        </td>
        <td style="border-left-style: hidden;" class="text-right">
          {{ number_format($soawal, 2, ',', '.') }} <br>
          {{ number_format($sum_pendapatan, 2, ',', '.') }} <br>
          {{ number_format($sum_belanja, 2, ',', '.') }} <br>
          @if($biaya_netto < 0)
            ({{ number_format($biaya_netto *-1, 2, ',', '.') }}) <br>
          @else
            {{ number_format($biaya_netto, 2, ',', '.') }} <br>
          @endif
          {{-- {{ number_format($penyesuaian, 2, ',', '.') }} <br> --}}
          <br>
          @if (!empty($sum_penyesuaian_lebih))
          {{ number_format($sum_penyesuaian_lebih, 2, ',', '.') }} <br>
          @else
          - <br>  
          @endif
          @if (!empty($sum_penyesuaian_kurang))
          ({{ number_format($sum_penyesuaian_kurang, 2, ',', '.') }}) <br>
          @else
          - <br>  
          @endif
          {{-- {{ number_format($soakhir-$sum_penyesuaian_lebih ?? 0, 2, ',', '.') }} --}}
          @php
              $sesuai = $sum_penyesuaian_lebih - $sum_penyesuaian_kurang
          @endphp
          {{-- @if ($sesuai < 0)
            {{ number_format(($soawal+$sum_pendapatan-$sum_belanja-$biaya_netto+$sesuai) ?? 0, 2, ',', '.') }}
          @else
            {{ number_format(($soawal+$sum_pendapatan-$sum_belanja-$biaya_netto-$sesuai) ?? 0, 2, ',', '.') }}
          @endif  --}}
          {{ number_format(($sp3b_saldo) ?? 0, 2, ',', '.') }} 
        </td>
        <td style="border-left-style: hidden;" colspan="2"></td>
      </tr>
      
      <tr>
        <td colspan="3">
          Untuk bulan: {{ nmbulan($sp3b->bln_sp3) }}
        </td>
        <td colspan="3" style="border-left-style: hidden;">
          Tahun Anggaran {{ Tahun() }}
        </td>
      </tr>
      
      <tr class="text-center">
        <td colspan="2">
          Dasar Pengesahan
        </td>
        <td>
          Urusan
        </td>
        <td>
          Organisasi
        </td>
        <td colspan="2">
          Nama BLUD
        </td>
      </tr>

      <tr>
        <td colspan="2" style="font-size: xx-small;">{{ $qr_sp3b_2[0]->Dasar }}</td>
        <td>{{ $qr_sp3b_2[0]->Urusan }}</td>
        <td>{{ $qr_sp3b_2[0]->Organisasi }}</td>
        <td colspan="2">{{ nm_unit() }}</td>
      </tr>

      <tr><td class="text-center" colspan="6">Program, Kegiatan</td></tr>

      <tr><td class="text-center" colspan="6">{{ $qr_sp3b_2[0]->Kode_prokeg }} - {{ $qr_sp3b_2[0]->Ur_keg }}</td></tr>

      <tr><td colspan="6"></td></tr>

    </tbody>
  </table>

  {{-- Tabel Pendapatan vs Belanja --}}

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center">
        <td colspan="3">Pendapatan</td>
        <td colspan="3">Belanja</td>
      </tr>
      <tr class="text-center">
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
      </tr>
    </thead>

    <tbody>
      @if (count($qr_sp3b_pdp_bel) > 0)
      @foreach($qr_sp3b_pdp_bel as $number => $qr_sp3b_pdp_bel)
      <tr>
        <td style="width: 30%; font-size: 10px">{{ $qr_sp3b_pdp_bel->Ko_Rkk_pdp }} <br> {{ $qr_sp3b_pdp_bel->Ur_Rk6_pdp }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%;" class="text-right">
          @if($qr_sp3b_pdp_bel->spirc_Rp_pdp < 0)
          ({{ number_format($qr_sp3b_pdp_bel->spirc_Rp_pdp *-1, 2, ",", ".") }})
          @else
          {{ number_format($qr_sp3b_pdp_bel->spirc_Rp_pdp, 2, ",", ".") }}
          @endif
        </td>
        <td style="font-size: 10px">{{ $qr_sp3b_pdp_bel->Ko_Rkk_bel }} <br> {{ $qr_sp3b_pdp_bel->Ur_Rk6_bel }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%;" class="text-right">
          @if($qr_sp3b_pdp_bel->spirc_Rp_bel < 0)
          ({{ number_format($qr_sp3b_pdp_bel->spirc_Rp_bel *-1, 2, ",", ".") }})
          @else
          {{ number_format($qr_sp3b_pdp_bel->spirc_Rp_bel, 2, ",", ".") }}
          @endif
        </td>
      </tr>
      @endforeach
      @endif
    </tbody>
    <tbody>
      <tr>
        <td>Jumlah Pendapatan</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($sum_pendapatan, 2, ",", ".") }}</td>
        <td>Jumlah Belanja</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($sum_belanja, 2, ",", ".") }}</td>
      </tr>
    </tbody>
    
    <tr><td colspan="6"></td></tr>
  </table>

  {{-- Tabel Penerimaan Pembiayaan vs Pengeluaran Pembiayaan --}}
  
  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center">
        <td colspan="3">Penerimaan Pembiayaan</td>
        <td colspan="3">Pengeluaran Pembiayaan</td>
      </tr>
      <tr class="text-center">
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
      </tr>
    </thead>

    <tbody>
      @if (count($qr_sp3b_biaya) > 0)
      @foreach($qr_sp3b_biaya as $number => $qr_sp3b_biaya)
      <tr>
        <td style="width: 30%; font-size: 10px">{{ $qr_sp3b_biaya->Ko_Rkk_pdp }} <br> {{ $qr_sp3b_biaya->Ur_Rk6_pdp }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">
          @if($qr_sp3b_biaya->spirc_Rp_pdp < 0)
            ({{ number_format($qr_sp3b_biaya->spirc_Rp_pdp *-1, 2, ",", ".") }})
          @else
            {{ number_format($qr_sp3b_biaya->spirc_Rp_pdp, 2, ",", ".") }}
          @endif
        </td>
        <td style="font-size: 10px">{{ $qr_sp3b_biaya->Ko_Rkk_bel }} <br> {{ $qr_sp3b_biaya->Ur_Rk6_bel }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">{{ number_format($qr_sp3b_biaya->spirc_Rp_bel, 2, ",", ".") }}</td>
      </tr>
      @endforeach
      @else
      <tr>
        <td style="width: 30%; font-size: 10px">_</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">0,00</td>
        <td style="font-size: 10px">_</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">0,00</td>
      </tr>
      @endif
    </tbody>
    <tbody>
      <tr>
        <td>Jumlah Penerimaan Pembiayaan</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">
          @if($sum_terimabiaya < 0)
            ({{ number_format($sum_terimabiaya *-1, 2, ",", ".") }})
          @else
            {{ number_format($sum_terimabiaya, 2, ",", ".") }}
          @endif
        </td>
        <td>Jumlah Pengeluaran Pembiayaan</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($sum_keluarbiaya, 2, ",", ".") }}</td>
      </tr>
    </tbody>

      <tr><td colspan="6"></td></tr>
  </table>

  {{-- Penyesuaian Lebih vs Penyesuaian Kurang --}}

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead>
      <tr class="text-center">
        <td colspan="3">Penyesuaian Lebih</td>
        <td colspan="3">Penyesuaian Kurang</td>
      </tr>
      <tr class="text-center">
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
        <td>Kode Rekening</td>
        <td colspan="2">Jumlah</td>
      </tr>
    </thead>

    <tbody>
      @if (count($qr_sp3b_penyesuaian) > 0)
      @foreach($qr_sp3b_penyesuaian as $number => $qr_sp3b_penyesuaian)
      <tr>
        <td style="width: 30%; font-size: 10px">{{ $qr_sp3b_penyesuaian->Ko_Rkk_lebih }} <br> {{ $qr_sp3b_penyesuaian->Ur_Rk6_lebih }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">{{ number_format($qr_sp3b_penyesuaian->Penerimaan_lebih, 2, ",", ".") }}</td>
        <td style="font-size: 10px">{{ $qr_sp3b_penyesuaian->Ko_Rkk_kurang }} <br> {{ $qr_sp3b_penyesuaian->Ur_Rk6_kurang }}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">{{ number_format($qr_sp3b_penyesuaian->Pengeluaran_kurang, 2, ",", ".") }}</td>
      </tr>
      @endforeach
      @else
      <tr>
        <td style="width: 30%; font-size: 10px">_</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">0,00</td>
        <td style="font-size: 10px">_</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td style="width: 15%" class="text-right">0,00</td>
      </tr>
      @endif
    </tbody>
    <tbody>
      <tr>
        <td>Jumlah Penyesuaian Lebih</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($sum_penyesuaian_lebih, 2, ",", ".") }}</td>
        <td>Jumlah  Penyesuaian Kurang</td>
        <td style="border-right-style: hidden;">Rp</td>
        <td class="text-right">{{ number_format($sum_penyesuaian_kurang, 2, ",", ".") }}</td>
      </tr>
    </tbody>

  </table>
  
  
  <!-- TTD -->
  <table class="table table-sm table-borderless" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td>* isi salah satu</td>
        <td class="text-center">
          {{nm_ibukota()}}, {{ Carbon\Carbon::parse($sp3b->Dt_sp3)->isoFormat('D MMMM Y') }}<br>
          Direktur {{nm_unit()}} <br><br><br><br>
          {{ $sp3b->Nm_Kuasa }}<br>
          NIP {{$sp3b->NIP_Kuasa}}
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