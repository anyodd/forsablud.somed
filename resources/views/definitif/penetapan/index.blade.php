@extends('layouts.template')

@section('content')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">DAFTAR PENETAPAN</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        {{--<div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('penetapan.create') }}">
                                    <button class="btn btn-sm btn-primary mb-2" title="tambah">
                                        <i class="fas fa-plus-circle pr-1"></i>Tambah
                                    </button>
                                </a>
                            </div>
                        </div>--}}
                        <div class="row my-3">
                            <div class="col-6 text-left">
                              <a href="{{ route('penetapan.create') }}" class="btn btn-outline-primary btn-sm" title="Tambah Penetapan RBA">
                                <i class="fas fa-plus"></i> Tambah Penetapan
                              </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0" width="100%" cellspacing="0"
                                id="tabelPenetapan" style="text-align: center;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="vertical-align: middle;">Kode Penetapan</th>
                                        <th style="vertical-align: middle;">Uraian Penetapan</th>
                                        <th style="vertical-align: middle;">Nomor Penetapan</th>
                                        <th style="vertical-align: middle;">Tanggal Penetapan</th>
                                        <th style="vertical-align: middle;">Nomor DPA</th>
                                        <th style="vertical-align: middle;">Tanggal DPA</th>
                                        <th style="vertical-align: middle;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tap as $row)
                                    <tr>
                                        <td>{{ $row->Ko_Tap }}</td>
                                        <td>{{ $row->Ur_Tap }}</td>
                                        <td>{{ $row->No_Tap }}</td>
                                        <td>{{ date('d M Y', strtotime($row->Dt_Tap)) }}</td>
                                        <td>{{ $row->No_DPA }}</td>
                                        <td>{{ date('d M Y', strtotime($row->Dt_DPA)) }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <form action="{{ route('penetapan.edit', $row->id_tap) }}"
                                                        method="get" class="">
                                                        <button class="btn btn-warning btn-block"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Edit" type="submit">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn btn-danger btn-block" data-toggle="modal"
                                                        data-target="#modal{{ $row->id }}"
                                                        style="display: flex; align-items: center; justify-content: center;"
                                                        title="Hapus">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal{{ $row->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                            <h6>Yakin ingin menghapus data Nomor Penetapan APBD: {{
                                                                $row->No_Tap }} ?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('penetapan.destroy', $row->id) }}"
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
        $('#tabelPenetapan').DataTable({
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