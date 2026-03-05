@extends('layouts.template')
@section('title', 'Tagihan')

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
                                    <form action="{{ route('tagihan.pdf.cetak') }}">
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
                            @include('laporan.penatausahaan.belanja.select_laporan')
                            <hr>
                            <a href="" id="scroll" style="display: none;"><span></span></a>
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center text-bold" colspan="12">
                                            DAFTAR TAGIHAN<br>
                                            TAHUN ANGGARAN {{ Tahun() }} <br>
                                            Periode <br>
                                            <input type="text" style='text-align: center' name="daterange" value="" />
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <div id="result-table" class="container" style="width: 100%"></div>
                            <table class="table table-bordered table-striped" id="table-header" style="width: 100; font-size: 14px">
                                <thead>
                                    <tr>
                                        <td rowspan="2" class="text-center" style="width: 2px">No</td>
                                        <td colspan="7" class="text-center">Uraian</td>
                                        <td rowspan="2" class="text-center">Nilai</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Uraian</td>
                                        <td class="text-center">Tanggal Tagihan</td>
                                        <td class="text-center">Tanggal JT</td>
                                        <td class="text-center">Nama Pihak Ketiga</td>
                                        <td class="text-center">Uraian Kegiatan/Belanja</td>
                                        <td class="text-center">Kode Rek</td>
                                        <td class="text-center">Uraian Rek</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 3px">1</td>
                                        <td class="text-center" style="width: 4px">2</td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">6</td>
                                        <td class="text-center">7</td>
                                        <td class="text-center">8</td>
                                        <td class="text-center">9</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" id='baris-kosong' colspan=9>Silahkan Pilih Periode Pelaporan</td>
                                        <td class="text-center" id='baris-loader' colspan=9><div class="lds-ellipsis"><div></div><div></div><div></div></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#baris-loader').hide();
            $('.btn.btn-sm.btn-secondary').hide();
            pilihan();

            $('.select2').select2();

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
        });

        tahun = {{ Tahun() }};
        
        $('input[name="daterange"]').daterangepicker({
            opens: "center",
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: "DD-MM-YYYY"
            },
            startDate: "01/01/" + tahun,
            minDate: "01/01/" + tahun,
            maxDate: "31/12/" + tahun
        });
        
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        
            date1 = picker.startDate.format('YYYY-MM-DD');
            date2 = picker.endDate.format('YYYY-MM-DD');

            $('#awal').val(date1)
            $('#akhir').val(date2)
        
            $.ajax({
                type: "post",
                url: "{{ route('tagihan.pdf.isi') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date1": date1,
                    "date2": date2
                },
                beforeSend: function() {
                    $('#result-table').hide();
                    $('#baris-kosong').hide();
                    $('#table-header').show();
                    $('#baris-loader').show();
                },
                success: function(result) {
                    $('#table-header').hide();
                    $('#baris-loader').hide();
                    $('#result-table').html(result);
                    $('#result-table').show();
                    $('.btn.btn-sm.btn-secondary').show();
                }
            })
        });
        
        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#result-table').hide();
            $('#table-header').show();
            $('#baris-kosong').show();
            $('.btn.btn-sm.btn-secondary').hide();
        });
    </script>
@endsection
