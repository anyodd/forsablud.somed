<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Penyesuaian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">

                                <div class="card-body">
                                    <form action="{{ route('penyesuaian.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Sesuai_Ur">Nomor Penyesuaian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="Sesuai_No" placeholder="Nomor Penyesuaian" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Sesuai_Ur">Tanggal Penyesuaian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date" name="dt_sesuai" class="form-control" required value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_jr">Jenis Jurnal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="Ko_jr" name="Ko_jr"
                                                    class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                    <option value="">--Pilih Jenis Jurnal--</option>
                                                    @foreach ($pf_sesuai as $item)
                                                        <option value="{{ $item->id_sesuai }}">{{ $item->Ur_sesuai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Sesuai_Ur">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="Sesuai_Ur" cols="30" rows="3" placeholder="Uraian Penyesuaian" required></textarea>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button class="btn btn-success float-right" data-dismiss="modal" id="back">
                                                <i class="far fa-arrow-alt-circle-left"></i> Kembali
                                            </button>
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