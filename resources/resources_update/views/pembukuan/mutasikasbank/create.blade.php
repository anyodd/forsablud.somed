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
                                    <form action="{{ route('mutasikasbank.store') }}" method="POST">
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
                                                    <option value="{{ Tahun() }}">{{ Tahun() }}</option>
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
                                            <div class="col-md-10">
                                                <select id="Ko_unitstr" name="Ko_unitstr"
                                                    class="form-control select2 select2-danger @error('Ko_unitstr') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    <option value="{{ kd_unit() }}">{{ kd_unit() }}</option>

                                                </select>
                                                @error('Ko_unitstr')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank1">Bank Asal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Bank1" name="Ko_Bank1"
                                                    class="form-control select2 select2-danger @error('Ko_Bank1') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    @foreach ($refbank1 as $item)
                                                        <option value="{{ $item->Ko_Bank }}">{{ $item->Ur_Bank }}
                                                    @endforeach
                                                </select>
                                                @error('Ko_Bank1')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank2">Bank Tujuan</label>
                                            </div>
                                            <div class="col-md-10">

                                                <select id="Ko_Bank2" name="Ko_Bank2"
                                                    class="form-control select2 select2-danger @error('Ko_Bank2') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    {{-- <option value="0">--Pilih Bank Tujuan--</option> --}}
                                                    @foreach ($refbank2 as $item)
                                                        <option value="{{ $item->Ko_Bank }}">{{ $item->Ur_Bank }}
                                                    @endforeach
                                                </select>
                                                @error('Ko_Bank2')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="muta_Rp">Nilai</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" name="muta_Rp" placeholder="Nilai  Saldo Awal"
                                                    class="form-control @error('muta_Rp') is-invalid @enderror"
                                                    value="{{ old('muta_Rp') ?? '' }}">
                                                @error('muta_Rp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Tag">Status</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Tag" name="Tag"
                                                    class="form-control select2 select2-danger @error('Tag') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    {{-- <option value="" disabled>--Status--</option> --}}
                                                    <option value="0">Draft</option>
                                                    <option value="1">Final</option>
                                                </select>
                                                @error('Tag')
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
