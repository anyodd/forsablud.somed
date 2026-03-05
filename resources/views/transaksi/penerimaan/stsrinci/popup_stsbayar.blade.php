<div class="modal fade" id="modal_stsbayar">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Daftar Realisasi Penerimaan </h4>
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
                                    <input type="text" name="id_rc" id="id_rc" hidden>
                                    <input type="text"  name="id_sts" id="id_sts" class="form-control" value="{{$id_sts}}" hidden>
                                    <input type="text"  name="No_sts" id="No_sts" class="form-control"  value="{{ $tb_sts->No_sts }}" hidden>
                                    <button type="submit" class="btn btn-sm btn-primary mb-2" id="submit"><i class="fa fa-save"> Simpan</i></button>
                                    <table id="exampl3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>No Bayar</th>
                                                <th>Tgl Bayar</th>
                                                <th>Uraian</th>
                                                <th>NIlai (Rp)</th>
                                                <th> 
                                                    @if (!empty($nobayar))
                                                    <input type="checkbox" id="checkall">
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nobayar as $item)
                                                <tr>
                                                    <td style="text-align: center;max-width: 50px;">
                                                        {{ $loop->iteration }}.</td>
                                                    <td>{{ $item->No_byr }}</td>
                                                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_byr)) }}</td>                      
                                                    <td>{{ $item->Ur_byr }}</td>
                                                    <td class="text-right">{{ number_format($item->total,0,'','.') }}</td>
                                                    <td class="text-center">
                                                        {{-- <button class="btn btn-warning btn-sm py-0" title="Pilih data"
                                                            id="pilih" data-dismiss="modal"
                                                            data-no_byr="{{ $item->No_byr }}"><i style='font-size:8px' class="fa fa-choose"></i>Pilih
                                                        </button> --}}
                                                        <input class="check" type="checkbox" value="{{ $item->id_byr }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- @endif --}}
                                        <tfoot>
                                        </tfoot>
                                    </table>
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
