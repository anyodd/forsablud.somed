@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Kontrak</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('kontrak.update', $data->id_contr) }}" method="post" class="form-horizontal">
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
                  <label for="unitKerja" class="col-sm-2 col-form-label">Unit Kerja</label>
                    <div class="col-sm">
                      <input type="text" name="UnitKerja" class="form-control @error('UnitKerja') is-invalid @enderror" id="unitKerja" value="{{ nm_unit() }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                  <label for="unitKerja" class="col-sm-2 col-form-label">Tahun</label>
                    <div class="col-sm">
                      <input type="text" name="Ko_Period" class="form-control @error('Ko_Period') is-invalid @enderror" id="unitKerja" value="{{ Tahun() }}" readonly>
                    </div>
                </div>
                <hr>   
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Dokumen Kontrak</label>
                  <div class="col-sm">
                    <input type="text" name="No_contr" class="form-control @error('No_contr') is-invalid @enderror" value="{{old('No_contr',$data->No_contr)}}" placeholder="Masukan Nomor Dokumen">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian Kontrak</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_contr" class="form-control @error('Ur_contr') is-invalid @enderror" value="{{old('Ur_contr',$data->Ur_contr)}}" placeholder="Masukan Uraian Kontrak">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Kontrak</label>
                  <div class="col-sm">
                    <input type="date" name="dt_contr" class="form-control @error('dt_contr') is-invalid @enderror" value="{{old('dt_contr',$data->dt_contr)}}" placeholder="Masukan Tanggal Kontrak" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama PPK</label>
                  <div class="col-sm">
                    {{-- <input type="text" name="nm_ppk" class="form-control @error('nm_ppk') is-invalid @enderror" value="{{old('nm_ppk',$data->nm_ppk)}}" placeholder="Masukan Nama PPK"> --}}
                    <select class="form-control select2  @error('nm_ppk') is-invalid @enderror" name="nm_ppk">
                      @foreach ($pegawai as $ls)
                        @if ($ls->nama != $data->nm_ppk)
                          @if ($loop->first)
                          <option value="{{$data->nm_ppk}}">{{$data->nm_ppk}}</option>
                          @endif
                        @endif
                          <option value="{{$ls->nama}}" {{$ls->nama == $data->nm_ppk ? 'selected' : ''}}>{{$ls->nama}} ({{$ls->jabatan}})</option>
                      @endforeach
                  </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Penyedia</label>
                  <div class="col-sm">
                    <select name="nm_BU" class="form-control select2 @error('nm_BU') is-invalid @enderror">
                      <option value="" selected>-- Pilih Rekanan --</option>
                      @foreach ($rekanan as $item)
                          <option value="{{$item->id_rekan}}" {{$item->id_rekan == $data->nm_BU ? 'selected' : ''}}>{{$item->rekan_nm}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('kontrak.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
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