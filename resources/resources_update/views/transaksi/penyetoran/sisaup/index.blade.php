@extends('layouts.template')
@section('title', 'Penyetoran Sisa Kas')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection


@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">@yield('title') Uang Persediaan</h5> 
          </div>

          <div class="card-body px-2 py-2">
              <a href="{{ route('sisaup.create') }}">
                <button class="btn btn-sm btn-primary">
                  <i class="fas fa-plus-circle pr-1"></i>
                  Tambah 
                </button>
              </a>
            <br>
            <br>            
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center"  style="text-align: left;max-width: 50px;">No</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Penyetoran</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle; width: 15%;">Nilai Sisa Kas (Rp)</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $number => $data)
                  <tr>
                    <td class="text-center" >{{$loop->iteration}}</td>                       
                    <td class="text-center" style="width: 15%">{{ date('d M Y', strtotime($data->dt_sikas)) }}</td>                      
                    <td>{{ $data->sikas_ur }}</td>                                          
                    <td class="text-right">{{ number_format($data->sikas_Rp,2,',','.'); }}</td>                                      
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-4">
                            <a href="{{route('sisaup.edit',$data->id_sikas)}}">
                              <button class="btn btn-warning btn-block" style="display: flex; align-items: center; justify-content: center;" title="Edit">
                              <i class="fas fa-edit"></i></button>
                            </a>
                        </div>
                        <div class="col-sm-4">
                              <button data-toggle="modal" data-target="#modal{{ $data->id_sikas }}" class="btn btn-danger btn-block" style="display: flex; align-items: center; justify-content: center;" title="Hapus">
                              <i class="fas fa-trash-alt"></i></button>
                        </div>

                      <div class="modal fade" id="modal{{ $data->id_sikas }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('sisaup.destroy', $data->id_sikas) }}" method="post" class="">
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
                  @endforeach
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