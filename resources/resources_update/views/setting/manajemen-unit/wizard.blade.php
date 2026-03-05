<h3>Input SKPD</h3>
<fieldset>
    <div class="row">
        <div class="col-12 m-auto">
            <div class="container-fluid">
                <h4 class="multisteps-form__title">Input SKPD</h4>
                <div class="form-group row border-bottom">
                    <label class="col-sm-3 text-left">Urusan Pemerintahan</label>
                    <label class="col-sm-9 text-left font-weight-bold">: {{ $model->urusan->nmurusan }}</label>
                </div>
                <div class="form-group row border-bottom">
                    <label class="col-sm-3 text-left">Bidang</label>
                    <label class="col-sm-9 text-left font-weight-bold">: {{ $model->nmbidang }}</label>
                </div>
            </div>
            <div class="container-fluid bg-light p-3">
                <div class="form-group row">
                    <label class="col-sm-3 text-left col-form-label">Tahun SKPD</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="tahun_skpd" placeholder="masukkan tahun SKPD" value="{{ session('tahun_anggaran') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 text-left col-form-label">Kode SKPD</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="kdskpd" placeholder="masukkan kode SKPD">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 text-left col-form-label">Nama SKPD</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="nmskpd" placeholder="masukkan nama SKPD">
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<h3>Input Unit</h3>
<fieldset>
    <div class="row">
        <div class="col-12 m-auto">
            <div class="container-fluid">
                <h4 class="multisteps-form__title">Input Unit</h4>
                <div class="form-group row border-bottom">
                    <label class="col-sm-3 text-left">Urusan Pemerintahan</label>
                    <label class="col-sm-9 text-left font-weight-bold">: {{ $model->urusan->nmurusan }}</label>
                </div>
                <div class="form-group row border-bottom">
                    <label class="col-sm-3 text-left">Bidang</label>
                    <label class="col-sm-9 text-left font-weight-bold">: {{ $model->nmbidang }}</span></label>
                </div>
                <div class="form-group row border-bottom">
                    <label class="col-sm-3 text-left">Nama SKPD</label>
                    <label class="col-sm-9 text-left font-weight-bold">: <span id="modal-info-skpd"></span></label>
                </div>
            </div>
            <div class="container-fluid bg-light p-3">
                <div class="repeater-custom-show-hide">
                    <div data-repeater-list="unit">
                        <div data-repeater-item>
                            <div class="form-group row d-flex align-items-end">
                                <div class="col-sm-2">
                                    <label class="control-label font-9">Tahun Unit</label>
                                    <input type="text" name="tahun" class="form-control" required value="{{ session('tahun_anggaran') }}">
                                </div>
                                <!--end col-->

                                <div class="col-sm-2">
                                    <label class="control-label font-10">Kode Unit</label>
                                    <input type="text" name="kdunit" class="form-control" required>
                                </div>
                                <!--end col-->

                                <div class="col-sm-7">
                                    <label class="control-label font-10">Nama Unit</label>
                                    <input type="text" name="nmunit" class="form-control" required>
                                </div>
                                <!--end col-->

                                <div class="col-sm-1">
                                    <span data-repeater-delete="" class="btn btn-danger">
                                        <span class="far fa-trash-alt mr-1"></span>
                                    </span>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end /div-->
                    </div>
                    <span data-repeater-create="" class="btn btn-secondary btn-block">
                        <span class="fas fa-plus"></span> Tambah Field Unit
                    </span>
                </div>
                <!--end repeter-->
            </div>
        </div>
    </div>
</fieldset>
