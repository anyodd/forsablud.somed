@extends('layouts.template')
@section('title', 'Pembiayaan Rinci')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Data  @yield('title') atas : {{ $tb_bp->No_bp}} - {{ $tb_bp->Ur_bp ?? 'BLUD '}} </h3>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div >
                            <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus-circle"></i> Tambah</button>
                            <a href="{{ route('pembiayaan.index')}}" class="btn btn-sm btn-success float-right">
                                <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                            </a>
                        </div>

                        <table class="table table-sm table-bordered table-striped tableIndex" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">No Bukti</th>
                                    <th class="text-center">Uraian</th>
                                    <th class="text-center">Rek. Transfer</th>
                                    <th class="text-center">Tgl Transfer</th>
                                    <th class="text-center">No Pendapatan</th>
                                    <th class="text-center">Nilai (Rp)</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            @if(count($tbbprc ?? '') > 0 )
                            <tbody>
                                @foreach ($tbbprc as $item)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}.</td>
                                    <td>{{$item->No_bp}}</td>
                                    <td>{{$item->Ur_bprc}}</td>
                                    <td class="text-center">{{$item->Ko_Rkk}}</td>
                                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_rftrbprc)) }}</td>                      
                                    <td>{{$item->No_PD}}</td>
                                    <td class="text-right">{{number_format($item->To_Rp,2,',','.')}}</td>
                                    <td style="width: 10%">
                                      <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                          <a href="{{route('pembiayaanrinci.edit', $item->id_bprc)}}"
                                              class="btn btn-sm btn-warning btn-block" title="Lihat rincian" style="display: flex; align-items: center; justify-content: center;"> 
                                              <i class="fa fa-edit"></i>
                                          </a>
                                        </div>
                                        <div class="col-sm-4">
                                          <button class="btn btn-sm btn-danger" type="button" style="display: flex; align-items: center; justify-content: center;"
                                              data-toggle="modal"
                                              data-target="#modal{{ $item->id_bprc }}"><i
                                                  class="fas fa-trash"></i>
                                          </button>
                                          <div class="modal fade" id="modal{{ $item->id_bprc }}"
                                              tabindex="-1" role="dialog"
                                              aria-labelledby="exampleModalCenterTitle"
                                              aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered"
                                                  role="document">
                                                  <div class="modal-content">
                                                      <div class="modal-header bg-info">
                                                          <h5 class="modal-title"
                                                              id="exampleModalLongTitle">
                                                              Konfirmasi :</h5>
                                                          <button type="button" class="close"
                                                              data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                          </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <p class="text-center">Yakin Mau Hapus Data
                                                          </p>
                                                          <p class="text-center">
                                                              <b>{{ $item->id_bprc }}</b>
                                                          </p>
                                                      </div>
                                                      <div class="modal-footer">
                                                          <form
                                                              action="{{ route('pembiayaanrinci.destroy', $item->id_bprc) }}"
                                                              method="post">
                                                              @csrf
                                                              @method('DELETE')
                                                              <button type="submit"
                                                                  class="btn btn-danger mr-3"
                                                                  name="submit" title="Hapus">Ya, Hapus
                                                              </button>
                                                          </form>
                                                          <button type="button" class="btn btn-primary"
                                                              data-dismiss="modal">Kembali</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif

                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
      </div><!-- /.container-fluid -->
        @include('transaksi.pembiayaanrinci.create')
        @include('transaksi.pembiayaanrinci.popup_kegiatan')

       @if(count($tbbprc ?? '') > 0 )
        {{-- @include('pembukuan.penyesuaian.edit') --}}
       @endif
       {{-- @include'sesuai.destroybukuan.sesuai.popu'sesuai.destroyening') --}}

    </section>
    <!-- /.content -->
@endsection

@section('script')
<script>
  $(document).ready(function() {
      $('.tableIndex').DataTable({
          responsive: {
              details: {
                  display: $.fn.dataTable.Responsive.display.modal({
                      header: function(row) {
                          var data = row.data();
                          return 'Details for ' + data[0] + ' ' + data[1];
                      }
                  }),
                  renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                      tableClass: 'table'
                  })
              }
          }
      });
  });
 $(function () {
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
    });

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });


     $("#example3").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
    $('#example4').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $(document).on('click','#pilih',function() {
        var kd_keg1 = $(this).data('k_skeg1');
        var kd_keg2 = $(this).data('k_skeg2');
        var u_keg = $(this).data('u_keg');
        var k_r = $(this).data('k_rek');
        $('#sKo_sKeg1').val(kd_keg1);
        $('#sKo_sKeg2').val(kd_keg2);
        $('#Ko_Rkk').val(k_r);
        $('#ur_skeg').val(u_keg);
        $('#modal_kegiatan').hide();
    });

  })

  // DropzoneJS Demo Code End
</script>
@endsection
