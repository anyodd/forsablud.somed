<!DOCTYPE html>
<html>
@include('pembukuan.spm.pdf_head')

<body>

  <footer class="pb-0">
    <?php date_default_timezone_set("Asia/Jakarta") ?>
    Tgl Cetak: {{ date("d-m-Y H:i:s") }} - User: {{ getUser('username') }}
  </footer>

  <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <tbody>
      <tr class="text-center">
        <td class="text-center" style="border-right-style: hidden;" colspan="2">
          @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
        <td colspan="4">
          PEMERINTAH {{ strtoupper(nm_pemda()) }} <br>
          SURAT PENCAIRAN DANA (SURAT-PD) <br>UP/GU/LS * <br>
          Nomor {{$data->No_npd}}
        </td>
        <td class="text-center" style="border-left-style: hidden;" colspan="2">
          @if (!empty(logo_blud()))
            <img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
          @else
              <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
          @endif
        </td>
      </tr>

      <tr>
        <td colspan="2" style="border-right-style: hidden;">
          Nomor DBA <br>
          Tanggal DBA <br>
          Nomor OPD <br>
          Tanggal OPD <br>
          BLUD
        </td>
        <td colspan="3">
          : {{ $dba[0]->No_DPA }} <br>
          : {{ Carbon\Carbon::parse($dba[0]->Dt_DPA)->isoFormat('DD MMMM Y') }} <br>
          : {{ $data->No_oto}} <br>
          : {{ Carbon\Carbon::parse($data->Dt_oto)->isoFormat('DD MMMM Y') }} <br>
          : {{ nm_unit() }}
        </td>
        <td colspan="3">
          Dari : Direktur <br>
          Tahun Anggaran : {{ Tahun() }}
        </td>
      </tr>
      <tr>
        <td colspan="2" style="border-right-style: hidden;">
          Bank/Pos <br>
          <br>
          Uang sebesar
        </td>
        <td colspan="6">
          : {{ rek_utama('Ur_Bank') ?? "---" }} <br>
          Hendaklah mencairkan/memindahbukukan dari Bank rekening nomor : {{ rek_utama('No_Rek') ?? "---" }} <br>
          @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4')
            : Rp {{ number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah')-$qr_pot->sum('tax_Rp'), 2, ',', '.') }} <br>
            ( {{ ucwords(terbilang($qr_sp2d->where('Kode', '1')->sum('Jumlah')-$qr_pot->sum('tax_Rp'))) }} Rupiah )
          @else
            : Rp {{ number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah'), 2, ',', '.') }} <br>
            ( {{ ucwords(terbilang($qr_sp2d->where('Kode', '1')->sum('Jumlah'))) }} Rupiah )
          @endif
          
        </td>
      </tr>

      <tr>
        <td colspan="2" style="border-right-style: hidden;">
          Kepada <br>
          NPWP <br>
          No. Rekening <br>
          Bank/Pos <br>
          Untuk
        </td>
        <td colspan="6">
          : {{ $qr_sp2d[0]->Trm_Nm }} <br>
          : {{ $qr_sp2d[0]->Trm_NPWP }} <br>
          : {{ $qr_sp2d[0]->Trm_rek }} <br>
          : {{ $qr_sp2d[0]->Trm_bank }} <br>
          : {{ $qr_sp2d[0]->Ur_oto }} <br>
        </td>
      </tr>

      <tr class="text-center font-weight-bold">
        <td style="width: 5%">No</td>
        <td colspan="2">Kode Rekening</td>
        <td colspan="3">Uraian</td>
        <td colspan="2">Jumlah</td>
      </tr>

      @if (count($qr_sp2d->where('Kode', '1')) > 0)
      @foreach($qr_sp2d->where('Kode', '1') as $number => $dt)
      <tr class="text-center">
        <td>{{$loop->iteration}}</td>
        <td colspan="2">{{ $dt->Ko_Rkk }}</td>
        <td colspan="3" class="text-left">{{ $dt->Ur_Rk6}}</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 20%">{{ number_format($dt->Jumlah, 2, ",", ".") }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-center">
        <td>-</td>
        <td>-</td>
        <td class="text-left">-</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 20%">{{ number_format(0, 2, ",", ".") }}</td>
      </tr>
      @endif

      <tr class="text-center font-weight-bold">
        <td class="text-right" colspan="6">Jumlah</td>
        <td style="width: 5%; border-right-style: hidden;">Rp</td>
        <td class="text-right" style="width: 20%">{{  number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah'), 2, ",", ".") }}</td>
      </tr>

      <tr>
        <td colspan="8">Potongan - potongan</td>
      </tr>
    </tbody>

    <thead>
      <tr class="text-center">
        <td>No</td>
        <td colspan="3">Uraian</td>
        <td colspan="2">Jumlah</td>
        <td colspan="2">Keterangan</td>
      </tr>
    </thead>

    <tbody>
      {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4') --}}
      @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) == 0)
        @foreach($qr_pot as $dt)
          <tr class="text-center">
            <td>{{$loop->iteration}}</td>
            <td class="text-left" colspan="3">{{ $dt->Ko_tax }}</td>
            <td style="width: 5%; border-right-style: hidden;">Rp</td>
            <td class="text-right" style="width: 20%">{{ number_format($dt->tax_Rp, 2, ",", ".") }}</td>
            <td colspan="2"></td>
          </tr>
        @endforeach
      @else
        <tr class="text-center">
          <td>-</td>
          <td colspan="3">-</td>
          <td style="width: 5%; border-right-style: hidden;">Rp</td>
          <td class="text-right" style="width: 20%">0,00</td>
          <td colspan="2"></td>
        </tr>
      @endif
      
      {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4') --}}
      @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) == 0)
        <tr class=" font-weight-bold">
          <td colspan="4" class="text-right">Jumlah</td>
          <td style="border-right-style: hidden;">Rp</td>
          <td class="text-right">{{ number_format($qr_pot->sum('tax_Rp'), 2, ",", ".") }}</td>
          <td colspan="2"></td>
        </tr>
      @else
        <tr class=" font-weight-bold">
          <td colspan="4" class="text-right">Jumlah</td>
          <td style="border-right-style: hidden;">Rp</td>
          <td class="text-right">-</td>
          <td colspan="2"></td>
        </tr>
      @endif
    </tbody>

    <tr>
      <td colspan="8">Informasi: (Potongan pajak tidak mengurangi jumlah pembayaran SURAT-PD)</td>
    </tr>
    <thead>
      <tr class="text-center">
        <td>No</td>
        <td colspan="3">Uraian</td>
        <td colspan="2">Jumlah</td>
        <td colspan="2">Keterangan</td>
      </tr>
    </thead>

    <tbody>
      {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi == '4') --}}
      @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) != 0)
        @foreach($qr_pot as $dt)
          <tr class="text-center">
            <td>{{$loop->iteration}}</td>
            <td class="text-left" colspan="3">{{ $dt->Ko_tax }}</td>
            <td style="width: 5%; border-right-style: hidden;">Rp</td>
            <td class="text-right" style="width: 20%">{{ number_format($dt->tax_Rp, 2, ",", ".") }}</td>
            <td colspan="2"></td>
          </tr>
        @endforeach
      @else
        <tr class="text-center">
          <td>-</td>
          <td colspan="3">-</td>
          <td style="width: 5%; border-right-style: hidden;">Rp</td>
          <td class="text-right" style="width: 20%">0,00</td>
          <td colspan="2"></td>
        </tr>
      @endif
      
      {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi == '4') --}}
      @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) != 0)
        <tr class=" font-weight-bold">
          <td colspan="4" class="text-right">Jumlah</td>
          <td style="border-right-style: hidden;">Rp</td>
          <td class="text-right">{{ number_format($qr_pot->sum('tax_Rp'), 2, ",", ".") }}</td>
          <td colspan="2"></td>
        </tr>
      @else
        <tr class=" font-weight-bold">
          <td colspan="4" class="text-right">Jumlah</td>
          <td style="border-right-style: hidden;">Rp</td>
          <td class="text-right">-</td>
          <td colspan="2"></td>
        </tr>
      @endif
    </tbody>
    <tbody>
      <tr>
        <td colspan="4">
          SURAT-PD yang dibayarkan <br>
          Jumlah yang diminta <br>
          Jumlah potongan <br>
          Jumlah yang dibayarkan
        </td>
        <td  style="border-right-style: hidden; border-left-style: hidden;"><br>: Rp <br>: Rp <br>: Rp </td>
        <td colspan="3" class="text-right">
          <br>
          {{  number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah'), 2, ",", ".") }} <br>
          {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4') --}}
          @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) == 0)
            {{  number_format($qr_pot->sum('tax_Rp'), 2, ",", ".") }} <br>
          @else
            - <br>
          @endif
          {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4') --}}
          @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) == 0)
            {{  number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah')-$qr_pot->sum('tax_Rp'), 2, ",", ".") }}
          @else
            {{  number_format($qr_sp2d->where('Kode', '1')->sum('Jumlah'), 2, ",", ".") }}
          @endif
        </td>
      </tr>
      <tr style="border-top-style: hidden;">
        <td colspan="8">
          {{-- @if (count($qr_pot) > 0 && $qr_pot['0']->Ko_SPi != '4') --}}
          @if (count($qr_pot) > 0 && in_array($qr_pot['0']->Ko_SPi,array('4','6')) == 0)
            ( {{ ucwords(terbilang($qr_sp2d->where('Kode', '1')->sum('Jumlah')-$qr_pot->sum('tax_Rp'))) }} Rupiah )
          @else
            ( {{ ucwords(terbilang($qr_sp2d->where('Kode', '1')->sum('Jumlah'))) }} Rupiah )
          @endif
        </td>
      </tr>

      <tr>
        <td colspan="5" style="border-right-style: hidden;">
          <br><br><br>
          * coret yang tidak perlu <br>
          ** menyesuaikan ketentuan lebih lanjut <br>
          *** menyesuaikan ketentuan per-UU-an
        </td>
        <td colspan="3" class="text-center">
          {{nm_ibukota()}}, {{ \Carbon\Carbon::parse($qr_sp2d[0]->dt_byro)->isoFormat('DD MMMM Y') }} <br>
          @if (jabatan($ttd->nip) != '')
          Direktur <br><br><br>
          @else
          {{ jabatan($ttd->NIP_PP) }}<br><br><br>
          @endif
          {{$ttd->Nm_PP}} <br>
          NIP {{$ttd->NIP_PP}}
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