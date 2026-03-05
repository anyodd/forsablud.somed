<div class="modal fade" id="modal_kegiatan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title') Cari Data</h4>
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
                                <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Program</th>
                                            <th>Kode Kegiatan</th>
                                            <th>Uraian Kegiatan</th>
                                            <th>Kode Akun</th>
                                            <th>Uraian Akun</th>
                                            <th>Nilai Anggaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- @if(count($kegiatan ?? '') > 0 ) --}}

                                    <tbody>
                                            @foreach ($kegiatan as $item)
                                            <tr>
                                                <td>{{$item->ko_skeg1}}</td>
                                                <td>{{$item->ko_skeg2}}</td>
                                                <td>{{$item->ur_kegbl2}}</td>
                                                <td>{{$item->ko_rkk}}</td>
                                                <td>{{$item->ur_rk6}}</td>
                                                <td style="text-align: right">{{number_format($item->to_rp)}}</td>
                                                <td>
                                                     <button class="btn btn-warning btn-xs py-0" title="Pilih data" id="pilih" data-dismiss="modal"
                                                            data-k_skeg1    = "{{ $item->ko_skeg1 }}"
                                                            data-k_skeg2    = "{{ $item->ko_skeg2 }}"
                                                            data-u_keg      = "{{ $item->ur_kegbl2 }}"
                                                            data-k_rek      = "{{ $item->ko_rkk }}"
                                                        ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                        {{-- @endif --}}
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





