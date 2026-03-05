@extends('layouts.template')

@section('content')
<section class="content px-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-info">
						<h5 class="card-title font-weight-bold">Laporan Akuntansi</h5>  
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<form id="form-cetak" action="{{ route('laporan.pembukuan.cetak-lapkeu.rptpembukuan') }}" method="GET"
									target="_blank">
									@csrf
									<div class="form-group row">
										<div class="col-sm-4">
											<code>Jenis Laporan</code>
											{!! Form::select('jenis_laporan', $jnslap, 0, [
												'class' => 'form-control select2',
												'id' => 'jenis_laporan',
											]) !!}
										</div>
										<div class="col-sm-4">
											<code>Level Rekening</code>
											<select name="idlevelrekening" id="idlevelrekening" class="form-control select2" required>
												<option value="">Pilih Level Rekening</option>
												<option value="2">2 Kelompok</option>
												<option value="3">3 Jenis</option>
												<option value="4">4 Obyek</option>
												<option value="5">5 Rincian Obyek</option>
												<option value="6">6 SubRincian Obyek</option>
											</select>
											
										</div>
										<div class="col-sm-4">
											<code>Program</code>
											<select name="idprogram" id="idprogram" class="form-control select2">
												<option value="">Pilih Program</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<code>Periode Transaksi</code>
											{!! Form::text('tgl_range', $tgl_1 ?? date(Tahun() . '-01-01'), [
												'placeholder' => 'Mulai',
												'class' => 'form-control', //  datepicker
												'id' => 'tgl_range-field',
											]) !!}
											{!! Form::hidden('tgl_1', $tgl_1 ?? date(Tahun() . '-01-01'), [
												'placeholder' => 'Mulai',
												'class' => 'form-control', //  datepicker
												'id' => 'tgl_1-field',
											]) !!}
										</div>
											{!! Form::hidden('tgl_2', $tgl_2 ?? date(Tahun() . '-12-31'), [
												'placeholder' => 'Selesai',
												'class' => 'form-control datepicker',
												'id' => 'tgl_2-field',
											]) !!}
										<div class="col-sm-4">
											<code>Kode Rekening Akun</code>
											{!! Form::select('idkdrek1', $getRek1, null, [
												'placeholder' => 'Pilih Rekening Akun',
												'class' => 'form-control select2',
												'id' => 'idkdrek1',
											]) !!}
										</div>
										<div class="col-sm-4">
											<code>Kegiatan</code>
											<select name="idkegiatan" id="idkegiatan" class="form-control select2">
												<option value="">Pilih Kegiatan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<code>Nomor Jurnal</code>
											{!! Form::select('idjurnalsemua', [], null, [
												'placeholder' => 'Pilih No. Bukti',
												'disabled' => true,
												'class' => 'form-control',
												'id' => 'idjurnalsemua',
												'required',
											]) !!}
										</div>
										<div class="col-sm-4">
											<code>Kode Rekening Kelompok</code>
											<select name="idkdrek2" id="idkdrek2" class="form-control select2">
												<option value="">Pilih Rekening Kelompok</option>
											</select>
										</div>
										<div class="col-sm-4">
											<code>Sub Kegiatan</code>
											<select name="idsubkegiatan" id="idsubkegiatan" class="form-control select2">
												<option value="">Pilih Sub Kegiatan</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<code>Jenis Sumber Dana</code>
											{!! Form::select('idsumberdana', $getRefSumberDana, null, [
												'placeholder' => 'Pilih Sumber Dana',
												'disabled' => true,
												'class' => 'form-control select2',
												'id' => 'idsumberdana-field',
												// 'required',
											]) !!}
										</div>
										<div class="col-sm-4">
											<code>Kode Rekening Jenis</code>
											<select name="idkdrek3" id="idkdrek3" class="form-control select2">
												<option value="">Pilih Rekening Jenis</option>
											</select>
										</div>
										<div class="col-sm-4">

										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											
										</div>
										<div class="col-sm-4">
											<select name="idkdrek4" id="idkdrek4" class="form-control select2">
												<option value="">Pilih Rekening Objek</option>
											</select>
										</div>
										<div class="col-sm-4">

										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-2">
												{!! Form::text('ibukota', $ibukota, [
													'placeholder' => 'Ibukota',
													'class' => 'form-control',
													'id' => 'ibukota-field',
												]) !!}
										</div>
										<div class="col-sm-2">
											<code>Ibukota</code>
										</div>
										<div class="col-sm-4">
											<select name="idkdrek5" id="idkdrek5" class="form-control select2">
												<option value="">Pilih Rekening Rincian</option>
											</select>
										</div>
										<div class="col-sm-4">
											
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-2">
											{!! Form::date('tgl_laporan', $tgl_1 ?? date('Y-m-d'), [
												'placeholder' => 'Tgl Laporan',
												'class' => 'form-control datepicker',
												'id' => 'tgl_laporan-field',
											]) !!}
										</div>
										<div class="col-sm-2">
											<code>Tanggal Laporan</code>
										</div>
										<div class="col-sm-4">
											<select name="idkdrek6" id="idkdrek6" class="form-control select2">
												<option value="">Pilih Rekening Sub Rincian</option>
											</select>
										</div>
										<div class="col-sm-4">
											
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">

										</div>
										<div class="col-sm-4">

										</div>
										<div class="col-sm-4">
										</div>
									</div>
									{{--<div class="form-group row">
										<div class="col-sm-9">
											{!! Form::text('footer', $model->footer, [
												'placeholder' => 'Footer',
												'class' => 'form-control',
												'id' => 'footer-field',
											]) !!}
										</div>
									</div>--}}
									<div class="form-group row">
										<label for="jenis" class="col-sm-4 col-form-label font-weight-semibold"></label>
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

