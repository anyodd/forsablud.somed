@extends('layouts.template')

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data LS Kontrak/SPK</h5> 
          </div>
            <div class="card-body px-2 py-2">
            <a href="{{ route('lskontrak.create') }}">
            <button class="btn btn-sm btn-primary">
              <i class="fas fa-plus-circle pr-1"></i>
              Tambah LS Kontrak
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
                      {{-- <th class="text-center" style="vertical-align: middle">Nama Pengusul/PPTK</th> --}}
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
                  @if ($lskontrak->count() > 0)
                  @foreach($lskontrak as $number => $lskontrak)
                  <?php $no++ ;?>
                  <tr>
                    <td style="text-align: center">{{$no}}</td>                                         
                    <td>{{ $lskontrak->No_SPi }}</td>                      
                    <td>{{ $lskontrak->Dt_SPi->format('Y-m-d') }}</td>                      
                    <td>{{ $lskontrak->Ur_SPi }}</td>  
                    {{-- <td>{{ $lskontrak->Nm_PP }}</td> --}}                       
                    <td class="text-right">{{ number_format($lskontrak->jml,2,',','.') }}</td>                
                    <td class="align-top">
                      <div class="row justify-content-center" >
                        {{-- <form action="lskontrak/viewtambahrincian/{{$lskontrak->id}} " method="get" class="">
                          <button type="submit" class="btn btn-sm btn-info file-alt mx-1" name="submit" title="Tambah Rincian">
                            <i class="fas fa-plus-circle"></i>
                          </button>
                        </form>
                        <form action="lskontrak/rincian/{{$lskontrak->id}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-success file-alt mx-1" name="submit" title="List Rincian">
                            <i class="fas fa-file-alt"></i>
                          </button>
                        </form> --}}

                        <a href="{{ route('sppdls_pdf', $lskontrak->id)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
                          <i class="fa fa-print"></i>
                        </a>

                        <form action="{{route('lskontrak.viewtambahrincian',$lskontrak->id)}}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-success file-alt mx-1" name="submit" title="Tambah Rincian">
                            <i class="fas fa-plus-circle"></i>
                          </button>
                        </form>
                        @if ($lskontrak->Tag_v == 0)
                          <button class="btn btn-sm btn-warning file-alt mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$lskontrak->id}}" title="Catatan">
                            <i class="fas fa-envelope"></i>
                          </button>
                        @else
                          <button class="btn btn-sm btn-warning file-alt mx-1" data-toggle="modal" data-target="#modal_log" id="catatan" data-row="{{$lskontrak->id}}" title="Catatan" disabled>
                            <i class="fas fa-envelope"></i>
                          </button>
                        @endif
                        @if ($lskontrak->Tag_v == 0)
                        <button class="btn btn-sm btn-primary file-alt mx-1" data-toggle="modal" data-target="#modal_verif{{$lskontrak->id}}" title="verfikasi">
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @else
                        <button class="btn btn-sm btn-primary file-alt mx-1" data-toggle="modal" data-target="#modal_verif{{$lskontrak->id}}" title="verfikasi" disabled>
                          <i class="fas fa-file-invoice"></i>
                        </button>
                        @endif
						@if ($lskontrak->Tag_v == 0)
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            {{-- <button class="btn btn-sm" id="history" value="{{$lskontrak->id}}"><i class="fas fa-book"></i> History</button> --}}
                            <a class="dropdown-item" href="{{route('lskontrakedit', $lskontrak->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $lskontrak->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
						@else
						<div class="btn-group">
                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false" disabled>
                            <i class="fas fa-bell"></i>
                          </button>
                          <div class="dropdown-menu" role="menu" style="">
                            {{-- <button class="btn btn-sm" id="history" value="{{$lskontrak->id}}"><i class="fas fa-book"></i> History</button> --}}
                            <a class="dropdown-item" href="{{route('lskontrakedit', $lskontrak->id)}}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal{{ $lskontrak->id }}"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
						@endif
                      </div>

                      <!-- modal verifikasi -->
                      <div class="modal fade" id="modal_verif{{ $lskontrak->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{route('lskontrak.verifikasi',$lskontrak->id)}}" method="post">
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

                      <div class="modal fade" id="modal{{ $lskontrak->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data {{ $lskontrak->Ur_SPi }} dengan nomor SPP {{ $lskontrak->No_SPi }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('lskontrak.destroy', $lskontrak->id) }}" method="post" class="">
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
@include('pengajuan.lskontrak.popup.log')
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });

  $(document).on('click','#catatan', function () {
    var id = $(this).data('row');
    $.ajax({
      type: "GET",
      url: "{{ route('lskontrak.show','') }}"+"/"+id,
      success: function (result) {
        $('#place').html(result);
        $('#place').show();
      }
    });
  });
</script>
<script>
  $('#history').click(function (e) { 
    var id = $('#history').val();
    $.ajax({
      type: 'GET',
      url: '/lskontrak/history/'+id,
      dataType: 'JSON',
      success: function (response) {
        console.log(response);
      }
    });
  });
</script>
@endsection