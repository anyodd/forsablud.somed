@extends('layouts.template')

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Rincian Nomor Bukti : {{ $kasawal->No_SPi }}</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('kasawal.tambahrincian')}}" method="post">
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Unit Kerja</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="" class="form-control @error('Ko_unitstr') is-invalid @enderror" value="{{ old('Ko_unitstr', $kasawal->Ko_unitstr) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nomor Pengajuan</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="No_spi" class="form-control @error('No_SPi') is-invalid @enderror" value="{{ old('No_SPi', $kasawal->No_SPi) }}" readonly>
                                    </div>
                                </div>
								 @foreach ($kasawalold as $number => $kasawalold)
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                    <label for="" class="col-form-label">:</label>
									 @if ($kasawalold->spirc_Rp == NULL)
										<div class="col-sm-4">
											<input type="text" name="spirc_Rp" class="form-control @error('spirc_Rp') is-invalid @enderror" placeholder="Masukan Nilai Kas Awal/UP">
										</div>
									@else 
										@if ($kasawal->Tag_v == 0)
										<div class="col-sm-4">
											<input type="text" name="spirc_Rp" class="form-control @error('spirc_Rp') is-invalid @enderror" value="{{ number_format($kasawalold->spirc_Rp,2,',','.') }}">
										</div>
										@else 
										<div class="col-sm-4">
											<input type="text" name="spirc_Rp" class="form-control @error('spirc_Rp') is-invalid @enderror" value="{{ number_format($kasawalold->spirc_Rp,2,',','.') }}" disabled>
										</div>
										@endif
									@endif
                                    <div class="col-sm" hidden>
                                        <input type="text" name="dt_rftrbprc" class="form-control @error('dt_rftrbprc') is-invalid @enderror" value="{{ old('Dt_SPi', $kasawal->Dt_SPi) }}">
                                    </div>
									<div class="col-sm" hidden>
                                        <input type="text" name="id_spi" class="form-control @error('id_spi') is-invalid @enderror" value="{{ old('id_spi', $kasawal->id) }}">
                                    </div>
                                </div>
								@endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer-->
                    <div class="form-group row justify-content-center mt-3">
                        <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                        <i class="far fa-save pr-2"></i>Simpan
                        </button>
                        <a href="{{ route('kasawal.index') }}" class="col-sm-2 btn btn-danger ml-3">
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