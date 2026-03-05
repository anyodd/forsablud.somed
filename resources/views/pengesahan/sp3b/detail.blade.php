@extends('layouts.template')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info mt-2">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold">Detail SP3B Nomor : {{$sp3->No_sp3}}</h5> 
                    </div>
                    <div class="card-body">
						<div class="col-md-11">
							<a href="{{ route('pengesahan.index') }}" class="btn btn-sm btn-danger" id="kembali">
								<i class="fas fa-arrow-alt-circle-left"></i> Kembali
							</a>
						</div>
						<br>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
								<thead class="thead-light">
									<tr>
										<th class="text-center" style="vertical-align: middle;">Rekening</th>
										<th class="text-center" style="vertical-align: middle;">No Bukti</th>
										<th class="text-center" style="vertical-align: middle;">Uraian Bukti</th>
										<th class="text-center" style="vertical-align: middle;">Rupiah (Rp)</th>
									</tr>
								</thead>
								<tbody>
								@php
									$total = 0;
									$total_terima = 0;
									$total_setor = 0;
								@endphp
								@if (!empty($data))
								
									@foreach ($data as $rekening => $bukti)
										<tr>
											<td colspan="3" class="text-bold">{{$rekening}}-{{$bukti['ur_rk']->Ur_Rk6_bel}}</td>
											<td class="text-right text-bold">{{number_format($bukti['subtotal'],2,',','.')}}</td>
										</tr>
										@foreach ($bukti['subrincian'] as $detail => $rincian)
											<tr>
												<td></td>
												<td>{{$detail}}</td>
												<td>{{$rincian['ur_bprc']['0']->Ur_bprc}}</td>
												<td class="text-right">{{number_format($rincian['total_bp'],2,',','.')}}</td>
											</tr>
										@endforeach
									@endforeach
								</tbody> 
								@else
								@endif
							</table>
						</div>
						<div class="card-footer">
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</section>
@endsection

@section('script')

<script>
    $(document).ready(function() {
      $('#example').DataTable({
			responsive: {
				 details: {
					display: $.fn.dataTable.Responsive.display.modal( {
					  header: function ( row ) {
							var data = row.data();
							return 'Details for '+data[0]+' '+data[1];
						}
					}),
					renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
					  tableClass: 'table'
					})
				}
			}
		});
	});
</script>
@endsection