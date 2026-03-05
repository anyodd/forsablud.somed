@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">

        <div class="card card-info card-tabs mt-2">
          <div class="card-header p-0 pt-1">
            <div class="row">
              <div class="col-10">
                <ul class="nav nav-tabs" id="rekening" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="sppd_up-tab" data-toggle="pill" href="#sppd_up" role="tab" aria-controls="sppd_up" aria-selected="true">UP</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="sppd_gu-tab" data-toggle="pill" href="#sppd_gu" role="tab" aria-controls="sppd_gu" aria-selected="false">GU</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="sppd_ls-tab" data-toggle="pill" href="#sppd_ls" role="tab" aria-controls="sppd_ls" aria-selected="false">LS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="sppd_panjar-tab" data-toggle="pill" href="#sppd_panjar" role="tab" aria-controls="sppd_panjar" aria-selected="false">Panjar</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="sppd_nihil-tab" data-toggle="pill" href="#sppd_nihil" role="tab" aria-controls="sppd_nihil" aria-selected="false">Nihil</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="register-sppd-tab" data-toggle="pill" href="#register_sppd" role="tab" aria-controls="register_sppd" aria-selected="false">Register S-PPD</a>
                  </li>
                </ul>
              </div>
              <div class="col-2 text-right pr-3 my-auto">
                <form action="{{ route('register.sppd.cetak') }}">
                  <input type="hidden" id='awal' name="date1">
                  <input type="hidden" id='akhir' name="date2">
                  <button type="submit" class="btn btn-sm btn-secondary">
                      <i class="fas fa-file-pdf bg-red"></i> Cetak
                  </button>
              </form>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="tab-content" id="rekeningContent">

              <div class="tab-pane fade show active" id="sppd_up" role="tabpanel" aria-labelledby="sppd_up-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0 example1" id="example1" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                        <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PPD UP</th>
                        <!-- <th class="text-center" style="vertical-align: middle; width: 25%">Jns</th> -->
                        <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PPD</th>
                        <th class="text-center" style="vertical-align: middle;">Uraian</th>
                        <th class="text-center" style="width: 5%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      @if($sppd_up->count() > 0)
                      @foreach ($sppd_up as $number => $sppd_up)

                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>                      
                        <td>{{$sppd_up ->No_SPi}}</td>                      
                        <!-- <td>{{$sppd_up ->Ko_SPi}}</td>                       -->
                        <td class="text-center">{{ date('d M Y', strtotime($sppd_up->Dt_SPi)) }}</td>                      
                        <td>{{$sppd_up ->Ur_SPi}}</td>                                  
                        <td>
                          <div class="row justify-content-center" >
                            <div class="row">
                              <div class="col-sm">
                                <a href="{{ route('sppd_pdf', $sppd_up->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
                                  <i class="fas fa-file-pdf"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>

                  </table>
                </div>
              </div>

              <div class="tab-pane fade show" id="sppd_gu" role="tabpanel" aria-labelledby="sppd_gu-tab">
               <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0 example1" id="example2" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                      <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PPD GU</th>
                      <!-- <th class="text-center" style="vertical-align: middle;">Jns</th> -->
                      <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PPD</th>
                      <th class="text-center" style="vertical-align: middle;">Uraian</th>
                      <th class="text-center" style="width: 5%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($sppd_gu->count() > 0)
                    @foreach ($sppd_gu as $number => $sppd_gu)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>                      
                      <td>{{$sppd_gu ->No_SPi}}</td>                      
                      <!-- <td>{{$sppd_gu ->Ko_SPi}}</td>                       -->
                      <td class="text-center">{{ date('d M Y', strtotime($sppd_gu->Dt_SPi)) }}</td>                      
                      <td>{{$sppd_gu ->Ur_SPi}}</td>                                  
                      <td>
                        <div class="row justify-content-center" >
                          <div class="row">
                            <div class="col-sm">
                              <a href="{{ route('sppd_pdf', $sppd_gu->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
                                <i class="fas fa-file-pdf"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td>Tidak Ada Data</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane fade show" id="sppd_ls" role="tabpanel" aria-labelledby="sppd_ls-tab">
             <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0 example1" id="tabel_sppd_ls" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                    <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PPD LS</th>
                    <!-- <th class="text-center" style="vertical-align: middle;">Jns</th> -->
                    <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PPD</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="width: 5%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if($sppd_ls->count() > 0)
                  @foreach ($sppd_ls as $number => $sppd_ls)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>                      
                    <td>{{$sppd_ls ->No_SPi}}</td>                      
                    <!-- <td>{{$sppd_ls ->Ko_SPi}}</td>                       -->
                    <td class="text-center">{{ date('d M Y', strtotime($sppd_ls->Dt_SPi)) }}</td>                      
                    <td>{{$sppd_ls ->Ur_SPi}}</td>                                  
                    <td>
                      <div class="row justify-content-center" >
                        <div class="row">
                          <div class="col-sm">
                            <a href="{{ route('sppd_pdf', $sppd_ls->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
                              <i class="fas fa-file-pdf"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td>Tidak Ada Data</td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade show" id="sppd_panjar" role="tabpanel" aria-labelledby="sppd_panjar-tab">
           <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover mb-0 example1" id="tabel_sppd_panjar" width="100%" cellspacing="0">
              <thead class="thead-light">
                <tr>
                  <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                  <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PPD Panjar</th>
                  <!-- <th class="text-center" style="vertical-align: middle;">Jns</th> -->
                  <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PPD</th>
                  <th class="text-center" style="vertical-align: middle;">Uraian</th>
                  <th class="text-center" style="width: 5%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if($sppd_panjar->count() > 0)
                @foreach ($sppd_panjar as $number => $sppd_panjar)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>                      
                  <td>{{$sppd_panjar ->No_SPi}}</td>                      
                  <!-- <td>{{$sppd_panjar ->Ko_SPi}}</td>                       -->
                  <td class="text-center">{{ date('d M Y', strtotime($sppd_panjar->Dt_SPi)) }}</td>                      
                  <td>{{$sppd_panjar ->Ur_SPi}}</td>                                  
                  <td>
                    <div class="row justify-content-center" >
                      <div class="row">
                        <div class="col-sm">
                          <a href="{{ route('sppd_pdf', $sppd_panjar->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
                            <i class="fas fa-file-pdf"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>Tidak Ada Data</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="tab-pane fade show" id="sppd_nihil" role="tabpanel" aria-labelledby="sppd_nihil-tab">
         <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover mb-0 example1" id="tabel_sppd_nihil" width="100%" cellspacing="0">
            <thead class="thead-light">
              <tr>
                <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PPD Nihil</th>
                <!-- <th class="text-center" style="vertical-align: middle;">Jns</th> -->
                <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PPD</th>
                <th class="text-center" style="vertical-align: middle;">Uraian</th>
                <th class="text-center" style="width: 5%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @if($sppd_nihil->count() > 0)
              @foreach ($sppd_nihil as $number => $sppd_nihil)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>                      
                <td>{{$sppd_nihil ->No_SPi}}</td>                      
                <!-- <td>{{$sppd_nihil ->Ko_SPi}}</td>                       -->
                <td class="text-center">{{ date('d M Y', strtotime($sppd_nihil->Dt_SPi)) }}</td>                      
                <td>{{$sppd_nihil ->Ur_SPi}}</td>                                  
                <td>
                  <div class="row justify-content-center" >
                    <div class="row">
                      <div class="col-sm">
                        <a href="{{ route('sppd_pdf', $sppd_nihil->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
                          <i class="fas fa-file-pdf"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td>Tidak Ada Data</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      @include('laporan.penatausahaan.pengajuan.sppd.register_sppd')
      
    </div>
  </div>
  <!-- /.card -->
