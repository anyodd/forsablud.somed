@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Rekanan</h5> 
          </div>

          <div class="card-body px-2 py-2">
            {{--<a href="{{ route('rekanan.create') }}" class="btn btn-sm mb-2">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian">
            </a>--}}
            <div class="row my-3">
              <div class="col-6 text-left">
                <a href="{{ route('rekanan.create') }}" class="btn btn-sm btn-success" title="Tambah Rekanan">
                  <i class="fas fa-plus"></i> Tambah Rekanan
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 3%;">No</th>
                    <th class="text-center" style="vertical-align: middle">Nama Rekanan</th>
                    <th class="text-center" style="vertical-align: middle">Nomor NPWP</th>
                    <th class="text-center" style="vertical-align: middle">Rekening Bank</th>
                    <th class="text-center" style="vertical-align: middle">Nama Bank</th>
                    <th class="text-center" style="vertical-align: middle;">Alamat</th>
                    <th class="text-center" style="vertical-align: middle;">No. Telp/HP</th>
                    <th class="text-center" style="vertical-align: middle;">Email</th>
                    <th class="text-center" style="vertical-align: middle;">Bentuk Perusahaan</th>
                    <th class="text-center" style="vertical-align: middle; width: 7%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($rekanan->count() > 0)
                  @foreach($rekanan as $number => $rekanan)
                  <tr>
                    <td class="text-center">{{ $loop->iteration}}.</td>                          
                    <td>{{ $rekanan->rekan_nm }}</td>                      
                    <td>{{ $rekanan->rekan_npwp }}</td>                      
                    <td>{{ $rekanan->rekan_rekbank }}</td>                      
                    <td>{{ $rekanan->rekan_nmbank }}</td>                      
                    <td>{{ $rekanan->rekan_adr }}</td>                 
                    <td>{{ $rekanan->rekan_ph }}</td>                 
                    <td>{{ $rekanan->rekan_mail }}</td>                 
                    <td class="text-center">{{ $rekanan->ur_usaha }}</td>                 
                    <td>
                      <div class="row justify-content-center" >
                        {{-- <form action="{{ route('rekanan.edit', $rekanan->id_rekan) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form> --}}
                        @if ( $rekanan->kode !=  0 )
                        <form action="{{ route('rekanan.edit', $rekanan->id_rekan) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $rekanan->id_rekan }}" title="Hapus"> 
                            <i class="fas fa-trash-alt"></i>
                          </button>           
                        @else
                        <form action="{{ route('rekanan.edit', $rekanan->id_rekan) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" disabled> 
                          <i class="fas fa-trash-alt"></i>
                        </button> 
                        @endif 
                        
                      </div>
                      <div class="modal fade" id="modal{{ $rekanan->id_rekan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data Rekanan: {{ $rekanan->rekan_nm }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('rekanan.destroy', $rekanan->id_rekan) }}" method="post" class="">
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