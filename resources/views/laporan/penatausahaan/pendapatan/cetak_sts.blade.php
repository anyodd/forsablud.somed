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
  padding: 0.3rem;
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




</style>
  <head>
    <title>Surat Tanda Setoran</title>
  </head>
  <body>
      <div class="container py-4" style="background: white">
        <h4 class="my-0" style="text-align: center;padding-top: 0; padding-bottom: 0;"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center;padding-top: 0; padding-bottom: 0;"><b>SURAT TANDA SETORAN</b></h4>
        <br>
    <div class="row">
        
    <table class="table table-sm table-bordered" width="100%" cellspacing="0">
      <tbody>

        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">Nomor</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 48%">{{$data->No_sts}}</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 30%">Tanggal : {{$data->dt_sts}}</td>
        </tr>
        
        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">Bank</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td colspan="2" style="padding-top: 0; padding-bottom: 0; width: 48%">{{$data->Ur_Bank}}</td>
        </tr>

        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">No. Rekening</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td colspan="2" style="padding-top: 0; padding-bottom: 0; width: 48%">{{$data->No_Rek}}</td>
        </tr>

        <tr>
          <td colspan="4">Harap diterima uang dari Bendahara senilai Rp. {{number_format($data->to_rp,2,',','.')}}
            <br>{{'('.terbilang(floor($data->to_rp)).')'}}</td>
        </tr>

        <tr>
          <td colspan="4">Rincian Penerimaan yang disetorkan adalah:</td>
        </tr>

        
        <tr>
        <td style="vertical-align: middle;text-align: center">Kode Rekening</td>
        <td colspan="2" style="vertical-align: middle;text-align: center">Uraian</td>
        <td style="vertical-align: middle;text-align: center" >Nilai</td>
        </tr>

        <tr>
        <td style="vertical-align: middle;text-align: center">{{$data->Ko_rkk}}</td>
        <td colspan="2" style="vertical-align: middle;">{{$data->Ur_Pdp}}</td>
        <td style="vertical-align: middle;">{{'Rp. ' . number_format($data->to_rp,2,',','.')}}</td>
        </tr>

        <tr>
        <td colspan="3" style="vertical-align: middle;text-align: center">Jumlah</td>
        <td style="vertical-align: middle;">{{'Rp. ' . number_format($data->to_rp,2,',','.')}}</td>
        </tr>
        
  
        <tr>
          <td colspan="4"><br>Uang tersebut telah diterima oleh Bank pada tanggal {{$data->dt_byr}}
            <br><br><br>
          </td>
        </tr>
              
      </tbody>
    </table>
    <table style="width: 100%">
      <tbody>
        <tr>
          <td style="width: 60%"></td>
          <td colspan="4" style="text-align: center;vertical-align: middle;width: 40%">
              {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara Penerimaan,
              <br><br><br><br><br>{{ tb_sub('Nm_Bend') }}<br>NIP.{{ tb_sub('Nip_Bend') }}
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </body>
</html>