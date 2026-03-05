<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>DBA-Belanja</title>
    @endsection
    @include('laporan.perencanaan.dba.pdf_head')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
                        <thead class="">
                            <tr>
                                <td class="text-center" style="border-right-style: hidden;">
                                    @if (!empty(logo_pemda()))
                                      <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
                                    @else
                                        <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
                                    @endif
                                </td>
                                <td class="text-center" colspan="6">
                                    PEMERINTAH {{ nm_pemda() }} <br>
                                    {{ nm_unit() }}
                                    <br>
                                    DOKUMEN BISNIS DAN ANGGARAN
                                    <br>
                                    ANGGARAN BELANJA TAHUN ANGARAN {{ Tahun() }} <br>
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
                                <td class="text-center" rowspan="2" style="vertical-align: middle;">No</td>
                                <td class="text-center" rowspan="2" style="vertical-align: middle;">Uraian
                                </td>
                                <td class="text-center" colspan="4">Pendapatan Layanan</td>
                                <td class="text-center" rowspan="2">APBD</td>
                                <td class="text-center" rowspan="2">Jumlah <br>(Rp)</td>
                            </tr>
                            <tr>
                                <td class="text-center">Jasa Layanan</td>
                                <td class="text-center">Hibah</td>
                                <td class="text-center">Hasil Kerjasama</td>
                                <td class="text-center">Lain PBLUDYS</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">1</td>
                                <td class="text-center" style="vertical-align: middle;">2</td>
                                <td class="text-center" colspan="4">3</td>
                                <td class="text-center">4</td>
                                <td class="text-center">5</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($gburblj as $gr => $urblj)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        {{ $gr }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right">
                                        <strong>{{ number_format($urblj['subtotal'],2,',','.') }}</strong>
                                    </td>
                                </tr>

                                @foreach ($urblj['subrincian'] as $item)
                                    <tr>
                                        <td style="text-align: center">({{ $loop->iteration }})</td>
                                        <td style="text-align: left">{{ $item['Ur_Rk4'] }}</td>
                                        <td class="text-right">{{ number_format($item['JLTo_Rp'],2,',','.') }}</td>
                                        <td class="text-right">{{ number_format($item['HbTo_Rp'],2,',','.') }}</td>
                                        <td class="text-right">{{ number_format($item['KSTo_Rp'],2,',','.') }}</td>
                                        <td class="text-right">{{ number_format($item['BLTo_Rp'],2,',','.') }}</td>
                                        <td class="text-right">{{ number_format($item['APTo_Rp'],2,',','.') }} </td>
                                        <td class="text-right">
                                            {{ number_format($item['JLTo_Rp'] + $item['HbTo_Rp'] + $item['KSTo_Rp'] + $item['BLTo_Rp'] + $item['APTo_Rp'],2,',','.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $total += $urblj['subtotal'];
                                @endphp
                            @endforeach
                                <tr>
                                    <td style="text-align: center" colspan="7"><strong>Jumlah</strong></td>
                                    <td class="text-right"><strong>{{ number_format($total,2,',','.') }}</strong></td>
                                </tr>
                        </tbody>
                    </table><br>
                    <table class="table table-borderless" cellspacing="0">
                        <tbody>
                            <td style="text-align: center">
                                <strong>
                                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                                    <br>
                                    Direktur {{ nm_unit() }}
                                    <br><br><br>
                                    <br><br>
                                    {{ $footer[0]->Nm_Pimp }}
                                    <br>
                                    {{ $footer[0]->NIP_Pimp }}
                                </strong>
                            </td>
                        </tbody>    
                    </table>
                </div>
            </div>
        </div>
</body>

</html>
