@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Rincian Kontrak</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('subkontrak.update', $data->id_contrc) }}" method="post" class="form-horizontal">
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

              <div class="card-body">
                  <div class="form-group row">
                  <label for="koPeriod" class="col-sm-3 col-form-label">Periode</label>
                      <div class="col-sm-3">
                          <input type="text" name="Ko_period" class="form-control @error('Ko_period') is-invalid @enderror" value="{{old('Ko_Period', $data->Ko_Period)}}" id="KoPeriod" readonly>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="unitKerja" class="col-sm-3 col-form-label">Kode Unit </label>
                      <div class="col-sm-3">
                          <input type="text" name="Ko_unit1" class="form-control @error('Ko_unit1') is-invalid @enderror" value="{{old('Ko_unit1', $data->Ko_unit1)}}" id="unitKerja" readonly>
                      </div>
                  </div>    
                  <div class="form-group row">
                      <label for="nomorSpd" class="col-sm-3 col-form-label">Nomor Kontrak</label>
                      <div class="col-sm-3">
                          <input type="text" name="No_contr" class="form-control" value="{{old('No_contr', $data->No_contr)}}" id="nomorBukti" readonly>
                      </div>
                  </div>
                  <input type="hidden" name="id_contr" class="form-control" value="{{old('id_contr', $data->id_contr)}}" id="IdContr" readonly>
                  <hr>
                  
                  <div class="form-group row">
                      <label for="Ko_bprc" class="col-sm-3 col-form-label">Nomor Urut</label>
                      <div class="col-sm-1">
                          <input type="text" name="Ko_contrc" class="form-control" value="{{$data->Ko_contrc}}" id="Ko_contrc" readonly>
                      </div> 
                  </div>
                  {{-- modal Kegiatan APBD --}}
                  <div class="row form-group">
                      <div class="col-sm-3">
                        <label for="KegApbd">Cari Rincian</label>
                      </div>
                      <div class="col-sm-9">
                        <div class="input-group input-group-sm-1">
                            <input type="text" class="form-control" id="Ur_Keg2" name="Ur_Keg2">
                            <span class="input-group-append">
                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalCariKegiatan">Cari!</button>
                            </span>
                        </div>
                      </div>
                  </div>
                  {{-- END MODAL Kegiatan APBD--}}
                  <div class="form-group row">
                      <label for="Ko_sKeg1" class="col-sm-3 col-form-label">Nilai Total Program (Rp)</label>
                      <div class="col-sm-2">
                          <input type="text" name="To_Rp2" class="form-control text-right" id="To_Rp" value="{{number_format($dt_view->to_rp,2,',','.')}}" readonly>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="Ko_sKeg1" class="col-sm-3 col-form-label">Uraian Program</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_sKeg1" class="form-control" id="sKo_sKeg1" value="{{old('Ko_sKeg1', $dt_view->ko_skeg1)}}" readonly>
                      </div> 
                      <div class="col-sm-7">
                          <input type="text" name="Ur_sKeg1" class="form-control" id="Ur_KegBL1" value="{{old('Ur_sKeg1', $dt_view->ur_kegbl1)}}" readonly>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="Ko_sKeg2" class="col-sm-3 col-form-label">Uraian Kegiatan</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_sKeg2" class="form-control" id="sKo_sKeg2" value="{{old('Ko_sKeg2', $dt_view->ko_skeg2)}}" readonly>
                      </div>
                      <div class="col-sm-7">
                          <input type="text" name="Ur_sKeg2" class="form-control" id="Ur_KegBL2" value="{{old('Ur_sKeg2', $dt_view->ur_kegbl2)}}" readonly>
                      </div>  
                  </div>
                  <div class="form-group row">
                      <label for="Ko_Rkk" class="col-sm-3 col-form-label">Uraian Rekening</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_Rkk" class="form-control" id="sKo_Rkk" value="{{old('Ko_Rkk', $dt_view->ko_rkk)}}" readonly>
                      </div> 
                      <div class="col-sm-7">
                          <input type="text" name="Ur_Rk6" class="form-control" id="Ur_Rk6"  value="{{old('Ur_Rk6', $dt_view->ur_rk6)}}" readonly>
                      </div> 
                  </div>
                  <hr>
                  <div class="form-group row">
                      <label for="To_Rp" class="col-sm-3 col-form-label">Nilai Kontrak (Rp)</label>
                      <div class="col-sm-9">
                          <input type="text" name="To_Rp" class="form-control desimal" id="To_Rp2" value="{{old('To_Rp', number_format($data->To_Rp,2,',','.'))}}">
                      </div>
                  </div>
              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('subkontrak.rincian', $data->id_contr) }}" class="col-sm-2 btn btn-danger ml-3">
                  <i class="fas fa-backward pr-2"></i>Kembali
                </a> 
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  
@include('transaksi.belanja.popup.modal_cari_kegiatan')
@endsection