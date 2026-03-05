@extends('layouts.template')
@section('content')
<style>
  :root {
    --apexchart-bg: #ffffff;
    --apexchart-text: #1f2937;
  }

  [data-theme="dark-mode"] {
    --apexchart-bg: #1f2937;
    --apexchart-text: #f3f4f6;
  }
</style>


<div class="container-fluid row justify-content-center ">
	<div class="col-lg-6 col-xl-3 mb-3">
		<div class="card bg-warning text-black h-100">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;">Jumlah Pemda Pengguna</div>
						<div class="font-weight-bold" style="font-size: 16px;">{{ number_format($userPemda['jmluserPemda'], 0, ',', '.') }} Pemda</div>
					</div>
					<i class="fas fa-users-cog align-self-center icon-sm font-24"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;" ><a class="text-black stretched-link" id="pemdarinci" href="#allpemda" data-toggle="modal" title="Data Pemda Pengguna sesuai Permintaan" >Lihat Detail</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-xl-3 mb-3">
		<div class="card bg-success text-black h-100">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;">Pengguna BLUD-RS </div>
						<div class="font-weight-bold" style="font-size: 16px;">{{ number_format($userforsaRs['jmluserforsaRs'], 0, ',', '.') }} BLUD</div>
					</div>
					<i class="fas fa-user-edit align-self-center icon-sm font-24"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;" ><a class="text-black stretched-link" id="rsrinci" href="#allforsaRs" data-toggle="modal" title="Data Pengguna Forsa BLUD-Kesehatan Khusus RSUD">Lihat Detail</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-xl-3 mb-3">
		<div class="card bg-info text-black h-100">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;">Pengguna BLUD-PKM</div>
						<div class="font-weight-bold" style="font-size: 16px;">{{ number_format($userforsaPkm['jmluserforsaPkm'], 0, ',', '.') }} BLUD</div>
					</div>
					<i class="fas fa-user-edit align-self-center icon-sm font-24"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;" ><a class="text-black stretched-link" id="pkmrinci" href="#allforsaPkm" data-toggle="modal" title="Data Pengguna Forsa BLUD-Kesehatan Khusus PKM">Lihat Detail</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-xl-3 mb-3">
		<div class="card bg-danger text-black h-100">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;">Pengguna BLUD-Non Kesehatan </div>
						<div class="font-weight-bold" style="font-size: 16px;">{{ number_format($userforsaNon['jmluserforsaNon'], 0, ',', '.') }} BLUD</div>
					</div>
					<i class="fas fa-user-edit align-self-center icon-sm font-24"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div class="me-3">
						<div class="font-weight-bold" style="font-size: 16px;" ><a class="text-black stretched-link" id="nonrinci" href="#allforsaNon" data-toggle="modal" title="Data Pengguna Forsa BLUD-Non Kesehatan">Lihat Detail</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="card bg-white text-black h-100">
		<div class="card-header bg-light-alt">
			<div class="row align-items-center">
				<div class="col">
					<h4 class="card-title">Realisasi Penyerapan Anggaran Per BLUD</h4>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="">
				<div class="font-weight-bold" style="font-size: 8px;" id="chart"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('modals')
    <div class="modal fade" id="allpemda" tabindex="-1" aria-labelledby="allpemda"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card-body">
                <div class="card-header bg-warning">
					<h5 class="card-title font-weight-bold">Data Pemerintah Daerah Pengguna Forsa sesuai Permintaan/Sudah Aktivasi</h5>  
				</div>
				<div class="table-responsive my-3">
					<table class="table table-hover table-pointer no-footer" id="table-pemda" width="100%">
						<thead class="bg-white text-black-left">
							<tr>
								<th class="vertical-align: middle;">Aksi</th>
								<th class="vertical-align: middle;">Kode Provinsi</th>
								<th class="vertical-align: middle;">Nama Provinsi</th>
								<th class="vertical-align: middle;">Nama Pemerintah Daerah</th>
								<th class="vertical-align: middle;">Ibukota</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($data_pemda as $key => $pemda)
                                <tr class="curs-point" style="font-size: 8pt"
                                    onclick="realisasirinc({{ $pemda->id_pemda }})">
                                    <td width="4%">
                                        <button type="button" class="btn btn-xs btn-light btn-icon-square-xs"
                                            title="lihat detail">
                                            <i class="ti-arrow-right"></i>
                                        </button>
                                    </td>
                                    <td class="text-left">
									   {{ $pemda->kode_pemda }}
                                    </td>
                                    <td class="text-left">
                                       {{ $pemda->nama_prov }}
                                    </td>
                                    <td class="text-left">
                                       {{ $pemda->nama_kab }}
                                    </td>
                                    <td class="text-left">
                                       {{ $pemda->ibukota }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
					</table>
				</div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> T u t u p </button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="allforsaRs" tabindex="-1" aria-labelledby="allforsaRs"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card-body">
                <div class="card-header bg-success">
					<h5 class="card-title font-weight-bold">Data Pengguna BLUD-Kesehatan Khusus RSUD</h5>  
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-pointer no-footer" id="table-pemda" width="100%">
						<thead class="bg-white text-black-left">
							<tr>
								<th class="vertical-align: middle;">Aksi</th>
								<th class="vertical-align: middle;">Kode BLUD</th>
								<th class="vertical-align: middle;">Nama BLUD</th>
								<th class="vertical-align: middle;">Nama Bidang</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($data_forsaRs as $key => $Rs)
                                <tr class="curs-point" style="font-size: 8pt"
                                    onclick="realisasirinc({{ $Rs->id_unit }})">
                                    <td width="4%">
                                        <button type="button" class="btn btn-xs btn-light btn-icon-square-xs"
                                            title="lihat detail">
                                            <i class="ti-arrow-right"></i>
                                        </button>
                                    </td>
                                    <td class="text-left">
									   {{ $Rs->kode_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Rs->uraian_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Rs->Ur_Bid }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
					</table>
				</div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> T u t u p </button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="allforsaPkm" tabindex="-1" aria-labelledby="allforsaPkm"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card-body">
                <div class="card-header bg-info">
					<h5 class="card-title font-weight-bold">Data Pengguna BLUD-Kesehatan Khusus PKM</h5>  
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-pointer no-footer" id="table-pemda" width="100%">
						<thead class="bg-white text-black-left">
							<tr>
								<th class="vertical-align: middle;">Aksi</th>
								<th class="vertical-align: middle;">Kode BLUD</th>
								<th class="vertical-align: middle;">Nama BLUD</th>
								<th class="vertical-align: middle;">Nama Bidang</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($data_forsaPkm as $key => $Pkm)
                                <tr class="curs-point" style="font-size: 8pt"
                                    onclick="realisasirinc({{ $Pkm->id_unit }})">
                                    <td width="4%">
                                        <button type="button" class="btn btn-xs btn-light btn-icon-square-xs"
                                            title="lihat detail">
                                            <i class="ti-arrow-right"></i>
                                        </button>
                                    </td>
                                    <td class="text-left">
									   {{ $Pkm->kode_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Pkm->uraian_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Pkm->Ur_Bid }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
					</table>
				</div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> T u t u p </button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="allforsaNon" tabindex="-1" aria-labelledby="allforsaNon"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content card-body">
                <div class="card-header bg-danger">
					<h5 class="card-title font-weight-bold">Data Pengguna BLUD-Non Kesehatan</h5>  
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-pointer no-footer" id="table-pemda" width="100%">
						<thead class="bg-white text-black-left">
							<tr>
								<th class="vertical-align: middle;">Aksi</th>
								<th class="vertical-align: middle;">Kode BLUD</th>
								<th class="vertical-align: middle;">Nama BLUD</th>
								<th class="vertical-align: middle;">Nama Bidang</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($data_forsaNon as $key => $Non)
                                <tr class="curs-point" style="font-size: 8pt"
                                    onclick="realisasirinc({{ $Non->id_unit }})">
                                    <td width="4%">
                                        <button type="button" class="btn btn-xs btn-light btn-icon-square-xs"
                                            title="lihat detail">
                                            <i class="ti-arrow-right"></i>
                                        </button>
                                    </td>
                                    <td class="text-left">
									   {{ $Non->kode_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Non->uraian_unit }}
                                    </td>
                                    <td class="text-left">
                                       {{ $Non->Ur_Bid }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
					</table>
				</div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> T u t u p </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts_end')
{{--<script type="text/javascript" src="{{asset('newadmin/assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('newadmin/assets/js/moment.js')}}"></script>
<script src="{{ asset('js/dataTables.rowsGroup.js') }}" type="text/javascript"></script>--}}
<script src="{{asset('template')}}/plugins/apex-charts/apexcharts.min.js"></script>
<script type="text/javascript">
$(function() {
	
	var options = {
		series: [
			{
				name: 'Realisasi',
				data: JSON.parse('{!! $anggaran['data_realisasi'] !!}')
			}, 
			{
				name: 'Sisa Anggaran',
				data: JSON.parse('{!! $anggaran['data_sisa'] !!}')
			}, 
			// {
			// 	name: 'Anggaran',
			// 	data: JSON.parse('{!! $anggaran['data_anggaran'] !!}')
			// }, 
		],
		chart: {
			type: 'bar',
			height: 'auto',
			stacked: true,
			stackType: "100%",
			background: '#ffffff', // Set a fixed background color
			offsetX: 5, // horizontal margin
    		offsetY: 25  // vertical margin
		},
		theme: {
			mode: 'light' // This can still change, but background stays fixed
		},
		dataLabels: {
			enabled: false
	
		},
		plotOptions: {
			bar: {
				horizontal: true,
			},
		},

		colors: ['#1aff00', '#ff0051'],

		xaxis: {
			categories: JSON.parse('{!! $anggaran['data_skpd'] !!}'),
			min: 0,
			max: 100,
			labels: {
				formatter: function(val) {
					return val + '%';
				}
			}
		},
		yaxis: {
			labels: {
				style: {
					fontSize: '8px',
					fontFamily: 'Arial, sans-serif'
				}
    		}
		},
		tooltip: {
			custom: function({
				series,
				seriesIndex,
				dataPointIndex,
				w
			}) {
				var label = w.globals.labels[dataPointIndex];
				var totalRealisasi = series[0][dataPointIndex];
				var totalSisa = series[1][dataPointIndex];
				var totalAnggaran = totalRealisasi + totalSisa;
				var persenRealisasi = (totalAnggaran == 0) ? 0 : (totalRealisasi / totalAnggaran) *
					100;
				var persenSisa = (totalAnggaran == 0) ? 0 : (totalSisa / totalAnggaran) * 100;

				return '<div class="card bg-white text-black h-100">' +
					'<div class="alert custom-alert custom-alert-info icon-custom-alert alert-secondary-shadow fade show" style="margin:-10px 0px -15px 0px">' +
					'<div class="alert-text">' +
					'<h5 class="font-weight-bold mt-4">' + label + '</h5>' +
					'<table class="table" style="font-size:8pt;">' +
					'<tbody>' +
					'<tr>' +
					'<td><strong>Total Anggaran</strong></td>' +
					'<td>:</td>' +
					'<td>Rp</td>' +
					'<td class="text-right">' + totalAnggaran.toFixed(2).replace(
						/\d(?=(\d{3})+\.)/g, '$&,') + '</td>' +
					'<td></td>' +
					'</tr>' +
					'<tr>' +
					'<td><strong>Realisasi</strong></td>' +
					'<td>:</td>' +
					'<td>Rp</td>' +
					'<td class="text-right">' + totalRealisasi.toFixed(2).replace(
						/\d(?=(\d{3})+\.)/g, '$&,') + '</td>' +
					'<td>(' + persenRealisasi.toFixed(2) + '%)</td>' +
					'</tr>' +
					'<tr class="table-borderless">' +
					'<td><strong>Sisa</strong></td>' +
					'<td>:</td>' +
					'<td>Rp</td>' +
					'<td class="text-right">' + totalSisa.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
						'$&,') + '</td>' +
					'<td>(' + persenSisa.toFixed(2) + '%)</td>' +
					'</tr>' +
					'</tbody>' +
					'<table>' +
					'</div>' +
					'</div>' +
					'</div>';
			}
		},
		fill: {
			opacity: 0.9
		},
		legend: {
			position: 'top',
			horizontalAlign: 'left',
		}
	};

	var chart = new ApexCharts(document.querySelector("#chart"), options);
	chart.render();
});
</script>
@endpush