<div class="modal fade" id="modalListBernomor">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Usulan yang sudah Bernomor</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover example1">
          <thead class="thead-light">
            <tr>
              <!-- <th class="text-center" style="width: 10%;">Tahun</th> -->
              <th class="text-center" style="vertical-align: middle;">Nomor Usulan</th>
              <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
              <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
              <th class="text-center" style="vertical-align: middle;">Uraian Otorisasi</th>
              <th class="text-center" style="vertical-align: middle;">Nilai Usulan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>

            @if($otorisasi2->count() > 0)
            @foreach ($otorisasi2 as $number => $otorisasi2)
            <tr>
              <!-- <td class="text-center">{{$otorisasi2->Ko_Period}}</td>                        -->
              <td>{{$otorisasi2 ->No_SPi}}</td>                      
              <td>{{$otorisasi2 ->No_oto}}</td>                      
              <td class="text-center">{{ date('d M Y', strtotime($otorisasi2->Dt_oto)) }}</td>                      
              <td>{{$otorisasi2 ->Ur_oto}}</td>                      
              <td class="text-right">{{ number_format($otorisasi2 ->Jumlah, 2, ',', '.') }}</td>   
              <td>
                <div class="row justify-content-center" >
                  <div class="row">
                    <div class="col-sm-6">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditOtoBernomor{{ $otorisasi2->id }}" data-backdrop="static" title="Edit">
                        <i class="fas fa-edit"></i> 
                      </button>
                    </div>
                    @if($otorisasi2->id_byro == NULL)
                    <div class="col-sm-6">
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalHapusOtoBernomor{{ $otorisasi2->id }}" data-backdrop="static" title="Hapus">
                        <i class="fas fa-trash-alt"></i> 
                      </button>
                    </div>
                    @else
                    <div class="col-sm-6">
                      <button class="btn btn-danger" disabled="">
                        <i class="fas fa-trash-alt"></i> 
                      </button>
                    </div>
                    @endif
                  </div>
                </div>
              </td>    
            </tr>
            @include('otorisasi.penomoran.popup.otorisasi_bernomor_edit')
            @include('otorisasi.penomoran.popup.otorisasi_bernomor_hapus')
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