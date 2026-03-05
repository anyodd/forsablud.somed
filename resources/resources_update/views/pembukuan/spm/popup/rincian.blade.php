<div class="modal fade" id="rincian">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold">Data Transaksi</h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped table-hover" id="dtrincian" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center">Nomor Pengajuan</th>
                          <th class="text-center" style="width: 3%">Tanggal Pengajuan</th>
                          <th class="text-center">Nomor Bukti</th>
                          <th class="text-center">Uraian</th>
                          <th class="text-center">Jumlah</th>
                          <th class="text-center"><input type="checkbox" id="checkall"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($rincian as $item)
                            <tr>
                                <td>{{ $item->No_SPi }}</td>
                                <td class="text-center">{{ $item->Dt_SPi }}</td>
                                <td>{{ $item->No_bp }}</td>
                                <td>{{ $item->Ur_bprc }}</td>
                                <td class="text-right">{{ number_format($item->spirc_Rp,2,',','.') }}</td>
                                <td class="text-center"><input class="check" type="checkbox" value="{{ $item->id }}"></td>
                            </tr>
                        @endforeach
                      </tbody>
                      <input type="text" value="{{ $dt_oto->id }}" id="id_spi" hidden>
                    </table>
                  </div>
                  <div class="form-group row justify-content-center mt-3">
                    <button  class="col-sm-2 btn btn-primary ml-3" data-dismiss="modal" onclick="getData()">
                    <i class="fas fa-check pr-2"></i>Pilih
                    </button>
                    <button type="button" class="col-sm-2 btn btn-danger ml-3" data-dismiss="modal" onclick="cancel()"><i class="fas fa-backward pr-2"></i>Kembali</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>