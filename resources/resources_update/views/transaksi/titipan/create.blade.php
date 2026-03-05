<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah @yield('title')</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- About Me Box -->
                            <div class="card card-info">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('titipan.store') }}" method="POST" >
                                    @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_bp">No Penerimaan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="No_bp" placeholder="No Bukti Titipan" class="form-control @error('No_bp') is-invalid @enderror" value="{{ old('No_bp')  ?? '' }}" >
                                                @error('No_bp')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="dt_bp">Tanggal</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="date"  name="dt_bp" placeholder="Tanggal titip" class="form-control @error('dt_bp') is-invalid @enderror" value="{{ old('dt_bp')  ?? '' }}" >
                                                    @error('dt_bp')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="Ur_bp">Uraian</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="text" name="Ur_bp" placeholder="Uraian penjelasan titipan " class="form-control @error('Ur_bp') is-invalid @enderror" value="{{ old('Ur_bp')  ?? '' }}" >
                                                    @error('Ur_bp')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                         <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="nm_BUcontr">Penitip</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="text"  name="nm_BUcontr" placeholder="Nama Pihak penitip" class="form-control @error('nm_BUcontr') is-invalid @enderror" value="{{ old('nm_BUcontr')  ?? '' }}" >
                                                    @error('nm_BUcontr')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="adr_bucontr">Alamat Penitip</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="text"  name="adr_bucontr" placeholder="Alamat Pihak penitip" class="form-control @error('adr_bucontr') is-invalid @enderror" value="{{ old('adr_bucontr')  ?? '' }}" >
                                                    @error('adr_bucontr')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="Nm_input">Petugas Input</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        {{-- <input type="text"  name="Nm_input" placeholder="Petugas  input data titipan" class="form-control @error('Nm_input') is-invalid @enderror" value="{{ old('Nm_input')  ?? '' }}" > --}}
                                                        <select class="form-control select2  @error('Nm_input') is-invalid @enderror" name="Nm_input" id="Nm_input">
                                                            <option value="">--Pilih Petugas Input--</option>
                                                            @foreach ($pegawai as $item)
                                                                <option value="{{$item->nama}}">{{$item->nama}} ({{$item->jabatan}})</option>
                                                            @endforeach
                                                          </select>  
                                                    @error('Nm_input')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button data-dismiss="modal" class="btn btn-success float-right">
                                                <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                                            </button>
                                        </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->






