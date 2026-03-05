{{-- Stats Widget 7 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Body --}}
    <div class="card-body d-flex flex-column p-0">
        {{--<div id="kt_stats_widget_7_chart" class="card-rounded-bottom" style="height: 150px"></div>--}}
		<div class="col-xl-12 mb-4">
			<div class="card card-header-actions h-100">
				<div class="card-header">
				<h4 class="card-title"><span class="card-label font-weight-bolder text-dark">Transaksi Bulanan</span></h4>
				</div>
				<div class="card-body">
					<div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div><canvas id="myAreaChart" width="510" height="310" style="display: block; height: 240px; width: 408px;" class="chartjs-render-monitor"></canvas></div>
				</div>
			</div>
		</div>
    </div>
</div>

@push('scripts_end')

<script type="text/javascript">
// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Metropolis"),
'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";
	
function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
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
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
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


// Area Chart
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
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
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
                    // Include a dollar sign in the ticks
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

</script>
@endpush
