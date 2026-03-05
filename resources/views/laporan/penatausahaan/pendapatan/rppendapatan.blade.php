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
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">Rekapitulasi Penerimaan Pendapatan</a>
  <a href="{{ route('bkupenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Buku Kas Umum Penerimaan</a>
  <a href="{{ route('bprincian') }}" class="col-sm btn btn-info ml-3 py-1">Buku Pembantu</a>
  <a href="{{ route('lpjbendahara') }}" class="col-sm btn btn-info ml-3 py-1">LPJ Bendahara</a>
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
        <h4 class="my-0" style="text-align: center"><b>REKAPITULASI PENERIMAAN PENDAPATAN</b></h4>
        <br>

            <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>
                   
                    <tr>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >No</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="1" >Bukti <br>Penerimaan</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Jasa Layanan</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Hibah</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Kerja Sama</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="3" rowspan="1" >Lainnya</td>
                    <td class="text-center" style="vertical-align: middle;" colspan="1" rowspan="2" >Total</td>
                    </tr>

                    <tr>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >No.</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Tgl</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Umum</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >BPJS</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Asuransi</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >APBN</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >APBD</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >CSR</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >KSO</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >KSP</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Sewa</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Jasa<br>Giro</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Bunga</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >Lainnya</td>
                    </tr>

                    <tr>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" >1.</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    </tr>

                    <tr>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" colspan="2" >Jumlah</td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    <td class="text-center" style="vertical-align: middle;" rowspan="1" ></td>
                    </tr>
                   
                    

                    

            </tbody>
            </table>

            <table class="table-sm" width="100%">
                  <tbody>
                        <tr>
                        <td class="text-center" colspan="8" id="hapus"><br><br>Telah direviu oleh,<br>Pejabat Keuangan<br><br><br>Nama<br>NIP</td>
                        <td class="text-center" colspan="8" id="hapus"><br>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Dibuat oleh,<br>Bendahara Penerima <br><br><br>Nama<br>NIP</td>
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
            window.open('stspendapatan/rppendapatan_pdf/'+id,'_blank');
            
        };

    </script>
@endsection