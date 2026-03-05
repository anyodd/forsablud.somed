@extends('layouts.template')

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data UP (Kas Awal)</h5> 
          </div>
            <div class="card-body px-2 py-2">
            @if($max < $sesi)   
            <a href="{{ route('kasawal.create') }}">
              <button class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle pr-1"></i>
                Tambah UP (Kas Awal)
              </button>
            </a>          
            @elseif ($max = $sesi)
            <button class="btn btn-sm btn-danger" disabled>
              <i class="fas fa-plus-circle pr-1"></i>
               Tambah UP (Kas Awal)
            </button>
            @elseif ($max > $sesi)
            <button class="btn btn-sm btn-danger" disabled>
              <i class="fas fa-plus-circle pr-1"></i>
               Tambah UP (Kas Awal)
            </button>
            @endif
            <br>
            <br>  
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="tabelkasawal" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle">No</th>
                      <th class="text-center" style="vertical-align: middle">Nomor SPP</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal SPP</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      {{-- <th class="text-center" style="vertical-align: middle">Nama Pengusul/PPTK</th>
                      <th class="text-center" style="vertical-align: middle">NIP Pengusul/PPTK</th>
                      <th class="text-center" style="vertical-align: middle">Nama Bendahara</th>
                      <th class="text-center" style="vertical-align: middle">NIP Bendahara</th>
                      <th class="text-center" style="vertical-align: middle">Nama PPK</th>
                      <th class="text-center" style="vertical-align: middle">NIP PPK</th> --}}
					  <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
                  @if ($kasawal->count() > 0)
                  @foreach($kasawal as $number => $kasawal)
                  <?php $no++ ;?>
                  <tr>
                    <td style="text-align: center">{{$no}}</td>                                         
                    <td>{{ $kasawal->No_SPi }}</td>                      
                    <td>{{ $kasawal->Dt_SPi->format('Y-m-d') }}</td>                      
                    <td>{{ $kasawal->Ur_SPi }}</td>  
                    {{-- <td>{{ $kasawal->Nm_PP }}</td>                      
                    <td>{{ $kasawal->NIP_PP }}</td>                      
                    <td>{{ $kasawal->Nm_Ben }}</td>                      
                    <td>{{ $kasawal->NIP_Ben }}</td>
                    <td>{{ $kasawal->Nm_Keu }}</td>                      
                    <td>{{ $kasawal->NIP_Keu }}</td>  --}}     
					<td class="text-right">{{ number_format($kasawal->jml,2,',','.') }}</td> 					
                    <td class="align-top">
                      <div class="row justify-content-center" >

						 <a href="{{ route('sppdup_pdf', $kasawal->id)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
                            <i class="fa fa-print"></i>
                         </a>
						  
                        <form action="kasawal/viewtambahrincian/{{$kasawal->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-success file-alt mx-1" name="submit" id="btnSubmit" title="Tambah Rincian">
                            <i class="fas fa-plus-circle"></i>
                          </button>
                        </form>

                        {{-- <form action="kasawal/rincian/{{$kasawal->id}}" method="get" class="">
                          <input type="text" name="Tag_v" value="1" hidden>
                          <button type="submit" class="btn btn-sm btn-success file-alt mx-1" name="submit" title="List Rincian">
                            <i class="fas fa-file-alt"></i>
                          </button>
                        </form> --}} 
                        @if ($kasawal->Tag_v == 0)
                          <button class="btn btn-sm btn-warning file-alt mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$kasawal->id}}" title="Catatan">
                            <i class="fas fa-envelope"></i>
                          </button>
                        @else
                          <button class="btn btn-sm btn-warning file-alt mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$kasawal->id}}" title="Catatan" disabled>
                            <i class="fas fa-envelope"></i>
                          </button>
                        @endif
                        @if ($kasawal->Tag_v == 0)
                        <button class="btn btn-sm btn-primary file-alt mx-1" data-toggle="modal" data-target="#modal_verif{{$kasawal->id}}" title="verfikasi">
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @else
                        <button class="btn btn-sm btn-primary file-alt mx-1" data-toggle="modal" data-target="#modal_verif{{$kasawal->id}}" title="verfikasi" disabled>
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @endif
						@if ($kasawal->Tag_v == 0)
                        <div class="btn-group">
                          {{-- <button type="button" class="btn btn-sm btn-outline-primary mx-1"><i class="fas fa-align-center"></i></button> --}}
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{route('editkasawal',$kasawal->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $kasawal->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
						@else
						<div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false" disabled>
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{route('editkasawal',$kasawal->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $kasawal->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
						 @endif
                      </div>

                      <!-- modal verifikasi -->
                      <div class="modal fade" id="modal_verif{{ $kasawal->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{route('kasawal.verifikasi',$kasawal->id)}}" method="post">
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

                      <div class="modal fade" id="modal{{ $kasawal->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data {{ $kasawal->Ur_SPi }} dengan nomor SPP {{ $kasawal->No_SPi }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('kasawal.destroy', $kasawal->id) }}" method="post" class="">
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
                  <tr>
                    <td colspan="11">Tidak Ada Data</td>
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
@include('pengajuan.kasawal.log')
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
        url: "{{ route('kasawal.show','') }}"+"/"+id,
        success: function (result) {
          $('#place').html(result);
          $('#place').show();
        }
      });
    });
  </script>
@endsection