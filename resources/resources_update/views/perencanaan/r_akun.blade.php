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
          <div class="card-body pb-0">
            <div class="row">
              <div class="col-12">
                <table class="table table-sm table-hover text-nowrap">
                  <tbody>
                    @if(getUser('user_level') != 1)
                    <tr>
                      <td style="width: 10px"><b>Bidang</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ kd_bidang() }} - {{ nm_bidang() }}</td>
                    </tr>
                    @endif
                    {{-- 
                    <tr>
                      <td style="width: 10px"><b>Bidang</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ kd_bidang() }} - {{ nm_bidang() }}</td>
                    </tr>
                    --}}
                    <tr>
                      <td style="width: 10px"><b>Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ $map->Ko_sKeg1 }} - {{ $map->Ur_sKeg }}</a></td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Aktivitas</b></td>
                      <td style="width: 1px">:</td>
                      {{-- <td><a href="{{ route('subkegiatan',[$map3->Ko_sKeg1, $map3->Ko_KegBL1]) }}">{{ $map3->Ko_sKeg2 }} - {{ $map3->Ur_KegBL2 }}</a></td> --}}
                      <td>
                        <div class="d-flex">
                          <div>
                            {{ $map3->Ko_sKeg2 }} - {{ $map3->Ur_KegBL2 }}
                          </div>
                          <div class="ml-auto">
                            {{'Rp. '. number_format($rp_akt,2,',','.')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Akun</b></td>
                      <td style="width: 1px">:</td>
                      {{-- <td><a href="{{ route('akun',[$map4->Ko_sKeg1, $map4->Ko_sKeg2, $map3->Ko_KegBL1]) }}">{{ $map4->Ko_Rkk }} - {{ $map4->Ur_Rc }}</a></td> --}}
                      <td>
                        <div class="d-flex">
                          <div>
                            {{ $map4->Ko_Rkk }} - {{ $map4->Ur_Rc }}
                          </div>
                          <div class="ml-auto">
                            {{'Rp. '. number_format($rc_rp,2,',','.')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>             
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-2">
                <div class="card">
                  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-rincianAkun"><i class="fas fa-plus-circle"></i> Rincian Akun</button>
                </div>  
              </div>
              <div class="col-10">
                <div class="card float-right">
                  <a href="{{ route('akun',[$map4->Ko_sKeg1, $map4->Ko_sKeg2, $map3->Ko_KegBL1]) }}" class="btn btn-outline-primary float-right"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>  
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="card card-info">
                  <div class="card-header">
                    <h5 class="card-title"><i class="far fa-file-alt"></i> Rincian Akun</h5>
                  </div>
                  <div class="card-body">
                    <table class="table table-sm table-hover text-nowrap dtable2">
                      <thead class="thead-light">
                        <th class="text-center">No.</th>
                        <th class="text-center">Rincian</th>
                        <th class="text-center">Volume</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Nilai (Rp)</th>
                        <th></th>
                      </thead>
                      <tbody>
                        @php $no=1 @endphp
                        @foreach ($rc as $item)
                        <tr>  
                          <td class="text-center" style="vertical-align: middle; width: 3%">{{$no++}}.</td>
                          <td style="vertical-align: middle">{{ $item->Ur_Rc1 }}</td>
                          <td class="text-right" style="vertical-align: middle">{{ $item->V_1 }}</td>  
                          <td class="text-center" style="vertical-align: middle">{{ $item->V_sat }}</td>
                          <td class="text-right" style="vertical-align: middle">{{ number_format($item->Rp_1,2,',','.')}}</td>  
                          <td class="text-right" style="vertical-align: middle">{{ number_format($item->To_Rp,2,',','.')}}</td>
                          <td class="text-center" style="width: 5%">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit{{$item->id}}" title="Edit Rincian"> 
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{$item->id}}" title="Hapus Rincian"> 
                              <i class="fas fa-trash-alt"></i>
                            </button>
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
                                    <p class="text-center">Yakin Mau Hapus Data Rincian Akun</p>
                                    <p class="text-center"><b>{{ $item->Ur_Rc1 }}</b></p>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="{{ route('r_akun.destroy', $item->id) }}" method="post">
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
                        @include('perencanaan.popup.editRincianAkun')
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('perencanaan.popup.addRincianAkun')
  </section>

  @endsection

  @section('script')
  <script>

    $(document).ready(function() {
      $('.dtable').DataTable();
      $('.dtable2').DataTable({
        stateSave: true,
      });
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

    function total() {
      var rp = document.getElementById('Rp_1').value.replace(/[^,\d]/g, '');
      var rp1 = rp.replace(',','.');
      var v = document.getElementById('V_1').value;
      // var total = document.getElementById('V_1').value * document.getElementById('Rp_1').value;
      var total = rp1 * v;
      // console.log(total);
      // document.getElementById('To_Rp').value = total.toFixed(2);
      document.getElementById('To_Rp').value = new Intl.NumberFormat(['ban', 'id'], { maximumFractionDigits: 2, minimumFractionDigits: 2 }).format(total);
    }
  </script>
  @endsection
