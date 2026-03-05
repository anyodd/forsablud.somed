<div class="modal fade" id="modal-editUser{{ $item->user_id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit User</h4>
          </button>
        </div>
        <form action="{{ route('user.update', $item->user_id) }}" method="POST">
            @method('PATCH')
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
                                        <input type="email" name="" class="form-control" value="{{ $item->nama }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Hak Akses</label>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control" value="{{ $item->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-3 col-form-label">Level</label>
                                    <div class="col-sm-4">
                                        <select name="user_level" class="form-control select2" required>
                                            {{-- <option value="" selected>--- Pilih Level ---</option> --}}
                                            <option value="2" {{ $item->user_level == '2' ? 'selected' : '' }}>Otorisator - Pimpinan</option>
                                            <option value="3" {{ $item->user_level == '3' ? 'selected' : '' }}>Sekretaris Pimpinan</option>
                                            <option value="4" {{ $item->user_level == '4' ? 'selected' : '' }}>Keuangan</option>
                                            <option value="5" {{ $item->user_level == '5' ? 'selected' : '' }}>Dinas</option>
                                            <option value="6" {{ $item->user_level == '6' ? 'selected' : '' }}>PPTK</option>
                                            <option value="10" {{ $item->user_level == '10' ? 'selected' : '' }}>Perencana</option>
                                            <option value="7" {{ $item->user_level == '7' ? 'selected' : '' }}>Bendahara</option>
                                            <option value="8" {{ $item->user_level == '8' ? 'selected' : '' }}>Pembukuan</option>
                                            <option value="9" {{ $item->user_level == '9' ? 'selected' : '' }}>Laporan</option>
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