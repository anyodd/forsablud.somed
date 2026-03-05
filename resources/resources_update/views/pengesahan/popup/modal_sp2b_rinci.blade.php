<div class="modal fade" id="modalSp2bRinci">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Rincian SP2B</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0 example1" id="example1" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center" style="width: 5%">No</th>
                          <th class="text-center">Nomor SP2B</th>
                          <th class="text-center">Tanggal SP2B</th>
                          <th class="text-center">Uraian SP2B</th>
                          <th class="text-center" style="width: 8%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>

                        @if($sp2b->count() > 0)
                        @foreach ($sp2b as $number => $sp2b)
                        <tr>
                          <td class="text-center">{{$loop->iteration}}</td>                       
                          <td>{{$sp2b ->No_sp2}}</td>                      
                          <td class="text-center">{{ date('d M Y', strtotime($sp2b->Dt_sp2)) }}</td>                      
                          <td>{{$sp2b ->Ur_sp2}}</td>   
                          <td class="text-center">
							<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditSp2b{{ $sp2b->id_sp2 }}" title="Edit">
							  <i class="far fa-edit"></i>
							</button>
							&nbsp&nbsp
							@include('pengesahan.popup.modal_sp2b_edit')
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusSp2b{{ $sp2b->id_sp2 }}" title="Hapus">
							  <i class="far fa-trash-alt"></i>
							</button>
							@include('pengesahan.popup.modal_sp2b_hapus')
                          </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="3">Tidak Ada Data</td>
                        </tr>
                        @endif
                      </tbody>

                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                      <button class="btn btn-danger btn-block px-0" data-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </div>
                <!-- /.card-footer-->
              </div>
              <!-- /.card -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>