<div class="modal fade" id="modal_rekening">
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
                            <div class="card card-info">

                                <div class="card-body">
                                    <table id="rekening" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama Rekeing</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rekening as $item)
                                                <tr>
                                                    <td class="text-center" style="width: 4%">{{ $loop->iteration }}.</td>
                                                    <td>{{ $item->rkk }}</td>
                                                    <td>{{ $item->ur_rkk }}</td>
                                                    <td class="text-center" style="width: 4%">
                                                        <button class="btn btn-warning btn-xs py-0" title="Pilih data"
                                                            id="pilihrek" data-dismiss="modal"
                                                            data-rkk="{{ $item->rkk }}"
                                                            data-ur_rkk="{{ $item->ur_rkk }}">
                                                            <i class="fa fa-choose"> </i>Pilih
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>