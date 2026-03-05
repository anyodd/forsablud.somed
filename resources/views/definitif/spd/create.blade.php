@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">INPUT SPD</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <form action="{{ route('spd.store') }}" method="post">
                            @csrf
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
                                    <label for="noSpd" class="col-sm-3 col-form-label">Nomor SPD</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="noSpd"
                                            class="form-control @error('noSpd') is-invalid @enderror" id="noSpd"
                                            value="{{ old('noSpd') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggalSpd" class="col-sm-3 col-form-label">Tanggal SPD</label>
                                    <div class="col-sm-2">
                                        <input type="date" name="tanggalSpd" min="{{ $date[0]->min ?? Tahun() . '-01-01' }}"
                                            class="form-control @error('tanggalSpd') is-invalid @enderror"
                                            id="tanggalSpd" value="{{ old('tanggalSpd') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="uraianSpd" class="col-sm-3 col-form-label">Uraian SPD</label>
                                    <div class="col-sm-9">
                                        <textarea name="uraianSpd"
                                            class="form-control @error('uraianSpd') is-invalid @enderror" id="uraianSpd"
                                            rows="3">{{ old('uraianSpd') }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nmPenandatanganSpd" class="col-sm-3 col-form-label">Nm. Penandatangan
                                        SPD</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nmPenandatanganSpd"
                                            class="form-control @error('nmPenandatanganSpd') is-invalid @enderror"
                                            id="nmPenandatanganSpd" value="{{ old('nmPenandatanganSpd') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nipPenandatanganSpd" class="col-sm-3 col-form-label">NIP Penandatangan
                                        SPD</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nipPenandatanganSpd"
                                            class="form-control @error('nipPenandatanganSpd') is-invalid @enderror"
                                            id="nipPenandatanganSpd" value="{{ old('nipPenandatanganSpd') }}">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mt-3">
                                    <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                                        <i class="far fa-save pr-2"></i>Simpan
                                    </button>
                                    <a href="{{ route('spd.index') }}" class="col-sm-2 btn btn-danger ml-3">
                                        <i class="fas fa-backward pr-2"></i>Kembali
                                    </a>
                                </div>
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