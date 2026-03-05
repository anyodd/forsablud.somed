@extends('layouts.template')
@section('style') @endsection

@section('content')
<div class="row">
  <a href="#" class="col-sm-1 btn btn-success ml-3 py-1 disabled">Unit</a>
  <a href="{{ route('unitsub.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">BLUD</a>
  <a href="{{ route('unitsub1.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">Bidang</a>
</div>
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Unit</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Nama Unit</th>
                    <th class="text-center" style="vertical-align: middle;">Kepala Unit</th>
                    <th class="text-center" style="vertical-align: middle;">Kabag Keu</th>
                    <th class="text-center" style="vertical-align: middle;">Bendahara</th>
                    <th class="text-center" style="vertical-align: middle;">Alamat</th>
                    <th class="text-center" style="vertical-align: middle;">Jml BLUD</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($unit->count() > 0)
                  @foreach($unit as $number => $unit)
                  <tr>
                    <td>{{ $unit->Ur_Unit }}</td>                      
                    <td>{{ $unit->Nm_Pimp }} <br> NIP {{ $unit->NIP_Pimp }} </td>                      
                    <td>{{ $unit->Nm_Keu }} <br> NIP {{ $unit->NIP_Keu }} </td>                      
                    <td>{{ $unit->Nm_Bend }} <br> NIP {{ $unit->NIP_Bend }} </td>                      
                    <td>{{ $unit->Nm_Jln }}</td>                      
                    <td class="text-center">{{ $unit->jumkosub }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('unit.edit', $unit->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>
                      </div>
                    </td>

                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td>Tidak Ada Data</td>
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