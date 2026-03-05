@extends('layouts.template')
@section('title', 'Realisasi Pendapatan dan Belanja')

@section('content')
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
                                <form action="{{ route('reg.piutang.show.cetak') }}">
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
                    @include('laporan.pembukuan.lapman.lapman_head')
                        <form action="">
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <select name="saldo" class="form-control">
                                        <option value="" selected>-- Pilih Jenis Saldo Awal --</option>
                                        <option value="NERACA">Neraca</option>
                                        <option value="LRA">LRA</option>
                                        <option value="LO">LO</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="period" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary col"><i class="fa fa-search"></i> Filter</button>
                                </div>
                            </div>
                        </form>
                        <a href="" id="scroll" style="display: none;"><span></span></a>
                        <table class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <td class="text-center text-bold" colspan="12">
                                        {{$judul}} <br>
                                        TAHUN ANGARAN {{ Tahun() }} <br>
                                         <br>
                                    </td>
                                </tr>
                                <thead>
                        </table>
                        <div id="result-table" class="container" style="width: 100%"></div>
                        <table class="table table-sm table-bordered table-striped" id="table-header" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt">Kode Rekening</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt">Uraian</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt">{{Tahun()}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{$item->Ko_rkk5}}</td>
                                        <td>{{$item->Ur_Rk5}}</td>
                                        <td class="text-right">{{number_format($item->Jumlah,2,',','.')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><br><br>
                        <table style="width: 100%">
                            <tbody>
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
                                        Bendahara Penerimaan/<br>
                                        Bendahara Penerimaan Pembantu
                                        <br><br><br>
                                        Nama<br>
                                        NIP. ............
                                        <br><br><br></strong>
                                </td>
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
                    // url: "{{ route('reg.piutang.show.isi') }}",
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
        })

        // DropzoneJS Demo Code End
</script>
@endsection