@extends('layouts.template')
@section('title', 'Pajak')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <a href="{{ route('pengesahan.index') }}" class="btn btn-sm btn-info" id="kembali">
                    <i class="fas fa-arrow-alt-circle-left"></i> Kembali
                </a>
            </div>
            <div class="col-md-12">
                <div class="card card-info mt-2">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold">Daftar Pajak Atas SP3B Nomor : {{$sp3->No_sp3}}</h5> 
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped" id="tbl_sp3b">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 3%">No</th>
                                    {{-- <th style="text-align: center">Nomor SP3B</th> --}}
                                    <th style="text-align: center">Nama Rekanan</th>
                                    <th style="text-align: center">No Bukti</th>
                                    <th style="text-align: center">Kode Rekening</th>
                                    <th style="text-align: center">Uraian</th>
                                    <th style="text-align: center">Tanggal Terima</th>
                                    <th style="text-align: center">Tanggal Setor</th>
                                    <th style="text-align: center">Terima</th>
                                    <th style="text-align: center">Setor</th>
                                    <th style="text-align: center">Saldo</th>
                                </tr>
                            </thead>
                            @php
                                $total = 0;
                                $total_terima = 0;
                                $total_setor = 0;
                            @endphp
                            @if (!empty($pajak))
                            <tbody>
                                @foreach ($pajak as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    {{-- <td>{{ $item->No_sp3 }}</td> --}}
                                    <td>{{ $item->rekan_nm }}</td>
                                    <td>{{ $item->No_Bukti }}</td>
                                    <td>{{ $item->Ko_Rkk }}</td>
                                    <td>{{ $item->Uraian }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($item->dt_taxt)) }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($item->dt_taxs)) }}</td>
                                    <td class="text-right">{{ number_format($item->Terima,2,',','.') }}</td>
                                    <td class="text-right">{{ number_format($item->Setor,2,',','.') }}</td>
                                    <td class="text-right">{{ number_format($item->Terima - $item->Setor,2,',','.') }}</td>
                                </tr>
                                <p hidden>{{ number_format($total += $item->Terima - $item->Setor,2,',','.') }}</p>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-right"><dt>Total</dt></td>
                                    <td class="text-right"><dt>{{ number_format($terima,2,',','.') }}</dt></td>
                                    <td class="text-right"><dt>{{ number_format($setor,2,',','.') }}</dt></td>
                                    <td class="text-right"><dt>{{ number_format($total,2,',','.') }}</dt></td>
                                </tr>
                            </tbody> 
                            @else
                            @endif
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
      $('#tbl_sp3b').DataTable( {
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
  });
</script>
@endsection