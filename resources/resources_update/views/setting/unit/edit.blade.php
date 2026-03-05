@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Unit</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('unit.update', $tbunit->id) }}" method="post">
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
                  <label for="" class="col-sm-2 col-form-label">Unit</label>
                  <div class="col-sm">
                    <select id="Ko_Unit" name="Ko_Unit" class="form-control" disabled>
                      @foreach($unit as $item)
                      @if (old('Ko_Unit', $tbunit->Ko_Unit ) == $item->Ko_Unit && $tbunit->Ko_Urus == $item->Ko_Urus && $tbunit->Ko_Bid == $item->Ko_Bid)
                      <option value="{{ $item->Ko_Unit }}" selected>{{ $item->Ur_Unit }}</option>
                      @else
                      <option value="{{ $item->Ko_Unit }}">{{ $item->Ur_Unit }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Jln" class="form-control @error('Nm_Jln') is-invalid @enderror" value="{{ old('Nm_Jln', $tbunit->Nm_Jln) }}" placeholder="Alamat">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kepala Unit</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Pimp" class="form-control @error('Nm_Pimp') is-invalid @enderror" value="{{ old('Nm_Pimp', $tbunit->Nm_Pimp) }}" placeholder="Nama Kepala Unit">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kepala Unit</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Pimp" class="form-control @error('NIP_Pimp') is-invalid @enderror" value="{{ old('NIP_Pimp', $tbunit->NIP_Pimp) }}" placeholder="NIP Kepala Unit">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kabag Keuangan</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Keu" class="form-control @error('Nm_Keu') is-invalid @enderror" value="{{ old('Nm_Keu', $tbunit->Nm_Keu) }}" placeholder="Nama Kabag Keuangan">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kabag Keuangan</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Keu" class="form-control @error('NIP_Keu') is-invalid @enderror" value="{{ old('NIP_Keu', $tbunit->NIP_Keu) }}" placeholder="NIP Kabag Keuangan">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bendahara</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Bend" class="form-control @error('Nm_Bend') is-invalid @enderror" value="{{ old('Nm_Bend', $tbunit->Nm_Bend) }}" placeholder="Nama Bendahara">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Bendahara</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Bend" class="form-control @error('NIP_Bend') is-invalid @enderror" value="{{ old('NIP_Bend', $tbunit->NIP_Bend) }}" placeholder="NIP Bendahara">
                  </div>
                </div>

                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  <a href="{{ route('unit.index') }}" class="col-sm-2 btn btn-danger ml-3">
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