@extends('layouts.template')
@section('style')
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection


@section('content')

    <section class="content px-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card shadow-lg mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Pengesahan SP2B</h5>
                        </div>

                        <div class="card-body">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalSp2bRinci"
                                data-backdrop="static">
                                <i class="fas fa-list-alt pr-1"></i>Daftar SP2B
                            </button>
                            @include('pengesahan.popup.modal_sp2b_rinci')
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="example" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="vertical-align: middle; width: 3%">No.</th>
                                            <th class="text-center" style="vertical-align: middle;">Nomor SP3B</th>
                                            <th class="text-center" style="vertical-align: middle; width: 10%">Tanggal SP3B</th>
                                            <th class="text-center" style="vertical-align: middle;">Uraian SP3B</th>
                                            <th class="text-center" style="vertical-align: middle; width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($calon_sp2b->count() > 0)
                                            @foreach ($calon_sp2b as $number => $calon_sp2b)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $calon_sp2b->No_sp3 }}</td>
                                                    <td class="text-center">
                                                        {{ date('d M Y', strtotime($calon_sp2b->Dt_sp3)) }}</td>
                                                    <td>{{ $calon_sp2b->Ur_sp3 }}</td>
                                                    <td>
                                                        <div class="row justify-content-center">
                                                            <div class="col-sm-5">
                                                                <button class="btn btn-sm btn-info btn-primary" type=""
                                                                    name="" value=""
                                                                    style="display: flex; align-items: center; justify-content: center;"
                                                                    data-toggle="modal"
                                                                    data-target="#modalSp2bTambah{{ $calon_sp2b->id_sp3 }}"
                                                                    data-backdrop="static">Pilih
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('pengesahan.popup.modal_sp2b_tambah')
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">Tidak Ada Data</td>
                                            </tr>
                                        @endif
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
    <script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.example1').DataTable();
            $('#example').DataTable({
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

        $(document).on('change', '#Nm_Kuasa', function() {
            let data = document.getElementById("Nm_Kuasa").value;
            let nip  = data.split("|");
            $('#NIP_Kuasa').val(nip[1]);
        });

        $(document).on('change', '#EditNm_Kuasa', function() {
            let data = document.getElementById("EditNm_Kuasa").value;
            let nip = data.split("|");
            $('#EditNIP_Kuasa').val(nip['1']);
        });
    </script>
@endsection
