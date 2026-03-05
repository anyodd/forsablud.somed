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
            <h5 class="card-title font-weight-bold">Penomoran Usulan Otorisasi</h5> 
          </div>

          <div class="card-body px-2 py-2">
            {{-- <button class="btn btn-info btn-primary" data-toggle="modal" data-target="#modalListBernomor" data-backdrop="static">
              <i class="fas fa-list-alt pr-1"></i>Rincian Usulan yang sudah bernomor
            </button> --}}
            <a href="{{route('penomoran_bernomor.bulan',date('m'))}}" class="btn btn-info btn-primary"><i class="fas fa-list-alt pr-1"></i>Rincian Usulan yang sudah bernomor</a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <!-- <th class="text-center" style="width: 10%;">Tahun</th> -->
                    <th class="text-center">Nomor Usulan</th>
                    <th class="text-center">Tanggal Usulan</th>
                    <th class="text-center">Tanggal Otorisasi</th>
                    <th class="text-center">Uraian Usulan</th>
                    <th class="text-center">Nilai Usulan</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  @if($otorisasi->count() > 0)
                  @foreach ($otorisasi as $number => $otorisasi)
                  <tr>
                    <!-- <td class="text-center">{{$otorisasi->Ko_Period}}</td>                        -->
                    <td>{{$otorisasi ->No_SPi}}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($otorisasi->Dt_SPi)) }}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($otorisasi->otodated_at)) }}</td>                      
                    <td>{{$otorisasi ->Ur_SPi}}</td>   
                    <td class="text-right">{{ number_format($otorisasi ->Jumlah, 2, ',', '.') }}</td>                    
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-5">
                          <button class="btn btn-info btn-primary" type="" name="" value="" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modalPenomoranUsul{{ $otorisasi->id }}" data-backdrop="static">Pilih
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @include('otorisasi.penomoran.popup.otorisasi_tambah')
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

{{-- @include('otorisasi.penomoran.popup.otorisasi_bernomor') --}}

@endsection

@section('script')

{{-- <script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

<script>
  $(document).ready(function() {
    $('.example1').DataTable();
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

  // $(document).on('change','#Trm_Nm', function () {
  //     var data = document.getElementById("Trm_Nm").value;
  //     var dt = data.split("|");
  //     $('#Trm_NPWP').val(dt[1]);
  //     $('#Trm_bank').val(dt[2]);
  //     $('#Trm_rek').val(dt[3]);
  // });

  // $(document).on('change','#EditNm_Kuasa', function () {
  //     var data = document.getElementById("EditNm_Kuasa").value;
  //     var nip = data.split("|");
  //     $('#EditNIP_Kuasa').val(nip[1]);
  // });

  // $(document).on('change','#EditTrm_Nm', function () {
  //     var data = document.getElementById("EditTrm_Nm").value;
  //     var dt = data.split("|");
  //     $('#EditTrm_NPWP').val(dt['1']);
  //     $('#EditTrm_bank').val(dt['2']);
  //     $('#EditTrm_rek').val(dt['3']);
  // });

</script>

@endsection