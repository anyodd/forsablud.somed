@extends('layouts.template')
@section('style') 
<meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="mt-2">
          <a href="{{ route('lapbb_rekap') }}" type="button" class="btn btn-primary mb-2">
            <i class="fas fa-book"></i> Buku Besar
          </a>
          <a href="{{ route('lapbb_sub') }}" type="button" class="btn btn-primary mb-2">
            <i class="fas fa-book"></i> Buku Besar Sub Rinci 1
          </a>
          <a href="{{ route('lapbb_subrinci') }}" type="button" class="btn btn-primary mb-2">
            <i class="fas fa-book"></i> Buku Besar Sub Rinci 2
          </a>
          <a href="{{ route('lapbb.index') }}" type="button" class="btn btn-primary mb-2">
            <i class="fas fa-book"></i> Buku Besar Rinci
          </a>
          <a href="{{ route('lapbbrekap') }}" type="button" class="btn btn-primary mb-2">
            <i class="fas fa-book"></i> Rekap Buku Besar
          </a>
        </div>
        <form action="{{ route('lapbbrekap') }}" method="get" class="form-horizontal">
          @csrf

          <div class="card shadow-lg mt-2">
            <div class="card-header bg-info py-2">
              <h5 class="card-title font-weight-bold">Saldo Buku Besar</h5> 
            </div>
            <div class="text-center font-weight-bold">
                SALDO BUKU BESAR <br>
            </div>
            <div class="row justify-content-center">
              {{ $periode }}
              {{-- <code>Periode Transaksi</code>  --}}
              <div class="input-group justify-content-center">
                <div class="input-group-prepend">
                  <input type="text" name="period" class="form-control float-right text-center" id="reservation" value="-- Pilih Periode --">
                  <span class="input-group-text text-primary">
                    <button type="submit" class="btn-xs btn-primary" name="submit">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>
            </div>
            <br>
          </div>
          <div class="card shadow-lg">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0" id="example1" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th></th>
                      <th class="text-center" style="vertical-align: middle;">Uraian</th>
                      <th class="text-center" style="vertical-align: middle;">Debet (Rp)</th>
                      <th class="text-center" style="vertical-align: middle;">Kredit (Rp)</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($data as $rk3 => $rinci)
                        <tr>
                          <td></td>
                          <td class="text-bold">{{$rk3}}</td>
                          <td class="text-right text-bold">{{ number_format($rinci['debet'],2,',','.') }}</td>
                          <td class="text-right text-bold">{{ number_format($rinci['kredit'],2,',','.') }}</td>
                          @foreach ($rinci['rincian'] as $rk6 => $item)
                          <tr>
                              <td></td>
                              <td>{{$rk6}}</td>
                              <td class="text-right">{{ number_format($item['debet'],2,',','.') }}</td>
                              <td class="text-right">{{ number_format($item['kredit'],2,',','.') }}</td>
                          </tr>
                          @endforeach
                        </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>

          </div>

        </div>

      </form>
      <input type="text" value="{{Tahun()}}" id="anggaran_th" hidden>
    </div>
  </div>
</div>
</section>  

@endsection

@section('script') 
  <script>
    $(document).ready(function() {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "aLengthMenu": [1000],
        "buttons": ["excel"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      var tahun = document.getElementById('anggaran_th').value;
      $('#reservation').data('daterangepicker').setStartDate('01/01/'+tahun);
      $('#reservation').data('daterangepicker').setEndDate('12/31/'+tahun);
    });
  </script>

  <script type="text/javascript">
    $('#reservation').daterangepicker()
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    });
  </script>

@endsection