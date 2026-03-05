<!doctype html>
<html lang="en">
<style type="text/css">
.table td {
  background-color: white;
}

.table {
  margin-bottom: 1rem;
  color: #212529;
}
.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #000000;
}
.table thead th {
  border: 1px solid #000000;
  vertical-align: middle;
}
.table tbody + tbody {
  border-top: 2px solid #000000;
}
.table-sm th,
.table-sm td {
  padding: 0.7rem;
}

.table-bordered {
  border: 1px solid #000000;
}
.table-bordered th,
.table-bordered td {
  border: 1px solid #000000;
}
.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

#hapus{
  border: 0px solid #000000;
}

#a{
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
  <head>
    <title>Bukti Penerimaan Pendapatan</title>
  </head>
  <body>
  <div class="container py-4" style="background: white">
        <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>BUKTI PENERIMAAN PENDAPATAN</b></h4>
        <br>

            <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>

                    <tr>
                    <td style="vertical-align: middle;" colspan="7">Nomor: {{$data->No_bp}}</td>
                    <td style="vertical-align: middle;" colspan="2">Tanggal: {{ $data->dt_bp }}</td>
                    </tr>

                    <tr>
                    <td id="hapus" colspan="3">Jenis Pelayanan
                      <br>{{$data->Ur_Pdp}}
                    </td>
                    <td colspan="6">Diterima:
                    <br>{{$data->Ur_kas}}
                    </td>
                   </tr>
    
                    
                    <tr>
                    <td style="vertical-align: middle;" colspan="2" rowspan="1">Diterima dari</td>
                    <td style="vertical-align: middle; width: 3%" colspan="1" rowspan="1"> :</td>
                    <td style="vertical-align: middle;" colspan="6" rowspan="1">{{$data->nm_BUcontr}}</td>
                    </tr>

                    <tr>
                    <!-- Baris 4 -->
                    <td style="vertical-align: middle;" colspan="2" rowspan="1"> Sejumlah</td>
                    <td style="vertical-align: middle;" colspan="1" rowspan="1">:</td>
                    <td style="vertical-align: middle;" colspan="6" rowspan="1">{{'Rp. ' . number_format($data->to_rp,2,',','.')}}
                  <br>(terbilang {{terbilang(floor($data->to_rp))}})</td>
                    </tr>

                    <tr>
                    <!-- Baris 5 -->
                    <td style="vertical-align: middle;" colspan="2" rowspan="1"> Keterangan</td>
                    <td style="vertical-align: middle;" colspan="1" rowspan="1">:</td>
                    <td style="vertical-align: middle;" colspan="6" rowspan="1">{{$data->ur_bp}}</td>
                    </tr>
            </tbody>
            </table>
            <table style="width: 100%">
              <tbody>
                  <tr>
                      <td style="text-align: center;width: 50%"> 
                          
                      </td>
                      <td style="text-align: center"> 
                          {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }},<br>
                              Bendahara Penerimaan<br>
                              <br><br><br>
                              {{ tb_sub('Nm_Bend') }}<br>
                              NIP. {{ tb_sub('Nm_Bend') }}
                          <br><br><br>
                      </td>
                  </tr>
              </tbody>
          </table>    
    </div>
    </div>

    
  </body>
</html>