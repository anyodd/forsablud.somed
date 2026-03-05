@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Jenis Pelayanan</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <a href="{{ route('jnslayanan.create') }}" class="btn btn-sm mb-2">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian">
            </a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">Kode Jenis</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Layanan</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($pmed->count() > 0)
                  @foreach($pmed as $number => $pmed)
                  <tr>
                    <td class="text-center">{{ $pmed->ko_pmed }}</td>                      
                    <td>{{ $pmed->ur_pmed }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('jnslayanan.edit', $pmed->ko_pmed) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $pmed->ko_pmed }}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{ $pmed->ko_pmed }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data Jenis Pelayanan: {{ $pmed->ur_pmed }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('jnslayanan.destroy', $pmed->ko_pmed) }}" method="post" class="">
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