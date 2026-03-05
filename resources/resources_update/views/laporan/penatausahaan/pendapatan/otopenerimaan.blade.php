@extends('layouts.template')
@section('style') 
@section('style') 
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
  <a href="{{ route('lpjbendahara') }}" class="col-sm btn btn-info ml-3 py-1">LPJ Bendahara</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">Otorisasi Penerimaan</a>
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
        <h4 class="my-0" style="text-align: center"><b>OTORISASI PENERIMAAN</b></h4>
        <br>

            <table class="table table-sm table-bordered" width="100%">
            <tbody>
                   
                            <tr>
                            <th style="vertical-align: middle; width: 50%" colspan="8" rowspan="1" ><h5><b>{{ nm_unit() }}</th></h5>
                            <th style="vertical-align: middle; width: 50%" colspan="8" rowspan="1" ><h5><b>SURAT OTORISASI PENERIMAAN</th></h5>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" id="hapus">Nomor<br>Permintaan<br>Pembayaran</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" id="hapus">:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >Nomor</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >Tanggal</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1">Tanggal:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1">Unit Layanan:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1">Dari:</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="8" rowspan="1" ></th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >Tahun<br>Anggaran</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="4" rowspan="1" >:</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="16" rowspan="1"><br></th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 20%" colspan="16" rowspan="1" >Menyetejui Penerimaan Sejumlah Rp. (terbilang) dengan rincian:</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="2" rowspan="1" >No.</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" >Kode Rekening</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" >Jumlah</th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="2" rowspan="1" >1.</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" ></th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 45%" colspan="7" rowspan="1" ></th>
                            </tr>

                            <tr>
                            <th style="padding-top: 0; padding-bottom: 0; width: 90%" colspan="10" rowspan="1" >Jumlah Penerimaan</th>
                            <th style="padding-top: 0; padding-bottom: 0; width: 10%" colspan="6" rowspan="1" >Rp.</th>
                            </tr>
            </tbody>
            </table>

            <table class="table-sm" width="100%">
                  <tbody>
                        <tr>
                        <th class="text-center" colspan="8" id="hapus"><br><br>Pimpinan BLUD<br><br><br>Nama<br>NIP</th>
                        <th class="text-center" colspan="8" id="hapus"><br>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Pejabat Keuangan<br><br><br>Nama<br>NIP</th>
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
            window.open('stspendapatan/otopenerimaan_pdf/'+id,'_blank');
            
        };

    </script>
@endsection