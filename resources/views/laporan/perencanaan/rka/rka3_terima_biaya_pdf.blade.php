<!DOCTYPE html>
<html>
@include('laporan.perencanaan.rka.pdf_head')

<body>
  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td class="text-left" style="border-right-style: hidden;">
          @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
        <td class="text-center">
          RENCANA KERJA DAN ANGGARAN <br>
          SATUAN KERJA PERANGKAT DAERAH <br>
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
        {{-- <td class="text-center" style="vertical-align: top;">FORMULIR <br>RKA - SKPD</td> --}}
      </tr>
      <tr>
        <td>Urusan Pemerintahan</td>
        <td colspan="2">: 01.02 - Bidang Kesehatan</td>
      </tr>
      <tr>
        <td>Organisasi</td>
        <td colspan="2">: {{ kd_unit() }} - {{ nm_unit() }}</td>
      </tr>
      <tr>
        <td class="text-center" colspan="3">
          Rincian Penerimaan Pembiayaan
        </td>
      </tr>
      <tr>
        <td class="text-center" style="vertical-align: middle;">Kode Rekening</td>
        <td class="text-center" style="vertical-align: middle;">Uraian</td>
        <td class="text-center">Jumlah <br>(Rp)</td>
      </tr>
      <tr>
        <td class="text-center" style="width: 18%">1</td>
        <td class="text-center">2</td>
        <td class="text-center" style="width: 23%">3</td>
      </tr>
      
      @foreach($data as $number => $data)
      <tr>
        <td class="text-center">{{ $data->Ko_Rkk}}</td>
        <td >{{ $data->Ur_Rk6 }}</td>
        <td class="text-right">{{ number_format($data->To_Rp, 0, ",", ".") }}</td>
      </tr>
      @endforeach

      <tr>
        <td class="text-right" colspan="2">Jumlah Penerimaan Pembiayaan</td>
        <td class="text-right">{{ number_format($jumlah, 0, ",", ".") }}</td>
      </tr>

      <tr>
        <td colspan="2" style="border-right-style: none;"></td>
        <td class="text-center" style="border-left-style: none;">
          {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }} <br>
          Kepala {{ nm_unit() }} <br><br>
          <br><br>
          {{ $data->nm_pimp = '' ? $data->nm_pimp : '-'}} <br>
            NIP {{ $data->nm_pimp = '' ? $data->nip_pimp : '-' }}
        </td>
      </tr>
    </tbody>
  </table>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td colspan="7">Keterangan: ...................</td>
      </tr>
      <tr>
        <td colspan="7">Tanggal Pembahasan: </td>
      </tr>
      <tr>
        <td colspan="7">Catatan Hasil Pembahasan: </td>
      </tr>
      <tr>
        <td style="width: 3%" class="text-center">1. </td>
        <td colspan="6">..... </td>
      </tr>
      <tr>
        <td style="width: 3%" class="text-center">2. </td>
        <td colspan="6">..... </td>
      </tr>
      <tr>
        <td style="width: 3%" class="text-center">Dst. <br><br></td>
        <td colspan="6">..... </td>
      </tr>
      <tr>
        <td class="text-center" colspan="7">Tim Anggaran Pemerintah Daerah: ...............</td>
      </tr>
      <tr>
        <td class="text-center" style="width: 3%;">No</td>
        <td colspan="2" class="text-center">Nama</td>
        <td colspan="2" class="text-center">NIP</td>
        <td class="text-center">Jabatan</td>
        <td class="text-center">Tanda Tangan</td>
      </tr>
      <tr>
        <td class="text-center">1</td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td class="text-center">2</td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td class="text-center">dst</td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
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