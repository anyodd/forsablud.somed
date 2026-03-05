<div class="modal fade" id="modalTambahKegs2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Aktivitas</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('setkegs2.store') }}" method="post" class="form-horizontal">
                @csrf
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kode Aktivitas</label>
                          <div class="col-sm-1">
                            <input type="number" min="1" max="99" name="Ko_KegBL2" class="form-control @error('Ko_KegBL2') is-invalid @enderror" value="{{ old('Ko_KegBL2', $max+1) }}" placeholder="Kode Aktivitas" required="">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Aktivitas</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_KegBL2" class="form-control @error('Ur_KegBL2') is-invalid @enderror" value="{{ old('Ur_KegBL2') }}" placeholder="Aktivitas" required="">
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
                        <input type="hidden" name="Ko_KegBL1" value="{{ $Ko_KegBL1 }}">
                        <input type="hidden" name="ko_unit1" value="{{ $ko_unit1 }}">
                        <input type="hidden" name="nm_bidang" value="{{ $nm_bidang }}">
                        <input type="hidden" name="Ur_sKeg" value="{{ $Ur_sKeg }}">
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