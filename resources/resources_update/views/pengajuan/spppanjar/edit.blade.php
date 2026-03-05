@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">UBAH DATA SPP PANJAR</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <form action="{{ route('spppanjar.update', $spppanjar->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Kode Unit</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="KodeUnit" class="form-control" id=""
                                                    value="{{kd_unit()}}" readonly>
                                                @error('kodeUnit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Nomor Bukti</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="No_SPi"
                                                    class="form-control @error('No_SPi') is-invalid @enderror"
                                                    value="{{ old('No_SPi', $spppanjar->No_SPi) }}"
                                                    placeholder="Nomor Bukti">
                                                @error('No_SPi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Tanggal Bukti</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                <input type="date" name="Dt_SPi"
                                                    class="form-control @error('Dt_SPi') is-invalid @enderror"
                                                    value="{{ old('Dt_SPi', $spppanjar->Dt_SPi->format('Y-m-d')) }}"
                                                    placeholder="Tanggal Bukti">
                                                @error('Dt_SPi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Uraian</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="Ur_SPi"
                                                    class="form-control @error('Ur_SPi') is-invalid @enderror"
                                                    value="{{ old('Ur_SPi', $spppanjar->Ur_SPi) }}"
                                                    placeholder="Uraian">
                                                @error('Ur_SPi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Nama Pengusul</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                {{-- <input type="text" name="Nm_PP"
                                                    class="form-control @error('Nm_PP') is-invalid @enderror"
                                                    value="{{ old('Nm_PP', $spppanjar->Nm_PP) }}"
                                                    placeholder="Nama Pengusul"> --}}
                                                <select class="form-control select2 @error('Nm_PP') is-invalid @enderror" name="Nm_PP" id="Nm_PP">
                                                    @foreach ($pegawai as $item)
                                                        @if ($item->nama != $spppanjar->Nm_PP)
                                                            @if ($loop->first)
                                                            <option value="{{$spppanjar->Nm_PP}}|{{$spppanjar->NIP_PP}}">{{$spppanjar->Nm_PP}}</option>
                                                            @endif
                                                        @endif
                                                        <option value="{{$item->nama}}|{{$item->nip}}" {{$item->nama == $spppanjar->Nm_PP ? 'selected' : ''}}>{{$item->nama}} ({{$item->jabatan}})</option>
                                                    @endforeach
                                                </select>
                                                @error('Nm_PP')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <label for="" class="col-sm-2 col-form-label">NIP Pengusul</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm">
                                                <input type="text" name="NIP_PP" id="NIP_PP"
                                                    class="form-control @error('NIP_PP') is-invalid @enderror"
                                                    value="{{ old('NIP_PP', $spppanjar->NIP_PP) }}"
                                                    placeholder="NIP Pengusul" readonly>
                                                @error('NIP_PP')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Nama Bendahara</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                {{-- <input type="text" name="Nm_Ben"
                                                    class="form-control @error('Nm_Ben') is-invalid @enderror"
                                                    value="{{ old('Nm_Ben', $spppanjar->Nm_Ben) }}"
                                                    placeholder="Nama Bendahara"> --}}
                                                <select class="form-control select2 @error('Nm_Ben') is-invalid @enderror" name="Nm_Ben" id="Nm_Ben">
                                                    @foreach ($pegawai as $item)
                                                        @if ($item->nama != $spppanjar->Nm_Ben)
                                                            @if ($loop->first)
                                                            <option value="{{$spppanjar->Nm_Ben}}|{{$spppanjar->NIP_Ben}}">{{$spppanjar->Nm_Ben}}</option>
                                                            @endif
                                                        @endif
                                                        <option value="{{$item->nama}}|{{$item->nip}}" {{$item->nama == $spppanjar->Nm_Ben ? 'selected' : ''}}>{{$item->nama}} ({{$item->jabatan}})</option>
                                                    @endforeach
                                                </select>
                                                @error('Nm_Ben')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <label for="" class="col-sm-2 col-form-label">NIP Bendahara</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm">
                                                <input type="text" name="NIP_Ben" id="NIP_Ben"
                                                    class="form-control @error('NIP_Ben') is-invalid @enderror"
                                                    value="{{ old('NIP_Ben', $spppanjar->NIP_Ben) }}"
                                                    placeholder="NIP Bendahara" readonly>
                                                @error('NIP_Ben')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Nama PPK</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                {{-- <input type="text" name="Nm_Keu"
                                                    class="form-control @error('Nm_Keu') is-invalid @enderror"
                                                    value="{{ old('Nm_Keu', $spppanjar->Nm_Keu) }}"
                                                    placeholder="Nama PPK"> --}}
                                                <select class="form-control select2 @error('Nm_Keu') is-invalid @enderror" name="Nm_Keu" id="Nm_Keu">
                                                    @foreach ($pegawai as $item)
                                                        @if ($item->nama != $spppanjar->Nm_Keu)
                                                            @if ($loop->first)
                                                            <option value="{{$spppanjar->Nm_Keu}}|{{$spppanjar->NIP_Keu}}">{{$spppanjar->Nm_Keu}}</option>
                                                            @endif
                                                        @endif
                                                        <option value="{{$item->nama}}|{{$item->nip}}" {{$item->nama == $spppanjar->Nm_Keu ? 'selected' : ''}}>{{$item->nama}} ({{$item->jabatan}})</option>
                                                    @endforeach
                                                </select>
                                                @error('Nm_Keu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <label for="" class="col-sm-2 col-form-label">NIP PPK</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm">
                                                <input type="text" name="NIP_Keu" id="NIP_Keu"
                                                    class="form-control @error('NIP_Keu') is-invalid @enderror"
                                                    value="{{ old('NIP_Keu', $spppanjar->NIP_Keu) }}"
                                                    placeholder="NIP PPK" readonly>
                                                @error('NIP_Keu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="text" name="created_at" class="form-control"
                                                value="{{ old('created_at', $spppanjar->created_at) }}" hidden readonly>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Bank Yang Membayar</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                                <select name="Ko_Bank" class="form-control select2">
                                                  <option value="" selected>-- Pilih Bank Yang Membayar --</option>
                                                  @foreach ($ko_bank as $item)
                                                      <option value="{{ $item->Ko_Bank }}" {{$spppanjar->Ko_Bank == $item->Ko_Bank ? 'selected':'' }}>{{ $item->No_Rek }} - {{ $item->Ur_Bank }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Bank Tujuan</label>
                                            <label for="" class="col-form-label">:</label>
                                            <div class="col-sm-5">
                                              <select name="rekan_bank" class="form-control select2">
                                                <option value="" selected>-- Pilih Bank Tujuan --</option>
                                                @foreach ($bank_rekan as $item)
                                                    <option value="{{ $item->rekan_rekbank }}||{{$item->rekan_nmbank}}" {{$spppanjar->trm_rek == $item->rekan_rekbank ? 'selected' : ''}}>{{ $item->rekan_nm }} ( {{ $item->rekan_rekbank }} - {{ $item->rekan_nmbank }} )</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center mt-3">
                                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                                    <i class="far fa-save pr-2"></i>Simpan
                                </button>
                                <a href="{{ route('spppanjar.index') }}" class="col-sm-2 btn btn-danger ml-3">
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

@section('script')
<script>
  $(document).on('change','#Nm_PP', function () {
      var data = document.getElementById("Nm_PP").value;
      var nip = data.split("|");
      $('#NIP_PP').val(nip[1]);
  });

  $(document).on('change','#Nm_Ben', function () {
      var data = document.getElementById("Nm_Ben").value;
      var nip = data.split("|");
      $('#NIP_Ben').val(nip[1]);
  });

  $(document).on('change','#Nm_Keu', function () {
      var data = document.getElementById("Nm_Keu").value;
      var nip = data.split("|");
      $('#NIP_Keu').val(nip[1]);
  });
</script>
@endsection