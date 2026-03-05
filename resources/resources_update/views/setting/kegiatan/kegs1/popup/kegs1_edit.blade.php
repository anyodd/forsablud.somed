 <div class="modal fade" id="modalEditKegs1{{ $kegs1->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Program BLUD</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('setkegs1.update', $kegs1->id) }}" method="post" class="form-horizontal">
                @csrf
                @method("PUT")
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kode Program BLUD</label>
                          <div class="col-sm-1">
                            <input type="text" class="form-control" value="{{ $kegs1->Ko_KegBL1 }}" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Program BLUD</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_KegBL1" class="form-control @error('Ur_KegBL1') is-invalid @enderror" value="{{ old('Ur_KegBL1', $kegs1->Ur_KegBL1) }}" placeholder="Program BLUD" required="">
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