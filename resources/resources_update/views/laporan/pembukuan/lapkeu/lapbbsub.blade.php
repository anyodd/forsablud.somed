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
        <form action="{{ route('lapbb_sub') }}" method="get" class="form-horizontal">
          @csrf

          <div class="card shadow-lg mt-2">
            <div class="card-header bg-info py-2">
              <h5 class="card-title font-weight-bold">Buku Besar Sub Rinci 1</h5> 
            </div>
            <div class="card-body py-0">
              <div class="form-group row mb-0">
                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-md-8">
                      <code>Pilih Akun</code>
                      <select name="kd_rkk" class="form-control" id="search">
                      </select>
                    </div>
                    <div class="col">
                      <code>Periode Transaksi</code>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <input type="text" name="period" class="form-control float-right" id="reservation" value="-- Pilih Periode --">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <code>.</code>
                      <button type="submit" class="col btn btn-primary" name="submit">
                        <i class="fa fa-search"> FILTER</i>
                      </button>
                    </div>
                  </div>
                </div>  
              </div>
            </div>

          </div>

          <div class="text-center font-weight-bold">
            {{ $judul }} <br>
            Kode Akun : {{ $kd_rkk }} <br>
            Uraian    : {{ $ur_rkk }} <br>
            {{ $periode }}
          </div>


          <div class="card shadow-lg">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0" id="example1" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center" style="vertical-align: middle;">Rekening</th>
                      <th class="text-center" style="vertical-align: middle;">Uraian</th>
                      <th class="text-center" style="vertical-align: middle;">Debet (Rp)</th>
                      <th class="text-center" style="vertical-align: middle;">Kredit (Rp)</th>
                      <th class="text-center" style="vertical-align: middle;">Saldo (Rp)</th>
                    </tr>
                  </thead>

                  <tbody>
                    @php
                      $total = 0;
                      $total_debet = 0;
                      $total_kredit = 0;
                    @endphp
                    <tr>
                      @if(!empty($saldo))
                      @foreach($saldo as $item)
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{$item->kd_rkk }}</td>
                      <td>{{ $item->ur_rkk }}</td>
                      <td class="text-right">{{number_format($item->debet, '2', ',', '.') }}</td>
                      <td class="text-right">{{number_format($item->kredit, '2', ',', '.') }}</td>
                      <td class="text-right">{{number_format($total += $item->debet - $item->kredit, '2', ',', '.') }}</td>
                    </tr>
                      @php
                          $total_debet += $item->debet;
                          $total_kredit += $item->kredit;
                      @endphp
                      @endforeach
                    @else
                    <tr>
                      <td colspan="6">Tidak ada data</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot style="background-color: #1db790">
                    <tr>
                        <th class="text-center" colspan="3">Total</th>
                        <th class="text-right">{{number_format($total_debet, 2, ',', '.')}}</th> 
                        <th class="text-right">{{number_format($total_kredit, 2, ',', '.')}}</th>
                        <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
                    </tr>
                  </tfoot>
              </table>
            </div>

          </div>

        </div>

      </form>
    </div>
  </div>
</div>
</section>  

@endsection

@section('script') 
<script type="text/javascript">
  //Date range picker
  $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    });
</script>

<script>
  $(document).ready(function() {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    var tahun = {{tahun()}};
    $('#reservation').data('daterangepicker').setStartDate('01/01/'+tahun);
    $('#reservation').data('daterangepicker').setEndDate('12/31/'+tahun);
  });

  $('#search').select2({
    ajax: {
      url: "{{ route('cariakunsubrekap') }}",
      dataType: 'json',
      processResults: function(data) {
        console.log(data);
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.Ko_RKK+'-'+obj.Ur_Rk4,
              text: obj.Ko_RKK+' - '+obj.Ur_Rk4
            };
          })
        };
      }
    }
  });

</script>

@endsection