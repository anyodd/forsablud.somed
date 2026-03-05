<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>RBA-Belanja Rinci</title>
    @endsection
    @include('laporan.perencanaan.rba.pdf_head')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table id="example1" class="table table-sm table-bordered table-striped" style="width: 100%;font-size: 6pt">
                        <thead>
                            <tr>
                                <td class="text-center" style="border-right-style: hidden;">
                                    @if (!empty(logo_pemda()))
                                      <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
                                    @else
                                        <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
                                    @endif
                                </td>
                                <td class="text-center" colspan="7">
                                    PEMERINTAH {{ nm_pemda() }} <br>
                                    {{ nm_unit() }}
                                    <br>
                                    RENCANA BISNIS DAN ANGGARAN
                                    <br>
                                    ANGGARAN BELANJA RINCI TAHUN ANGARAN {{ Tahun() }} <br>
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
                                <td class="text-center" rowspan="2" style="vertical-align: middle;">Sumber Dana</td>
                                <td class="text-center" rowspan="2" style="vertical-align: middle;">
                                    Uraian</td>
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
                                <td class="text-center" style="vertical-align: middle;">3</td>
                                <td class="text-center" colspan="4">4</td>
                                <td class="text-center">5</td>
                                <td class="text-center">6</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rba2rinci as $gr => $rincirba)
                                <tr>
                                    <td class="text-center"><strong>{{ $loop->iteration }}.</strong></td>
                                    <td colspan="7"><strong style="color: black"> {{ $gr }} </strong></td>
                                    <td style="text-align: right"> <strong style="color: black">
                                        {{ number_format($rincirba['tot'], 2, ",", ".") }} </strong>
                                    </td>
                                </tr>
                                @foreach ($rincirba['rincian'] as $rinc1 => $rinci1rba)
                                    <tr>
                                        <td></td>
                                        <td style="text-align: left">&nbsp;<strong>{{ $loop->parent->iteration . '.' . $loop->iteration }}</strong></td>
                                        <td style="text-align: left" colspan="6">&nbsp;<strong>{{ $rinc1 }}</strong></td>
                                        <td style="text-align: right">
                                            <strong>{{ number_format($rinci1rba['subtotal1'], 2, ",", ".") }}</strong>
                                        </td>
                                    </tr>
                                    @foreach ($rinci1rba['subrincian1'] as $rinc2 => $rinci2rba)
                                        <tr>
                                            <td></td>
                                            <td style="text-align: left">&nbsp;&nbsp;{{ $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                            <td style="text-align: left" colspan="6">&nbsp;&nbsp;{{ $rinc2 }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($rinci2rba['subtotal2'], 2, ",", ".")}}
                                            </td>
                                        </tr>
                                        @foreach ($rinci2rba['subrincian2'] as $rinc3 => $rinci3rba)
                                            <tr>
                                                <td></td>
                                                <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinci3rba['ko_rkk'] }}</td>
                                                <td style="text-align: left" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc3 }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($rinci3rba['subtotal3'], 2, ",", ".")}}
                                                </td>
                                            </tr>
                                            @foreach ($rinci3rba['subrincian3'] as $rinc4 => $rinci4rba)
                                                <tr>
                                                    <td></td>
                                                    <td class="text-right">{{ $loop->iteration }}.</td>
                                                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc4 }}</td>
                                                    <td style="text-align: right">{{ number_format($rinci4rba['0']->JLTo_Rp,2,',','.') }}</td>
                                                    <td style="text-align: right">{{ number_format($rinci4rba['0']->HbTo_Rp,2,',','.') }}</td>
                                                    <td style="text-align: right">{{ number_format($rinci4rba['0']->KSTo_Rp,2,',','.') }}</td>
                                                    <td style="text-align: right">{{ number_format($rinci4rba['0']->BLTo_Rp,2,',','.') }}</td>
                                                    <td style="text-align: right">{{ number_format($rinci4rba['0']->APTo_Rp,2,',','.') }}</td>
                                                    <td style="text-align: right">
                                                        {{ number_format($rinci4rba[0]->To_Rp, 2, ",", ".") }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                        {{-- <tfoot style="font-size: 9pt">
                            <td style="text-align: left"></td>
                            <td colspan="6"> <strong style="color: blue"> </strong></td>
                            <td colspan="2" style="text-align: center"> <strong>
                                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                                    <br>
                                    Direktur {{ nm_unit() }}
                                    <br><br><br>
                                    ttd
                                    <br><br>
                                    {{ $footer[0]->Nm_Pimp }}
                                    <br>
                                    {{ $footer[0]->NIP_Pimp }}
                                </strong> </td>
                        </tfoot> --}}
                    </table><br>
                    <table class="table table-borderless" cellspacing="0">
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
                    </table>
                </div>
            </div>
        </div>
</body>

</html>
