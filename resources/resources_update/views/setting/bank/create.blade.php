@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Bank</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('bank.store') }}" method="post" class="form-horizontal">
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
                  {{-- <label for="" class="col-sm-2 col-form-label">Kode Bank</label> --}}
                  <div class="col-sm-2">
                    <input type="number" min="1" max="99" name="Ko_Bank" class="form-control @error('Ko_Bank') is-invalid @enderror" value="{{ old('Ko_Bank', $max+1) }}" placeholder="Kode Bank" hidden>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Bank</label>
                  <div class="col-sm">
                    <input type="text" name="Ur_Bank" class="form-control @error('Ur_Bank') is-invalid @enderror" value="{{ old('Ur_Bank') }}" placeholder="Nama Bank">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Rekening</label>
                  <div class="col-sm">
                    <input type="text" name="No_Rek" class="form-control @error('No_Rek') is-invalid @enderror" value="{{ old('No_Rek') }}" placeholder="Nomor Rekening">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm">
                    <select id="Tag" name="Tag" class="form-control" >
                      <option value="" selected disabled>-- Pilih Status Bank --</option>
                      <option value=1>Rekening Utama</option>
                      <option value=2>Rekening Bendahara Pengeluaran</option>
                      <option value=3>Rekening Bendahara Penerimaan</option>
                    </select>
                  </div>
                </div>
                
              </div>

              <div class="form-group row justify-content-center mt-3">
                <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                  <i class="far fa-save pr-2"></i>Simpan
                </button>
                <a href="{{ route('bank.index') }}" class="col-sm-2 btn btn-danger ml-3">
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