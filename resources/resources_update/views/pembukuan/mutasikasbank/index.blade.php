@extends('layouts.template')
@section('title', 'Mutasi Kas Bank')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info mt-2">
                        <div class="card-header">
                            <h3 class="card-title"> Data: @yield('title')</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn  btn-primary mb-2" data-toggle="modal" data-backdrop="static"
                                data-target="#modal-create">Tambah</button>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Bank Awal</th>
                                        <th>Bank Tujuan</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mutabank as $item)
                                        <tr>
                                            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                                            <td>{{ $item->Ko_Bank1 }}</td>
                                            <td>{{ $item->Ko_Bank2 }}</td>
                                            <td class="text-right">{{ number_format($item->muta_Rp, 2, ",", ".") }}</td>
                                            <td>
                                                <button class="btn btn-warning py-0" title="Edit data" id="edit"
                                                    data-toggle="modal" data-target="#modal-edit"
                                                    data-id="{{ $item->id }}" data-unit="{{ $item->Ko_unitstr }}"
                                                    data-periode="{{ $item->Ko_Period }}"
                                                    data-bank1="{{ $item->Ko_Bank1 }}"
                                                    data-bank2="{{ $item->Ko_Bank2 }}" data-mut="{{ $item->muta_Rp }}"
                                                    data-tag="{{ $item->Tag }}" data-dismiss="modal"><i
                                                        style='font-size:8px' class="fa fa-edit"> </i>
                                                </button>
                                                <form
                                                    action="{{ route('mutasikasbank.destroy', ['mutasikasbank' => $item->id]) }}"
                                                    method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus {{ $item->muta_Rp }} ?')">
                                                    @method("delete")
                                                    @csrf
                                                    <button title="Hapus data" type="submit" data-name=""
                                                        data-table="mutabankawal" class="btn btn-danger py-0"><i
                                                            class="fa fa-trash" style='font-size:8px'></i></button>
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
        @include('pembukuan.mutasikasbank.create')
        @if (count($mutabank ?? '') > 0)
            @include('pembukuan.mutasikasbank.edit')
        @endif
        {{-- @include('pembukuan.mutabankawal.popup_rekening') --}}

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

            $(document).on('click', '#edit', function() {
                var id = $(this).data('id');
                var periode = $(this).data('periode');
                var unit = $(this).data('unit');
                var bank1 = $(this).data('bank1');
                var bank2 = $(this).data('bank2');
                var nilaimut = $(this).data('mut');
                var tag = $(this).data('tag');
                $('#id').val(id);
                $('#Periodedit').val(periode);
                $('#Ko_unitstredit').val(unit);
                $('#Ko_Bank1edit').val(bank1);
                $('#Ko_Bank2edit').val(bank2);
                $('#muta_Rpedit').val(nilaimut);
                $('#Tagedit').val(tag);
                $('#modal-edit').hide();
                // window.location.reload();
            });

            $('#modal-edit').on('hidden.bs.modal', function() {
                location.reload();
            });

            // $(document).on('hidden', '#modal-edit', function() {
            //     window.location.reload();
            // });

        })

        // DropzoneJS Demo Code End
    </script>
@endsection
