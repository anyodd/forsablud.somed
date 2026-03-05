@extends('layouts.template')
@section('title', ' RBA Belanja')

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
                                <a href="" class="btn btn-success float-right">
                                    <i class="far fa-arrow-alt-circle-left"> Back</i>
                                </a>
                                <a href="{{ route('rba2rinciPDF') }}" target="_blank" rel="noopener" type="button"
                                    class="btn  btn-warning mr-2 mb-2 float-right">
                                    <i class="fas fa-print"></i>
                                    Print
                                </a>
                            </div>
                            <table class="table table-sm table-bordered" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td class="text-center" colspan="12">
                                            PEMERINTAH {{ nm_pemda() }} <br>
                                            {{ nm_unit() }}
                                            <br>
                                            RENCANA BISNIS DAN ANGGARAN
                                            <br>
                                            ANGGARAN BELANJA RINCI TAHUN ANGARAN {{ Tahun() }} <br>
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
                                                        {{-- <td style="text-align: left">&nbsp;&nbsp;&nbsp;{{ $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td> --}}
                                                        <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinci3rba['ko_rkk'] }}</td>
                                                        <td style="text-align: left" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rinc3 }}</td>
                                                        <td style="text-align: right">
                                                            {{ number_format($rinci3rba['subtotal3'], 2, ",", ".")}}
                                                        </td>
                                                    </tr>
                                                    @foreach ($rinci3rba['subrincian3'] as $rinc4 => $rinci4rba)
                                                        <tr>
                                                            <td></td>
                                                            {{-- <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $loop->parent->parent->parent->iteration . '.' .$loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td> --}}
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
                                <tfoot>
                                    <td style="text-align: left" colspan="6"></td>
                                    <td style="text-align: center" colspan="3">
                                        <strong>
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

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
