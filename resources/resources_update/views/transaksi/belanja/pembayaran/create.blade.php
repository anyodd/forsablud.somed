@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Realisasi</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('pembayaran.store') }}" method="post" class="form-horizontal">
              @csrf
              @if(session('errors'))
              <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                Something it's wrong:
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
                      <label for="nomorSpd" class="col-sm-2 col-form-label">Nomor Bukti</label>
                      <div class="col-sm-8">
                          <input type="text" id="no_bp"  class="form-control" readonly>
                          <input type="text" name="id_bp" id="id_bp"  class="form-control" hidden>
                      </div>
                      <div class="col-sm-2">
                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#cariTagihan"><i class="fas fa-search"></i> Cari Tagihan</a>
                      </div>
                  </div>  
                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Uraian</label>
                    <div class="col-sm">
                        <textarea class="form-control" name="" id="ur_bp" cols="30" rows="3" readonly></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tanggal Bukti</label>
                    <div class="col-sm-4">
                        <input id="dt_bp" type="text" class="form-control" value="" readonly>
                    </div>
                    <label for="" class="col-sm-1 col-form-label text-right">Total</label>
                    <div class="col-sm-5">
                        <input id="total" type="text" class="form-control" value="" readonly>
                    </div>
                  </div>
                  <hr>
                    <div class="form-group row">
                   <label for="" class="col-sm-2 col-form-label">No. Dokumen Bayar</label>
                   <div class="col-sm">
                       <input type="text" name="No_byr" class="form-control" value="{{ old('No_byr') }}" placeholder="Isiskan Nomor Dokumen Bayar" required>
                   </div>
                   </div>
                   <div class="form-group row">
                   <label for="" class="col-sm-2 col-form-label">Tanggal Dokumen</label>
                   <div class="col-sm">
                       <input type="date" name="dt_byr" class="form-control" value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}" required>
                   </div>
                   </div>
                   <div class="form-group row">
                   <label for="" class="col-sm-2 col-form-label">Uraian</label>
                   <div class="col-sm">
                       <input type="text" name="Ur_byr" class="form-control" value="{{ old('Ur_byr') }}" placeholder="Keterangan Transaksi" required>
                   </div>
                   </div>
                   <div class="form-group row">
                   <label for="" class="col-sm-2 col-form-label">Nama Penyetor</label>
                    <div class="col-sm">
                        {{-- <input type="text" name="Nm_Byr" class="form-control" value="{{ old('Nm_Byr') }}" placeholder="Isikan Nama Penyetor" required> --}}
                        <select class="form-control select2  @error('Nm_Byr') is-invalid @enderror" name="Nm_Byr" id="Nm_Byr">
                          <option value="">--Pilih Nama Penyetor--</option>
                          @foreach ($pegawai as $item)
                              <option value="{{$item->nama}}">{{$item->nama}} ({{$item->jabatan}})</option>
                          @endforeach
                        </select>  
                    </div>
                   </div>
                   <div class="form-group row">
                      <label for="Ko_kas" class="col-sm-2 col-form-label">Cara Pembayaran</label>
                      <div class="col-sm">
                          <select name="ko_kas" class="form-control" required>
                              <option value="">--Pilih Cara Pembayaran--</option>
                              <option value="1">Pindah Buku</option>
                              <option value="2">Tunai Fisik</option>
                          </select>
                      </div>
                  </div>
               </div>
           </div>
              </div>                            
              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('pembayaran.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
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
@include('transaksi.belanja.pembayaran.popup.cari_tagihan')
@endsection