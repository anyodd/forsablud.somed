@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">UBAH PENETAPAN</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <form action="{{ route('penetapan.update', $tap->id_tap) }}" method="post">
                            @csrf
                            @method("PUT")
                            @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                                Perhatian!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="card-body">
                                <div class="form-group row">
                                    {{-- <label for="noId" class="col-sm-3 col-form-label">No. Id</label> --}}
                                    <div class="col-sm-1">
                                        <input type="text" name="noId"
                                            class="form-control @error('noId') is-invalid @enderror"
                                            value="{{ $tap->id_tap }}" id="noId" hidden>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kodePenetapanApbd" class="col-sm-3 col-form-label">Jenis Penetapan
                                        Anggaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kodePenetapanApbd"
                                            class="form-control @error('kodePenetapanApbd') is-invalid @enderror"
                                            value="{{ $tap->Ur_Tap }}" id="kodePenetapanApbd" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomorPenetapanApbd" class="col-sm-3 col-form-label">Nomor Penetapan
                                        Anggaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nomorPenetapanApbd"
                                            class="form-control @error('nomorPenetapanApbd') is-invalid @enderror"
                                            value="{{ $tap->No_Tap }}" id="nomorPenetapanApbd">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggalPenetapanApbd" class="col-sm-3 col-form-label">Tanggal Penetapan
                                        Anggaran</label>
                                    <div class="col-sm-2">
                                        <input type="date" name="tanggalPenetapanApbd"
                                            class="form-control @error('tanggalPenetapanApbd') is-invalid @enderror"
                                            value="{{ $tap->Dt_Tap }}" id="tanggalPenetapanApbd" max="{{ Tahun().'-12-31' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomorDpa" class="col-sm-3 col-form-label">Nomor DPA/RBA</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nomorDpa"
                                            class="form-control @error('nomorDpa') is-invalid @enderror"
                                            value="{{ $tap->No_DPA }}" id="nomorDpa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggalDpa" class="col-sm-3 col-form-label">Tanggal DPA/RBA</label>
                                    <div class="col-sm-2">
                                        <input type="date" name="tanggalDpa"
                                            class="form-control @error('tanggalDpa') is-invalid @enderror"
                                            value="{{ $tap->Dt_DPA }}" id="tanggalDpa" max="{{ Tahun().'-12-31' }}">
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center mt-3">
                                    <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                                        <i class="far fa-save pr-2"></i>Simpan
                                    </button>
                                    <a href="{{ route('penetapan.index') }}" class="col-sm-2 btn btn-danger ml-3">
                                        <i class="fas fa-backward pr-2"></i>Kembali
                                    </a>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script') @endsection