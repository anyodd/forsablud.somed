@extends('layouts.template')
@section('content')
<div class="container-fluid py-2">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box bg-primary">
        <img src="{{ asset('template/dist/img/budgeting.svg') }}" class="rounded p-2"style="width: 120px">
        <div class="info-box-content">
          <span class="info-box-text text-center"><h3>RSUD</h3></span>
          <span class="info-box-number text-center">{{ $userforsaRs['jmluserforsaRs'] }} Permintaan</span>
          <span>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary text-center"
              role="progressbar"style="width: 100.00%" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" data-inputmask="{{ data_inputmask_percentage() }}">100.00%
            </div>
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box bg-success">
        <img src="{{ asset('template/dist/img/expense.svg') }}" class="rounded p-2"style="width: 120px">
        <div class="info-box-content">
          <span class="info-box-text text-center"><h3>Puskesmas</h3></span>
          <span class="info-box-number text-center">{{ $userforsaPkm['jmluserforsaPkm'] }} Permintaan</span>
          <span>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary text-center"
              role="progressbar"style="width: 100.00%" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" data-inputmask="{{ data_inputmask_percentage() }}">100.00%
            </div>
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box bg-warning">
        <img src="{{ asset('template/dist/img/saving.svg') }}" class="rounded p-2"style="width: 120px">
        <div class="info-box-content">
          <span class="info-box-text text-center"><h3>Lainnya</h3></span>
          <span class="info-box-number text-center">{{ $userforsaNon['jmluserforsaNon'] }} Permintaan</span>
          <span>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary text-center"
              role="progressbar"style="width: 100.00%" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" data-inputmask="{{ data_inputmask_percentage() }}">100.00%
            </div>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="card h-100">
        <div class="card-header bg-navy">
          <h5 class="card-title text-bold">Data Transaksi Sampai Dengan Hari Ini</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless table-striped">
              <tbody>
                <tr>
                  <td class="text-center">
                    <img src="{{ asset('template/dist/img/icon_svg/Book-open.svg') }}"/>
                  </td>
                  <td>
                    <a href="javascript:void(0);" class="text-primary text-bold">Bukti Terima/Klaim</a>
                    <div>
                      <span class="text-bold">{{ number_format($klaim['jumlahklaim'], 0, ',', '.') }}</span>
                      <a href="javascript:void(0);" class="text-primary text-bold">Dokumen</a>
                    </div>
                  </td>
                  <td class="text-right">
                    <span class="text-bold">Rp. {{ format_money($klaim['nilaiklaim'], 2) }}</span>
                  </td>
                  <td class="text-left">
                    <span>Pendapatan Rutin Tahun Berjalan BLUD</span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-primary">Detail</span>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <img src="{{ asset('template/dist/img/icon_svg/Box.svg') }}" class="h-50 align-self-center"/>
                  </td>
                  <td>
                    <a href="javascript:void(0);" class="text-primary text-bold">Tagihan Terbit</a>
                    <div>
                      <span class="text-bold"> {{ number_format($tagihan['jumlahtagihan'], 0, ',', '.') }} </span>
                      <a href="javascript:void(0);" class="text-primary text-bold">Dokumen</a>
                    </div>
                  </td>
                  <td class="text-right">
                    <span class="text-bold">Rp. {{ format_money($tagihan['nilaitagihan'], 2) }}</span>
                  </td>
                  <td class="text-left">
                      <span>Tagihan Tahun Berjalan BLUD</span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-primary">Detail</span>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <img src="{{ asset('template/dist/img/icon_svg/Cupboard.svg') }}" class="h-50 align-self-center"/>
                  </td>
                  <td>
                    <a href="javascript:void(0);" class="text-primary text-bold">Kontrak Di LS-kan</a>
                    <div>
                      <span class="text-bold"> {{ number_format($kontrak['jumlahkontrakls'], 0, ',', '.') }} </span>
                      <a href="javascript:void(0);" class="text-primary text-bold">Dokumen</a>
                    </div>
                  </td>
                  <td class="text-right">
                    <span class="text-bold">Rp. {{ format_money($kontrak['nilaikontrakls'], 2) }}</span>
                  </td>
                  <td class="text-left">
                    <span>Tagihan Kontrak LS/SPK BLUD</span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-primary">Detail</span>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <img src="{{ asset('template/dist/img/icon_svg/Library.svg') }}"/>
                  </td>
                  <td>
                    <a href="javascript:void(0);" class="text-primary text-bold">Bukti GU Terbit</a>
                    <div>
                      <span class="text-bold"> {{ number_format($buktigu['jumlahbuktigu'], 0, ',', '.') }} </span>
                      <a href="javascript:void(0);" class="text-primary text-bold">Dokumen</a>
                    </div>
                  </td>
                  <td class="text-right">
                    <span class="text-bold">Rp. {{ format_money($buktigu['nilaibuktigu'], 2) }}</span>
                  </td>
                  <td class="text-left">
                    <span>Bukti Kuitansi Pembayaran dgn Ganti Uang BLUD</span>
                  </td>
                  <td class="text-center">
                    <span class="badge badge-primary">Detail</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header bg-navy">
          <h5 class="card-title text-bold">Transaksi Bulanan</h5>
        </div>
        <div class="card-body">
					<div class="chart-area">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class="">
                  </div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                  <div class="">
                    </div>
                  </div>
                </div>
                <canvas id="myAreaChart" height="200" style="height: 200px;"></canvas>
              </div>
            </div>
          </div>
	</div>
  </div>
</div>

@endsection

@push('scripts_end')

<script type="text/javascript">
Chart.defaults.global.defaultFontColor = "#858796";
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [
    @foreach($realisasi as $data)
      '{{ $data->Kode }}',
    @endforeach
    ],
    datasets: [{
      label: "Pendapatan",
      lineTension: 0.3,
      backgroundColor: "rgba(0, 97, 242, 0.05)",
      borderColor: "#00FFFF",
      pointRadius: 3,
      pointBackgroundColor: "rgba(0, 97, 242, 1)",
      pointBorderColor: "#4e73df",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
      pointHoverBorderColor: "rgba(0, 97, 242, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [
      @foreach($realisasi as $data)
        {{ $data->pdpt_real }},
      @endforeach ]
    },
    {
      label: "Belanja",
      lineTension: 0.3,
      backgroundColor: "rgba(0, 97, 242, 0.05)",
      borderColor: "#14dc93",
      pointRadius: 3,
      pointBackgroundColor: "rgba(0, 97, 242, 1)",
      pointBorderColor: "#4e73df",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
      pointHoverBorderColor: "rgba(0, 97, 242, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [
        @foreach($realisasi as $data)
          {{ $data->blj_real }},
        @endforeach ]
      }]
    },
    options: {
    maintainAspectRatio: true,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: "date"
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 10
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 12,
          padding: 10,
          callback: function(value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }]
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: "#6e707e",
      titleFontSize: 14,
      borderColor: "#dddfeb",
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: "index",
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel =
            chart.datasets[tooltipItem.datasetIndex].label || "";
          return datasetLabel + ": Rp" + number_format((tooltipItem.yLabel)*1000000);
        }
      }
    }
  }
});

$(function() {
	$('#updateModal').modal({
		show: true
	});
});
</script>
@endpush

