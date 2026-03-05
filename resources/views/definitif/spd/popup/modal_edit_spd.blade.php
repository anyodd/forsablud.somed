<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">EDIT PENETAPAN</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="noSpd" class="col-sm-3 col-form-label">Nomor SPD</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="noSpd" class="form-control" id="noSpd">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggalSpd" class="col-sm-3 col-form-label">Tanggal
                                                        SPD</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="tanggalSpd" class="form-control"
                                                            id="tanggalSpd">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="uraianSpd" class="col-sm-3 col-form-label">Uraian
                                                        SPD</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="uraianSpd" class="form-control" id="uraianSpd"
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nmPenandatanganSpd" class="col-sm-3 col-form-label">Nm.
                                                        Penandatangan SPD</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nmPenandatanganSpd"
                                                            class="form-control" id="nmPenandatanganSpd">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nipPenandatanganSpd" class="col-sm-3 col-form-label">NIP
                                                        Penandatangan SPD</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" nama="nipPenandatanganSpd"
                                                            class="form-control" id="nipPenandatanganSpd">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-1">
                                                <button type="submit"
                                                    class="btn btn-success btn-block px-0">Simpan</button>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-secondary btn-block px-0"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
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
            <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
        </div>
    </div>
</div>