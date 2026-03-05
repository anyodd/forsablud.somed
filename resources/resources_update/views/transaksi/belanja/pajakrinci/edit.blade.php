<div class="modal fade" id="modal_edit{{ $item->id_taxtor }}">
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
                                    <form
                                        action="{{ route('pajakrinci.update', ['pajakrinci' => $item->id_taxtor]) }}"
                                        method="POST">
                                        @method('PATCH')
                                        @csrf
                                        {{-- modal terima --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_byr">Kode/Periode/Unit</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="id_taxtored" id="id_taxtored"
                                                        class="form-control" value="{{ $item->id_taxtor }}"
                                                        readonly>
                                                    <input type="text" name="Ko_Perioded" id="Ko_Perioded"
                                                        class="form-control" value="{{ $item->Ko_Period }}"
                                                        readonly>
                                                    <input type="text" name="Ko_unit1ed" id="Ko_unit1ed"
                                                        class="form-control" value="{{ $item->Ko_unit1 }}" readonly>

                                                </div>
                                            </div>
                                        </div>
                                        {{-- Modal terima --}}
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="taxtor_Rped">Nilai Setor</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" name="taxtor_Rped" placeholder="Nilai Pajak (Rp) "
                                                    class="form-control @error('taxtor_Rped') is-invalid @enderror"
                                                    value="{{ $item->taxtor_Rp }}">
                                                @error('taxtor_Rped')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Banked">Bank</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Banked" name="Ko_Banked"
                                                    class="form-control select2 select2-danger @error('Ko_Banked') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    autofocus>
                                                    @foreach ($kobank as $dt)
                                                        <option value="{{ $dt->Ko_Bank }}" {{$item->Ko_Bank == $dt->Ko_Bank ? 'selected' : ''}}>
                                                            {{ $dt->Ur_Bank }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('Ko_Banked')
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
                                                    value="{{ $item->No_ntpn }}">
                                                @error('No_ntpn')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button type="button" class="btn btn-info float-right" data-dismiss="modal">
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
