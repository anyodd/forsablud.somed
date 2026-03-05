@extends('layouts.template')
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
            <h5 class="card-title font-weight-bold">Rincian Pengesahan</h5> 
          </div>

          <div class="card-body px-2 py-2">
          <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSpd">Tambah</button>
                            </div>
                        </div>
                        <br>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width: 10%;">No Urut</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                    <th class="text-center" style="vertical-align: middle;">Nilai Otorisasi (Rp)</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  
                @if($rincian->count() > 0)
                @foreach ($rincian as $number => $rincian)

                  <tr>
                    <td class="text-center">{{$rincian ->id}}</td>                       
                    <td>{{$rincian ->No_oto}}</td>                      
                    <td>{{$rincian ->sp3rc_Rp}}</td>                                                       
                    <td>
                      <div class="row justify-content-center" >
                      <div class="row">
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-danger btn-block" style="display: flex; align-items: center; justify-content: center;" title="Hapus"><i class="far fa-trash-alt"></i></button>
                                                    </div>
                                                  
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