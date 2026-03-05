@extends('layouts.template')
@section('style') 
@section('style') 
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
@endsection

@section('content')
<div class="row">
<a href="{{ route('bppendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Bukti Penerimaan Pendapatan</a>
  <a href="{{ route('stspendapatan') }}" class="col-sm btn btn-info ml-3 py-1 ">Surat Tanda Setoran</a>
  <a href="{{ route('rppendapatan') }}" class="col-sm btn btn-info ml-3 py-1 ">Rekapitulasi Penerimaan Pendapatan</a>
  <a href="{{ route('bkupenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Buku Kas Umum Penerimaan</a>
  <a href="{{ route('bprincian') }}" class="col-sm btn btn-info ml-3 py-1">Buku Pembantu</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">LPJ Bendahara</a>
  <a href="{{ route('otopenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Otorisasi Penerimaan</a>
</div>

<div class="card-body pt-0">
  <div class="row mb-2">
    <div class="col-sm-10"></div>
    <div class="col-sm">
    <a href="javascript:cetak();"><button class="btn btn-primary" id="cetak">Cetak PDF</button></a>
      </a>
    </div>
  </div>

  <div class="container py-4" style="background: white">
        <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN SKPD</b></h4>
        <h6 class="my-0" style="text-align: center"><b>Nomor:</b></h6>
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
                            <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Nomor</td>
                            <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Kode<br>Rekening</td>
                            <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Uraian</td>
                            <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Jumlah<br>Anggaran</td>
                            <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Sampai dengan Bulan lalu</td>
                            <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Bulan ini </td>
                            <td class="text-center" style="vertical-align: middle;" colspan="4" rowspan="1" >Sampai dengan Bulan ini </td>
                            </tr>

                            <tr>
                            <td class="text-center" style="vertical-align: middle;">Penerimaan</td>
                            <td class="text-center" style="vertical-align: middle;">Penyetoran</td>
                            <td class="text-center" style="vertical-align: middle;">Sisa</td>
                            <td class="text-center" style="vertical-align: middle;">Penerimaan</td>
                            <td class="text-center" style="vertical-align: middle;">Penyetoran</td>
                            <td class="text-center" style="vertical-align: middle;">Sisa</td>
                            <td class="text-center" style="vertical-align: middle;">Jumlah<br>Anggaran Yang<br>Terealisasi</td>
                            <td class="text-center" style="vertical-align: middle;">Jumlah Anggaran<br>Yang Telah<br>disetor</td>
                            <td class="text-center" style="vertical-align: middle;">Sisa<br>Yang belum<br>disetor</td>
                            <td class="text-center" style="vertical-align: middle;">Sisa Anggaran<br>Yang belum<br>terealisasi/<br>Pelampauan<br>Anggaran</td>
                            </tr>

                            <tr>
                            <td class="text-center" style="vertical-align: middle;">1</td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                           </tr>

                           <tr>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;">Jumlah</td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                            <td class="text-center" style="vertical-align: middle;"></td>
                           </tr>

            </tbody>
            </table>

            <table class="table-sm" width="100%">
                  <tbody>
                        <tr>
                        <td class="text-center" colspan="8" id="hapus"><br><br>Mengetahui,<br>Pemimpin BLUD<br><br><br>Nama<br>NIP</td>
                        <td class="text-center" colspan="8" id="hapus"><br>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br><br>Bendahara Penerimaan <br><br><br>Nama<br>NIP</td>
                        <br>
                       </tr>
                  </tbody>
            </table>
    </div>
    </div>
    </div>

@endsection

@section('script')
    <script>

    function cetak() {
            var id =  document.getElementById("cetak").value;
            window.open('stspendapatan/lpjbendahara_pdf/'+id,'_blank');
            
        };

    </script>
@endsection