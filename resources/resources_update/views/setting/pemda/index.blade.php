@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Pemda</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">#</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Pemda</th>
                    <th class="text-center" style="vertical-align: middle;">Ibukota</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Kepala Daerah</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Sekda</th>
                    <th class="text-center" style="vertical-align: middle;">Nama PPKD</th>
                    <th class="text-center" style="vertical-align: middle;">Nama BUD</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($pemda->count() > 0)
                  @foreach($pemda as $number => $pemda)
                  <tr>
                    <td>{{ $pemda->Ko_Wil1 }} - {{ $pemda->Ko_Wil2 }}</td>                      
                    <td>{{ $pemda->Ur_Pemda }}</td>                      
                    <td>{{ $pemda->Ibukota }}</td>                      
                    <td>{{ $pemda->Ur_Kpl }}</td>                      
                    <td>{{ $pemda->Ur_Sekda }}</td>                      
                    <td>{{ $pemda->Ur_PPKD }}</td>                      
                    <td>{{ $pemda->Ur_BUD }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('pemda.edit', $pemda->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>Edit
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