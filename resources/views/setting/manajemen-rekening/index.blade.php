<?php
$title = 'Data Rekening';
?>
@extends('layouts.template')

@section('content')
	<div class="row">
        <div class="col-12">
            <div class="card">
				<div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold"><?= $title ?></h5>
                </div>
				<div class="card-header">	
					<div class="container-fluid pt-1">
						<ul class="nav nav-pills nav-fill" id="prokeg" role="tablist">
							@foreach ($tabList as $tabKey => $tabName)
								<li class="nav-item" role="presentation">
									<a class="nav-link disabled {{ $tabKey == 'Rk1' ? 'active' : '' }}" id="tab-{{ $tabKey }}"
										data-toggle="tab" href="#{{ $tabKey }}" role="tab" aria-controls="{{ $tabKey }}"
										aria-selected="{{ $tabKey == 'Rk1' ? 'true' : 'false' }}">Rekening {{ $tabName }}</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content" id="tab-parent">
							@foreach ($tabList as $tabKey => $tabName)
								<div class="tab-pane {{ $tabKey == 'Rk1' ? 'active' : '' }}" id="{{ $tabKey }}" role="tabpanel"
									aria-labelledby="tab-{{ $tabKey }}">
									@if ($loop->index)
										<div class="table-responsive">
											<table class="table table-sm table-borderless table-hover mb-0"
												id="tabel-{{ $tabKey }}-info" width="100%">
												<tr class="p-2 border-bottom">
													<td colspan="4">Rekening / <b>Rekening {{ $tabName }}</b> </td>
												</tr>
												@foreach ($tabList as $tabKeyInfo => $tabNameInfo)
													@break($loop->index >= $loop->parent->index)
													<tr>
														<td width="10%" class="p-2">
															<button type="button"
																class="btn btn-danger btn-round btn-tab-return ml-2" style="font-size: 11pt"><i
																	class="fas fa-angle-left"></i> kembali</button>
														</td>
														<td width="20%" class="p-2">Rekening {{ $tabNameInfo }}</td>
														<td width="3" class="p-2">:</td>
														<td class="info-{{ $tabKeyInfo }} p-2"></td>
													</tr>
												@endforeach
											</table>
										</div>
									@endif
									<div class="row my-3">
										<div class="col-6 text-left">
											<div class="btn-add-rekening"></div>
											@if ($loop->first)
												<a href="{{ route('setting.manajemen-rekening.copy') }}"
													class="btn btn-sm btn-primary waves-effect waves-light copy-rekening"
													title="Salin Data Tahun Sebelumnya">
													<i class="fas fa-copy"></i> Salin Data Tahun Sebelumnya
												</a>
											@endif
										</div>
										<div class="col-6 text-right">
											<div class="btn-group-ml">
												<strong>Export data ke:</strong>
												<a href="{{ route('setting.manajemen-rekening.export', ['level' => $loop->iteration, 'type' => 'pdf']) }}"
													class="btn btn-danger mx-2 btn-sm" target="_blank"><i class="fa fa-file-pdf"></i>
													cetak
													PDF</a>
											</div>
										</div>
									</div>
									<div class="table-responsive my-3">
										<table class="table {{ $loop->last ? '' : 'table-hover table-pointer' }}"
											id="tabel-{{ $tabKey }}" width="100%">
											<thead class="bg-light text-center" >
												<tr>
													<th class="text-center" style="vertical-align: middle; width: 15%">Aksi</th>
													<th class="text-center" style="vertical-align: middle; width: 10%">Tahun</th>
													<th class="text-center" style="vertical-align: middle; width: 10%">Kode {{ $tabName }}</th>
													<th class="text-center" style="vertical-align: middle;">Nama Rekening {{ $tabName }}</th>
													<th class="text-center" style="vertical-align: middle;">Kode Bidang</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							@endforeach
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
@endsection

@push('scripts_start')
    <script type="text/javascript">
        var table = [];
    </script>
@endpush

