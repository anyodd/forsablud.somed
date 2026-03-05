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
                                    <form action="{{ route('saldoawal.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="soaw_Rp">Nilai</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="soaw_Rp" placeholder="Nilai Saldo Awal" class="form-control desimal" value="{{ old('soaw_Rp') ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Tag">Status</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select id="Tag" name="Tag" class="form-control" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                    <option value="">--Pilih Status--</option>
                                                    <option value="0">Draft</option>
                                                    <option value="1">Final</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="nourek">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" id="kd_rkk" name="Ko_rkk5" required>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat"
                                                            data-toggle="modal"
                                                            data-target="#modal_rekening">Cari!
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                                            <a href="#" data-dismiss="modal"class="btn btn-success float-right"> <i class="far fa-arrow-alt-circle-left"> Back</i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
