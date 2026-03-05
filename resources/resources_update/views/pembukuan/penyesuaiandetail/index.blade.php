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
                    <form action="{{ route('penyesuaian_rinci.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Nomor Penyesuaian</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-5">
                                    <input type="text" name="Sesuai_No" class="form-control" value="{{ $sesuai[0]->Sesuai_No }}" readonly>
                                    <input type="text" name="id_tbses" class="form-control" value="{{ $sesuai[0]->id_tbses }}" hidden>
                                    <input type="text" name="dt_sesuai" class="form-control" value="{{ $sesuai[0]->dt_sesuai }}" hidden>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Jenis Jurnal</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-5">
                                    <select id="Ko_jr" name="Ko_jr"
                                        class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" disabled>
                                        <option value="">--Pilih Jenis Jurnal--</option>
                                        @foreach ($pf_sesuai as $ls)
                                            <option value="{{ $ls->id_sesuai }}" {{$sesuai[0]->Ko_jr == $ls->id_sesuai ? 'selected' : ''}}>{{ $ls->Ur_sesuai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                                    <input type="text" name="No_bp" id="no_bp" class="form-control" placeholder="No Bukti Transaksi" readonly>
                                </div>
                                {{-- <div class="col-sm"> --}}
                                    <input type="text" name="Ko_bprc" id="ko_bprc" class="form-control" placeholder="No Rincian Transaksi" hidden>
                                {{-- </div> --}}
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Program</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_sKeg1" id="ko_skeg1" class="form-control" placeholder="Kode Program" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="Uraian Program" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Kegiatan</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_sKeg2" id="ko_skeg2" class="form-control" placeholder="Kode Kegiatan" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="Uraian Kegiatan" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Akun</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Ko_Rkk" id="ko_rkk"class="form-control" placeholder="Kode Akun" readonly>
                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="Uraian Akun" id="uraian_akun" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="Sesuai_Rp" class="form-control decimal" placeholder="Nilai (Rp)" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Debet/Kredit</label>
                                <label for="" class="col-form-label">:</label>
                                <div class="col-sm-3">
                                    <select name="Ko_DK" class="form-control" required>
                                        <option class="text-center" value="">-- Pilih Debet/Kredit --</option>
                                        <option value="D">Debet</option>
                                        <option value="K">Kredit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="col-sm-1 btn btn-primary" name="submit">
                                  <i class="far fa-save pr-2"></i>Simpan
                                </button>
								{{--<a href="{{ route('penyesuaian.index') }}" class="col-sm-1 btn btn-info float-right">
                                  <i class="fas fa-backward pr-2"></i>Kembali
                                </a>--}}
								<?php
								$t_debet = 0;
								$t_kredit = 0;
								$t_saldo = 0;
								?>
								@foreach ($data as $item)
								<?php
								$t_debet = $item->Rp_D + $t_debet ;
								$t_kredit = $item->Rp_K + $t_kredit;
								$t_saldo = $t_debet - $t_kredit;
								?>
								@endforeach
								@if ( $t_saldo !=  0 )
                                <a href="#" class="col-sm-1 btn btn-danger float-right">
                                  <i class="fas fa-backward pr-2" disabled></i>Kembali
                                </a>             
								@else
								<a href="{{ route('penyesuaian.index') }}" class="col-sm-1 btn btn-info float-right">
                                  <i class="fas fa-backward pr-2"></i>Kembali
                                </a>
								@endif 
                            </div>
                        </form>
                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3%">No</th>
                                        <th>No. Penyesuaian</th>
                                        <th>No. Transaksi</th>
                                        <th>No. Rinci Transaksi</th>
                                        <th>Program</th>
                                        <th>Kegiatan</th>
                                        <th>Akun</th>
                                        <th class="text-center">Debet</th>
                                        <th class="text-center">Kredit</th>
                                        <th class="text-center" style="width: 8%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t_debet = 0;
                                        $t_kredit = 0;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <td style="text-align: left;max-width: 50px;">{{ $loop->iteration }}.</td>
                                            <td>{{ $item->Sesuai_No }}</td>
                                            <td>{{ $item->No_bp }}</td>
                                            <td>{{ $item->Ko_bprc }}</td>
                                            <td>{{ $item->Ko_sKeg1 }}</td>
                                            <td>{{ $item->Ko_sKeg2 }}</td>
                                            <td>{{ $item->Ko_Rkk }} - {{$item->Ur_Rk6}}</td>
                                            @if ($item->Rp_D != 0)
                                                <td class="text-right">{{ number_format($item->Rp_D,2,',','.') }}</td>                                        
                                                <td class="text-right">-</td> 
                                            @else
                                                <td class="text-right">-</td>                                        
                                                <td class="text-right">{{ number_format($item->Rp_K,2,',','.') }}</td> 
                                            @endif                                       
                                            <td class="text-center">
                                                <a href="{{ route('penyesuaian_rinci.edit',$item->id_jr) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$item->id_jr}}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="delete{{ $item->id_jr }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <h6>Yakin mau hapus data  ?</h6>
                                                </div>
                                                <div class="modal-footer">
                                                  <form action="{{ route('penyesuaian_rinci.destroy', $item->id_jr) }}" method="post" class="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                                    </button>
                                                    <input type="text" name="id_tbses" value="{{$item->id_tbses}}" hidden>
                                                  </form>
												  <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" >Kembali</button> 
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        @php
                                            $t_debet += $item->Rp_D;
                                            $t_kredit += $item->Rp_K;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7"></th>
                                        <th class="text-right">{{ number_format($t_debet,2,',','.') }}</th>
                                        <th class="text-right">{{ number_format($t_kredit,2,',','.') }}</th>
                                        <th></th>
                                    </tr>
									<tr height=40px>
										<td width="10%"></td>
										<td width="20%">Total Debit</td>
										<td width="70%" colspan="8"><strong>Rp <span id="totalDebit">{{ number_format($t_debet,2,',','.') }}</span></strong></td>
									</tr>
									<tr height=40px>
										<td width="10%"></td>
										<td width="20%">Total Kredit</td>
										<td width="70%" colspan="8"><strong>Rp <span id="totalKredit">{{ number_format($t_kredit,2,',','.') }}</span></strong></td>
									</tr>
									<tr class="text-danger" height=40px>
										<td width="10%"></td>
										<td width="20%">Selisih</td>
										<td width="70%" colspan="8"><strong>Rp <span id="selisih">{{ number_format($t_debet-$t_kredit,2,',','.') }}</span> (pastikan selisih harus 0)</strong></td>
									</tr>
                                </tfoot>
                            </table>
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
              var ur_rkk   = $(this).data('ur_rkk');
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
