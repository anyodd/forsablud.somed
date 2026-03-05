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
                                <a href="{{ route('rbabelanjaPDF') }}" rel="noopener" target="_blank" type="button"
                                    class="btn  btn-warning mr-2 mb-2 float-right">
                                    <i class="fas fa-print"></i>
                                    {{-- <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png" alt="Product 1"class="nav-icon img-circle img-size-32 mr-1"> --}}
                                    Print
                                </a>
                            </div>
                            <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
                                <thead class="">
                                    <tr>
                                        <td class="text-center" colspan="12">
                                            PEMERINTAH {{ nm_pemda() }} <br>
                                            {{ nm_unit() }}
                                            <br>
                                            RENCANA BISNIS DAN ANGGARAN
                                            <br>
                                            ANGGARAN BELANJA TAHUN ANGARAN {{ Tahun() }} <br>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" rowspan="2" style="vertical-align: middle;">No</td>
                                        <td class="text-center" rowspan="2" style="vertical-align: middle;" colspan="4">
                                            Uraian</td>
                                        <td class="text-center" colspan="4">Pendapatan Layanan</td>
                                        <td class="text-center" rowspan="2">APBD</td>
                                        <td class="text-center" rowspan="2" colspan="2">Jumlah <br>(Rp)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Jasa Layanan</td>
                                        <td class="text-center">Hibah</td>
                                        <td class="text-center">Hasil Kerjasama</td>
                                        <td class="text-center">Lain PBLUDYS</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle;">1</td>
                                        <td class="text-center" style="vertical-align: middle;" colspan="4">2</td>
                                        <td class="text-center" colspan="4">3</td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">5</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $JLTo_Rp = 0;
                                        $HbTo_Rp = 0;
                                        $KSTo_Rp = 0;
                                        $BLTo_Rp = 0;
                                        $APTo_Rp = 0;
                                    @endphp
                                    @foreach ($gburblj as $gr => $urblj)
                                        <tr>
                                            <td style="text-align: left">{{ $loop->iteration }}.</td>
                                            <td class="text-center" style="vertical-align: middle;" colspan="4">
                                                {{ $gr }}</td>
                                            <td class="text-right"><strong>{{ number_format($urblj['JLTo_Rp'], 2, ",", ".") }}</strong></td>
                                            <td class="text-right"><strong>{{ number_format($urblj['HbTo_Rp'], 2, ",", ".") }}</strong></td>
                                            <td class="text-right"><strong>{{ number_format($urblj['KSTo_Rp'], 2, ",", ".") }}</strong></td>
                                            <td class="text-right"><strong>{{ number_format($urblj['BLTo_Rp'], 2, ",", ".") }}</strong></td>
                                            <td class="text-right"><strong>{{ number_format($urblj['APTo_Rp'], 2, ",", ".") }}</strong></td>
                                            <td class="text-right">
                                                <strong>{{ number_format($urblj['subtotal'], 2, ",", ".") }}</strong>
                                            </td>
                                        </tr>

                                        @php
                                            $JLTo_Rp += $urblj['JLTo_Rp'];
                                            $HbTo_Rp += $urblj['HbTo_Rp'];
                                            $KSTo_Rp += $urblj['KSTo_Rp'];
                                            $BLTo_Rp += $urblj['BLTo_Rp'];
                                            $APTo_Rp += $urblj['APTo_Rp'];
                                        @endphp

                                        @foreach ($urblj['subrincian'] as $item)
                                            <tr>
                                                <td style="text-align: left">({{ $loop->iteration }}.)</td>
                                                <td style="text-align: left" colspan="4">{{ $item['Ur_Rk4'] }}</td>
                                                <td class="text-right">{{ number_format($item['JLTo_Rp'], 2, ",", ".") }}</td>
                                                <td class="text-right">{{ number_format($item['HbTo_Rp'], 2, ",", ".") }}</td>
                                                <td class="text-right">{{ number_format($item['KSTo_Rp'], 2, ",", ".") }}</td>
                                                <td class="text-right">{{ number_format($item['BLTo_Rp'], 2, ",", ".") }}</td>
                                                <td class="text-right">{{ number_format($item['APTo_Rp'], 2, ",", ".") }} </td>
                                                <td class="text-right">
                                                    {{ number_format($item['JLTo_Rp'] + $item['HbTo_Rp'] + $item['KSTo_Rp'] + $item['BLTo_Rp'] + $item['APTo_Rp'], 2, ",", ".") }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td class="text-center" colspan="5"><strong>TOTAL</strong></td>
                                        <td class="text-right"><strong>{{ number_format($JLTo_Rp, 2, ",", ".") }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format($HbTo_Rp, 2, ",", ".") }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format($KSTo_Rp, 2, ",", ".") }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format($BLTo_Rp, 2, ",", ".") }}</strong></td>
                                        <td class="text-right"><strong>{{ number_format($APTo_Rp, 2, ",", ".") }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <td style="text-align: left" colspan="10"></td>
                                    {{-- <td colspan="6"> <strong style="color: blue"> </strong></td> --}}
                                    <td style="text-align: center" colspan="2">
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
