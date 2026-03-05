 <div class="modal fade" id="modalEditKegs2{{ $kegs2->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Aktivitas</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid"> 
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('setkegs2.update', $kegs2->id) }}" method="post" class="form-horizontal">
                @csrf
                @method("PUT")
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kode Aktivitas</label>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" value="{{ $kegs2->Ko_KegBL2 }}" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Aktivitas</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_KegBL2" class="form-control @error('Ur_KegBL2') is-invalid @enderror" value="{{ old('Ur_KegBL2', $kegs2->Ur_KegBL2) }}" placeholder="Aktivitas" required="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-md-10"></div>
                      <div class="col-md-1">
                        <button type="submit" class="btn btn-success btn-block px-0">Simpan</button>
                        <input type="hidden" name="Ko_sKeg1" value="{{ $Ko_sKeg1 }}">
                        <input type="hidden" name="Ur_sKeg" value="{{ $Ur_sKeg }}">
                        <input type="hidden" name="Ko_KegBL1" value="{{ $Ko_KegBL1 }}">
                        <input type="hidden" name="Ur_KegBL1" value="{{ $Ur_KegBL1 }}">
                      </div>
                      <div class="col-md-1">
                        <button class="btn btn-secondary btn-block px-0" data-dismiss="modal">Batal</button>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!-- /.card -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>