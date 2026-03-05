<div class="modal fade" id="modalTambahSp3bRinciTambah" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Tambah Rincian SP3B Nomor : <span class="text-primary" id="head_nosp3"></span></h5>
        <input type="text" id="frmadd_idsp3" hidden>
        <input type="text" id="frmadd_nosp3" hidden>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover mb-0" id="tbl_list_rinci" width="100%" cellspacing="0">
                      <thead class="thead-light">
                        <tr>
                          <th class="text-center" style="vertical-align: middle; width: 5%;">Tahun</th>
                          <th class="text-center" style="vertical-align: middle;">Nomor Usulan</th>
                          <th class="text-center" style="vertical-align: middle;">Nomor Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Tanggal Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Uraian Otorisasi</th>
                          <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                          <th class="text-center" style="vertical-align: middle;"><input type="checkbox" id="checkall"></th>
                        </tr>
                      </thead>
                      <tbody>

                        {{-- @if($otosah->count() > 0)
                        @foreach ($otosah as $number => $otosah)
                        <tr>
                          <td class="text-center">{{$otosah ->ko_period}}</td>                       
                          <td>{{$otosah ->no_SPi}}</td>                       
                          <td name="No_oto">{{$otosah ->No_oto}}</td>                      
                          <td class="text-center">{{ date('d M Y', strtotime($otosah ->Dt_oto)) }}</td>                      
                          <td>{{$otosah ->Ur_oto}}</td>                      
                          <td class="text-right">{{ number_format($otosah ->jumlah, 0, ',', '.') }}</td> 
                          <td>
                            <form action="{{ route('sp3b_rinci_store') }}" method="post" class="form-horizontal">
                              @csrf
                              @method("PUT")
                              <button type="submit" class="btn btn-success btn-xs btn-block px-0" name="submit" 
                              value="{{ $sp3b->id_sp3 }}||{{ $sp3b->No_sp3 }}||{{ $otosah->No_oto }}||{{$otosah->jumlah}}">Pilih
                              </button>
                            </form>
                          </td>                     
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="5">Tidak Ada Data</td>
                        </tr>
                        @endif --}}
                      </tbody>

                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="form-group row justify-content-center">
                    <button class="btn btn-primary" data-dismiss="modal" id="submit"><i class="fa fa-save"></i> Simpan</button>
                    <button class="btn btn-danger mx-2" data-dismiss="modal"><i class="fa fa-reply"></i> Kembali</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>