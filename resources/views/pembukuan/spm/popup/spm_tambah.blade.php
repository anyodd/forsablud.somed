<div class="modal fade" id="modalSpmBayar{{ $calon_spm->id }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Realisasi SPM</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('spm.store') }}" method="post" class="form-horizontal">
                @csrf
                @if(session('errors'))
                <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                  Something it's wrong:
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nomor Otorisasi</label>
                          <div class="col-sm-5">
                            <input type="text" name="No_oto" class="form-control" id="" value="{{ $calon_spm->No_oto }}" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
                          <div class="col-sm-5">
                            <input type="date" name="Dt_oto" class="form-control" value="{{ $calon_spm->Dt_oto }}" disabled="">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nomor Bukti Bayar</label>
                          <div class="col-sm-5">
                            <input type="text" name="No_byro" class="form-control @error('No_byro') is-invalid @enderror" id="" value="{{ old('No_byro') }}">
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal Bayar</label>
                          <div class="col-sm">
                            <input type="date" name="dt_byro" class="form-control" value="{{ old('dt_byro') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Uraian</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_byro" class="form-control @error('Ur_byro') is-invalid @enderror" value="{{ old('Ur_byro', 'Pembayaran SPM ...') }}">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank yang membayar</label>
                          <div class="col-sm">
                            <select name="Ko_Bank" class="form-control select2 @error('Ko_Bank') is-invalid @enderror" id="Ko_Bank">
                              <option value="" selected disabled>-- pilih Bank --</option>
                              @foreach($bank as $number => $bank)
                              <option value="{{ $bank->Ko_Bank }}">{{ $bank->Ko_Bank }} - {{ $bank->Ur_Bank }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank Tujuan</label>
                          <div class="col-sm">
                            <input type="text" name="Nm_Bank" class="form-control @error('Nm_Bank') is-invalid @enderror" value="{{ old('Nm_Bank') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">No Rek Bank Tujuan</label>
                          <div class="col-sm">
                            <input type="text" name="No_Rektuju" class="form-control @error('No_Rektuju') is-invalid @enderror" value="{{ old('No_Rektuju') }}">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Yang membayar</label>
                          <div class="col-sm">
                            <input type="text" name="Nm_Byro" class="form-control @error('Nm_Byro') is-invalid @enderror" value="{{ old('Nm_Byro') }}">
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
                        <button type="submit" class="btn btn-success btn-block px-0" name="submit" value="{{ $calon_spm->id }}">Simpan</button>
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