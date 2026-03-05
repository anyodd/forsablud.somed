@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pendapatan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
          </ol>
        </div>
      </div>
    </div> -->
</section>

  <!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-body">
                    <div class="row">
              <div class="col-12">
                <table class="table table-hover text-nowrap">
                  <tbody>
                    {{-- <tr>
                      <td style="width: 10px"><b>Periode</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ Tahun() }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Unit</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ nm_bidang() }}</td>
                    </tr> --}}
                    <tr>
                      <td style="width: 10px"><b>Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      {{-- <td>{{ $map->Ko_sKeg1 }} - {{ $map->Ur_sKeg }}</td> --}}
                      <td><a href="{{ route('kegiatan.index') }}"> {{ $map->Ko_sKeg1 }} - {{ $map->Ur_sKeg }}</a></td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Sub Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      {{-- <td>{{ $map2->Ko_KegBL1 }} - {{ $map2->Ur_KegBL1 }}</td> --}}
                      <td><a href="{{ route('program', $map2->Ko_sKeg1) }}">{{ $map2->Ko_KegBL1 }} - {{ $map2->Ur_KegBL1 }}</a></td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Aktivitas</b></td>
                      <td style="width: 1px">:</td>
                      <td><a href="{{ route('subkegiatan',[$map3->Ko_sKeg1, $map3->Ko_KegBL1]) }}">{{ $map3->Ko_KegBL2 }} - {{ $map3->Ur_KegBL2 }}</a>
                        <p style="text-align: right">{{'Rp. '. number_format($jml,2,',','.')}}</p></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>             
          <div class="card-body">
            <div class="row">
              <div class="col-2">
                  <div class="card">
                      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-akun"><i class="fas fa-plus-circle"></i> Tambah Akun</button>
                  </div> 
              </div>
              <div class="col-10">
                <div class="card float-right">
                    <a href="{{ route('subkegiatan',[$map3->Ko_sKeg1, $map3->Ko_KegBL1]) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>  
              </div> 
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-file-alt"></i>
                            Akun
                        </h3>
                      </div>
                        <div class="card-body">
                            <table class="table table-hover text-nowrap dtable">
                                <thead>
                                  <tr>
                                    <th>Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Rupiah</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $item)
                                        <tr>
                                            <td style="vertical-align: middle; width: 20px">{{ $item->Ko_Rkk }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ur_Rc }}</td>
                                            <td style="vertical-align: middle">{{ 'Rp. ' . number_format($item->jml,2,',','.')}}</td>
                                            <td style="width: 5px">
                                              
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modal{{$item->id}}"><i class="fas fa-trash text-danger"></i></button>
                                                
                                                <a href="{{ route('r_akun',[$item->Ko_sKeg1, $item->Ko_sKeg2, $item->Ko_Rkk]) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-angle-double-right"></i></a>
                                              
                                              {{-- delete --}}
                                              <div class="modal fade" id="modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                      <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <p class="text-center">Yakin Mau Hapus Data Akun dan Rincian</p>
                                                      <p class="text-center"><b>{{ $item->Ur_Rc }}</b></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <form action="{{ route('akun.destroy', $item->id) }}" method="post">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    
                </div>
            </div>
            
            {{-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="far fa-file-alt"></i> Rincian Akun</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover text-nowrap dtable2">
                                <thead>
                                  <th>Rincian</th>
                                  <th>Satuan</th>
                                  <th>Rupiah</th>
                                  <th></th>
                                </thead>
                                <tbody>
                                  @foreach ($rc as $item)
                                    <tr>  
                                      <td style="vertical-align: middle">{{ $item->Ur_Rc1 }}</td>
                                      <td style="vertical-align: middle">{{ $item->V_sat }}</td>
                                      <td style="vertical-align: middle">{{ $item->Rp_1 }}</td>
                                      <td style="width: 10px">
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-outline-primary"><i class="fab fa-usb"></i></button>
                                          <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Hapus</a>
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
            </div> --}}
          </div>
      </div>
    </div>
  </div>
  @include('perencanaan.popup.addAkun')
  @include('perencanaan.popup.listAkun')

</section>

@endsection

@section('script')
<script>
  $(document).ready(function() {
      $('.dtable').DataTable();
      $('.dtable2').DataTable();
      $('.select2').select2();

      $(document).on('click','#select',function() {
        var rk1 = $(this).data('rk1');
        var rk2 = $(this).data('rk2');
        var rk3 = $(this).data('rk3');
        var rk4 = $(this).data('rk4');
        var rk5 = $(this).data('rk5');
        var rk6 = $(this).data('rk6');
        var ur_rk6 = $(this).data('ur_rk6');
        $('#rk1').val(rk1);
        $('#rk2').val(rk2);
        $('#rk3').val(rk3);
        $('#rk4').val(rk4);
        $('#rk5').val(rk5);
        $('#rk6').val(rk6);
        $('#ur_rk6').val(ur_rk6);
        $('#modal-listAkun').hide();
    });
  });
</script>
<script>
  $(function(){
    // $(document).on("click", ".dtable tbody tr", function() {
    //     alert("You clicked my <tr>!");
    // });
  });
</script>
@endsection