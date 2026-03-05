<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="reportpdf/bootstrap.min.css">

    <title>Kuitansi Panjar</title>
    <style>
        tr td{
            padding: 0 !important;
            margin: 0 !important;
            }
    </style>
  </head>
  <body>
    <div class="row">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td class="text-center">{{ nm_unit() }}</td>
                </tr>
                <tr>
                    <td class="text-center">KUITANSI PANJAR</td>
                </tr>
            </tbody>
        </table>
    </div><br><br>
    <div class="row">
        <table class="table table-sm table-bordered" cellspacing="0" style="font-size: 10pt; padding: 0; margin: 0" style="width: 100%">
            <tbody>
                <tr>
                    <td colspan="2">Nomor : .............</td>
                    <td>Tanggal : .............</td>
                </tr>
                <tr>
                    <td style="width: 25%">Diserahkan kepada</td>
                    <td class="text-center" style="width: 5%">:</td>
                    <td>{{ $panjar->nm_BUcontr }}</td>
                </tr>
                <tr>
                    <td>Sejumlah</td>
                    <td class="text-center">:</td>
                    <td>@rupiah($total[0]->jml)<br>
                        ({{ terbilang($total[0]->jml) }})
                    </td>
                </tr>  
                <tr>
                    <td> Nomor/Tanggal Permintaan  <br>
                        Panjar
                    </td>
                    <td class="text-center">:</td>
                    <td>{{ $panjar->No_bp }}<br>{{ $panjar->dt_bp }}</td>
                </tr>  
                <tr>
                    <td>Keterangan</td>
                    <td class="text-center">:</td>
                    <td>{{ $panjar->Ur_bp }}</td>
                </tr> 
            </tbody>
        </table>
        <table class="table-sm" style="width: 100%;font-size: 10pt">
            <tr>
                <td style="width: 50%;"></td>
                <td class="text-center" style="width: 50%;">{{ ucfirst(nm_ibukota()) }},{{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="text-center">Diterima oleh,</td>
                <td class="text-center">Bendahara Pengeluaran,</td>
            </tr>
            <tr>
                <td style="height: 8%"></td>
                <td style="height: 8%"></td>
            </tr>
            <tr>
                <td class="text-center">.........................</td>
                <td class="text-center">{{ tb_sub('Nm_Bend')}}</td>
            </tr>
            <tr>
                <td class="text-center">NIP .........................</td>
                <td class="text-center">NIP {{ tb_sub('NIP_Bend')}}</td>
            </tr>
        </table>
    </div>
  </body>
</html>