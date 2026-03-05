@extends('layouts.template')
@section('title', 'Otorisasi')
@section('style') @endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">

                <div class="card card-info card-tabs mt-2">
                    <div class="card-header p-0 pt-1">
                            <div class="row">
                                <div class="col-10">
                                    <ul class="nav nav-tabs" id="rekening" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="sopd-tab" data-toggle="pill" href="#sopd" role="tab" aria-controls="sopd" aria-selected="true">S-OPD</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="spd-tab" data-toggle="pill" href="#spd" role="tab" aria-controls="spd" aria-selected="false">S-PD</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="registerSpm-tab" data-toggle="pill" href="#registerSpm" role="tab" aria-controls="registerSpm" aria-selected="false" ambil="spm">Register S-OPD</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="registerSpd-tab" data-toggle="pill" href="#registerSpd" role="tab" aria-controls="registerSpd" aria-selected="false" ambil="spd">Register S-PD</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-2 text-right pr-3 my-auto">
                                    <form action="">
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

                            <div class="tab-pane fade show active" id="sopd" role="tabpanel" aria-labelledby="sopd-tab">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-0" id="example1"
                                        width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                                                <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-OPD</th>
                                                <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-OPD</th>
                                                <th class="text-center" style="vertical-align: middle; width: 50%;">Uraian</th>
                                                <th class="text-center" style="width: 5%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if($sopd->count() > 0)
                                            @foreach ($sopd as $number => $sopd)

                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{$sopd ->No_oto}}</td>
                                                <td class="text-center">{{ date('d M Y', strtotime($sopd->Dt_oto)) }}</td>
                                                <td>{{$sopd ->Ur_oto}}</td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <a href="{{ route('sopd_pdf', $sopd->id) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
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
                                                <td>Tidak Ada Data</td><td></td><td></td><td></td><td></td>
                                            </tr>
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="spd" role="tabpanel" aria-labelledby="spd-tab">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-0" id="example2"
                                        width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" style="vertical-align: middle; width: 5%;">#</th>
                                                <th class="text-center" style="vertical-align: middle; width: 25%">Nomor S-PD</th>
                                                <th class="text-center" style="vertical-align: middle; width: 15%;">Tanggal S-PD</th>
                                                <th class="text-center" style="vertical-align: middle; width: 50%;">Uraian</th>
                                                <th class="text-center" style="width: 5%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($spd))
                                            @foreach ($spd as $number => $spd)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{$spd ->No_npd}}</td>
                                                <td class="text-center">{{ date('d M Y', strtotime($spd->dt_byro)) }}</td>
                                                <td>{{$spd ->Ur_byro}}</td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <a href="{{ route('spd_pdf', $spd->id_npd) }}" class="btn btn-danger" target="_blank" style="float: right;" title="Cetak">
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
                                                <td>Tidak Ada Data</td><td></td><td></td><td></td><td></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @include('laporan.penatausahaan.otorisasi.register_spm')
                            @include('laporan.penatausahaan.otorisasi.register_spd')

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
      $('#example1').DataTable( {
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
      $('#example2').DataTable( {
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
        $('.baris-loader').hide();
        $('.btn.btn-sm.btn-secondary').hide();
    });
    
    $('a.nav-link').click(function() {
        $('.result-table').hide();
        $('.table-header').show();
        $('.baris-kosong').show();
        tabPilih = $(this).attr('ambil');
        $('input[name="daterange"]').val('');
        
        if (tabPilih == 'spm') {
            $('form').attr('action', '{{ route("lap_oto_cetak_spm") }}') 
        } else {
            $('form').attr('action', '{{ route("lap_oto_cetak_spd") }}') 
        }
    })
    
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
                url: tabPilih == "spm" ? "{{ route('lap_oto_isi_spm') }}" : "{{ route('lap_oto_isi_spd') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date1": date1,
                    "date2": date2
                },
                beforeSend: function() {
                    $('.result-table').hide();
                    $('.baris-kosong').hide();
                    $('.table-header').show();
                    $('.baris-loader').show();
                },
                success: function(result) {
                    $('.table-header').hide();
                    $('.baris-loader').hide();
                    $('.result-table').html(result);
                    $('.result-table').show();
                    $('.btn.btn-sm.btn-secondary').show();
                }
            })
        });
        
        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('.result-table').hide();
            $('.table-header').show();
            $('.baris-kosong').show();
            $('.btn.btn-sm.btn-secondary').hide();
        });
    })
</script>

@endsection