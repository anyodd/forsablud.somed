@extends('layouts.template')
@section('title', 'Buku Kas Umum')

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
                                    <form action="{{ route('penerimaan_bku_cetak') }}" target="_blank">
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
                                            BUKU KAS UMUM <br>
                                            TAHUN ANGARAN {{ Tahun() }} <br><br>
                                            Periode <br>
                                            <input type="text" style='text-align: center' name="daterange" value=""/>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <div id="result-table" style="width: 100%"></div>
                            <table class="table table-bordered table-striped" id="table-header" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3px">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">No.Bukti</th>
                                        <th class="text-center">Kode Rekening</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Penerimaan</th>
                                        <th class="text-center">Pengeluaran</th>
                                        <th class="text-center">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" id='baris-kosong' colspan=8>Silahkan Pilih Periode Pelaporan</td>
                                        <td class="text-center" id='baris-loader' colspan=8><div class="lds-ellipsis"><div></div><div></div><div></div></div></td>
                                    </tr>
                                </tbody>
                            </table><br>
                            <table style="width: 100%" id="terbilang">
                                <tbody>
                                    <tr>
                                        <td colspan="8">Saldo Kas di Bendahara Penerimaan/Bendahara Penerimaan Pembantu <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 3%"></td>
                                        <td colspan="7">
                                            Rp. ....................<br>
                                            (Terbilang ....................)<br>
                                            terdiri dari : <br>
                                            a. Tunai     : Rp. ...........<br>
                                            b. Bank      : Rp. ...........<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: center"> 
                                            <strong>Disetujui oleh,<br>
                                                Pengguna Anggara/Kuasa<br>
                                                Pengguna Anggaran
                                                <br><br><br>
                                                {{$pegawai[0]->Nm_Pimp}}<br>
                                                NIP. {{$pegawai[0]->NIP_Pimp}}
                                            <br><br><br></strong> 
                                        </td>
                                        <td colspan="4" style="text-align: center"> 
                                            <strong>Disiapkan oleh,<br>
                                                Bendahara Penerimaan/<br>
                                                Bendahara Penerimaan Pembantu
                                                <br><br><br>
                                                {{-- {{$pegawai[0]->Nm_Bend}}<br>
                                                NIP. {{$pegawai[0]->NIP_Bend}} --}}
                                                @if (!empty($bendahara[0]))
                                                    {{$bendahara[0]->Nm_Bend}}<br>
                                                    NIP. {{$bendahara[0]->NIP_Bend}}
                                                @else
                                                    TTD <br>
                                                    NIP. -
                                                @endif
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
        $(document).ready(function() {
            $('#baris-loader').hide();
            $('.btn.btn-sm.btn-secondary').hide();
            pilihan()
        })

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
                    url: "{{ route('penerimaan_bku_isi') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "date1": date1,
                        "date2": date2
                    },
                    beforeSend: function() {
                        $('#result-table').hide();
                        $('#baris-kosong').hide();
                        $('#terbilang').hide();
                        $('#table-header').show();
                        $('#baris-loader').show();
                    },
                    success: function(result) {
                        $('#table-header').hide();
                        $('#baris-loader').hide();
                        $('#result-table').html(result);
                        $('#result-table').show();
                        $('.btn.btn-sm.btn-secondary').show();
                        $("#example1").DataTable({
                            "responsive": true,
                            "ordering": false,
                            "info": false,
                            "paging": false,
                            "lengthChange": false,
                            "autoWidth": false,
                            "searching": false,
                            "buttons": ["excel"]
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
        });

        // DropzoneJS Demo Code End
    </script>
@endsection
