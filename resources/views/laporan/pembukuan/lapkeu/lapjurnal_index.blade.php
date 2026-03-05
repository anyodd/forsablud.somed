@extends('layouts.template')
@section('style') 
<meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">

        <form action="{{ route('lapjurnal.index') }}" method="get" class="form-horizontal">
          @csrf

          <div class="card shadow-lg mt-2">
            <div class="card-header bg-info py-2">
              <h5 class="card-title font-weight-bold">Daftar Jurnal</h5> 
            </div>
            <div class="card-body py-0">
              <div class="form-group row mb-0">
                <div class="col-10">
                  <div class="form-group row">
                    <div class="col">
                      <code>Jenis Jurnal</code>
                      <select name="jns_jurnal" class="form-control" id="">
                        <option value="">-- Pilih Jenis Jurnal --</option>
                        <option value="jr_trans">Jurnal Transaksi</option>
                        <option value="jr_sesuai">Jurnal Penyesuaian</option>
                        <option value="jr_soaw">Jurnal Saldo Awal</option>
                      </select>
                    </div>
                    <div class="col">
                      <code>Periode Transaksi</code>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <input type="text" name="tgl_jurnal" class="col form-control float-right" id="reservation" value="-- Pilih Periode --">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col">
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
            {{ $periode }}
          </div>
          @php
            $total_debet = 0;
            $total_kredit = 0;
          @endphp

          <div class="card shadow-lg">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0" id="example1" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">No Jurnal</th>
                      <th class="text-center" style="vertical-align: middle;">Kode Rekening</th>
                      <th class="text-center" style="vertical-align: middle;">Uraian</th>
                      <th class="text-center" style="vertical-align: middle;">Debet</th>
                      <th class="text-center" style="vertical-align: middle;">Kredit</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      @if(count($jurnal) > 0)
                      @foreach($jurnal as $number => $jurnal)
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{ $jurnal->dt_bukti }}</td>
                      <td>{{ $jurnal->no_jurnal }}</td>
                      <td>{{ $jurnal->kode }} <br> {{ $jurnal->ur_kode}}</td>
                      <td>{{ $jurnal->uraian }}</td>
                      <td class="text-right">{{number_format($jurnal->debet, '2', ',', '.') }}</td>
                      <td class="text-right">{{number_format($jurnal->kredit, '2', ',', '.') }}</td>
                    </tr>
                    @php
                        $total_debet += $jurnal->debet;
                        $total_kredit += $jurnal->kredit;
                    @endphp
                    @endforeach
                    @else
                    <tr>
                      <td colspan="6">Tidak ada data</td>
                    </tr>
                    @endif
                  </tr>
                </tbody>

                <tfoot style="background-color: #1db790">
                  <tr>
                      <th class="text-center" colspan="5">Total</th>
                      <th class="text-right">{{number_format($total_debet, 2, ',', '.')}}</th> 
                      <th class="text-right">{{number_format($total_kredit, 2, ',', '.')}}</th>
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
<!-- medium modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mediumBody">
            <div>
                <!-- the result to be displayed apply here -->
            </div>
        </div>
    </div>
</div>
</div>

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
    $('#example').DataTable( {
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal( {
            header: function ( row ) {
              var data = row.data();
              return 'Details for '+data[0]+' '+data[1];
            }
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
            tableClass: 'table'
          })
        }
      }
    });
    var tahun = {{tahun()}};
    $('#reservation').data('daterangepicker').setStartDate('01/01/'+tahun);
  });

  // display a modal (medium modal)
  $(document).on('click', '#mediumButton', function(event) {
    event.preventDefault();
    let href = $(this).attr('data-attr');
    $.ajax({
        url: href,
        beforeSend: function() {
            $('#loader').show();
        },
        // return the result
        success: function(result) {
            $('#mediumModal').modal("show");
            $('#mediumBody').html(result).show();
        },
        complete: function() {
            $('#loader').hide();
        },
        error: function(jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
            $('#loader').hide();
        },
        timeout: 8000
    })
  });
</script>

@endsection