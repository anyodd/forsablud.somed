<!doctype html>
<html lang="en">
    
<style type="text/css">
.table th {
  background-color: white;
}

.table {
  margin-bottom: 1rem;
  color: #212529;
}
.table th,
.table th {
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
.table-sm th {

  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #000000;
}
.table-bordered th,
.table-bordered th {
  border: 1px solid #000000;
}
.table-bordered thead th,
.table-bordered thead th {
  border-bottom-width: 2px;
}

#hapus{
  border: 0px solid #000000;
}


</style>
  <head>
    <title>Buku Pembantu</title>
  </head>
  <body>
  <div class="container py-4" style="background: white">
        <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>BUKU PEMBANTU</b></h4>
        <h4 class="my-0" style="text-align: center"><b>PER RINCIAN OBYEK PENERIMAAN</b></h4>
        <br>

        <table class="table-sm" width="100%">
                  <tbody>
                  
                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Kode Rekening</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%"></th>
                            </tr>     

                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Nama Rekening</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%"></th>
                            </tr>  

                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Jumlah Anggaran</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%"></th>
                            </tr>  

                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Tahun Anggaran</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%">{{ Tahun() }}</th>
                            </tr>
                                            
                   </tbody>
            </table>

            <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>
                   
                    <tr>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Nomor<br>urut</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Nomor BKU<br>Penerimaan</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2" rowspan="1" >Bukti Setor</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Jumlah<br>Rp.</th>
                    </tr>

                    <tr>
                    <th class="text-center" style="vertical-align: middle;">Nomor</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                    </tr>
                  
                    <tr>
                    <th class="text-center" style="vertical-align: middle;">1</th>
                    <th class="text-center" style="vertical-align: middle;"></th>
                    <th class="text-center" style="vertical-align: middle;"></th>
                    <th class="text-center" style="vertical-align: middle;"></th>
                    <th class="text-center" style="vertical-align: middle;"></th>
                    </tr>

                    <tr>
                    <th colspan="4" rowspan="1"  id="hapus">Jumlah Bulan ini</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1"></th>
                    </tr>

                    <tr>
                    <th style="vertical-align: middle;" colspan="4" rowspan="1"  id="hapus">Jumlah s.d Bulan Lalu</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1"></th>
                    </tr>

                    <tr>
                    <th style="vertical-align: middle;" colspan="4" rowspan="1"  id="hapus">Jumlah s.d Bulan ini</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="1"></th>
                    </tr>

            </tbody>
        </table>
                            
        <table class="table-sm" width="100%">
                  <tbody>

                                <tr>
                                <th style="text-align: center; middle; padding-top: 0; padding-bottom: 0"><br>
                                    <br><br><br><br></th>
                                </th>
                                <th style="width: 60%"></th>
                                <th style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara Penerimaan,
                                    <br><br><br>{{ tb_sub('Nm_Bend') }}<br>NIP.{{ tb_sub('Nip_Bend') }}</th>
                                </th>
                                </tr>
                   </tbody>
        </table>
    </div>
    </div>
    
  </body>
</html>