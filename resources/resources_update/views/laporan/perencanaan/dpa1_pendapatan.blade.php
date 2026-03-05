@extends('layouts.template')
@section('style') 
<style type="text/css">
.table td {
  background-color: white;
}
</style>
@endsection

@section('content')
<div class="row">
  <a href="#" class="col-sm btn btn-primary ml-3 py-1 disabled">DPA Pendapatan</a>
  <a href="{{ route('dpa1_pendapatan') }}" class="col-sm btn btn-info ml-3 py-1">DPA Belanja Langsung</a>
  <a href="{{ route('dpa1_pendapatan') }}" class="col-sm btn btn-info ml-3 py-1">DPA Penerimaan Pembiayaan</a>
  <a href="{{ route('dpa1_pendapatan') }}" class="col-sm btn btn-info ml-3 py-1">DPA Pengeluaran Pembiayaan</a>
</div>


<div class="card-body">
  <div class="table-responsive">
    <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
    <thead class="">
      <tr>
        <!-- Baris 1 -->
        <td class="text-center" style="vertical-align: middle;" colspan="7" rowspan="2">
          DOKUMEN PELAKSANAAN ANGGARAN<br>
          SATUAN KERJA PERANGKAT DAERAH
        </td>
        <td class="text-center" colspan="6">NOMOR DPA SKPD</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">
          Formulir<br>
          DPA-SKPD	
        </td>
      </tr>
      <tr>
        <!-- Baris 2 -->
        <td class="text-center" colspan="2">X.XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">00</td>
        <td class="text-center">00</td>
        <td class="text-center">4</td>
      </tr>
      <tr>
        <!-- Baris 3 -->
        <td class="text-center" colspan="15">
          Provinsi/Kabupaten/Kota .................................. (2)<br>
          Tahun Anggaran ........................................ (3)
        </td>
      </tr>
      <tr>
        <!-- Baris 4 -->
        <td colspan="2">Urusan Pemerintahan</td>
        <td colspan="13"> : x.xx. ......................... (4)</td>
      </tr>
      <tr>
        <!-- Baris 5 -->
        <td colspan="2">Organisasi</td>
        <td colspan="13"> : x.xx.xx. ......................... (5)</td>
      </tr>
      <tr>
        <!-- Baris 6 -->
        <td class="text-center" colspan="15">
          Rincian Dokumen Pelaksanaan Anggaran Pendapatan<br>
          Satuan Kerja Perangkat Daerah
        </td>
      </tr>
      <tr>
        <!-- Baris 7 -->
        <td class="text-center" style="vertical-align: middle;" colspan="5" rowspan="2">Kode Rekening Uraian</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Uraian</td>
        <td class="text-center" colspan="6">Rincian Penghitungan</td>
        <td class="text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Jumlah</td>
      </tr>
      <tr>
        <!-- Baris 8 -->
        <td class="text-center" colspan="2">Volume</td>
        <td class="text-center" colspan="2">Satuan</td>
        <td class="text-center" colspan="2">Tarif/Harga</td>
      </tr>
      <tr>
        <!-- Baris 9 -->
        <td class="text-center" colspan="5">1 .. (6)</td>
        <td class="text-center" colspan="2">2 .. (7)</td>
        <td class="text-center" colspan="2">3 .. (8)</td>
        <td class="text-center" colspan="2">4 .. (9)</td>
        <td class="text-center" colspan="2">5 .. (10)</td>
        <td class="text-center" colspan="2">6=3x5 .. (11)</td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <!-- Baris 10 -->
        <td class="text-center">XX</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td colspan="2">Pendapatan</td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 11 -->
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td colspan="2">PAD</td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
        <!-- Baris 12 -->
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td colspan="2">Lain-lain PAD yang sah</td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 13 -->
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center"></td>
          <td colspan="2">Pendapatan BLUD</td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
        <!-- Baris 14 -->
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td colspan="2">Pendapatan BLUD ....</td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 15 -->
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
        <!-- Baris 16 -->
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center">XX</td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
        <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 17 -->
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center">XX</td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
          <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 18 -->
          <td class="text-right" colspan="13">Jumlah</td>
          <td class="text-center" colspan="2"></td>
      </tr>
      <tr>
          <!-- Baris 19 -->
          <td class="text-left" colspan="15">Rencana Pendapatan Per Triwulan</td>
      </tr>
      <tr>
          <!-- Baris 20 -->
          <td class="text-center" colspan="9"></td>
          <td class="text-center" colspan="6">Kota, ..... ...................    20...... (12)</td>
      </tr>
      <tr>
          <!-- Baris 21 -->
          <td class="text-center">Triwulan I</td>
          <td class="text-left" colspan="7">Rp............................... (13)</td>
          <td class="text-center" colspan="6">Mengesahkan</td>
      </tr>
      <tr>
          <!-- Baris 22 -->
          <td class="text-center">Triwulan II</td>
          <td class="text-left" colspan="7">Rp............................... (13)</td>
          <td class="text-center" colspan="6">Pejabat Pengelola Keuangan Daerah</td>
      </tr>
      <tr>
          <!-- Baris 23 -->
          <td class="text-center">Triwulan III</td>
          <td class="text-left" colspan="7">Rp............................... (13)</td>
          <td class="text-center" style="vertical-align: middle;" colspan="6" rowspan="2">(ttd)</td>
      </tr>
      <tr>
          <!-- Baris 25 -->
          <td class="text-center">Triwulan IV</td>
          <td class="text-left" colspan="7">Rp............................... (13)</td>
      </tr>
      <tr>
          <!-- Baris 26 -->
          <td class="text-center" colspan="9"></td>
          <td class="text-center" colspan="6">(nama lengkap)</td>
      </tr>
      <tr>
          <!-- Baris 27 -->
          <td class="text-center" colspan="9"></td>
          <td class="text-center" colspan="6">NIP. ...................</td>
      </tr>
    </tbody>
    </table>
  </div>
</div>

@endsection

@section('script') 
@endsection