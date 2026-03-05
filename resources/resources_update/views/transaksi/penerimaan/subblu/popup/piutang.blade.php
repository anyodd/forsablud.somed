<div class="modal fade" id="modalCariKegiatan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')Cari Kegiatan APBD</h4>
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
                                            <th>Nomor</th>
                                            <th>Tanggal</th>
                                            <th>Uraian</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nilai (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- @if(count($datafinal ?? '') > 0 ) --}}

                                    <tbody>
                                            @foreach ($datafinal as $item)
                                            <tr>
                                                <td>{{$item->piut_doc}}</td>
                                                <td>{{$item->dt_piut}}</td>
                                                <td>{{$item->piut_ur}}</td>
                                                <td>{{$item->piut_nm}}</td>
                                                <td>{{$item->piut_addr}}</td>
                                                <td class="text-right">{{ number_format($item->piut_Rp, 2, ",", ".") }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-k_skeg1 = "{{ $item->Ko_sKeg1 }}"
                                                        data-k_skeg2 = "{{ $item->Ko_sKeg2 }}"
                                                        data-k_skeg3 = "{{ $item->Ko_Rkk }}"
                                                        data-k_skeg6 = "{{ $item->piut_ur }}"
                                                        data-k_skeg7 = "{{ $item->piut_Rp }}"
                                                        data-k_skeg8 = "1"
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
 $(function () {
    $(document).on('click','#select',function() {
        var v1 = $(this).data('k_skeg1');
        var v2 = $(this).data('k_skeg2');
        var v3 = $(this).data('k_skeg3');
        var v4 = $(this).data('k_skeg4');
        var v5 = $(this).data('k_skeg5');
        var v6 = $(this).data('k_skeg6');
        var v7 = $(this).data('k_skeg7');
        var v8 = $(this).data('k_skeg8');
        var rp = v7.toString().replace('.',',');
        console.log(rp);
        $('#sKo_sKeg1').val(v1);
        $('#sKo_sKeg2').val(v2);
        $('#sKo_Rkk').val(v3);
        $('#Ur_KegBL1').val(v4);
        $('#Ur_KegBL2').val(v5);
        $('#Ur_Rk6').val(v6);
        $('#To_Rp_3').val(rp);
        $('#Ko_Pdp').val(v8);
        $('#To_Rp2').val(rp);
        $('#modal_rekening').hide();
    });
  })
</script>
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
@endsection




