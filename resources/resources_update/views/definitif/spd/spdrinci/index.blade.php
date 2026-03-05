@extends('layouts.template')

@section('content')

<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">DAFTAR RINCIAN SPD - {{ nm_bidang() }}</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('spd-rinci.tambah', $spd->id) }}">
                                    <button class="btn btn-sm btn-primary mb-2" title="tambah">
                                        <i class="fas fa-plus-circle pr-1"></i>Tambah
                                    </button>
                                </a>
                                <a href="{{ route('spd.index') }}">
                                    <button class="btn btn-sm btn-secondary mb-2 ml-1" title="kembali">
                                        <i class="far fa-arrow-alt-circle-left pr-1"></i>Kembali
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0" width="100%" cellspacing="0"
                                id="tabelSpd" style="text-align: center;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="vertical-align: middle;">Nomor SPD</th>
                                        <th style="vertical-align: middle;">Nomor Urut</th>
                                        <th style="vertical-align: middle;">Kode Kegiatan APBD</th>
                                        <th style="vertical-align: middle;">Kode Kegiatan BLU</th>
                                        <th style="vertical-align: middle;">Kode Akun</th>
                                        <th style="vertical-align: middle;">Uraian</th>
                                        <th style="vertical-align: middle;">Nilai (Rp)</th>
                                        <th style="vertical-align: middle;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spd_rinc as $row)
                                    <tr>
                                        <td>{{ $row->No_PD }}</td>
                                        <td>{{ $row->Ko_PDrc }}</td>
                                        <td>{{ $row->Ko_sKeg1 }}</td>
                                        <td>{{ $row->Ko_sKeg2 }}</td>
                                        <td>{{ $row->Ko_Rkk }}</td>
                                        <td style="text-align: left">{{ $row->Ur_Rc }}</td>
                                        <td style="text-align: right">{{ number_format($row->To_Rp, 2, ',', '.') }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <form action="{{ route('spd-rinci.edit', $row->id) }}" method="get">
                                                        <button class="btn btn-warning btn-block"
                                                            style="display: flex; align-items: center; justify-content: center;"
                                                            title="Edit"><i class="far fa-edit"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn btn-danger btn-block mr-3" data-toggle="modal"
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
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Konfirmasi :</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left">
                                                            <h6>Yakin ingin menghapus SPD {{ $row->No_PD }} nomor urut
                                                                {{
                                                                $row->Ko_PDrc }}?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('spd-rinci.destroy', $row->id) }}"
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
        $('#tabelSpd').DataTable({
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