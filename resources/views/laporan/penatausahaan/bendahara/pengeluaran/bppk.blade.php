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
                                    class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Register SPP-SPM
                                </a>
                                <a href="{{ route('bku.show') }}" type="button" class="btn btn-sm btn-primary mb-2 ">
                                    <i class="fas fa-print"></i>
                                    Buku Kas Umum
                                </a>
                                <a href="{{ route('pengeluaran_bpb') }}" type="button"
                                    class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Bank
                                </a>
                                <a href="{{ route('pengeluaran_bpk') }}" type="button"
                                    class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Kas
                                </a>
                                <a href="{{ route('pengeluaran_bppk') }}" type="button"
                                    class="btn btn-sm btn-primary mb-2 disabled">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Pajak
                                </a>
                                <a href="{{ route('pengeluaran_bppj') }}" type="button"
                                    class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Buku Pembantu Pajar
                                </a>
                                <a href="{{ route('pengeluaran_lpj') }}" type="button"
                                    class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Lap. Pertanggungjawaban
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
                                            BUKU PEMBANTU PAJAK <br>
                                            Periode : ............
                                        </td>
                                    </tr>
                                    <thead>
                            </table>
                            <table class="table table-bordered table-striped" style="width: 100%">
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
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table><br><br>
                            <table style="width: 100%">
                                <tbody>
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
