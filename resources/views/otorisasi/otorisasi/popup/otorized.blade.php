<div class="modal fade" id="oto{{ $otorisasi->id }}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Usulan Nomor {{ $otorisasi->No_SPi }}</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover example1">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="vertical-align: middle;">#</th>
              <th class="text-center" style="vertical-align: middle;">Nomor Bukti</th>
              <th class="text-center" style="vertical-align: middle;">Ref</th>
              <th class="text-center" style="vertical-align: middle;">Uraian</th>
              <th class="text-center" style="vertical-align: middle;">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @if($rincian->where('No_spi', $otorisasi->No_SPi)->count() > 0)
            @foreach ($rincian->where('No_spi', $otorisasi->No_SPi) as $number => $rincian)
            <tr>
              <td class="text-center">{{$rincian->Ko_spirc}}</td>                       
              <td>{{$rincian ->No_bp}}</td>                      
              <td>{{$rincian ->rftr_bprc}}</td>                      
              <td>{{$rincian ->Ur_bprc}}</td>   
              <td class="text-right">{{ number_format($rincian ->spirc_Rp, 2, ',', '.') }}</td>                    
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6">Tidak Ada Data</td>
            </tr>
            @endif
          </tbody>
          <tfoot class="thead-light">
            <tr class=" font-weight-bold">
              <td></td>                       
              <td class="text-center" colspan="3">Jumlah</td>                      
              <td class="text-right">{{ number_format($rincian->where(['No_spi' => $otorisasi->No_SPi, 'Ko_unitstr' => kd_unit(), 'Ko_Period' => Tahun() ])->sum('spirc_Rp'), 2, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
        <form action="{{ route('otorisasi.update', $otorisasi->id) }}" method="post">
          @csrf
          @method("PUT")
        <div class="col-sm-12">
          <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
            <div class="col-sm-10">
              <input type="date" name="Dt_oto" class="form-control @error('Dt_oto') is-invalid @enderror" min="{{ $otorisasi ->Dt_SPi }}" max="{{ Tahun().'-12-31' }}" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-outline-success" name="submit" value=""><i class="fas fa-check"></i> Setuju</button>
        </form>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>  