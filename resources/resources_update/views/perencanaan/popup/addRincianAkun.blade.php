<div class="modal fade" id="modal-rincianAkun">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Rincian Akun</h4>
          </button>
        </div>
        <form action="{{ route('r_akun.store') }}" method="POST">
            @csrf
        <div class="modal-body">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">No. Rincian</label>
                                    <div class="col-sm-2">
                                        <input type="number" min="1" max="500" name="Ko_Rc" class="form-control @error('Ko_Rc') is-invalid @enderror" value="{{ $max+1 }}" required>

                                        <input type="text" name="Ko_Period" class="form-control" value="{{ $dt[0]['Ko_Period'] }}" hidden>
                                        <input type="text" name="ko_unit1" class="form-control" value="{{ $dt[0]['ko_unit1'] }}" hidden>
                                        <input type="text" name="Ko_sKeg1" class="form-control" value="{{ $dt[0]['Ko_sKeg1'] }}" hidden>
                                        <input type="text" name="Ko_sKeg2" class="form-control" value="{{ $dt[0]['Ko_sKeg2'] }}" hidden>
                                        <input type="text" name="Ko_Rkk" class="form-control" value="{{ $dt[0]['Ko_Rkk'] }}" hidden>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Sumber Dana</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2 @error('Ko_Pdp') is-invalid @enderror" name="Ko_Pdp" style="width: 100%;" required>
                                            <option selected="selected" value="">-- Pilih Sumber Dana--</option>
                                            @foreach ($jp as $item)
                                                <option value="{{ $item->Ko_Pdp }}">{{ $item->Ur_Pdp }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Ko_Pdp')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Uraian Rincian</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control @error('Ur_Rc1') is-invalid @enderror" name="Ur_Rc1" rows="3" placeholder="" required></textarea>
                                    </div>
                                    @error('Ur_Rc1')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Volume</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="V_1" class="form-control @error('V_1') is-invalid @enderror" id="V_1" onkeyup="total()" autocomplete="off">
                                    </div>
                                    @error('V_1')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="V_sat" class="form-control @error('V_sat') is-invalid @enderror" required autocomplete="off">
                                    </div>
                                    @error('V_sat')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Harga Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="Rp_1" class="form-control decimal @error('Rp_1') is-invalid @enderror" id="Rp_1" onkeyup="total()" required autocomplete="off">
                                    </div>
                                    @error('Rp_1')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: right" for="Kode Akun" class="col-sm-2 col-form-label">Jumlah Harga</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="To_Rp" id="To_Rp" class="form-control text-right" readonly>
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