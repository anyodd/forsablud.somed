@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Setor Pajak</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('setorpajak.update', $pajak->id_taxtor) }}" method="post" class="form-horizontal">
              @csrf
              @method('PUT')
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
                  <label for="" class="col-sm-2 col-form-label">Kode Billing</label>
                  <div class="col-sm">
                    <input type="text" name="No_bill" class="form-control @error('No_bill') is-invalid @enderror" value="{{ old('No_bill', $pajak->No_bill) }}" placeholder="Kode Billing">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">No. NTPN</label>
                  <div class="col-sm">
                    <input type="text" name="No_ntpn" class="form-control @error('No_ntpn') is-invalid @enderror" value="{{ old('No_ntpn', $pajak->No_ntpn) }}" placeholder="Nomor Transaksi Penerimaan Negara">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Rekanan</label>
                  <div class="col-sm">
                    <select class="form-control select2" name="id_rekan">
                      <option value="" selected>-- Pilih Rekanan --</option>
                      @foreach ($rekanan as $item)
                          <option value="{{$item->id_rekan}}"{{$item->id_rekan == $pajak->id_rekan ? 'selected' : ''}}>{{$item->rekan_nm}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm">
                    <input type="date" name="dt_taxtor" class="form-control @error('dt_taxtor') is-invalid @enderror" value="{{ old('dt_taxtor', $pajak->dt_taxtor) }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_taxtor" class="form-control @error('Ur_taxtor') is-invalid @enderror" value="{{ old('Ur_taxtor', $pajak->Ur_taxtor) }}" placeholder="Uraian">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Jenis Pajak</label>
                  <div class="col-sm">
                    <div class="input-group">
                      <input type="text" class="form-control @error('Ko_Rkk') is-invalid @enderror" id="Ko_Rkk" name="Ko_Rkk" value="{{$pajak->Ko_Rkk}}">
                      <span class="input-group-append">
                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_rekening">Cari!</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Bank</label>
                  <div class="col-sm">
                    <select class="form-control select2" name="Ko_Bank">
                      <option value="" selected>-- Pilih Bank --</option>
                      @foreach ($bank as $item)
                          <option value="{{$item->Ko_Bank}}"{{$item->Ko_Bank == $pajak->Ko_Bank ? 'selected' : ''}}>{{$item->No_Rek}} - {{$item->Ur_Bank}}
                          @if ($item->Tag == 1)
                            (Rekening Utama)
                          @elseif($item->Tag == 2)
                            (Rekening Bendahara Pengeluaran)
                          @elseif($item->Tag == 3)
                            (Rekening Bendahara Penerimaan)
                          @endif
                          </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('setorpajak.index') }}" class="col-sm-2 btn btn-danger ml-3">
                  <i class="fas fa-backward pr-2"></i>Kembali
                </a> 
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  @include('pembukuan.setorpajak.popup.rekening')
</section>  

@endsection

@section('script')  
<script>
  $(function () {
    $('.select2').select2();
  });
</script>
<script>
  $(function () {
      $(document).on('click', '#pilihrek', function() {
      var kd_r = $(this).data('kd_rek');
      $('#Ko_Rkk').val(kd_r);
  });

  $(document).on('click', '#btnback', function () {
      location.reload();
    });
  })
</script>
@endsection