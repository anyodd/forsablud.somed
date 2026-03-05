@extends('layouts.template')
@section('title', 'Rincian RBA')

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
                                <a href="{{ route('rba.pdf') }}" type="button" class="btn btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pendapatan
                                </a>
                                <a href="{{ route('rba2.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Belanja
                                </a>
                                <a href="{{ route('rba2rinci') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Belanja Rinci
                                </a>
                                <a href="{{ route('rba3.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Pembiayaan
                                </a>
                                <a href="{{ route('rba4.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Ringkasan RBA
                                </a>
                                <a href="{{ route('rba5.pdf') }}" type="button" class="btn  btn-primary mb-2">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1">
                                    Rincian RBA
                                </a>

                                <a href="" class="btn btn-success float-right">
                                    <i class="far fa-arrow-alt-circle-left"> Back</i>
                                </a>
                                {{-- <button type="submit" class="btn btn-default float-right"><i class="fa fa-angle-double-left"></i>Back</button> --}}
                                <a href="{{ route('rbarinciPDF') }}" rel="noopener" target="_blank" type="button"
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
                                            RINCIAN RENCANA BISNIS DAN ANGGARAN
                                            <br>
                                            PENDAPATAN, BELANJA DAN PEMBIAYAAN PEMBIAYAAN TAHUN ANGARAN
                                            {{ Tahun() ?? 'DEMO' }} <br>
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
                                            <td style="text-align: left"><strong>{{ $loop->iteration }}</strong></td>
                                            <td colspan="6"><strong style="color: black"> {{ $gr }} </strong></td>
                                            <td colspan="5" style="text-align: right"> <strong style="color: black">
                                                    {{-- {{ number_format($rincirba['total'], 2, ",", ".") }} </strong> --}}
                                                    {{ number_format($rincirba['total']->To_Rp, 2, ",", ".") }} </strong>
                                            </td>
                                        </tr>
                                        @foreach ($rincirba['rincian'] as $rinc1 => $rinci1rba)
                                            <tr>
                                                <td style="text-align: left">{{ $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                                <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;{{ $rinc1 }}</td>
                                                <td colspan="5" style="text-align: right">
                                                    {{ number_format($rinci1rba['subtotal'], 2, ",", ".") }}
                                                </td>
                                            </tr>
                                            @foreach ($rinci1rba['subrincian'] as $rinc2 => $rinci2rba)
                                                <tr>
                                                    <td style="text-align: left">{{ $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                                    <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc2 }}</td>
                                                    <td colspan="5" style="text-align: right">
                                                        {{ number_format($rinci2rba['subsubtotal'], 2, ",", ".")}}
                                                    </td>
                                                </tr>
                                                @foreach ($rinci2rba['subsubrincian'] as $rinc3 => $rinci3rba)
                                                    <tr>
                                                        <td style="text-align: left">{{ $loop->parent->parent->parent->iteration . '.' .$loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                                        <td colspan="6" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc3 }}</td>
                                                        <td colspan="5" style="text-align: right">
                                                            {{ number_format($rinci3rba[0]->To_Rp, 2, ",", ".") }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    {{-- <tr>
                                    <td style="text-align: left" ></td>
                                    <td colspan="6"> <strong style="color: blue"> Jumlah </strong></td>
                                     <td colspan="5" style="text-align: right" > <strong style="color: blue">{{number_format($total, 2, ",", ".")}} </strong> </td>
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
        {{-- @include('transaksi.titipanrinci.create') --}}
        {{-- @include('transaksi.titipanrinci.popup_kegiatan') --}}

        {{-- @if (count($tbbprc ?? '') > 0) --}}
        {{-- @include('pembukuan.penyesuaian.edit') --}}
        {{-- @endif --}}
        {{-- @include'sesuai.destroybukuan.sesuai.popu'sesuai.destroyening') --}}

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
