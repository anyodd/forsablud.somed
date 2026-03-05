<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@yield('title')</h4>
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
                                    <form action="{{ route('koreksi.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Period">Periode</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Period" name="Ko_Period"
                                                    class="form-control select2 select2-danger @error('Ko_Period') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                                    <option value="2020">2020</option>

                                                </select>
                                                @error('Ko_Period')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_unitstr">Unit</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select id="Ko_unitstr" name="Ko_unitstr"
                                                    class="form-control select2 select2-danger @error('Ko_unitstr') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="{{ $unitstr }}">{{ $unitstr }}</option>

                                                </select>
                                                @error('Ko_unitstr')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="nm_unit"
                                                    class="form-control @error('nm_unit') is-invalid @enderror"
                                                    value="{{ $nm_unit ?? '' }}" readonly>
                                                @error('nm_unit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Koreksi">Kode Koreksi</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Koreksi" name="Ko_Koreksi"
                                                    class="form-control select2 select2-danger @error('Ko_Koreksi') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="0">--Pilih Kode--</option>
                                                    @foreach ($refkoreksi as $item)
                                                        <option value="{{ $item->Ko_Koreksi }}"
                                                            {{ old('Ko_Koreksi') == $item->Ko_Koreksi ? 'selected' : '' }}>
                                                            {{ $item->Ur_Koreksi }}</option>
                                                    @endforeach
                                                </select>
                                                @error('Ko_Koreksi')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>


                                        {{-- <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Koreksi_No">No</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" name="Koreksi_No" placeholder="Nomor koreksi "
                                                    class="form-control @error('Koreksi_No') is-invalid @enderror"
                                                    value="{{ old('Koreksi_No') ?? '' }}">
                                                @error('Koreksi_No')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Koreksi_Ur">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="Koreksi_Ur" placeholder="Uraian koreksi "
                                                    class="form-control @error('Koreksi_Ur') is-invalid @enderror"
                                                    value="{{ old('Koreksi_Ur') ?? '' }}">
                                                @error('Koreksi_Ur')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- modal spi --}}

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourut">Referensi SPJ</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" id="No_spi" name="No_spi">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal_spirc">Cari!</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourut">SPJ Rinci</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="Ko_spirc"
                                                        name="Ko_spirc" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourut">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class=" mt-2">
                                                    <input type="text" class="form-control" id="Ko_Rkk" name="Ko_Rkk"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Modal rekenig --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Korek_Rp">Nilai Koreksi</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" name="Korek_Rp" placeholder="Nilai koreksi "
                                                    class="form-control @error('Korek_Rp') is-invalid @enderror"
                                                    value="{{ old('Korek_Rp') ?? '' }}">
                                                @error('Korek_Rp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Korek_Tag">Kode Koreksi</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Korek_Tag" name="Korek_Tag"
                                                    class="form-control select2 select2-danger @error('Korek_Tag') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="" disabled>--Pilih Kode--</option>
                                                    <option value="1">Penambahan</option>
                                                    <option value="2">Pengurangan</option>

                                                </select>
                                                @error('Korek_Tag')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Save
                                            </button>
                                            <a href="{{ old('url_asal') ?? url()->previous() }}"
                                                class="btn btn-success float-right">
                                                <i class="far fa-arrow-alt-circle-left"> Back</i>
                                            </a>
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
