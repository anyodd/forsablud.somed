<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>RBA-Rincian</title>
    @endsection
    @include('laporan.perencanaan.rba.pdf_head')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table id="example1" class="table table-sm table-bordered table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <td class="text-center" style="border-right-style: hidden;">
                                    @if (!empty(logo_pemda()))
                                      <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
                                    @else
                                        <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
                                    @endif
                                </td>
                                <td class="text-center" colspan="10">
                                    PEMERINTAH {{ nm_pemda() ?? 'DEMO' }} <br>
                                    {{ nm_unit() ?? 'DEMO' }}
                                    <br>
                                    RINCIAN RENCANA BISNIS DAN ANGGARAN
                                    <br>
                                    PENDAPATAN, BELANJA DAN PEMBIAYAAN PEMBIAYAAN TAHUN ANGARAN
                                    {{ Tahun() ?? 'DEMO' }} <br>
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
                                <td class="text-center" style="width: 3px">No</td>
                                <td class="text-center" colspan="6">Uraian</td>
                                <td class="text-center" colspan="5">Jumlah (Rp)</td>

                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center" colspan="6">2</td>
                                <td class="text-center" colspan="5">3</td>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($gbrincirba as $gr => $rincirba)
                                <tr>
                                    <td><strong>{{ $loop->iteration }}</strong></td>
                                    <td colspan="6"><strong style="color: black"> {{ $gr }} </strong></td>
                                    <td colspan="5" style="text-align: right"> <strong style="color: black">
                                            {{-- {{ number_format($rincirba['total'], 2, ",", ".") }} </strong> --}}
                                        {{ number_format($rincirba['total']->To_Rp, 2, ",", ".") }} </strong>
                                    </td>
                                </tr>
                                @foreach ($rincirba['rincian'] as $rinc1 => $rinci1rba)
                                    <tr>
                                        <td>&nbsp;{{ $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                        <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;{{ $rinc1 }}</td>
                                        <td colspan="5" style="text-align: right">
                                            {{ number_format($rinci1rba['subtotal'], 2, ",", ".") }}
                                        </td>
                                    </tr>
                                    @foreach ($rinci1rba['subrincian'] as $rinc2 => $rinci2rba)
                                        <tr>
                                            <td>&nbsp;&nbsp;{{ $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                            <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc2 }}</td>
                                            <td colspan="5" style="text-align: right">
                                                {{ number_format($rinci2rba['subsubtotal'], 2, ",", ".")}}
                                            </td>
                                        </tr>
                                        @foreach ($rinci2rba['subsubrincian'] as $rinc3 => $rinci3rba)
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;{{ $loop->parent->parent->parent->iteration . '.' .$loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                                <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc3 }}</td>
                                                <td colspan="5" style="text-align: right">
                                                    {{ number_format($rinci3rba[0]->To_Rp, 2, ",", ".") }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table><br>
                    <table class="table table-borderless" cellspacing="0">
                        <td> 
                            <strong>
                                {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                                <br>
                                Direktur {{ nm_unit() ?? 'DEMO ONLY' }}
                                <br><br><br>
                                <br><br>
                                {{ $footer[0]->Nm_Pimp ?? 'NIP 123456789' }}
                                <br>
                                {{ $footer[0]->NIP_Pimp ?? 'DEMO' }}
                            </strong> 
                        </td>
                    </table>
                </div>
            </div>
        </div>
</body>

</html>
