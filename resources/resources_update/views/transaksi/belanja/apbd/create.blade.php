<div class="modal fade" id="modal_create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Data Belanja</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('apbd.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="No_bp" class="col-sm-2 col-form-label">Nomor
                                                        Bukti</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="No_bp" id="No_bp"
                                                            class="form-control" placeholder="Isikan Nomor Dokumen">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="dt_bp" class="col-sm-2 col-form-label">Tanggal
                                                    </label>
                                                    <div class="col-sm">
                                                        <input type="date" name="dt_bp" id="dt_bp"
                                                            class="form-control" value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Ur_bp" class="col-sm-2 col-form-label">Uraian</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="Ur_bp" id="Ur_bp"
                                                            class="form-control" placeholder="Keterangan Transaksi">
                                                    </div>
                                                </div>
												<div class="form-group row">
													 <label for="" class="col-sm-2 col-form-label">Jenis SP2D</label>
													 <div class="col-sm-3">
														<select class="form-control" name="Jn_Spm">
															<option value="0" >Non</option>
															<option value="1" >SP2D LS-Gaji</option>
															<option value="2" >SP2D LS-Barjas</option>
															<option value="3" >SP2D LS-Modal</option>
															<option value="4" >SP2D GU</option>
														</select>
													 </div>
												</div>
                                                <div class="form-group row">
                                                    <label for="nm_BUcontr" class="col-sm-2 col-form-label">Nama
                                                        Pihak-3</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="nm_BUcontr" id="nm_BUcontr"
                                                            class="form-control" placeholder="Isikan Nama Pihak Lain">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="adr_bucontr" class="col-sm-2 col-form-label">Alamat
                                                        Pihak-3
                                                    </label>
                                                    <div class="col-sm">
                                                        <input type="text" name="adr_bucontr" id="adr_bucontr"
                                                            class="form-control"
                                                            placeholder="Isikan Alamat Pihak Lain">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Nm_input"
                                                        class="col-sm-2 col-form-label">Petugas</label>
                                                    <div class="col-sm">
                                                        {{-- <input type="text" name="Nm_input" id="Nm_input"
                                                            class="form-control"
                                                            placeholder="Isikan Petugas Entry Data "> --}}
                                                        <select class="form-control select2" name="Nm_input">
                                                            <option value="">-- Petugas Entry Data --</option>
                                                            @foreach ($pegawai as $item)
                                                                <option value="{{$item->nama}}">{{$item->nama}} ({{$item->jabatan}})</option>
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
                                            <i class="fas fa-save"></i> Save
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
