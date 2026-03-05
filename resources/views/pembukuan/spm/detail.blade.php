@extends('layouts.template')
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Realisasi Pencairan Dana Nomor {{ $dt_oto->No_oto }}</h5> 
          </div>

          <div class="card-body px-2 py-2">
            @php $id = Crypt::encrypt($dt_oto->id) @endphp
			@if($dt_oto->id_byro == NULL)
            <a href="{{ route('spm.tambah',$id) }}" class="btn btn-primary">
              <i class="fas fa-list-alt pr-1"></i>Pembayaran
            </a>
			@else
			 <a class="btn btn-primary" onclick="notifikasi()" >
              <i class="fas fa-list-alt pr-1"></i>Pembayaran
            </a>
			@endif
            <a href="{{ route('spm.index') }}" class="btn btn-info">
              <i class="fas fa-arrow-left pr-1"></i>Kembali
            </a><br><br>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover" id="data" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center">Nomor Bayar</th>
                    <th class="text-center">Tanggal Bayar</th>
                    <th class="text-center">Uraian</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center" style="width: 8%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->No_npd }}</td>
                        <td class="text-center">{{ $item->Dt_npd }}</td>
                        <td>{{ $item->Ur_npd }}</td>
                        <td class="text-right">{{ number_format($item->total,2,',','.') }}</td>
                        <td class="text-center">
                            {{-- <a href="#">
                              <button class="btn btn-warning btn-sm" title="Edit">
                              <i class="fas fa-edit"></i></button>
                            </a> --}}
                            <a href="#">
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#Delete{{ $item->id_npd }}" title="hapus">
                              <i class="fas fa-trash-alt"></i></button>
                            </a>
    
                            <div class="modal fade" id="Delete{{ $item->id_npd }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    <form action="{{ route('spm.destroy',$item->id_npd) }}" method="post" class="">
                                      @csrf
                                      @method('DELETE')
                                      <input type="text" name="id_oto" value="{{$dt_oto->id}}" hidden>
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
<script>
  $(document).ready(function() {
    $('#data').DataTable();
  });
  
  function notifikasi() {
    Swal.fire('', 'Data telah dilakukan Pencairan Sebelumnya, tidak dapat dilakukan perubahan data', 'warning')
  }
</script>
@endsection