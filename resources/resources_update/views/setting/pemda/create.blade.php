@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Pemda {{ $Ko_Period }}</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('pemda.store') }}" method="post" class="form-horizontal">
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
                  <label for="" class="col-sm-2 col-form-label">Provinsi</label>
                  <div class="col-sm">
                    <select id="prov" name="prov" class="form-control" >
                      <option value="" selected disabled>-- Pilih Provinsi --</option>
                      @foreach($prov as $item)
                      <option value="{{ $item->Ko_Wil1 }}">{{$item->Ko_Wil1}} - {{ $item->Ur_Wil1 }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                  <div class="col-sm">
                    <select name="kabkota" id="kabkota" class="form-control">
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pemda</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Pemda" class="form-control @error('Ur_Pemda') is-invalid @enderror" value="{{ old('Ur_Pemda') }}" placeholder="Nama Pemda">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Ibukota</label>
                  <div class="col-sm">
                    <input type="text" name="Ibukota" class="form-control @error('Ibukota') is-invalid @enderror" value="{{ old('Ibukota') }}" placeholder="Nama Ibukota Kabupaten/Kota">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Kepala Daerah</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Kpl" class="form-control @error('Ur_Kpl') is-invalid @enderror" value="{{ old('Ur_Kpl') }}" placeholder="Nama Kepala Daerah">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Sekretaris Daerah</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Sekda" class="form-control @error('Ur_Sekda') is-invalid @enderror" value="{{ old('Ur_Sekda') }}" placeholder="Nama Sekretaris Daerah">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama PPKD</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_PPKD" class="form-control @error('Ur_PPKD') is-invalid @enderror" value="{{ old('Ur_PPKD') }}" placeholder="Nama PPKD">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama BUD</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_BUD" class="form-control @error('Ur_BUD') is-invalid @enderror" value="{{ old('Ur_BUD') }}" placeholder="Nama BUD">
                  </div>
                </div>
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('pemda.index') }}" class="col-sm-2 btn btn-danger ml-3">
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