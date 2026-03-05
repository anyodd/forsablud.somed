@extends('layouts.template')

@section('content')
<section class="content px-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-info">
						<h5 class="card-title font-weight-bold">Laporan RKA/RKAP</h5>  
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<form id="form-cetak" action="{{ route('laporan.perencanaan.cetak-rka.rptrka') }}" method="GET"
									target="_blank">
									@csrf
									<div class="form-group row">
										<label for="tahun" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Tahun Anggaran </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::text('tahun', $tahun, [
												'class' => 'form-control',
												'id' => 'tahun',
												'readonly' => 'readonly',
											]) !!}
										</div>
										 <div class="col-sm-1">
											<input class="form-control" type="checkbox" name="rkaperubahan_check"
												value="perubahan">
										</div>
										<label for="rkaperubahan_name" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left"> RKA Perubahan</label>
									</div>
									<div class="form-group row">
										<label for="jenis_laporan" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Jenis Laporan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::select('jenis_laporan', $jnslap, 1, [
												'class' => 'form-control select2',
												'id' => 'jenis_laporan',
											]) !!}
										</div>
									</div>
									{{--<div class="form-group row">
										<label for="idskpd" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">SKPD </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idskpd" id="idskpd" class="form-control select2">
												<option value="">Pilih SKPD</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="idunit" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Unit </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idunit" id="idunit" class="form-control select2">
												<option value="">Pilih Unit</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="idsubunit" class="col-sm-2 col-form-label font-weight-semibold" style="text-align: left">Sub Unit </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idsubunit" id="idsubunit" class="form-control select2" disabled="disabled">
												<option value="">Pilih Sub Unit</option>
											</select>
										</div>
									</div>--}}
									{{-- <div class="form-group row">
										<label for="idbidang" class="col-sm-2 col-form-label font-weight-semibold" style="text-align: left">Urasan Bidang Pemerintahan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											{!! Form::select('idbidang', $bidang, null, [
												'class' => 'form-control select2',
												'id' => 'idbidang',
											]) !!}
										</div>
									</div> --}}
									<div class="form-group row">
										<label for="idprogram" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Program </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idprogram" id="idprogram" class="form-control select2"
												disabled="disabled">
												<option value="">Pilih Program RKA</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="idkegiatan" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Kegiatan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idkegiatan" id="idkegiatan" class="form-control select2"
												disabled="disabled">
												<option value="">Pilih Kegiatan RKA</option>
											</select>
										</div>
									</div>
									{{--<div class="form-group row">
										<label for="idsubkegiatan" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Sub Kegiatan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-8">
											<select name="idsubkegiatan" id="idsubkegiatan" class="form-control select2"
												disabled="disabled">
												<option value="">Pilih Sub Kegiatan RKA</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="kota_ttd" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Kota </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::text('kota_ttd', $nmibukota, [
												'class' => 'form-control',
												'id' => 'kota_ttd',
											]) !!}
										</div>
									</div>--}}
									<div class="form-group row">
										<label for="tgl_ttd" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Tanggal Tanda Tangan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::date('tgl_ttd', date('Y-m-d'), [
												'class' => 'form-control datepicker',
												'id' => 'tgl_ttd',
											]) !!}
										</div>
									</div>
									{{--<div class="form-group row">
										<label for="nama_ttd" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Nama Penandatangan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::text('nama_ttd', '', [
												'class' => 'form-control',
												'id' => 'nama_ttd',
											]) !!}
										</div>
									</div>
									<div class="form-group row">
										<label for="jabatan_ttd" class="col-sm-2 col-form-label font-weight-semibold"
											style="text-align: left">Jabatan Penandatangan </label>
										<div class="col-sm-1 text-right p-2">:</div>
										<div class="col-sm-4">
											{!! Form::text('jabatan_ttd', '', [
												'class' => 'form-control',
												'id' => 'jabatan_ttd',
											]) !!}
										</div>
									</div>--}}
									<hr>
									<div class="form-group row">
										<label for="jenis" class="col-sm-3 col-form-label font-weight-semibold"></label>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-danger pr-4 btn-lg" name="btnsubmit"
												id="btnsubmit"><i class="fa fa-file-pdf"></i> Cetak Laporan</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> 
