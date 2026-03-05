@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-1">
  {{--<div class="row px-1">
    <button class="col-sm-1 btn btn-outline-primary ml-3 py-1" data-toggle="modal" data-target="#modal-addUser"><i class="fas fa-user-plus"></i>User</button>
  </div>--}}
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Pengguna</h5> 
          </div>
          
          <div class="card-body px-2 py-2">
            <div class="row my-3">
              <div class="col-6 text-left">
                <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-addUser" title="Tambah Data Pengguna">
                  <i class="fas fa-user-plus"></i> Tambah Data Pengguna
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="dtable" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>

                    <th class="text-center" style="vertical-align: middle;">No</th> 
                    <th class="text-center" style="vertical-align: middle;">NIP</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Pegawai</th>
                    <th class="text-center" style="vertical-align: middle;">Email</th>
                    <th class="text-center" style="vertical-align: middle;">Hak Akses</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1; @endphp
                  @foreach ($user as $item)
                    <tr>
                        <td class="text-center" style="width: 2%">{{ $no++ }}.</td>
                        <td class="text-center" style="width: 15%">{{ $item->username }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">{{ $item->email }}</td>
                        
                        @if($item->user_level == '1')
                          <td class="text-center">Admin</td>
                        @elseif($item->user_level == '2')
                          <td class="text-center">Otorisator - Pimpinan</td>
                        @elseif($item->user_level == '3')
                          <td class="text-center">Sekretaris Pimpinan</td>
                        @elseif($item->user_level == '4')
                          <td class="text-center">Keuangan</td>
                        @elseif($item->user_level == '5')
                          <td class="text-center">Dinas</td>
                        @elseif($item->user_level == '6')
                          <td class="text-center">PPTK</td>
                        @elseif($item->user_level == '7')
                          <td class="text-center">Bendahara</td>
                        @elseif($item->user_level == '8')
                          <td class="text-center">Pembukuan</td>
                        @elseif($item->user_level == '9')
                          <td class="text-center">Laporan</td>
                        @elseif($item->user_level == '10')
                          <td class="text-center">Perencana</td>
                        @endif
                        <td class="text-center" style="width: 10px">
                          <div class="btn-group">
                          <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#modal-editUser{{ $item->user_id }}"><i class="fas fa-edit"></i></button>
                          <button type="submit" class="btn btn-danger  mr-2" data-toggle="modal" data-target="#modal{{$item->user_id}}"><i class="fas fa-trash-alt""></i></button>
                        </div>
                        {{-- delete --}}
                        <div class="modal fade" id="modal{{$item->user_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-info">
                                <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h6>Yakin Mau Hapus User {{ $item->nama }}</h6>
                              </div>
                              <div class="modal-footer">
                                <form action="{{ route('user.destroy', $item->user_id) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                  </button>
                                </form>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- delete --}}
                        </td>
                    </tr>
                    @include('setting.user.pop.editUser')
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('setting.user.pop.addUser')
</section>  

@endsection

@section('script')

<script>
    $(function(){
        $("#dtable").dataTable();
        $(".select2").select2();
    });
</script>

@endsection