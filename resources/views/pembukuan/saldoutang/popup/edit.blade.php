<div class="modal fade" id="modal-edit{{$item->id}}">
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
                                    <form action="{{ route('saldoawalutang.update',$item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nomor</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="uta_doc" id="uta_doc" value="{{$item->uta_doc}}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="dt_uta" id="dt_uta" value="{{$item->dt_uta}}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Tanggal Jatuh Tempo</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="jt_uta" id="jt_uta" value="{{$item->jt_uta}}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="uta_ur" id="uta_ur" value="{{$item->uta_ur}}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nama</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <input type="text" name="uta_nm" id="uta_nm" value="{{$item->uta_nm}}" class="form-control" required> --}}
                                                <select class="form-control select2" name="uta_nm" id="uta_nm{{$item->id}}" onchange="myEdituta_nm({{$item->id}})" required>
                                                    @foreach ($rekan as $rk)
                                                        @if ($rk->rekan_nm != $item->uta_nm)
                                                            @if ($loop->first)
                                                            <option value="{{$item->id_rekan}}|{{$item->uta_nm}}|{{$item->uta_addr}}">{{$item->uta_nm}}</option>
                                                            @endif
                                                        @endif
                                                        <option value="{{$rk->id_rekan}}|{{$rk->rekan_nm}}|{{$rk->rekan_adr}}" {{$rk->rekan_nm == $item->uta_nm ? 'selected' : ''}}>{{$rk->rekan_nm}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Alamat</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="uta_addr" id="uta_addr{{$item->id}}" value="{{$item->uta_addr}}" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kegiatan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="skeg1" name="Ko_sKeg1" value="{{$item->Ko_sKeg1}}" readonly>
                                                    <input type="text" class="form-control" id="skeg2" name="Ko_sKeg2" value="{{$item->Ko_sKeg2}}" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal_kegiatan">Cari!</button>
                                                    </span>
                                                </div>
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="ur_keg" value="{{$item->ur_keg}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="Ko_Rkk" name="Ko_Rkk" value="{{$item->Ko_Rkk}}" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#rekening">Cari!</button>
                                                    </span>
                                                </div>
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="ur_rek" value="{{$item->ur_rkk}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai (Rp)</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="uta_Rp" id="uta_rp" value="{{$item->uta_Rp}}" class="form-control desimal" required>
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
