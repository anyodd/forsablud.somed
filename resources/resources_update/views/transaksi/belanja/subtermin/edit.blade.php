@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Penerimaan {{ Session::get('Ko_Period') }}</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('subtermin.update', $data->id_bprc) }}" method="post" class="form-horizontal">
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
                  <input type="hidden" name="id_bp" class="form-control" value="{{old('id_bp', $data->id_bp)}}" id="IdBp" readonly>
                  <div class="form-group row">
                      <label for="rftr_bprc" class="col-sm-3 col-form-label">Nomor Bukti</label>
                      <div class="col-sm-9">
                          <input type="text" name="No_bp" class="form-control" id="No_bp" value="{{ old('No_bp', $data->No_bp )}}" readonly>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="dt_rftrbprc" class="col-sm-3 col-form-label">Tanggal Pembayaran</label>
                      <div class="col-sm-9">
                          <input type="date" name="dt_rftrbprc" class="form-control" id="dt_rftrbprc" value="{{ old('dt_bp', $data->dt_bp )}}" readonly>
                      </div> 
                  </div>
                  <hr>
                  
                  <div class="form-group row">
                      <label for="Ko_bprc" class="col-sm-3 col-form-label">No. Urut Pembayaran</label>
                      <div class="col-sm-1">
                          {{-- <input type="text" name="Ko_bprc" class="form-control" value="{{$max+1}}" id="Ko_bprc" readonly> --}}
                      </div> 
                  </div>
                  {{-- modal Kegiatan APBD --}}
                  <div class="row form-group">
                      <div class="col-sm-3">
                        <label for="KegApbd">Kegiatan APBD</label>
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
                          <input type="text" name="total" class="form-control text-right" id="To_Rp" value="{{number_format($dt_view->To_Rp,2,',','.')}}" readonly>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="Ko_sKeg1" class="col-sm-3 col-form-label">Uraian Program</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_sKeg1" class="form-control" id="sKo_sKeg1" value="{{$data->Ko_sKeg1}}"  readonly>
                      </div> 
                      <div class="col-sm-7">
                          <input type="text" name="Ur_sKeg1" class="form-control" id="Ur_KegBL1" value="{{$dt_view->Ur_KegBL1}}" readonly>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="Ko_sKeg2" class="col-sm-3 col-form-label">Uraian Kegiatan</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_sKeg2" class="form-control" id="sKo_sKeg2" value="{{$data->Ko_sKeg2}}" readonly>
                      </div>
                      <div class="col-sm-7">
                          <input type="text" name="Ur_sKeg2" class="form-control" id="Ur_KegBL2" value="{{$dt_view->Ur_KegBL2}}" readonly>
                      </div>  
                  </div>
                  <div class="form-group row">
                      <label for="Ko_Rkk" class="col-sm-3 col-form-label">Uraian RKK</label>
                      <div class="col-sm-2">
                          <input type="text" name="Ko_Rkk" class="form-control" id="sKo_Rkk" value="{{$data->Ko_Rkk}}" readonly>
                      </div> 
                      <div class="col-sm-7">
                          <input type="text" name="Ur_Rk6" class="form-control" id="Ur_Rk6" value="{{$dt_view->Ur_Rk6}}" readonly>
                      </div> 
                  </div>
                  <hr>
                  <div class="form-group row">
                      <label for="Ur_bprc" class="col-sm-3 col-form-label">Uraian Rincian</label>
                      <div class="col-sm-9">
                          <input type="text" name="Ur_bprc" class="form-control" id="Ur_bprc" value="{{$data->Ur_bprc}}">
                      </div> 
                  </div>
                  <div class="form-group row">
                    <label for="rftr_bprc" class="col-sm-3 col-form-label">Nomor Referensi</label>
                    <div class="col-sm-9">
                        <input type="text" name="rftr_bprc" class="form-control" value="{{$data->rftr_bprc}}" id="rftr_bprc" readonly>
                    </div> 
                  </div>
                  <div class="form-group row">
                    <label for="dt_rftrbprc" class="col-sm-3 col-form-label">Tanggal Referensi</label>
                    <div class="col-sm-9">
                        <input type="date" name="dt_rftrbprc" class="form-control" id="dt_rftrbprc1" value="{{$data->dt_rftrbprc}}" readonly>
                    </div> 
                  </div>
                  <input type="text" name="No_PD" class="form-control" id="No_PD" value="1" hidden>

                  {{-- <div class="row form-group">
                      <div class="col-sm-3">
                        <label for="KoPdp">Jenis Sumber</label>
                      </div>
                      <div class="col-sm-9">
                          <select id="KoPdp" name="Ko_Pdp"  class="form-control select2 select2-danger @error('Ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;" autofocus>  
                              <option value="">--Pilih Sumber Kegiatan--</option>
                              @foreach ($sumber as $s)
                                <option value="{{$s->Ko_Pdp}}">{{$s->Ur_Pdp}}</option>
                              @endforeach
                              
                          </select>
                          @error('Ko_kas')
                              <div class="invalid-feedback"> {{ $message}}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col-sm-3">
                        <label for="RincianSumber">Rincian Sumber</label>
                      </div>
                      <div class="col-sm-9">
                          <select id="param2" name="Ko_pmed" class="form-control select2 select2-danger @error('KoPdp') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;" autofocus>
                          <option value="" selected>---Pilih Sumber Kegiatan---</option>
                          </select>
                            @error('Ko_kas')
                                  <div class="invalid-feedback"> {{ $message}}</div>
                            @enderror
                      </div>
                  </div> --}}
                  <div class="form-group row">
                      <label for="To_Rp" class="col-sm-3 col-form-label">Nilai (Rp)</label>
                      <div class="col-sm-9">
                          <input type="text" name="To_Rp" class="form-control desimal" id="To_Rp" value="{{number_format($data->To_Rp,2,',','.')}}">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="Ko_kas" class="col-sm-3 col-form-label">Cara Pembayaran</label>
                      <div class="col-sm-9">
                          <select id="Ko_kas" name="Ko_kas" class="form-control select2 select2-danger @error('Ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;" autofocus>
                              <option value="0">--Pilih Cara Pembayaran--</option>
                              <option value="1" {{$data->ko_kas == 1 ? 'selected' : ''}}>Pindah Buku</option>
                              <option value="2" {{$data->ko_kas == 2 ? 'selected' : ''}}>Tunai Fisik</option>
                          </select>
                          @error('Ko_kas')
                              <div class="invalid-feedback"> {{ $message}}</div>
                          @enderror
                      </div>
                  </div>
              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('termin.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
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
@include('transaksi.belanja.subtermin.popup.modal_cari_kegiatan')
@endsection