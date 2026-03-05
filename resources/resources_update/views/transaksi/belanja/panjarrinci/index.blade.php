@extends('layouts.template')
@section('style') @endsection
@section('content')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">RINCIAN PANJAR</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('panjar-rinci.tambah', $panjar->id_bp) }}">
                                    <button class="btn btn-sm btn-primary mb-2" title="tambah">
                                        <i class="fas fa-plus-circle pr-1"></i>Tambah
                                    </button>
                                </a>
                                <a href="{{ route('panjar.index') }}">
                                    <button class="btn btn-sm btn-secondary mb-2 ml-1" title="kembali">
                                        <i class="far fa-arrow-alt-circle-left pr-1"></i>Kembali
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0" id="panjarRinci" width="100%"
                                cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%;">No Rincian</th>
                                        <th class="text-center" style="vertical-align: middle;">No Bukti</th>
                                        <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                        <th class="text-center" style="vertical-align: middle;">No Ref Bukti</th>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Ref Bukti
                                        </th>
                                        <th class="text-center" style="vertical-align: middle;">Kode Kegiatan APBD
                                        </th>
                                        <th class="text-center" style="vertical-align: middle;">Kode Kegiatan BLU
                                        </th>
                                        <th class="text-center" style="vertical-align: middle;">Kode Akun</th>
                                        <th class="text-center " style="vertical-align: middle;">Nilai (Rp)</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($panjar_detail as $row)
                                    <tr>
                                        <td class="text-center">{{ $row->Ko_bprc }}</td>
                                        <td>{{ $row->No_bp }}</td>
                                        <td>{{ $row->Ur_bprc }}</td>
                                        <td>{{ $row->rftr_bprc }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($row->dt_rftrbprc)) }}</td>                      
                                        <td>{{ $row->Ko_sKeg1 }}</td>
                                        <td>{{ $row->Ko_sKeg2 }}</td>
                                        <td>{{ $row->Ko_Rkk }}</td>
                                        <td>{{ number_format($row->To_Rp,2,',','.') }}</td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-6">
                                                    <form action="{{ route('panjar-rinci.edit', $row->id_bprc) }}"
                                                        method="get">
                                                        <button class="btn btn-warning btn-block"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Edit"><i class="far fa-edit"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn btn-danger btn-block mr-3" data-toggle="modal"
                                                        data-target="#modal{{ $row->id_bprc }}"
                                                        style="display: flex; align-items: center; justify-content: center;"
                                                        title="Hapus"><i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="modal{{ $row->id_bprc }}" tabindex="-1"
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
                                                                <h6>Yakin ingin menghapus Rincian Panjar Nomor {{
                                                                    $row->Ko_bprc
                                                                    }}?
                                                                </h6>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('panjar-rinci.destroy', $row->id_bprc) }}"
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
</section>


@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#panjarRinci').DataTable({
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
</script>

@endsection