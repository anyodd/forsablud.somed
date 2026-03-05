<div class="modal fade" id="edit_akun{{$item->id}}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Akun</h4>
          </button>
        </div>
        <form action="{{route('akun.update',$item->id)}}" method="post">
            @method('PATCH')
            @csrf
        <div class="modal-body">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="Kode Akun" class="col-sm-2 col-form-label">Kode Akun</label>
                                    <div class="col-sm-1">
                                        <input type="text" name="Ko_sKeg1" class="form-control" value="{{ $Ko_sKeg1 }}" hidden>
                                        <input type="text" name="Ko_sKeg2" class="form-control" value="{{ $Ko_sKeg2 }}" hidden>
                                        <input type="text" name="Ko_KegBL1" class="form-control" value="{{ $Ko_KegBL1 }}" hidden>
                                        <input type="text" id="rk1_e{{$item->id}}" name="Ko_Rk1" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" id="rk2_e{{$item->id}}" name="Ko_Rk2" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" id="rk3_e{{$item->id}}" name="Ko_Rk3" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" id="rk4_e{{$item->id}}" name="Ko_Rk4" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" id="rk5_e{{$item->id}}" name="Ko_Rk5" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" id="rk6_e{{$item->id}}" name="Ko_Rk6" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-listAkun_edit" id="cedit" data-idmod = "{{$item->id}}"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Kode Akun" class="col-sm-2 col-form-label">Nama Akun</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('Ur_Rc') is-invalid @enderror" id="ur_rk6_e{{$item->id}}" name="Ur_Rc" rows="3" placeholder="" readonly>{{ $item->Ur_Rc }}</textarea>
                                    </div>
                                    @error('Ur_Rc')
                                        <div class="invalid-feedback"> {{ $message }}</div>
                                    @enderror
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