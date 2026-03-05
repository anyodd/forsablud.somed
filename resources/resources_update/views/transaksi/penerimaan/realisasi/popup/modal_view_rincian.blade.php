<div class="modal fade" id="modalRealisasiRincian{{ $realisasi->id_bp }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Realisasi</h4>
      </div>
            <div class="modal-body">
              <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                  <th class="text-center" style="vertical-align: middle;">Nomor Tagihan</th>
                  <th class="text-center" style="vertical-align: middle;">Period</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Pembayaran</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Bayar</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach($rincian as $r)
                  <tr>
                    <td class="text-center">{{ $r->No_bp }}</td>  
                    <td class="text-center">{{ $r->Ko_Period }}</td>                       
                    <td>{{ $r->No_byr }}</td>                      
                    <td>{{ $r->dt_byr }}</td>                      
                    <td>{{ $r->Ur_byr }}</td>                                       
                    <td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                      <button class="btn btn-danger btn-block px-0" data-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </div>
                <!-- /.card-footer--> 

        </div>
      </div>
</div>