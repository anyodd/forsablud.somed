@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data Penerimaan</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('penerimaan.update', $penerimaan[0]->id_bp) }}" method="post">
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
                <input type="text" class="form-control" name="IdBp" value="{{ $penerimaan[0]->id_bp }}" disabled hidden>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Bukti/Klaim</label>
                  <div class="col-sm">
                    <input type="text" id="NoBp" name="NoBp" class="form-control" value="{{ $penerimaan[0]->No_bp }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Bukti/Klaim</label>
                  <div class="col-sm">
                    <input type="date" id="DtBp" name="DtBp" class="form-control" value="{{ date('Y-m-d',strtotime($penerimaan[0]->dt_bp)) }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                    <input type="text" id="UrBp" name="UrBp" class="form-control" value="{{ $penerimaan[0]->Ur_bp }}" placeholder="Keterangan Transaksi">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pihak Lain</label>
                  <div class="col-sm">
                    <input type="text" id="NmBuContr" name="NmBuContr" class="form-control" value="{{ $penerimaan[0]->nm_BUcontr }}" placeholder="Isikan Nama Pihak Lain">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat Pihak Lain</label>
                  <div class="col-sm">
                  <input type="text" id="AdrBuContr" name="AdrBuContr" class="form-control" value="{{ $penerimaan[0]->adr_bucontr }}" placeholder="Isikan Alamat Pihak Lain">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Jenis Penerimaan</label>
                  <div class="col-sm">
                    <select name="KoBp" id="" class="form-control">
                      <option value="" selected>-- Pilih --</option>
                      <option value="1" {{$penerimaan[0]->Ko_bp == '1' ? 'selected' : ''}}>Penerimaan Tahun Berjalan</option>
                      <option value="11"{{$penerimaan[0]->Ko_bp == '11' ? 'selected' : ''}}>Penerimaan Piutang Tahun Lalu</option>
                      <option value="42"{{$penerimaan[0]->Ko_bp == '42' ? 'selected' : ''}}>Penerimaan Diterima Dimuka</option>
                      <option value="43"{{$penerimaan[0]->Ko_bp == '43' ? 'selected' : ''}}>Pengakuan Pendapatan Diterima Dimuka</option>
                    </select>
                  </div>
                </div>
      

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('penerimaan.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
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