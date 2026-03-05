@extends('layouts.template')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg">
          <div class="card-header bg-info">
            <h5 class="card-title font-weight-bold">Daftar Pengesahan SP3B</h5>  
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTambahSp3b">
					 <i class="fas fa-plus-circle pr-1"></i>
					  Tambah SP3B
                </button>
              </div>
              @include('pengesahan.popup.modal_sp3b_tambah')
            </div>
            <br>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 3%">No.</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Pengesahan</th>
                    <th class="text-center" style="vertical-align: middle; width: 5%">Tanggal Pengesahan</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle; width: 5%">Bulan SP3B</th>
                    <th class="text-center" style="vertical-align: middle; width: 18%">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  @if($sp3b->count() > 0)
                  @foreach ($sp3b as $number => $sp3b)

                  <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>                      
                    <td>{{$sp3b ->No_sp3}}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($sp3b->Dt_sp3)) }}</td>                      
                    <td>{{$sp3b ->Ur_sp3}}</td>                                  
                    <td class="text-center">{{nmbulan($sp3b->bln_sp3)}}</td>                                  
                    <td>
                      <div class="row justify-content-center" >
                        <div class="row">
							<a href="{{ route('sp3b_pdf', $sp3b->id_sp3) }}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
								<i class="fa fa-print"></i>
							</a>
							<button type="button" class="btn btn-sm btn-success btnrinci file-alt  mx-1"
							  data-id_sp3b    = "{{$sp3b->id_sp3}}"
							  data-no_sp3b    = "{{$sp3b->No_sp3}}"
							  data-dt_sp3b    = "{{$sp3b->Dt_sp3}}"
							  data-ur_sp3b    = "{{$sp3b->Ur_sp3}}"
							  data-kuasa_sp3b = "{{$sp3b->Nm_Kuasa}}"
							  data-nip_sp3b   = "{{$sp3b->NIP_Kuasa}}"
							  onclick="myModal({{ $sp3b->id_sp3 }})" title="Tambah Rincian SP3B">
							  <i class="fas fa-plus-circle"></i>
							</button>
							<a href="{{ route('sp3b_detail', $sp3b->id_sp3) }}" class="btn btn-sm btn-info file-alt  mx-1" title="Detail SP3B">
							  <i class="fas fa-list"></i>
							</a>
							<button class="btn btn-sm btn-danger file-alt mx-1" title="Pajak SP3B" data-toggle="modal" data-target="#modalPajak{{ $sp3b->id_sp3 }}">
								<i class="fas fa-money-check"></i>
							</button>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-warning dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false">
								 <i class="fas fa-bell"></i>
								</button>
								<div class="dropdown-menu" style="">
								  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalEditSp3b{{ $sp3b->id_sp3 }}" title="Edit">
									<i class="far fa-edit"></i> Edit
								  </button>
                              @if($sp3b->id_sp3rc == NULL)
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalHapus{{$sp3b->id_sp3}}" title="Hapus"><i class="far fa-trash-alt"></i> Hapus</button>
                              @else
                                <button type="button" class="dropdown-item" disabled=""><i class="far fa-trash-alt"></i> Hapus</button>
                              @endif
                            </div>
                          </div>
                          @include('pengesahan.popup.modal_sp3b_edit')
                          @include('pengesahan.popup.modal_sp3b_hapus')

                          <div class="modal fade" id="modalPajak{{ $sp3b->id_sp3 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Pajak SP3B :</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row justify-content-center">
                                    <form action="{{ route('sp3b_pajak',$sp3b->id_sp3) }}" method="get">
                                      @csrf
                                      <button type="submit" class="btn btn btn-warning mr-3" name="submit" title="Pajak SP3B">
                                        <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pembiayaan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1"> SP3B Pajak
                                      </button>
                                    </form>
                                    <form action="{{ route('sp3b_bbpajak',$sp3b->id_sp3) }}" method="get">
                                      @csrf
                                      <button type="submit" class="btn btn btn-primary mr-3" name="submit" title="Buku Bantu Pajak">
                                        <img src="{{ asset('template') }}/dist/img/icon_menu/transaksi/pembiayaan.png"
                                        alt="Product 1" class="nav-icon img-circle img-size-32 mr-1"> Buku Bantu Pajak
                                      </button>
                                    </form>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td>Tidak Ada Data</td>
                  </tr>
                  @endif
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('pengesahan.popup.modal_sp3b_rinci')
  @include('pengesahan.popup.modal_sp3b_rinci_tambah')
</section>  

@endsection

@section('script')

<script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('template') }}/plugins/moment/moment.min.js"></script>

