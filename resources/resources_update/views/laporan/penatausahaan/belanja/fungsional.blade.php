@extends('layouts.template')
@section('title', 'Laporan Pertanggungjawaban Bendahara Pengeluaran')

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
                                <form action="{{route('fungsionalpengeluaran_cetak')}}" method="post" target="_blank">
                                    @csrf
                                    @method('POST')
                                    <input type="text" name="bulan" id="bln" hidden>
                                    <button type="submit" id="cetak" class="btn btn-sm btn-secondary">
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
                                        LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN <br>
                                        (SPJ BELANJA - FUNGSIONAL) <br>
                                        TAHUN ANGARAN {{ Tahun() }} <br>
                                        Periode <br>
                                        <select style='text-align: center' name="bulan" id="bulan">
                                            <option value="">-- Pilih Bulan --</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <div id="result-table" style="width: 100%"></div>
                        <table class="table table-bordered table-striped" id="table-header" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3px; vertical-align: middle; font-size: 10pt" rowspan="2">Kode Rekening</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Uraian</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Jumlah Anggaran</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">SPJ s.d Lalu</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" colspan ="2">SPJ Ini</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan ="2">S.D SPJ Ini</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt" rowspan="2">Sisa Pagu Anggaran</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt">LS</th>
                                    <th class="text-center" style="vertical-align: middle; font-size: 10pt">TU/GU Nihil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" id='baris-kosong' colspan=11>Silahkan Pilih Periode
                                        Pelaporan
                                    </td>
                                    <td class="text-center" id='baris-loader' colspan=11>
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table><br><br>
                        {{-- <table style="width: 100%">
                            <tbody>
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
                                        {{$pegawai[0]->Nm_Bend}}<br>
                                        NIP. {{$pegawai[0]->NIP_Bend}}
                                        <br><br><br></strong>
                                </td>
                            </tbody>
                        </table> --}}
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
            // pilihan()
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

            $('#bulan').change(function () { 
                bulan = document.getElementById('bulan').value;
                $.ajax({
                    type: "post",
                    url: "{{ route('fungsionalpengeluaran_isi') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "bulan": bulan
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

            $('#cetak').click(function () { 
                bulan = document.getElementById('bulan').value;
                document.getElementById('bln').value = bulan;
            });
        })

        // DropzoneJS Demo Code End
</script>
@endsection