@extends('layouts.template')
@section('title', 'Saldo Awal Piutang')

@section('content')
    <section class="content">
        <div class="container-fluid"><br>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{route('saldoawal.index')}}" class="btn btn-sm btn-primary">Saldo Awal Lapkeu</a>
                    <a href="#" class="btn btn-sm btn-primary disabled">Saldo Awal Piutang</a>
                    <a href="{{route('saldoawalutang.index')}}" class="btn btn-sm btn-primary">Saldo Awal Utang</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Saldo Piutang</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{route('saldoawalpiutang.create')}}" type="button" class="btn btn-sm btn-success mb-2"><i class="fas fa-plus-circle pr-1"></i>Tambah</a>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Rekening</th>
                                        <th class="text-center">Nilai (Rp)</th>
                                        <th class="text-center" style="width: 7%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->piut_doc}}</td>
                                            <td>{{$item->dt_piut}}</td>
                                            <td>{{$item->piut_ur}}</td>
                                            <td>{{$item->piut_nm}}</td>
                                            <td>{{$item->piut_addr}}</td>
                                            <td>{{$item->ur_rkk}}</td>
                                            <td class="text-right">{{number_format($item->piut_Rp,2,',','.')}}</td>
                                            <td>
                                                <div class="row justify-content-center" >
                                                <a href="{{route('saldoawalpiutang.edit',$item->id)}}" type="button" class="btn btn-sm btn-warning" title="Edit"> 
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                &nbsp&nbsp
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $item->id }}" title="Hapus"> 
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <h6>Yakin mau hapus data ?</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <form action="{{ route('saldoawalpiutang.destroy', $item->id) }}" method="post" class="">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" name="submit" title="Hapus">Ya, Hapus
                                                        </button>
                                                      </form>
                                                      <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        

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

            $("#tabelkegiatan").DataTable();

            $("#example1").DataTable();

        })

    </script>
@endsection
