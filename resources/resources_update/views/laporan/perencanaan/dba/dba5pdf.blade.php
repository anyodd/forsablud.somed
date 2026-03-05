<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>DBA-Rincian</title>
    @endsection
    @include('laporan.perencanaan.dba.pdf_head')
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
                                    RINCIAN DOKUMEN BISNIS DAN ANGGARAN
                                    <br>
                                    PENDAPATAN, BELANJA DAN PEMBIAYAAN TAHUN ANGARAN
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
                                <td class="text-center" colspan="5">Jumlah</td>

                            </tr>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center" style="width: 3px">2</td>
                                <td class="text-center" colspan="5">3</td>
                                <td class="text-center" colspan="5">4</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gbrincirba as $gr => $rincirba)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}.</td>
                                    <td colspan="6"><strong> {{ $gr }} </strong>
                                    </td>
                                    <td colspan="5" style="text-align: right"> <strong>
                                            {{ number_format($rincirba['subtotal']->To_Rp,2,',','.') }} </strong> </td>
                                </tr>
                                @foreach ($rincirba['subrincian'] as $key => $item)
                                    <tr>
                                        <td style="text-align: left"></td>
                                        <td style="text-align: center">{{ $item[0]->Ko_Rc }}</td>
                                        <td colspan="5" style="text-align: left">{{ $item[0]->Ur_Rc1 }}</td>
                                        <td colspan="5" style="text-align: right">
                                            {{ number_format($item[0]->To_Rp,2,',','.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table><br>
                    <table class="table table-borderless" cellspacing="0">
                        <tbody>
                            <td style="text-align: center"> 
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>

</html>
