@extends('layouts.template')

@section('content')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">Data Rincian SPP Nihil Panjar</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('sppnihilpanjar-rinci.tambah', $sppnihilpanjar[0]->id) }}">
                                    <button class="btn btn-sm btn-primary mb-2" title="tambah">
                                        <i class="fas fa-plus-circle pr-1"></i>Tambah
                                    </button>
                                </a>
                                <a href="{{ route('sppnihilpanjar.index') }}">
                                    <button class="btn btn-sm btn-secondary mb-2 ml-1" title="kembali">
                                        <i class="far fa-arrow-alt-circle-left pr-1"></i>Kembali
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%"
                                cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle">No</th>
                                        <th class="text-center" style="vertical-align: middle">No. Rincian</th>
                                        <th class="text-center" style="vertical-align: middle">No. Bukti</th>
                                        <th class="text-center" style="vertical-align: middle">Kode Akun</th>
                                        <th class="text-center" style="width: 11%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0;?>
                                    @foreach($sppnihilpanjar_rinci as $row)
                                    <?php $no++ ;?>
                                    <tr>
                                        <td style="text-align: center; width: 5%">{{$no}}</td>
                                        <td style="text-align: center; width: 5%">{{ $row->id }}</td>
                                        <td style="text-align: center">{{ $row->No_spi }}</td>
                                        <td style="text-align: center">{{ $row->Ko_Rkk }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <form action="{{ route('sppnihilpanjar-rinci.edit', $row->id) }}"
                                                        method="get">
                                                        <button class="btn btn-warning btn-block"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Edit"><i class="far fa-edit"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn btn-danger btn-block" data-toggle="modal"
                                                        data-target="#modal{{ $row->id }}"
                                                        style="display: flex; align-items: center; justify-content: center;"
                                                        title="Hapus"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal{{ $row->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Konfirmasi :</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Yakin ingin menghapus data {{ $row->rftr_bprc }} dengan
                                                                nomor bukti {{
                                                                $row->No_spi }} ?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('sppnihilpanjar-rinci.destroy', $row->id) }}"
                                                                method="post" class="">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger mr-3"
                                                                    name="submit" title="Hapus">Ya,
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-primary"
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