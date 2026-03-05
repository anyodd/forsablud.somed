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
                                    <form action="{{ route('saldoawalutang.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nomor</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="uta_doc" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="dt_uta" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Tanggal Jatuh Tempo</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="jt_uta" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="uta_ur" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nama</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <input type="text" name="uta_nm" class="form-control" required> --}}
                                                <select class="form-control select2" name="uta_nm" id="cruta_nm" required>
                                                    <option value="">-- Pilih Rekanan --</option>
                                                    @foreach ($rekan as $rk)
                                                        <option value="{{$rk->id_rekan}}|{{$rk->rekan_nm}}|{{$rk->rekan_adr}}">{{$rk->rekan_nm}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">  
                                                <label for="soaw_Rp">Alamat</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="uta_addr" id="cruta_addr" class="form-control" required readonly>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kegiatan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="skeg1_create" name="Ko_sKeg1" readonly>
                                                    <input type="text" class="form-control" id="skeg2_create" name="Ko_sKeg2" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal_kegiatan">Cari!</button>
                                                    </span>
                                                </div>
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="ur_keg_create" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="Ko_Rkk_create" name="Ko_Rkk" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#rekening">Cari!</button>
                                                    </span>
                                                </div>
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="ur_rek_create" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai (Rp)</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="uta_Rp" class="form-control desimal" required>
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
