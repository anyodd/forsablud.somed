<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah @yield('title')</h4>
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
                                    <form action="{{ route('pajakrinci.store') }}" method="POST">
                                        @csrf
                                        {{-- modal terima --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_byr">Kode/Periode/Unit</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="id_tax" id="id_tax" class="form-control"
                                                        value="{{ $tb_pajak->id_tax }}" readonly>
                                                    <input type="text" name="Ko_Period" id="Ko_Period"
                                                        class="form-control" value="{{ $tb_pajak->Ko_Period }}"
                                                        readonly>
                                                    <input type="text" name="Ko_unit1" id="Ko_unit1"
                                                        class="form-control" value="{{ $tb_pajak->Ko_unit1 }}"
                                                        readonly>
                                                    {{-- <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_terima">Cari!</button>
                                                        </span> --}}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Modal terima --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="taxtor_Rp">Nilai Setor</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="taxtor_Rp" placeholder="Nilai Pajak (Rp) "
                                                    class="form-control @error('taxtor_Rp') is-invalid @enderror"
                                                    value="{{ old('taxtor_Rp',$tb_pajak->tax_Rp) ?? '' }}">
                                                @error('taxtor_Rp')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank">Bank</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Bank" name="Ko_Bank"
                                                    class="form-control select2 select2-danger @error('Ko_Bank') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    @foreach ($kobank as $item)
                                                        <option value="{{ $item->Ko_Bank }}"
                                                            {{ old('Ko_Bank') == $item->Ur_Bank ? 'selected' : '' }}>
                                                            {{ $item->Ur_Bank }}</option>
                                                    @endforeach

                                                </select>
                                                @error('Ko_Bank')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_ntpn">No. NTPN</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="No_ntpn" placeholder="Nomor NTPN"
                                                class="form-control @error('No_ntpn') is-invalid @enderror"
                                                    value="{{ old('No_ntpn') ?? '' }}">
                                                @error('No_ntpn')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="fas fa-save"></i> Save
                                            </button>
                                            <a href="{{ old('url_asal') ?? url()->previous() }}"
                                                class="btn btn-outline-success float-right">
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

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
