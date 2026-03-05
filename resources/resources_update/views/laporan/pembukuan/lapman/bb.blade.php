@extends('layouts.template')
@section('title', 'Buku Besar')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <!-- About Me Box -->
        <div class="card card-info mt-2">
          <div class="card-header bg-info">
            <h5 class="card-title font-weight-bold">BUKU BESAR</h5> 
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('laporan.pembukuan.lapman.lapman_head')
              <table id="example1" class="table table-sm table-hover table-bordered table-striped" style="width: 100">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width: 3px">No.</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Kode Jurnal</th>
                    <th class="text-center">No Jurnal</th>
                    <th class="text-center">Uraian</th>
                    <th class="text-center">Kode Rek</th>
                    <th class="text-center">Debet</th>
                    <th class="text-center">Kredit</th>
                    <th class="text-center">Saldo</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $no = 1;
                    $total = 0;
                  @endphp

                  @foreach ($bb as $item)
                  <tr>

                    <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_bp)) }}</td>                      
                    <td>{{ $item->Ko_jr }}</td>
                    <td>{{ $item->Buktijr_No }}</td>
                    <td>{{ $item->Uraian }}</td>
                    <td class="text-center">{{ $item->Ko_Rkk }}</td>
                    <td class="text-right">
                      {{ number_format($item->Debet, 0, ",", ".") }}
                    </td>
                    <td class="text-right">
                      {{ number_format($item->Kredit, 0, ",", ".") }}
                    </td>
                    <td class="text-right">
                      {{ number_format($total += $item->Debet - $item->Kredit, 0, ",", ".") }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-center font-weight-bold" colspan="6">Jumlah</td>
                    <td class="text-right font-weight-bold" >{{ number_format($totald, 0, ",", ".") }}</strong></td>
                    <td class="text-right font-weight-bold" >{{ number_format($totalk, 0, ",", ".") }}</strong></td>
                    <td class="text-right font-weight-bold" >{{ number_format($totald-$totalk, 0, ",", ".") }}</strong></td>
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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "searching": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        })

        // DropzoneJS Demo Code End
    </script>
@endsection

