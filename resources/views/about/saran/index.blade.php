@extends('layouts.template')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid text-sm">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Saran dan Masukan </h5> 
          </div>

          <div class="card-body px-2 py-2">
            <a href="{{ route('saran.create') }}" class="btn btn-sm mb-2">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian">
            </a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Menu</th>
                    <th class="text-center">Kondisi</th>
                    <th class="text-center">Saran</th>
                    <th class="text-center">Tanggapan</th>
                    <th class="text-center">User</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="vertical-align: middle; width: 7%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  @if($saran->count() > 0)
                  @foreach ($saran as $number => $saran)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>                      
                    <td>{{$saran ->ur_menu}}</td>   
                    <td>{{$saran ->kondisi}}</td>   
                    <td>{{$saran ->saran}}</td>   
                    <td>{{$saran ->tanggapan}}</td>   
                    <td>{{$saran ->user}}</td>
                    @if($saran ->status == 'open')   
                    <td class="btn btn-sm bg-danger rounded-pill">{{$saran ->status}}</td>
                    @elseif($saran ->status == 'on process')   
                    <td class="btn btn-sm bg-warning rounded-pill">{{$saran ->status}}</td>
                    @else   
                    <td class="btn btn-sm bg-success rounded-pill">{{$saran ->status}}</td>
                    @endif
                    <td>
                      <div class="row justify-content-center" >
                        {{--
                        <form action="{{ route('rekanan.edit', $saran->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>
                        --}}

                        @if($saran->user == $user)
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $saran->id }}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        @else
                        
                        @endif
                      </div>

                      <div class="modal fade" id="modal{{ $saran->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus Saran/Masukan: {{ $saran->ur_menu }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('saran.destroy', $saran->id) }}" method="post" class="">
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

<script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(document).ready(function() {
    $('.example1').DataTable();
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