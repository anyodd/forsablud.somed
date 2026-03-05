@extends('layouts.template')

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Rincian SPP GU</h5> 
          </div>
          <div class="card-body">
            <div class="card">
              <div class="card-body card-outline-primary">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <label class="col-sm-1 col-form-label">Nomor</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_spi" id="no_spi" value="{{$spi->No_SPi}}" disabled>
                        <input type="text" class="form-control" name="id_spi" id="id_spi" value="{{$spi->id}}" hidden>
                      </div>
                      <label class="col-sm-1 col-form-label text-right">Tanggal</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="" id="" value="{{date_format($spi->Dt_SPi,'d-m-Y')}}" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <label class="col-sm-1 col-form-label">Uraian</label>
                      <div class="col-sm-11">
                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled>{{$spi->Ur_SPi}}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row justify-content-center mb-2">
              @if ($spi->Tag_v == '0')
                <button class="btn btn-primary" id="btn_tambahrinci"><i class="fa fa-plus-square"></i> Tambah</button>
              @else
                <button class="btn btn-primary" onclick="notifikasi()"><i class="fa fa-plus-square"></i> Tambah</button>
              @endif
              <button class="btn btn-danger mx-2" id="btn_hapusrinci"><i class="fa fa-trash"></i> Hapus</button>
              <a href="{{ route('spjgu.bulan',Session::get('bulan')) }}" class="btn btn-info"><i class="fa fa-reply"></i> Kembali</a>
            </div>

            <div class="card">
              <div class="card-body card-outline-primary">
                <div class="table-responsive">
                  <table class="table table-sm table-striped datatable">
                    <thead class="thead-light">
                      <tr>
                        @if ($spi->Tag == '0')
                          <th class="text-center"><input type="checkbox" id="checklist"></th>
                        @else
                          <th class="text-center"><input type="checkbox" disabled></th>
                        @endif
                        <th>No</th>
                        <th>Nomor Tagihan</th>
                        <th class="text-center">Tanggal Tagihan</th>
                        <th>Uraian</th>
                        <th class="text-right">Nilai (Rp)</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@include('pengajuan.spjgu.popup.modal_bukti_spjgu')
@endsection

