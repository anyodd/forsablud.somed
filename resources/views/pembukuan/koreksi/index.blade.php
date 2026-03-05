@extends('layouts.template')
@section('title', 'Koreksi')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5> Periode: {{ $tahun }} </h5>
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
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"> Data: @yield('title')</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- <div class=" mb-1">
                            <a href="{{ route('koreksi.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"> Add</i>
                            </a>
                        </div> --}}

                            <button type="button" class="btn  btn-primary mb-2" data-toggle="modal" data-backdrop="static"
                                data-target="#modal-create">Add</button>
                            {{-- <div class="row form-group">
                                     <div class="col-md-2">
                                            <label for="nourut">Kode Rekening</label>
                                    </div>
                                    <div class="col-md-10">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-rekening">Add</button>
                                                </span>
                                            </div>
                                    </div>
                        </div> --}}
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        {{-- <th>Periode</th> --}}
                                        {{-- <th>Unit</th> --}}
                                        <th>Kode Koreksi</th>
                                        <th>No Koreksi</th>
                                        <th>Uraian Koreksi</th>
                                        <th>No Ref SPJ</th>
                                        <th>No Ref SPJ Rinci</th>
                                        <th>Kode Rek</th>
                                        <th>Nilai</th>
                                        <th>Tambah/(Kurang)</th>
                                        {{-- <th>Tag</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                {{-- @if (count($koreksi ?? '') > 0) --}}
                                <tbody>
                                    @foreach ($koreksi as $item)
                                        <tr>
                                            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                                            {{-- <td>{{ $item->Ko_Period }}</td> --}}
                                            {{-- <td>{{ $item->Ko_unitstr }}</td> --}}
                                            <td>{{ $item->Ko_Koreksi }}</td>
                                            <td>{{ $item->Koreksi_No }}</td>
                                            <td>{{ $item->Koreksi_Ur }}</td>
                                            <td>{{ $item->No_spi }}</td>
                                            <td>{{ $item->Ko_spirc }}</td>
                                            <td>{{ $item->Ko_Rkk }}</td>
                                            <td>{{ $item->Korek_Rp }}</td>
                                            <td>{{ $item->Korek_Tag }}</td>
                                            <td>
                                                <a href="{{ route('koreksi.edit', ['koreksi' => $item->id_korek]) }}"
                                                    class="btn btn-warning btn-xs py-0" title="Edit data"> <i
                                                        style='font-size:8px' class="fa fa-edit"> </i> </a>
                                                <button class="btn btn-warning btn-xs py-0" title="Edit data" id="edit"
                                                    data-toggle="modal" data-target="#modal-edit" {{-- data-id= "{{ $item->id_tbses  }}"
                                            data-periode= "{{ $item->Ko_Period }}"
                                            data-unit= "{{ $item->Ko_unitstr }}"
                                            data-kojr= "{{ $item->Ko_jr }}"
                                            data-sesuaino= "{{ $item->Sesuai_No }}"
                                            data-sesuaiur= "{{ $item->Sesuai_Ur }}" --}}><i
                                                        style='font-size:8px' class="fa fa-edit"> </i>
                                                </button>
                                                <form
                                                    action="{{ route('koreksi.destroy', ['koreksi' => $item->id_korek]) }}"
                                                    method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus {{ $item->Koreksi_Ur }} ?')">
                                                    @method("delete")
                                                    @csrf
                                                    <button title="Hapus data" type="submit" data-name=""
                                                        data-table="koreksi" class="btn btn-xs btn-danger py-0"><i
                                                            class="fa fa-trash pr-1" style='font-size:8px'></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- @endif --}}

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
        @include('pembukuan.koreksi.create')
        @include('pembukuan.koreksi.popup_spi')
        @if (count($koreksi ?? '') > 0)
            @include('pembukuan.koreksi.edit')
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
            });

            $(document).on('click', '#pilih', function() {
                var kd_si = $(this).data('kd_spi');
                var kd_src = $(this).data('kd_spirc');
                var nm_r = $(this).data('nm_rek');
                $('#No_spi').val(kd_si);
                $('#Ko_spirc').val(kd_src);
                $('#Ko_Rkk').val(nm_r);
                $('#modal_spirc').hide();
            });

        })

        // DropzoneJS Demo Code End
    </script>
@endsection
