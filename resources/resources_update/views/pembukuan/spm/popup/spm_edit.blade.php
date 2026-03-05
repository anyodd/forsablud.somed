 <div class="modal fade" id="modalEditSpm{{ $spm->id_byro }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Edit Data Realisasi Pencairan Dana No: {{ $spm->No_byro }}</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('spm.update', $spm->id_byro) }}" method="post" class="">
                @csrf
                @method("PUT")
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
                          <label for="" class="col-sm-2 col-form-label">Nomor Bukti Bayar</label>
                          <div class="col-sm-3">
                            <input type="text" name="No_byro" class="form-control @error('No_byro') is-invalid @enderror" value="{{ old('No_byro', $spm->No_byro) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                          <div class="col-sm-3">
                            <input type="date" name="dt_byro" class="form-control @error('dt_byro') is-invalid @enderror" value="{{ old('dt_byro', $spm->dt_byro) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Uraian</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_byro" class="form-control @error('Ur_byro') is-invalid @enderror" value="{{ old('Ur_byro', $spm->Ur_byro) }}">
                          </div>
                        </div>
                      </div>

                      {{-- <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank yang membayar</label>
                          <div class="col-sm">
                            <select name="Ko_Bank" class="form-control select2 @error('Ko_Bank') is-invalid @enderror" id="Ko_Bank">
                              <option value="" selected disabled>-- pilih Bank --</option>
                              @foreach($bank as $number => $bank)
                              @if ($spm->Ko_Bank == $bank->Ko_Bank)
                              <option value="{{ $bank->Ko_Bank }}" selected="">{{ $bank->Ko_Bank }} - {{ $bank->Ur_Bank }}</option>
                              @else
                              <option value="{{ $bank->Ko_Bank }}">{{ $bank->Ko_Bank }} - {{ $bank->Ur_Bank }}</option>
                              @endif
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div> --}}

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank Tujuan</label>
                          <div class="col-sm">
                            <input type="text" name="Nm_Bank" class="form-control @error('Nm_Bank') is-invalid @enderror" value="{{ old('Nm_Bank', $spm->Nm_Bank) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">No Rek Bank Tujuan</label>
                          <div class="col-sm">
                            <input type="text" name="No_Rektuju" class="form-control @error('No_Rektuju') is-invalid @enderror" value="{{ old('No_Rektuju', $spm->No_Rektuju) }}">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Yang membayar</label>
                          <div class="col-sm">
                            <input type="text" name="Nm_Byro" class="form-control @error('Nm_Byro') is-invalid @enderror" value="{{ old('Nm_Byro', $spm->Nm_Byro) }}">
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-md-10"></div>
                      <div class="col-md-1">
                        <button type="submit" class="btn btn-success btn-block px-0" name="submit" value="">Simpan</button>
                      </div>
                      <div class="col-md-1">
                        <button class="btn btn-secondary btn-block px-0" data-dismiss="modal">Batal</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>