<div class="modal fade" id="modal-edit">
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
                                    <form
                                        action="{{ route('mutasikasbank.update', ['mutasikasbank' => $mutabank[0]->id]) }}"
                                        method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank1edit">Bank Asal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Bank1edit" name="Ko_Bank1edit"
                                                    class="form-control select2 select2-danger @error('Ko_Bank1edit') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">

                                                    @foreach ($refbank1 as $item)
                                                        <option value="{{ $item->Ko_Bank }}"
                                                            {{ $item->Ko_Bank == $mutabank[0]->Ko_Bank1 ? 'selected' : '' }}>
                                                            {{ $item->Ur_Bank }}
                                                    @endforeach

                                                </select>
                                                @error('Ko_Bank1edit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank2edit">Bank Tujuan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_Bank2edit" name="Ko_Bank2edit"
                                                    class="form-control select2 select2-danger @error('Ko_Bank2edit') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    @foreach ($refbank2 as $item)
                                                        <option value="{{ $item->Ko_Bank }}"
                                                            {{ $item->Ko_Bank == $mutabank[0]->Ko_Bank2 ? 'selected' : '' }}>
                                                            {{ $item->Ur_Bank }}
                                                    @endforeach
                                                </select>
                                                @error('Ko_Bank2edit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="muta_Rpeditedit">Nilai</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" id="muta_Rpedit" name="muta_Rpedit"
                                                    placeholder="Nilai  Saldo Awal"
                                                    class="form-control @error('muta_Rpedit') is-invalid @enderror"
                                                    value="{{ old('muta_Rpedit') ?? '' }}">
                                                @error('muta_Rpedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Tagedit">Status</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Tagedit" name="Tagedit"
                                                    class="form-control select2 select2-danger @error('Tagedit') is-invalid @enderror"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">

                                                    <option value="{{ 1 == $mutabank[0]->Tag ? 'selected' : '' }}">
                                                        Draft</option>
                                                    <option value="{{ 2 == $mutabank[0]->Tag ? 'selected' : '' }}">
                                                        Final</option>

                                                </select>
                                                @error('Tagedit')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Update
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