@push('scripts_end')
    <script type="text/javascript">
        var kode = [];
        var info = [];
        var url = '{!! route('setting.manajemen-rekening.datatable') !!}';
        var tabList = JSON.parse('{!! json_encode($tabList) !!}');
        var tabLength = parseInt('{!! count($tabList) !!}');

        $(function() {
            initRekTable(0);

            $(document).on('dblclick', '.tab-next', function() {
                var target = $(this).data('target');
                var pane = $(target).attr('href');
                var tabIndex = $('.tab-pane').index($(pane));
                kode[$(this).data('type')] = $(this).data('kode');
                info[$(this).data('type')] = $(this).data('info');

                $.each(tabList, function(tab) {
                    $(pane).find('.info-' + tab).html('<strong>' + kode[tab] + '. ' + info[tab] +
                        '</strong>');
                    $(pane).find('.info-' + tab).closest('tr').addClass('tab-next')
                        .data('target', '#tab-' + tab)
                        .data('kode', kode[tab])
                        .data('type', tab)
                        .data('info', info[tab]);
                });

                $.when(resetRekTable(tabIndex + 1))
                    .then(initRekTable(tabIndex));
                changeTab(target);
            });

            $(document).on('click', '.btn-tab-next, .btn-tab-return', function() {
                $(this).closest('tr').trigger('dblclick');
            });

            $(document).on('click', '.copy-rekening', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Warning!',
                    html: 'Apakah anda ingin menyalin data rekening dari tahun sebelumnya?<br><strong>Data rekning tahun ini akan ditimpa dengan data rekening tahun sebelumnya!</strong>',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Salin'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();

                        $.get(url, function(response) {
                            if (response.status) {
                                window.location.reload();
                            } else {
                                showAlert(response.message, 'warning');
                                hideLoading();
                            }
                        });
                    }
                });
            });
        });

        function initRekTable(index) {
            var rek = index + 1;
            var id = '#tabel-Rk' + rek;
            var target = rek + 1;

            if ($.fn.DataTable.isDataTable(id)) {
                $(id).DataTable().destroy();
            }

            table[index] = $(id).DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: url,
                    type: 'POST',
                    data: function(d) {
                        d._token = '{!! csrf_token() !!}';
                        d.level = rek;

                        for (const key in kode) {
                            if (Object.hasOwnProperty.call(kode, key)) {
                                d['kode[' + key + ']'] = kode[key];
                            }
                        }
                    }
                },
                order: [1, 'asc'],
                columns: [{
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        width: '15%',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'Ko_Period',
                        name: 'Ko_Period',
                        className: 'text-center',
                        width: '10%',
                    },
                    {
                        data: 'Ko_Rk' + rek,
                        name: 'Ko_Rk' + rek,
                        className: 'text-center',
                        width: '10%',
                    },
                    {
                        data: 'Ur_Rk' + rek,
                        name: 'Ur_Rk' + rek,
                    },
					{
                        data: 'id_bidang',
                        name: 'id_bidang'
                    },
                ],
                createdRow: function(row, data, index) {
                    if (rek < tabLength) {
                        $(row).addClass('tab-next')
                            .data('target', '#tab-Rk' + target)
                            .data('kode', data['Ko_Rk' + rek])
                            .data('type', 'Rk' + rek)
                            .data('info', data['Ur_Rk' + rek]);
                    }
                },
                initComplete: function(data, settings) {
                    $('.btn-add-rekening').eq(index).html(data.json.btnAdd);
                }
            });
        }

        function resetRekTable(tabIndex) {
            for (let index = tabIndex; index < $('.tab-pane').length; index++) {
                var id = $('.tab-pane:eq(' + (index - 1) + ')').attr('id');
                var tableId = '#' + $('.tab-pane:eq(' + index + ') .table:eq(1)').attr('id');
                $('.tab-pane:eq(' + index + ') .table:eq(0) tr').each(function() {
                    $(this).find('td:eq(3)').empty();
                });
                delete kode[id];
                delete info[id];

                if ($.fn.DataTable.isDataTable(tableId)) {
                    $(tableId).DataTable().destroy();
                    $(tableId).find('tbody').remove();
                }
            }
        }

        function changeTab(target) {
            var navElm = $('.nav-link');
            var navActive = $('.nav-link' + target);
            var navIndex = navElm.index(navActive);

            navElm.each(function() {
                var index = navElm.index($(this));

                if (index <= navIndex) {
                    $(this).removeClass('disabled');
                } else {
                    $(this).addClass('disabled');
                }
            });

            $(target).trigger('click');
        }
    </script>
@endpush
