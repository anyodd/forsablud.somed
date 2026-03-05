@extends('layouts.template')
@section('title', 'Penatausahaan Belanja')

@section('content')

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
                                            <option selected="selected">-- Pilih --</option>
                                            @foreach ($panjar as $item)
                                                <option value="{{ $item->id_bp }}">{{ $item->No_bp }} -
                                                    {{ $item->Ur_bp }}</option>
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
                                <h4 class="my-0" style="text-align: center"><b>KUITANSI PANJAR</b></h4>

                                <div class="container px-4" style="font-size: 13pt">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0">
                                                            Nomor : </td>
                                                        <td
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0; width: 20%">
                                                            Tanggal : </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0; width: 10%">
                                                            Diserahkan kepada</td>
                                                        <td
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0; width: 1%;">
                                                            :</td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0"
                                                            id="pihak"></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0; width: 10%">
                                                            Sejumlah</td>
                                                        <td
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0; width: 1%;">
                                                            :</td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0">
                                                            <input type="text" id="total"
                                                                style="text-align: left; left; border: 0ch"><br>
                                                            <input type="text" id="uang"
                                                                style="text-align: left; left; border: 0ch;" size="75"><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0; width: 10%">
                                                            Nomor/Tanggal Permintaan<br>panjar</td>
                                                        <td
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0; width: 1%;">
                                                            :</td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0">
                                                            <input type="text" id="nomor"
                                                                style="text-align: left; middle; border: 0ch"
                                                                value="Nomor :">
                                                            <br><input type="text" id="tanggal"
                                                                style="text-align: left; left; border: 0ch"
                                                                value="Tanggal :">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0; width: 10%">
                                                            Keterangan</td>
                                                        <td
                                                            style="vertical-align: middle; text-align: center; padding-top: 0; padding-bottom: 0; width: 1%;">
                                                            :</td>
                                                        <td colspan="2"
                                                            style="vertical-align: middle; text-align: left; padding-top: 0; padding-bottom: 0"
                                                            id="uraian"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table-sm" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                                            <br>Diterima oleh,
                                                            <br><br><br><input id="pihak_" value="Nama Lengkap"
                                                                style="text-align: center; middle; border: 0ch"><br>NIP.
                                                            ..............
                                                        </td>
                                                        </td>
                                                        <td style="width: 40%"></td>
                                                        <td
                                                            style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                                            {{ nm_ibukota() }},
                                                            {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara
                                                            Pengeluaran,
                                                            <br><br><br>{{ tb_sub('Nm_Bend') }}<br>NIP.
                                                            {{ tb_sub('Nip_Bend') }}
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
                    url: 'kump/d_kump/' + id,
                    dataType: 'json',
                    success: function(data) {
                        var nomor = data['panjar']['No_bp'];
                        var tanggal = data['panjar']['dt_bp'];
                        var uraian = data['panjar']['Ur_bp'];
                        var pihak = data['panjar']['nm_BUcontr'];
                        var total = data['total'][0]['jml'];
                        var id = data['panjar']['id_bp'];
                        var no = parseFloat(total).toFixed();
                        console.log(no);
                        var uang = 'Terbilang(' + terbilang(no) + ')';

                        $('#cetak').val(id);
                        $('#nomor').val('Nomor : ' + nomor);
                        $('#tanggal').val('Tanggal : ' + tanggal);
                        $('#pihak').html(pihak);
                        $('#pihak_').val(pihak);
                        $('#uang').val(uang);
                        $('#uraian').html(uraian);
                        $('#total').val('Rp ' + total);
                        $('#sebesar').html('sebesar Rp ' + total);

                    },
                })
            })
        });

        function cetak() {
            var id = document.getElementById("cetak").value;
            window.open('kump/print_kump/' + id, '_blank');

        };

        function terbilang(bilangan) {

            bilangan = String(bilangan);
            var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
            var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
            var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');

            var panjang_bilangan = bilangan.length;

            if (panjang_bilangan > 15) {
                kaLimat = "Diluar Batas";
                return kaLimat;
            }

            for (i = 1; i <= panjang_bilangan; i++) {
                angka[i] = bilangan.substr(-(i), 1);
            }

            i = 1;
            j = 0;
            kaLimat = "";


            while (i <= panjang_bilangan) {

                subkaLimat = "";
                kata1 = "";
                kata2 = "";
                kata3 = "";

                if (angka[i + 2] != "0") {
                    if (angka[i + 2] == "1") {
                        kata1 = "Seratus";
                    } else {
                        kata1 = kata[angka[i + 2]] + " Ratus";
                    }
                }

                if (angka[i + 1] != "0") {
                    if (angka[i + 1] == "1") {
                        if (angka[i] == "0") {
                            kata2 = "Sepuluh";
                        } else if (angka[i] == "1") {
                            kata2 = "Sebelas";
                        } else {
                            kata2 = kata[angka[i]] + " Belas";
                        }
                    } else {
                        kata2 = kata[angka[i + 1]] + " Puluh";
                    }
                }

                if (angka[i] != "0") {
                    if (angka[i + 1] != "1") {
                        kata3 = kata[angka[i]];
                    }
                }


                if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
                    subkaLimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
                }


                kaLimat = subkaLimat + kaLimat;
                i = i + 3;
                j = j + 1;

            }

            if ((angka[5] == "0") && (angka[6] == "0")) {
                kaLimat = kaLimat.replace("Satu Ribu", "Seribu");
            }

            return kaLimat + "Rupiah";
        }
    </script>
@endsection
