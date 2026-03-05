<div class="modal fade" id="modal-editPenerimaan{{$item->id_bp}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@yield('title') Penerimaan</h4>
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
                                    <form action="{{ route('pembiayaan.update', $item->id_bp) }}" method="POST">
                                        @csrf
                                        @method("PUT")
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_bp">Kode Pembiayaan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_bp" name="Ko_bp"
                                                    class="form-control select2 select2-danger @error('Ko_bp') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="" disabled>--Pilih Kode pembiayaan--</option>
                                                    @foreach ($pfbp as $dt)
                                                        <option value="{{ $dt->ko_bp }}"
                                                            {{ $dt->ko_bp == $item->Ko_bp ? 'selected' : '' }}>
                                                            {{ $dt->Ur_bp }}</option>
                                                    @endforeach
                                                </select>
                                                @error('Ko_bp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_bp">No Pembiayaan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="No_bp" placeholder="No Bukti"
                                                    class="form-control @error('No_bp') is-invalid @enderror"
                                                    value="{{ old('No_bp', $item->No_bp) ?? '' }}">
                                                @error('No_bp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="dt_bp">Tanggal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date" name="dt_bp" placeholder="Tanggal "
                                                    class="form-control @error('dt_bp') is-invalid @enderror"
                                                    value="{{ old('dt_bp', $item->dt_bp) ?? '' }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                @error('dt_bp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ur_bp">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="Ur_bp" placeholder="Uraian BP "
                                                    class="form-control @error('Ur_bp') is-invalid @enderror"
                                                    value="{{ old('Ur_bp', $item->Ur_bp) ?? '' }}">
                                                @error('Ur_bp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nm_BUcontr">Pihak Ke 3</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="nm_BUcontr" placeholder="Nama Pihak ketiga"
                                                    class="form-control @error('nm_BUcontr') is-invalid @enderror"
                                                    value="{{ old('nm_BUcontr', $item->nm_BUcontr) ?? '' }}">
                                                @error('nm_BUcontr')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="adr_bucontr">Alamat Pihak Ke 3</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="adr_bucontr" placeholder="Alamat Pihak ketiga"
                                                    class="form-control @error('adr_bucontr') is-invalid @enderror"
                                                    value="{{ old('adr_bucontr', $item->adr_bucontr) ?? '' }}">
                                                @error('adr_bucontr')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Nm_input">Petugas Input</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <input type="text" name="Nm_input"
                                                    placeholder="Petugas  input data pembiayaan"
                                                    class="form-control @error('Nm_input') is-invalid @enderror"
                                                    value="{{ old('Nm_input', $item->Nm_input) ?? '' }}"> --}}
                                                <select class="form-control select2  @error('Nm_input') is-invalid @enderror" name="Nm_input">
                                                    @foreach ($pegawai as $ls)
                                                        <option value="{{$ls->nama}}" {{$ls->nama == $item->Nm_input ? 'selected' : ''}}>{{$ls->nama}} ({{$ls->jabatan}})</option>
                                                    @endforeach
                                                </select>
                                                @error('Nm_input')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Modal rekenig --}}
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button data-dismiss="modal"
                                                class="btn btn-success float-right">
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
