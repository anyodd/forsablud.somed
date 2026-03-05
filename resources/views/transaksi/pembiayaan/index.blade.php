@extends('layouts.template')
@section('title', 'Pembiayaan')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <button class="btn btn-sm btn-primary my-2" data-toggle="modal" data-backdrop="static"
                data-target="#modal-create">
                <i class="fas fa-plus-circle pr-1"></i> Pembiayaan
            </button>
            <div class="row">
                <div class="col-md-12">
                  <div class="card card-info card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Penerimaan</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Pengeluaran</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                            {{-- Penerimaan --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-0 example" id="example" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" style="width: 3%">No</th>
                                                <th class="text-center" style="vertical-align: middle;">No BP</th>
                                                <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                                                <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                                <th class="text-center" style="vertical-align: middle;">Nama Pihak 3</th>
                                                <th class="text-center" style="vertical-align: middle;">Alamat Pihak 3</th>
                                                <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                                                <th class="text-center" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        @if (count($penerimaan ?? '') > 0)
                                            <tbody>
                                                @foreach ($penerimaan as $item)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                                        <td>{{ $item->No_bp }}</td>
                                                        <td class="text-center">{{ $item->dt_bp }}</td>
                                                        <td>{{ $item->Ur_bp }}</td>
                                                        <td>{{ $item->nm_BUcontr }}</td>
                                                        <td>{{ $item->adr_bucontr }}</td>
                                                        <td class="text-right">{{ number_format($item->jml,2,',','.') }}</td>
                                                        <td>
                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-4">
                                                                    <a
                                                                        href="{{ route('pembiayaan.detail', ['pembiayaan' => $item->id_bp]) }}">
                                                                        <button class="btn btn-sm btn-info"
                                                                            style="display: flex; align-items: center; justify-content: center;"
                                                                            title="Detail">
                                                                            <i class="fas fa-angle-double-right"></i>
                                                                        </button>
                                                                    </a>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-editPenerimaan{{$item->id_bp}}"
                                                                        style="display: flex; align-items: center; justify-content: center;"
                                                                        title="Edit data"><i class="fa fa-edit"> </i>
                                                                    </button>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <button class="btn btn-sm btn-danger" type="button" style="display: flex; align-items: center; justify-content: center;"
                                                                        data-toggle="modal"
                                                                        data-target="#modal{{ $item->id_bp }}"><i
                                                                            class="fas fa-trash"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="modal{{ $item->id_bp }}"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="exampleModalCenterTitle"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header bg-info">
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLongTitle">
                                                                                        Konfirmasi :</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p class="text-center">Yakin Mau Hapus Data
                                                                                    </p>
                                                                                    <p class="text-center">
                                                                                        <b>{{ $item->No_bp }}</b>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <form
                                                                                        action="{{ route('pembiayaan.destroy', $item->id_bp) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger mr-3"
                                                                                            name="submit" title="Hapus">Ya, Hapus
                                                                                        </button>
                                                                                    </form>
                                                                                    <button type="button" class="btn btn-primary"
                                                                                        data-dismiss="modal">Kembali</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('transaksi.pembiayaan.editPenerimaan')
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            {{-- Penerimaan --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                            {{-- Pengeluaran --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-0 example" id="example" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width: 3%">No</th>
                                            <th class="text-center" style="vertical-align: middle;">No BP</th>
                                            <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                                            <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                            <th class="text-center" style="vertical-align: middle;">Nama Pihak 3</th>
                                            <th class="text-center" style="vertical-align: middle;">Alamat Pihak 3</th>
                                            <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                                            <th class="text-center" style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    @if (count($pengeluaran ?? '') > 0)
                                        <tbody>
                                            @foreach ($pengeluaran as $item2)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                                    <td>{{ $item2->No_bp }}</td>
                                                    <td class="text-center">{{ $item2->dt_bp }}</td>
                                                    <td>{{ $item2->Ur_bp }}</td>
                                                    <td>{{ $item2->nm_BUcontr }}</td>
                                                    <td>{{ $item2->adr_bucontr }}</td>
                                                    <td class="text-right">{{ number_format($item2->jml,2,',','.') }}</td>
                                                    <td>
                                                        <div class="row justify-content-center">
                                                            <div class="col-sm-4">
                                                                <a
                                                                    href="{{ route('pembiayaan.detail', ['pembiayaan' => $item2->id_bp]) }}">
                                                                    <button class="btn btn-sm btn-info"
                                                                        style="display: flex; align-items: center; justify-content: center;"
                                                                        title="Detail">
                                                                        <i class="fas fa-angle-double-right"></i>
                                                                    </button>
                                                                </a>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-editPengeluaran{{$item2->id_bp}}"
                                                                    style="display: flex; align-items: center; justify-content: center;"
                                                                    title="Edit data"><i class="fa fa-edit"> </i>
                                                                </button>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <button class="btn btn-sm btn-danger" type="button" style="display: flex; align-items: center; justify-content: center;"
                                                                    data-toggle="modal"
                                                                    data-target="#modal{{ $item2->id_bp }}"><i
                                                                        class="fas fa-trash"></i>
                                                                </button>
                                                                <div class="modal fade" id="modal{{ $item2->id_bp }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalCenterTitle"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-info">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLongTitle">
                                                                                    Konfirmasi :</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-center">Yakin Mau Hapus Data
                                                                                </p>
                                                                                <p class="text-center">
                                                                                    <b>{{ $item2->No_bp }}</b>
                                                                                </p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <form
                                                                                    action="{{ route('pembiayaan.destroy', $item2->id_bp) }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger mr-3"
                                                                                        name="submit" title="Hapus">Ya, Hapus
                                                                                    </button>
                                                                                </form>
                                                                                <button type="button" class="btn btn-primary"
                                                                                    data-dismiss="modal">Kembali</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('transaksi.pembiayaan.editPengeluaran')
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                                </div>
                            </div>
                           {{-- Pengeluaran --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>


            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"> Data: @yield('title')</h3>
                        </div>
                        <div class="card-body">

                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-backdrop="static"
                                data-target="#modal-create">
                                <i class="fas fa-plus-circle pr-1"></i>Tambah Pembiayaan
                            </button>
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center" style="vertical-align: middle;">No BP</th>
                                            <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                                            <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                            <th class="text-center" style="vertical-align: middle;">Nama Pihak 3</th>
                                            <th class="text-center" style="vertical-align: middle;">Alamat Pihak 3</th>
                                            <th class="text-center" style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    @if (count($pembiayaan ?? '') > 0)
                                        <tbody>
                                            @foreach ($pembiayaan as $item)
                                                <tr>
                                                    <td class="text-center" style="width: 3%;">
                                                        {{ $loop->iteration }}.</td>
                                                    <td>{{ $item->No_bp }}</td>
                                                    <td class="text-center">{{ $item->dt_bp }}</td>
                                                    <td>{{ $item->Ur_bp }}</td>
                                                    <td>{{ $item->nm_BUcontr }}</td>
                                                    <td>{{ $item->adr_bucontr }}</td>
                                                    <td>

                                                        <div class="row justify-content-center">
                                                            <div class="col-sm-4">
                                                                <a
                                                                    href="{{ route('pembiayaan.detail', ['pembiayaan' => $item->id_bp]) }}">
                                                                    <button class="btn btn-sm btn-info"
                                                                        style="display: flex; align-items: center; justify-content: center;"
                                                                        title="Detail">
                                                                        <i class="fas fa-angle-double-right"></i>
                                                                    </button>
                                                                </a>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <button class="btn btn-sm btn-warning"
                                                                    style="display: flex; align-items: center; justify-content: center;"
                                                                    title="Edit data" id="edit" data-toggle="modal"
                                                                    data-target="#modal-edit"
                                                                    data-id="{{ $item->id_bp }}"
                                                                    data-periode="{{ $item->Ko_Period }}"
                                                                    data-unit="{{ $item->Ko_unit1 }}"
                                                                    data-datebp="{{ $item->dt_bp }}"
                                                                    data-bpno="{{ $item->No_bp }}"
                                                                    data-bpur="{{ $item->Ur_bp }}"><i
                                                                        class="fa fa-edit"> </i>
                                                                </button>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <form
                                                                    action="{{ route('pembiayaan.destroy', ['pembiayaan' => $item->id_bp]) }}"
                                                                    method="post" class="d-inline"
                                                                    onsubmit="return confirm('Yakin hapus {{ $item->Ur_bp }} berserta JURNAL RINCIAN?')">
                                                                    @method("delete")
                                                                    @csrf
                                                                    <button class="btn btn-sm btn-danger"
                                                                        style="display: flex; align-items: center; justify-content: center;"
                                                                        title="Hapus Data" type="submit" data-name=""
                                                                        data-table="Pembiayaan">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                </form>
                                                            </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif

                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div> --}}
            
        <!-- /.row -->
        </div><!-- /.container-fluid -->
        @include('transaksi.pembiayaan.create')

    </section>
    <!-- /.content -->
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
            $('.example').DataTable({
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
