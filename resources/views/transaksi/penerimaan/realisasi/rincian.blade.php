@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">RINCIAN REALIASASI</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <div class="card-body">
            <a href="{{ route('realisasi.index')}}" class="btn btn-success float-right">
                    <i class="far fa-arrow-alt-circle-left"> Back</i>
            </a>
              <br><br>
              <!-- <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSubBlu">Tambah</button>
                  </div>
              </div>
              <br> -->
              <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                  <th class="text-center" style="vertical-align: middle;">Nomor Tagihan</th>
                  <th class="text-center" style="vertical-align: middle;">Period</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Pembayaran</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Bayar</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($realisasi as $r)
                  <tr>
                  <td class="text-center">{{ $r->No_bp }}</td>  
                  <td class="text-center">{{ $r->Ko_Period }}</td>                       
                    <td>{{ $r->No_byr }}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($r->dt_byr)) }}</td>                      
                    <td>{{ $r->Ur_byr }}</td>                                       
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-4">
                            <a href="#">
                              <button class="btn btn-danger btn-block" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modalHapusSubRealisasi{{$r->id_byr}}" title="hapus">
                              <i class="fas fa-trash-alt"></i></button>
                            </a>
                        </div>
                      <div class="modal fade" id="modalHapusSubRealisasi{{$r->id_byr}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                              <form action="{{ route('subrealisasi.destroy', $r->id_byr) }}" method="post" class="">
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

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>


@endsection