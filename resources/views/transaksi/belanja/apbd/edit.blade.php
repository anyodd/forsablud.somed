<div class="modal fade" id="modal_edit{{ $belanja->id_bp }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data Belanja</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('apbd.update', ['apbd' => $belanja->id_bp]) }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="No_bp" class="col-sm-2 col-form-label">Nomor
                                                        Bukti</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="No_bped" id="No_bped"
                                                            class="form-control" value="{{ $belanja->No_bp }}"
                                                            placeholder="Isikan Nomor Dokumen">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="dt_bped" class="col-sm-2 col-form-label">Tanggal
                                                    </label>
                                                    <div class="col-sm">
                                                        <input type="date" name="dt_bped" id="dt_bped"
                                                            class="form-control" value="{{ $belanja->dt_bp }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Ur_bped" class="col-sm-2 col-form-label">Uraian</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="Ur_bped" id="Ur_bped"
                                                            class="form-control" value="{{ $belanja->Ur_bp }}"
                                                            placeholder="Keterangan Transaksi">
                                                    </div>
                                                </div>
												<div class="form-group row">
													 <label for="" class="col-sm-2 col-form-label">Jenis SP2D</label>
													 <div class="col-sm-3">
														<select class="form-control" name="Jn_Spm">
															<option value="0" {{$belanja->Jn_Spm == 0 ? 'selected' : ''}}>Non</option>
															<option value="1" {{$belanja->Jn_Spm == 1 ? 'selected' : ''}}>SP2D LS-Gaji</option>
															<option value="2" {{$belanja->Jn_Spm == 2 ? 'selected' : ''}}>SP2D LS-Barjas</option>
															<option value="3" {{$belanja->Jn_Spm == 3 ? 'selected' : ''}}>SP2D LS-Modal</option>
															<option value="4" {{$belanja->Jn_Spm == 4 ? 'selected' : ''}}>SP2D GU</option>
														</select>
													 </div>
												</div>
                                                <div class="form-group row">
                                                    <label for="nm_BUcntred" class="col-sm-2 col-form-label">Nama
                                                        Pihak-3</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="nm_BUcntred" id="nm_BUcntred"
                                                            class="form-control" value="{{ $belanja->nm_BUcontr }}"
                                                            placeholder="Isikan Nama Pihak Lain">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="adr_bucntred" class="col-sm-2 col-form-label">Alamat
                                                        Pihak-3
                                                    </label>
                                                    <div class="col-sm">
                                                        <input type="text" name="adr_bucntred" id="adr_bucntred"
                                                            class="form-control" value="{{ $belanja->adr_bucontr }}"
                                                            placeholder="Isikan Alamat Pihak Lain">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Nm_inputed"
                                                        class="col-sm-2 col-form-label">Petugas</label>
                                                    <div class="col-sm">
                                                        {{-- <input type="text" name="Nm_inputed" id="Nm_inputed"
                                                            class="form-control" value="{{ $belanja->Nm_input }}"
                                                            placeholder="Isikan Petugas Entry Data "> --}}
                                                        <select class="form-control select2" name="Nm_inputed">
                                                            @foreach ($pegawai as $ls)
                                                                <option value="{{$ls->nama}}" {{$ls->nama == $belanja->Nm_input ? 'selected' : ''}}>{{$ls->nama}} ({{$ls->jabatan}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                        <div class="col-md-1 float-right">
                                            <button class="btn btn-outline-secondary btn-block px-0"
                                                data-dismiss="modal">Batal</button>
                                        </div>

                                    </div>

                                    <!-- /.card-footer-->
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
