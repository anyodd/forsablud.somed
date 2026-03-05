<div class="modal fade" id="modalPenomoranUsul{{ $otorisasi->id }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Penomoran Usulan Otorisasi</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('otorisasi.store') }}" method="post" class="form-horizontal">
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
                          <div class="col-sm-5">
                            <input type="hidden"  name="id_spi" class="form-control" value="{{ $otorisasi->id }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nomor Usulan</label>
                          <div class="col-sm-5">
                            <input type="text" name="No_SPi" class="form-control" id="" value="{{ $otorisasi->No_SPi }}" disabled="">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nomor Otorisasi</label>
                          <div class="col-sm-5">
                            <input type="text" name="No_oto" class="form-control @error('No_oto') is-invalid @enderror" value="{{ old('No_oto') }}" placeholder="Nomor Otorisasi">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
                          <div class="col-sm-5"> 
                            <input type="date" name="" class="form-control" value="{{date('Y-m-d', strtotime($otorisasi->otodated_at))}}" readonly>
                            <input type="hidden" name="Dt_oto" class="form-control" value="{{ $otorisasi->otodated_at }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Untuk keperluan</label>
                          <div class="col-sm">
                            <input type="text" name="Ur_oto" class="form-control @error('Ur_oto') is-invalid @enderror" value="{{ old('Ur_oto', 'Otorisasi '.$otorisasi->Ur_SPi) }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Nama penerima</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Trm_Nm') is-invalid @enderror" name="Trm_Nm" id="Trm_Nm{{$otorisasi->id}}" onchange="myTrmNm({{$otorisasi->id}})">
                              <option value="">-- Pilih Nama Penerima --</option>
                              @foreach ($rekan as $rk)
                                  <option value="{{$rk->rekan_nm}}|{{$rk->rekan_npwp}}|{{$rk->rekan_nmbank}}|{{$rk->rekan_rekbank}}">{{$rk->rekan_nm}} ({{$rk->rekan_nmbank}})</option>
                              @endforeach
                            </select>
                            {{-- <input type="text" name="Trm_Nm" class="form-control @error('Trm_Nm') is-invalid @enderror" value="{{ old('Trm_Nm') }}"> --}}
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NPWP</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_NPWP" id="Trm_NPWP{{$otorisasi->id}}" class="form-control @error('Trm_NPWP') is-invalid @enderror" value="{{ old('Trm_NPWP') }}" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bank penerima</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_bank" id="Trm_bank{{$otorisasi->id}}" class="form-control @error('Trm_bank') is-invalid @enderror" value="{{ old('Trm_bank') }}" readonly>
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">No Rek</label>
                          <div class="col-sm">
                            <input type="text" name="Trm_rek" id="Trm_rek{{$otorisasi->id}}" class="form-control @error('Trm_rek') is-invalid @enderror" value="{{ old('Trm_rek') }}" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Otorisator/Kuasa</label>
                          <div class="col-sm">
                            <select class="form-control select2 @error('Nm_Kuasa') is-invalid @enderror" name="Nm_Kuasa" id="Nm_Kuasa{{$otorisasi->id}}" onchange="myNmKuasa({{$otorisasi->id}})">
                              <option value="">-- Pilih Nama Otorisator/Kuasa --</option>
                              @foreach ($pegawai as $item)
                                  <option value="{{$item->nama}}|{{$item->nip}}" data-nip={{$item->nip}} data-nama={{$item->nama}}>{{$item->nama}} ({{$item->jabatan}})</option>
                              @endforeach
                            </select>
                            {{-- <input type="text" name="Nm_Kuasa" class="form-control @error('Nm_Kuasa') is-invalid @enderror" value="{{ old('Nm_Kuasa') }}"> --}}
                          </div>
                          <label for="" class="col-sm-1 col-form-label text-right">NIP</label>
                          <div class="col-sm">
                            <input type="text" name="NIP_Kuasa" id="NIP_Kuasa{{$otorisasi->id}}" class="form-control @error('NIP_Kuasa') is-invalid @enderror" value="{{ old('NIP_Kuasa') }}" readonly>
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
                        <button type="submit" class="btn btn-success btn-block px-0" name="submit" value="{{ $otorisasi->No_SPi }}">
                          Simpan
                        </button>
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