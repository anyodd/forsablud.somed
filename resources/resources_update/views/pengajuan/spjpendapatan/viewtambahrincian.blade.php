@extends('layouts.template')

@section('content')

{{-- @include('pengajuan.spjpendapatan.popup.modal_bukti_spjpendapatan') --}}

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spjpendapatan.index') }}">SPJ Pendapatan</a></li>
    <li class="breadcrumb-item active pull-right" aria-current="page">Tambah Rincian SPJ Pendapatan</li>
  </ol>
</nav>

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Rincian SPJ Pendapatan</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <form action="{{ route('spjpendapatan.tambahrincian')}}" method="post">
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
                <div class="card">
                    <div class="card-body card-info">
                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nomor SPJ</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="No_spi" class="form-control @error('No_SPi') is-invalid @enderror" value="{{ old('No_SPi', $spjpendapatan->No_SPi) }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Bukti yg diajukan</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalBuktiSpjpendapatan">Pilih.....</button>
                                        </span>
                                    </div>
                                    <!-- Pilih -->
                                    <div class="col-sm-9">
                                        <input type="text" name="No_sts" class="form-control @error('No_sts') is-invalid @enderror" id="sNo_sts" value="{{old('No_sts')  }}" placeholder="Nomor Bayar" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">No. Bayar</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="No_byr" class="form-control @error('No_byr') is-invalid @enderror" id="sNo_byr" value="{{ old('No_byr') }}" placeholder="No. Bayar" readonly>
                                    </div>

                                    <label for="" class="col-sm-2 col-form-label">Tgl. Bayar</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="date" name="dt_byr" class="form-control @error('dt_byr') is-invalid @enderror" id="sdt_byr" value="{{ old('dt_byr') }}" placeholder="Tgl. Bayar" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Uraian Bukti</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm">
                                        <input type="text" name="Ur_sts" class="form-control @error('Ur_sts') is-invalid @enderror" id="sUr_sts" value="{{ old('Ur_sts') }}" placeholder="Uraian Bukti" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                    <label for="" class="col-form-label">:</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="sjumlah" value="{{ old('jumlah') }}" placeholder="Nilai (Rp)" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <table class="table table-sm table-bordered table-hover mb-0" id="exampl1" width="100%" cellspacing="0">
                          <thead class="thead-light">
                              <tr>
                              <th class="text-center" style="vertical-align: middle">No</th>
                              <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                              <th class="text-center" style="vertical-align: middle">Uraian Bukti</th>
                              <th class="text-center" style="vertical-align: middle">No. Bayar</th>
                              <th class="text-center" style="vertical-align: middle">Tgl. Bayar</th>
                              <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                              <th class="text-center" style="vertical-align: middle">
                                @if (!empty($spjpendapatanbukti))
                                <input type="checkbox" id="checkall">
                                @endif
                              </th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php $no = 0; $total=0;?>
                          @foreach($spjpendapatanbukti as $spjpendapatanbukti)
                          <?php $no++ ;?>
                          <tr>
                              <td style="text-align: center">{{$no}}</td>                
                              <td>{{ $spjpendapatanbukti->No_byr }}</td>                                           
                              <td>{{ $spjpendapatanbukti->Ur_byr }}</td>                      
                              <td>{{ $spjpendapatanbukti->No_byr }}</td>  
                              <td>{{ $spjpendapatanbukti->dt_byr }}</td>                       
                              <td class="text-right">{{ number_format($spjpendapatanbukti->realisasi,2,',','.') }}</td>  
                              <td class="text-center">
                                  {{-- <button class="btn btn-primary py-0" data-dismiss="modal" title="Pilih data" id="select"
                                      data-val1 = "{{ $spjpendapatanbukti->No_byr }}"
                                      data-val2 = "{{ $spjpendapatanbukti->dt_byr }}"
                                      data-val3 = "{{ $spjpendapatanbukti->Ur_byr }}"
                                      data-val4 = "{{ $spjpendapatanbukti->realisasi }}"
                                      data-val5 = "{{ $spjpendapatanbukti->id_byr }}"
                                      data-val6 = "{{ $spjpendapatanbukti->No_byr }}"
                                      data-val7 = "{{ $spjpendapatanbukti->dt_byr }}"
                                  ><i style='font-size:8px' class="fa fa-choose"> </i>Pilih</button> --}}
                                  <input class="check" type="checkbox" value="{{ $spjpendapatanbukti->id_byr }}">
                              </td>                     
                          </tr>
                            @php
                                $total += $spjpendapatanbukti->realisasi;
                            @endphp
                          @endforeach
                          </tbody>
                          <tfoot style="background-color: #1db790">
                            <tr>
                                <th class="text-center" colspan="5">Total</th>
                                <th class="text-right">{{number_format($total, 0, ',', '.')}}</th> 
                                <th class="text-right"></th>
                            </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card-footer-->
                    <div class="form-group row justify-content-center mt-3">
                        <input type="text" name="No_spi" value="{{ $spjpendapatan->No_SPi }}" hidden>
                        <input type="text" name="id_spi" value="{{ $spjpendapatan->id }}" hidden>
                        <input type="text" name="id_rc" id="id_rc" hidden>
                        <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit" id="submit">
                        <i class="far fa-save pr-2"></i>Simpan
                        </button>
                        <a href="{{ route('spjpendapatan.index') }}" class="col-sm-2 btn btn-danger ml-3">
                        <i class="fas fa-backward pr-2"></i>Kembali
                        </a> 
                    </div>
                </div>
                <!-- /.card -->
            </form>
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
    $("#example1").DataTable({
        "pageLength": 20,
    });

    let ceklist = $('table tbody .check:checked')
    let cek = (ceklist.length > 0)
    $('#submit').prop('disabled',!cek);

    $(document).on('click','#checkall', function () {
        var isChecked = $('#checkall').prop('checked')
        $('.check').prop('checked',isChecked);

        if(isChecked > 0) {
        $('#submit').prop('disabled',false);
        }else{
        $('#submit').prop('disabled',true);
        }
    });

    $(document).on('click','.check', function () {
        let cek = $('table tbody .check:checked')

        if(cek.length > 0) {
        $('#submit').prop('disabled',false);
        }else{
        $('#submit').prop('disabled',true);
        }
    });

    function getData() {
        let dt = $('.check:checked')
        let data = []
        $.each(dt, function (index, elm) { 
            data.push(elm.value)
        });

        $('#id_rc').val(data);
        console.log(dt);
    }
    $(document).on('click','#submit', function () {
        let dt = $('.check:checked')
        let data = []
        $.each(dt, function (index, elm) { 
            data.push(elm.value)
        });

        $('#id_rc').val(data);
    });
  })
</script>
@endsection