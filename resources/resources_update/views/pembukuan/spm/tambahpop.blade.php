@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Realisasi Pembayaran</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('spm.store') }}" method="post" class="form-horizontal">
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
                      <label for="nomorSpd" class="col-sm-2 col-form-label">Nomor Otorisasi</label>
                      <div class="col-sm-4">
                          <input type="text" name="No_oto" class="form-control" id="No_oto" value="{{ $dt_oto->No_oto }}" readonly>
                      </div>
                    <label for="nomorSpd" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $dt_oto->Dt_oto }}" readonly>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                      <label for="Ur_bprc" class="col-sm-2 col-form-label">Nomor Bukti Bayar</label>
                      <div class="col-sm-4">
                          <input type="text" name="No_npd" class="form-control" value="{{old('No_npd')}}" id="No_npd" placeholder="Nomor Bukti Bayar" required>
                      </div> 
                      <label for="rftr_bprc" class="col-sm-2 col-form-label">Tanggal Bayar</label>
                      <div class="col-sm-4">
                          <input type="date" name="Dt_npd" class="form-control" value="{{old('Dt_npd')}}" id="Dt_npd" required>
                      </div> 
                  </div>
                  <div class="form-group row">
                      <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Uraian</label>
                      <div class="col-sm-10">
                          <input type="text" name="Ur_npd" class="form-control" value="{{old('Ur_npd')}}" id="Ur_npd" placeholder="untuk pembayaran.." required>
                      </div> 
                  </div>
                  <div class="form-group row">
                    <label for="To_Rp" class="col-sm-2 col-form-label">Bank yang membayar</label>
                    <div class="col-sm-4">
                      <select name="Ko_Bank" class="form-control @error('Ko_Bank') is-invalid @enderror"  id="Ko_Bank" required>
                          <option value="" selected disabled>-- pilih Bank --</option>
                          @foreach($bank as $number => $bank)
                          <option value="{{ $bank->Ko_Bank }}">{{ $bank->Ko_Bank }} - {{ $bank->Ur_Bank }}</option>
                          @endforeach
                      </select>
                    </div>
                    <label for="Ur_bprc" class="col-sm-2 col-form-label">Yang membayar</label>
                    <div class="col-sm-4">
                        <input type="text" name="Nm_Byro" class="form-control" value="{{old('Nm_Byro')}}" id="Nm_Byro" placeholder="Yang membayar" required>
                    </div> 
                </div>
                  <div class="form-group row">
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Bank Tujuan</label>
                    <div class="col-sm-4">
                        <input type="text" name="Nm_Bank" class="form-control" id="Nm_Bank" value="{{old('Nm_Bank')}}" placeholder="Nama Bank Tujuan" required>
                    </div>
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">No. Rekening Bank Tujuan</label>
                    <div class="col-sm-4">
                        <input type="text" name="No_Rektuju" class="form-control" id="No_Rektuju" value="{{old('No_Rektuju')}}" placeholder="Nomor Rek. Bank Tujuan" required>
                    </div> 
                  </div>
                  <div class="form-group row">
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama Pengusul/PPTK</label>
                    <div class="col-sm-4">
                        <input type="text" name="Nm_PP" class="form-control" id="Nm_PP" value="{{old('Nm_PP')}}" placeholder="Nama Pengusul/PPTK" required>
                    </div>
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP Pengusul/PPTK</label>
                    <div class="col-sm-4">
                        <input type="text" name="NIP_PP" class="form-control" id="NIP_PP" value="{{old('NIP_PP')}}" placeholder="PPK Pengusul/PPTK" required>
                    </div> 
                  </div>
                  <div class="form-group row">
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama Bendahara</label>
                    <div class="col-sm-4">
                        <input type="text" name="Nm_Ben" class="form-control" id="Nm_Ben" value="{{old('Nm_Ben')}}" placeholder="Nama Bendahara" required>
                    </div>
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP Bendahara</label>
                    <div class="col-sm-4">
                        <input type="text" name="NIP_Ben" class="form-control" id="NIP_Ben" value="{{old('NIP_Ben')}}" placeholder="NIP Bendahara" required>
                    </div> 
                  </div>
                  <div class="form-group row">
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama PPK</label>
                    <div class="col-sm-4">
                        <input type="text" name="Nm_Keu" class="form-control" id="Nm_Keu" value="{{old('Nm_Keu')}}" placeholder="Nama PPK" required>
                    </div>
                    <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP PPK</label>
                    <div class="col-sm-4">
                        <input type="text" name="NIP_Keu" class="form-control" id="NIP_Keu" value="{{old('NIP_Keu')}}" placeholder="NIP PPK" required>
                    </div> 
                  </div>
                  <hr>
                  <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group input-group-sm-1">
                            <input type="text" class="form-control" placeholder="">
                            <span class="input-group-append">
                            <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#rincian" data-backdrop="static">Cari Rincian Transaksi</button>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="tb_add" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nomor Pengajuan</th>
                            <th class="text-center" style="width: 3%">Tanggal Pengajuan</th>
                            <th class="text-center">Nomor Bukti</th>
                            <th class="text-center">Uraian</th>
                            <th class="text-center">Jumlah</th>
                            {{-- <th class="text-center">#</th> --}}
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <div class="form-group row justify-content-center mt-3">
                    <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                    </button>
                    <a href="javascript:history.back()" class="col-sm-2 btn btn-danger ml-3">
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
@include('pembukuan.spm.popup.rincian')
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#tb_add').DataTable();
        $('#dtrincian').DataTable();
    });

    $(document).on('click','#checkall', function () {
        var isChecked = $('#checkall').prop('checked')
        $('.check').prop('checked',isChecked);
    });

    function getData() {
        let id_spi = $('#id_spi').val()
        let dt = $('.check:checked')
        let data = []
        $.each(dt, function (index, elm) { 
             data.push(elm.value)
        });

        $.ajax({
            type: "post",
            url: "{{ route('spm_getData') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id'  : id_spi, 
                'dt' : data
            },
            success: function (data) {
                console.log(data);
                $("#tb_add").DataTable({
                    "paging": false,
                    "searching": false,
                    "bInfo": false,
                    "bDestroy": true,
                    "data": data,
                    "columns": [{
                            "data": null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings
                                    ._iDisplayStart + 1;
                            }
                        },
                        {
                            "data": "No_SPi"
                        },
                        {
                            "data": "Dt_SPi"
                        },
                        {
                            "data": "No_bp"
                        },
                        {
                            "data": "Ur_bprc"
                        },
                        {
                            "data": "spirc_Rp"
                        },
                        // {
                        //     "data": null,
                        //     "bSortable": false,
                        //     "mRender": function (o) { return '<a href=#/' + o.userid + '><i class="fas fa-trash text-danger"></i></a>'; }
                        // }
                    ],
                    "columnDefs": [ 
                        {
                        "targets": 0,
                        "className": "text-center"
                        },
                        {
                        "targets": 2,
                        "className": "text-center"
                        },
                        {
                        "targets": 5,
                        "className": "text-right",
                        "render": $.fn.dataTable.render.number('.', ',', 2, '')
                        }
                    ],
                });
            }
        });
    }

    function cancel() {
        $('#checkall').prop('checked',false);
        $('.check').prop('checked',false);
    }
</script>
@endsection
