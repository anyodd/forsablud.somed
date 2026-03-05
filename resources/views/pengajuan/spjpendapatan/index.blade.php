@extends('layouts.template')

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">SPJ Pendapatan</h5> 
          </div>
            <div class="card-body px-2 py-2">
            <a href="{{ route('spjpendapatan.create') }}">
            <button class="btn btn-sm btn-primary">
              <i class="fas fa-plus-circle pr-1"></i>
              Tambah SPJ Pendapatan
            </button>
            </a>
            <br>
            <br>  
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle">No</th>
                      <th class="text-center" style="vertical-align: middle">Nomor SPJ</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal SPJ</th>
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
                  @foreach($spjpendapatan as $number => $spjpendapatan)
                  <?php $no++ ;?>
                  <tr>
                    <td style="text-align: center">{{$no}}</td>                                        
                    <td>{{ $spjpendapatan->No_SPi }}</td>                      
                    <td>{{ $spjpendapatan->Dt_SPi->format('Y-m-d') }}</td>                      
                    <td>{{ $spjpendapatan->Ur_SPi }}</td>  
                    {{-- <td>{{ $spjpendapatan->Nm_PP }}</td>                                         
                    <td>{{ $spjpendapatan->Nm_Ben }}</td>                      
                    <td>{{ $spjpendapatan->Nm_Keu }}</td> --}}                      
                    <td class="text-right">{{ number_format($spjpendapatan->jml,2,',','.') }}</td>                 
                    <td class="align-top">
                      <div class="row justify-content-center" >
                        {{-- <form action="spjpendapatan/viewtambahrincian/{{$spjpendapatan->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-info file-alt" name="submit" title="Tambah Rincian">
                            <i class="fas fa-plus-circle"></i>
                          </button>
                        </form> --}}
                        <button class="btn btn-sm btn-info file-alt" data-toggle="modal" data-target="#modal_add{{$spjpendapatan->id}}"><i class="fas fa-plus-circle"></i></button>
                        <form action="spjpendapatan/rincian/{{$spjpendapatan->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-success file-alt  mx-1" name="submit" title="List Rincian">
                            <i class="fas fa-file-alt"></i>
                          </button>
                        </form>
                        @if ($spjpendapatan->Tag_v == 0)
                          <button class="btn btn-sm btn-warning file-alt  mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$spjpendapatan->id}}" title="Catatan">
                            <i class="fas fa-envelope"></i>
                          </button>
                        @else
                          <button class="btn btn-sm btn-warning file-alt  mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$spjpendapatan->id}}" title="Catatan" disabled>
                            <i class="fas fa-envelope"></i>
                          </button>
                        @endif
                        @if ($spjpendapatan->Tag_v == 0)
                        <button class="btn btn-sm btn-primary file-alt  mx-1" data-toggle="modal" data-target="#modal_verif{{$spjpendapatan->id}}" title="verfikasi">
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @else
                        <button class="btn btn-sm btn-primary file-alt  mx-1" data-toggle="modal" data-target="#modal_verif{{$spjpendapatan->id}}" title="verfikasi" disabled>
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @endif
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle  mx-1" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{route('spjpendapatanedit', $spjpendapatan->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $spjpendapatan->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
                      </div>

                      <!-- modal tambah rincian -->
                      <div class="modal fade" id="modal_add{{ $spjpendapatan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Rincian SPJ Pendapatan Berdasarkan :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row justify-content-center">
                                <form action="spjpendapatan/viewtambahrincian/{{$spjpendapatan->id}}" method="get">
                                  @csrf
                                  <button type="submit" class="btn btn btn-warning mr-3" name="submit" title="Realiasi Pendapatan">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/realisasi.png"
                                    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1"> Realisasi
                                  </button>
                                </form>
                                <form action="spjpendapatan/viewtambahrinciansts/{{$spjpendapatan->id}}" method="get">
                                  @csrf
                                  <button type="submit" class="btn btn btn-primary mr-3" name="submit" title="Nomor STS">
                                    <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pendapatan/sts.png"
                                    alt="Product 1" class="nav-icon img-circle img-size-32 mr-1"> STS
                                  </button>
                                </form>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- modal tambah rincian -->

                      <!-- modal verifikasi -->
                      <div class="modal fade" id="modal_verif{{ $spjpendapatan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{route('spjpendapatan.verifikasi',$spjpendapatan->id)}}" method="post">
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

                      <div class="modal fade" id="modal{{ $spjpendapatan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data {{ $spjpendapatan->Ur_SPi }} dengan nomor SPJ {{ $spjpendapatan->No_SPi }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('spjpendapatan.destroy', $spjpendapatan->id) }}" method="post" class="">
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
@include('pengajuan.spjpendapatan.popup.log')
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
        url: "{{ route('spjpendapatan.show','') }}"+"/"+id,
        success: function (result) {
          $('#place').html(result);
          $('#place').show();
        }
      });
    });

  </script>

  @endsection