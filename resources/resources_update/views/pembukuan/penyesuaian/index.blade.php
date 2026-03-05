@extends('layouts.template')
@section('title', 'Penyesuaian')

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Penyesuaian</h5> 
          </div>
          <div class="card-body">
			<div class="row">
				  <div class="col-md-12">
					<button type="button" class="btn btn-sm btn-success mb-2" data-toggle="modal" data-backdrop="static" data-target="#modal-create"><i class="fas fa-plus-circle pr-1"></i> Tambah</button>
				  </div>
			</div>
			<div class="table-responsive">
				<table id="example1" class="table table-sm table-bordered table-striped">
				  <thead class="thead-light">
					<tr>
					  <th class="text-center" style="vertical-align: middle; width: 3%">No.</th>
					  <th class="text-center" style="vertical-align: middle;">Nomor Penyesuaian</th>
					  <th class="text-center" style="vertical-align: middle;">Tanggal Penyesuaian</th>
					  <th class="text-center" style="vertical-align: middle;">Jenis Jurnal</th>
					  <th class="text-center" style="vertical-align: middle;">Uraian</th>
					  <th class="text-center" style="vertical-align: middle; width: 4%">Status</th>
					  <th class="text-center" style="vertical-align: middle; width: 10%">Aksi</th>
					</tr>
				  </thead>
				  @if (count($penyesuaian ?? '') > 0)
				  <tbody>
					@foreach ($penyesuaian as $item)
					<tr>
					  <td class="text-center" style="width: 5%">{{ $loop->iteration }}.</td>
					  <td style="width: 20%">{{ $item->Sesuai_No }}</td>
					  <td style="width: 10%">{{ date('d-m-Y',strtotime($item->dt_sesuai)) }}</td>
					  <td>{{ $item->Ur_sesuai }}</td>
					  <td>{{ $item->Sesuai_Ur }}</td>
					  @if ($item->status_jr == '1')
						<td class="text-center text-success">Balanced</td>
					  @elseif($item->status_jr == '0')
						<td class="text-center text-danger">Unbalanced</td>
					  @elseif($item->status_jr == NULL)
						<td class="text-center text-secondary">-</td>
					  @else()
						<td class="text-center">-</td>
					  @endif
					  <td class="text-center" style="width: 10%">
						<a href="{{ route('penyesuaian.detail',$item->id_tbses) }}"
						  class="btn btn-sm btn-info" title="Tambah rincian"> <i
						  class="fa fa-angle-double-right"></i>
						</a>
						<button class="btn btn-warning btn-sm" title="Edit" data-toggle="modal" data-target="#modaledit{{$item->id_tbses}}" data-backdrop="static" ><i class="fa fa-edit"> </i></button>
						<button class="btn btn-danger btn-sm" title="Hapus" data-toggle="modal" data-target="#delete{{$item->id_tbses}}" data-backdrop="static" ><i class="fa fa-trash"> </i></button>

						<div class="modal fade" id="delete{{ $item->id_tbses }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						  <div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<h6>Yakin mau hapus data  ?</h6>
							  </div>
							  <div class="modal-footer">
								<form action="{{ route('penyesuaian.destroy', $item->id_tbses) }}" method="post" class="">
								  @csrf
								  @method('DELETE')
								  <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
								  </button>
								</form>
								<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Kembali</button>
							  </div>
							</div>
						  </div>
						</div>
				  </td>
				</tr>
				@include('pembukuan.penyesuaian.edit')
				@endforeach
			  </tbody>
			  @endif
			</table>
		 </div>
      </div>
    </div>
  </div>
</div>
</div>
@include('pembukuan.penyesuaian.create')
</section>
@endsection

@section('script')
<script>
  $(function() {
    $('.select2').select2()

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $("#example1").DataTable({
        stateSave: true,
      });

    $(document).on('click','#back', function () {
      location.reload();
    });
  })
 </script>
 @endsection
