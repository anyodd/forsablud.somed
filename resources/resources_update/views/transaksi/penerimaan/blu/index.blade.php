@extends('layouts.template')
@section('title', 'Bukti Terima / Klaim')
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
            <h5 class="card-title font-weight-bold">@yield('title') Bulan {{nm_bulan($bulan)}} 
            </h5> 
          </div>

          <div class="card-body px-2 py-2">
              <a href="{{ route('penerimaan.create') }}">
                <button class="btn btn-sm btn-primary">
                  <i class="fas fa-plus-circle pr-1"></i>
                  Tambah 
                </button>
              </a>
              
              <select class="form-control-sm float-right" name="bulan" id="bulan" onchange="Mymonth()">
                <option value="1" {{$bulan == 1 ? 'selected' : ''}}>Januari</option>
                <option value="2" {{$bulan == 2 ? 'selected' : ''}}>Februari</option>
                <option value="3" {{$bulan == 3 ? 'selected' : ''}}>Maret</option>
                <option value="4" {{$bulan == 4 ? 'selected' : ''}}>April</option>
                <option value="5" {{$bulan == 5 ? 'selected' : ''}}>Mei</option>
                <option value="6" {{$bulan == 6 ? 'selected' : ''}}>Juni</option>
                <option value="7" {{$bulan == 7 ? 'selected' : ''}}>Juli</option>
                <option value="8" {{$bulan == 8 ? 'selected' : ''}}>Agustus</option>
                <option value="9" {{$bulan == 9 ? 'selected' : ''}}>September</option>
                <option value="10" {{$bulan == 10 ? 'selected' : ''}}>Oktober</option>
                <option value="11" {{$bulan == 11 ? 'selected' : ''}}>November</option>
                <option value="12" {{$bulan == 12 ? 'selected' : ''}}>Desember</option>
              </select>
              <p class="form-control-sm font-weight-bold float-right">Bulan</p>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center"  style="vertical-align: middle; text-align: left; width:5%;">No</th>
                    <th class="text-center" style="vertical-align: middle; width:15%;">Nomor Bukti/Klaim</th>
                    <th class="text-center" style="vertical-align: middle; width:10%;">Tanggal Bukti/Klaim</th>
                    <th class="text-center" style="vertical-align: middle; width:25%;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle; width:15%;">Nama kasir / penjamin</th>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">Total Pengajuan (Rp)</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($penerimaan as $number => $data)
                  <tr>
                    <td class="text-center" >{{$loop->iteration}}</td>                                  
                    <td>{{ $data->No_bp }}</td>
                    <td class="text-center">{{ date('d M Y', strtotime($data->dt_bp)) }}</td>                      
                    <td>{{ $data->Ur_bp }}</td>                      
                    <td>{{ $data->nm_BUcontr }}</td>                      
                    <td class="text-right">{{ number_format($data->Total,2,',','.') }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-4">
                            <a href= "{{route('subpenerimaan.rincian',$data->id_bp)}}">
                              <button class="btn btn-info btn-block" style="display: flex; align-items: center; justify-content: center;" title="Detail">
                              <i class="fas fa-angle-double-right"></i></button>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('penerimaan.edit', $data->id_bp) }}">
                              <button class="btn btn-warning btn-block" style="display: flex; align-items: center; justify-content: center;" title="Edit">
                              <i class="fas fa-edit"></i></button>
                            </a>
                        </div>
                        @if ($data->id_byr != null)
                          <div class="col-sm-4">
                            <a href="#">
                              <button class="btn btn-danger btn-block" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modalHapusPenerimaan{{$data->id_bp}}" title="hapus" disabled>
                              <i class="fas fa-trash-alt"></i></button>
                            </a>
                          </div>
                        @else
                          <div class="col-sm-4">
                            <a href="#">
                              <button class="btn btn-danger btn-block" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modalHapusPenerimaan{{$data->id_bp}}" title="hapus">
                              <i class="fas fa-trash-alt"></i></button>
                            </a>
                          </div>  
                        @endif

                      <div class="modal fade" id="modalHapusPenerimaan{{$data->id_bp}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{ route('penerimaan.destroy', $data->id_bp) }}" method="post" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger " name="submit" title="Hapus">Ya, Hapus
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

    function Mymonth()
    {
      var slug = $('#bulan').val();
      console.log(slug);
      var url = '{{ route("penerimaan.bulan", ":slug") }}';
      url = url.replace(':slug', slug);
      window.location.href=url;
    }

  </script>

  @endsection