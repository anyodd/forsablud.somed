<div class="modal fade" id="realisasi">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">TAMBAH REALISASI</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                        <thead class="thead-light">
                          <tr>
                            <th class="text-center" style="width: 5%;">No Rincian</th>
                            <th class="text-center" style="vertical-align: middle;">No Bukti</th>
                            <th class="text-center" style="vertical-align: middle;">Uraian</th>
                            <th class="text-center" style="vertical-align: middle;display: none;">No Ref. </th>
                            <th class="text-center" style="vertical-align: middle;display: none;">Tanggal Ref. </th>
                            <th class="text-center" style="vertical-align: middle; middle;display: none;">Kode Sub Kegiatan</th>
                            <th class="text-center" style="vertical-align: middle; middle;display: none;">Kode Aktivitas</th>
                            <th class="text-center" style="vertical-align: middle; middle;display: none;">Kode Akun</th>
                            <th class="text-center" style="vertical-align: middle;">Saldo Piutang (Rp)</th>
                            <th class="text-center" style="vertical-align: middle;">Bayar Piutang (Rp)</th>
                            <th class="text-center" style="vertical-align: middle;display: none;">id_bprc</th>
                            <th class="text-center" style="vertical-align: middle;">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($rincian as $item)
                          <tr>
                            <td class="text-center" style="vertical-align: middle;">{{ $item->Ko_bprc }}</td>                       
                            <td class="text-center" style="vertical-align: middle;">{{ $item->No_bp }}</td>                      
                            <td style="vertical-align: middle;">{{ $item->Ur_bprc }}</td>                      
                            <td class="text-center" style="vertical-align: middle;display: none;">{{ $item->rftr_bprc }}</td>                      
                            <td class="text-center" style="vertical-align: middle;display: none;">{{ date('d M Y', strtotime($item->dt_rftrbprc)) }}</td>                      
                            <td style="vertical-align: middle;display: none;">{{ $item->Ko_sKeg1 }}</td>                      
                            <td style="vertical-align: middle;display: none;">{{ $item->Ko_sKeg2 }}</td>
                            <td style="vertical-align: middle;display: none;">{{ $item->Ko_Rkk }}</td>                      
                            <td class="text-right" style="vertical-align: middle;">{{ number_format($item->To_Rp - $item->realisasi,2,',','.') }}</td>                       
                            @if ($item->To_Rp - $item->realisasi != 0)
                              <td style="vertical-align: middle;">
                                <input type="number" name="real_rp" id="textBox{{$item->id_bprc}}" min="0" max="{{$item->To_Rp - $item->realisasi}}" class="form-control" onkeyup="myInput(textBox{{$item->id_bprc}}, {{$item->To_Rp - $item->realisasi}})">
                              </td>
                            @else
                              <td style="vertical-align: middle;">
                                <input type="number" class="form-control" disabled>
                              </td> 
                            @endif    
                            <td style="vertical-align: middle;display: none;">{{$item->id_bprc}}</td>
                            @if ($item->To_Rp - $item->realisasi != 0)
                              <td class="text-center" style="vertical-align: middle;">
                                <a href="#">
                                    <button id="bayar" data-ref={{$item->id_bprc}} class="btn btn-sm btn-warning" title="Bayar">
                                    <i class="fas fa-credit-card"></i></button>
                                </a>
                              </td>
                            @else
                              <td class="text-center" style="vertical-align: middle;">
                                <a href="#">
                                    <button class="btn btn-sm btn-warning" disabled>
                                    <i class="fas fa-credit-card"></i></button>
                                </a>
                              </td>
                            @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>