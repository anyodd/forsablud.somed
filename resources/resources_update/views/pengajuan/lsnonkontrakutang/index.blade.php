@extends('layouts.template')

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="container-fluid">
     {{-- <div class="row">
        <div class="col-md-12">
            <a href="{{route('lsnonkontrak.index')}}" class="btn btn-primary">Tahun Berjalan</a>
            <a href="{{route('lsnonkontrakutang.index')}}" class="btn btn-primary disabled">Tahun Lalu</a>
        </div>
      </div> --}}
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data LS Tagihan</h5> 
          </div>
            <div class="card-body px-2 py-2">
            <a href="{{ route('lsnonkontrakutang.create') }}">
            <button class="btn btn-sm btn-primary">
              <i class="fas fa-plus-circle pr-1"></i>
              Tambah LS Tagihan
            </button>
            </a>
            <br>
            <br>  
            <div class="table-responsive">
            
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle">No</th>
                      <th class="text-center" style="vertical-align: middle">Nomor SPP</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal SPP</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      {{-- <th class="text-center" style="vertical-align: middle">Nama Pengusul/PPTK</th>
                      <th class="text-center" style="vertical-align: middle">Nama Bendahara</th>
                      <th class="text-center" style="vertical-align: middle">Nama PPK</th> --}}  
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
                  @if ($lsnonkontrakutang->count() > 0)
                  @foreach($lsnonkontrakutang as $number => $lsnonkontrakutang)
                  <?php $no++ ;?>
                  <tr>
                    <td style="text-align: center">{{$no}}</td>                                         
                    <td>{{ $lsnonkontrakutang->No_SPi }}</td>                      
                    <td>{{ $lsnonkontrakutang->Dt_SPi->format('Y-m-d') }}</td>                      
                    <td>{{ $lsnonkontrakutang->Ur_SPi }}</td>  
                    {{-- <td>{{ $lsnonkontrakutang->Nm_PP }}</td>                       
                    <td>{{ $lsnonkontrakutang->Nm_Ben }}</td>  
                    <td>{{ $lsnonkontrakutang->Nm_Keu }}</td> --}}                 
                    <td class="text-right">{{ number_format($lsnonkontrakutang->jml,2,',','.') }}</td>               
                    <td class="align-top">
                      <div class="row justify-content-center" >
                        
                        <a href="{{ route('sppdlsnonutang_pdf', $lsnonkontrakutang->id)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
                          <i class="fa fa-print"></i>
                        </a>

                        <form action="lsnonkontrakutang/viewtambahrincian/{{$lsnonkontrakutang->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-info file-alt" name="submit" title="Tambah Rincian">
                            <i class="fas fa-plus-circle"></i>
                          </button>
                        </form>
                        &nbsp&nbsp&nbsp
                        <form action="lsnonkontrakutang/rincian/{{$lsnonkontrakutang->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-success file-alt" name="submit" title="List Rincian">
                            <i class="fas fa-file-alt"></i>
                          </button>
                        </form>
                        &nbsp&nbsp&nbsp
                        @if ($lsnonkontrakutang->Tag_v == 0)
                          <button class="btn btn-sm btn-warning file-alt" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$lsnonkontrakutang->id}}" title="Catatan">
                            <i class="fas fa-envelope"></i>
                          </button>
                        @else
                          <button class="btn btn-sm btn-warning file-alt" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$lsnonkontrakutang->id}}" title="Catatan" disabled>
                            <i class="fas fa-envelope"></i>
                          </button>
                        @endif
                        &nbsp&nbsp&nbsp
                        @if ($lsnonkontrakutang->Tag_v == 0)
                        <button class="btn btn-sm btn-primary file-alt" data-toggle="modal" data-target="#modal_verif{{$lsnonkontrakutang->id}}" title="verfikasi">
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @else
                        <button class="btn btn-sm btn-primary file-alt" data-toggle="modal" data-target="#modal_verif{{$lsnonkontrakutang->id}}" title="verfikasi" disabled>
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @endif
                        &nbsp&nbsp&nbsp
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{route('lsnonkontrakutangedit', $lsnonkontrakutang->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $lsnonkontrakutang->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
                      </div>

                      <!-- modal verifikasi -->
                      <div class="modal fade" id="modal_verif{{ $lsnonkontrakutang->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Ajukan SPP untuk <b>diverifikasi</b> ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{route('lsnonkontrakutang.verifikasi',$lsnonkontrakutang->id)}}" method="post">
                                @csrf
                                <input type="text" name="Tag_v" value="1" hidden>
                                <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Ajukan
                                </button>
                              </form>
                              <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Tidak</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- modal verifikasi -->

                      <div class="modal fade" id="modal{{ $lsnonkontrakutang->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data {{ $lsnonkontrakutang->Ur_SPi }} dengan nomor SPP {{ $lsnonkontrakutang->No_SPi }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('lsnonkontrakutang.destroy', $lsnonkontrakutang->id) }}" method="post" class="">
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
                  @else
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
@include('pengajuan.lsnonkontrakutang.popup.log')
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

    $(document).on('click','#catatan', function () {
      var id = $(this).data('row');
      $.ajax({
        type: "GET",
        url: "{{ route('lsnonkontrakutang.show','') }}"+"/"+id,
        success: function (result) {
          $('#place').html(result);
          $('#place').show();
        }
      });
    });

  </script>

  @endsection