<div class="modal fade" id="modal_rekeningedit">
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
                                <div class="card-body">
                                    <table id="example4" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama Rekeing</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rkk5 as $rkk)
                                                <tr>
                                                    <td class="text-center" style="width: 2%">{{ $loop->iteration }}.</td>
                                                    <td>{{ $rkk->ko_rek5 }}</td>
                                                    <td>{{ $rkk->Ur_Rk5 }}</td>
                                                    <td class="text-center" style="width: 3%">
                                                        <button class="btn btn-warning btn-xs py-0" title="Pilih data"
                                                            id="pilihedit" data-dismiss="modal"
                                                            data-kd_rekedit="{{ $rkk->ko_rek5 }}">
                                                            <i style='font-size:8px' class="fa fa-choose"> </i>Pilih
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
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
