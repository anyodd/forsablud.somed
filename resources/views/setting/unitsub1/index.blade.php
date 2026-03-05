@extends('layouts.template')
@section('style') @endsection

@section('content')
<div class="row">
  <a href="{{ route('unit.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">Unit</a>
  <a href="{{ route('unitsub.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">BLUD</a>
  <a href="#" class="col-sm-1 btn btn-success ml-3 py-1 disabled">Bidang</a>
</div>
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Bidang</h5> 
          </div>

          <div class="card-body px-2 py-2">
			<div class="row my-3">
              <div class="col-6 text-left">
					<a class="btn btn-sm btn-success" href="{{ route('unitsub1.create') }}">
						 <i class="fas fa-plus-circle pr-1"></i>
						  Tambah Bidang
					</a>
				</div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">Kode Bidang</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Bidang</th>
                    <th class="text-center" style="vertical-align: middle;">Kepala Bidang</th>
                    <!-- <th class="text-center" style="vertical-align: middle;">Keuangan Bidang</th> -->
                    <th class="text-center" style="vertical-align: middle;">Bendahara Bidang</th>
                    <th class="text-center" style="vertical-align: middle;">Alamat Bidang</th>
                    <th class="text-center" style="width: 10%; vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($unitsub1->count() > 0)
                  @foreach($unitsub1 as $number => $unitsub1)
                  <tr>
                    <td class="text-center">{{ substr($unitsub1->ko_unit1, 19, 3) }}</td>                      
                    <td>{{ $unitsub1->ur_subunit1 }}</td>                      
                    <td>{{ $unitsub1->Nm_Pimp }} <br> NIP {{ $unitsub1->NIP_Pimp }} </td>                      
                    <!-- <td>{{ $unitsub1->Nm_Keu }} <br> NIP {{ $unitsub1->NIP_Keu }} </td>                       -->
                    <td>{{ $unitsub1->Nm_Bend }} <br> NIP {{ $unitsub1->NIP_Bend }} </td>                      
                    <td>{{ $unitsub1->Nm_Jln }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('unitsub1.edit', $unitsub1->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        {{--<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $unitsub1->id }}" title="hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>--}}
                      </div>

                      <div class="modal fade" id="modal{{ $unitsub1->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data BLUD: {{ $unitsub1->ur_subunit1 }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('unitsub1.destroy', $unitsub1->id) }}" method="post" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                </button>
                              </form>
                              <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                            </div>
                          </div>
                        </div>
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

<script>
  $(document).ready(function() {
    $('#example').DataTable( {
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