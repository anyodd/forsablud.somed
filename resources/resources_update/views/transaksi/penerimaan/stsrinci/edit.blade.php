@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Edit STS Rinci</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="card-body">
                <form action="{{ route('stsrinci.update', $stsrinci->id_stsrc) }}" method="POST" >
                    @csrf
                    @method("PUT")
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label for="Ko_Period">Nomer STS</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text"  name="No_sts" id="No_sts" class="form-control"  value="{{ $stsrinci->No_sts }}" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label for="Ko_stsrc">No STS Rinci</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text"  name="id_sts" id="id_sts" class="form-control" value="{{$stsrinci->Ko_stsrc}}" readonly>
                        </div>
                    </div>

                        {{-- modal rekening --}}

                    <div class="row form-group">
                        <div class="col-md-2">
                                <label for="No_byr">Kode Bayar STS</label>
                        </div>
                        <div class="col-md-10">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="no_edit" name="No_byredit" value="{{$stsrinci->No_byr}}" readonly>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_stsbayaredit">Cari!</button>
                                    </span>
                                </div>
                        </div>
                    </div>

                    {{-- Modal rekening --}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{route('sts.detail', $stsrinci->id_stsrc)}}" class="btn btn-success float-right">
                            <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                        </a>
                    </div>
                </form>
                        
            @include('transaksi.penerimaan.stsrinci.popup_stsbayaredit')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('script')
    <script>
         $(function() {
            $(document).on('click', '#edit', function() {
                var kd_byr = $(this).data('no_bayar');
                $('#no_edit').val(kd_byr);
                $('#modal_stsbayaredit').hide();
            });

         })
    </script>
@endsection