<script>
  $(document).ready(function() {
    $('#example').DataTable( {
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal( {
            header: function ( row ) {
              var data = row.data();
              return 'Details for '+data[0]+' '+data[1];
            }
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
            tableClass: 'table'
          })
        }
      }
    });
  });

  $(document).on('change','#Nm_Kuasa', function () {
      var data = document.getElementById("Nm_Kuasa").value;
      var nip = data.split("|");
      $('#NIP_Kuasa').val(nip[1]);
  });

  $(document).on('change','#EditNm_Kuasa', function () {
      var data = document.getElementById("EditNm_Kuasa").value;
      var nip = data.split("|");
      $('#EditNIP_Kuasa').val(nip['1']);
  });

  function myModal(id) {
    $('#modalSp3bRinci').modal('show');
    let route = '{{ URL::route('sp3b_rinci',':id') }}'; 
    let url   = route.replace(':id',id);
    $('#tbl_sp3b_rinci').DataTable({
      lengthChange: true,
      processing: true,
      serverSide: true,
      destroy: true,
      autoWidth: false,
      ajax: url,
      columns: [
        {data: 'check', name: 'check', className: 'text-center', orderable: false},
        {data: 'Ko_sp3', name: 'Ko_sp3', width: '5%', className: 'text-center'},
        {data: 'No_oto', name: 'No_oto'},
        {data: 'tanggal', name: 'tanggal', width: '10%', className: 'text-center'},
        {data: 'sp3rc_Rp', name: 'sp3rc_Rp', className: 'text-right',width: '5%', render: $.fn.DataTable.render.number('.',',',2)},
        {data: 'action', name: 'action', className: 'text-center'}
      ]
    });
  }

  $('body').on('click','.btnrinci', function () {
    $('#frm_no').val($(this).data('no_sp3b'));
    $('#frm_tgl').val($(this).data('dt_sp3b'));
    $('#frm_uraian').val($(this).data('ur_sp3b'));
    $('#frm_kuasa').val($(this).data('kuasa_sp3b'));
    $('#frm_nip').val($(this).data('nip_sp3b'));
    $('#btn_tambahrinci').data('No_SP3',$(this).data('no_sp3b'));
    $('#btn_tambahrinci').data('Id_SP3',$(this).data('id_sp3b'));
    $('#btn_hapusrinci').data('Id_SP3',$(this).data('id_sp3b'));
    $('#checklist').prop('checked', false);
    $('#btn_hapusrinci').prop('disabled',true);
  });

  $('body').on('click','.delete', function () {
    let id    = $(this).data('id');
    let route = '{{ URL::route('sp3b_rinci_destroy',':id') }}';
    let url   = route.replace(':id',id);

    let id_sp3 = $(this).data('id_sp3');
    let list   = '{{ URL::route('sp3b_rinci',':id_sp3') }}';
    let sp3brc = list.replace(':id',id_sp3);
    Swal.fire({
      title: 'Yakin data dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus data',
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
          data: {
            "_token": "{{ csrf_token() }}",
            id:id
          },
          dataType: 'json',
          success: function(data){
            $('#tbl_sp3b_rinci').DataTable({
              lengthChange: true,
              processing: true,
              serverSide: true,
              destroy: true,
              autoWidth: false,
              ajax: sp3brc,
              columns: [
                {data: 'check', name: 'check', className: 'text-center', orderable: false},
                {data: 'Ko_sp3', name: 'Ko_sp3', width: '5%', className: 'text-center'},
                {data: 'No_oto', name: 'No_oto'},
                {data: 'Dt_oto', name: 'Dt_oto', width: '10%', className: 'text-center'},
                {data: 'sp3rc_Rp', name: 'sp3rc_Rp', className: 'text-right',width: '5%', render: $.fn.DataTable.render.number('.',',',2)},
                {data: 'action', name: 'action', className: 'text-center'}
              ]
            }).draw();
            Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')
          },
          error: function (data) {
            Swal.fire('Info', 'Tidak diketahui', 'warning')
          }
        });
      }
    });
  });

  $(document).on('click','#btn_tambahrinci', function () {
    $('#modalTambahSp3bRinciTambah').modal('show');
    $('#head_nosp3').html($(this).data('No_SP3'));
    $('#frmadd_idsp3').val($(this).data('Id_SP3'));
    $('#frmadd_nosp3').val($(this).data('No_SP3'));
    $('#checkall').prop('checked', false);
    $('#submit').prop('disabled',true);
    let url = '{{ URL::route('sp3b_list') }}'; 
    $('#tbl_list_rinci').DataTable({
      lengthChange: true,
      processing: true,
      serverSide: true,
      destroy: true,
      autoWidth: false,
      ajax: url,
      columns: [
        {data: 'ko_period', name: 'ko_period', width: '5%', className: 'text-center'},
        {data: 'no_SPi', name: 'no_SPi'},
        {data: 'No_oto', name: 'No_oto', className: 'text-center'},
        {data: 'tanggal', name: 'tanggal', className: 'text-center'},
        {data: 'Ur_oto', name: 'Ur_oto', className: 'text-center'},
        {data: 'jumlah', name: 'jumlah', className: 'text-right',width: '5%', render: $.fn.DataTable.render.number('.',',',2)},
        {data: 'action', name: 'action', className: 'text-center', orderable: false}
      ]
    });
  });

  let ceklist = $('table tbody .check:checked')
  let cek     = (ceklist.length > 0)
  $('#submit').prop('disabled',!cek);

  $(document).on('click','#checkall', function () {
    var isChecked = $('#checkall').prop('checked')
    $('.check').prop('checked',isChecked);

    if(isChecked > 0) {
      $('#submit').prop('disabled',false);
    }else{
      $('#submit').prop('disabled',true);
    }
  });

  $(document).on('click','.check', function () {
    let cek = $('table tbody .check:checked')

    if(cek.length > 0) {
      $('#submit').prop('disabled',false);
    }else{
      $('#submit').prop('disabled',true);
    }
  });

  $(document).on('click','#submit', function () {
    let dt   = $('.check:checked')
    let data = []
    $.each(dt, function (index, elm) { 
      data.push(elm.value)
    });

    $.ajax({
      type : 'POST',
      url  : '{{route('sp3b_rinci_store')}}',
      data : { '_token' : '{{ csrf_token() }}', data, 'id_sp3': $('#frmadd_idsp3').val(), 'no_sp3': $('#frmadd_nosp3').val() },
      dataType: 'json',
      success: function (response) {
        let id_sp3 = $('#frmadd_idsp3').val();
        let list   = '{{ URL::route('sp3b_rinci',':id_sp3') }}';
        let sp3brc = list.replace(':id',id_sp3);
        $('#tbl_sp3b_rinci').DataTable({
          lengthChange: true,
          processing: true,
          serverSide: true,
          destroy: true,
          autoWidth: false,
          ajax: sp3brc,
          columns: [
            {data: 'check', name: 'check', className: 'text-center', orderable: false},
            {data: 'Ko_sp3', name: 'Ko_sp3', width: '5%', className: 'text-center'},
            {data: 'No_oto', name: 'No_oto'},
            {data: 'Dt_oto', name: 'Dt_oto', width: '10%', className: 'text-center'},
            {data: 'sp3rc_Rp', name: 'sp3rc_Rp', className: 'text-right',width: '5%', render: $.fn.DataTable.render.number('.',',',2)},
            {data: 'action', name: 'action', className: 'text-center'}
          ]
        }).draw();
        Swal.fire('Berhasil', 'Data berhasil ditambahkan', 'success')
      }
    });
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

  $(document).on('click','#btn_hapusrinci', function () {
    let id_sp3 = $(this).data('Id_SP3');
    let list   = '{{ URL::route('sp3b_rinci',':id_sp3') }}';
    let sp3brc = list.replace(':id',id_sp3);
    let dt   = $('.checklist:checked')
    let data = []
    $.each(dt, function (index, elm) { 
      data.push(elm.value)
    });

    Swal.fire({
      title: 'Yakin data dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus data',
      customClass: {
        confirmButton: 'btn btn-danger me-2 mx-2',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        $.ajax({
          type : 'POST',
          url  : '{{route('sp3b_rinci_delete')}}',
          data : { '_token' : '{{ csrf_token() }}', data },
          dataType: 'json',
          success: function(data){
            $('#tbl_sp3b_rinci').DataTable({
              lengthChange: true,
              processing: true,
              serverSide: true,
              destroy: true,
              autoWidth: false,
              ajax: sp3brc,
              columns: [
                {data: 'check', name: 'check', className: 'text-center', orderable: false},
                {data: 'Ko_sp3', name: 'Ko_sp3', width: '5%', className: 'text-center'},
                {data: 'No_oto', name: 'No_oto'},
                {data: 'Dt_oto', name: 'Dt_oto', width: '10%', className: 'text-center'},
                {data: 'sp3rc_Rp', name: 'sp3rc_Rp', className: 'text-right',width: '5%', render: $.fn.DataTable.render.number('.',',',2)},
                {data: 'action', name: 'action', className: 'text-center'}
              ]
            }).draw();
            Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')
          },
          error: function (data) {
            Swal.fire('Info', 'Tidak diketahui', 'warning')
          }
        });
      }
    });
  });
</script>

@endsection