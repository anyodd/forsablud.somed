@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Saran/Masukan</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('saran.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Nama Menu/Sub Menu</label>
                  <div class="col-sm">
                    <select name="menu" class="form-control select2 @error('menu') is-invalid @enderror">
                      <option value="" selected disabled="">-- pilih Menu --</option>
                      @foreach($menu as $number => $menu)
                      @if (old('menu') == $menu->ur_menu)
                      <option value="{{ $menu->ur_menu }}" selected="">{{ $menu->ur_menu }}</option>
                      @else
                      <option value="{{ $menu->ur_menu }}">{{ $menu->ur_menu }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Kondisi</label>
                  <div class="col-sm">
                    <textarea class="form-control @error('kondisi') is-invalid @enderror" id="kondisi" rows="3" name="kondisi" placeholder="Kondisi saat ini">{{ old('kondisi') }}</textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Pesan Error</label>
                  <div class="col-sm">
                    <textarea class="form-control @error('pesan_error') is-invalid @enderror" id="pesan_error" rows="3" name="pesan_error" placeholder="Pesan error">{{ old('pesan_error') }}</textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Saran/Masukan</label>
                  <div class="col-sm">
                    <textarea class="form-control @error('saran') is-invalid @enderror" id="saran" rows="3" name="saran" placeholder="Saran/Masukan">{{ old('saran') }}</textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor HP (Whatsapp)</label>
                  <div class="col-sm-3">
                    <input type="text" name="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp') }}" placeholder="Nomor Telp/HP">
                  </div>
                </div>
                
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('saran.index') }}" class="col-sm-2 btn btn-danger ml-3">
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