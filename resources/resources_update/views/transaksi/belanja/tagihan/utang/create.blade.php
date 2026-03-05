@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Tagihan (Utang)</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <form action="{{ route('tagihanlalu.store') }}" method="post" class="form-horizontal">
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
           
              <div class="card-body">
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Tagihan</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalSaldoUtang">Pilih.....</button>
                    </span>
                  </div>
                  <div class="col-sm-9">
                      <input type="text" name="No_bp" class="form-control " id="No_bp" value="" placeholder="Nomor Tagihan" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Tagihan</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm-3">
                      <input type="text" name="DtBp" class="form-control " id="DtBp" value="" placeholder="Tanggal Tagihan" readonly>
                  </div>
                  <label for="" class="col-sm-2 col-form-label">Tanggal Jatuh Tempo</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm-3">
                    <input type="text" name="DtJt" class="form-control " id="DtJt" value="" placeholder="Jatuh Tempo Tagihan" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" name="UrBp" id="UrBp" class="form-control @error('UrBp') is-invalid @enderror" value="{{old('UrBp')}}" placeholder="Keterangan Transaksi" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Kegiatan</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm-3">
                    <input type="text" name="Ko_sKeg1" class="form-control " id="Ko_sKeg1" value="" placeholder="Kode Kegiatan" readonly>
                  </div>
                  <div class="col-sm-3">
                    <input type="text" name="Ko_sKeg2" class="form-control " id="Ko_sKeg2" value="" placeholder="Kode Kegiatan" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label"></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Keg" class="form-control " id="Ur_Keg" value="" placeholder="Uraian Kegiatan" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Akun Rekening</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm-6">
                      <input type="text" name="Ko_Rkk" class="form-control" id="Ko_Rkk" value="" placeholder="Kode Rekening" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label"></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Rkk" class="form-control " id="Ur_Rkk" value="" placeholder="Uraian Rekening" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nilai</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm-2">
                    <input type="text" name="To_Rp" id="To_Rp" class="form-control text-right" value="" placeholder="Nilai (Rp)">
                  </div>
                </div>
                <div class="form-group row" id="pilih_bu" hidden>
                  <label for="" class="col-sm-2 col-form-label">Nama Pihak Lain</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <select name="NmBuContr" id="NmBuContr" class="form-control select2 @error('NmBuContr') is-invalid @enderror" required disabled>
                      <option value="" selected>-- Pilih Rekanan --</option>
                      @foreach ($rekanan as $item)
                          <option value="{{$item->id_rekan}}">{{$item->rekan_nm}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row" id="isi_bu">
                  <label for="" class="col-sm-2 col-form-label">Nama Pihak Lain</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" id="NmBuContr_isi" class="form-control @error('NmBuContr') is-invalid @enderror" value="{{old('NmBuContr')}}" placeholder="Nama Pihak Lain" readonly>
                    <input type="text" name="NmBuContr" id="NmBuContr_val" class="form-control @error('NmBuContr') is-invalid @enderror" value="{{old('NmBuContr')}}" placeholder="Nama Pihak Lain" hidden>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Ko_kas" class="col-sm-2 col-form-label">Cara Pembayaran</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                      <select id="Ko_kas" name="Ko_kas" value="{{old('Ko_kas')}}" class="form-control select2 select2-danger @error('Ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;" autofocus>
                          <option value="0">--Pilih Cara Pembayaran--</option>
                          <option value="1" selected>Pindah Buku</option>
                          <option value="2">Tunai Fisik</option>
                      </select>
                  </div>
                </div>
                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  {{-- <a href="{{ route('tagihanlalu.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3"> --}}
                  <a href="{{ route('tagihanlalu.index') }}" class="col-sm-2 btn btn-danger ml-3">
                    <i class="fas fa-backward pr-2"></i>Kembali
                  </a> 
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  
@include('transaksi.belanja.tagihan.utang.popup.saldo_utang');
@endsection

@section('script')  
<script>
  $(function () {
    $('.select2').select2();
  })
</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

@endsection