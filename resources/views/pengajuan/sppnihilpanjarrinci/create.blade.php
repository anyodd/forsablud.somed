@extends('layouts.template')

@section('content')

@include('pengajuan.sppnihilpanjarrinci.popup.modal_bukti_sppnihilpanjar')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">Tambah Rincian Data SPP Nihil Panjar - Nomor Bukti : {{
                            $sppnihilpanjar->No_SPi }}</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <form action="{{ route('sppnihilpanjar-rinci.store') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Unit Kerja</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <input type="text" name=""
                                                        class="form-control @error('Ko_unitstr') is-invalid @enderror"
                                                        value="{{ old('Ko_unitstr', $sppnihilpanjar->Ko_unitstr) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Nomor Pengajuan</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <input type="text" name="No_spi"
                                                        class="form-control @error('No_SPi') is-invalid @enderror"
                                                        value="{{ old('No_SPi', $sppnihilpanjar->No_SPi) }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body card-info card-outline">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">No. Rincian</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="Ko_spirc"
                                                        class="form-control @error('Ko_spirc') is-invalid @enderror"
                                                        value="{{ $max + 1 }}" placeholder="No. Rincian" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Bukti yg diajukan</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#modalBuktiSppPanjar">...</button>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Program - Kegiatan</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <input type="text" name="Ko_sKeg1"
                                                        class="form-control @error('Ko_sKeg1') is-invalid @enderror"
                                                        id="sKo_sKeg1" value="{{ old('Ko_sKeg1') }}"
                                                        placeholder="Program" readonly>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="text" name="Ko_sKeg2"
                                                        class="form-control @error('Ko_sKeg2') is-invalid @enderror"
                                                        id="sKo_sKeg2" value="{{ old('Ko_sKeg2') }}"
                                                        placeholder="Kegiatan" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Kode Akun</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <input type="text" name="Ko_Rkk"
                                                        class="form-control @error('Ko_Rkk') is-invalid @enderror"
                                                        id="sKo_Rkk" value="{{ old('Ko_Rkk') }}" placeholder="Kode Akun"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                                <label for="" class="col-form-label">:</label>
                                                <div class="col-sm">
                                                    <input type="text" name="spirc_Rp"
                                                        class="form-control @error('spirc_Rp') is-invalid @enderror"
                                                        id="sspirc_Rp" value="{{ old('spirc_Rp') }}"
                                                        placeholder="Nilai (Rp)" readonly>
                                                </div>
                                            </div>
                                            <input type="text" name="pd" class="form-control" id="sPD"
                                                value="{{ old('pd') }}" hidden readonly>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-footer-->
                                <div class="form-group row justify-content-center mt-3">
                                    <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                                        <i class="far fa-save pr-2"></i>Simpan
                                    </button>
                                    <a href="{{ route('sppnihilpanjar-rinci.pilih', $sppnihilpanjar->id) }}"
                                        class="col-sm-2 btn btn-danger ml-3">
                                        <i class="fas fa-backward pr-2"></i>Kembali
                                    </a>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

@endsection