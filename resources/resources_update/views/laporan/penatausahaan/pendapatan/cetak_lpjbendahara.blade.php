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
    <title>LPJ Bendahara</title>
  </head>
  <body>
      <div class="container py-4" style="background: white">
      <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN SKPD</b></h4>
        <h6 class="my-0" style="text-align: center"><b>Nomor:</b></h6>
        <br>
    <div class="row">
        
    <table class="table-sm" width="100%">
            <tbody>
                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Tahun Anggaran</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%">{{ Tahun() }}</th>
                            </tr>   
                            <tr>
                                <th style="padding-top: 0; padding-bottom: 0; width: 20%">Bulan</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 2%">:</th>
                                <th style="padding-top: 0; padding-bottom: 0; width: 78%"></th>
                            </tr>
            </tbody>
            </table>

            <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>
                   
                            <tr>
                            <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Nomor</th>
                            <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Kode<br>Rekening</th>
                            <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Uraian</th>
                            <th class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Jumlah<br>Anggaran</th>
                            <th class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Sampai dengan Bulan lalu</th>
                            <th class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Bulan ini </th>
                            <th class="text-center" style="vertical-align: middle;" colspan="4" rowspan="1" >Sampai dengan Bulan ini </th>
                            </tr>

                            <tr>
                            <th class="text-center" style="vertical-align: middle;">Penerimaan</th>
                            <th class="text-center" style="vertical-align: middle;">Penyetoran</th>
                            <th class="text-center" style="vertical-align: middle;">Sisa</th>
                            <th class="text-center" style="vertical-align: middle;">Penerimaan</th>
                            <th class="text-center" style="vertical-align: middle;">Penyetoran</th>
                            <th class="text-center" style="vertical-align: middle;">Sisa</th>
                            <th class="text-center" style="vertical-align: middle;">Jumlah<br>Anggaran Yang<br>Terealisasi</th>
                            <th class="text-center" style="vertical-align: middle;">Jumlah Anggaran<br>Yang Telah<br>disetor</th>
                            <th class="text-center" style="vertical-align: middle;">Sisa<br>Yang belum<br>disetor</th>
                            <th class="text-center" style="vertical-align: middle;">Sisa Anggaran<br>Yang belum<br>terealisasi/<br>Pelampauan<br>Anggaran</th>
                            </tr>

                            <tr>
                            <th class="text-center" style="vertical-align: middle;">1</th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                           </tr>

                           <tr>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;">Jumlah</th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                            <th class="text-center" style="vertical-align: middle;"></th>
                           </tr>

            </tbody>
            </table>

            <table class="table-sm" width="100%">
                  <tbody>
                        <tr>
                        <th class="text-center" colspan="8" id="hapus"><br><br>Mengetahui,<br>Pemimpin BLUD<br><br><br>Nama<br>NIP</th>
                        <th class="text-center" colspan="8" id="hapus"><br>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br><br>Bendahara Penerimaan <br><br><br>Nama<br>NIP</th>
                        <br>
                       </tr>
                  </tbody>
            </table>
   
    </div>
    </div>
    
  </body>
</html>