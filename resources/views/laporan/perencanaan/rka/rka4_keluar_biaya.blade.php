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
</style>
@endsection

@section('content')
<div class="row">
  <a href="{{ route('rka1_pendapatan') }}" class="col-sm btn btn-info ml-3 py-1">RKA Pendapatan</a>
  <a href="{{ route('rka2_belanja') }}" class="col-sm btn btn-info ml-3 py-1">RKA Belanja</a>
  <a href="{{ route('rka3_terima_biaya') }}" class="col-sm btn btn-info ml-3 py-1">RKA Penerimaan Pembiayaan</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">RKA Pengeluaran Pembiayaan</a>
</div>


<div class="card-body">
  <div class="row mb-2">
    <div class="col-sm-10"></div>
    <div class="col-sm">
      <a href="{{ route('rka4_keluar_biaya_pdf') }}" class="btn btn-sm btn-danger" target="_blank" style="float: right;">
        <i class="fas fa-file-pdf"></i> Cetak PDF
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
      <tbody>
        <tr>
          <td class="text-center" colspan="2">
            RENCANA KERJA DAN ANGGARAN <br>
            SATUAN KERJA PERANGKAT DAERAH <br>
            {{ nm_pemda() }} <br>
            Tahun Anggaran {{ Tahun() }}
          </td>
          <td class="text-center" style="vertical-align: top;">FORMULIR <br>RKA - SKPD</td>
        </tr>
        <tr>
          <td>Urusan Pemerintahan</td>
          <td colspan="2">: 01.02 - Bidang Kesehatan</td>
        </tr>
        <tr>
          <td>Organisasi</td>
          <td colspan="2">: {{ kd_unit() }} - {{ nm_unit() }}</td>
        </tr>
        <tr>
          <td class="text-center" colspan="3">
            Rincian Pengeluaran Pembiayaan
          </td>
        </tr>
        <tr>
          <td class="text-center" style="vertical-align: middle;">Kode Rekening</td>
          <td class="text-center" style="vertical-align: middle;">Uraian</td>
          <td class="text-center">Jumlah <br>(Rp)</td>
        </tr>
        <tr>
          <td class="text-center">1</td>
          <td class="text-center">2</td>
          <td class="text-center">3</td>
        </tr>

        @foreach($data as $number => $data)
        <tr>
          <td class="text-center">{{ $data->Ko_Rkk}}</td>
          <td>{{ $data->Ur_Rk6 }}</td>
          <td class="text-right">{{ number_format($data->To_Rp, 0, ",", ".") }}</td>
        </tr>
        @endforeach

        <tr>
          <td class="text-right" colspan="2">Jumlah Pengeluaran Pembiayaan</td>
          <td class="text-right">{{ number_format($jumlah, 0, ",", ".") }}</td>
        </tr>

        <tr>
          <td colspan="2" style="border-right-style: none;"></td>
          <td class="text-center" style="border-left-style: none;">
            <br>
            {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }} <br>
            Kepala {{ nm_unit() }} <br><br>
            TTD <br><br>
            {{ $data->nm_pimp = '' ? $data->nm_pimp : '-'}} <br>
            NIP {{ $data->nm_pimp = '' ? $data->nip_pimp : '-' }}
          </td>
        </tr>
      </tbody>
    </table>

    <table class="table table-sm table-bordered" id="" width="100%" cellspacing="0">
      <tbody>
        <tr>
          <td colspan="7">Keterangan: ...................</td>
        </tr>
        <tr>
          <td colspan="7">Tanggal Pembahasan: </td>
        </tr>
        <tr>
          <td colspan="7">Catatan Hasil Pembahasan: </td>
        </tr>
        <tr>
          <td style="width: 3%" class="text-center">1. </td>
          <td colspan="6">..... </td>
        </tr>
        <tr>
          <td style="width: 3%" class="text-center">2. </td>
          <td colspan="6">..... </td>
        </tr>
        <tr>
          <td style="width: 3%" class="text-center">Dst. <br><br></td>
          <td colspan="6">..... </td>
        </tr>
        <tr>
          <td class="text-center" colspan="7">Tim Anggaran Pemerintah Daerah: ...............</td>
        </tr>
        <tr>
          <td style="width: 3%;" class="text-center">No</td>
          <td class="text-center" colspan="2">Nama</td>
          <td class="text-center" colspan="2">NIP</td>
          <td class="text-center">Jabatan</td>
          <td class="text-center">Tanda Tangan</td>
        </tr>
        <tr>
          <td class="text-center">1</td>
          <td colspan="2"></td>
          <td colspan="2"></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-center">2</td>
          <td colspan="2"></td>
          <td colspan="2"></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-center">dst</td>
          <td colspan="2"></td>
          <td colspan="2"></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

  </div>
</div>

@endsection

@section('script') @endsection