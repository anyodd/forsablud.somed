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

#a{
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
  <head>
    <title>Buku Kas Umum Penerimaan</title>
  </head>
  <body>
      <div class="container py-4" style="background: white">
        <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>BUKU KAS UMUM PENERIMAAN</b></h4>
        <br>

        <table class="table-sm" width="100%">
                  <tbody>

                  <tr>
                                <td style="padding-top: 0; padding-bottom: 0; width: 20%">Tahun Anggaran</td>
                                <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
                                <td style="padding-top: 0; padding-bottom: 0; width: 78%">{{ Tahun() }}</td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0; padding-bottom: 0; width: 20%">Bulan</td>
                                <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
                                <td style="padding-top: 0; padding-bottom: 0; width: 78%"></td>
                            </tr>                     
                   </tbody>
            </table>

            <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>
                   
                    <tr>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >No</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Tanggal</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Nomor<br>Bukti</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Kode<br>Rekening</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Uraian</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Penerimaan<br>(Rp)</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Pengeluaran<br>(Rp)</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >Saldo<br>(Rp)</td>
                    </tr>

                    <tr>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" >1.</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1" ></td>
                    </tr>
                  

            </tbody>
            </table>

            <table class="table-sm" width="100%">
                  <tbody>

                  <tr>
                                <td style="text-align: center; middle; padding-top: 0; padding-bottom: 0"><br>
                                    <br><br><br><br></td>
                                </td>
                                <td style="width: 60%"></td>
                                <td style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara Penerimaan,
                                    <br><br><br>{{ tb_sub('Nm_Bend') }}<br>NIP.{{ tb_sub('Nip_Bend') }}</td>
                                </td>
                </tr>
                   </tbody>
            </table>
                            
                       
    </div>
    </div>
    </div>
  </body>
</html>