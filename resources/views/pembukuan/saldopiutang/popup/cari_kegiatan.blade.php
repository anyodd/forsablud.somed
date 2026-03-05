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
                                <table class="table table-sm table-bordered table-hover mb-0" id="tabelkegiatan" width="100%" cellspacing="0">
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
                                    {{-- @if(count($datafinal ?? '') > 0 ) --}}

                                    <tbody>
                                            @foreach ($datafinal as $item)
                                            <tr>
                                                <td>{{$item->Ko_sKeg1}}</td>
                                                <td>{{$item->Ko_sKeg2}}</td>
                                                <td>{{$item->Ur_KegBL2}}</td>
                                                <td>{{$item->Ko_Rkk}}</td>
                                                <td>{{$item->Ur_Rk6}}</td>
                                                <td class="text-right">{{ number_format($item->total, 0, ",", ".") }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-k_skeg1 = "{{ $item->Ko_sKeg1 }}"
                                                        data-k_skeg2 = "{{ $item->Ko_sKeg2 }}"
                                                        {{-- data-k_skeg3 = "{{ $item->Ko_Rkk }}" --}}
                                                        data-k_skeg4 = "{{ $item->Ur_KegBL1 }}"
                                                        data-k_skeg5 = "{{ $item->Ur_KegBL2 }}"
                                                        data-k_skeg6 = "{{ $item->Ur_Rk6 }}"
                                                        data-k_skeg7 = "{{ number_format($item->To_Rp,0,',','.'); }}"
                                                        data-k_skeg8 = "{{ $item->Ko_Pdp }}"
                                                        
                                                    ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
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
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->