@section('script')
<script>
  $(function(){
    datatable.draw();
  })

  let id    = document.getElementById('id_spi').value;
  let route = '{{ URL::route('spjgu.rincian',':id') }}';
  let url   = route.replace(':id',id);
  var datatable = $('.datatable').DataTable({
    pageLength  : 25,
    lengthChange: true,
    processing  : true,
    serverSide  : true,
    destroy     : true,
    autoWidth   : false,
    ajax        : url,
    columns: [
      {data: 'check', name: 'check', className: 'text-center', orderable: false},
      {data: 'Ko_spirc', name: 'Ko_spirc'},
      {data: 'No_bp', name: 'No_bp'},
      {data: 'tanggal', name: 'tanggal', className: 'text-center'},
      {data: 'Ur_bprc', name: 'Ur_bprc'},
      {data: 'spirc_Rp', name: 'spirc_Rp', className: 'text-right', render: $.fn.DataTable.render.number('.',',',2)},
      {data: 'action', name: 'action', className: 'text-center', orderable: false}
    ]
  });

  let checklist = $('table tbody .checklist:checked')
  let checkls   = (checklist.length > 0)
  $('#btn_hapusrinci').prop('disabled',!checkls);

  $(document).on('click','#checklist', function () {
    var isChecked = $('#checklist').prop('checked')
    $('.checklist').prop('checked',isChecked);

    if(isChecked > 0) {
      $('#btn_hapusrinci').prop('disabled',false);
    }else{
      $('#btn_hapusrinci').prop('disabled',true);
    }
  });

  $(document).on('click','.checklist', function () {
    let cek = $('table tbody .checklist:checked')

    if(cek.length > 0) {
      $('#btn_hapusrinci').prop('disabled',false);
    }else{
      $('#btn_hapusrinci').prop('disabled',true);
    }
  });

  $('#btn_tambahrinci').click(function (e) { 
    e.preventDefault();
    $('#modal_list').modal('show');
    $('#checkall').prop('checked', false);
    $('.ceklist').prop('checked', false);
    let id    = {{tahun()}};
    let route = '{{ URL::route('spjgu.list_tagihan',':id') }}';
    let url   = route.replace(':id',id);
    var tablelist =
    $('.tablelist').DataTable({
      pageLength  : 25,
      lengthChange: true,
      processing  : true,
      serverSide  : true,
      destroy     : true,
      autoWidth   : false,
      ajax        : url,
      columns: [
        {data: 'no_bp', name: 'no_bp'},
        {data: 'tgl_bp', name: 'tgl_bp', className: 'text-center'},
        {data: 'tgl_jt', name: 'tgl_jt', className: 'text-center'},
        {data: 'ur_bprc', name: 'ur_bprc'},
        {data: 'rekanan', name: 'rekanan'},
        {data: 'to_rp', name: 'to_rp', className: 'text-right', render: $.fn.DataTable.render.number('.',',',2)},
        {data: 'check', name: 'check', className: 'text-center', orderable: false}
      ]
    }).draw();
  });

  $('body').on('click','.delete', function () {
    let id    = $(this).data('id');
    let no_bp = $(this).data('no_bp');
    let route = '{{ URL::route('spjgu.hapusrincianspjgu',':id') }}';
    let url   = route.replace(':id',id);
    
    Swal.fire({
      title: 'Yakin mau hapus rincian LS Tagihan dengan nomor tagihan ' + no_bp +' ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      customClass: {
        confirmButton: 'btn btn-danger me-2 mx-2',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type: 'DELETE',
          url: url,
          data: { "_token": "{{ csrf_token() }}", id:id },
          dataType: 'json',
          success: function(data){
            $('#checklist').prop('checked', false);
            $('.checklist').prop('checked', false);
            datatable.draw();
            Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')
          },
          error: function (data) {
            Swal.fire('Info', 'Tidak diketahui', 'warning')
          }
        });
      }
    });
  });

  $(document).on('click','#btn_hapusrinci', function () {
    $('#checklist').prop('checked', false);
    let dt   = $('.checklist:checked')
    let data = []
    $.each(dt, function (index, elm) { 
      data.push(elm.value)
    });

    Swal.fire({
      title: 'Yakin hapus data yang dipilih ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      customClass: {
        confirmButton: 'btn btn-danger me-2 mx-2',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type : 'POST',
          url  : '{{route('spjgu.hapusrincian')}}',
          data : { '_token' : '{{ csrf_token() }}', data },
          dataType: 'json',
          success: function(data){
            datatable.draw();
            Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')
          },
          error: function (data) {
            Swal.fire('Info', 'Tidak diketahui', 'warning')
          }
        });
      }
    });
  });

  let ceklist = $('table tbody .ceklist:checked')
  let cekls   = (ceklist.length > 0)
  $('#submit').prop('disabled',!cekls);

  $(document).on('click','#checkall', function () {
    var isChecked = $('#checkall').prop('checked')
    $('.ceklist').prop('checked',isChecked);

    if(isChecked > 0) {
      $('#submit').prop('disabled',false);
    }else{
      $('#submit').prop('disabled',true);
    }
  });

  $(document).on('click','.ceklist', function () {
    let cek = $('table tbody .ceklist:checked')

    if(cek.length > 0) {
      $('#submit').prop('disabled',false);
    }else{
      $('#submit').prop('disabled',true);
    }
  });

  $(document).on('click','#submit', function () {
    let dt   = $('.ceklist:checked')
    let data = []
    $.each(dt, function (index, elm) { 
      data.push(elm.value)
    });
    
    $.ajax({
      type : 'POST',
      url  : '{{route('spjgu.tambahrincian')}}',
      data : { '_token' : '{{ csrf_token() }}', data, 'id_spi': $('#id_spi').val(), 'no_spi': $('#no_spi').val() },
      dataType: 'json',
      success: function (response) {
        datatable.draw();
        Swal.fire('Berhasil', 'Data berhasil ditambahkan', 'success')
      }
    });
  });

  function notifikasi() {
    Swal.fire('', 'Data telah diverifikasi, tidak dapat dilakukan perubahan data', 'warning')
  }
</script>
@endsection