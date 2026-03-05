@extends('layouts.template')
@section('title', 'Bendahara Pengeluaran')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

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
                                <a href="{{ route('pengeluaran_rss') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Register SPP-SPM
                                </a>
                                <a href="{{ route('bku.show') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2 disabled">
                                    <i class="fas fa-print"></i>
                                    Buku Kas Umum
                                </a>
                                <a href="{{ route('pengeluaran_bpb') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Bank
                                </a>
                                <a href="{{ route('pengeluaran_bpk') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Kas
                                </a>
                                <a href="{{ route('pengeluaran_bppk') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Pajak
                                </a>
                                <a href="{{ route('pengeluaran_bppj') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Pajar
                                </a>
                                <a href="{{ route('pengeluaran_lpj') }}" type="button"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Lap. Pertanggungjawaban
                                </a>
                                <a href="" class="btn btn-sm btn-outline-success float-right">
                                    <i class="far fa-arrow-alt-circle-left"> Back</i>
                                </a>
                                {{-- <button type="submit" class="btn btn-default float-right"><i class="fa fa-angle-double-left"></i>Back</button> --}}
                                <a href="{{ route('bku.pdf') }}" rel="noopener" target="_blank" type="button"
                                    class="btn btn-sm  btn-outline-warning mr-2 mb-2 float-right">
                                    <i class="fas fa-print"></i>
                                    {{-- <img src="{{ asset('template') }}/dist/img/icon_menu/laporan/laporan.png" alt="Product 1"class="nav-icon img-circle img-size-32 mr-1"> --}}
                                    Print
                                </a>
                            </div>
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center text-bold" colspan="12">
                                            PEMERINTAH {{ nm_pemda() }} <br>
                                            {{ nm_unit() }}
                                            <br>
                                            TAHUN ANGARAN {{ Tahun() }} <br><br><br>
                                            BUKU KAS UMUM <br>
                                        </td>
                                    </tr>
                                    <thead>
                            </table>
                            {{-- <table class="table table-bordered table-striped" style="width: 100%"> --}}
                            <table id="example1" class="table table-bordered table-striped" style="width: 100">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3px">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">No.Bukti</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Penerimaan</th>
                                        <th class="text-center">Pengeluaran</th>
                                        <th class="text-center">Saldo</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $total = 0;
                                    @endphp
                                    @foreach ($bku as $item)
                                        <tr>

                                            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                                            <td>{{ $item->dt_oto }}</td>
                                            <td>{{ $item->No_oto }}</td>
                                            <td>{{ $item->ur_oto }}</td>
                                            <td style="text-align: right">{{ number_format($item->Terima) }}</td>
                                            <td style="text-align: right">{{ number_format($item->Keluar) }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($total += $item->Terima - $item->Keluar) }}
                                            </td>
                                            {{-- <td>{{ $total }}</td> --}}

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><br>
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="8">Saldo Kas di Bendahara Pengeluaran/Bendahara Pengeluaran
                                            Pembantu
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 3%"></td>
                                        <td colspan="7">
                                            Rp. {{ number_format($net) }}<br>
                                            (Terbilang: {{ terbilang(number_format($net, 0, '', '')) . ' rupiah' }})<br>
                                            terdiri dari : <br>
                                            a. Tunai : Rp. ...........<br>
                                            b. Bank : Rp. ...........<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            <strong>Disetujui oleh,<br>
                                                Pengguna Anggara/Kuasa<br>
                                                Pengguna Anggaran
                                                <br><br><br>
                                                Nama<br>
                                                NIP. ............
                                                <br><br><br></strong>
                                        </td>
                                        <td colspan="4" style="text-align: center">
                                            <strong>Disiapkan oleh,<br>
                                                Bendahara Pengeluaran/<br>
                                                Bendahara Pengeluaran
                                                <br><br><br>
                                                Nama<br>
                                                NIP. ............
                                                <br><br><br></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
