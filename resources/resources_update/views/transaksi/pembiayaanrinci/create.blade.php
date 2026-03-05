<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')  {{ $tb_bp[0]->Ur_bp ?? 'BLUD '}}</h4>
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
                                <form action="{{ route('pembiayaanrinci.store') }}" method="POST" >
                                    @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Period">K. BP & Per</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="id_bp" id="id_bp" class="form-control"  value="{{ $tb_bp->id_bp }}" readonly>
                                                <input type="text"  name="Ko_Period" id="Ko_Period" class="form-control"  value="{{ $tb_bp->Ko_Period }}" readonly>

                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_unit1">Ref Unit & Nomer</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="Ko_unit1" id="Ko_unit1" class="form-control"  value="{{ $tb_bp->Ko_unit1 }}" readonly>
                                                <input type="text"  name="No_bp" id="No_bp" class="form-control"  value="{{ $tb_bp->No_bp }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_bprc">No BP Rinci</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number"  name="Ko_bprc" id="Ko_bprc" class="form-control" value="{{$max+1}}" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ur_bprc">Uraian BP Rinci</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="Ur_bprc" id="Ur_bprc" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="rftr_bprc">Bukti Transfer</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="rftr_bprc" id="rftr_bprc" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="dt_rftrbprc">Tanggal Transfer</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date"  name="dt_rftrbprc" id="dt_rftrbprc" class="form-control" value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_PD">Nomor Penerimaan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="No_PD" id="No_PD" class="form-control">
                                            </div>
                                        </div>
                                        {{-- modal Kegiatan APBD --}}
                                        <div class="row form-group">
                                            <div class="col-sm-2">
                                                <label for="sKo_sKeg1">Nomor Keg APBD</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="sKo_sKeg1" name="sKo_sKeg1" readonly>
                                                    <span class="input-group-append">
                                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_kegiatan">Cari!</button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="sKo_sKeg2" name="sKo_sKeg2" readonly>
                                                        {{-- <input type="text" class="form-control" id="nm_rek" name="nm_rek" readonly> --}}

                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="Ko_Rkk"  name="Ko_Rkk" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="ur_skeg">Kegiatan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" id="ur_skeg"  name="ur_skeg" readonly>
                                            </div>
                                        </div>
                                        {{-- END MODAL Kegiatan APBD--}}

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                    <label for="To_Rp">Nilai</label>
                                            </div>
                                            <div class="col-md-10">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="To_Rp" name="To_Rp"  placeholder="Nilai pembiayaan">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                    <label for="ko_kas">Kode Kas/Bank</label>
                                            </div>
                                            <div class="col-md-10">
                                                    <select id="ko_kas" name="ko_kas" class="form-control select2 select2-danger @error('ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option value="" disabled>--Pilih Cara Pembayaran--</option>
                                                            @foreach ($kobank as $item)
                                                                <option value="{{$item->Ko_Bank}}">{{$item->Ur_Bank}} - (Rek: {{$item->No_Rek}} )</option>
                                                            @endforeach
                                                    </select>
                                                    @error('ko_kas')
                                                        <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror

                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button class="btn btn-success float-right" data-dismiss="modal">
                                                <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                                            </button>
                                        </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
                {{-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->






