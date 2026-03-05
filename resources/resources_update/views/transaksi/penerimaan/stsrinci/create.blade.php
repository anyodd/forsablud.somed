<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title') {{ $tb_sts[0]->Ur_sts ?? 'BLUD '}}</h4>
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
                                <form action="{{ route('stsrinci.store') }}" method="POST">
                                    @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Period">Nomor STS</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="No_sts" id="No_sts" class="form-control"  value="{{ $tb_sts->No_sts }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_stsrc">No STS Rinci</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="Ko_stsrc" id="Ko_stsrc" class="form-control" value="{{$max+1}}" readonly>
                                                <input type="text"  name="id_sts" id="id_sts" class="form-control" value="{{$id_sts}}" hidden>
                                            </div>
                                        </div>

                                         {{-- modal rekening --}}

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                    <label for="No_byr">Kode Bayar STS</label>
                                            </div>
                                            <div class="col-md-10">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" id="No_byr" name="No_byr" readonly>
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_stsbayar">Cari!</button>
                                                        </span>
                                                    </div>
                                            </div>
                                        </div>

                                        {{-- Modal rekening --}}
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button class="btn btn-success float-right" data-dismiss="modal">
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
