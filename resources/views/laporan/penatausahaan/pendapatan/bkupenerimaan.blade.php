@extends('layouts.template')

@section('content')
<div class="row">
<a href="{{ route('bppendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Bukti Penerimaan Pendapatan</a>
  <a href="{{ route('stspendapatan') }}" class="col-sm btn btn-info ml-3 py-1 ">Surat Tanda Setoran</a>
  <a href="{{ route('rppendapatan') }}" class="col-sm btn btn-info ml-3 py-1 ">Rekapitulasi Penerimaan Pendapatan</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">Buku Kas Umum Penerimaan</a>
  <a href="{{ route('bprincian') }}" class="col-sm btn btn-info ml-3 py-1">Buku Pembantu</a>
  <a href="{{ route('lpjbendahara') }}" class="col-sm btn btn-info ml-3 py-1">LPJ Bendahara</a>
  <a href="{{ route('otopenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Otorisasi Penerimaan</a>
</div>

<div class="card-body pt-0">
  <div class="container py-4 mt-2" style="background: white">
    <div class="col-sm-2">
      <a href="javascript:cetak();"><button class="btn btn-primary" id="cetak"><i class="fas fa-print"></i> Cetak</button></a>
    </div>
    <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
    <h4 class="my-0" style="text-align: center"><b>BUKU KAS UMUM PENERIMAAN</b></h4>
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
            <td style="padding-top: 0; padding-bottom: 0; width: 78%">{{date('M')}}</td>
        </tr>                     
      </tbody>
    </table>

    <table class="table table-sm table-bordered" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th class="text-center" style="vertical-align: middle;">No</th>
          <th class="text-center" style="vertical-align: middle;">Tanggal</th>
          <th class="text-center" style="vertical-align: middle;">Nomor<br>Bukti</th>
          <th class="text-center" style="vertical-align: middle;">Kode Rekening</th>
          <th class="text-center" style="vertical-align: middle;">Uraian</th>
          <th class="text-center" style="vertical-align: middle;">Penerimaan<br>(Rp)</th>
          <th class="text-center" style="vertical-align: middle;">Pengeluaran<br>(Rp)</th>
          <th class="text-center" style="vertical-align: middle;">Saldo<br>(Rp)</th>
        </tr>
      <thead>
      <tbody>
        @php $no=1; $sum=0; @endphp
        @foreach ($dt as $item)
        <tr>
          <td class="text-center" style="vertical-align: middle;">{{$no++}}</td>
          <td class="text-center" style="vertical-align: middle;">{{ date('d M Y', strtotime($item->dt_bp)) }}</td>                      
          <td class="text-center" style="vertical-align: middle;">{{$item->no_bp}}</td>
          <td class="text-center" style="vertical-align: middle;">{{$item->Ko_Rkk}}</td>
          <td class="text-left" style="vertical-align: middle;">{{$item->Ur_bp}}</td>
          <td class="text-right" style="vertical-align: middle;">{{number_format($item->Terima,2,',','.')}}</td>
          <td class="text-right" style="vertical-align: middle;">{{number_format($item->Setor,2,',','.')}}</td>
          <td class="text-right" style="vertical-align: middle;">
            {{ number_format($sum += $item->Terima - $item->Setor,2,',','.') }}
          </td>
        </tr> 
        @endforeach

      </tbody>
    </table>
    {{-- <table width="100%">
      <tbody>
        <tr>
          <td>
              {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara Penerimaan,
              <br>Nama Lengkap<br>NIP. .........
          </td>
        </tr>
      </tbody>
    </table>  --}}
  </div>
</div>

@endsection

@section('script')
  <script>
    function cetak() {
      var id =  document.getElementById("cetak").value;
      window.open('stspendapatan/bkupenerimaan_pdf/'+id,'_blank');  
    };
  </script>
@endsection