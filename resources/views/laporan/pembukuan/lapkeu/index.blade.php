@extends('layouts.template')
@section('style') 
<meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-10">

        <form action="{{ route('lapkeu_pdf') }}" method="get" class="form-horizontal" target="_blank">
          @csrf

          <div class="card shadow-lg mt-2">
            <div class="card-header bg-info py-2">
              <h5 class="card-title font-weight-bold">Laporan Keuangan</h5> 
            </div>

            <div class="card-body">
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Jenis Laporan</label>
                <div class="col">
                  <select name="jns_lap" class="form-control" id="">
                    <option value="" disabled>-- Pilih Jenis Laporan --</option>
                    <option value="lra">Laporan Realisasi Anggaran (LRA)</option>
                    <option value="lpsal">Laporan Perubahan Saldo Anggaran Lebih (LP SAL)</option>
                    <option value="nrc" selected>Neraca</option>
                    <option value="lo">Laporan Operasional (LO)</option>
                    <option value="lak">Laporan Arus Kas (LAK)</option>
                    <option value="lpe">Laporan Perubahan Ekuitas (LPE)</option>
                    <option value="nrcsaldo">Neraca Saldo</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Posisi s.d.</label>
                <div class="col">
                  <select name="jns_periode" class="form-control" id="">
                    {{-- <option value="" selected disabled>-- Pilih Periode Pelaporan --</option> --}}
                    <option value="tahun" selected>Tahunan</option>
                    <option value="sem1">Semester I</option>
                    <option value="sem2">Semester II</option>
                    <option value="tri1" hidden>Triwulan I</option>
                    <option value="tri2" hidden>Triwulan II</option>
                    <option value="tri3" hidden>Triwulan III</option>
                    <option value="tri4" hidden>Triwulan IV</option>
                    <option value="bulan01">Bulan Januari</option>
                    <option value="bulan02">Bulan Februari</option>
                    <option value="bulan03">Bulan Maret</option>
                    <option value="bulan04">Bulan April</option>
                    <option value="bulan05">Bulan Mei</option>
                    <option value="bulan06">Bulan Juni</option>
                    <option value="bulan07">Bulan Juli</option>
                    <option value="bulan08">Bulan Agustus</option>
                    <option value="bulan09">Bulan September</option>
                    <option value="bulan10">Bulan Oktober</option>
                    <option value="bulan11">Bulan November</option>
                    <option value="bulan12">Bulan Desember</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Tanggal Cetak Laporan</label>
                <div class="col-sm">
                  <input type="date" name="tgl_lap" class="form-control" value="" >
                </div>
              </div>

              <div class="card-footer">
                <div class="form-group row justify-content-center">
                  <button type="submit" class="col btn btn-primary rounded-pill" name="submit">
                    <i class="fa fa-print"> Preview / Cetak</i>
                  </button>
                </div>
              </div>

            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>  

@endsection

@section('script') @endsection