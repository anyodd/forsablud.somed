<!-- Modal Bukti Rincian -->
<div class="modal fade" id="modalSaldoUtang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">TAGIHAN UTANG</h5>
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
                                        <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0" style="font-size: 10pt">
                                            <thead class="thead-light">
                                                <tr>
                                                <th class="text-center" style="vertical-align: middle">No</th>
                                                <th class="text-center" style="vertical-align: middle">Program</th>
                                                <th class="text-center" style="vertical-align: middle">Kegiatan</th>
                                                <th class="text-center" style="vertical-align: middle">Akun</th>
                                                <th class="text-center" style="vertical-align: middle">Nomor Tagihan</th>
                                                <th class="text-center" style="vertical-align: middle">Tgl Tagihan</th>
                                                <th class="text-center" style="vertical-align: middle">Tgl Jatuh Tempo</th>
                                                <th class="text-center" style="vertical-align: middle">Uraian</th>
                                                <th class="text-center" style="vertical-align: middle">Nama Pihak Lain</th>
                                                <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                                                <th class="text-center" style="vertical-align: middle">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $data)
                                            <tr>
                                                <td style="text-align: center">{{$loop->iteration}}</td>                
                                                <td>{{ $data->Ko_sKeg1 }}</td>                      
                                                <td>{{ $data->Ko_sKeg2 }}</td>                      
                                                <td>{{ $data->Ko_Rkk }}</td>                      
                                                <td>{{ $data->uta_doc }}</td>                      
                                                <td>{{ $data->dt_uta }}</td>                      
                                                <td>{{ $data->jt_uta }}</td>
                                                <td style="width: 50%">{{ $data->uta_ur }}</td>                          
                                                <td>{{ nm_rekan($data->id_rekan) }}</td> 
                                                @if ($data->total == null)
                                                    <td>{{ number_format($data->uta_Rp,2,',','.') }}</td>
                                                @else
                                                    <td>{{ number_format($data->total,2,',','.') }}</td>
                                                @endif 
                                                <td>
                                                    <button class="btn btn-primary py-0" data-dismiss="modal" title="Pilih data" id="select"
                                                        data-val1 = "{{ $data->uta_doc }}"
                                                        data-val2 = "{{ $data->uta_ur }}"
                                                        data-val3 = "{{ $data->dt_uta }}"
                                                        data-val4 = "{{ $data->jt_uta }}"
                                                        data-val5 = "{{ $data->Ko_sKeg1 }}"
                                                        data-val6 = "{{ $data->Ko_sKeg2 }}"
                                                        data-val7 = "{{ $data->ur_keg }}"
                                                        data-val8 = "{{ $data->Ko_Rkk }}"
                                                        data-val9 = "{{ $data->ur_rkk }}"
                                                        @if ($data->total == null)
                                                        data-val10 = "{{ number_format($data->uta_Rp,2,',','.') }}"
                                                        @else
                                                        data-val10 = "{{ number_format($data->total,2,',','.') }}"
                                                        @endif
                                                        data-val11 = "{{ $data->id_rekan }}"
                                                        data-val12 = "{{ $data->uta_nm }}"
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
        var v12 = $(this).data('val12');

        $('#No_bp').val(v1);
        $('#UrBp').val(v2);
        $('#DtBp').val(v3);
        $('#DtJt').val(v4);
        $('#Ko_sKeg1').val(v5);
        $('#Ko_sKeg2').val(v6);
        $('#Ur_Keg').val(v7);
        $('#Ko_Rkk').val(v8);
        $('#Ur_Rkk').val(v9);
        $('#To_Rp').val(v10);
        if (v11 === '') {
            $('#NmBuContr_isi').val(v12);
            $('#pilih_bu').removeAttr('hidden','false');
            $('#NmBuContr').removeAttr('disabled','false');
            document.getElementById('isi_bu').setAttribute('hidden','true');
            document.getElementById('NmBuContr_isi').setAttribute('disabled','true');
            document.getElementById('NmBuContr_val').setAttribute('disabled','true');
        } else {
            document.getElementById("pilih_bu").setAttribute('hidden','true');
            $('#NmBuContr_isi').removeAttr('disabled','false');
            $('#NmBuContr_val').removeAttr('disabled','false');
            $('#isi_bu').removeAttr('hidden','false');
            $('#NmBuContr_isi').val(v12);
            $('#NmBuContr_val').val(v11);
        }
    });
    })
</script>
@endsection