</div>

</div>
</section>  

@endsection

@section('script')

<script>
  $(document).ready(function() {
    $('.example1').DataTable( {
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

  $(document).ready(function() {
        $('#baris-loader').hide();
        $('.btn.btn-sm.btn-secondary').hide();
    })

    $('a.nav-link').click(function() {
        $('#result-table').hide();
        $('#table-header').show();
        $('#baris-kosong').show();
        tabPilih = $(this).attr('ambil');
        $('input[name="daterange"]').val('');
    })

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    $(function() {
        tahun = {{ Tahun() }};
        
        $('input[name="daterange"]').daterangepicker({
            opens: "center",
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: "DD-MM-YYYY"
            },
            startDate: "01/01/" + tahun,
            minDate: "01/01/" + tahun,
            maxDate: "31/12/" + tahun
        });
        
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        
            date1 = picker.startDate.format('YYYY-MM-DD');
            date2 = picker.endDate.format('YYYY-MM-DD');

            $('#awal').val(date1)
            $('#akhir').val(date2)
        
            $.ajax({
                type: "post",
                url: "{{ route('register.sppd.isi') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date1": date1,
                    "date2": date2
                },
                beforeSend: function() {
                    $('#result-table').hide();
                    $('#baris-kosong').hide();
                    $('#table-header').show();
                    $('#baris-loader').show();
                },
                success: function(result) {
                    $('#table-header').hide();
                    $('#baris-loader').hide();
                    $('#result-table').html(result);
                    $('#result-table').show();
                    $('.btn.btn-sm.btn-secondary').show();
                }
            })
        });
        
        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#result-table').hide();
            $('#table-header').show();
            $('#baris-kosong').show();
            $('.btn.btn-sm.btn-secondary').hide();
        });
    })
</script>

@endsection