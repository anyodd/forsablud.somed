<!-- Modal Bukti Rincian -->
<div class="modal fade" id="modalBuktispjguutang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">BUKTI YANG DIAJUKAN - LS TAGIHAN</h5>
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
                                        <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                <th class="text-center" style="vertical-align: middle">No</th>
                                                <th class="text-center" style="vertical-align: middle">Nomor Tagihan</th>
                                                <th class="text-center" style="vertical-align: middle">Tgl Tagihan</th>
                                                <th class="text-center" style="vertical-align: middle">Tgl Jatuh Tempo</th>
                                                <th class="text-center" style="vertical-align: middle">Uraian</th>
                                                <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                                                <th class="text-center" style="vertical-align: middle">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 0;?>
                                            @foreach($spjguutangbukti as $spjguutangbukti)
                                            <tr>
                                                <td style="text-align: center">{{$loop->iteration}}.</td>                
                                                <td>{{ $spjguutangbukti->uta_doc }}</td>                      
                                                <td class="text-center">{{ $spjguutangbukti->dt_uta }}</td>                      
                                                <td class="text-center">{{ $spjguutangbukti->jt_uta }}</td>
                                                <td>{{ $spjguutangbukti->uta_ur }}</td>       
                                                <td class="text-right">{{ number_format($spjguutangbukti->uta_Rp,0,'','.') }}</td> 
                                                <td class="text-center">
                                                    <button class="btn btn-primary py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-val1 = "{{ $spjguutangbukti->uta_doc }}"
                                                        data-val2 = "{{ $spjguutangbukti->Ko_sKeg1 }}"
                                                        data-val3 = "{{ $spjguutangbukti->Ko_sKeg2 }}"
                                                        data-val4 = "{{ $spjguutangbukti->Ko_Rkk }}"
                                                        data-kegiatan = "{{ $spjguutangbukti->kegiatan }}"
                                                        data-urkk = "{{ $spjguutangbukti->ur_rkk }}"
                                                        data-utaur = "{{ $spjguutangbukti->uta_ur }}"
                                                        data-utarp = "{{ $spjguutangbukti->uta_Rp }}"
                                                    ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
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
        var urkk = $(this).data('urkk');
        var kegiatan = $(this).data('kegiatan');
        var utaur = $(this).data('utaur');
        var utarp = $(this).data('utarp');

        console.log(v1);
        $('#sNo_bp').val(v1);
        $('#sKo_sKeg1').val(v2);
        $('#sKo_sKeg2').val(v3);
        $('#sKo_Rkk').val(v4);
        $('#kegiatan').val(kegiatan);
        $('#urkk').val(urkk);
        $('#sUr_bprc').val(utaur);
        $('#sspirc_Rp').val(utarp);
    });
    })
</script>
@endsection