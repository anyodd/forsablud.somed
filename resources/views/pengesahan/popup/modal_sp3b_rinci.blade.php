<div class="modal fade" id="modalSp3bRinci" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Rincian SP3B</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nomor Dokumen</label>
                        <div class="col-sm">
                          <input type="text" id="frm_no" class="form-control" disabled>
                        </div>
                        <label for="" class="col-sm-2 col-form-label text-right">Tanggal Dokumen</label>
                        <div class="col-sm">
                          <input type="date" id="frm_tgl" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Uraian</label>
                        <div class="col-sm">
                          <input type="text" id="frm_uraian" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Kepala/Kuasa</label>
                        <div class="col-sm">
                          <input type="text" id="frm_kuasa" class="form-control" disabled>
                        </div>
                        <label for="" class="col-sm-2 col-form-label text-right">NIP</label>
                        <div class="col-sm">
                          <input type="text" id="frm_nip" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center mb-2">
                <button class="btn btn-primary" id="btn_tambahrinci"><i class="fa fa-plus-square"></i> Tambah</button>
                <button class="btn btn-danger mx-2" id="btn_hapusrinci"><i class="fa fa-trash"></i> Hapus</button>
                <button class="btn btn-info" data-dismiss="modal"><i class="fa fa-reply"></i> Kembali</button>
              </div>

              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0" id="tbl_sp3b_rinci" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center" style="vertical-align: middle;"><input type="checkbox" id="checklist"></th>
                          <th class="text-center" style="vertical-align: middle;">Nomor Urut</th>
                          <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Nilai Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;width: 5%">#</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>