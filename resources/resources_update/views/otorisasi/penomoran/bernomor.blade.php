@extends('layouts.template')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Rincian Usulan yang sudah bernomor</h5> 
          </div>

          <div class="card-body px-2 py-2">
            {{-- <button class="btn btn-info btn-primary" data-toggle="modal" data-target="#modalListBernomor" data-backdrop="static">
              <i class="fas fa-list-alt pr-1"></i>Rincian Usulan yang sudah bernomor
            </button> --}}
            <a href="{{route('penomoran')}}" class="btn btn-info btn-primary"><i class="fas fa-angle-double-left pr-1"></i>Kembali</a>
            <select class="form-control-sm float-right" name="bulan" id="bulan" onchange="Mymonth()">
              <option value="1" {{$bulan == 1 ? 'selected' : ''}}>Januari</option>
              <option value="2" {{$bulan == 2 ? 'selected' : ''}}>Februari</option>
              <option value="3" {{$bulan == 3 ? 'selected' : ''}}>Maret</option>
              <option value="4" {{$bulan == 4 ? 'selected' : ''}}>April</option>
              <option value="5" {{$bulan == 5 ? 'selected' : ''}}>Mei</option>
              <option value="6" {{$bulan == 6 ? 'selected' : ''}}>Juni</option>
              <option value="7" {{$bulan == 7 ? 'selected' : ''}}>Juli</option>
              <option value="8" {{$bulan == 8 ? 'selected' : ''}}>Agustus</option>
              <option value="9" {{$bulan == 9 ? 'selected' : ''}}>September</option>
              <option value="10" {{$bulan == 10 ? 'selected' : ''}}>Oktober</option>
              <option value="11" {{$bulan == 11 ? 'selected' : ''}}>November</option>
              <option value="12" {{$bulan == 12 ? 'selected' : ''}}>Desember</option>
            </select>
            <p class="form-control-sm font-weight-bold float-right">Bulan</p>
            <div class="table-responsive">
            <table class="table table-bordered table-hover example1">
                <thead class="thead-light">
                  <tr>
                    <!-- <th class="text-center" style="width: 10%;">Tahun</th> -->
                    <th class="text-center" style="vertical-align: middle;">Nomor Usulan</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian Otorisasi</th>
                    <th class="text-center" style="vertical-align: middle;">Nilai Usulan</th>
                    <th class="text-center" style="width: 12%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
      
                  @if($otorisasi2->count() > 0)
                  @foreach ($otorisasi2 as $number => $otorisasi2)
                  <tr>
                    <!-- <td class="text-center">{{$otorisasi2->Ko_Period}}</td>                        -->
                    <td>{{$otorisasi2 ->No_SPi}}</td>                      
                    <td>{{$otorisasi2 ->No_oto}}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($otorisasi2->Dt_oto)) }}</td>                      
                    <td>{{$otorisasi2 ->Ur_oto}}</td>                      
                    <td class="text-right">{{ number_format($otorisasi2 ->Jumlah, 2, ',', '.') }}</td>   
                    <td>
                      <div class="row justify-content-center" >
                        <div class="row">
                          <div class="col-sm-4">
                            <a href="{{ route('sopd_pdf', $otorisasi2->id)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
                              <i class="fa fa-print"></i>
                            </a>
                          </div>
						  @if($otorisasi2->id_byro == NULL)
                          <div class="col-sm-4">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditOtoBernomor{{ $otorisasi2->id }}" data-backdrop="static" title="Edit">
                              <i class="fas fa-edit"></i> 
                            </button>
                          </div>
						  @else
						  <div class="col-sm-4">
                            <button class="btn btn-sm btn-warning" disabled="">
                              <i class="fas fa-edit"></i> 
                            </button>
                          </div>
						  @endif
                          @if($otorisasi2->id_byro == NULL)
                          <div class="col-sm-4">
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusOtoBernomor{{ $otorisasi2->id }}" data-backdrop="static" title="Hapus">
                              <i class="fas fa-trash-alt"></i> 
                            </button>
                          </div>
                          @else
                          <div class="col-sm-4">
                            <button class="btn btn-sm btn-danger" disabled="">
                              <i class="fas fa-trash-alt"></i> 
                            </button>
                          </div>
                          @endif
                        </div>
                      </div>
                    </td>    
                  </tr>
                  @include('otorisasi.penomoran.popup.otorisasi_bernomor_edit')
                  @include('otorisasi.penomoran.popup.otorisasi_bernomor_hapus')
                  @endforeach
                  @else
                  <tr>
                    <td colspan="7">Tidak Ada Data</td>
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
    $('.example1').DataTable({ order: [[2, 'desc']] });
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

  function myNmKuasa($id) {
    var data = document.getElementById("Nm_Kuasa"+$id).value;
    var nip = data.split("|");
    $('#NIP_Kuasa'+$id).val(nip[1]);
  }

  function myTrmNm($id) {
    var data = document.getElementById("Trm_Nm"+$id).value;
    var dt = data.split("|");
    $('#Trm_NPWP'+$id).val(dt[1]);
    $('#Trm_bank'+$id).val(dt[2]);
    $('#Trm_rek'+$id).val(dt[3]);
  }

  function myEditNmKuasa($id) {
    var data = document.getElementById("EditNm_Kuasa"+$id).value;
    var nip = data.split("|");
    $('#EditNIP_Kuasa'+$id).val(nip[1]);
  }

  function myEditTrmNm($id) {
    var data = document.getElementById("EditTrm_Nm"+$id).value;
    var dt = data.split("|");
    $('#EditTrm_NPWP'+$id).val(dt[1]);
    $('#EditTrm_bank'+$id).val(dt[2]);
    $('#EditTrm_rek'+$id).val(dt[3]);
  }

  function Mymonth()
  {
    var slug = $('#bulan').val();
    console.log(slug);
    var url = '{{ route("penomoran_bernomor.bulan", ":slug") }}';
    url = url.replace(':slug', slug);
    window.location.href=url;
  }

</script>

@endsection