@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Rekanan</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('rekanan.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Nama Rekanan</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_nm" class="form-control @error('rekan_nm') is-invalid @enderror" value="{{ old('rekan_nm') }}" placeholder="Nama Rekanan">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor NPWP</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_npwp" class="form-control @error('rekan_npwp') is-invalid @enderror" value="{{ old('rekan_npwp') }}" placeholder="Nomor NPWP">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pemilik Rekening</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_milikbank" class="form-control @error('rekan_milikbank') is-invalid @enderror" value="{{ old('rekan_milikbank') }}" placeholder="Nama Pemilik Rekening">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Rekening Bank</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_rekbank" class="form-control @error('rekan_rekbank') is-invalid @enderror" value="{{ old('rekan_rekbank') }}" placeholder="Rekening Bank">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bank</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_nmbank" class="form-control @error('rekan_nmbank') is-invalid @enderror" value="{{ old('rekan_nmbank') }}" placeholder="Nama Bank">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_adr" class="form-control @error('rekan_adr') is-invalid @enderror" value="{{ old('rekan_adr') }}" placeholder="Alamat">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pimpinan</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_pimp" class="form-control @error('rekan_pimp') is-invalid @enderror" value="{{ old('rekan_pimp') }}" placeholder="Nama Pimpinan">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Telp/HP</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_ph" class="form-control @error('rekan_ph') is-invalid @enderror" value="{{ old('rekan_ph') }}" placeholder="Nomor Telp/HP">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm">
                    <input type="text" name="rekan_mail" class="form-control @error('rekan_mail') is-invalid @enderror" value="{{ old('rekan_mail') }}" placeholder="Email">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Bentuk Perusahaan</label>
                  <div class="col-sm">
                    <select name="ko_usaha" class="form-control select2 @error('ko_usaha') is-invalid @enderror">
                      <option value="" selected disabled="">-- pilih Bentuk Perusahaan --</option>
                      @foreach($pf_usaha as $number => $pf_usaha)
                      @if (old('ko_usaha') == $pf_usaha->ko_usaha)
                      <option value="{{ $pf_usaha->ko_usaha }}" selected="">{{ $pf_usaha->ur_usaha }}</option>
                      @else
                      <option value="{{ $pf_usaha->ko_usaha }}">{{ $pf_usaha->ur_usaha }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('rekanan.index') }}" class="col-sm-2 btn btn-danger ml-3">
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