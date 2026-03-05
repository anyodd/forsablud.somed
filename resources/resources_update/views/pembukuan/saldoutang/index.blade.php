@extends('layouts.template')
@section('title', 'Saldo Awal Utang')

@section('content')
    <section class="content">
        <div class="container-fluid"><br>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{route('saldoawal.index')}}" class="btn btn-sm btn-primary">Saldo Awal Lapkeu</a>
                    <a href="{{route('saldoawalpiutang.index')}}" class="btn btn-sm btn-primary">Saldo Awal Piutang</a>
                    <a href="#" class="btn btn-sm btn-primary disabled">Saldo Awal Utang</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Saldo Utang</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-success mb-2" data-toggle="modal" data-backdrop="static"
                                data-target="#modal-create"><i class="fas fa-plus-circle pr-1"></i>Tambah</button>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Tanggal Jatuh Tempo</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Nilai (Rp)</th>
                                        <th class="text-center" style="width: 10%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}.</td>
                                            <td>{{$item->uta_doc}}</td>
                                            <td class="text-center">{{$item->dt_uta}}</td>
                                            <td class="text-center">{{$item->jt_uta}}</td>
                                            <td>{{$item->uta_ur}}</td>
                                            <td>{{$item->uta_nm}}</td>
                                            <td>{{$item->uta_addr}}</td>
                                            <td class="text-right">{{number_format($item->uta_Rp,2,',','.')}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm ml-2 mr-2" title="Edit data" id="edit"
                                                    data-toggle="modal" data-target="#modal-edit{{$item->id}}"><i class="fa fa-edit"> </i>
                                                </button>
                                                <form action="{{ route('saldoawalutang.destroy', $item->id) }}" method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus data ?')">
                                                    @method("delete")
                                                    @csrf
                                                    <button title="Hapus data" type="submit" data-name=""
                                                        data-table="sesuai" class="btn btn-sm btn-danger"><i class="fa fa-trash pr-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @include('pembukuan.saldoutang.popup.edit')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        @include('pembukuan.saldoutang.popup.create')
        @include('pembukuan.saldoutang.popup.kegiatan')
        @include('pembukuan.saldoutang.popup.rekening')

    </section>
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

            $("#example1").DataTable();


            $("#tbl_rekening").DataTable();
            $("#example3").DataTable();

            $(document).on('click', '#pilih', function() {
                var skeg1 = $(this).data('skeg1');
                var skeg2 = $(this).data('skeg2');
                var ur_keg  = $(this).data('ur_keg');
                $('#skeg1_create').val(skeg1);
                $('#skeg2_create').val(skeg2);
                $('#ur_keg_create').val(ur_keg);
                $('#modal_kegiatan').hide();
            });

            $(document).on('click', '#pilihrkk', function() {
                var kd_rek = $(this).data('rkk');
                var nm_rek = $(this).data('ur_rkk');
                $('#Ko_Rkk_create').val(kd_rek);
                $('#ur_rek_create').val(nm_rek);
                $('#modal_rekening').hide();
            });

        })

        $(document).on('change','#cruta_nm',function () { 
            var dt  = document.getElementById('cruta_nm').value;
            var adr = dt.split("|");
            $('#cruta_addr').val(adr[2]);
        });

        function myEdituta_nm($id) {
            var data = document.getElementById("uta_nm"+$id).value;
            var dt = data.split("|");
            $('#uta_addr'+$id).val(dt[2]);
        }
    </script>
@endsection
