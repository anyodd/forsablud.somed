<div class="modal fade" id="cariTagihan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')Cari Tagihan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nomor Tagihan</th>
                                                <th>Tanggal Bukti</th>
                                                <th>Tanggal Jatuh Tempo</th>
                                                <th style="width: 30%">Uraian</th>
                                                <th>Penyedia Barang/Jasa</th>
                                                <th>Total (Rp)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center">{{$loop->iteration}}.</td>
                                                <td>{{$item->No_bp}}</td>
                                                <td class="text-center">{{$item->dt_bp}}</td>
                                                <td class="text-center">{{$item->dt_jt}}</td>
                                                <td>{{$item->Ur_bp}}</td>
                                                <td>{{nm_rekan($item->nm_BUcontr)}}</td>
                                                <td class="text-right">{{number_format($item->total,2,',','.')}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm py-0" data-dismiss="modal" title="Pilih data" id="pilihdata"
                                                        data-id_bp = "{{ $item->id_bp }}"
                                                        data-no_bp = "{{ $item->No_bp }}"
                                                        data-dt_bp = "{{ $item->dt_bp }}"
                                                        data-ur_bp = "{{ $item->Ur_bp }}"
                                                        data-tot_bp = "{{ number_format($item->total,2,',','.'); }}"
                                                    ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function() {
        $('#tabelTap').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details for ' + data[0] + ' ' + data[1];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            }
        });
    });
</script>
<script>
    $(function () {
      $(document).on('click','#pilihdata',function() {
        var v1 = $(this).data('id_bp');
        var v2 = $(this).data('no_bp');
        var v3 = $(this).data('dt_bp');
        var v4 = $(this).data('ur_bp');
        var v5 = $(this).data('tot_bp');
      //  console.log(v1);
        $('#id_bp').val(v1);
        $('#no_bp').val(v2);
        $('#dt_bp').val(v3);
        $('#ur_bp').val(v4);
        $('#total').val(v5);
      });
    })
  </script>
@endsection




