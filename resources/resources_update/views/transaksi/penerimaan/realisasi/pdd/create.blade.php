@extends('layouts.template')
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Realisasi Diterima Dimuka</h5> 
          </div>

          <div class="card-body px-2 py-2">
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
                  <div class="col-sm">
                    <input type="text" name="NoBp" id="no_bp" class="form-control" value="{{old('No_bp', $data->No_bp)}}" readonly>
                    <input type="text" name="KoUnitStr" id="ko_unitstr" class="form-control" value="{{old('Ko_unit1', $data->Ko_unit1)}}" readonly hidden>
                    <input type="text" name="IdBp" id="id_bp" class="form-control" value="{{old('id_bp', $data->id_bp)}}" readonly hidden>
                    <input type="text" name="KoPeriod" id="ko_period" class="form-control" value="{{old('Ko_Period', $data->Ko_Period)}}" readonly hidden>
                  </div>
                </div>  
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Total Nilai Piutang</label>
                  <div class="col-sm">
                      <input id="ToRp" type="text" name="ToRp" class="form-control" value="{{ number_format($data2[0]->Total,0,',','.') }}" readonly>
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Dokumen Setor</label>
                  <div class="col-sm">
                      <input type="text" id="no_byr" name="NoByr" class="form-control @error('NoByr') is-invalid @enderror" value="{{ old('NoByr') }}" placeholder="Isikan Nomor Dokumen Bayar">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Dokumen</label>
                  <div class="col-sm-2">
                      <input type="date" id="tgl_byr" name="DtByr" class="form-control" value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                      <input type="text" id="uraian_byr" name="UrByr" class="form-control @error('UrByr') is-invalid @enderror" value="{{ old('UrByr') }}" placeholder="Keterangan Transaksi">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Penyetor</label>
                  <div class="col-sm">
                      {{-- <input id="nama_byr" type="text" name="NmByr" class="form-control @error('NmByr') is-invalid @enderror" value="{{ old('NmByr') }}" placeholder="Isikan Nama Penyetor"> --}}
                    <select class="form-control select2  @error('NmByr') is-invalid @enderror" name="NmByr" id="nama_byr">
                      <option value="">--Pilih Nama Penyetor--</option>
                      @foreach ($pegawai as $item)
                          <option value="{{$item->nama}}">{{$item->nama}} ({{$item->jabatan}})</option>
                      @endforeach
                    </select>  
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Ko_kas" class="col-sm-2 col-form-label">Cara Penyetoran</label>
                  <div class="col-sm">
                      <select id="ko_kas" name="KoKas" class="form-control select2 select2-danger @error('Ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;" autofocus>
                        <option value="0">--Pilih Cara Penyetoran--</option>
                        <option value="1">Pindah Buku</option>
                        <option value="2">Tunai Fisik</option>
                      </select>
                      @error('Ko_kas')
                        <div class="invalid-feedback"> {{ $message}}</div>
                      @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Ko_kas" class="col-sm-2 col-form-label">Pilih Bank</label>
                  <div class="col-sm">
                    <select name="ko_bank" class="form-control" id="ko_bank" disabled>
                      <option value="0" selected>--Pilih Bank--</option>
                      @foreach ($bank as $list)
                        <option value="{{$list->Ko_Bank}}">{{$list->Ur_Bank}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!--table-->
                <div class="form-group row">
                  <div class="col-sm-11">
                    <a href="#" class="btn btn-sm btn-warning" id="piutang" onclick="piutang()">
                      <i class="fas fa-search"></i> Piutang
                    </a>
                  </div>
                  <div class="col-sm-1">
                    <a href="{{route('realisasipdd.bulan',Session::get('bulan'))}}" class="btn btn-sm btn-info" id="kembali">
                      <i class="fas fa-arrow-alt-circle-left"></i> Kembali
                    </a>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0" id="tblbayar" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center" style="vertical-align: middle;">No.</th>
                          <th class="text-center" style="vertical-align: middle;">No Bayar</th>
                          <th class="text-center" style="vertical-align: middle;">Tanggal Bayar</th>
                          <th class="text-center" style="vertical-align: middle;">Uraian</th>
                          <th class="text-center" style="vertical-align: middle;">No Bukti</th>
                          <th class="text-center" style="vertical-align: middle;">Nama Penyetor</th>
                          <th class="text-center" style="vertical-align: middle;">Jumlah Bayar</th>
                          <th class="text-center" style="vertical-align: middle;"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($bayar as $item)
                          <tr>
                            <td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}.</td>
                            <td class="text-center" style="vertical-align: middle;">{{$item->No_byr}}</td>
                            <td class="text-center" style="vertical-align: middle;">{{$item->dt_byr}}</td>
                            <td style="vertical-align: middle;">{{$item->Ur_byr}}</td>
                            <td class="text-center" style="vertical-align: middle;">{{$item->No_bp}}</td>
                            <td style="vertical-align: middle;">{{$item->Nm_Byr}}</td>
                            <td class="text-right" style="vertical-align: middle;">{{number_format($item->real_rp,0,'','.')}}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$item->id_byr}}" title="hapus"><i class="fas fa-trash-alt"></i></button>
                            </td>
                          </tr>
                          <div class="modal fade" id="delete{{$item->id_byr}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <h6>Yakin mau hapus data ?</h6>
                                </div>
                                <div class="modal-footer">
                                  <form action="{{ route('realisasipdd.destroy', $item->id_byr) }}" method="post" class="">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger " name="submit" title="Hapus">Ya, Hapus
                                    </button>
                                  </form>
                                  <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--table-->
              </div>
           </div>
              </div>   
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  
@include('transaksi.penerimaan.realisasi.pdd.popup.list_piutang')

