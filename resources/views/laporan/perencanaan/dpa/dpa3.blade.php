@extends('layouts.template')
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
<a href="{{ route('dpa1') }}" class="col-sm btn btn-info ml-3 py-1">DPA Pendapatan</a>
  <a href="{{ route('dpa2') }}" class="col-sm btn btn-info ml-3 py-1">DPA Belanja Langsung</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">DPA Penerimaan Pembiayaan</a>
  <a href="{{ route('dpa4') }}" class="col-sm btn btn-info ml-3 py-1">DPA Pengeluaran Pembiayaan</a>
</div>

<div class="card-body">
  <div class="row mb-2">
    <div class="col-sm-10"></div>
    <div class="col-sm">
      <a href="{{ route('dpa3_pdf') }}" class="btn btn-sm btn-danger" target="_blank" style="float: right;">
        <i class="fas fa-file-pdf"></i> Cetak PDF
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <!-- Baris 1 -->
        <td class="text-center" style="vertical-align: middle;" colspan="5" rowspan="2">
          DOKUMEN PELAKSANAAN ANGGARAN<br>
          SATUAN KERJA PERANGKAT DAERAH
        </td>
        <td class="text-center" colspan="2">NOMOR DPA SKPD</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">
          Formulir<br>
          DPA-SKPD	
        </td>
      </tr>
      <tr>
        <!-- Baris 2 -->
        <td class="text-center">{{$unit}}.00.6.1</td>
      </tr>
      <tr>
        <!-- Baris 3 -->
        <td class="text-center" colspan="9">
          {{ nm_pemda() }} <br>
          Tahun Anggaran {{ Tahun() }}
        </td>
      </tr>
      <tr>
        <!-- Baris 4 -->
        <td id="hapus">Urusan Pemerintahan</td>
        <td colspan="7" id="hapus">: 01.02 - Bidang Kesehatan</td>
      </tr>
      <tr>
        <!-- Baris 5 -->
        <td id="hapus">Organisasi</td>
        <td colspan="7" id="hapus">: {{ kd_unit() }} - {{ nm_unit() }}</td>
      </tr>
      <tr>
        <!-- Baris 7 -->
        <td class="text-center" colspan="9">Rincian Penerimaan Pembiayaan</td>
      </tr>
      <tr>
        <!-- Baris 8 -->
        <td class="text-center" style="vertical-align: middle;" colspan="3">Kode Rekening</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3">Uraian</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3">Jumlah<br>
        (Rp)
        </td>
      </tr>
      <tr>
        <!-- Baris 9 -->
        <td class="text-center" style="vertical-align: middle;" colspan="3">1</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3">2</td>
        <td class="text-center" style="vertical-align: middle;" colspan="3">3</td>
      </tr>
      <!-- Baris 10 -->
      @foreach($ambildatadpa3 as $number => $ambildatadpa3)
      <tr>
        <td class="text-center" colspan="3">{{ $ambildatadpa3->Ko_Rkk}}</td>
        <td colspan="3">{{ $ambildatadpa3->Ur_Rk6}}</td>
        <td class="text-right" colspan="3">{{ number_format($ambildatadpa3->To_Rp, 0, ",", ".") }}</td>
      </tr>
      @endforeach
      
      <tr>
        <!-- Baris 13 -->
        <td class="text-right" colspan="7">Jumlah Penerimaan</td>
        <!-- <td class="text-right" colspan="2">{{ number_format($jumlah, 0, ",", ".") }}</td> -->
      </tr>
      <tr>
        <!-- Baris 12 -->
        <td colspan="9" id="hapus">Rencana Pendapatan Per Triwulan</td>
      </tr>
      <tr>
        <!-- Baris 13 -->
        <td colspan="2" id="hapus">Triwulan I</td>
        <td colspan="3" id="hapus">Rp...............................</td>
        <td class="text-center" colspan="4" id="hapus">{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
      </tr>
      <tr>
        <!-- Baris 14 -->
        <td colspan="2" id="hapus">Triwulan II</td>
        <td colspan="3" id="hapus">Rp...............................</td>
        <td class="text-center" colspan="4" id="hapus">Mengesahkan</td>
      </tr>
      <tr>
        <!-- Baris 15 -->
        <td colspan="2" id="hapus">Triwulan III</td>
        <td colspan="3" id="hapus">Rp...............................</td>
        <td class="text-center" colspan="4" id="hapus">Kepala {{ nm_unit() }}</td>
      </tr>
      <tr>
        <!-- Baris 16 -->
        <td colspan="2" id="hapus">Triwulan IV</td>
        <td colspan="3" id="hapus">Rp...............................</td>
        <td class="text-center" id="hapus" colspan="4" rowspan="3" style="vertical-align: middle;">(ttd)</td>
      </tr>
      <tr>
        <!-- Baris 17 -->
        <td colspan="2" id="hapus"></td>
        <td colspan="3" id="hapus"></td>
      </tr>
      <tr>
        <!-- Baris 18 -->
        <td colspan="2" id="hapus"></td>
        <td colspan="3" id="hapus"></td>
      </tr>
      <tr>
        <!-- Baris 19 -->
        <td class="text-center" colspan="2" id="hapus">Jumlah</td>
        <td colspan="3" id="hapus">Rp...............................</td>
        <td class="text-center" id="hapus" colspan="4" rowspan="2">
          {{ $ambildatadpa3->nm_pimp = '' ? $ambildatadpa3->nm_pimp : '-'}}<br>
          NIP. {{ $ambildatadpa3->nip_pimp = '' ? $ambildatadpa3->nip_pimp : '-'}}
        </td>
      </tr>
      <tr>
        <!-- Baris 20 -->
        <td colspan="2" id="hapus"></td>
        <td colspan="3" id="hapus"></td>
      </tr>
    </tbody>
    </table>
  </div>
</div>

@endsection

@section('script') 
@endsection