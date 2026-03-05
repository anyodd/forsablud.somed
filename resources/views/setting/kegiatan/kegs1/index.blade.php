@extends('layouts.template')
@section('style') @endsection
@include('setting.kegiatan.kegs1.popup.kegs1_tambah')

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Sub Kegiatan</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table mb-0 pl-0" width="100%" cellspacing="0">
                <tr>
                  <td style="width: 10%;">
                    <a href="{{ route('setkegiatan.index') }}" style="color: black;">
                      <b>Bidang</b>
                    </a>
                  </td>
                  <td> : {{ $ko_unit1 }} - {{ $nm_bidang }}</td>
                </tr>
                <tr>
                  <td>
                    <a href="{{ route('setkegiatan.index') }}" style="color: black;">
                      <b>Kegiatan</b>
                    </a>
                  </td>
                  <td> : {{ $Ko_sKeg1 }} - {{ $Ur_sKeg }}
                      <a href="{{ route('setkegiatan.index') }}" class="btn btn-outline-success btn-sm float-right" >
                        <i class="fas fa-share fa-rotate-180"></i> Kembali
                      </a>
                  </td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="card-body py-1 mx-0">
            {{--<button class="btn btn-sm mb-2" data-toggle="modal" data-target="#modalTambahKegs1">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian">
            </button>--}}
            <div class="row my-3">
              <div class="col-12 text-left">
                <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalTambahKegs1" title="Tambah Rincian Sub Kegiatan">
                  <i class="fas fa-plus"></i> Tambah Sub Kegiatan
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Kode Sub Kegiatan</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Sub Kegiatan</th>
                    <th class="text-center" style="vertical-align: middle; width: 15%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($kegs1->count() > 0)
                  @foreach($kegs1 as $number => $kegs1)
                  <tr>
                    <td class="text-center">{{ $kegs1->Ko_KegBL1 }}</td>                      
                    <td>{{ $kegs1->Ur_KegBL1 }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-3 mr-2">
                          <form action="{{ route('setkegs2.index') }}" method="get" class="">
                            <button type="submit" class="btn btn-outline-primary" name="submit" title="Rincian Kegiatan BLUD">
                              <i class="fas fa-angle-double-right"></i>
                              <input type="hidden" name="Ko_sKeg1" value="{{ $kegs1->Ko_sKeg1 }}">
                              <input type="hidden" name="Ur_sKeg" value="{{ $Ur_sKeg }}">
                              <input type="hidden" name="Ko_KegBL1" value="{{ $kegs1->Ko_KegBL1 }}">
                              <input type="hidden" name="Ur_KegBL1" value="{{ $kegs1->Ur_KegBL1 }}">
                              <input type="hidden" name="ko_unit1" value="{{ $kegs1->ko_unit1 }}">
                            </button>
                          </form>
                        </div>
                        <div class="col-sm-3 mr-2">
                          <button class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalEditKegs1{{ $kegs1->id }}">
                            <i class="fas fa-edit"></i>
                          </button>
                          @include('setting.kegiatan.kegs1.popup.kegs1_edit')
                        </div>
                        @if($kegs1->Ko_KegBL2 == NULL)
                        <div class="col-sm-3">
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $kegs1->id }}" title="Hapus"> 
                            <i class="fas fa-trash-alt"></i>
                          </button>
                          @include('setting.kegiatan.kegs1.popup.kegs1_hapus')
                        </div>
                        @else
                        <div class="col-sm">
                          <button type="button" class="btn btn-danger" disabled=""> 
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="3">Tidak Ada Data</td>
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