<div class="modal fade" id="modalEditOtoBernomor{{ $otorisasi2->id }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data Otorisasi No: {{ $otorisasi2->No_oto }}</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('penomoran_update', $otorisasi2->id) }}" method="post" class="form-horizontal">
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
                          <label for="" class="col-sm-2 col-form-label">Nomor Otorisasi</label>
                          <div class="col-sm-3">
                            <input type="text" name="" class="form-control" value="{{ $otorisasi2->No_oto }}" disabled="">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
                          <div class="col-sm-3">
                            <input type="date" name="Dt_oto" class="form-control @error('Dt_oto') is-invalid @enderror" id="" value="{{ old('Dt_oto',$otorisasi2->Dt_oto) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Untuk Keperluan</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_oto" class="form-control @error('Ur_oto') is-invalid @enderror" value="{{ old('Ur_oto', $otorisasi2->Ur_oto) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nama Penerima</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Trm_Nm') is-invalid @enderror" name="Trm_Nm" id="EditTrm_Nm{{$otorisasi2->id}}" onchange="myEditTrmNm({{$otorisasi2->id}})">
                              {{-- <option value="">-- Pilih Nama Penerima --</option> --}}
                              @foreach ($rekan as $rk)
                              @if ($rk->rekan_nm != $otorisasi2->Trm_Nm)
                                  @if ($loop->first)
                                  <option value="{{$otorisasi2->Trm_Nm}}|{{$otorisasi2->Trm_NPWP}}|{{$otorisasi2->Trm_bank}}|{{$otorisasi2->Trm_rek}}">{{$otorisasi2->Trm_Nm}}</option>
                                  @endif
                              @endif
                                  <option value="{{$rk->rekan_nm}}|{{$rk->rekan_npwp}}|{{$rk->rekan_nmbank}}|{{$rk->rekan_rekbank}}" {{$rk->rekan_nm == $otorisasi2->Trm_Nm ? 'selected' : ''}}>{{$rk->rekan_nm}} ({{$rk->rekan_nmbank}})</option>
                              @endforeach
                            </select>
                            {{-- <input type="text" name="Trm_Nm" class="form-control @error('Trm_Nm') is-invalid @enderror" value="{{ old('Trm_Nm', $otorisasi2->Trm_Nm) }}"> --}}
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NPWP</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_NPWP" id="EditTrm_NPWP{{$otorisasi2->id}}" class="form-control @error('Trm_NPWP') is-invalid @enderror" value="{{ old('Trm_NPWP', $otorisasi2->Trm_NPWP) }}" readonly>
                          </div>
                        </div>
                      </div>
                     
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank Penerima</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_bank" id="EditTrm_bank{{$otorisasi2->id}}" class="form-control @error('Trm_bank') is-invalid @enderror" value="{{ old('Trm_bank', $otorisasi2->Trm_bank) }}" readonly>
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">No Rek</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_rek" id="EditTrm_rek{{$otorisasi2->id}}" class="form-control @error('Trm_rek') is-invalid @enderror" value="{{ old('Trm_rek', $otorisasi2->Trm_rek) }}" readonly>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Kepala/Kuasa</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Nm_Kuasa') is-invalid @enderror" name="Nm_Kuasa" id="EditNm_Kuasa{{$otorisasi2->id}}" onchange="myEditNmKuasa({{$otorisasi2->id}})">
                              {{-- <option value="">-- Pilih Nama Otorisator/Kuasa --</option> --}}
                              @foreach ($pegawai as $dt)
                                @if ($dt->nama != $otorisasi2->Nm_Kuasa)
                                    @if ($loop->first)
                                    <option value="{{$otorisasi2->Nm_Kuasa}}|{{$otorisasi2->NIP_Kuasa}}">{{$otorisasi2->Nm_Kuasa}}</option>
                                    @endif
                                @endif
                                  <option value="{{$dt->nama}}|{{$dt->nip}}" {{$dt->nama == $otorisasi2->Nm_Kuasa ? 'selected' : ''}}>{{$dt->nama}} ({{$dt->jabatan}})</option>
                              @endforeach
                            </select>
                            {{-- <input type="text" name="Nm_Kuasa" id="EditNm_Kuasa" class="form-control @error('Nm_Kuasa') is-invalid @enderror" value="{{ old('Nm_Kuasa', $otorisasi2->Nm_Kuasa) }}"> --}}
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NIP</label>
                          <div class="col-sm">
                            <input type="text" name="NIP_Kuasa" id="EditNIP_Kuasa{{$otorisasi2->id}}" class="form-control @error('NIP_Kuasa') is-invalid @enderror" value="{{ old('NIP_Kuasa', $otorisasi2->NIP_Kuasa) }}" readonly>
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

