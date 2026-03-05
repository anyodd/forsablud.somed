<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>DBA-Pembiayaan</title>
    @endsection
    @include('laporan.perencanaan.dba.pdf_head')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped" style="width: 100%">
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
                                    PEMERINTAH {{ nm_pemda() }} <br>
                                    {{ nm_unit() }}
                                    <br>
                                    DOKUMEN BISNIS DAN ANGGARAN
                                    <br>
                                    ANGGARAN PEMBIAYAAN TAHUN ANGARAN {{ Tahun() }} <br>
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
                                <td class="text-center" style="width: 3px">1</td>
                                <td class="text-center" style="width: 3px">2</td>
                                <td class="text-center" colspan="5">3</td>
                                <td class="text-center" colspan="5">4</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($gburpb as $gr => $urpdp)
                                <tr>
                                    <td style="text-align: left">{{ $loop->iteration }}.</td>
                                    <td colspan="6"><strong style="color: black"> {{ $gr }} </strong>
                                    </td>
                                    <td colspan="5" style="text-align: right"> <strong style="color: black">
                                            {{ number_format($urpdp['subtotal'],2,',','.') }} </strong> </td>
                                </tr>
                                @foreach ($urpdp['rincian'] as $item)
                                    <tr>
                                        <td style="text-align: left"></td>
                                        <td>{{ $item->Ko_Pdp }}</td>
                                        {{-- <td colspan="4"></td> --}}
                                        <td colspan="5" style="text-align: left">{{ $item->Ur_pdp }}</td>
                                        <td colspan="5" style="text-align: right">
                                            {{ number_format($item->sumtotal,2,',','.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td style="text-align: left"></td>
                                <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                                <td colspan="5" style="text-align: right"> <strong>{{ number_format($total,2,',','.') }} </strong> </td>
                            </tr>
                        </tbody>
                        {{-- alternatif 3 --}}
                        <tfoot>
                            <td style="text-align: left"></td>
                            <td colspan="6"> <strong> </strong></td>
                            <td colspan="5" style="text-align: center"> <strong>
                                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                                    <br>
                                    Direktur {{ nm_unit() }}
                                    <br><br><br>
                                    ttd
                                    <br><br>
                                    {{ $footer[0]->Nm_Pimp }}
                                    <br>
                                    {{ $footer[0]->NIP_Pimp }}
                                </strong> 
                            </td>
                        </tfoot>
                    </table><br>
                    <table class="table table-borderless" cellspacing="0">
                        <tbody>
                            <td style="text-align: center"> <strong>
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
