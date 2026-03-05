@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Penyetoran Sisa Kas UP</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('sisaup.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Nomor Penyetoran</label>
                  <div class="col-sm">
                    <input type="text" name="sikas_no" class="form-control" value="" placeholder="Masukan Nomor Dokumen Penyetoran Sisa Kas UP">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Dokumen</label>
                  <div class="col-sm">
                    <input type="date" name="dt_sikas" class="form-control" value="" >
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                    <input type="text" name="sikas_ur" class="form-control" value="" placeholder="Masukan Uraian Penyetoran Sisa Kas">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nilai Penyetoran Kas (Rp)</label>
                  <div class="col-sm">
                  <input type="text" name="sikas_Rp" class="form-control" value="">
                  </div>
                </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('sisaup.index') }}" class="col-sm-2 btn btn-danger ml-3">
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

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>


@endsection