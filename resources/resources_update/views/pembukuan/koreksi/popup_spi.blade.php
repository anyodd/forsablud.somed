<div class="modal fade" id="modal_spirc">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- About Me Box -->
                            <div class="card card-info">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example3" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode SPJ</th>
                                            <th>SPJ Rinci</th>
                                            <th>Urauan Rinci</th>
                                            <th>Kode Rekening</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- @if(count($saldo ?? '') > 0 ) --}}
                                    <tbody>
                                        @foreach ($refspirc as $item)
                                        <tr>
                                            <td  style="text-align: left;max-width: 50px;" >{{$loop->iteration}}.</td>
                                            <td>{{$item->No_spi}}</td>
                                            <td>{{$item->Ko_spirc}}</td>
                                            <td>{{$item->Ur_bprc}}</td>
                                            <td>{{$item->Ko_Rkk}}</td>
                                            <td>
                                                {{-- <a href="{{ route('saldoawal.pilih', ['id' =>$item->refspirc])}}" class="btn btn-warning btn-xs py-0" title="Edit data"> <i style='font-size:8px' class="fa fa-choose"> </i>Pilih </a> --}}
                                                {{-- {{ route('saldoawal.edit', ['saldoawal' =>$item->id])}} --}}
                                                {{-- <form action="{{ route('saldoawal.destroy', ['saldoawal' =>$item->id])}}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus {{$item->namarek}} ?')">
                                                    @method("delete")
                                                        @csrf
                                                        <button title="Hapus data" type="submit" data-name="{{$item->consul_id}}" data-table="saldoawal"  class="btn btn-xs btn-danger py-0"><i  class="fa fa-trash pr-1" style='font-size:8px'></i></button>
                                                </form> --}}
                                                <button class="btn btn-warning btn-xs py-0" title="Pilih data" id="pilih"
                                                    data-kd_spi = "{{ $item->No_spi }}"
                                                    data-kd_spirc = "{{ $item->Ko_spirc }}"
                                                    data-nm_rek = "{{ $item->Ko_Rkk }}"
                                                ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
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
            </div>
                {{-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->





