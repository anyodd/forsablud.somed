<div class="modal fade" id="modal_rekening">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Kode Rekening Utang @yield('title') </h4>
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
                                    <table id="example5" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Uraian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rkk6 as $item)
                                                <tr>
                                                    <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                                                    <td>{{ $item->RKK6 }}</td>
                                                    <td>{{ $item->ur_rk6 }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-info btn-xs py-0" title="Pilih data" id="pilihrek" data-dismiss="modal"
                                                            data-kd_rek="{{ $item->RKK6 }}"
                                                            data-nm_rek="{{ $item->ur_rk6 }}">
                                                            <i style='font-size:8px' class="fa fa-check"> </i> Pilih
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
