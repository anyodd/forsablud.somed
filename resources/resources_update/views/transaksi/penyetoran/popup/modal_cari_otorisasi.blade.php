<div class="modal fade" id="modalCariOtorisasi">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')Cari Otorisasi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- About Me Box -->
                            <div class="card card-info">

                            <!-- /.card-header -->
                            <div class="card-body">
                            <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nomor SPI</th>
                                            <th>Nomor Otorisasi</th>
                                            <th>Tanggal Otorisasi</th>
                                            <th>Uraian Otorisasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- @if(count($data ?? '') > 0 ) --}}

                                    <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>{{$item->No_SPi}}</td>
                                                <td>{{$item->No_oto}}</td>
                                                <td>{{$item->Dt_oto}}</td>
                                                <td>{{$item->Ur_oto}}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-k_skeg1 = "{{ $item->No_SPi }}"
                                                        data-k_skeg2 = "{{ $item->No_oto }}"
                                                        data-k_skeg3 = "{{ $item->Dt_oto }}"
                                                        data-k_skeg4 = "{{ $item->Ur_oto }}"
                                                    ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- @endif --}}
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    </tbody>
                                    {{-- @endif --}}
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
                {{-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->
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
    $(document).on('click','#select',function() {
        var v1 = $(this).data('No_SPi');
        var v2 = $(this).data('No_Oto');
        var v1 = $(this).data('Dt_oto');
        var v2 = $(this).data('Ur_oto');
        $('#dNo_SPi').val(v1);
        $('#dNo_Oto').val(v2);
        $('#dDt_oto').val(v1);
        $('#dUr_oto').val(v2);
        $('#modal_rekening').hide();
    });
  })
</script>
@endsection




