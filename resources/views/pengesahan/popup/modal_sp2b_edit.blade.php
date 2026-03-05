<div class="modal fade" id="modalEditSp2b{{ $sp2b->id_sp2 }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Pengesahan SP2B</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('sp2b.update', $sp2b->id_sp2) }}" method="post" class="form-horizontal">
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
                          <label for="" class="col-sm-2 col-form-label">Nomor SP2B</label>
                          <div class="col-sm-3">
                            <input type="text" name="No_sp2" class="form-control" value="{{ $sp2b->No_sp2 }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal SP2B</label>
                          <div class="col-sm-3">
                            <input type="date" name="Dt_sp2" class="form-control @error('Dt_sp2') is-invalid @enderror" id="" value="{{ old('Dt_sp2', $sp2b->Dt_sp2) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Uraian SP2B</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_sp2" class="form-control @error('Ur_sp2') is-invalid @enderror" value="{{ old('Ur_sp2', $sp2b->Ur_sp2) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kepala/Kuasa</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Nm_Kuasa') is-invalid @enderror" name="Nm_Kuasa" id="EditNm_Kuasa">
                              {{-- <option value="">-- Pilih Nama Kepala/Kuasa --</option> --}}
                              @foreach ($pegawai as $ls)
                                @if ($ls->nama != $sp2b->Nm_Kuasa)
                                  @if ($loop->first)
                                  <option value="{{$sp2b->Nm_Kuasa}}|{{$sp2b->NIP_Kuasa}}">{{$sp2b->Nm_Kuasa}}</option>
                                  @endif
                                @endif
                                  <option value="{{$ls->nama}}|{{$ls->nip}}" {{$ls->nama == $sp2b->Nm_Kuasa ? 'selected' : ''}}>{{$ls->nama}} ({{$ls->jabatan}})</option>
                              @endforeach
                            </select>
                            {{-- <input type="text" name="Nm_Kuasa" class="form-control @error('Nm_Kuasa') is-invalid @enderror" value="{{ old('Nm_Kuasa', $sp2b->Nm_Kuasa) }}"> --}}
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NIP</label>
                          <div class="col-sm">
                            <input type="text" name="NIP_Kuasa" id="EditNIP_Kuasa" class="form-control @error('NIP_Kuasa') is-invalid @enderror" value="{{ old('NIP_Kuasa', $sp2b->NIP_Kuasa) }}" readonly>
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
                        <button type="submit" class="btn btn-success btn-block px-0" name="submit" value="">Simpan</button>
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

