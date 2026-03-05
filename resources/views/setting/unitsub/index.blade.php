@extends('layouts.template')
@section('style') @endsection

@section('content')
<div class="row">
  <a href="{{ route('unit.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">Unit</a>
  <a href="#" class="col-sm-1 btn btn-success ml-3 py-1 disabled">BLUD</a>
  <a href="{{ route('unitsub1.index') }}" class="col-sm-1 btn btn-success ml-3 py-1">Bidang</a>
</div>
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data BLUD</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">Kode BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Nama BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Kepala BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Kabag Keu BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Bendahara BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Alamat BLUD</th>
                    <th class="text-center" style="vertical-align: middle;">Jml Bidang</th>
                    <th class="text-center" style="vertical-align: middle;">SPD</th>
                    <th class="text-center" style="vertical-align: middle;">APBD Dimunculkan</th>
                    <th class="text-center" style="width: 10%; vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($unitsub->count() > 0)
                  @foreach($unitsub as $number => $unitsub)
                  <tr>
                    <td>{{ $unitsub->Ko_Sub }}</td>                      
                    <td>{{ $unitsub->ur_subunit }}</td>                      
                    <td>{{ $unitsub->Nm_Pimp }} <br> NIP {{ $unitsub->NIP_Pimp }} </td>                      
                    <td>{{ $unitsub->Nm_Keu }} <br> NIP {{ $unitsub->NIP_Keu }} </td>                      
                    <td>{{ $unitsub->Nm_Bend }} <br> NIP {{ $unitsub->NIP_Bend }} </td>                      
                    <td>{{ $unitsub->Nm_Jln }}</td>                      
                    <td class="text-center">{{ $unitsub->jumkosub1 }}</td>                      
                    <td class="text-center">{{ $unitsub->set_PD == 0 ? 'Tidak' : 'Ya' }}</td>    
                    <td class="text-center">{{ $unitsub->apbd == 0 ? 'Tidak' : 'Ya' }}</td>                    
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('unitsub.edit', $unitsub->id) }}" method="get" class="">
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