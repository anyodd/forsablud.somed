<div class="modal fade" id="modalSetujuBatal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Usulan yang sudah Bernomor</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover example1">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width: 5%;">#</th>
              <th class="text-center" style="vertical-align: middle;">Nomor Usulan</th>
              <th class="text-center" style="vertical-align: middle;">Tanggal Usulan</th>
              <th class="text-center" style="vertical-align: middle;">Uraian Usulan</th>
              <th class="text-center" style="vertical-align: middle;">Nilai Usulan</th>
              <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>

            @if($otorisasi_blm_nomor->count() > 0)
            @foreach ($otorisasi_blm_nomor as $number => $otorisasi_blm_nomor)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>                      
              <td>{{$otorisasi_blm_nomor ->No_SPi}}</td>                      
              <td class="text-center">{{ date('d M Y', strtotime($otorisasi_blm_nomor->Dt_SPi)) }}</td>                      
              <td>{{$otorisasi_blm_nomor ->Ur_SPi}}</td>                      
              <td class="text-right">{{ number_format($otorisasi_blm_nomor->Jumlah, 2, ',', '.') }}</td>                      
              <td class="text-center">{{ date('d M Y', strtotime($otorisasi_blm_nomor ->otodated_at)) }}</td>                      
              <td>
                <div class="row justify-content-center" >
                  <div class="row">
                    <div class="col-sm-6">
                      <form action="{{route('otorisasi_batal',$otorisasi_blm_nomor->id)}}" method="get">
                        <button type="submit" class="btn btn-sm btn-danger" name="submit">Batalkan
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </td>    
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="7">Tidak Ada Data</td>
            </tr>
            @endif
          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>  