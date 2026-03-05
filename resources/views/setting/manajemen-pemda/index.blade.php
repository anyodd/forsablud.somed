@extends('layouts.template')

@section('content')
<section class="content px-0">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col">
				<div class="card shadow-lg">
					<div class="card-header bg-info">
						<h5 class="card-title font-weight-bold">Data Pemerintah Daerah</h5>  
					</div>
					<div class="card-body">
						<div class="row my-2">
							<div class="col-12">
								<a href="{{ route('setting.manajemen-pemda.form') }}" class="btn btn-success btn-sm" data-toggle="modal"
									data-target="#modal" data-action="create" title="Tambah Data Pemda">
									<i class="fas fa-user-plus"></i> Tambah Data Pemda
								</a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-hover dataTable no-footer" id="table" width="100%">
								<thead class="bg-light text-center">
									<tr>
                                        <th class="vertical-align: middle;">Aksi</th>
										<th class="vertical-align: middle;">No</th>
										<th class="vertical-align: middle;">Provinsi</th>
										<th class="vertical-align: middle;">Kode Pemda</th>
										<th class="vertical-align: middle;">Pemerintah Daerah</th>
                                        <th class="vertical-align: middle;">Ibukota</th>
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
	<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modal" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="btn btn-light btn-icon-square-sm close mr-1" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body bg-light" style="padding-bottom: 15px"></div>
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
			ajax: '{!! route('setting.manajemen-pemda.datatable') !!}',
			processing: true,
			serverSide: true,
			order: [1, 'asc'],
			columns: [
				{ data: 'action', name: 'action', className: 'text-center', width: '5%', orderable: false, searchable: false },
				{ data: 'kdurut', name: 'kdurut'},
				{ data: 'nama_prov_display', name: 'nama_prov_display'},
				{ data: 'kode_pemda', name: 'kode_pemda'},
				{ data: 'nama_kab', name: 'nama_kab'},
				{ data: 'ibukota', name: 'ibukota'},
			],
			drawCallback: function(settings) {
				var api = this.api();
				var rows = api.rows({
					page: 'current'
				}).nodes();
				var last = null;
				var json = api.ajax.json();

				api.column(2, {
					page: 'current'
				}).data().each(function(group, i) {
					if (last !== group) {
						$(rows).eq(i).before(
							'<tr class="group"><td colspan="5" style="font-weight:bold;">' +
							group + '</td></tr>'
						);
						last = group;
					}
				});
			},
			columnDefs: [{
				targets: [2],
				visible: false
			}],
		});

		$(document).on('change', 'select[name="Ko_Wil1"]', function() {
			var url = '{!! route('setting.manajemen-pemda.pemda') !!}'
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
	});

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