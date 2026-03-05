@extends('layouts.template')
@section('title', 'Titipan')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- About Me Box -->
                <div class="card card-info mt-2">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold">Data Titipan</h5> 
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-backdrop="static"
                        data-target="#modal-create"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <table id="example1" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No</th>
                                    <th class="text-center">No Titipan</th>
                                    <th class="text-center">Tanggal</th> 
                                    <th class="text-center">Uraian</th>
                                    <th class="text-center">Nama Pihak 3</th>
                                    <th class="text-center">Alamat Pihak 3</th>
                                    <th class="text-center">Nilai (Rp)</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            @if (count($titipan ?? '') > 0)
                            <tbody>
                                @foreach ($titipan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item->No_bp }}</td>
                                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_bp)) }}</td>                      
                                    <td>{{ $item->Ur_bp }}</td>
                                    <td>{{ $item->nm_BUcontr }}</td>
                                    <td>{{ $item->adr_bucontr }}</td>
                                    <td class="text-right">{{ number_format($item->jml,2,',','.') }}</td>
                                    <td class="text-center" style="width: 10%">
                                        <a href="{{ route('titipan.detail', ['titipan' => $item->id_bp]) }}"
                                            class="btn btn-sm btn-info py-0" title="Tambah rincian"> <i
                                            class="fa fa-angle-double-right"></i>
                                        </a>
                                        <button class="btn btn-warning btn-sm py-0" title="Edit data" id="edit"
                                        data-toggle="modal" data-target="#modal-edit{{$item->id_bp}}"><i class="fa fa-edit"> </i>
                                    </button>

                                    <button class="btn btn-sm btn-danger py-0"
                                    data-toggle="modal"
                                    data-target="#modal{{ $item->id_bp }}"><i
                                    class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade" id="modal{{ $item->id_bp }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title"
                                            id="exampleModalLongTitle">
                                        Konfirmasi :</h5>
                                        <button type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Yakin Mau Hapus Data
                                    </p>
                                    <p class="text-center">
                                        <b>{{ $item->No_bp }}</b>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form
                                    action="{{ route('titipan.destroy', $item->id_bp) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                    class="btn btn-danger mr-3"
                                    name="submit" title="Hapus">Ya, Hapus
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary"
                            data-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @include('transaksi.titipan.edit')
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
@include('transaksi.titipan.create')
{{-- @include'sesuai.destroybukuan.sesuai.popu'sesuai.destroyening') --}}

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
            });
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
                //  console.log("Variable is either null or undefined");
                var ko_periode = $(this).data('periode');
                var unit = $(this).data('unit');
                var kojr = $(this).data('kojr');
                var sesuaino = $(this).data('sesuaino');
                var sesuaiur = $(this).data('sesuaiur');

                $('#id').val(id);
                $('#Ko_Periodedit').val(ko_periode);
                $('#Ko_unitstredit').val(unit);
                $('#Ko_jredit').val(kojr);
                $('#Sesuai_Noedit').val(sesuaino);
                $('#Ur_bpedit').val(sesuaiur);
                $('#modal_spirc').hide();

            });

            // $('#modal-edit').on('show.bs.modal', function (event) {
            //     // event.relatedtarget menampilkan elemen mana yang digunakan saat diklik.
            //     var button              = $(event.relatedTarget)

            //     // data-data yang disimpan pada tombol edit dimasukkan ke dalam variabelnya masing-masing
            //     var id         = button.data('id')
            //     var periode    = button.data('periode')
            //     var unit        = button.data('unit')
            //     var sesuaino        = button.data('sesuaino')
            //     var sesuaiur        = button.data('sesuaiur')
            //     var modal = $(this)

            //     //variabel di atas dimasukkan ke dalam element yang sesuai dengan idnya masing-masing
            //     modal.find('#Ko_Periodedit').val(periode)
            //     modal.find('#deskripsi_barang').val(deskripsi_barang)
            //     modal.find('#jenis_barang').val(jenis_barang)
            //     modal.find('#harga_barang').val(harga_barang)
            // })

        })

        // DropzoneJS Demo Code End
    </script>
    @endsection
