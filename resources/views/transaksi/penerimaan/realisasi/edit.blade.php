<div class="modal fade" id="edit{{$item->id_byr}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Realisasi</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('realisasi.update',$item->id_byr)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Nomor Bayar</label>
                                                    <div class="col-sm">
                                                        <input type="text" class="form-control" value="{{$item->No_byr}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Tanggal Bayar</label>
                                                    <div class="col-sm">
                                                        <input type="date" name="dt_byr" class="form-control" value="{{$item->dt_byr}}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Uraian</label>
                                                    <div class="col-sm">
                                                        <input type="text" name="Ur_byr" class="form-control" value="{{$item->Ur_byr}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Nama Penyetor</label>
                                                    <div class="col-sm">
                                                        {{-- <input type="text" name="Nm_Byr" class="form-control" value="{{$item->Nm_Byr}}"> --}}
                                                        <select class="form-control select2  @error('NmByr') is-invalid @enderror" name="Nm_Byr">
                                                            @foreach ($pegawai as $ls)
                                                                @if ($ls->nama != $item->Nm_Byr)
                                                                    @if ($loop->first)
                                                                    <option value="{{$item->Nm_Byr}}">{{$item->Nm_Byr}}</option>
                                                                    @endif
                                                                @endif
                                                                <option value="{{$ls->nama}}" {{$ls->nama == $item->Nm_Byr ? 'selected' : ''}}>{{$ls->nama}} ({{$ls->jabatan}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="real_rp" class="form-control desimal" value="{{number_format($item->real_rp,2,',','.')}}">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-success btn-block px-0">Simpan</button>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-secondary btn-block px-0" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>