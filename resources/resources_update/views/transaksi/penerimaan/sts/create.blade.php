<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah STS</h4>
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
                                    <form action="{{ route('sts.store') }}" method="POST">
                                        @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="No_sts">Nomor STS</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="No_sts" placeholder="Nomor STS "
                                                    class="form-control @error('No_sts') is-invalid @enderror"
                                                    value="{{ old('No_sts') ?? '' }}">
                                                @error('No_sts')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="dt_sts">Tanggal</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date" name="dt_sts" placeholder="Nomor STS "
                                                    class="form-control @error('dt_sts') is-invalid @enderror"
                                                    value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                                @error('dt_sts')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ur_sts">Uraian</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="Ur_sts" placeholder="Uraian STS "
                                                    class="form-control @error('Ur_sts') is-invalid @enderror"
                                                    value="{{ old('Ur_sts') ?? '' }}">
                                                @error('Ur_sts')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Nm_Ben">Nama Bendahara</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <input type="text" name="Nm_Ben" placeholder="Nama Bendahara "
                                                    class="form-control @error('Nm_Ben') is-invalid @enderror"
                                                    value="{{ old('Nm_Ben') ?? '' }}">
                                                @error('Nm_Ben')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror --}}
                                                <select class="form-control select2 @error('Nm_Ben') is-invalid @enderror" name="Nm_Ben" id="pegawai">
                                                    <option value="">-- Pilih Bendahara --</option>
                                                    @foreach ($pegawai as $item)
                                                        <option value="{{$item->nama}}|{{$item->nip}}">{{$item->nama}} ({{$item->jabatan}})</option>
                                                    @endforeach
                                                </select>
                                                @error('Nm_Ben')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="NIP_Ben">NIP</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="NIP_Ben" id="nip" placeholder="NIP Bendahara"
                                                    class="form-control @error('NIP_Ben') is-invalid @enderror"
                                                    value="{{ old('NIP_Ben') ?? '' }}" readonly>
                                                @error('NIP_Ben')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Bank">Bank Tujuan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="Ko_Bank" id="" class="select2">
                                                    <option value="" selected>-- Pilih Bank --</option>
                                                    @foreach ($bank as $item)
                                                        <option value="{{ $item->Ko_Bank }}">{{ $item->No_Rek }} - {{ $item->Ur_Bank }}
                                                            @if ($item->Tag == 1)
                                                            (Rekening Utama)
                                                            @elseif($item->Tag == 2)
                                                            (Rekening Bendahara Pengeluaran)
                                                            @elseif($item->Tag == 3)
                                                            (Rekening Bendahara Penerimaan)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('Ko_Bank')
                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Modal rekenig --}}
                                        <input type="hidden" name="url_asal"
                                            value="{{ old('url_asal') ?? url()->previous() }}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button
                                                class="btn btn-success float-right" data-dismiss="modal">
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
