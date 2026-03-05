@extends('layouts.template')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header bg-info py-2">
            @if(getUser('user_level') == 1)
            <h5 class="card-title font-weight-bold">Data RBA</h5> 
            @else
            <h5 class="card-title font-weight-bold">Data RBA : {{ nm_bidang() }}</h5> 
            @endif
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <table class="table table-sm  table-hover text-nowrap">
                  <tbody>
                    @if(getUser('user_level') != 1)
                    <tr>
                      <td style="width: 10px"><b>Bidang</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ kd_bidang() }} - {{ nm_bidang() }}</td>
                    </tr>
                    @endif
                    <tr>
                      <td style="width: 10px"><b>Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ $map->Ko_sKeg1 }} - {{ $map->Ur_sKeg }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Aktivitas</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ $map3->Ko_sKeg2 }} - {{ $map3->Ur_KegBL2 }}</td>
                      <td class="text-right">{{'Rp '. number_format($jml,2,',','.')}}</td>
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
                  <a href="{{ route('rba.index') }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>  
              </div> 
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-info">
                  <div class="card-body">
                    <table class="table table-sm  table-hover text-nowrap dtable">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">Kode Akun</th>
                          <th class="text-center">Nama Akun</th>
                          <th class="text-center">Nilai (Rp)</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($dt as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>                      
                          <td style="vertical-align: middle; width: 20px">{{ $item->Ko_Rkk }}</td>
                          <td style="vertical-align: middle">{{ $item->Ur_Rc }}</td>
                          <td class="text-right" style="vertical-align: middle">{{ number_format($item->jml,2,',','.')}}</td>
                          <td style="width: 10px">
                            
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_akun{{$item->id}}" data-backdrop="static"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{$item->id}}"><i class="fas fa-trash-alt"></i></button>

                            <a href="{{ route('r_akun',[$item->Ko_sKeg1, $item->Ko_sKeg2, $item->Ko_Rkk]) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a>

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
                          </td>
                        </tr>
                        @include('perencanaan.popup.editAkun')
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
          </div>
        </div>
      </div>
    </div>
    @include('perencanaan.popup.addAkun')
    @include('perencanaan.popup.listAkun')
    @include('perencanaan.popup.listAkun_edit')

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
    
      $(document).on('click','#pilih',function() {
        var id   =  $('#idemod').val();
        var rk1e = $(this).data('rk1_e');
        var rk2e = $(this).data('rk2_e');
        var rk3e = $(this).data('rk3_e');
        var rk4e = $(this).data('rk4_e');
        var rk5e = $(this).data('rk5_e');
        var rk6e = $(this).data('rk6_e');
        var ur_rk6e = $(this).data('ur_rk6_e');
        $('#rk1_e'+id).val(rk1e);
        $('#rk2_e'+id).val(rk2e);
        $('#rk3_e'+id).val(rk3e);
        $('#rk4_e'+id).val(rk4e);
        $('#rk5_e'+id).val(rk5e);
        $('#rk6_e'+id).val(rk6e);
        $('#ur_rk6_e'+id).val(ur_rk6e);
        $('#modal-listAkun_edit').hide();
      });

      $(document).on('click','#cedit', function () {
        var idmod = $(this).data('idmod');
        $('#idemod').val(idmod);
      });

      $('#MyModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
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