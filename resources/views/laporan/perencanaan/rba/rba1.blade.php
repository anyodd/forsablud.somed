@extends('layouts.template')
@section('title', 'RBA Pendapatan')

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
                                <a href="{{ route('rba.pdf') }}" type="button" class="btn btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pendapatan
                                </a>
                                <a href="{{ route('rba2.pdf') }}" type="button" class="btn  btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Belanja
                                </a>
                                <a href="{{ route('rba2rinci') }}" type="button" class="btn  btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Belanja Rinci
                                </a>
                                <a href="{{ route('rba3.pdf') }}" type="button" class="btn  btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pembiayaan
                                </a>
                                <a href="{{ route('rba4.pdf') }}" type="button" class="btn  btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Ringkasan RBA
                                </a>
                                <a href="{{ route('rba5.pdf') }}" type="button" class="btn  btn-outline-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Rincian RBA
                                </a>

                                <a href="" class="btn btn-outline-success float-right">
                                    <i class="far fa-arrow-alt-circle-left"> Back</i>
                                </a>
                                <a href="{{ route('rbapendapatanPDF') }}" rel="noopener" target="_blank" type="button"
                                    class="btn  btn-outline-warning mr-2 mb-2 float-right">
                                    <i class="fas fa-print"></i>
                                    Print
                                </a>
                            </div>
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center" colspan="12">
                                            PEMERINTAH {{ nm_pemda() }} <br>
                                            {{ nm_unit() }}
                                            <br>
                                            RENCANA BISNIS DAN ANGGARAN
                                            <br>
                                            ANGGARAN PENDAPATAN TAHUN ANGARAN {{ Tahun() }} <br>
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
                                    @foreach ($gburpdp as $gr => $urpdp)
                                        <tr>
                                            <td style="text-align: left">{{ $loop->iteration }}.</td>
                                            <td colspan="6"><strong style="color: black"> {{ $gr }} -
                                                    {{ $urpdp['jns'] }} </strong>
                                            </td>
                                            <td colspan="5" style="text-align: right"> <strong style="color: black">
                                                    {{ number_format($urpdp['subtotal'], 2, ',', '.') }} </strong> </td>
                                        </tr>
                                        @foreach ($urpdp['rincian'] as $item)
                                            <tr>
                                                <td style="text-align: left"></td>
                                                <td colspan="2" style="text-align: left">({{ $loop->iteration }} ).</td>
                                                <td>{{ $item->Ko_Rkk }}</td>
                                                <td colspan="3" style="text-align: left">{{ $item->Ur_Rk6 }}</td>
                                                <td colspan="5" style="text-align: right">
                                                    {{ number_format($item->To_Rp, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td style="text-align: left"></td>
                                        <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                                        <td colspan="5" style="text-align: right"> <strong
                                                style="color: blue">{{ number_format($total, 2, ',', '.') }} </strong> </td>
                                    </tr>
                                </tbody>
                                {{-- alternatif 3 --}}
                                <tfoot>
                                    <td style="text-align: left"></td>
                                    <td colspan="6"> <strong style="color: blue"> </strong></td>
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
