@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Tagihan</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('tagihan.update',$data->id_bp) }}" method="post" class="form-horizontal">
              @csrf
              @method('PUT')
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
                  <label for="" class="col-sm-2 col-form-label">Nomor Tagihan/Faktur</label>
                  <div class="col-sm">
                    <input type="text" name="NoBp" class="form-control @error('NoBp') is-invalid @enderror" value="{{old('NoBp', $data->No_bp)}}" placeholder="Masukan Nomor Dokumen">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Tagihan/Faktur</label>
                  <div class="col-sm">
                    <input type="date" name="DtBp" class="form-control @error('DtBp') is-invalid @enderror" value="{{old('DtBp', $data->dt_bp)}}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Jatuh Tempo</label>
                  <div class="col-sm">
                    <input type="date" name="DtJt" class="form-control @error('DtJt') is-invalid @enderror" value="{{old('DtJt', $data->dt_jt)}}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                    <input type="text" name="UrBp" class="form-control @error('UrBp') is-invalid @enderror" value="{{old('UrBp', $data->Ur_bp)}}" placeholder="Keterangan Transaksi">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pihak Lain</label>
                  <div class="col-sm">
                    <select name="NmBuContr" class="form-control select2 @error('NmBuContr') is-invalid @enderror">
                      <option value="" selected>-- Pilih Rekanan --</option>
                      @foreach ($rekanan as $item)
                          <option value="{{$item->id_rekan}}" {{$item->id_rekan == $data->nm_BUcontr ? 'selected' : ''}}>{{$item->rekan_nm}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('tagihan.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
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


@endsection

@section('script')  
<script>
  $(function () {
    $('.select2').select2();
  })
</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

@endsection