@push('scripts_start')

@endpush

@push('scripts_end')
    <script type="text/javascript" src="{{ asset('assets/daterangepicker/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/daterangepicker/daterangepicker.css') }}" />

    <script type="text/javascript">
        function cetakForm() {
            href = '<?= route('laporan.pembukuan.cetak-lapkeu.rptpembukuan') ?>'
            event.preventDefault();
            var formData = $(form).serialize();

            return !window.open(href + '?' + formData, 'Cetak', 'width=1024,height=600,scrollbars=1')
            return false;
        }
        $('#tgl_range-field').daterangepicker({
            "startDate": "{{ Tahun() }}-01-01",
            "endDate": "{{ Tahun() }}-12-31",
            "minDate": "{{ Tahun() }}-01-01",
            "maxDate": "{{ Tahun() }}-12-31",
            "cancelClass": "btn-secondary",
            "locale": {
                "format": 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            $("#tgl_1-field").val(start.format('YYYY-MM-DD'));
            $("#tgl_2-field").val(end.format('YYYY-MM-DD'));
        });

        function getProgram(id) {
			var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectProgram', ':id') !!}';
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
				target.html('<option value="-1">Pilih Program</option>');
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
			var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectKegiatan', ':id') !!}';
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
				target.html('<option value="-1">Pilih Kegiatan</option>');
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
			var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectSubKegiatan', ':id') !!}';
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
				target.html('<option value="-1">Pilih Sub Kegiatan</option>');
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

        function getRek2(id) {
            var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectRek2', ':id') !!}';
            var target = $('select[name="idkdrek2"]');

            if ($(this).data('url')) {
                url = $(this).data('url');
            };
            showLoading();
            $.get(url.replace(':id', id), {
                code: $(this).data('code')
            }, function(response) {
                if (target.hasClass('select2-hidden-accessible')) {
                    target.select2('destroy');
                };
                target.html('<option value="">Pilih Rekening Kelompok</option>');
                $.each(response.refrek2, function(value, text) {
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
                hideLoading();
            });
        };

        function getRek3(id) {
            var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectRek3', ':id') !!}';
            var target = $('select[name="idkdrek3"]');

            if ($(this).data('url')) {
                url = $(this).data('url');
            };
            showLoading();
            $.get(url.replace(':id', id), {
                code: $(this).data('code')
            }, function(response) {
                if (target.hasClass('select2-hidden-accessible')) {
                    target.select2('destroy');
                };
                target.html('<option value="">Pilih Rekening Jenis</option>');
                $.each(response.refrek3, function(value, text) {
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
                hideLoading();
            });
        };

        function getRek4(id) {
            var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectRek3', ':id') !!}';
            var target = $('select[name="idkdrek4"]');

            if ($(this).data('url')) {
                url = $(this).data('url');
            };
            showLoading();
            $.get(url.replace(':id', id), {
                code: $(this).data('code')
            }, function(response) {
                if (target.hasClass('select2-hidden-accessible')) {
                    target.select2('destroy');
                };
                target.html('<option value="">Pilih Rekening Objek</option>');
                $.each(response.refrek4, function(value, text) {
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
                hideLoading();
            });
        };

        function getRek5(id) {
            var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectRek3', ':id') !!}';
            var target = $('select[name="idkdrek5"]');

            if ($(this).data('url')) {
                url = $(this).data('url');
            };
            showLoading();
            $.get(url.replace(':id', id), {
                code: $(this).data('code')
            }, function(response) {
                if (target.hasClass('select2-hidden-accessible')) {
                    target.select2('destroy');
                };
                target.html('<option value="">Pilih Rekening Rincian</option>');
                $.each(response.refrek5, function(value, text) {
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
                hideLoading();
            });
        };

        function getRek6(id) {
            var url = '{!! route('laporan.pembukuan.cetak-lapkeu.selectRek3', ':id') !!}';
            var target = $('select[name="idkdrek6"]');

            if ($(this).data('url')) {
                url = $(this).data('url');
            };
            showLoading();
            $.get(url.replace(':id', id), {
                code: $(this).data('code')
            }, function(response) {
                if (target.hasClass('select2-hidden-accessible')) {
                    target.select2('destroy');
                };
                target.html('<option value="">Pilih Rekening Sub Rincian</option>');
                $.each(response.refrek6, function(value, text) {
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
                hideLoading();
            });
        };

        $(document).on('change', 'select[name="idkdrek1"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target = $('select[name="idkdrek2"]');
            var target2 = $('select[name="idkdrek3"]');
            if (id > 0) {
                getRek2(id);
            } else {
                target.html('<option value="">Pilih Rekening Kelompok</option>');
                target2.html('<option value="">Pilih Rekening Jenis</option>');
            }
        });

        $(document).on('change', 'select[name="idkdrek2"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target2 = $('select[name="idkdrek3"]');
            if (id > 0) {
                getRek3(id);
            } else {
                target2.html('<option value="">Pilih Rekening Jenis</option>');
            }
        });

        $(document).on('change', 'select[name="idkdrek3"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target2 = $('select[name="idkdrek4"]');
            if (id != '') {
                console.log(id)
                getRek4(id);
            } else {
                target2.html('<option value="">Pilih Rekening Objek</option>');
            }
        });

        $(document).on('change', 'select[name="idkdrek4"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target2 = $('select[name="idkdrek5"]');
            if (id != '') {
                getRek5(id);
            } else {
                target2.html('<option value="">Pilih Rekening Rincian</option>');
            }
        });

        $(document).on('change', 'select[name="idkdrek5"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target2 = $('select[name="idkdrek6"]');
            if (id != '') {
                getRek6(id);
            } else {
                target2.html('<option value="">Pilih Rekening Sub Rincian</option>');
            }
        });
        

        $(document).on('change', 'select[name="idprogram"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target5 = $('select[name="idkegiatan"]');
            var target6 = $('select[name="idsubkegiatan"]');
            if (id > 0) {
                getKegiatan(id);
            } else {
                target5.html('<option value="">Pilih Kegiatan</option>');
                target6.html('<option value="">Pilih Sub Kegiatan</option>');
            }
        });

        $(document).on('change', 'select[name="idkegiatan"]', function(event) {
            var elm = $(this);
            var id = elm.val();
            var target6 = $('select[name="idsubkegiatan"]');
            //if (id > 0) {
            //    getSubKegiatan(id);
            //} else {
            //    target6.html('<option value="">Pilih Sub Kegiatan</option>');
            //}
			getSubKegiatan(id);
        });

        //script on change di pilih laporan, ketika pilih laporan 1 maka Pilih program menjadi disabled
       $(document).on('change', 'select[name="jenis_laporan"]', function(event, data) {
            var elm = $(this);
            var id = elm.val();
			
			var tglLaporanFieldElm = document.getElementById("tgl_laporan-field");
			
            var idprogramElm = document.getElementById("idprogram"); 
            var idkegiatanElm = document.getElementById("idkegiatan"); 
            var idsubkegiatanElm = document.getElementById("idsubkegiatan"); 
             
            var tglRangeFieldElm = document.getElementById("tgl_range-field");
			
			var idsumberdanaFieldElm = document.getElementById("idsumberdana-field");
			
            var idlevelrekeningElm = document.getElementById("idlevelrekening"); 

            var idjurnalsemuaElm = document.getElementById("idjurnalsemua"); 
			
            var idkdrek1Elm = document.getElementById("idkdrek1"); 
            var idkdrek2Elm = document.getElementById("idkdrek2"); 
            var idkdrek3Elm = document.getElementById("idkdrek3"); 
			var idkdrek4Elm = document.getElementById("idkdrek4"); 
            var idkdrek5Elm = document.getElementById("idkdrek5"); 
            var idkdrek6Elm = document.getElementById("idkdrek6");

            //var idrefjurnalElm = document.getElementById("idrefjurnal");             

			if ((id == 2)) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = true;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = true;
                idkdrek2Elm.disabled = true;
                idkdrek3Elm.disabled = true;
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = false;
            }
			if ((id == 3) || (id == 4) || (id == 5)) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = true;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = false;
                idkdrek2Elm.disabled = false;
                idkdrek3Elm.disabled = false;                
                idkdrek4Elm.disabled = false;
                idkdrek5Elm.disabled = false;
                idkdrek6Elm.disabled = false;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = true;
            }
            if (id == 9) {
                idprogramElm.disabled = false;
                idkegiatanElm.disabled = false;
                idsubkegiatanElm.disabled = false;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = false;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = true;
                idkdrek2Elm.disabled = true;
                idkdrek3Elm.disabled = true;                
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = true;
				getProgram(id);
				//idrefjurnalElm.disabled = true;
            }
            if (id == 11) {
                idprogramElm.disabled = false;
                idkegiatanElm.disabled = false;
                idsubkegiatanElm.disabled = false;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = false;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = true;
                idkdrek2Elm.disabled = true;
                idkdrek3Elm.disabled = true;                
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = false;
				getProgram(id);
				//idrefjurnalElm.disabled = true;
            }
            if ((id == 6) || (id == 7) || (id == 8) || (id == 10) || (id == 12) || (id == 13) || (id == 14) || (id == 15) ||
                (id == 16) || (id == 20)) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = true;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = true;
                idkdrek2Elm.disabled = true;
                idkdrek3Elm.disabled = true;                
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = true;
            }
			if (id == 17) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = true;
                tglRangeFieldElm.disabled = true;
                idlevelrekeningElm.disabled = true;
                idjurnalsemuaElm.disabled = false;
                idkdrek1Elm.disabled = true;
                idkdrek2Elm.disabled = true;
                idkdrek3Elm.disabled = true;                
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = true;
            }
            if (id == 18) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = false;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = false;
                idkdrek2Elm.disabled = false;
                idkdrek3Elm.disabled = false;                
                idkdrek4Elm.disabled = true;
                idkdrek5Elm.disabled = true;
                idkdrek6Elm.disabled = true;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = true;
            }
            if (id == 19) {
                idprogramElm.disabled = true;
                idkegiatanElm.disabled = true;
                idsubkegiatanElm.disabled = true;
                tglLaporanFieldElm.disabled = false;
                tglRangeFieldElm.disabled = false;
                idlevelrekeningElm.disabled = false;
                idjurnalsemuaElm.disabled = true;
                idkdrek1Elm.disabled = false;
                idkdrek2Elm.disabled = false;
                idkdrek3Elm.disabled = false;                
                idkdrek4Elm.disabled = false;
                idkdrek5Elm.disabled = false;
                idkdrek6Elm.disabled = false;
				idsumberdanaFieldElm.disabled = true;
				//idrefjurnalElm.disabled = true;
            }
        });
        //tutup script on change

        $('#idjurnalsemua').select2({
            ajax: {
                url: '{!! route('laporan.pembukuan.cetak-lapkeu.getNoBukti') !!}',
                dataType: 'json',
                processResults: function(data) {
                    var results = [];
                    Object.entries(data.nobukti).forEach(([key, value]) => {
                        results.push({
                            id: key,
                            text: value
                        })
                    })
                    return {
                        results: results
                    }
                }
            },
            minimumInputLength: 3
        });
    </script>
@endpush
