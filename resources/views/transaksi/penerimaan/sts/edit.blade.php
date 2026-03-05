<div class="modal fade" id="modal-edit{{$item->id_sts}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> @yield('title') Edit</h4>
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
                                    <form action="{{ route('sts.update', ['st' => $item->id_sts]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_stsedit">Nomor STS</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="No_stsedit" name="No_stsedit"
                                                    placeholder="Nomor STS "
                                                    class="form-control @error('No_stsedit') is-invalid @enderror"
                                                    value="{{ old('No_stsedit',$item->No_sts) ?? '' }}">
                                                @error('No_stsedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="text" name="id_sts" id="id_sts"
                                                class="form-control @error('id_sts') is-invalid @enderror"
                                                value="{{ $item->id_sts }}" hidden>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="dt_stsedit">Tanggal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date" name="dt_stsedit" id="dt_stsedit"
                                                    placeholder="Nomor STS "
                                                    class="form-control @error('dt_stsedit') is-invalid @enderror"
                                                    value="{{ old('dt_stsedit',$item->dt_sts) ?? '' }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                @error('dt_stsedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ur_stsedit">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="Ur_stsedit" id="Ur_stsedit"
                                                    placeholder="Uraian STS "
                                                    class="form-control @error('Ur_stsedit') is-invalid @enderror"
                                                    value="{{ old('Ur_stsedit',$item->Ur_sts) ?? '' }}">
                                                @error('Ur_stsedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Nm_Benedit">Nama Bendahara</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <input type="text" name="Nm_Benedit" id="Nm_Benedit"
                                                    placeholder="Nama Bendahara "
                                                    class="form-control @error('Nm_Benedit') is-invalid @enderror"
                                                    value="{{ old('Nm_Benedit',$item->Nm_Ben) ?? '' }}"> --}}
                                                    <select class="form-control select2 @error('Nm_Ben') is-invalid @enderror" name="Nm_Benedit" id="editpegawai">
                                                        {{-- <option value="">-- Pilih Bendahara --</option> --}}
                                                        @foreach ($pegawai as $list)
                                                            @if ($list->nama != $item->Nm_Ben)
                                                                @if ($loop->first)
                                                                <option value="{{$item->Nm_Ben}}|{{$item->NIP_Ben}}">{{$item->Nm_Ben}}</option>
                                                                @endif
                                                            @endif
                                                            <option value="{{$list->nama}}|{{$list->nip}}" {{$list->nama == $item->Nm_Ben ? 'selected' : ''}}>{{$list->nama}} ({{$list->jabatan}})</option>
                                                        @endforeach
                                                    </select>
                                                @error('Nm_Benedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="NIP_Beneditedit">NIP</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="NIP_Benedit" id="NIP_Benedit"
                                                    placeholder="NIP Bendahara"
                                                    class="form-control @error('NIP_Benedit') is-invalid @enderror"
                                                    value="{{ old('NIP_Benedit',$item->NIP_Ben) ?? '' }}" readonly>
                                                @error('NIP_Benedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank">Bank Tujuan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="Ko_Bankedit" class="select3">
                                                    <option value="" selected>-- Pilih Bank --</option>
                                                    @foreach ($bank as $bank)
                                                        <option value="{{ $bank->Ko_Bank }}" {{ $bank->Ko_Bank == $item->Ko_Bank ? 'selected' : '' }}>{{ $bank->No_Rek }} - {{ $bank->Ur_Bank }}
                                                            @if ($bank->Tag == 1)
                                                            (Rekening Utama)
                                                            @elseif($bank->Tag == 2)
                                                            (Rekening Bendahara Pengeluaran)
                                                            @elseif($bank->Tag == 3)
                                                            (Rekening Bendahara Penerimaan)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('Ko_Bank')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
