@extends('layouts.template')
@section('style') 
<meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            @if(getUser('user_level') == 1)
            <h5 class="card-title font-weight-bold">Data Kegiatan</h5> 
            @else
            <h5 class="card-title font-weight-bold">Data Kegiatan : {{ nm_bidang() }}</h5> 
            @endif
          </div>

          <div class="card-body px-2 py-2">
            {{--<a href="{{ route('setkegiatan.create') }}" class="btn btn-sm mb-2">
              <img src="{{asset('template')}}/dist/img/icon_crud/add.png" class="img-circle img-sm" alt="" title="Tambah Rincian Kegiatan">
            </a>--}}
            <div class="row my-3">
              <div class="col-6 text-left">
                <a href="{{ route('setkegiatan.create') }}" class="btn btn-outline-primary btn-sm" title="Tambah Rincian Kegiatan">
                  <i class="fas fa-plus"></i> Tambah Kegiatan
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="tabelKeg" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Bidang</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Kode Kegiatan</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Sumber Dana</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Kegiatan</th>
                    <th class="text-center" style="vertical-align: middle; width: 15%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($keg->count() > 0)
                  @foreach($keg as $number => $keg)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>                      
                    <td class="text-center">{{ $keg->ko_unit1 }}</td>                      
                    <td class="text-center">{{ $keg->Ko_sKeg1 }}</td>                      
                    <td class="text-center">@if ($keg->ko_dana == 1) <span class="text-danger">APBD</span> @else <span class="text-success">BLUD</span> @endif </td>                      
                    <td>{{ $keg->Ur_sKeg }}</td>                      
                    <td class="text-center">
                      <div class="row justify-content-center" >
                          <form action="{{ route('setkegs1.index') }}" method="get" class=""> 
                            <button type="submit" class="btn btn-outline-primary" name="submit" title="Rincian Program BLUD">
                              <i class="fas fa-angle-double-right"></i>
                              <input type="hidden" name="Ko_sKeg1" value="{{ $keg->Ko_sKeg1 }}">
                              <input type="hidden" name="Ur_sKeg" value="{{ $keg->Ur_sKeg }}">
                              <input type="hidden" name="ko_unit1" value="{{ $keg->ko_unit1 }}">
                            </button>
                          </form>
                          &nbsp&nbsp&nbsp
                          <a href="{{route('setkegiatan.edit',$keg->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                          &nbsp&nbsp&nbsp
                        @if($keg->ur_subunit1 == NULL)
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $keg->id }}" title="Hapus"> 
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        @include('setting.kegiatan.keg.popup.keg_hapus')
                        @else
                          <button type="button" class="btn btn-danger" disabled=""> 
                            <i class="fas fa-trash-alt"></i>
                          </button>
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
    $('#tabelKeg').DataTable( {
      stateSave: true,
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