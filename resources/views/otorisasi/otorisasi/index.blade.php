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
            <h5 class="card-title font-weight-bold">Usulan Otorisasi</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <button class="btn btn-info btn-primary" data-toggle="modal" data-target="#modalSetujuBatal" data-backdrop="static">
              <i class="fas fa-list-alt pr-1"></i>Otorisasi blm bernomor
            </button>
            <button class="btn btn-info btn-primary" data-toggle="modal" data-target="#modalNomorBatal" data-backdrop="static">
              <i class="fas fa-list-alt pr-1"></i>Otorisasi bernomor
            </button>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Nomor Usulan</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Usulan</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Usulan</th>
                    <th class="text-center" style="vertical-align: middle;">Nilai Usulan</th>
                    <th class="text-center" style="width: 13%;">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  @if($otorisasi->count() > 0)
                  @foreach ($otorisasi as $number => $otorisasi)
                  <tr>
                    <td>{{$otorisasi ->No_SPi}}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($otorisasi ->Dt_SPi)) }}</td>                      
                    <td>{{$otorisasi ->Ur_SPi}}</td>   
                    <td class="text-right">{{ number_format($otorisasi ->Jumlah, 2, ',', '.') }}</td>                    
                    <td class="align-top">
                      <div class="row justify-content-center" >
                        <div class="col-sm-5">
                          <button class="btn btn-sm btn-warning" type="" name="" value="" data-toggle="modal" data-target="#kembalikan{{$otorisasi->id}}">Kembalikan
                          </button>
                        </div>
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <div class="col-sm-5">
                          <button class="btn btn-sm btn-info" type="" name="" value="" data-toggle="modal" data-target="#oto{{ $otorisasi->id }}">Pilih
                          </button>
                          @include('otorisasi.otorisasi.popup.otorized')
                        </div>
                      </div>
                    </td>
                  </tr>
                  <!-- modal kembalikan otorisasi -->
                  <div class="modal fade" id="kembalikan{{$otorisasi->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{route('otorisasi.batal',$otorisasi->id)}}" method="post">
                          @csrf
                          {{-- @method('PUT') --}}
                        <h6>Apakah yakin akan kembalikan pengajuan SPP ?</h6>
                        <textarea class="form-control" name="ur_logv" id="" cols="50" rows="5" placeholder="catatan" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="Tag_v" value="0" hidden>
                            <input type="text" name="id_spi" value="{{$otorisasi->id}}" hidden>
                            <input type="text" name="Tag_vSpi" value="{{$otorisasi->Tag_v}}" hidden>
                            <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Kembalikan
                            </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Tidak</button>
                        </div>
                    </div>
                    </div>
                  </div>
                  <!-- modal kembalikan otorisasi -->
                  @endforeach
                  @else
                  <tr>
                    <td colspan="6">Tidak Ada Data Usulan Otorisasi</td>
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

@include('otorisasi.otorisasi.popup.otorisasi_setuju_batal')
@include('otorisasi.otorisasi.popup.otorisasi_nomor_batal')

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