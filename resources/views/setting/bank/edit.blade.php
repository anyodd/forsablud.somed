@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Bank</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('bank.update', $bank->Ko_Bank) }}" method="post">
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
                  {{-- <label for="" class="col-sm-2 col-form-label">Kode Bank</label> --}}
                  <div class="col-sm-1">
                    <input type="text" class="form-control" value="{{ $bank->Ko_Bank }}" hidden>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bank</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Bank" class="form-control" value="{{ $bank->Ur_Bank }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Rekening</label>
                  <div class="col-sm">
                    <input type="text" name="No_Rek" class="form-control" value="{{ $bank->No_Rek }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm">
                    <select id="Tag" name="Tag" class="form-control" >
                      @if (old('Tag', $bank->Tag ) == 1)
                      <option value=1 selected>Rekening Utama</option>
                      <option value=2>Rekening Bendahara Pengeluaran</option>
                      <option value=3>Rekening Bendahara Penerimaan</option>
                      @elseif (old('Tag', $bank->Tag ) == 2)
                      <option value=1>Rekening Utama</option>
                      <option value=2 selected>Rekening Bendahara Pengeluaran</option>
                      <option value=3>Rekening Bendahara Penerimaan</option>
                      @else
                      <option value=1>Rekening Utama</option>
                      <option value=2>Rekening Bendahara Pengeluaran</option>
                      <option value=3 selected>Rekening Bendahara Penerimaan</option>
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  <a href="{{ route('bank.index') }}" class="col-sm-2 btn btn-danger ml-3">
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