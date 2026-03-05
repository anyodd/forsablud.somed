<?php
$title = 'Data Unit/Sub Unit';
?>
@extends('layouts.template')

@push('styles')
    <link href="{{ asset('newadmin/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .wizard>.content {
            overflow: auto !important;
        }
        .wizard>.content>.body {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

@section('content')
	<div class="row">
        <div class="col-12">
            <div class="card">
				<div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold"><?= $title ?></h5>
                </div>
				<div class="card-header">	
					<div class="container-fluid pt-1">
						<ul class="nav nav-pills nav-fill" role="tablist" id="nav-parent">
							@foreach ($tabList as $tab)
								@continue($tab == 'urusan')
								@php
									if ($tab == 'bidang') {
										$tabName = 'Urusan dan Bidang';
									} elseif ($tab == 'Unit') {
										$tabName = 'Unit';
									} elseif ($tab == 'Sub') {
										$tabName = 'Sub Unit';
									} else {
										$tabName = Str::title($tab);
									}
								@endphp
								<li class="nav-item" role="presentation">
									<a class="nav-link font-13 {{ $tab == 'bidang' ? '' : 'disabled' }} {{ $tab == 'bidang' ? 'active' : '' }}"
										id="tab-{{ $tab }}" data-toggle="tab" href="#{{ $tab }}" role="tab"
										aria-controls="{{ $tab }}"
										aria-selected="{{ $tab == 'bidang' ? 'true' : 'false' }}">{{ $tabName }}</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content" id="tab-parent">
							@foreach ($tabList as $tab)
								@continue($tab == 'urusan')
								@php
									if ($tab == 'bidang') {
										$tabName = 'Urusan dan Bidang';
									} elseif ($tab == 'Unit') {
										$tabName = 'Unit';
									} elseif ($tab == 'Sub') {
										$tabName = 'Sub Unit';
									} else {
										$tabName = Str::title($tab);
									}
								@endphp
								<div class="tab-pane {{ $tab == 'bidang' ? 'active' : '' }}" id="{{ $tab }}" role="tabpanel"
									aria-labelledby="tab-{{ $tab }}">
									@if ($tab == 'bidang')
										<div class="row pt-3">
											@foreach ($urusan as $ur)
												<div class="col-12">
													<div class="card">
														<div class="card-header bg-light curs-point collapsed" data-toggle="collapse"
															data-target="#urusan-{{ $loop->iteration }}" aria-expanded="false"
															aria-controls="urusan-{{ $loop->iteration }}">
															<h4 class="card-title">{{ '[' . $ur->Ko_Urus . '] ' . $ur->Ur_Urus }}
															</h4>
														</div>
														<div id="urusan-{{ $loop->iteration }}" class="collapse"
															aria-labelledby="urusan-{{ $loop->iteration }}" style="">
															<ul class="list-group list-group-flush border-bottom">
																@foreach ($ur->bidangs as $bid)
																	@php $code = Crypt::encryptString($bid->id_bidang) @endphp
																	<li class="list-group-item align-items-center curs-point tab-next"
																		data-target="#tab-Unit" data-code="{{ $code }}"
																		data-type="bidang"
																		data-info="{{ $ur->Ko_Urus . '.' . $bid->Ko_Bid . ' - ' . $bid->Ur_Bid }}"
																		data-urusan="{{ $ur->Ko_Urus . ' - ' . $ur->Ur_Urus }}">
																		<div class="row">
																			<div class="pl-2" style="width: 11%">
																				<button type="button"
																					class="btn btn-sm btn-success btn-next"><i
																						class="fas fa-forward"></i> Lihat Unit</button>
																			</div>
																			<div class="my-auto" style="width: 89%">
																				<span class="mr-2">{{ $loop->iteration . ')' }}</span>
																				{{ '[' . $ur->Ko_Urus . '.' . $bid->Ko_Bid . '] ' . $bid->Ur_Bid }}
																					{{--<span
																					class="badge badge-success menu-arrow jmlunit ml-2"
																					data-toggle="tooltip" data-placement="right"
																					data-original-title="Jumlah Unit">{{ $bid->units()->count() }}</span>--}}
																			</div>

																		</div>
																	</li>
																@endforeach
															</ul>
														</div>
													</div>
												</div>
											@endforeach
										</div>
									@else
										<div class="table-responsive pt-1">
											<table class="table table-sm table-borderless table-hover mb-0"
												id="tabel-{{ $tab }}-info" width="100%">
												@foreach ($tabList as $tabInfo)
													@continue($tabInfo == 'urusan')
													@php
														if ($loop->index >= $loop->parent->index) {
															break;
														}
														
														if ($tabInfo == 'bidang') {
															$tabNameInfo = 'Urusan dan Bidang';
														} elseif ($tabInfo == 'Unit') {
															$tabNameInfo = 'Unit';
														} elseif ($tabInfo == 'Sub') {
															$tabNameInfo = 'Sub Unit';
														} else {
															$tabNameInfo = Str::title($tabInfo);
														}
													@endphp
													@if ($tabInfo == 'bidang')
														<tr class="p-2 border-bottom">
															<td colspan="4">Unit Organisasi / <b>{{ $tabName }}</b> </td>
														</tr>
														<tr class="p-2">
															<td width="10%">
																<button type="button"
																	class="btn btn-danger btn-xs ml-2 btn-next btn-round" style="font-size: 11pt"><i
																		class="fas fa-angle-left"></i> kembali</button>
															</td>
															<td width="10%">Urusan</td>
															<td width="2%">:</td>
															<td class="info-urusan "></td>
														</tr>
														<tr class="p-2">
															<td width="10%">
																<button type="button"
																	class="btn btn-danger btn-xs ml-2 btn-next btn-round" style="font-size: 11pt"><i
																		class="fas fa-angle-left"></i> kembali</button>
															</td>
															<td width="10%">Bidang</td>
															<td width="2%">:</td>
															<td class="info-bidang"></td>
														</tr>
													@else
														<tr class="p-2">
															<td width="10%">
																<button type="button"
																	class="btn btn-danger btn-xs ml-2 btn-next btn-round" style="font-size: 11pt"><i
																		class="fas fa-angle-left"></i> kembali</button>
															</td>
															<td>{{ $tabNameInfo }}</td>
															<td width="2%">:</td>
															<td class="info-{{ $tabInfo }}"></td>
														</tr>
													@endif
												@endforeach
											</table>
										</div>
										<div class="row my-2 btn-add d-none">
											<div class="col-12">
												<a href="{{ route('setting.manajemen-unit.form', ['code' => ':code', 'table' => $tab]) }}"
													class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal"
													data-action="create" title="Tambah {{ $tabName }}">
													<i class="fas fa-plus"></i> Tambah {{ $tabName }}
												</a>
											</div>
										</div>
										<div class="table-responsive my-3">
											<table class="table table-borderless {{ $loop->last ? '' : 'table-hover table-pointer' }}"
												id="tabel-{{ $tab }}" width="100%">
												<thead class="bg-light text-center">
													<tr>
														<th class="text-center" style="vertical-align: middle; width: 15%">Aksi</th>
														<th class="text-center" style="vertical-align: middle; width: 10%">No</th>
														<th class="text-center" style="vertical-align: middle; width: 10%">Kode {{ $tabName }}</th>
														<th class="text-center" style="vertical-align: middle;">Nama {{ $tabName }}</th>
													</tr>
												</thead>
											</table>
										</div>
									@endif
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
    <!-- wizard -->
    <script src="{{ asset('newadmin/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <!-- repeater -->
    <script src="{{ asset('newadmin/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script type="text/javascript">
        var url = '{!! route('setting.manajemen-unit.datatable') !!}';
        var code = [];
        var info = [];
        var tabList = JSON.parse('{!! json_encode($tabList) !!}');

        $(function() {
            $(document).on('dblclick', '.tab-next', function() {
                var target = $(this).data('target');
                var pane = $(target).attr('href');
                var tabIndex = $('.tab-pane').index($(pane));
                var btnAdd = $('.btn-add').eq(tabIndex - 1);
                var addUrl = new URL(btnAdd.find('a').attr('href'));
                var type = $(this).data('type');
                code[type] = $(this).data('code');
                info[type] = $(this).data('info');

                if (type == 'bidang') {
                    info.urusan = $(this).data('urusan');
                }

                var prevTarget = 'bidang';

                $.each(tabList, function(index, tab) {
                    var tabTarget = tab;

                    if (tab == 'urusan') {
                        tabTarget = 'bidang';
                        prevTarget = 'bidang';
                    }

                    $(pane).find('.info-' + tab).html('<strong>' + info[tab] + '</strong>');
                    $(pane).find('.info-' + tab).closest('tr').addClass('tab-next')
                        .data('target', '#tab-' + tabTarget)
                        .data('code', code[prevTarget])
                        .data('type', prevTarget)
                        .data('info', info[prevTarget])
                        .data('urusan', info.urusan);

                    prevTarget = tab;
                });

                addUrl.searchParams.set('code', code[type]);
                btnAdd.find('a').attr('href', addUrl.href);
                btnAdd.removeClass('d-none');
                initUnitTable(tabIndex + 1);
                resetUnitTable(tabIndex + 1);
                changeTab(target);
            });

            $(document).on('change', 'input[name="Ur_Unit"]', function() {
                $('#modal-info-Unit').text($(this).val());
            });

            $(document).on('click', '.btn-next', function() {
                $(this).closest('.tab-next').trigger('dblclick');
            });

            $(document).on('click', '.tab-detail.btn-secondary', function() {
                var index = $('#tab-parent > .tab-pane').index($('#tab-parent > .tab-pane.active'));
                var tr = $(this).closest('tr');
                var row = table[index].row(tr);

                row.child.hide();
                $(this).removeClass('btn-secondary').addClass('btn-warning');
            });

            $(document).on('click', '.tab-detail.btn-warning', function() {
                var target = $(this).data('target');
                var label = $(this).text();
                var index = $('#tab-parent > .tab-pane').index($('#tab-parent > .tab-pane.active'));
                var tr = $(this).closest('tr');
                var row = table[index].row(tr);
                var id = 'table-' + target + '-' + row.index();

                $('.tab-detail.btn-secondary').trigger('click');
                $(this).removeClass('btn-warning').addClass('btn-secondary');
                row.child(formatDetailTable(target, id, label, row.data())).show();
                row.child().attr('data-id', tr.attr('id'));
                initUnitTableDetail(target, id, row.data().code);
            });

            $(document).on('hide.bs.tab', 'a[data-toggle="tab"]', function(event) {
                $('.tab-detail.btn-secondary').trigger('click');
            });

        });

        function initUnitTable(index) {

            var id = '#tabel-' + tabList[index];
            var columns = [{
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'Ko_' + tabList[index],
                    name: 'Ko_' + tabList[index],
                    className: 'text-center',
                    width: '10%'
                },
                {
                    data: 'Ur_' + tabList[index],
                    name: 'Ur_' + tabList[index]
                },
            ];
			

            if ($.fn.DataTable.isDataTable(id)) {
                $(id).DataTable().destroy();
                $(id).find('tbody').empty();
            }

            table[index - 1] = $(id).DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: url,
                    data: function(d) {
                        d.table = tabList[index];
                        d.code = code[tabList[index - 1]];
                    }
                },
                order: [0, 'asc'],
                columns: columns,
                createdRow: function(row, data) {
                    if (index + 1 < tabList.length) {
                        $(row).addClass('tab-next')
                            .data('target', '#tab-' + tabList[index + 1])
                            .data('code', data.code)
                            .data('type', tabList[index])
                            .data('info', data['Ko_' + tabList[index]] + ' - ' + data['Ur_' + tabList[index]]);
                    }
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var json = api.ajax.json();

                    if (json && json.table == 'Unit') {
                        $('.tab-next[data-code="' + json.code + '"] .jmlunit').text(json.recordsTotal);
                    }
                }
            });
        }
		

        function resetUnitTable(tabIndex) {
            for (let index = tabIndex; index < $('.tab-pane').length; index++) {
                var tableId = '#' + $('.tab-pane:eq(' + index + ') .table:eq(1)').attr('id');
                $('.tab-pane:eq(' + index + ') .table:eq(0) tr').each(function() {
                    $(this).find('td:eq(3)').empty();
                });
                $('.btn-add').eq(index - 1).addClass('d-none');

                if ($.fn.DataTable.isDataTable(tableId)) {
                    $(tableId).DataTable().destroy();
                    $(tableId).find('tbody').remove();
                }
            }
        }

        function changeTab(target) {
            $(target).removeClass('disabled').trigger('click');

            var navElm = $('#nav-parent .nav-link');
            var tableIndex = $('#tab-parent .tab-pane').index($('#tab-parent .tab-pane.active'));

            navElm.each(function() {
                var navIndex = navElm.index($(this));

                if (navIndex > tableIndex) {
                    $(this).addClass('disabled');
                }
            });
        }

        function initFormWizard(form) {
            form.steps({
                headerTag: 'h3',
                bodyTag: 'fieldset',
                transitionEffect: 'slide',
                onFinished: function(event, currentIndex) {
                    form.submit();
                }
            });
        }

        function formatDetailTable(target, id, label, data) {
            var btnAdd = '';
			
			btnAdd = '<a href="{!! route('setting.manajemen-unit.form') !!}?code=' + data.code + '&table=' + target +
				'" class="btn btn-outline-primary btn-sm btn-add-detail" data-toggle="modal" data-target="#modal" data-action="create" title="Tambah ' +
				label + '">' +
				'<i class="ti-plus mr-2"></i> Tambah ' + label +
				'</a>';


            var formatTable = '<div class="bg-light pl-3">' +
                '<div class="row p-2">' +
                '<div class="col-12">' +
                btnAdd +
                '</div>' +
                '</div>' +
                '<div class="table-responsive p-2">' +
                '<table class="table table-striped" style="font-size: 8.5pt" id="' + id + '" width="100%">' +
                '<thead class="bg-secondary text-center">';
				

            return formatTable += '</thead></table></div></div>';
        }
		
		function initUnitTableDetail(target, id, detailCode) {
            var lengthChange = false;

            if ($.fn.DataTable.isDataTable('#' + id)) {
                $('#' + id).DataTable().destroy();
                $('#' + id).find('tbody').remove();
            }


            tableDetail = $('#' + id).DataTable({
                lengthChange: lengthChange,
                info: lengthChange,
                serverSide: true,
                processing: true,
                ajax: {
                    url: url,
                    data: function(d) {
                        d.table = target;
                        d.code = detailCode;
                    }
                },
                order: [0, 'asc'],
                columns: detailColumns
            });
        }

    </script>
@endpush
