@extends('layouts.template')
@section('title', 'Buku Pembantu Per Sub Rincian Objek')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
                            <div class="row">
                                <div class="col-6 my-auto">
                                    @yield('title')
                                </div>
                                <div class="col-6 text-right">
                                    <form action="{{ route('bpobjek_cetak') }}" method="post" target="_blank">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" id='rekening' name="ko_rkk">
                                        <input type="hidden" id='periode' name="periode">
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file-pdf bg-red"></i> Cetak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('laporan.penatausahaan.belanja.select_laporan')
                            <hr>
                            <a href="" id="scroll" style="display: none;"><span></span></a>
                            <div class="card-body">
                                <div class="form-group row mb-0">
                                  <div class="col-12">
                                    <div class="form-group row">
                                      <div class="col-8">
                                        <code>Rekening</code>
                                        <select name="rkk" id="rkk" class="form-control select2" id="">
                                          <option value="">-- Pilih Rekening --</option>
                                          @foreach ($akun as $item)
                                              <option value="{{$item->Ko_Rkk}}">{{$item->Ko_Rkk}} - {{$item->Ur_Rk6}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="col-2">
                                        <code>Periode</code>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <select class="form-control" name="bulan" id="bulan">
                                                <option value="">-- Pilih Bulan --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-2">
                                        <code>.</code>
                                        <button type="button" class="col btn btn-primary" name="submit" id="submit">
                                          <i class="fa fa-search"></i> Filter
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                            </div>
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td class="text-center text-bold" colspan="12">
                                            BUKU PEMBANTU PER SUB RINCIAN OBJEK <br>
                                            TAHUN ANGARAN {{ Tahun() }} <br>
                                        </td>
                                    </tr>
                                </head>
                            </table>
                            <div id="result-table" style="width: 100%"></div>
                            <table class="table table-bordered table-striped" id="table-header" style="width: 100">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 3px">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">No.Bukti</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Belanja LS</th>
                                        <th class="text-center">Belanja UP/GU</th>
                                        <th class="text-center">Saldo</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" id='baris-kosong' colspan=7>Silahkan Pilih Periode Pelaporan</td>
                                        <td class="text-center" id='baris-loader' colspan=7><div class="lds-ellipsis"><div></div><div></div><div></div></div></td>
                                    </tr>
                                </tbody>
                            </table><br>
                            {{-- <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="8">Saldo Kas di Bendahara Pengeluaran/Bendahara Pengeluaran
                                            Pembantu
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 3%"></td>
                                        <td colspan="7">
                                            Rp........<br>
                                            (Terbilang: ..............)<br>
                                            terdiri dari : <br>
                                            a. Tunai : Rp. ...........<br>
                                            b. Bank : Rp. ...........<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            <strong>Disetujui oleh,<br>
                                                Pengguna Anggara/Kuasa<br>
                                                Pengguna Anggaran
                                                <br><br><br>
                                                {{$pegawai[0]->Nm_Pimp}}<br>
                                                NIP. {{$pegawai[0]->NIP_Pimp}}
                                                <br><br><br></strong>
                                        </td>
                                        <td colspan="4" style="text-align: center">
                                            <strong>Disiapkan oleh,<br>
                                                Bendahara Pengeluaran/<br>
                                                Bendahara Pengeluaran Pembantu
                                                <br><br><br>
                                                {{$pegawai[0]->Nm_Bend}}<br>
                                                NIP. {{$pegawai[0]->NIP_Bend}}
                                                <br><br><br></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
            $('#baris-loader').hide();
            $('.btn.btn-sm.btn-secondary').hide();
            pilihan();
        })

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            tahun = {{ Tahun() }};

            $('#submit').click(function () { 
                rkk   = document.getElementById("rkk").value;
                bulan = document.getElementById("bulan").value;

                $.ajax({
                    type: "post",
                    url: "{{ route('bpobjek_isi') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "rkk"  : rkk,
                        "bulan": bulan
                    },
                    beforeSend: function() {
                        $('#result-table').hide();
                        $('#baris-kosong').hide();
                        $('#table-header').show();
                        $('#baris-loader').show();
                    },
                    success: function(result) {
                        $('#table-header').hide();
                        $('#baris-loader').hide();
                        $('#result-table').html(result);
                        $('#result-table').show();
                        $('.btn.btn-sm.btn-secondary').show();
                        $('#rekening').val(rkk);
                        $('#periode').val(bulan);
                    }
                })
            });


        })

        // DropzoneJS Demo Code End
    </script>
@endsection
