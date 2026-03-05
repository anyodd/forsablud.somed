<div class="modal fade" id="modal_stsbayaredit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Daftar Realisasi Penerimaan @yield('title') </h4>
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
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Bayar</th>
                                                <th>Tgl Bayar</th>
                                                <th>Uraian</th>
                                                <th>No Bukti Terima</th>
                                                {{-- <th>Nilai</th> --}}
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        {{-- @if (count($saldo ?? '') > 0) --}}
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($nobayar as $dt)
                                                <tr>
                                                    <td style="text-align: center;max-width: 50px;">
                                                        {{ $no++ }}.</td>
                                                    <td>{{ $dt->No_byr }}</td>
                                                    <td class="text-center">{{ date('d M Y', strtotime($dt->dt_byr)) }}</td>                      
                                                    <td>{{ $dt->Ur_byr }}</td>
                                                    <td>{{ $dt->No_bp }}</td>
                                                    <td>
                                                        <button class="btn btn-warning btn-xs py-0" title="Pilih data"
                                                            id="edit" data-dismiss="modal"
                                                            data-no_bayar="{{$dt->No_byr}}" ><i
                                                                style='font-size:8px' class="fa fa-choose">
                                                            </i>Pilih</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- @endif --}}
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
