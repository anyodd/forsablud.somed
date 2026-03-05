@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Rincian Setor Pajak</h5> 
          </div>
          
          <div class="card-body px-2 py-2">
            <a href="{{ route('setorpajak.tambah',[$id_taxtor,$id_taxtr]) }}" class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus-circle"></i> Tambah
            </a>
            <a href="{{ route('setorpajak.index') }}" class="btn btn-info btn-sm mb-2"><i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
                      <th>Rekanan</th>
                      <th>No. Tagihan</th>
                      <th>Tagihan</th>
                      <th>Total Tagihan</th>
                      <th>Jenis Pajak</th>
                      <th>Uraian Pajak</th>
                      <th>Pajak (Rp)</th>
                      <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($pajakrinci))
                  @foreach($pajakrinci as $number => $pajakrinci)
                  <tr>
                    <td class="text-center">{{$loop->iteration}}.</td>
                    <td>{{$pajakrinci->rekan_nm}}</td>
                    <td>{{$pajakrinci->No_bp}}</td>
                    <td>{{$pajakrinci->Ur_bp}}</td>
                    <td class="text-right">{{number_format($pajakrinci->t_tag,2,',','.')}}</td>
                    <td>{{$pajakrinci->ur_rk6}}</td>
                    <td>{{$pajakrinci->Ko_tax}}</td>
                    <td class="text-right">{{number_format($pajakrinci->taxtor_Rp,2,',','.')}}</td>                  
                    <td>
                      <div class="row justify-content-center" >

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $pajakrinci->id_taxtorc }}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{ $pajakrinci->id_taxtorc }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data setor pajak: {{ $pajakrinci->Ur_taxtor }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('setorpajak.destroy_detail', $pajakrinci->id_taxtorc) }}" method="post" class="">
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