@endsection




@section('script') 
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function () {
    document.getElementById('no_byr').value = localStorage.getItem('nobyr');
    document.getElementById('tgl_byr').value = localStorage.getItem('dtbyr');
    document.getElementById('nama_byr').value = localStorage.getItem('nmbyr');
    document.getElementById('uraian_byr').value = localStorage.getItem('urbyr');
    document.getElementById('ko_kas').value = localStorage.getItem('kasbyr');
  });

  function deleteItems() {
    localStorage.clear();
  }

  $(document).on('click','#bayar', function () {
    var row   = $(this).closest('tr');
    var id_bp = $('#id_bp').val();
    var ref   = $(this).data('ref');
    var rp    = document.getElementById('textBox'+ref).value
    var data  = {
      'id_bprc'    : row.find('td:nth-child(11)').text(),
      'Ko_Period'  : document.getElementById('ko_period').value,
      'Ko_unitstr' : document.getElementById('ko_unitstr').value,
      'No_byr'     : document.getElementById('no_byr').value,
      'dt_byr'     : document.getElementById('tgl_byr').value,
      'Ur_byr'     : document.getElementById('uraian_byr').value,
      'No_bp'      : row.find('td:nth-child(2)').text(),
      'Ko_bprc'    : row.find('td:nth-child(1)').text(),
      'real_rp'    : rp,
      'ko_kas'     : document.getElementById('ko_kas').value,
      'Ko_Bank'    : document.getElementById('ko_bank').value,
      'Nm_Byr'     : document.getElementById('nama_byr').value
    }

    if (rp == '') {
      alert('Jumlah Bayar Tidak Boleh Kosong')
    } else {
      $.ajax({
        url: "{{ route('realisasipdd.store_rinci') }}",
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function (response) {
          if(response.statusCode==200){
            window.location = "{{ route('realisasi.tambah','') }}"+"/"+id_bp;	
            $('#no_byr').val(document.getElementById('no_byr').value);
          }
        },
        error: function(xhr){
          console.log(xhr.responseText);
        }
      });
    }
  });

  $(document).on('change','#ko_kas',function(){
    var vl = $('#ko_kas').val();
    if (vl == 1) {
      $('#ko_bank').removeAttr('disabled');
    } else {
      $('#ko_bank').attr('disabled', true);
      $('#ko_bank').val('0');
    }
  });

  function piutang(){
    var no     = document.getElementById('no_byr').value;
    var tgl    = document.getElementById('tgl_byr').value;
    var nama   = document.getElementById('nama_byr').value;
    var uraian = document.getElementById('uraian_byr').value;
    var kas    = document.getElementById('ko_kas').value;
    if (kas == 0) { kas = ''; }
    var data = [no,tgl,nama,uraian,kas];
    if (data.includes('') == true) {
      alert('Isian Pembayaran Tidak boleh kosong')
    } else {
      $("#realisasi").modal();
    } 
    localStorage.setItem('nobyr',no);
    localStorage.setItem('dtbyr',tgl);
    localStorage.setItem('nmbyr',nama);
    localStorage.setItem('urbyr',uraian);
    localStorage.setItem('kasbyr',kas);
  }

  $(document).on('click','#kembali', function () {
    deleteItems();
  });

  function myCheck(txt){
    if(txt){
      $(txt).removeAttr('disabled');
    }else{
      $(txt).attr('disabled', true);
      $(txt).val('');
    }
  }

  function myInput(txt, rp){
      var value = $(txt).val(),
      max = rp,
      min = 0;
      if (value != "" && value > max || value < min) {
        alert(`Tidak boleh lebih/kurang dari sisa piutang`);
        $(txt).val(rp);
      }
  }

  $(document).ready(function() {
    $('#tblbayar').DataTable();
  });

 
</script>
@endsection