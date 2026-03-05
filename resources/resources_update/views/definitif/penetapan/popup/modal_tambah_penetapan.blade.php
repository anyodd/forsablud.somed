<div class="modal fade" id="modalTambahPenetapan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">TAMBAH PENETAPAN</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('penetapan.store') }}" method="post">
                                @csrf
                                @if(session('errors'))
                                <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                                    Something is wrong:
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class=" card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="noId" class="col-sm-3 col-form-label">No. Id</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" name="noId"
                                                            class="form-control @error('noId') is-invalid @enderror"
                                                            value="{{ old('noId') }}" id="noId">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kodePenetapanApbd" class="col-sm-3 col-form-label">Kode
                                                        Penetapan APBD</label>
                                                    <div class="col-sm-9">
                                                        <select id="kodePenetapanApbd" name="kodePenetapanApbd"
                                                            class="form-control">
                                                            <option value="" selected disabled>-- Pilih Kode Penetapan
                                                                APBD --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomorPenetapanApbd"
                                                        class="col-sm-3 col-form-label">Nomor Penetapan APBD</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nomorPenetapanApbd"
                                                            class="form-control @error('nomorPenetapanApbd') is-invalid @enderror"
                                                            value="{{ old('nomorPenetapanApbd') }}"
                                                            id="nomorPenetapanApbd">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggalPenetapanApbd"
                                                        class="col-sm-3 col-form-label">Tanggal Penetapan APBD</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="tanggalPenetapanApbd"
                                                            class="form-control @error('tanggalPenetapanApbd') is-invalid @enderror"
                                                            value="{{ old('tanggalPenetapanApbd') }}"
                                                            id="tanggalPenetapanApbd">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomorDipa" class="col-sm-3 col-form-label">Nomor
                                                        DPA</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nomorDipa"
                                                            class="form-control @error('nomorDipa') is-invalid @enderror"
                                                            value="{{ old('nomorDipa') }}" id="nomorDipa">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggalDipa" class="col-sm-3 col-form-label">Tanggal
                                                        DPA</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="tanggalDipa"
                                                            class="form-control @error('tanggalDipa') is-invalid @enderror"
                                                            value="{{ old('tanggalDipa') }}" id="tanggalDipa">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-1">
                                                <button type="submit"
                                                    class="btn btn-success btn-block px-0">Simpan</button>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-secondary btn-block px-0"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>