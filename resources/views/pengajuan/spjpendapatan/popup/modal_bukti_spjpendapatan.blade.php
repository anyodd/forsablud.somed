<!-- Modal Bukti Rincian -->
<div class="modal fade" id="modalBuktiSpjpendapatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">BUKTI YANG DIAJUKAN - SPJ PENDAPATAN</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="GET" enctype="multipart/form-data">
                            {{csrf_field()}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                <th class="text-center" style="vertical-align: middle">No</th>
                                                <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                                                <th class="text-center" style="vertical-align: middle">Uraian Bukti</th>
                                                <th class="text-center" style="vertical-align: middle">No. Bayar</th>
                                                <th class="text-center" style="vertical-align: middle">Tgl. Bayar</th>
                                                <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                                                <th class="text-center" style="vertical-align: middle">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 0;?>
                                            @foreach($spjpendapatanbukti as $spjpendapatanbukti)
                                            <?php $no++ ;?>
                                            <tr>
                                                <td style="text-align: center">{{$no}}</td>                
                                                <td>{{ $spjpendapatanbukti->No_byr }}</td>                                           
                                                <td>{{ $spjpendapatanbukti->Ur_byr }}</td>                      
                                                <td>{{ $spjpendapatanbukti->No_byr }}</td>  
                                                <td>{{ $spjpendapatanbukti->dt_byr }}</td>                       
                                                <td class="text-right">{{ number_format($spjpendapatanbukti->realisasi,2,',','.') }}</td>  
                                                <td>
                                                    <button class="btn btn-primary py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-val1 = "{{ $spjpendapatanbukti->No_byr }}"
                                                        data-val2 = "{{ $spjpendapatanbukti->dt_byr }}"
                                                        data-val3 = "{{ $spjpendapatanbukti->Ur_byr }}"
                                                        data-val4 = "{{ $spjpendapatanbukti->realisasi }}"
                                                        data-val5 = "{{ $spjpendapatanbukti->id_byr }}"
                                                        data-val6 = "{{ $spjpendapatanbukti->No_byr }}"
                                                        data-val7 = "{{ $spjpendapatanbukti->dt_byr }}"
                                                    ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button>
                                                </td>                     
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
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

        console.log(v1,v2,v3,v4,v5,v6,v7);
        $('#sNo_sts').val(v1);
        $('#sdt_sts').val(v2);
        $('#sUr_sts').val(v3);
        $('#sjumlah').val(v4);
        $('#sid_sts').val(v5);
        $('#sNo_byr').val(v6);
        $('#sdt_byr').val(v7);
    });
    })
</script>
@endsection