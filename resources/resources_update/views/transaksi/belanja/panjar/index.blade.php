@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">Data Panjar</h5>
                    </div>

                    <div class="card-body px-2 py-2">
                        <a href="{{ route('panjar.create') }}">
                            <button class="btn btn-sm btn-primary mb-2">
                                <i class="fas fa-plus-circle pr-1"></i>
                                Tambah
                            </button>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%"
                                cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 3%;">No.</th>
                                        <th class="text-center" style="vertical-align: middle;">Nomor Bukti</th>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Bukti</th>
                                        <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                        <th class="text-center" style="vertical-align: middle;">Nama Pihak Lain</th>
                                        <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                                        <th class="text-center" style="vertical-align: middle;">Pajak (Rp)</th>
                                        <th class="text-center" style="width: 11%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($panjar as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $row->No_bp }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($row->dt_bp)) }}</td>                      
                                        <td>{{ $row->Ur_bp }}</td>
                                        <td>{{ $row->rekan_nm }}</td>
                                        <td class="text-right">{{ number_format($row->jml,2,',','.') }}</td>
                                        <td class="text-right">{{ number_format($row->t_tax,0,',','.') }}</td> 
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-3">
                                                    <form action="{{ route('panjar-rinci.pilih', $row->id_bp) }}"
                                                        method="get">
                                                        <button class="btn btn-sm btn-info "
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Detail"><i class="fas fa-angle-double-right"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a href="{{route('panjar.pajak', $row->id_bp)}}">
                                                        <button class="btn btn-sm btn-outline-secondary"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Potong Pajak">
                                                            <i class="fas fa-money-check"></i></button>
                                                    </a>
                                                </div>
                                                <div class="col-sm-3">
                                                    <form action="{{ route('panjar.edit', $row->id_bp) }}" method="get">
                                                        <button class="btn btn-warning btn-sm"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Edit"><i class="far fa-edit"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                               @if ($row->jml == 0)
                                                <div class="col-sm-3">
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#modal{{ $row->id_bp }}"
                                                        style="display: flex; align-items: center; justify-content: center;"
                                                        title="Hapus"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                @else
                                                <div class="col-sm-3">
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#modal{{ $row->id_bp }}"
                                                        style="display: flex; align-items: center; justify-content: center;"
                                                        title="Hapus" disabled><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal fade" id="modal{{ $row->id_bp }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Konfirmasi :</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left">
                                                            <h6>Yakin ingin menghapus Panjar Nomor {{ $row->No_bp }}?
                                                            </h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('panjar.destroy', $row->id_bp) }}"
                                                                method="post" class="">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger mr-3"
                                                                    name="submit" title="Hapus">Ya, Hapus</button>
                                                            </form>
                                                            <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">Kembali</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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