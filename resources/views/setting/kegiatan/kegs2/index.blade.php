@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            @if(getUser('user_level') == 1)
            <h5 class="card-title font-weight-bold">Data Aktivitas</h5> 
            @else
            <h5 class="card-title font-weight-bold">Data Aktivitas : {{ nm_bidang() }}</h5> 
            @endif
          </div>

          <div class="card-body px-1 py-1">
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

                <tr>
                  <td>
                    <form action="{{ route('setkegs1.index') }}" method="get" class="">
                      @csrf
                      <button type="submit" class="btn pl-0 py-0">
                        <b>Sub Kegiatan</b>
                        <input type="hidden" name="Ko_sKeg1" value="{{ $Ko_sKeg1 }}">
                        <input type="hidden" name="Ur_sKeg" value="{{ $Ur_sKeg }}">
                      </button>
                    </form>
                  </td>
                  <td> : {{ $Ko_KegBL1 }} - {{ $Ur_KegBL1 }}
                    <a href="{{ route('setkegs1.index', ['Ko_sKeg1'=>$Ko_sKeg1, 'Ur_sKeg'=>$Ur_sKeg, 'ko_unit1'=>$ko_unit1]) }}" class="btn btn-outline-success btn-sm float-right" >
                      <i class="fas fa-share fa-rotate-180"></i> Kembali
                    </a>
                  </td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="card-body px-1 py-1">
            {{--<button class="btn btn-sm mb-2" data-toggle="modal" data-target="#modalTambahKegs2">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian">
            </button>--}}
            <div class="row my-3">
              <div class="col-6 text-left">
                <a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalTambahKegs2" title="Tambah Rincian Aktivitas">
                  <i class="fas fa-plus"></i> Tambah Aktivitas
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Kode Aktivitas</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Aktivitas</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($kegs2->count() > 0)
                  @foreach($kegs2 as $number => $kegs2)
                  <tr>
                    <td class="text-center">{{ $kegs2->Ko_sKeg2 }}</td>                      
                    <td>{{ $kegs2->Ur_KegBL2 }}</td>                      
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm">
                          <button class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalEditKegs2{{ $kegs2->id }}">
                            <i class="fas fa-edit"></i>
                          </button>
                          @include('setting.kegiatan.kegs2.popup.kegs2_edit')
                        </div>
                        @if($kegs2->Ko_sKeg2_ang == NULL)
                        <div class="col-sm">
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $kegs2->id }}" title="Hapus"> 
                            <i class="fas fa-trash-alt"></i>
                          </button>
                          @include('setting.kegiatan.kegs2.popup.kegs2_hapus')
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
@include('setting.kegiatan.kegs2.popup.kegs2_tambah')
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