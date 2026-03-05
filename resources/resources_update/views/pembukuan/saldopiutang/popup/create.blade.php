<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@yield('title')</h4>
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
                                    <form action="{{ route('saldoawalpiutang.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nomor</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="piut_doc" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="dt_piut" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="piut_ur" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nama</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="piut_nm" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Alamat</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="piut_addr" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                              <label for="KegApbd">Cari Rincian</label>
                                            </div>
                                            <div class="col-md-10">
                                              <div class="input-group input-group-sm">
                                                  <input type="text" class="form-control" id="Ur_Keg2" name="Ur_Keg2">
                                                  <span class="input-group-append">
                                                  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalCariKegiatan">Cari!</button>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Ko_sKeg1" class="col-md-2 col-form-label">Nilai Target</label>
                                            <div class="col-md-2">
                                                <input type="text" name="To_Rp" class="form-control text-right" id="To_Rp" readonly>
                                            </div> 
                                            <div class="col-md-4">
                                                <input type="text" name="Ko_Pdp" class="form-control" id="Ko_Pdp" readonly hidden>
                                                <input type="text" name="Ko_pmed" class="form-control" id="Ko_pmed" value="0" readonly hidden>
                                            </div> 
                                        </div>
                                        <div class="form-group row">
                                            <label for="Ko_sKeg1" class="col-md-2 col-form-label">Uraian Program</label>
                                            <div class="col-md-3">
                                                <input type="text" name="Ko_sKeg1" class="form-control" id="sKo_sKeg1" readonly>
                                            </div> 
                                            <div class="col-md-7">
                                                <input type="text" name="Ur_sKeg1" class="form-control" id="Ur_KegBL1" readonly>
                                            </div> 
                                        </div>
                                        <div class="form-group row">
                                            <label for="Ko_sKeg2" class="col-md-2 col-form-label">Uraian Kegiatan</label>
                                            <div class="col-md-3">
                                                <input type="text" name="Ko_sKeg2" class="form-control" id="sKo_sKeg2" readonly>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="Ur_sKeg2" class="form-control" id="Ur_KegBL2" readonly>
                                            </div>  
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" id="Ko_Rkk" name="Ko_Rkk" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal_rekening">Cari!</button>
                                                    </span>
                                                </div>
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="ur_rek" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai (Rp)</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="piut_Rp" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-danger float-right"><i class="fas fa-save"></i> Save</button>
                                            <button class="btn btn-info mx-2 float-right" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> Cancel</button>
                                        </div>
                                    </form>
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
 $(function () {
    $(document).on('click','#select',function() {
        var v1 = $(this).data('k_skeg1');
        var v2 = $(this).data('k_skeg2');
        // var v3 = $(this).data('k_skeg3');
        var v4 = $(this).data('k_skeg4');
        var v5 = $(this).data('k_skeg5');
        var v6 = $(this).data('k_skeg6');
        var v7 = $(this).data('k_skeg7');
        var v8 = $(this).data('k_skeg8');
        $('#sKo_sKeg1').val(v1);
        $('#sKo_sKeg2').val(v2);
        // $('#sKo_Rkk').val(v3);
        $('#Ur_KegBL1').val(v4);
        $('#Ur_KegBL2').val(v5);
        $('#Ur_Rk6').val(v6);
        $('#To_Rp').val(v7);
        $('#Ko_Pdp').val(v8);
        $('#modalCariKegiatan').hide();
    });

    $(document).on('click','#pilihrek',function() {
        var v1 = $(this).data('rkk');
        var v2 = $(this).data('ur_rkk');
        $('#Ko_Rkk').val(v1);
        $('#ur_rek').val(v2);
        $('#modal_rekening').hide();
    });
  })
</script>
@endsection