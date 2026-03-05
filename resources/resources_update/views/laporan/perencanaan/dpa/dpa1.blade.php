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
<a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">DPA Pendapatan</a>
  <a href="{{ route('dpa2') }}" class="col-sm btn btn-info ml-3 py-1">DPA Belanja Langsung</a>
  <a href="{{ route('dpa3') }}" class="col-sm btn btn-info ml-3 py-1">DPA Penerimaan Pembiayaan</a>
  <a href="{{ route('dpa4') }}" class="col-sm btn btn-info ml-3 py-1">DPA Pengeluaran Pembiayaan</a>
</div>

<div class="card-body">
  <div class="row mb-2">
    <div class="col-sm-10"></div>
    <div class="col-sm">
      <a href="{{ route('dpa1_pdf') }}" class="btn btn-sm btn-danger" target="_blank" style="float: right;">
        <i class="fas fa-file-pdf"></i> Cetak PDF
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <!-- Baris 1 -->
        <td class="text-center" style="vertical-align: middle;" colspan="4" rowspan="2">
          DOKUMEN PELAKSANAAN ANGGARAN<br>
          SATUAN KERJA PERANGKAT DAERAH
        </td>
        <td class="text-center" colspan="3">NOMOR DPA SKPD</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">
          Formulir<br>
          DPA-SKPD	
        </td>
      </tr>
      <tr>
        <!-- Baris 2 -->
        <td class="text-center" colspan="3">{{$unit}}.00.4</td>
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
        <!-- Baris 6 -->
        <td class="text-center" colspan="9">
          Rincian Dokumen Pelaksanaan Anggaran Pendapatan<br>
          Satuan Kerja Perangkat Daerah
        </td>
      </tr>
      <tr>
        <!-- Baris 7 -->
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Kode Rekening</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Uraian</td>
        <td class="text-center" colspan="3">Rincian Penghitungan</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Jumlah</td>
      </tr>
      <tr>
        <!-- Baris 8 -->
        <td class="text-center">Volume</td>
        <td class="text-center">Satuan</td>
        <td class="text-center">Tarif/Harga</td>
      </tr>
      <tr>
        <!-- Baris 9 -->
        <td class="text-center" colspan="2">1</td>
        <td class="text-center" colspan="2">2</td>
        <td class="text-center">3</td>
        <td class="text-center">4</td>
        <td class="text-center">5</td>
        <td class="text-center" colspan="2">6</td>
      </tr>

      @foreach($ambildatadpa1 as $number => $ambildatadpa1)
      <tr>
        <!-- Baris 10 -->
        <td class="text-center" colspan="2">{{ $ambildatadpa1->Ko_Rkk}}</td>
        <td colspan="2">{{ $ambildatadpa1->Ur_Rk6}}</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-right" colspan="2">Rp.{{ number_format($ambildatadpa1->To_Rp, 0, ",", ".") }}</td>
      </tr>
      @endforeach
      <tr>
          <!-- Baris 15 -->
          <td class="text-right" colspan="7">Jumlah</td>
          <td class="text-right" colspan="2">Rp.{{ number_format($jumlah, 0, ",", ".") }}</td>
      </tr>
      <tr>
          <!-- Baris 12 -->
          <td colspan="9" id="hapus">Rencana Pendapatan Per Triwulan</td>
        </tr>
        <tr>
          <!-- Baris 13 -->
          <td colspan="2" id="hapus">Triwulan I</td>
          <td id="hapus">Rp...............................</td>
          <td class="text-center" colspan="7" id="hapus">{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
        </tr>
        <tr>
          <!-- Baris 14 -->
          <td colspan="2" id="hapus">Triwulan II</td>
          <td id="hapus">Rp...............................</td>
          <td class="text-center" colspan="7" id="hapus">Mengesahkan</td>
        </tr>
        <tr>
          <!-- Baris 15 -->
          <td colspan="2" id="hapus">Triwulan III</td>
          <td id="hapus">Rp...............................</td>
          <td class="text-center" colspan="7" id="hapus">Kepala {{ nm_unit() }}</td>
        </tr>
        <tr>
          <!-- Baris 16 -->
          <td colspan="2" id="hapus">Triwulan IV</td>
          <td id="hapus">Rp...............................</td>
          <td class="text-center" id="hapus" colspan="7" rowspan="3" style="vertical-align: middle;">(ttd)</td>
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
          <td id="hapus">Rp...............................</td>
          <td class="text-center" id="hapus" colspan="7" rowspan="2">
            {{ $ambildatadpa1->nm_pimp}}<br>
            NIP. {{ $ambildatadpa1->nip_pimp}}
          </td>
      </tr>
    </tbody>
    </table>
  </div>
</div>

@endsection

@section('script') 
@endsection