@extends('layouts.template')
@section('title', 'Rincian Bukti Terima / Klaim')

((--@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection--}}

@section('content')

<section class="content px-0">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card shadow-lg mt-2">
					<div class="card-header bg-info py-2">
						<h5 class="card-title font-weight-bold">@yield('title')</h5> 
					</div>
					<div class="card-body px-2 py-2">
						{{-- @if(empty($cek)) --}}
						@if ($kobp->Ko_bp == 11)
						<a href="{{ route('subpenerimaan.tambahtl', Request::segment(3) )}}">
							<button class="btn btn-sm btn-primary mb-2" data-backdrop="static">
								<i class="fas fa-plus-circle pr-1"></i>Tambah</i>
							</button>
						</a>
						@else
						 <a href="{{ route('subpenerimaan.tambah', Request::segment(3) )}}">
							<button class="btn btn-sm btn-primary mb-2" data-backdrop="static">
								<i class="fas fa-plus-circle pr-1"></i>Tambah</i>
							</button>
						 </a>
						@endif
						<a href="{{ route('penerimaan.bulan',Session::get('bulan')) }}" class="btn btn-sm btn-success float-right">
							<i class="fas fa-share fa-rotate-180"></i>Kembali
						</a>
						<br><br>
						<div class="table-responsive">
							<table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
								<thead class="thead-light">
								  <tr>
									<th class="text-center" style="width: 3%;">No Rincian</th>
									<th class="text-center" style="width: 17%; vertical-align: middle;">No Bukti</th>
									<th class="text-center" style="width: 22%; vertical-align: middle;">Uraian</th>
									<th class="text-center" style="width: 15%; vertical-align: middle;">No Referensi </th>
									<th class="text-center" style="width: 10%; vertical-align: middle;">Tanggal Referensi </th>
									{{--<th class="text-center" style="width: 10%; vertical-align: middle;">Kode Sub Kegiatan</th>
									<th class="text-center" style="width: 10%; vertical-align: middle;">Kode Aktivitas</th>--}}
									<th class="text-center" style="width: 10%; vertical-align: middle;">Kode Akun</th>
									<th class="text-center" style="width: 13%; vertical-align: middle;">Nilai (Rp)</th>
									<th class="text-center" style="width: 10%;">Aksi</th>
								  </tr>
								</thead>
								<tbody>
									@foreach($rincian as $r)
										<tr>
											<td class="text-center">{{ $r->Ko_bprc }}</td>                       
											<td>{{ $r->No_bp }}</td>                      
											<td>{{ $r->Ur_bprc }}</td>                      
											<td>{{ $r->rftr_bprc }}</td>                      
											<td class="text-center">{{ date('d M Y', strtotime($r->dt_rftrbprc)) }}</td>                      
											{{--<td>{{ $r->Ko_sKeg1 }}</td>                      
											<td>{{ $r->Ko_sKeg2 }}</td>--}}
											<td>{{ $r->Ko_Rkk }}</td>                      
											<td class="text-right">{{ number_format($r->To_Rp,2,',','.') }}</td>                       
											<td>
												<div class="row justify-content-center" >
													@if(is_null ($r->idbprcbyr))
														<a href="{{route('subpenerimaan.edit',$r->id_bprc)}}">
															<button class="btn btn-warning btn-sm ml-2 mr-2" style="display: flex; align-items: center; justify-content: center;" title="Edit">
																<i class="fas fa-edit"></i>
															</button>
														</a>
														<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal2{{ $r->id_bprc }}" title="Hapus Rincian"> 
															 <i class="fa fa-trash"></i>
														</button>
													@else
														<a href="#">
															<button class="btn btn-warning btn-sm ml-2 mr-2" style="display: flex; align-items: center; justify-content: center;" title="Edit" disabled>
																<i class="fas fa-edit"></i>
															</button>
														</a>

														<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#" title="Hapus Rincian" disabled> 
															 <i class="fa fa-trash"></i>
														</button>
													@endif

													<div class="modal fade" id="modal2{{ $r->id_bprc }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<h6>Yakin mau hapus data ?</h6>
																</div>
																<div class="modal-footer">
																	<form action="{{ route('subpenerimaan.destroy', $r->id_bprc) }}" method="post" class="">
																	  @csrf
																	  @method('DELETE')
																		<button type="submit" class="btn btn-danger" name="submit" title="Hapus">Ya, Hapus</button>
																	</form>
																		<button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
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
<script>
        let x = document.querySelectorAll(".myDIV");
        for (let i = 0, len = x.length; i < len; i++) {
            let num = Number(x[i].innerHTML)
                      .toLocaleString('en');
            x[i].innerHTML = num;
            x[i].classList.add("currSign");
        }
</script>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>


@endsection