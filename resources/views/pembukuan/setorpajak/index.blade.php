@extends('layouts.template')
@section('title', 'Setor Pajak')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info mt-2">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold"></i> Setor Pajak</h5> 
                    </div>

                    <div class="card-body">
                        <table id="tblpajak" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 3%">No</th>
                                    <th style="text-align: center">Nama Rekanan</th>
                                    <th style="text-align: center">Total Pajak (Rp)</th>
                                    <th style="text-align: center">Setor Pajak (Rp)</th>
                                    <th style="text-align: center; width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            @if (!empty($pajak))
                            <tbody>
                                @foreach ($pajak as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $item->rekan_nm }}</td>
                                    <td class="text-right">{{ number_format($item->t_tax,2,',','.') }}</td>
                                    <td class="text-right">{{ number_format($item->setor,2,',','.') }}</td>
                                    <td class="text-center">
                                        <a href="{{route('setorpajak.show',$item->id_rekan)}}"
                                            class="btn btn-sm btn-success" title="Rincian"> <i
                                            class="fa fa-list"></i>
                                        </a>

                                    </td>
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
      $('#tblpajak').DataTable({
        pageLength: 20,
        stateSave: true,
      });
  });
</script>
@endsection