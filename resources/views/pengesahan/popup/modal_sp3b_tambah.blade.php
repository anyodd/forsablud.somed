<div class="modal fade" id="modalTambahSp3b">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Pengesahan SP3B</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('pengesahan.store') }}" method="post" class="form-horizontal">
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
                          <label for="" class="col-sm-2 col-form-label">Nomor Dokumen</label>
                          <div class="col-sm-3">
                            <input type="text" name="No_sp3" class="form-control @error('No_sp3') is-invalid @enderror" value="{{ old('No_sp3') }}" placeholder="Nomor SP3B">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal Dokumen</label>
                          <div class="col-sm-3">
                            <input type="date" name="Dt_sp3" class="form-control" id="" value="{{ old('Dt_sp3') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Uraian Dokumen</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_sp3" class="form-control @error('Ur_sp3') is-invalid @enderror" value="{{ old('Ur_sp3') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">SP3B Bulan</label>
                          <div class="col-sm-3">
                            <select class="form-control" name="bln_sp3" id="" required>
                              <option value="">-- Pilih Bulan --</option>
                              @foreach ($bulan as $item)
                                  <option value="{{$item->id_bln}}">{{ $item->Ur_bln }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kepala/Kuasa</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Nm_Kuasa') is-invalid @enderror" name="Nm_Kuasa" id="Nm_Kuasa">
                              <option value="">-- Pilih Nama Kepala/Kuasa --</option>
                              @foreach ($pegawai as $ls)
                                  <option value="{{$ls->nama}}|{{$ls->nip}}">{{$ls->nama}} ({{$ls->jabatan}})</option>
                              @endforeach
                            </select>
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NIP</label>
                          <div class="col-sm">
                            <input type="text" name="NIP_Kuasa" id="NIP_Kuasa" class="form-control @error('NIP_Kuasa') is-invalid @enderror" value="{{ old('NIP_Kuasa') }}" readonly>
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