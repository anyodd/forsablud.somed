<div class="modal fade" id="modaledit{{$item->id}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit @yield('title')</h4>
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
                                    <form action="{{ route('saldoawal.update',$item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai</label>
                                            </div>
                                            <div class="col-md-4">
                                                @if ($item->soaw_Rp_D == 0)
                                                    <input type="text" name="soaw_Rp" placeholder="Nilai Saldo Awal" class="form-control desimal" value="{{ old('soaw_Rp',number_format($item->soaw_Rp_K,2,',','.')) }}" required>
                                                @else
                                                    <input type="text" name="soaw_Rp" placeholder="Nilai Saldo Awal" class="form-control desimal" value="{{ old('soaw_Rp',number_format($item->soaw_Rp_D,2,',','.')) }}" required>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Tag">Status</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select id="Tag" name="Tag" class="form-control" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                    <option value="">--Pilih Status--</option>
                                                    <option value="0" {{$item->Tag == '0' ? 'selected' : ''}}>Draft</option>
                                                    <option value="1" {{$item->Tag == '1' ? 'selected' : ''}}>Final</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" id="kd_rkk{{$item->id}}" name="Ko_rkk5" value="{{$item->ko_rkk5}}" required>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat" id="id_edit"
                                                            data-toggle="modal"
                                                            data-target="#modal_rekeningedit"
                                                            data-id = "{{$item->id}}">Cari!
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                                            <a href="#" data-dismiss="modal"class="btn btn-success float-right"> <i class="far fa-arrow-alt-circle-left"> Back</i></a>
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
