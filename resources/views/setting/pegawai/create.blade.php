@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Pegawai</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('pegawai.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_pjb" class="form-control @error('Nm_pjb') is-invalid @enderror" value="{{ old('Nm_pjb') }}" placeholder="Nama">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP</label>
                  <div class="col-sm-4">
                    <input type="text" name="NIP_pjb" maxlength="21" class="form-control @error('NIP_pjb') is-invalid @enderror" value="{{ old('NIP_pjb') }}" placeholder="NIP tanpa spasi">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Jabatan</label>
                  <div class="col-sm">
                    <select name="id_pj" class="form-control select2 @error('id_pj') is-invalid @enderror">
                      <option value="" selected disabled="">-- pilih Jabatan --</option>
                      @foreach($jabatan as $number => $jabatan)
                      @if (old('id_pj') == $jabatan->id_pj)
                      <option value="{{ $jabatan->id_pj }}" selected="">{{ $jabatan->Ur_pj }}</option>
                      @else
                      <option value="{{ $jabatan->id_pj }}">{{ $jabatan->Ur_pj }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Bidang</label>
                  <div class="col-sm">
                    <select name="kd_bidang" class="form-control select2 @error('kd_bidang') is-invalid @enderror">
                      <option value="" selected disabled="">-- pilih Bidang --</option>
                      @foreach($bidang as $number => $bidang)
                      @if (old('kd_bidang') == $bidang->ko_unit1)
                      <option value="{{ $bidang->ko_unit1 }}" selected="">{{ $bidang->ko_unit1}} - {{ $bidang->ur_subunit1 }}</option>
                      @else
                      <option value="{{ $bidang->ko_unit1 }}">{{ $bidang->ko_unit1}} - {{ $bidang->ur_subunit1 }}</option>
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
                <a href="{{ route('pegawai.index') }}" class="col-sm-2 btn btn-danger ml-3">
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
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
@endsection