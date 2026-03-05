@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col">
				<div class="card shadow-lg mt-2">
					<div class="card-header bg-info py-2">
						<h5 class="card-title font-weight-bold">Tambah Kegiatan</h5> 
					</div>

					<div class="card-body px-2 py-2">

						<form action="{{ route('setkegiatan.store') }}" method="post" class="form-horizontal">
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
									<label for="" class="col-sm-2 col-form-label">Bidang</label>
									@if(getUser('user_level') == 1)
									<div class="col-sm">
										<select name="ko_unit1" class="form-control select2 @error('ko_unit1') is-invalid @enderror" id="ko_unit1">
											<option value="" selected disabled="">-- pilih Bidang --</option>
											@foreach($bidang as $number => $bidang)
											@if (old('ko_unit1', kd_bidang()) == $bidang->ko_unit1)
											<option value="{{ $bidang->ko_unit1 }}" selected>{{ $bidang->ko_unit1 }} - {{ $bidang->ur_subunit1 }}</option>
											@else
											<option value="{{ $bidang->ko_unit1 }}">{{ $bidang->ko_unit1 }} - {{ $bidang->ur_subunit1 }}</option>
											@endif
											@endforeach
										</select>
									</div>
									@else
									<div class="col-sm-2">
										<input type="text" value="{{ kd_bidang() }}" name="ko_unit1" class="form-control @error('ko_unit1') is-invalid @enderror" readonly="">
									</div>
									<div class="col-sm">
										<input type="text" value="{{ nm_bidang() }}" name="" class="form-control" readonly="">
									</div>
									@endif
									
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Kegiatan</label>
									<div class="col-sm">
										<select name="Ko_sKeg1" class="form-control select2 @error('Ko_sKeg1') is-invalid @enderror" id="Ko_sKeg1">
											<option value="" selected disabled="">-- pilih Kode/Kegiatan --</option>
											@foreach($skeg as $number => $skeg)
											<option value="{{ $skeg->Ko_sKeg1 }},{{ $skeg->Ur_sKeg }},{{ $skeg->id_sub_keg }}">{{ $skeg->Ko_sKeg1 }} - {{ $skeg->Ur_sKeg }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Sumber Dana</label>
									<div class="col-sm-3">
										<select name="ko_dana" class="form-control select2 @error('ko_dana') is-invalid @enderror" id="ko_dana">
											<option value="" selected disabled>-- Pilih Sumber Dana --</option>
											@if (old('ko_dana') == 1)
											<option value="1" selected="">APBD</option>
											<option value="2">BLUD</option>
											@elseif (old('ko_dana') == 2)
											<option value="1">APBD</option>
											<option value="2" selected="">BLUD</option>
											@else
											<option value="1">APBD</option>
											<option value="2">BLUD</option>
											@endif
										</select>
									</div>
								</div>


								<div class="form-group row justify-content-center mt-3">
									<button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
										<i class="far fa-save pr-2"></i>Simpan
									</button>
									<a href="{{ route('setkegiatan.index') }}" class="col-sm-2 btn btn-danger ml-3">
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