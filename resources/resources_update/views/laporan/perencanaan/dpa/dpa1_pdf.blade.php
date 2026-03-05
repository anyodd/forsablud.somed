<!DOCTYPE html>
<html>
@include('laporan.perencanaan.dpa.pdf_head')

<body>
    <footer class="pb-0">
        <?php date_default_timezone_set("Asia/Jakarta") ?>
        Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
    </footer>

    <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
    <tbody>
      {{-- <tr>
        <!-- Baris 1 -->
        <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="2">
          DOKUMEN PELAKSANAAN ANGGARAN<br>
          SATUAN KERJA PERANGKAT DAERAH
        </td>
        <td class="text-center" colspan="0">NOMOR DPA SKPD</td>
        <td class="text-center" style="vertical-align: middle;" colspan="6" rowspan="2">
          Formulir<br>
          DPA-SKPD	
        </td>
      </tr>
      <tr>
        <!-- Baris 2 -->
        <td class="text-center">{{$unit}}.00.4</td>
      </tr> --}}
      <tr>
        <!-- Baris 3 -->
        <td class="text-left" style="border-right-style: hidden;">
          @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
        <td class="text-center" colspan="8">
          DOKUMEN PELAKSANAAN ANGGARAN <br>
          SATUAN KERJA PERANGKAT DAERAH <br>
          NOMOR DPA SKPD : {{$unit}}.00.4 <br>
          {{ nm_pemda() }} <br>
          Tahun Anggaran {{ Tahun() }}
        </td>
        <td class="text-right" style="border-left-style: hidden;">
          @if (!empty(logo_blud()))
            <img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
      </tr>
      <tr>
            <!-- Baris 4 -->
            <td colspan="1" id="hapus">Urusan Pemerintahan</td>
            <td colspan="9" id="hapus">: 01.02 - Bidang Kesehatan</td>
        </tr>
        <tr>
            <!-- Baris 5 -->
            <td colspan="1" id="hapus">Organisasi</td>
            <td colspan="9" id="hapus">: {{ kd_unit() }} - {{ nm_unit() }}</td>
        </tr>
      <tr>
        <!-- Baris 6 -->
        <td class="text-center" colspan="10">
          Rincian Dokumen Pelaksanaan Anggaran Pendapatan<br>
          Satuan Kerja Perangkat Daerah
        </td>
      </tr>
      <tr>
        <!-- Baris 7 -->
        <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2">Kode Rekening</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="2">Uraian</td>
        <td class="text-center" colspan="3">Rincian Penghitungan</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="2">Jumlah</td>
      </tr>
      <tr>
        <!-- Baris 8 -->
        <td class="text-center">Volume</td>
        <td class="text-center">Satuan</td>
        <td class="text-center">Tarif/Harga</td>
      </tr>
      <tr>
        <!-- Baris 9 -->
        <td class="text-center" colspan="1">1</td>
        <td class="text-center" colspan="3">2</td>
        <td class="text-center">3</td>
        <td class="text-center">4</td>
        <td class="text-center">5</td>
        <td class="text-center" colspan="3">6</td>
      </tr>

      @foreach($ambildatapdfdpa1 as $number => $ambildatapdfdpa1)
      <tr>
        <!-- Baris 10 -->
        <td class="text-center" colspan="1">{{ $ambildatapdfdpa1->Ko_Rkk}}</td>
        <td colspan="3" width="10px">{{ $ambildatapdfdpa1->Ur_Rk6}}</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-right" colspan="3">Rp.{{ number_format($ambildatapdfdpa1->To_Rp, 0, ",", ".") }}</td>
      </tr>
      @endforeach
      <tr>
          <!-- Baris 15 -->
          <td class="text-right" colspan="7">Jumlah</td>
          <td class="text-right" colspan="3">Rp.{{ number_format($jumlah, 0, ",", ".") }}</td>
      </tr>
      <tr>
        <!-- Baris 12 -->
        <td colspan="10" id="hapus">Rencana Pendapatan Per Triwulan</td>
      </tr>
      <tr>
        <!-- Baris 13 -->
        <td colspan="2" id="hapus">Triwulan I</td>
        <td id="hapus">Rp...............................</td>
        <td class="text-center" colspan="7" id="hapus">{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
      </tr>
      <tr>
        <!-- Baris 14 -->
        <td colspan="2" id="hapus">Triwulan II</td>
        <td id="hapus">Rp...............................</td>
        <td class="text-center" colspan="7" id="hapus">Mengesahkan</td>
      </tr>
      <tr>
        <!-- Baris 15 -->
        <td colspan="2" id="hapus">Triwulan III</td>
        <td id="hapus">Rp...............................</td>
        <td class="text-center" colspan="7" id="hapus">Kepala {{ nm_unit() }}</td>
      </tr>
      <tr>
        <!-- Baris 16 -->
        <td colspan="2" id="hapus">Triwulan IV</td>
        <td id="hapus">Rp...............................</td>
        <td class="text-center" id="hapus" colspan="7" rowspan="3" style="vertical-align: middle;">(ttd)</td>
      </tr>
      <tr>
        <!-- Baris 17 -->
        <td colspan="2" id="hapus"></td>
        <td colspan="3" id="hapus"></td>
      </tr>
      <tr>
        <!-- Baris 18 -->
        <td colspan="2" id="hapus"></td>
        <td colspan="3" id="hapus"></td>
      </tr>
      <tr>
        <!-- Baris 19 -->
        <td class="text-center" colspan="2" id="hapus" rowspan="2">Jumlah</td>
        <td id="hapus" rowspan="2">Rp...............................</td>
        <td class="text-center" id="hapus" colspan="7">
          {{ $ambildatapdfdpa1->nm_pimp}}<br>
          NIP. {{ $ambildatapdfdpa1->nip_pimp}}
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
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
        </script>

</body>
</html>