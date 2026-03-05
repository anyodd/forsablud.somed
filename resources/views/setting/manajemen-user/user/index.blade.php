@extends('layouts.template')

@section('content')
<section class="content px-0">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col">
				<div class="card shadow-lg">
					<div class="card-header bg-info">
						<h5 class="card-title font-weight-bold">Data Pengguna Aplikasi</h5>  
					</div>
						
					<div class="card-body">
						<div class="row my-2">
							<div class="col-12 col-sm-6 col-md-3">
								<div class="card report-card bg-light">
									<a href="#">
										<div class="card-body">
											<div class="row d-flex justify-content-center">
												<div class="col">
													<p class="text-success mb-0 font-weight-bold">User aktif</p>
													<h4 class="nopadding" id="jmlAktif">{{ $jmlAktif }}</h4>
												</div>
												<div class="col-auto align-self-center">
													<div class="report-main-icon text-success">
														<i class="fas fa-check-circle align-self-center icon-sm font-24"></i>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-md-3">
								<div class="card report-card bg-light">
									<a href="#">
										<div class="card-body ">
											<div class="row d-flex justify-content-center">
												<div class="col">
													<p class="text-danger mb-0 font-weight-bold">User tidak aktif</p>
													<h4 class="nopadding" id="jmlTidakAktif">{{ $jmlTidakAktif }}</h4>
												</div>
												<div class="col-auto align-self-center">
													<div class="report-main-icon text-danger">
														<i class="fas fa-times-circle align-self-center icon-sm font-24"></i>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-md-3">
								<div class="card report-card bg-light">
									<a href="#">
										<div class="card-body">
											<div class="row d-flex justify-content-center">
												<div class="col">
													<p class="text-info mb-0 font-weight-bold">User Admin</p>
													<h4 class="nopadding" id="jmlAdmin">{{ $jmlAdmin }}</h4>
												</div>
												<div class="col-auto align-self-center">
													<div class="report-main-icon text-info">
														<i class="fas fa-users-cog align-self-center icon-sm font-24"></i>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-md-3">
								<div class="card report-card bg-light">
									<a href="#">
										<div class="card-body">
											<div class="row d-flex justify-content-center">
												<div class="col">
													<p class="text-warning mb-0 font-weight-bold">User Operator</p>
													<h4 class="nopadding" id="jmlOperator">{{ $jmlOperator }}</h4>
												</div>
												<div class="col-auto align-self-center">
													<div class="report-main-icon text-warning">
														<i class="fas fa-user-edit align-self-center icon-sm font-24"></i>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
                        @if ( getUser('user_level') == '99')
						<div class="row my-2">
							<div class="col-12">
								<a href="{{ route('setting.manajemen-user.user.form') }}" class="btn btn-success btn-sm" data-toggle="modal"
									data-target="#modal" data-action="create" title="Tambah Pengguna">
									<i class="fas fa-user-plus"></i> Tambah Pengguna
								</a>
							</div>
						</div>
                        @endif
						<div class="table-responsive">
							<table class="table table-striped" id="table" width="100%">
								<thead class="bg-light text-center">
									<tr>
										<th class="vertical-align: middle;">Aksi</th>
										<th class="vertical-align: middle;">No</th>
										<th class="vertical-align: middle;">Nama</th>
										<th class="vertical-align: middle;">Level</th>
										<th class="vertical-align: middle;">Aktif</th>
										<th class="vertical-align: middle;">Nama BLUD</th>
										<th class="vertical-align: middle;">Nama Bidang</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal-->
	<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modal"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="btn btn-light btn-icon-square-sm close mr-1" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body bg-white" style="padding-bottom: 15px"></div>
				<div class="bg-success" style="height: 12px; width: 100.08%"></div>
			</div>
		</div>
	</div>
</section> 
@endsection


@push('scripts_start')
    <script type="text/javascript">
        var table;
    </script>
	<!-- Select2 -->
