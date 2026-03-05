@extends('layouts.template')
@section('title', 'Bendahara Penerimaan')

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
                                    <div class="btn btn-sm btn-secondary">
                                        <i class="fas fa-file-pdf bg-red"></i> Cetak
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('laporan.penatausahaan.bendahara.penerimaan.select_laporan')
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center text-bold" colspan="12">
                                            PEMERINTAH {{ nm_pemda() }} <br>
                                            {{ nm_unit() }}
                                            <br>
                                            LAPORAN PERTANGGUNGJAWABAN<br>
                                            BENDAHARA PENERIMAAN/BENDAHARA PENERIMAAN PEMBANTU<br>
                                        </td>
                                    </tr>
                                <thead>
                            </table>
                            <table class="table table-bordered table-striped" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td style="width: 3%">SKPD</td>
                                        <td style="width: 3%">:</td>
                                        <td></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>PERIODE</td>
                                        <td>:</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>A.</td>
                                        <td colspan="3">Penerimaan</td>
                                        <td style="width: 15%">Rp. {{number_format($data[0]->Terima+$data[1]->Terima, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2" style="width: 50%">1. Tunai melalui bendahara penerimaan</td>
                                        <td class="text-right" style="width: 15%">Rp. {{number_format($data[0]->Terima, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">2. Tunai melalui bendahara penerimaan pembantu</td>
                                        <td class="text-right">Rp. -</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">3. Melalui ke rekening bendahara penerimaan</td>
                                        <td class="text-right">Rp. {{number_format($data[1]->Terima, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">4. Melalui ke rekening kas umum daerah</td>
                                        <td class="text-right">Rp. -</td>
                                    </tr>
                                    <tr>
                                        <td>B.</td>
                                        <td colspan="3">Jumlah penerimaan yang harus disetorkan(A1+A2+A3)</td>
                                        <td>Rp. {{number_format($data[0]->Terima+$data[1]->Terima, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td>C.</td>
                                        <td colspan="3">Jumlah penyetoran</td>
                                        <td>Rp. {{number_format($data[2]->Keluar, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td>D.</td>
                                        <td colspan="3">Saldo Kas di Bendahara</td>
                                        <td>Rp. {{number_format($data[0]->Terima + $data[1]->Terima - $data[2]->Keluar, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">1. Bendahara Penerimaan</td>
                                        <td>Rp. {{number_format($data[0]->Terima + $data[1]->Terima - $data[2]->Keluar, 0, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">2. Bendahara Penerimaan Pembantu .....</td>
                                        <td>Rp. ...............</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">3. Bendahara Penerimaan Pembantu .....</td>
                                        <td>Rp. ...............</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">4. dst .....</td>
                                        <td>Rp. ...............</td>
                                    </tr>
                                </tbody>
                            </table><br><br>
                            <table style="width: 100%">
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
                                            Bendahara Penerimaan
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

        })

        // DropzoneJS Demo Code End
    </script>
@endsection
