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
            <form action="{{ route('spjpendapatan.tambahrinciansts')}}" method="post">
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
                      <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No STS</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Bendahara</th>
                                <th class="text-center">NIP Bendahara</th>
                                <th class="text-center">Nilai (Rp)</th>
                                <th class="text-center">
                                  @if (!empty($spjpendapatanbukti))
                                    <input type="checkbox" id="checkall">
                                  @endif
                                </th>
                            </tr>
                        </thead>
                        @if (count($spjpendapatanbukti ?? '') > 0)
                          @php
                              $total = 0;
                          @endphp
                            <tbody>
                                @foreach ($spjpendapatanbukti as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td>{{ $item->No_sts }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($item->dt_sts)) }}</td>                      
                                        <td>{{ $item->Ur_sts }}</td>
                                        <td>{{ $item->Nm_Ben }}</td>
                                        <td>{{ $item->NIP_Ben }}</td>
                                        <td class="text-right">{{ number_format($item->total,0,'','.') }}</td>
                                        <td class="text-center">
                                          <input class="check" type="checkbox" value="{{ $item->id_sts }}">
                                        </td>
                                    </tr>
                                    @php
                                $total += $item->total;
                            @endphp
                                @endforeach
                            </tbody>
                        @endif
                        <tfoot style="background-color: #1db790">
                          <tr>
                              <th class="text-center" colspan="6">Total</th>
                              @if (!empty($total))
                              <th class="text-right">{{number_format($total, 0, ',', '.')}}</th>
                              @else
                              <th class="text-right">-</th>
                              @endif
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