<!-- Modal Bukti Rincian -->
<div class="modal fade" id="modalBuktiSppPanjar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">BUKTI YANG DIAJUKAN - SPP PANJAR
                </h5>
            </div>
            <div class="modal-body">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.card-body -->
                            <form action="" method="GET" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap"
                                                width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center" style="vertical-align: middle">No</th>
                                                        <th class="text-center" style="vertical-align: middle">Kode
                                                            Program</th>
                                                        <th class="text-center" style="vertical-align: middle">Kode
                                                            Kegiatan</th>
                                                        <th class="text-center" style="vertical-align: middle">Uraian
                                                            Kegiatan</th>
                                                        <th class="text-center" style="vertical-align: middle">Kode
                                                            Rekening</th>
                                                        <th class="text-center" style="vertical-align: middle">Nama
                                                            Rekening</th>
                                                        <th class="text-center" style="vertical-align: middle">Nominal
                                                        </th>
                                                        <th class="text-center" style="vertical-align: middle">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 0;?>
                                                    @foreach($data_transaksi as $row)
                                                    <?php $no++ ;?>
                                                    <tr>
                                                        <td style="text-align: center">{{$no}}</td>
                                                        <td>{{ $row->ko_skeg1 }}</td>
                                                        <td>{{ $row->ko_skeg2 }}</td>
                                                        <td>{{ $row->ur_kegbl2 }}</td>
                                                        <td>{{ $row->ko_rkk }}</td>
                                                        <td>{{ $row->ur_rk6 }}</td>
                                                        <td style="text-align: right">{{ number_format($row->to_rp, 2,
                                                            ",",
                                                            ".") }}</td>
                                                        <td>
                                                            <button class="btn btn-block btn-primary py-0"
                                                                data-dismiss="modal" title="Pilih data" id="select"
                                                                data-val1="{{ $row->PD }}"
                                                                data-val2="{{ $row->ko_skeg1 }}"
                                                                data-val3="{{ $row->ko_skeg2 }}"
                                                                data-val4="{{ $row->ko_rkk }}"
                                                                data-val5="{{ $row->to_rp }}"><i style='font-size:8px'
                                                                    class="fa fa-choose">
                                                                </i>Pilih</button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-footer-->
                                    <div class="card-footer">
                                    </div>
                                </div>
                                <!-- /.card -->
                            </form>
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
        $(document).on('click','#select',function() {
            var v1 = $(this).data('val1');
            var v2 = $(this).data('val2');
            var v3 = $(this).data('val3');
            var v4 = $(this).data('val4');
            var v5 = $(this).data('val5');

            $('#sPD').val(v1);
            $('#sKo_sKeg1').val(v2);
            $('#sKo_sKeg2').val(v3);
            $('#sKo_Rkk').val(v4);
            $('#sspirc_Rp').val(v5);
        });
    })
</script>
@endsection