<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">@yield('title')</h4>
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
                                <form action="{{ route('koreksi.update',  ['koreksi' =>$koreksi[0]->id_korek]) }}" method="POST" >
                                    @method('PATCH')
                                    @csrf
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_Periodedit">Periode</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="Ko_Periodedit" id="Ko_Periodedit" placeholder="Nomor Penyesuaian Edit " class="form-control @error('Ko_Periodedit') is-invalid @enderror" value="{{ old('Ko_Periodedit')  ?? '' }}" readonly >
                                                <input type="text"  name="id" id="id" placeholder="Nomor Penyesuaian Edit " class="form-control @error('id') is-invalid @enderror" value="{{ old('id')  ?? '' }}" readonly >

                                                @error('Ko_Periodedit')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_unitstredit">Unit</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text"  name="Ko_unitstredit" id="Ko_unitstredit" placeholder="Nomor Penyesuaian Edit " class="form-control @error('Ko_unitstredit') is-invalid @enderror" value="{{ old('Ko_unitstredit')  ?? '' }}" readonly>

                                                {{-- <select id="Ko_unitstredit" name="Ko_unitstredit" class="form-control select2 select2-danger @error('Ko_unitstredit') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option value="0">--Pilih Unit--</option>

                                                    @foreach($unitstr as $item)
                                                        <option  value="{{ $item->Ko_unitstredit }}" {{ old('Ko_unitstredit')  == $item->Ko_unitstredit ? 'selected' : '' }}>{{ $item->ur_subunit }}</option>
                                                    @endforeach
                                                </select> --}}
                                                @error('Ko_unitstredit')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                       <div class="row form-group">
                                            <div class="col-md-2">
                                                <label for="Ko_jr">Kode Jurnal</label>
                                            </div>
                                            <div class="col-md-10">
                                                {{-- <select id="Ko_jredit" name="Ko_jredit" class="form-control   @error('Ko_jr') is-invalid @enderror"  style="width: 100%;" >  //this work fine- without select2 --}}
                                                <select id="Ko_jredit" name="Ko_jredit" class="form-control   @error('Ko_jr') is-invalid @enderror" style="width: 100%;" >
                                                    {{-- <option value="">--Pilih Kode Jurnal--</option> --}}
                                                    {{-- var yourVar = condition1 ? someValue : condition2 ? anotherValue : defaultValue; --}}
                                                    {{-- @if(count($koreksi2['data'] ?? '') > 0 ) --}}
                                                    {{-- @foreach($koreksi2['data'] as $item) --}}
                                                    <option value="1" {{ 1 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Aset</option>
                                                    <option value="2" {{ 2 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Kewajiban</option>
                                                    <option value="3" {{ 3 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Ekuitas</option>
                                                    <option value="4" {{ 4 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Pendapatan</option>
                                                    <option value="5" {{ 5 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Belanja</option>
                                                    <option value="6" {{ 6 == $koreksi[0]->Ko_jr ? 'selected' : '' }} >Pembiayaan</option>
                                                    {{-- <option value="1" {{ 1 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Aset</option>
                                                    <option value="2" {{ 2 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Kewajiban</option>
                                                    <option value="3" {{ 3 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Ekuitas</option>
                                                    <option value="4" {{ 4 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Jr Pendapatan</option>
                                                    <option value="5" {{ 5 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Jr Belanja</option>
                                                    <option value="6" {{ 6 == $koreksi[0]->id ? '' : $koreksi[0]->id ? 'selected' : '' }} >Jr Pembiayaan</option> --}}
                                                    {{-- <option  value="{{ $bumdes->bumdes_id }}" {{  $bumdes->bumdes_id == $consuldetail->refbumde_id ? 'selected' : '' }}>{{ $bumdes->nama }} - ({{$bumdes->bumdes_id}})</option> --}}
                                                    {{-- @endforeach --}}
                                                    {{-- @endif --}}
                                                </select>
                                                @error('Ko_jredit')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="koreksi_Noedit">No</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="number"  name="koreksi_Noedit" id="koreksi_Noedit" placeholder="Nomor Penyesuaian " class="form-control @error('koreksi_Noedit') is-invalid @enderror" value="{{ old('koreksi_Noedit')  ?? '' }}" >
                                                    @error('koreksi_Noedit')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                         <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="koreksi_Uredit">Uraian</label>
                                                </div>
                                                <div  class="col-md-10">
                                                        <input type="text"  name="koreksi_Uredit" id="koreksi_Uredit" placeholder="Uraian Penyesuaian " class="form-control @error('koreksi_Uredit') is-invalid @enderror" value="{{ old('koreksi_Uredit')  ?? '' }}" >
                                                    @error('koreksi_Uredit')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                    @enderror
                                                </div>
                                        </div>


                                        {{-- modal rekening --}}

                                        {{-- <div class="row form-group">
                                            <div class="col-md-2">
                                                    <label for="nourut">Kode Rekening</label>
                                            </div>
                                            <div class="col-md-10">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" id="Ko_rkk4" name="Ko_rkk4">
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_rekening">Cari!</button>
                                                        </span>
                                                    </div>
                                                    <div class=" mt-2" >
                                                        <input type="text" class="form-control" id="nm_rek" name="nm_rek" readonly>
                                                    </div>
                                            </div>
                                        </div> --}}

                                        {{-- Modal rekenig --}}
                                        <input type="hidden" name="url_asal" value="{{ old('url_asal') ?? url()->previous()}}">

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                            <a href="{{ old('url_asal') ?? url()->previous()}}" class="btn btn-success float-right">
                                                <i class="far fa-arrow-alt-circle-left"> Back</i>
                                            </a>
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
                {{-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->






