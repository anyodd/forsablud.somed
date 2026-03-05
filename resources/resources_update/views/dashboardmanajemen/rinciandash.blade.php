@extends('layout.base.layout')

@push('styles')
    <style type="text/css">

    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="page-title-box">
            <div class="row">
                <div class="col row">
                    <div class="col-7">
                        <select name="idskpd" id="idskpd" class="form-control select2" onchange="realisasirinc(this.value)">
                            @foreach ($skpd as $id => $name)
                                <option value="{{ $id }}" {{ $id == $idskpd ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-auto align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">rincian dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- -----------------------------------------------------------------------mulai content----------------------------------------------------------------------- --}}
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="btn bg-light-warning card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="media">
                                    <img src="assets/images/money-beg.png" alt="" class="align-self-center"
                                        height="40">
                                    <div class="media-body align-self-center ml-3">
                                        <h6 class="m-0 font-20 lead">
                                            Rp {{ format_money($realisasiskpd->total_realisasi, 2) }}
                                        </h6>
                                        <p class="text-primary mb-0 lead font-weight-light font-12"
                                            style="font-family: Poppins,sans-serif">Total Realisasi</p>
                                    </div>
                                    <!--end media body-->
                                </div>
                                <!--end media-->
                            </div>

                            <div class="col-auto align-self-center">
                                <h1 class="mb-0 lead font-30 text-primary">
                                    {{ number_format($realisasiskpd->persen_realisasi, 2, '.', ',') }}%
                                </h1>
                                {{-- <small class="mb-0 text-muted blockquote-footer text-right"> Sisa Anggaran --}}
                                </small>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                    <div class="row">
                        <div class="col-12">
                            <div class="apexchart-wrapper">
                                <div id="dash_spark_1" class="chart-gutters"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="btn btn-success card" style="height: 100%">
                    <div class="row align-items-center card-body">
                        <div class="col text-center">
                            <span class="lead text-dark" style="font-size: 17pt">Rp
                                {{ format_money($realisasiskpd->sisa_anggaran, 2) }}</span>
                            <h6 class="text-dark mt-2 m-0 font-weight-light" style="font-family: Poppins,sans-serif">
                                Sisa Anggaran ({{ number_format($realisasiskpd->persen_sisa, 2, '.', ',') }}%)</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="btn btn-secondary card" style="height: 100%">
                    <div class="row align-items-center card-body">
                        <div class="col text-center">
                            <span class="lead text-dark" style="font-size: 17pt">Rp
                                {{ format_money($realisasiskpd->total_anggaran, 2) }}</span>
                            <h6 class="text-dark mt-2 m-0 font-weight-light" style="font-family: Poppins,sans-serif">
                                Total Anggaran</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ------------------------------------ --}}
        <div class="table-responsive mt-3">
            <table class="table table-hover">
                <thead class="text-center bg-light-alt">
                    <tr>
                        <th>#</th>
                        <th>Nama Unit Kerja</th>
                        <th>Rincian Belanja</th>
                        <th>Anggaran</th>
                        <th>Realisasi</th>
                        <th>Sisa Anggaran</th>
                        <th>% Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    @foreach ($data_anggaran as $key => $unit)
                        <tr class="curs-point" style="font-size: 8pt">
                            <td class="text-center">
                                <?php
                                echo $i;
                                $i++;
                                ?>
                            </td>
                            <td width=25%>
                                {{ $unit->nmunit }}
                            </td>
                            <td width=25%>
                                {{ $unit->nmrek3 }}
                            </td>
                            <td class="text-right">
                                Rp.
                                {{ format_money($unit->total_anggaran, 0) }}
                            </td>
                            <td class="text-right">
                                Rp.
                                {{ format_money($unit->total_realisasi, 0) }}
                            </td>
                            <td class="text-right">
                                Rp.
                                {{ format_money($unit->sisa_anggaran, 0) }}
                            </td>
                            <td class="text-right">
                                {{ format_money($unit->persen_realisasi, 0) }}
                                %
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
@endpush

@push('scripts_end')
    <script src="{{ asset('newadmin/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script type="text/javascript">
        var dash_spark_1 = {

            chart: {
                type: 'area',
                height: 65,
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                curve: 'smooth',
                width: 1.5
            },
            fill: {
                opacity: 1,
                gradient: {
                    shade: '#a7a3f0',
                    type: "horizontal",
                    shadeIntensity: 0.9,
                    inverseColors: true,
                    opacityFrom: 0.9,
                    opacityTo: 0.9,
                    stops: [0, 80, 100],
                    colorStops: []
                },
            },
            series: [{
                name: 'Realisasi (Rp)',
                data: JSON.parse('{!! $realisasibulan !!}')
            }],
            yaxis: {
                // min: -1
            },
            xaxis: {
                categories: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ]
            },
            colors: ['#a7a3f0'],
            // tooltip: {
            //     show: false,
            // }
            tooltip: {
                custom: function({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    var realisasi = series[0][dataPointIndex];
                    var bulan = w.globals.categoryLabels[dataPointIndex];
                    // console.log(w.globals);
                    return '<div class="alert custom-alert-info" style="margin:-5px 0px 0px 0px">' +
                        '<div class="alert-text mb-0">' +
                        '<h5 class="font-weight-bold" style="font-size:7pt">Realisasi ' + bulan + '</h5>' +
                        '<span style="font-size:8pt">Rp. ' +
                        realisasi.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +
                        '</span>' +
                        '</div>' +
                        '</div>';

                }
            }
        }
        new ApexCharts(document.querySelector("#dash_spark_1"), dash_spark_1).render();

        function realisasirinc(idskpd) {
            showLoading();
            window.location.href = '{{ route('dashboard.rincian') }}/' + idskpd
        }
    </script>
@endpush
