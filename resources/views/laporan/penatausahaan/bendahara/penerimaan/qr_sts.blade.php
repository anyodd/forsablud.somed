@extends('layouts.template')
@section('title', 'Register STS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
                            <div class="row">
                                <div class="col-6 my-auto">
                                    @yield('title')
                                </div>
                                <div class="col-6 text-right">
                                    <form action="{{ route('penerimaan_sts_cetak') }}">
                                        <input type="hidden" id='awal' name="date1">
                                        <input type="hidden" id='akhir' name="date2">
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file-pdf bg-red"></i> Cetak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('laporan.penatausahaan.bendahara.penerimaan.select_laporan')
                            <hr>
                            <a href="" id="scroll" style="display: none;"><span></span></a>
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center text-bold" colspan="12">
                                            SURAT TANDA SETORAN <br>
                                            {{nm_unit()}} <br>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <div id="result-table" style="width: 100%"></div>
                            <table class="table table-bordered table-striped" id="example1" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">No STS</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Bendahara</th>
                                        <th class="text-center">NIP Bendahara</th>
                                        <th class="text-center">Nilai (Rp)</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($sts as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}.</td>
                                                <td>{{ $item->No_sts }}</td>
                                                <td class="text-center">{{ date('d M Y', strtotime($item->dt_sts)) }}</td>                      
                                                <td>{{ $item->Ur_sts }}</td>
                                                <td>{{ $item->Nm_Ben }}</td>
                                                <td>{{ $item->NIP_Ben }}</td>
                                                <td class="text-right">{{ number_format($item->total,2,'','.') }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('qr_sts_cetak')}}" target="_blank">
                                                        <input type="text" name="No_sts" value="{{$item->No_sts}}" hidden>
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Cetak"><i class="fas fa-file-pdf"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
        $(document).ready(function() {
            $('#baris-loader').hide();
            $('.btn.btn-sm.btn-secondary').hide();
            pilihan()
        })

        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
    </script>
@endsection