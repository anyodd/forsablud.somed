@extends('layouts.template')
@section('title', 'Saldo Laporan Perubahan Ekuitas')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><br>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <a href="#" class="btn btn-sm btn-primary disabled">Saldo Awal Lapkeu</a>
                    <a href="{{route('saldoawalpiutang.index')}}" class="btn btn-sm btn-primary">Saldo Awal Piutang</a>
                    <a href="{{route('saldoawalutang.index')}}" class="btn btn-sm btn-primary">Saldo Awal Utang</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="btn btn-sm btn-warning mb-2">Neraca</a>
                    <a href="{{route('saldoawal.lo')}}" class="btn btn-sm btn-warning mb-2 mx-1">Laporan Operasional</a>
                    <a href="{{route('saldoawal.lra')}}" class="btn btn-sm btn-warning mb-2">Laporan Realisasi Anggaran</a>
                    <a href="{{route('saldoawal.lpsal')}}" class="btn btn-sm btn-warning mb-2">Laporan Perubahan Saldo Anggaran Lebih</a>
                    <a href="{{route('saldoawal.lpe')}}" class="btn btn-sm btn-warning mb-2 disabled">Laporan Perubahan Ekuitas</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Saldo Awal Laporan Perubahan Ekuitas</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-primary mb-2" 
                                data-toggle="modal" data-backdrop="static" data-target="#modal-create">
                                <i class="fas fa-plus-circle pr-1"></i>Tambah
                            </button>

                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center" style="width: 20%">Nilai (Rp)</th>
                                        <th class="text-center" style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center" style="text-align: left;width: 5%">{{ $loop->iteration }}.</td>
                                            <td class="text-left">{{ $item->ur_lpe }}</td>
                                            <td class="text-right">{{ number_format($item->soaw_Rp,2,',','.') }}</td>
                                            <td class="text-center">
                                                <form
                                                    action="{{ route('saldoawal.delete_lpe', $item->id_soawlp) }}"
                                                    method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus data ?')">
                                                    @method("delete")
                                                    @csrf
                                                    <button title="Hapus data" type="submit"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash pr-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
        @include('pembukuan.saldoawal.create_lpe')

    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $("#example1").DataTable({
                "pageLength": 100,
            });

            $("#example3").DataTable();

        })
    </script>
@endsection
