@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data BLUD {{ $Ko_Period }}</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('unitsub.store') }}" method="post" class="form-horizontal">
              @csrf
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

              <div class="card-body">

                
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Kode BLUD</label>
                  <div class="col-sm-2">
                    <input type="number" min="1" max="99" name="Ko_Sub" class="form-control @error('Ko_Sub') is-invalid @enderror" value="{{ old('Ko_Sub', $max+1) }}" placeholder="Kode BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="ur_subunit" class="form-control @error('ur_subunit') is-invalid @enderror" value="{{ old('ur_subunit') }}" placeholder="Nama BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Jln" class="form-control @error('Nm_Jln') is-invalid @enderror" value="{{ old('Nm_Jln') }}" placeholder="Alamat BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kepala BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Pimp" class="form-control @error('Nm_Pimp') is-invalid @enderror" value="{{ old('Nm_Pimp') }}" placeholder="Nama Kepala BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kepala BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Pimp" class="form-control @error('NIP_Pimp') is-invalid @enderror" value="{{ old('NIP_Pimp') }}" placeholder="NIP Kepala BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kabag Keuangan BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Keu" class="form-control @error('Nm_Keu') is-invalid @enderror" value="{{ old('Nm_Keu') }}" placeholder="Nama Kabag Keuangan BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kabag Keuangan BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Keu" class="form-control @error('NIP_Keu') is-invalid @enderror" value="{{ old('NIP_Keu') }}" placeholder="NIP Kabag Keuangan BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bendahara BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Bend" class="form-control @error('Nm_Bend') is-invalid @enderror" value="{{ old('Nm_Bend') }}" placeholder="Nama Bendahara BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Bendahara BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Bend" class="form-control @error('NIP_Bend') is-invalid @enderror" value="{{ old('NIP_Bend') }}" placeholder="NIP Bendahara BLUD">
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


  @endsection

  @section('script')  

  <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
  <script type="text/javascript">
    $('#prov').change(function(){
      var prov = $(this).val();    
      if(prov){
        $.ajax({
         type:"GET",
         url:"{{url('get-kabkota-list')}}?Ko_Wil1="+prov,
         success:function(res){ 
           console.log(res);   
           if(res){
            $("#kabkota").empty();
            $("#kabkota").append('<option disabled>-- Pilih Kabupaten/Kota --</option>');
            $.each(res,function(key){
              $("#kabkota").append('<option value="'+res[key].Ko_Wil2+'">'+res[key].Ko_Wil2+' - '+res[key].Ur_Wil2+'</option>');
            });

          }else{
           $("#kabkota").empty();
         }
       }
     });
      }else{
        $("#kabkota").empty();
      }      
    });

  </script>

  @endsection