@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Rincian Pengajuan</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;width: 3%">No.</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      <th class="text-center" style="vertical-align: middle">Ref</th>
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($spirc))
                  @foreach($spirc as $number => $spirc)
                  <tr>
                    <td style="text-align: center">{{$loop->iteration}}.</td>                                         
                    <td>{{ $spirc->No_bp }}</td>                      
                    <td class="text-center">{{ \Carbon\Carbon::parse($spirc->dt_bp)->format('d-m-Y')}}</td>                      
                    <td>{{ $spirc->Ur_bprc }}</td>  
                    <td>{{ $spirc->rftr_bprc }}</td>  
                    <td class="text-right">{{ number_format($spirc->spirc_Rp,2,',','.') }}</td>  
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="11">Tidak Ada Data</td>
                  </tr>
                  @endif
                </tbody>
                
              </table>
              <div class="form-group row justify-content-center mt-3">
                <button class="col-sm-2 btn btn-primary ml-3" data-toggle="modal" data-target="#verifikasi">
                  <i class="fas fa-file-signature pr-2"></i>Verifikasi
                </button>
                <button class="col-sm-2 btn btn-warning ml-3" data-toggle="modal" data-target="#kembalikan">
                  <i class="fas fa-file-export pr-2"></i>Batal Verifikasi
                </button>
                <a href="{{ route('verifikasi.index') }}" class="col-sm-2 btn btn-danger ml-3">
                  <i class="fas fa-backward pr-2"></i>Kembali
                </a> 
              </div>

              <!-- modal verifikasi -->
              <div class="modal fade" id="verifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <h6>Ajukan SPP untuk <b>diotorisasi</b> ?</h6>
                    </div>
                    <div class="modal-footer">
                    <form action="{{route('verifikasi.update',$id_spi)}}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="text" name="Tag_v" value="2" hidden>
                        <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Ajukan
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Tidak</button>
                    </div>
                </div>
                </div>
              </div>
              <!-- modal verifikasi -->

              <!-- modal kembalikan otorisasi -->
              <div class="modal fade" id="kembalikan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form action="{{route('verifikasi.batal',$id_spi)}}" method="post">
                      @csrf
                      {{-- @method('PUT') --}}
                    <h6>Apakah yakin akan kembalikan pengajuan SPP ?</h6>
                    <textarea class="form-control" name="ur_logv" id="" cols="50" rows="5" placeholder="catatan" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="Tag_v" value="0" hidden>
                        <input type="text" name="id_spi" value="{{$id_spi}}" hidden>
                        <input type="text" name="Tag_vSpi" value="1" hidden>
                        <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Kembalikan
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Tidak</button>
                    </div>
                </div>
                </div>
              </div>
              <!-- modal kembalikan otorisasi -->

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