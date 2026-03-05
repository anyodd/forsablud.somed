@extends('layouts.template')
@section('style') @endsection

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kasawal.index') }}">Data Kas Awal/UP</a></li>
    <li class="breadcrumb-item"><a href="javascript:history.back()">Detail Rincian</a></li>
    <li class="breadcrumb-item active pull-right" aria-current="page">Edit Detail Rincian</li>
  </ol>
</nav>

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Kas Awal/UP - Nomor SPP : {{ $kasawal->No_spi }}</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('kasawal.update', $kasawal->id) }}" method="post">
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
                  <label for="" class="col-sm-2 col-form-label">Unit Kerja</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" name="Ko_unitstr" class="form-control @error('Ko_unitstr') is-invalid @enderror" value="{{ old('Ko_unitstr', $kasawal->Ko_unitstr) }}" readonly>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">No Pengajuan</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col-sm">
                    <input type="text" name="No_spi" class="form-control @error('No_SPi') is-invalid @enderror" value="{{ old('No_spi', $kasawal->No_spi) }}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="kodePenetapanApbd1" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                    <label for="" class="col-form-label">:</label>
                    <div class="col-sm-4">
                      <input type="text" name="spirc_Rp" class="form-control @error('spirc_Rp') is-invalid @enderror" value="{{ old('spirc_Rp', $kasawal->spirc_Rp) }}" placeholder="Masukkan Nilai (Rp)">
                    </div>
                </div>
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('kasawal.index') }}" class="col-sm-2 btn btn-danger ml-3">
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
        let x = document.querySelectorAll(".myDIV");
        for (let i = 0, len = x.length; i < len; i++) {
            let num = Number(x[i].innerHTML)
                      .toLocaleString('en');
            x[i].innerHTML = num;
            x[i].classList.add("currSign");
        }
</script>
@endsection