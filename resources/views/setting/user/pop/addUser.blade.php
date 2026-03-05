<div class="modal fade" id="modal-addUser">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah User Akses</h4>
          </button>
        </div>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
        <div class="modal-body">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-6">
                                        <select name="user_name" id="" class="form-control select2" required>
                                            <option value="">--- Pilih Nama Pegawai ---</option>
                                            @foreach ($pjb as $item)
                                                <option value="{{$item->NIP_pjb}}">{{$item->Nm_pjb}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control"required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Hak Akses</label>
                                    <div class="col-sm-4">
                                        <select name="user_level" id="" class="form-control select2" required>
                                            <option value="" selected>--- Pilih Level ---</option>
                                            <option value="2">Otorisator - Pimpinan</option>
                                            <option value="3">Sekretaris Pimpinan</option>
                                            <option value="4">Keuangan</option>
                                            <option value="5">Dinas</option>
                                            <option value="6">PPTK</option>
                                            <option value="10">Perencana</option>
                                            <option value="7">Bendahara</option>
                                            <option value="8">Pembukuan</option>
                                            <option value="9">Laporan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="submit" class="btn btn-outline-primary"><i class="far fa-save"></i> Simpan</button>
        </div>
        </form>
      </div>
    </div>
</div>  