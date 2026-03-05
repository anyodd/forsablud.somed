@extends('layouts.template')
@section('title', 'Rincian Penyesuaian')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-sm card-info">
                        <div class="card-header">
                            <h3 class="card-title"> @yield('title')</h3>
                        </div>
                    <form action="{{ route('penyesuaian_rinci.update',$data->id_jr) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Cari</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-1">
                                    {{-- <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#modaltransaksi">
                                        <i class="fas fa-search"></i> Transaksi
                                    </a> --}}

                                    <a href="#" class="btn btn-outline-primary" id="viewTransaksi">
                                      <i class="fas fa-search"></i> Transaksi
                                    </a>
                                </div>
                                <div class="col-sm-0">
                                    {{-- <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalrekening">
                                        <i class="fas fa-search"></i> Rekening
                                    </a> --}}
                                    <a href="#" class="btn btn-outline-primary" id="viewRekening">
                                      <i class="fas fa-search"></i> Rekening
                                    </a>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="No_bp" id="no_bp" class="form-control" placeholder="No Bukti Transaksi" value="{{ $data->No_bp }}" readonly>
                                    <input type="text" name="Ko_DK" class="form-control" value="{{ $data->Ko_DK }}" hidden>
                                    <input type="text" name="id_tbses" class="form-control" value="{{ $data->id_tbses }}" hidden>
                                    <input type="text" name="Ko_bprc" id="ko_bprc" class="form-control" placeholder="No Rincian Transaksi" value="{{ $data->Ko_bprc }}" hidden>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Program</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_sKeg1" id="ko_skeg1" class="form-control" placeholder="Kode Program" value="{{ $data->Ko_sKeg1 }}" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="Uraian Program" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Kegiatan</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_sKeg2" id="ko_skeg2" class="form-control" placeholder="Kode Kegiatan" value="{{ $data->Ko_sKeg2 }}" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="Uraian Kegiatan" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Akun</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_Rkk" id="ko_rkk"class="form-control" placeholder="Kode Akun" value="{{ $data->Ko_Rkk }}" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="uraian_akun" placeholder="Uraian Akun" readonly>
                                </div>
                            </div>
                            @if ($data->Ko_DK == 'D')
                            <div class="form-group row">
                              <label for="" class="col-sm-2 col-form-label">Debet (Rp)</label>
                              <label for="" class="col-form-label">:</label>
                              <div class="col-sm-3">
                                  <input type="text" name="Rp_D" id="rp_d" class="form-control desimal" placeholder="Nilai (Rp)" value="{{ number_format($data->Rp_D,2,',','.') }}">
                              </div>
                            </div>
                            @else
                            <div class="form-group row">
                              <label for="" class="col-sm-2 col-form-label">Kredit (Rp)</label>
                              <label for="" class="col-form-label">:</label>
                              <div class="col-sm-3">
                                  <input type="text" name="Rp_K" id="rp_k" class="form-control decimal" placeholder="Nilai (Rp)" value="{{ number_format($data->Rp_K,2,',','.') }}">
                              </div>
                            </div>  
                            @endif
                            <div class="form-group">
                                <button type="submit" class="col-sm-1 btn btn-primary" name="submit">
                                  <i class="far fa-save pr-2"></i>Simpan
                                </button>
                                <a href="javascript:history.back()" class="col-sm-1 btn btn-info float-right">
                                  <i class="fas fa-backward pr-2"></i>Kembali
                                </a> 
                            </div>
                        </form>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        @include('pembukuan.penyesuaiandetail.popup.transaksi')
        @include('pembukuan.penyesuaiandetail.popup.rekening')

    </section>
@endsection

@section('script')
    <script>
        $(function() {
            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable();
            $("#example2").DataTable();
            $('#example3').DataTable();

            $(document).on('click', '#transaksi', function() {
                var nobp    = $(this).data('nobp');
                var kobprc  = $(this).data('kobprc');
                var skeg1   = $(this).data('skeg1');
                var skeg2   = $(this).data('skeg2');
                var korkk   = $(this).data('korkk');

                $('#no_bp').val(nobp);
                $('#ko_bprc').val(kobprc);
                $('#ko_skeg1').val(skeg1);
                $('#ko_skeg2').val(skeg2);
                $('#ko_rkk').val(korkk);
                $('#uraian_akun').val('');
            });

            $(document).on('click', '#rekening', function() {
                var korkk   = $(this).data('korkk');
                var ur_rkk  = $(this).data('ur_rkk');
                $('#no_bp').val('');
                $('#ko_bprc').val('');
                $('#ko_skeg1').val('');
                $('#ko_skeg2').val('');
                $('#ko_rkk').val(korkk);
                $('#uraian_akun').val(ur_rkk);
            });

        })

        $('#viewTransaksi').click(function () { 
        $('#modaltransaksi').modal('show');
        $('#tbl_transaksi').DataTable();
        $('#tbl_transaksi').DataTable({
          lengthChange: true,
          processing: true,
          serverSide: true,
          destroy: true,
          autoWidth: false,
          ajax:'{{ URL::route('penyesuaian.getTransaksi') }}',
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '3%'},
            {data: 'Ko_sKeg1', name: 'Ko_sKeg1'},
            {data: 'Ko_sKeg2', name: 'Ko_sKeg2'},
            {data: 'No_bp', name: 'No_bp'},
            {data: 'dt_rftrbprc', name: 'dt_rftrbprc'},
            {data: 'Ur_bprc', name: 'Ur_bprc'},
            {data: 'Ko_Rkk', name: 'Ko_Rkk'},
            {data: 'spirc_Rp', name: 'spirc_Rp', className: 'text-right', render: $.fn.DataTable.render.number('.',',',2)},
            {data: 'action', name: 'action'}
          ]
        });
      });

      $('#viewRekening').click(function () { 
        $('#modalrekening').modal('show');
        $('#tbl_rekening').DataTable({
          lengthChange: true,
          processing: true,
          serverSide: true,
          destroy: true,
          autoWidth: false,
          ajax:'{{ URL::route('penyesuaian.getRekening') }}',
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '3%'},
            {data: 'Ko_RKK', name: 'Ko_RKK', width: '10%'},
            {data: 'Ur_Rk6', name: 'Ur_Rk6'},
            {data: 'action', name: 'action'}
          ]
        });
      });
        
    </script>
@endsection