<script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@push('scripts_end')
    <script type="text/javascript">
        $(function() {
            $(document).ajaxSuccess(function(event, xhr, settings) {
                if (settings.type == 'POST') {
                    reloadUnitSubunit();
                }
            });

            table = $('#table').DataTable({
                ajax: '{!! route('setting.manajemen-user.user.datatable') !!}',
                processing: true,
                serverSide: true,
                order: [1, 'asc'],
                columns: [{
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'level',
                        name: 'level',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        searchable: false
                    },
                    {
                        data: 'nmblud',
                        name: 'nmblud',
                        orderable: false
                    },
                    {
                        data: 'nmbidang',
                        name: 'nmbidang',
                        orderable: false
                    },
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var json = api.ajax.json();

                    $('#jmlAktif').text(json.jmlAktif);
                    $('#jmlTidakAktif').text(json.jmlTidakAktif);
                    $('#jmlAdmin').text(json.jmlAdmin);
                    $('#jmlOperator').text(json.jmlOperator);
                }
            });

            $(document).on('change', 'select[name="Ko_Wil1"]', function() {
                var url = '{!! route('setting.manajemen-user.user.pemda') !!}'
                var Ko_Wil1 = $(this).val();
                var target = $('select[name="id_pemda"]');
                target.html(setLoader());

                $.get(url, {
                    Ko_Wil1: Ko_Wil1
                }, function(response) {
                    if (target.hasClass('.select2-hidden-accessible')) {
                        target.select2('destroy');
                    }

                    target.html('<option value="">Pemerintah Daerah</option>');

                    $.each(response.pemda, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        }
                    });

                    if (target.hasClass('.select2')) {
                        initSelect2();
                    }
                });
            });

			$(document).on('change', 'select[name="id_pemda"]', function() {
                var url = '{!! route('setting.manajemen-user.user.unit') !!}'
                var id_pemda = $(this).val();
                var target = $('select[name="id_unit"]');
                target.html(setLoader());

                $.get(url, {
                    id_pemda: id_pemda
                }, function(response) {
                    if (target.hasClass('.select2-hidden-accessible')) {
                        target.select2('destroy');
                    }

                    target.html('<option value="">Pilih Unit</option>');

                    $.each(response.unit, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        }
                    });

                    if (target.hasClass('.select2')) {
                        initSelect2();
                    }
                });
            });

            $(document).on('change', 'select[name="id_unit"]', function() {
                var url = '{!! route('setting.manajemen-user.user.subunit') !!}'
                var id_unit = $(this).val();
                var target = $('select[name="id_sub"]');
                target.html(setLoader());

                $.get(url, {
                    id_unit: id_unit
                }, function(response) {
                    if (target.hasClass('.select2-hidden-accessible')) {
                        target.select2('destroy');
                    }

                    target.html('<option value="">Pilih BLUD</option>');

                    $.each(response.subunit, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        }
                    });

                    if (target.hasClass('.select2')) {
                        initSelect2();
                    }
                });
            });

            $(document).on('change', 'select[name="id_sub"]', function() {
                var url = '{!! route('setting.manajemen-user.user.subunit1') !!}'
                var id_sub = $(this).val();
                var target = $('select[name="id_sub1"]');
                target.html(setLoader());

                $.get(url, {
                    id_sub: id_sub
                }, function(response) {
                    if (target.hasClass('.select2-hidden-accessible')) {
                        target.select2('destroy');
                    }

                    target.html('<option value="">Pilih Bidang</option>');

                    $.each(response.subunit1, function(value, text) {
                        if (value) {
                            target.append($('<option>', {
                                value: value,
                                text: text
                            }));
                        }
                    });

                    if (target.hasClass('.select2')) {
                        initSelect2();
                    }
                });
            });
        });
		
		function initSelect2() {
			$('select.select2:not(.select2-hidden-accessible)').select2({
				allowClear: false,
				width: '100%'
			});
		}

        function duplicateForm(elm) {
            var formButton = $(elm);
            var formGroup = formButton.closest('.form-group');

            if (formButton.hasClass('btn-primary')) {
                formGroup.find('.select2.select2-hidden-accessible').select2('destroy');
                var formNew = formGroup.clone();
                formNew.find('label').remove();
                formNew.find('select').val('');
                formNew.find('div:eq(0)').addClass('offset-sm-3');
                formNew.find('.btn').removeClass('btn-primary').addClass('btn-danger');
                formNew.find('.fa').removeClass('fa-plus').addClass('fa-minus');
                formGroup.after(formNew);
                initSelect2();
            } else {
                formGroup.remove();
            }
        }
    </script>
@endpush
