@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Jenis Pelayanan</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('jnslayanan.update', $pmed->ko_pmed) }}" method="post">
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
                  <label for="" class="col-sm-2 col-form-label">Kode Jenis Pelayanan</label>
                  <div class="col-sm-1">
                    <input type="text" class="form-control" value="{{ $pmed->ko_pmed }}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Jenis Pelayanan</label>
                  <div class="col-sm">
                    <input type="text" name="ur_pmed" class="form-control" value="{{ $pmed->ur_pmed }}">
                  </div>
                </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('jnslayanan.index') }}" class="col-sm-2 btn btn-danger ml-3">
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

@section('script')  @endsection