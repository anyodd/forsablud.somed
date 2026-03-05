@extends('layouts.template')
@section('title', 'Rincian Pajak')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 my-2">
                <a href="{{route('pajak.index')}}" class="btn btn-sm btn-primary">
                    <i class="fas fa-arrow-circle-left"> Kembali</i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                     <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold">Daftar Rincian Pajak</h5> 
                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 3%">No</th>
                                    <th style="text-align: center">Nama Rekanan</th>
                                    <th style="text-align: center">No. Tagihan</th>
                                    <th style="text-align: center">Uraian Tagihan</th>
                                    <th style="text-align: center">Jenis Pajak</th>
                                    <th style="text-align: center">Keterangan Pajak</th>
                                    <th style="text-align: center">Potong Pajak (Rp)</th>
                                </tr>
                            </thead>
                            @if (!empty($pajak_rinci))
                            <tbody>
                                @foreach ($pajak_rinci as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item->rekan_nm }}</td>
                                    <td>{{ $item->No_bp }}</td>
                                    <td>{{ $item->Ur_bp }}</td>
                                    <td>{{ $item->ur_rk6 }}</td>
                                    <td>{{ $item->Ko_tax }}</td>
                                    <td style="text-align: right">{{ number_format($item->tax_Rp,2,',','.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
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
  });
</script>
@endsection