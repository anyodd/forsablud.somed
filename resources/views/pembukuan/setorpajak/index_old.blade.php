@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Setor Pajak</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <a href="{{ route('setorpajak.create') }}" class="btn btn-sm btn-primary mb-2"><i class="fas fa-list-alt"></i> Setor Pajak
              {{-- <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian"> --}}
            </a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 3%;">No</th>
                    <th class="text-center" style="vertical-align: middle">Nama Rekanan</th>
                    <th class="text-center" style="vertical-align: middle">Uraian</th>
                    <th class="text-center" style="vertical-align: middle">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle">Jenis Pajak</th>
                    <th class="text-center" style="vertical-align: middle">Bank</th>
                    <th class="text-center" style="vertical-align: middle;">Kode Billing</th>
                    <th class="text-center" style="vertical-align: middle;">No. NTPN</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($pajak))
                  @foreach($pajak as $number => $pajak)
                  <tr>
                    <td class="text-center">{{ $loop->iteration}}.</td>                          
                    <td>{{ $pajak->rekan_nm }}</td>                      
                    <td>{{ $pajak->Ur_taxtor }}</td>                      
                    <td>{{ $pajak->dt_taxtor }}</td>                      
                    <td>{{ $pajak->ur_rk6 }}</td>                      
                    <td>{{ $pajak->Ur_Bank }} - {{$pajak->No_Rek}}</td>                      
                    <td>{{ $pajak->No_bill }}</td>                  
                    <td>{{ $pajak->No_ntpn }}</td>                 
                    <td>
                      <div class="row justify-content-center" >
                        <form action="{{ route('setorpajak.show', $pajak->id_taxtor) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-info mr-2" name="submit" title="Edit">
                            <i class="fas fa-angle-double-right"></i>
                          </button>
                        </form>
                        <form action="{{ route('setorpajak.edit', $pajak->id_taxtor) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $pajak->id_taxtor }}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{ $pajak->id_taxtor }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data setor pajak: {{ $pajak->Ur_taxtor }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('setorpajak.destroy', $pajak->id_taxtor) }}" method="post" class="">
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