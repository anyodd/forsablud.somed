<!DOCTYPE html>
<html>
    @section('titlepdf')
    <title>RBA-Pendapatan</title>
    @endsection
    @include('laporan.perencanaan.rba.pdf_head')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table id="example1" class="table table-sm table-bordered table-striped" style="width: 100%;">
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
                                    RENCANA BISNIS DAN ANGGARAN
                                    <br>
                                    ANGGARAN PENDAPATAN TAHUN ANGARAN {{ Tahun() }} <br>
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
                                <td class="text-center" colspan="3" style="width: 4px">2</td>
                                <td class="text-center" colspan="3">3</td>
                                <td class="text-center" colspan="5">4</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gburpdp as $gr => $urpdp)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}.</td>
                                    <td colspan="6"><strong style="color: black"> {{ $gr }} -
                                            {{ $urpdp['jns'] }} </strong>
                                    </td>
                                    <td colspan="5" style="text-align: right"> <strong style="color: black">
                                            {{ number_format($urpdp['subtotal'], 2, ",", ".") }} </strong> </td>
                                </tr>
                                @foreach ($urpdp['rincian'] as $item)
                                    <tr>
                                        <td style="text-align: left"></td>
                                        <td style="width: 4rem" colspan="2" style="text-align: center">
                                            {{ $loop->iteration }} )</td>
                                        <td>{{ $item->Ko_Rkk }}</td>
                                        <td colspan="3" style="text-align: left">{{ $item->Ur_Rk6 }}</td>
                                        <td colspan="5" style="text-align: right">
                                            {{ number_format($item->To_Rp, 2, ",", ".") }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td style="text-align: left"></td>
                                <td colspan="6"> <strong> Jumlah </strong></td>
                                <td colspan="5" style="text-align: right"> <strong
                                       >{{ number_format($total, 2, ",", ".") }} </strong> </td>
                            </tr>
                        </tbody>
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
                {{-- </div> --}}
            </div>
        </div>
    </div>







</body>

</html>
