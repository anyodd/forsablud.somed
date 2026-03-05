@extends('layouts.template')

@section('content')

@include('pengajuan.lsnonkontrakutang.popup.modal_bukti_lsnonkontrakutang')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lsnonkontrakutang.index') }}">LS Tagihan</a></li>
    <li class="breadcrumb-item active pull-right" aria-current="page">Tambah Rincian LS Tagihan</li>
  </ol>
</nav>

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Rincian LS Tagihan</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('lsnonkontrakutang.tambahrincian')}}" method="post">
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
                <div class="card">
                  
                    <div class="card-body card-info">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nomor SPP</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="No_spi" class="form-control @error('No_SPi') is-invalid @enderror" value="{{ old('No_SPi', $lsnonkontrakutang->No_SPi) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">No. Rincian</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="Ko_spirc" class="form-control @error('Ko_spirc') is-invalid @enderror" value="{{ $norincian }}" placeholder="No. Rincian" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nomor Tagihan</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalBuktiLsnonkontrakutang">Pilih.....</button>
                                        </span>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="No_bp" class="form-control @error('No_bp') is-invalid @enderror" id="sNo_bp" value="{{old('No_bp')  }}" placeholder="Nomor Tagihan" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Kegiatan</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="Ko_sKeg1" class="form-control @error('Ko_sKeg1') is-invalid @enderror" id="sKo_sKeg1" value="{{ old('Ko_sKeg1') }}" hidden>
                                        <input type="text" name="Ko_sKeg2" class="form-control @error('Ko_sKeg2') is-invalid @enderror" id="sKo_sKeg2" value="{{ old('Ko_sKeg2') }}" hidden>
                                        <input type="text" class="form-control" id="kegiatan"  placeholder="Kegiatan" readonly>
                                    </div>
                                    <label for="" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Kode Akun</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="Ko_Rkk" class="form-control @error('Ko_Rkk') is-invalid @enderror" id="sKo_Rkk" value="{{ old('Ko_Rkk') }}" placeholder="Kode Akun" hidden>
                                        <input type="text" class="form-control" id="urkk"  placeholder="Kode Akun" readonly>
                                    </div>
                                    <label for="" class="col-sm col-form-label">Nama Akun</label>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Uraian</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="Ur_bprc" class="form-control @error('Ur_bprc') is-invalid @enderror" id="sUr_bprc" value="{{ old('Ur_bprc') }}" placeholder="Uraian Bukti" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="spirc_Rp" class="form-control @error('spirc_Rp') is-invalid @enderror" id="sspirc_Rp" value="{{ old('spirc_Rp') }}"  placeholder="Nilai (Rp)" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer-->
                    <div class="form-group row justify-content-center mt-3">
                        <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                        <i class="far fa-save pr-2"></i>Simpan
                        </button>
                        <a href="{{ route('lsnonkontrakutang.index') }}" class="col-sm-2 btn btn-danger ml-3">
                        <i class="fas fa-backward pr-2"></i>Kembali
                        </a> 
                    </div>
                </div>
                <!-- /.card -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>   

@endsection

@section('script')

@endsection