@endsection

@push('scripts_end')
    <script type="text/javascript">
        $(function() {
            function getProgram(id) {
                var url = '{!! route('laporan.perencanaan.cetak-rka.selectProgram', ':id') !!}';
                var target = $('select[name="idprogram"]');

                if ($(this).data('url')) {
                    url = $(this).data('url');
                };
                $.get(url.replace(':id', id), {
                    code: $(this).data('code')
                }, function(response) {
                    if (target.hasClass('select2-hidden-accessible')) {
                        target.select2('destroy');
                    };
                    target.html('<option value="-1">Pilih Program RKA</option>');
                    $.each(response.refprogram, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        };
                    });
                    if (target.hasClass('select2')) {
                        initSelect2();
                    }
                    target.trigger('change');
                });
            };

            function getKegiatan(id) {
                var url = '{!! route('laporan.perencanaan.cetak-rka.selectKegiatan', ':id') !!}';
                var target = $('select[name="idkegiatan"]');

                if ($(this).data('url')) {
                    url = $(this).data('url');
                };
                $.get(url.replace(':id', id), {
                    code: $(this).data('code')
                }, function(response) {
                    if (target.hasClass('select2-hidden-accessible')) {
                        target.select2('destroy');
                    };
                    target.html('<option value="-1">Pilih Kegiatan RKA</option>');
                    $.each(response.refkegiatan, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        };
                    });
                    if (target.hasClass('select2')) {
                        initSelect2();
                    }
                    target.trigger('change');
                });
            };

            function getSubKegiatan(id) {
                var url = '{!! route('laporan.perencanaan.cetak-rka.selectSubKegiatan', ':id') !!}';
                var target = $('select[name="idsubkegiatan"]');

                if ($(this).data('url')) {
                    url = $(this).data('url');
                };
                // showLoading();
                $.get(url.replace(':id', id), {
                    code: $(this).data('code')
                }, function(response) {
                    if (target.hasClass('select2-hidden-accessible')) {
                        target.select2('destroy');
                    };
                    target.html('<option value="-1">Pilih Sub Kegiatan RKA</option>');
                    $.each(response.refsubkegiatan, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        };
                    });
                    if (target.hasClass('select2')) {
                        initSelect2();
                    }
                    target.trigger('change');
                });
            };

            $(document).on('change', 'select[name="idprogram"]', function(event) {
                var elm = $(this);
                var id = elm.val();
                getKegiatan(id);
            });

            $(document).on('blur', 'select[name="idprogram"]', function(event) {
                var elm = $(this);
                var id = elm.val();
                getKegiatan(id);
            });

            $(document).on('change', 'select[name="idkegiatan"]', function(event) {
                var elm = $(this);
                var id = elm.val();
                getSubKegiatan(id);
            });

            $(document).on('blur', 'select[name="idkegiatan"]', function(event) {
                var elm = $(this);
                var id = elm.val();
                getSubKegiatan(id);
            });

            //script on change di pilih laporan, ketika pilih laporan 1 maka Pilih program menjadi disabled
            $(document).on('change', 'select[name="jenis_laporan"]', function(event, data) {
                var elm = $(this);
                var id = elm.val();
				var elmthn = $('select[name="tahun"]');
				var u = elmthn.val();

                var x = document.getElementById("idprogram");
                var y = document.getElementById("idkegiatan");
                // z = document.getElementById("idsubkegiatan");

                if (id == 1) {
                    x.disabled = true;
                    y.disabled = true;
                    //z.disabled = true;
                }
                if (id == 2 || id == 3 || id == 4 || id == 6) {
                    x.disabled = true;
                    y.disabled = true;
                    //z.disabled = true;
                }
                if (id == 5) {
                    x.disabled = false;
                    y.disabled = false;
                    //z.disabled = false;
                    getProgram(id);
                }
            });
            //tutup script on change

        });
    </script>
@endpush
