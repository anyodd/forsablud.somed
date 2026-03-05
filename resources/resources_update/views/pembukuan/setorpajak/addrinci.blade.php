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
            <h5 class="card-title font-weight-bold">Tambah Rincian Setor Pajak</h5> 
          </div>

          <div class="card-body px-2 py-2">
              <div class="card-body">
                <table id="example" class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Rekanan</th>
                      <th>No. Tagihan</th>
                      <th>Tagihan</th>
                      <th>Total Tagihan</th>
                      <th>Jenis Pajak</th>
                      <th>Uraian Pajak</th>
                      <th>Pajak (Rp)</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($rincian as $item)
                        <tr>
                          <td>{{$loop->iteration}}.</td>
                          <td>{{$item->rekan_nm}}</td>
                          <td>{{$item->No_bp}}</td>
                          <td>{{$item->Ur_bp}}</td>
                          <td class="text-right">{{number_format($item->t_tag,2,',','.')}}</td>
                          <td>{{$item->ur_rk6}}</td>
                          <td>{{$item->Ko_tax}}</td>
                          <td class="text-right">{{number_format($item->tax_Rp,2,',','.')}}</td>
                          <td>
                            <button id="pilih" class="btn btn-sm btn-outline-success"
                              data-id_taxtor = "{{ $id_taxtr }}"
                              data-id_tax = "{{ $item->idtax }}"
                              data-rp = "{{ $item->tax_Rp }}"
                              >
                              <i class="far fa-check-circle pr-2"></i> Pilih
                            </button>
                          </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <input type="text" id="id_page" value="{{$id_taxtr}}" hidden>
              <div class="form-group row justify-content-center mt-3">
                <a href="{{ route('setorpajak.listdetail',$id_taxtr) }}" class="col-sm-2 btn btn-danger ml-3">
                  <i class="fas fa-backward pr-2"></i>Kembali
                </a> 
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>  

@endsection

@section('script')  
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(function () {
      var id_page = $('#id_page').val();
      $(document).on('click', '#pilih', function() {
      var id_taxtor = $(this).data('id_taxtor');
      var rp = $(this).data('rp');
      var id_tax = $(this).data('id_tax');
      console.log(rp);
      var data = {
        'id_taxtor': id_taxtor,
        'id_tax': id_tax,
        'rp_taxtor': rp
      }
      // console.log(data);
      $.ajax({
        url: "{{ route('setorpajak.store_detail') }}",
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function (response) {
          if(response.statusCode==200){
            window.location = "{{ route('setorpajak.listdetail','') }}"+"/"+id_page;       
          }
          else if(response.statusCode==201){
              alert("Gagal Simpan Rincian Pajak");
          }
        }
      });
      
  });

  $(document).on('click', '#btnback', function () {
      location.reload();
    });
  })
</script>

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
</script>
@endsection