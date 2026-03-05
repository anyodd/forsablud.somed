<div class="modal fade" id="modalSp3bRinci{{ $sp3b->id_sp3 }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Rincian SP3B</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nomor Dokumen</label>
                        <div class="col-sm">
                          <input type="text" name="" class="form-control" value="{{ $sp3b->No_sp3 }}" disabled="">
                        </div>
                        <label for="" class="col-sm-2 col-form-label text-right">Tanggal Dokumen</label>
                        <div class="col-sm">
                          <input type="date" name="" class="form-control" id="" value="{{ $sp3b->Dt_sp3 }}" disabled="">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Uraian</label>
                        <div class="col-sm">
                          <input type="text" name="" class="form-control" value="{{ $sp3b->Ur_sp3 }}" disabled="">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Kepala/Kuasa</label>
                        <div class="col-sm">
                          <input type="text" name="" class="form-control" value="{{ $sp3b->Nm_Kuasa }}" disabled="">
                        </div>
                        <label for="" class="col-sm-2 col-form-label text-right">NIP</label>
                        <div class="col-sm">
                          <input type="text" name="" class="form-control" value="{{ $sp3b->NIP_Kuasa }}" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSp3bRinciTambah{{ $sp3b->id_sp3 }}" data-backdrop="static">Tambah</button> 
                </div>
              </div>
              @include('pengesahan.popup.modal_sp3b_rinci_tambah')

              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0 example1" id="example1" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center" style="vertical-align: middle;">Nomor Urut</th>
                          <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Nilai Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;width: 5%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>

                        @if($sp3brinci->count() > 0)
                        @foreach ($sp3brinci->where('No_sp3', $sp3b->No_sp3) as $number => $sp3brinci)
                        <tr>
                          <td class="text-center" style=" width: 5%;">{{$sp3brinci ->Ko_sp3}}</td>                       
                          <td>{{$sp3brinci ->No_oto}}</td>                      
                          <td class="text-center">{{ date('d M Y', strtotime($sp3brinci ->Dt_oto)) }}</td>                      
                          <td class="text-right">{{ number_format($sp3brinci ->sp3rc_Rp, 0, ',', '.') }}</td>   
                          <td>
                            <div class="row justify-content-center" >
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $sp3brinci->id_sp3rc }}" title="Hapus">
                                <i class="far fa-trash-alt"></i>
                              </button>
                              @include('pengesahan.popup.modal_sp3b_rinci_hapus')
                            </div>
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