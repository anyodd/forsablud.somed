<!-- Modal Bukti Rincian -->
<div class="modal fade" id="modalBuktiLskontrak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">BUKTI YANG DIAJUKAN - LS KONTRAK/SPK</h5>
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
                                                <th class="text-center" style="vertical-align: middle">Nomor Kontrak</th>
                                                <th class="text-center" style="vertical-align: middle">Nomor Termin</th>
                                                <th class="text-center" style="vertical-align: middle">Uraian</th>
                                                <th class="text-center" style="vertical-align: middle">Kode Program</th>
                                                <th class="text-center" style="vertical-align: middle">Kode Kegiatan</th>
                                                <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                                                <th class="text-center" style="vertical-align: middle">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 0;?>
                                            @foreach($buktilskontrak as $buktilskontrak)
                                            <?php $no++ ;?>
                                            <tr>
                                                <td style="text-align: center">{{$no}}</td>                
                                                <td>{{ $buktilskontrak->rftr_bprc }}</td>                      
                                                <td>{{ $buktilskontrak->no_bp }}</td>                      
                                                <td>{{ $buktilskontrak->ur_bprc }}</td>                                          
                                                <td>{{ $buktilskontrak->ko_skeg1 }}</td>    
                                                <td>{{ $buktilskontrak->ko_skeg2 }}</td>
                                                <td>{{ number_format($buktilskontrak->to_rp,2,',','.') }}</td>
                                                <td>
                                                    <button class="btn btn-primary py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-val1 = "{{ $buktilskontrak->no_bp }}"
                                                        data-val2 = "{{ $buktilskontrak->ko_bprc }}"
                                                        data-val3 = "{{ $buktilskontrak->ko_skeg1 }}"
                                                        data-val4 = "{{ $buktilskontrak->ko_skeg2 }}"
                                                        data-val5 = "{{ $buktilskontrak->ko_rkk }}"
                                                        data-val6 = "{{ $buktilskontrak->ko_pdp }}"
                                                        data-val7 = "{{ $buktilskontrak->ko_pmed }}"
                                                        data-val8 = "{{ $buktilskontrak->rftr_bprc }}"
                                                        data-val9 = "{{ $buktilskontrak->dt_rftrbprc }}"
                                                        data-val10 = "{{ $buktilskontrak->ur_bprc }}"
                                                        data-val11 = "{{ $buktilskontrak->to_rp }}"
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
        var v5 = $(this).data('val5');
        var v6 = $(this).data('val6');
        var v7 = $(this).data('val7');
        var v8 = $(this).data('val8');
        var v9 = $(this).data('val9');
        var v10 = $(this).data('val10');
        var v11 = $(this).data('val11');

        console.log(v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11);
        $('#sNo_bp').val(v1);
        $('#sKo_bprc').val(v2);
        $('#sKo_sKeg1').val(v3);
        $('#sKo_sKeg2').val(v4);
        $('#sKo_Rkk').val(v5);
        $('#sKo_Pdp').val(v6);
        $('#sko_pmed').val(v7);
        $('#srftr_bprc').val(v8);
        $('#sdt_rftrbprc').val(v9);
        $('#sUr_bprc').val(v10);
        $('#sspirc_Rp').val(v11);
    });
    })
</script>
@endsection