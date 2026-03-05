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
            <h5 class="card-title font-weight-bold">Rincian Realisasi</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <a href="{{ route('penerimaan.index') }}" class="btn btn-sm bg-gradient-success mb-2">
              <i class="fas fa-book pr-1"></i> Penerimaan BLU
            </a>
            <a href="{{ route('realisasi.index') }}" class="btn btn-sm bg-gradient-success mb-2">
              <i class="fas fa-book pr-1"></i> Realisasi
            </a>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#">Tambah</button>
                  </div>
            </div>

            <br>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Nomor Tagihan</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Pembayaran</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Bayar</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Dir/Kuasa</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Bendaraha</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Pejabat Keuangan</th>                    
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($realisasi as $number => $realisasi)
                  <tr>
                    <td class="text-center">{{ $realisasi->Ko_Period }}</td>                       
                    <td>{{ $realisasi->No_byr }}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($realisasi->dt_byr)) }}</td>                      
                    <td>{{ $realisasi->Ur_byr }}</td>                      
                    <td></td>                      
                    <td>{{ $realisasi->to_rp }}</td>                                      
                    <td>
                      <div class="row justify-content-center" >
                        <button type="button" class="btn btn-sm btn-success" name="submit" title="View">
                            <i class="fas fa-book"></i>
                        </button>&nbsp

                        <form action="{{ route('realisasi.edit', $realisasi->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning mr-2" name="submit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusRealisasi" title="hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modalHapusRealisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{ route('realisasi.destroy', $realisasi->id) }}" method="post" class="">
                                <!-- @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                </button> -->
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

  </script>

  @endsection