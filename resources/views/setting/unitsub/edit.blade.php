@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit Data BLUD</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('unitsub.update', $unitsub->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method("PUT")
              @if(session('errors'))
              <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                Something it's wrong:
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="ur_subunit" class="form-control @error('ur_subunit') is-invalid @enderror" value="{{ old('ur_subunit', $unitsub->ur_subunit) }}" placeholder="Nama BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Jln" class="form-control @error('Nm_Jln') is-invalid @enderror" value="{{ old('Nm_Jln', $unitsub->Nm_Jln) }}" placeholder="Alamat BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kepala BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Pimp" class="form-control @error('Nm_Pimp') is-invalid @enderror" value="{{ old('Nm_Pimp', $unitsub->Nm_Pimp) }}" placeholder="Nama Kepala BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kepala BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Pimp" class="form-control @error('NIP_Pimp') is-invalid @enderror" value="{{ old('NIP_Pimp', $unitsub->NIP_Pimp) }}" placeholder="NIP Kepala BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kabag Keuangan BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Keu" class="form-control @error('Nm_Keu') is-invalid @enderror" value="{{ old('Nm_Keu', $unitsub->Nm_Keu) }}" placeholder="Nama Kabag Keuangan BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kabag Keuangan BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Keu" class="form-control @error('NIP_Keu') is-invalid @enderror" value="{{ old('NIP_Keu', $unitsub->NIP_Keu) }}" placeholder="NIP Kabag Keuangan BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bendahara BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Bend" class="form-control @error('Nm_Bend') is-invalid @enderror" value="{{ old('Nm_Bend', $unitsub->Nm_Bend) }}" placeholder="Nama Bendahara BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Bendahara BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Bend" class="form-control @error('NIP_Bend') is-invalid @enderror" value="{{ old('NIP_Bend', $unitsub->NIP_Bend) }}" placeholder="NIP Bendahara BLUD">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">APBD</label>
                  <div class="col-sm-3">
                    <select class="form-control" name="apbd">
                      <option value="0" {{$unitsub->apbd == 0 ? 'selected' : ''}}>Tidak</option>
                      <option value="1" {{$unitsub->apbd == 1 ? 'selected' : ''}}>Ya</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">SPD</label>
                  <div class="col-sm-3">
                    <select class="form-control" name="set_PD">
                      <option value="0" {{$unitsub->set_PD == 0 ? 'selected' : ''}}>Tidak</option>
                      <option value="1" {{$unitsub->set_PD == 1 ? 'selected' : ''}}>Ya</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Logo Pemda</label>
                  <div class="col-sm-2">
                    <input type="file" name="img_pemda" class="form-control-file">
                  </div>
                  <label for="" class="col-sm-1 col-form-label">Logo BLUD</label>
                  <div class="col-sm-2">
                    <input type="file" name="img_blud" class="form-control-file">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-2">
                    @if (!empty($unitsub->logo_pemda))
                      <img class="img-thumbnail" src="{{asset('logo') }}/pemda/{{$unitsub->logo_pemda}}" alt="Photo" style="width: 150px; height: 150px;">  
                      <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt" data-toggle="modal" data-target="#lgpemda"></i></button>
                    @else
                      <img class="img-thumbnail" src="{{asset('template') }}/dist/img/no_image.png" alt="Photo" style="max-width: 60%">
                    @endif
                  </div>
                  <label for="" class="col-sm-1 col-form-label"></label>
                  <div class="col-sm-2">
                    @if (!empty($unitsub->logo_blud))
                      <img class="img-thumbnail" src="{{asset('logo') }}/blud/{{$unitsub->logo_blud}}" alt="Photo" style="width: 150px; height: 150px;">
                      <button type="button" class="btn btn-danger btn-sm"><i class="far fa-trash-alt" data-toggle="modal" data-target="#lgblud"></i></button>
                    @else
                      <img class="img-thumbnail" src="{{asset('template') }}/dist/img/no_image.png" alt="Photo" style="max-width: 60%">
                    @endif
                  </div>
                </div>
                <br>

                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  <a href="{{ route('unitsub.index') }}" class="col-sm-2 btn btn-danger ml-3">
                    <i class="fas fa-backward pr-2"></i>Kembali
                  </a> 
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>  
  <div class="modal fade" id="lgpemda">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <p><strong>Yakin akan menghapus logo PEMDA ?</strong></p>
        </div>
        <form action="{{route('unitsub.delpemda', $unitsub->id)}}" method="GET">
          @csrf
          @method('GET')
          <div class="modal-footer justify-content">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Iya, Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="lgblud">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <p><strong>Yakin akan menghapus logo BLUD ?</strong></p>
        </div>
        <form action="{{route('unitsub.delblud', $unitsub->id)}}" method="GET">
          @csrf
          @method('GET')
          <div class="modal-footer justify-content">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Iya, Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

  @section('script')  @endsection