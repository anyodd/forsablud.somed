@extends('layouts.template')
@section('title', 'Penatausahaan Belanja')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h5> Periode : {{ $tahun }}</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            @yield('title')
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('laporan.penatausahaan.belanja.select_laporan')
                            <hr>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-8">
                                        <select id="pilih" class="form-control select2" style="width: 100%;">
                                            <option selected="selected">-- Pilih Nomor --</option>
                                            @foreach ($belanja as $item)
                                                <option value="{{ $item->id_bp }}">{{ $item->No_bp }} -
                                                    {{ $item->Ur_bp }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">

                                        <a href="javascript:cetak();" rel=" noopener" id="cetak" type="button"
                                            class="btn  btn-outline-warning mr-2 mb-2 float-right">
                                            <i class="fas fa-print"></i>
                                            Print
                                        </a>

                                    </div>
                                </div>
                            </div>

                            <div class="container py-4" style="background: white">
                                <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
                                <h4 class="my-0" style="text-align: center"><b>NOTA PENCAIRAN DANA</b></h4>
                                <h5 class="my-0" style="text-align: center" id="nomor">Nomor : </h5><br>

                                <div class="container px-4" style="font-size: 13pt">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table-sm" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 20%">Unit
                                                            Layanan</td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 78%">
                                                            {{ nm_unit() }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 20%">Tahun
                                                            Anggaran</td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 78%">
                                                            {{ Tahun() }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 20%">Uraian
                                                        </td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
                                                        <td style="padding-top: 0; padding-bottom: 0; width: 78%"
                                                            id="uraian"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-sm table-bordered" width="100%" id="npdTable">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2"
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0; width: 3%">
                                                            No.</th>
                                                        <th colspan="2"
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Rekening</th>
                                                        <th colspan="3"
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Bukti / Nota</th>
                                                    </tr>
                                                    <tr>
                                                        <th
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Kode</th>
                                                        <th
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Uraian</th>
                                                        <th
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Nomor</th>
                                                        <th
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Tanggal</th>
                                                        <th
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0">
                                                            Jumlah (Rp)</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"
                                                            style="vertical-align: middle; text-align: right; padding-top: 0; padding-bottom: 0">
                                                            Jumlah</td>
                                                        <td style="vertical-align: middle; text-align: right; padding-top: 0; padding-bottom: 0"
                                                            id="total">Rp </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <table class="table-sm" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                                            <br>Bendahara
                                                            Pengeluaran,
                                                            <br><br><br>{{ tb_sub('Nm_Bend') }}<br>NIP.
                                                            {{ tb_sub('Nip_Bend') }}
                                                        </td>
                                                        </td>
                                                        <td style="width: 40%"></td>
                                                        <td
                                                            style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                                            {{ nm_ibukota() }},
                                                            {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>PPTK,
                                                            <br><br><br>Nama Lengkap<br>NIP. .........
                                                        </td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
         $(document).ready(function() {
            pilihan();
        })

        $(function() {
            $('#pilih, .select2').select2();
            $('#pilih').change(function() {
                var id = $(this).val();
                $.ajax({
                    type: 'get',
                    url: 'npd/d_npd/' + id,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var nomor = data['belanja']['No_bp'];
                        var uraian = data['belanja']['Ur_bp'];
                        var total = data['total'][0]['jml'];
                        var rincian = data['rincian'];
                        var id = data['belanja']['id_bp'];

                        $('#cetak').val(id);
                        $('#nomor').html('Nomor : ' + nomor);
                        $('#uraian').html(uraian);
                        $('#total').html('Rp ' + total);
                        $("#npdTable").DataTable({
                            "paging": false,
                            "searching": false,
                            "bInfo": false,
                            "bDestroy": true,
                            "data": rincian,
                            "columns": [{
                                    "data": null,
                                    render: function(data, type, row, meta) {
                                        return meta.row + meta.settings
                                            ._iDisplayStart + 1;
                                    }
                                },
                                {
                                    "data": "Ko_Rkk"
                                },
                                {
                                    "data": "Ur_Rk6"
                                },
                                {
                                    "data": "rftr_bprc"
                                },
                                {
                                    "data": "dt_rftrbprc"
                                },
                                {
                                    "data": "To_Rp"
                                },
                            ]
                        });
                    },
                })
            })
        });

        function cetak() {
            var id = document.getElementById("cetak").value;
            window.open('npd/print_npd/' + id, '_blank');

        };
    </script>
@endsection
