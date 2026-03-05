<!doctype html>
<html lang="en">
  <style>
    table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                  }

    #hapus{
           border: 0px solid #000000;
          }

          .center  { text-align: center;}
   
    </style>
  <head>
    <title>Otorisasi Penerimaan</title>
  </head>
  <body>
      <div class="container py-4" style="background: white">
      <h4 class="my-0" style="text-align: center"><b>OTORISASI PENERIMAAN</b></h4>
        <br>
    <div class="row">
        
    <table class="table table-sm table-bordered" width="100%">
            <tbody>
                   
                            <tr>
                            <td style="vertical-align: middle; width: 50%" colspan="8" rowspan="1" ><h5><b>{{ nm_unit() }}</td></h5>
                            <td style="vertical-align: middle; width: 50%" colspan="8" rowspan="1" ><h5><b>SURAT OTORISASI PENERIMAAN</td></h5>
                            </tr>

                            <tr>
                            <td colspan="4" rowspan="1" id="hapus">Nomor<br>Permintaan<br>Pembayaran</td>
                            <td colspan="4" rowspan="1" id="hapus">:</td>
                            <td  colspan="4" rowspan="1" >Nomor</td>
                            <td colspan="4" rowspan="1" id="hapus">:</td>
                            </tr>

                            <tr>
                            <td colspan="4" rowspan="1" >Tanggal</td>
                            <td colspan="4" rowspan="1" >:</td>
                            <td colspan="4" rowspan="1">Tanggal</td>
                            <td colspan="4" rowspan="1" >:</td>
                            </tr>

                            <tr>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1">Unit Layanan:</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1">Dari</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</td>
                            </tr>

                            <tr>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="8" rowspan="1" ></td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >Tahun<br>Anggaran</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</td>
                            </tr>

                            <tr>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="16" rowspan="1"><br></td>
                            </tr>

                            <tr>
                            <td style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="16" rowspan="1" >Menyetejui Penerimaan Sejumlah Rp. (terbilang) dengan rincian:</td>
                            </tr>

                            <tr>
                            <td class="center" style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="2" rowspan="1" >No.</td>
                            <td class="center" style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" >Kode Rekening</td>
                            <td class="center" style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" >Jumlah</td>
                            </tr>

                            <tr>
                            <td class="center" style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="2" rowspan="1" >1.</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" ></td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" ></td>
                            </tr>

                            <tr>
                            <td class="center" style="padding-top: 0; padding-bottom: 0; width: 90%" colspan="10" rowspan="1" >Jumlah Penerimaan</td>
                            <td style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="6" rowspan="1" >Rp.</td>
                            </tr>
            </tbody>
            </table>

            <table class="table table-sm table-bordered" width="100%">
                  <tbody>
                        <tr>
                        <td class="center" colspan= "8" id="hapus"><br><br>Pimpinan BLUD<br><br><br>Nama<br>NIP</td>
                        <td class="center" colspan="8" id="hapus"><br>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Pejabat Keuangan<br><br><br>Nama<br>NIP</td>
                        <br>
                       </tr>
                  </tbody>
            </table>
   
    </div>
    </div>
    
  </body>
</html>