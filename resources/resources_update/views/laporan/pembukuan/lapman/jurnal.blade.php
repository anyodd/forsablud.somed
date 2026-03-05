@extends('layouts.template')
@section('title', 'Daftar Jurnal')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <!-- About Me Box -->
        <div class="card card-info">
          <div class="card-header">
            @yield('title')
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('laporan.pembukuan.lapman.lapman_head')
            <table class="table" style="width: 100%">
            </table>
            {{-- <table class="table table-bordered table-striped" style="width: 100%"> --}}
              <table id="example1" class="table table-sm table-hover table-bordered table-striped" style="width: 100">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width: 3px">No.</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">No Bukti</th>
                    <th class="text-center">Uraian</th>
                    <th class="text-center">Kode Rek</th>
                    <th class="text-center">Debet</th>
                    <th class="text-center">Kredit</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($jurnal as $item)
                  @php

                  $nilai_debet[] = $item->Debet;
                  $total_debet = array_sum($nilai_debet);
                  $nilai_kredit[] = $item->Kredit;
                  $total_kredit = array_sum($nilai_kredit);
                  @endphp
                  <tr>

                    <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_bp)) }}</td>                      
                    <td>{{ $item->Buktijr_No }}</td>
                    <td>{{ $item->Ur_bp }}</td>
                    <td>{{ $item->Ko_Rkk }} <br> ({{ $item->Ur_RK6 }}</td>
                    <td style="text-align: right">
                      {{ number_format($item->Debet, 0, ",", ".") }}
                    </td>
                    <td style="text-align: right">
                      {{ number_format($item->Kredit, 0, ",", ".") }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-center font-weight-bold" colspan="5">Jumlah</td>
                    <td class="text-right font-weight-bold" >{{ number_format($totald, 0, ",", ".") }}</strong></td>
                    <td class="text-right font-weight-bold" >{{ number_format($totalk, 0, ",", ".") }}</strong></td>
                  </tr>
                </tfoot>
              </table><br>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->

  </section>
  <!-- /.content -->
  @endsection

  @section('script')
  <script>
    $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })

            $("#example1").DataTable({
              "responsive": true,
              "lengthChange": false,
              "autoWidth": false,
              "searching": true,
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          })

        // DropzoneJS Demo Code End
      </script>
      @endsection
