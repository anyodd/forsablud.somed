<!DOCTYPE html>
<html>
{{-- @include('laporan.perencanaan.rka.pdf_head') --}}


<head>
    <title>rba1-pendapatan</title>
    <link rel="stylesheet" href="reportpdf/bootstrap.min.css">
    <script src="reportpdf/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped" style="width: 90%">
                        <thead>
                            <tr>
                                <td class="text-center" colspan="12" style="width: auto;">
                                    PEMERINTAH {{ nm_pemda() }} <br>
                                    {{ nm_unit() }}
                                    <br>
                                    RENCANA BISNIS DAN ANGGARAN
                                    <br>
                                    ANGGARAN PENDAPATAN TAHUN ANGARAN {{ Tahun() }} <br>
                                </td>
                            </tr>
                            <tr>
                                <td class=" text-center" style="width: 3px">No</td>
                                <td class="text-center" colspan="6" style="width: 50px;">Uraian</td>
                                <td class="text-center" colspan="5" style="width: 50px">Jumlah</td>

                            </tr>
                            <tr>
                                <td class="text-center" style="width: 3px">1</td>
                                <td class="text-center" style="width: 4px">2</td>
                                <td class="text-center" colspan="5" style="width: 50px">3</td>
                                <td class="text-center" colspan="5" style="width: 50px">4</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gburpdp as $gr => $urpdp)
                                <tr>
                                    <td style="text-align: left">{{ $loop->iteration }}.</td>
                                    <td colspan="6"><strong style="color: black"> {{ $gr }} </strong>
                                    </td>
                                    <td colspan="5" style="text-align: right"> <strong style="color: black">
                                            {{ number_format($urpdp['subtotal']) }} </strong> </td>
                                </tr>
                                @foreach ($urpdp['rincian'] as $item)
                                    <tr>
                                        <td style="text-align: left"></td>
                                        <td>{{ $item->Ko_Rc }}</td>
                                        {{-- <td colspan="4"></td> --}}
                                        <td colspan="5" style="text-align: left">{{ $item->Ur_Rc1 }}</td>
                                        <td colspan="5" style="text-align: right">
                                            {{ number_format($item->To_Rp) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td style="text-align: left"></td>
                                <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                                <td colspan="5" style="text-align: right"> <strong
                                        style="color: blue">{{ number_format($total) }}
                                    </strong> </td>
                            </tr>
                        </tbody>
                        {{-- alternatif 3 --}}
                        <tfoot>
                            <td style="text-align: left"></td>
                            <td colspan="6"> <strong style="color: blue"> </strong></td>
                            <td colspan="5" style="text-align: center"> <strong>
                                    Cianjur,... Februari 2022
                                    <br>
                                    PIMPINAN {{ nm_unit() }}
                                    <br><br><br>
                                    ttd
                                    <br><br>
                                    {{ $footer[0]->Nm_Pimp }}
                                    <br>
                                    {{ $footer[0]->NIP_Pimp }}
                                </strong> </td>
                        </tfoot>
                    </table>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>







</body>

</html>
