@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Bidang BLUD {{ $Ko_Period }}</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('unitsub1.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Kode Bidang BLUD</label>
                  <div class="col-sm-2">
                    <input type="number" min="1" max="99" name="Ko_Sub1" class="form-control @error('Ko_Sub1') is-invalid @enderror" value="{{ old('Ko_Sub1', $max+1) }}" placeholder="Kode Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bidang BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="ur_subunit1" class="form-control @error('ur_subunit1') is-invalid @enderror" value="{{ old('ur_subunit1') }}" placeholder="Nama Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Alamat Bidang BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Jln" class="form-control @error('Nm_Jln') is-invalid @enderror" value="{{ old('Nm_Jln') }}" placeholder="Alamat Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kepala Bidang BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Pimp" class="form-control @error('Nm_Pimp') is-invalid @enderror" value="{{ old('Nm_Pimp') }}" placeholder="Nama Kepala Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kepala Bidang BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Pimp" class="form-control @error('NIP_Pimp') is-invalid @enderror" value="{{ old('NIP_Pimp') }}" placeholder="NIP Kepala Bidang BLUD">
                  </div>
                </div>
                <!-- <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kabag Keuangan Bidang BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Keu" class="form-control @error('Nm_Keu') is-invalid @enderror" value="{{ old('Nm_Keu') }}" placeholder="Nama Kabag Keuangan Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Kabag Keuangan Bidang BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Keu" class="form-control @error('NIP_Keu') is-invalid @enderror" value="{{ old('NIP_Keu') }}" placeholder="NIP Kabag Keuangan Bidang BLUD">
                  </div>
                </div> -->
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bendahara Bidang BLUD</label>
                  <div class="col-sm">
                    <input type="text" name="Nm_Bend" class="form-control @error('Nm_Bend') is-invalid @enderror" value="{{ old('Nm_Bend') }}" placeholder="Nama Bendahara Bidang BLUD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">NIP Bendahara Bidang BLUD</label>
                  <div class="col-sm-3">
                    <input type="text" maxlength="21" name="NIP_Bend" class="form-control @error('NIP_Bend') is-invalid @enderror" value="{{ old('NIP_Bend') }}" placeholder="NIP Bendahara Bidang BLUD">
                  </div>
                </div>

                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  <a href="{{ route('unitsub1.index') }}" class="col-sm-2 btn btn-danger ml-3">
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