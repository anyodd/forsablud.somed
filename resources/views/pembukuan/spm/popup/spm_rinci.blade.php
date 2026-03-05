<div class="modal fade" id="modalSpmRinci">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Realisasi Pencairan Dana</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover example1" width="100%" cellspacing="0">
            <thead class="thead-light">
              <tr>
                <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                {{-- <th class="text-center" style="vertical-align: middle;">Nomor Bukti Bayar</th> --}}
                <th class="text-center" style="vertical-align: middle;">Tanggal Pencairan Dana</th>
                <th class="text-center" style="vertical-align: middle;">Uraian</th>
                <th class="text-center" style="vertical-align: middle;">Bank Pembayar</th>
                <th class="text-center" style="vertical-align: middle;">Penerima</th>
                <th class="text-center" style="vertical-align: middle;">Pembayar</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              @if($spm->count() > 0)
              @foreach ($spm as $number => $spm)
              <tr>
                <td>{{$spm ->No_oto}}</td>                      
                {{-- <td>{{$spm ->No_byro}}</td>                       --}}
                <td class="text-center">{{ date('d M Y', strtotime($spm->dt_byro)) }}</td>                      
                <td>{{$spm ->Ur_byro}}</td>                      
                <td>{{$spm ->Ur_Bank}}</td>                      
                <td>{{$spm ->Nm_Bank}}-<br>No: {{$spm ->No_Rektuju}}</td>                      
                <td>{{$spm ->Nm_Byro}}</td>                      
                <td style="width: 10%">
                  <div class="row justify-content-center" >
                    <div class="col-sm-6">
                      <button class="btn btn-warning" type="" name="" value="" data-toggle="modal" data-target="#modalEditSpm{{ $spm->id_byro }}" data-backdrop="static" title="Edit">
                        <i class="fas fa-edit"></i> 
                      </button>
                    </div>
                    <div class="col-sm-6">
                      <button class="btn btn-danger" type="" name="" value="" data-toggle="modal" data-target="#modalHapusSpm{{ $spm->id_byro }}" data-backdrop="static" title="Hapus">
                        <i class="fas fa-trash-alt"></i> 
                      </button>
                    </div>
                  </div>
                </td>    
              </tr>
              @include('pembukuan.spm.popup.spm_edit')
              @include('pembukuan.spm.popup.spm_hapus')
              @endforeach
              @else
              <tr>
                <td colspan="6">Tidak Ada Data</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>  