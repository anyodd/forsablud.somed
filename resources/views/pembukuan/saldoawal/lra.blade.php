@extends('layouts.template')
@section('title', 'Saldo Awal')

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
                    <div class="card card-info mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Saldo Awal Laporan Realisasi Anggaran</h5>
                        </div>
                        <div class="card-body">
							 <div class="row">
								<div class="col-md-12">
									<a href="{{route('saldoawal.index')}}" class="btn btn-sm btn-warning mb-2">Neraca</a>
									<a href="{{route('saldoawal.lo')}}" class="btn btn-sm btn-warning mb-2 mx-1">Laporan Operasional</a>
									<a href="" class="btn btn-sm btn-warning mb-2 disabled">Laporan Realisasi Anggaran</a>
									{{--<a href="{{route('saldoawal.lpsal')}}" class="btn btn-sm btn-warning mb-2">Laporan Perubahan Saldo Anggaran Lebih</a>
									<a href="{{route('saldoawal.lpe')}}" class="btn btn-sm btn-warning mb-2">Laporan Perubahan Ekuitas</a>--}}
								</div>
							</div>
                            <button type="button" class="btn btn-sm btn-success mb-2" 
                                data-toggle="modal" data-backdrop="static" data-target="#modal-create">
                                <i class="fas fa-plus-circle pr-1"></i>Tambah
                            </button>

                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center" style="width: 15%">Kode Rekening</th>
                                        <th class="text-center">Nama Rekening</th>
                                        <th class="text-center" style="width: 15%;">Debet</th>
                                        <th class="text-center" style="width: 15%;">Kredit</th>
                                        <th class="text-center" style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saldo as $item)
                                        <tr>
                                            <td class="text-center" style="text-align: left;width: 5%">{{ $loop->iteration }}.</td>
                                            <td class="text-center">{{ $item->ko_rkk5 }}</td>
                                            <td>{{ $item->Ur_Rk5 }}</td>
                                            <td class="text-right"> {{ number_format($item->soaw_Rp_D, 2, ',', '.') }}</td>
                                            <td class="text-right"> {{ number_format($item->soaw_Rp_K, 2, ',', '.') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modaledit{{$item->id}}"><i class="fas fa-edit"></i></button>
                                                <form
                                                    action="{{ route('saldoawal.destroy', ['saldoawal' => $item->id]) }}"
                                                    method="post" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus {{ $item->ko_rkk5 }} ?')">
                                                    @method("delete")
                                                    @csrf
                                                    <button title="Hapus data" type="submit"
                                                        data-name="{{ $item->ko_rkk5 }}" data-table="saldoawal"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash pr-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @include('pembukuan.saldoawal.edit')
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right"></th>
                                        <th class="text-right">{{number_format($debet,2,',','.')}}</th>
                                        <th class="text-right">{{number_format($kredit,2,',','.')}}</th>
                                        <th class="text-right">{{number_format($kredit-$debet,2,',','.')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pembukuan.saldoawal.create')
        @include('pembukuan.saldoawal.popup_rekening')
        @include('pembukuan.saldoawal.popup_rekening_edit')

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
            $("#example4").DataTable();

            $(document).on('click', '#pilih', function() {
                var kd_r = $(this).data('kd_rek');
                console.log(kd_r);
                $('#kd_rkk').val(kd_r);
                $('#modal_rekening').hide();
            });

            $(document).on('click', '#id_edit', function() {
                var id = $(this).data('id');
                $(document).on('click', '#pilihedit', function() {
                    var kd_r = $(this).data('kd_rekedit');
                    $('#kd_rkk'+id).val(kd_r);
                    $('#modal_rekeningedit').hide();
                });
            });

        })
    </script>
@endsection
