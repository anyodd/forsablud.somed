<div class="modal fade" id="modalCariKegiatan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')Cari Kegiatan APBD</h4>
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
                                            <th>Kode Program</th>
                                            <th>Kode Kegiatan</th>
                                            <th>Uraian Kegiatan</th>
                                            <th>Kode Akun</th>
                                            <th>Uraian Akun</th>
                                            <th>Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- @if(count($kegiatan ?? '') > 0 ) --}}

                                    <tbody>
                                            @foreach ($kegiatan as $item)
                                            <tr>
                                                <td>{{$item->Ko_sKeg1}}</td>
                                                <td>{{$item->Ko_sKeg2}}</td>
                                                <td>{{$item->Ur_KegBL2}}</td>
                                                <td>{{$item->Ko_Rkk}}</td>
                                                <td>{{$item->Ur_Rc1}}</td>
                                                <td>{{$item->Rp_1}}</td>
                                                <td>
                                                    <!-- {{-- <a href="{{ route('saldoawal.pilih', ['id' =>$item->RKK4])}}" class="btn btn-warning btn-xs py-0" title="Edit data"> <i style='font-size:8px' class="fa fa-choose"> </i>Pilih </a> --}}
                                                    {{-- {{ route('saldoawal.edit', ['saldoawal' =>$item->id])}} --}}
                                                    {{-- <form action="{{ route('saldoawal.destroy', ['saldoawal' =>$item->id])}}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus {{$item->namarek}} ?')">
                                                        @method("delete")
                                                            @csrf
                                                            <button title="Hapus data" type="submit" data-name="{{$item->consul_id}}" data-table="saldoawal"  class="btn btn-xs btn-danger py-0"><i  class="fa fa-trash pr-1" style='font-size:8px'></i></button>
                                                    </form> --}} -->
                                                    <button class="btn btn-warning btn-sm py-0" title="Pilih data" id="pilih"
                                                        data-Ko_Pdp = "{{ $item->Ko_Pdp }}"
                                                        data-Ur_Pdp = "{{ $item->Ur_Pdp }}"
                                                    >
                                                    <i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- @endif --}}
                                        <tfoot>
                                        </tfoot>
                                    </table>
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





