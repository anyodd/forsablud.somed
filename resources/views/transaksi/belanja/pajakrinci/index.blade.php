@extends('layouts.template')
@section('title', 'Setor Pajak')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5> </h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div>
                <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal"
                    data-backdrop="static" data-target="#modal-create"><i class="fas fa-plus-circle"></i> Penyetoran Pajak</button>
                <a href="{{ route('pajak.index') }}" class="btn btn-sm btn-success float-right">
                    <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h5 class="card-title">Data @yield('title') atas  Kode Rek.{{ $tb_pajak->Ko_Rkk ?? 'BLUD ' }} Nilai pajak :{{ number_format($tb_pajak->tax_Rp,2,',','.') ?? '0 ' }}</h5>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3%;">No</th>
                                        <th class="text-center">Setor Pajak</th>
                                        <th class="text-center">No. NTPN</th>
                                        <th class="text-center">Kode Bank</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                @if (count($pajakdetail ?? '') > 0)
                                    <tbody>
                                        @foreach ($pajakdetail as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}.</td>
                                                <td style="text-align: right">{{ number_format($item->taxtor_Rp,2,',','.') }}</td>
                                                <td class="text-center">{{ $item->No_ntpn }}</td>
                                                <td class="text-center">{{ $item->Ko_Bank }}</td>
                                                <td class="text-center">
                                                    <button data-toggle="modal" data-target="#modal_edit{{ $item->id_taxtor }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                    <button data-toggle="modal" data-target="#modal{{ $item->id_taxtor }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal{{ $item->id_taxtor }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Konfirmasi :</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Yakin Mau Hapus Data Rincian
                                                                Akun</p>
                                                            <p class="text-center"><b>{{ $item->Ko_Rkk }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('pajakrinci.destroy', ['pajakrinci' => $item->id_taxtor]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger mr-3"
                                                                    name="submit" title="Hapus">Ya, Hapus
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Kembali</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('transaksi.belanja.pajakrinci.edit')
                                        @endforeach
                                    </tbody>
                                @endif

                                <tfoot>

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
        @include('transaksi.belanja.pajakrinci.create')


        @if (count($pajakdetail ?? '') > 0)
        @endif

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
                "lengthChange": true,
                "autoWidth": false,
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


            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
            $('#example4').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                //   "responsive": true,
            });

            // $(document).on('click','#edit',function() {
            //     var id = $(this).data('id');
            //     // var id = if ($(this).data('id') === void 0 || $(this).data('id') === null) { $(this).data('id') };
            //     //  console.log("Variable is either null or undefined");
            //     var ko_periode = $(this).data('periode');
            //     // var ko_periode = if ($(this).data('periode') === void 0 || $(this).data('periode') === null) {""} else { $(this).data('periode') };
            //     var unit = $(this).data('unit');
            //     // var unit = if ($(this).data('unit') === void 0 || $(this).data('unit') === null) {""} else { $(this).data('unit') };
            //     var kojr = $(this).data('kojr');
            //     // var kojr = if ($(this).data('kojr') === void 0 || $(this).data('kojr') === null) {""} else { $(this).data('kojr') };

            //     var sesuaino = $(this).data('sesuaino');
            //     // var sesuaino = if ($(this).data('sesuaino') === void 0 || $(this).data('sesuaino') === null) {""} else { $(this).data('sesuaino') };

            //     var sesuaiur = $(this).data('sesuaiur');
            //     // var sesuaiur = if ($(this).data('sesuaiur') === void 0 || $(this).data('sesuaiur') === null) {""} else { $(this).data('sesuaiur') };

            //     $('#id').val(id);
            //     $('#Ko_Periodedit').val(ko_periode);
            //     $('#Ko_unitstredit').val(unit);
            //     $('#Ko_jredit').val(kojr);
            //     $('#Sesuai_Noedit').val(sesuaino);
            //     $('#Sesuai_Uredit').val(sesuaiur);
            //     $('#modal_spirc').hide();

            // });

            $(document).on('click', '#pilih', function() {
                var kd_byr = $(this).data('no_byr');
                $('#No_byr').val(kd_byr);
                $('#modal_stsbayar').hide();
            });

        })

        // DropzoneJS Demo Code End
    </script>
@endsection
