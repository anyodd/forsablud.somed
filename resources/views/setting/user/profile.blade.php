@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card mt-4">
        @if (getUser('user_level') == 1)
        <form action="{{ route('user_change', getUser('user_id')) }}" method="POST">
            @method("PUT")
            @csrf
            <div class="card-header bg-primary">
                <h5 class="card-title font-weight-bold">User Profil</h5> 
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Nama Pegawai</label>
                    <div class="col-sm-6">
                        <p class="col-sm-0 col-form-label">{{ getBidang() }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <p class="col-sm-0 col-form-label">{{ $dt->email }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Ganti Password</label>
                    <div class="col-sm-4">
                        <input type="password" name="password" class="form-control"required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary float-right"><i class="far fa-save"></i> Simpan</button>
                <a href="{{ route('home') }}" class="btn btn-outline-danger float-right mx-2"><i class="fas fa-times"></i> Close</a>
            </div>
        </form>
        @else
        <form action="{{ route('user_change', getUser('user_id')) }}" method="POST">
            @method("PUT")
            @csrf
            <div class="card-header bg-primary">
                <h5 class="card-title font-weight-bold">User Profil</h5> 
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Nama Pegawai</label>
                    <div class="col-sm-6">
                        <p class="col-sm-0 col-form-label">{{ $dt->nama }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <p class="col-sm-0 col-form-label">{{ $dt->email }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Ganti Password</label>
                    <div class="col-sm-4">
                        <input type="password" name="password" class="form-control"required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary float-right"><i class="far fa-save"></i> Simpan</button>
                <a href="{{ route('home') }}" class="btn btn-outline-danger float-right mx-2"><i class="fas fa-times"></i> Close</a>
            </div>
        </form>
        @endif
        </div>
      </div>
    </div>
  </div>
</section>  

@endsection
