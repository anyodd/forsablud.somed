@extends('layouts.template')
@section('style')
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')

    <section class="content px-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card shadow-lg mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Proses Realisasi Pencairan Dana</h5>
                        </div>
                        <div class="card-body px-2 py-2">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="data" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
											<th></th>
                                            <th class="text-center">Nomor Otorisasi</th>
                                            <th class="text-center">Tanggal Otorisasi</th>
                                            <th class="text-center">Uraian</th>
                                            <th class="text-center">Jumlah (Rp)</th>
                                            <th class="text-center">Realisasi (Rp)</th>
                                            <th class="text-center" style="width: 11%;">Aksi</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        @if ($dt_oto->count() > 0)
                                            @foreach ($dt_oto as $number => $dt_oto)
											<tr>
												<td>{{ $dt_oto->id }}</td>
												<td>{{ $dt_oto->No_oto }}</td>
												<td class="text-center">{{ date('d M Y', strtotime($dt_oto->Dt_oto)) }}</td>
												<td>{{ $dt_oto->Ur_oto }}</td>
												<td class="text-right">{{ number_format($dt_oto->Jumlah, 0, ',', '.') }}</td>
												<td class="text-right">{{ number_format($dt_oto->Bayar, 0, ',', '.') }}
												</td>
												<td>
													<div class="row justify-content-center">
														{{--<div class="col-sm-5">
															  <button class="btn btn-info btn-primary" type="" name="" value="" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modalSpmBayar{{ $dt_oto->id }}" data-backdrop="static">Bayar
															  </button>
															</div> --}}
														@php $id = Crypt::encrypt($dt_oto->id) @endphp
														{{-- @php $id = $dt_oto->id @endphp --}}
														@if ($dt_oto->Bayar == 0)
														<a onclick="notifikasi()" class="btn btn-sm btn-warning" target="_blank" style="float: right;" title="Preview/Cetak" >
															<i class="fa fa-print"></i>
														</a>
														@else
														<a href="{{ route('spd_spm_pdf', $dt_oto->id)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
															<i class="fa fa-print"></i>
														</a>
														@endif
														&nbsp&nbsp&nbsp
														@if ($dt_oto->Bayar == 0)
														<a href="{{ route('spm.show', $id) }}" type="submit"
															class="btn btn-info btn-danger">Realisasi
														</a>
														@else
														<a href="{{ route('spm.show', $id) }}" type="submit"
															class="btn btn-info btn-primary">Realisasi
														</a>
														@endif
													</div>
												</td>
											</tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">Tidak Ada Data</td>
                                            </tr>
                                        @endif
									</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data').DataTable({
                stateSave: true,
				order: [2,  'asc'],
				pageLength: 10,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
				 
            });
            $('.example1').DataTable();
            $('#example').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
        });
		$('#data tr > *:nth-child(1)').hide();
		
		function notifikasi() {
			Swal.fire('', 'Data Realisasi Tidak Ada !! Isi Realisasi Pencairan', 'warning')
		}
    </script>
@endsection
