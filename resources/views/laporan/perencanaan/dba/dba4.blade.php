@extends('layouts.template')
@section('title', 'Ringkasan DBA')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            @yield('title')
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div>
                                <a href="{{ route('dba.pdf') }}" type="button" class="btn btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pendapatan
                                </a>
                                <a href="{{ route('dba2.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Belanja
                                </a>
                                <a href="{{ route('dba3.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pembiayaan
                                </a>
                                <a href="{{ route('dba4.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Ringkasan DBA
                                </a>
                                <a href="{{ route('dba5.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Rincian DBA
                                </a>

                                <a href="" class="btn btn-success float-right">
                                    <i class="far fa-arrow-alt-circle-left"> Back</i>
                                </a>
                                {{-- <button type="submit" class="btn btn-default float-right"><i class="fa fa-angle-double-left"></i>Back</button> --}}
                                <a href="{{ route('dbaringkasPDF') }}" rel="noopener" target="_blank" type="button"
                                    class="btn  btn-warning mr-2 mb-2 float-right">
                                    <i class="fas fa-print"></i>
                                    {{-- <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png" alt="Product 1"class="nav-icon img-circle img-size-32 mr-1"> --}}
                                    Print
                                </a>
                                {{-- <a href="/pegawai/cetak_pdf" class="btn btn-primary" target="_blank">CETAK PDF</a> --}}
                            </div>
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center" colspan="12">
                                            PEMERINTAH {{ nm_pemda() ?? 'DEMO' }} <br>
                                            {{ nm_unit() ?? 'DEMO' }}
                                            <br>
                                            RINGKASAN DOKUMEN BISNIS DAN ANGGARAN
                                            <br>
                                            PENDAPATAN, BELANJA DAN PEMBIAYAAN TAHUN ANGARAN
                                            {{ Tahun() ?? 'DEMO' }} <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 3px">No</td>
                                        <td class="text-center" colspan="6">Uraian</td>
                                        <td class="text-center" colspan="5">Jumlah</td>

                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 3px">1</td>
                                        <td class="text-center" style="width: 4px">2</td>
                                        <td class="text-center" colspan="5">3</td>
                                        <td class="text-center" colspan="5">4</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gbringrba as $gr => $urrba)
                                        <tr>
                                            <td style="text-align: left">{{ $loop->iteration }}.</td>
                                            <td colspan="6"><strong style="color: black"> {{ $gr }} </strong>
                                            </td>
                                            <td colspan="5" style="text-align: right"> <strong style="color: black">
                                                    {{ number_format($urrba['subtotal']->To_Rp) }} </strong> </td>
                                        </tr>
                                        @foreach ($urrba['rincian'] as $item)
                                            <tr>
                                                <td style="text-align: left"></td>
                                                <td>{{ $item->Ko_Rk2 }}</td>
                                                {{-- <td colspan="1"></td> --}}
                                                <td colspan="5" style="text-align: left">{{ $item->Ur_Rk3 }}</td>
                                                <td colspan="5" style="text-align: right">
                                                    {{ number_format($item->To_Rp) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    {{-- <tr>
                                    <td style="text-align: left" ></td>
                                    <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                                     <td colspan="5" style="text-align: right" > <strong style="color: blue">{{number_format($total)}} </strong> </td>
                                </tr> --}}
                                </tbody>
                                {{-- alternatif 3 --}}
                                <tfoot>
                                    <td style="text-align: left"></td>
                                    <td colspan="6"> <strong style="color: blue"> </strong></td>
                                    <td colspan="5" style="text-align: center"> <strong>
                                            {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
                                            <br>
                                            Direktur {{ nm_unit() ?? 'DEMO ONLY' }}
                                            <br><br><br>
                                            ttd
                                            <br><br>
                                            {{ $footer[0]->Nm_Pimp ?? 'NIP 123456789' }}
                                            <br>
                                            {{ $footer[0]->NIP_Pimp ?? 'DEMO' }}
                                        </strong> </td>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

        })

        // DropzoneJS Demo Code End
    </script>
@endsection
