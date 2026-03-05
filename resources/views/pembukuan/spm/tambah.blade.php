@extends('layouts.template')
@section('style')
@endsection
@section('content')

    <section class="content px-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-lg mt-2">
                        <div class="card-header bg-info py-2">
                            <h5 class="card-title font-weight-bold">Realisasi Pembayaran</h5>
                        </div>
                        <div class="card-body px-2 py-2">
                            <form action="{{ route('spm.store') }}" method="post" class="form-horizontal">
                                @csrf
                                @if (session('errors'))
                                    <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                                        Something it's wrong:
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="nomorSpd" class="col-sm-2 col-form-label">Nomor Otorisasi</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="No_oto" class="form-control" id="No_oto" value="{{ $dt_oto->No_oto }}" readonly>
                                        </div>
                                        <label for="nomorSpd" class="col-sm-2 col-form-label">Tanggal Otorisasi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $dt_oto->tgl_oto }}" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label for="Ur_bprc" class="col-sm-2 col-form-label">Nomor Bukti Bayar</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="No_npd" class="form-control" value="{{ old('No_npd') }}" id="No_npd" placeholder="Nomor Bukti Bayar" required>
                                        </div>
                                        <label for="rftr_bprc" class="col-sm-2 col-form-label">Tanggal Bayar</label>
                                        <div class="col-sm-4">
                                            <input type="date" name="Dt_npd" class="form-control" value="{{ old('Dt_npd') ?? $dt_oto->tgl_oto }}" id="Dt_npd" min="{{ $dt_oto->tgl_oto }}" max="{{ Tahun().'-12-31' }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Uraian</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="Ur_npd" class="form-control" value="{{ old('Ur_npd') ?? $dt_oto->Ur_Oto }}" id="Ur_npd" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="To_Rp" class="col-sm-2 col-form-label">Bank yang membayar</label>
                                        <div class="col-sm-4">
                                            <select name="Ko_Bank"
                                                class="form-control @error('Ko_Bank') is-invalid @enderror" id="Ko_Bank" required>
                                                <option value="" selected disabled>-- pilih Bank --</option>
                                                @foreach ($bank as $number => $bank)
                                                    <option value="{{ $bank->Ko_Bank }}">{{ $bank->Ko_Bank }} -
                                                        {{ $bank->Ur_Bank }}
                                                        @if ($bank->Tag == 1)
                                                            (Rekening Utama)
                                                        @elseif($bank->Tag == 2)
                                                            (Rekening Bendahara Pengeluaran)
                                                        @elseif($bank->Tag == 3)
                                                            (Rekening Bendahara Penerimaan)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="Ur_bprc" class="col-sm-2 col-form-label">Yang membayar</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2 @error('Nm_Byro') is-invalid @enderror"
                                                name="Nm_Byro" id="Nm_Byro">
                                                <option value="">-- Pilih Yang Membayar --</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->nama }}">{{ $item->nama }}
                                                        ({{ $item->jabatan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="Nm_Byro" class="form-control" value="{{old('Nm_Byro')}}" id="Nm_Byro" placeholder="Yang membayar" required> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Bank Tujuan</label>
                                        <div class="col-sm-4">
											{{--<select class="form-control select2 @error('Nm_Bank') is-invalid @enderror" name="Nm_Bank" id="Nm_Bank">
													<option value="">-- Pilih Nama Bank Tujuan --</option>
													@foreach ($rekan as $ls)
														<option value="{{ $ls->rekan_nmbank }}|{{ $ls->rekan_rekbank }}">
															{{ $ls->rekan_nm }} ({{ $ls->rekan_nmbank }})</option>
													@endforeach
											</select>--}}
											<input type="text" name="Nm_Bank" class="form-control" value="{{ $dt_oto->Trm_Nm }}"" required readonly>
                                        </div>
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">No. Rekening Bank Tujuan</label>
                                        <div class="col-sm-4">
											<input type="text" name="No_Rektuju" class="form-control" id="No_Rektuju" value="{{ old('No_Rektuju') ?? $dt_oto->Trm_rek }}" placeholder="Nomor Rek. Bank Tujuan" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama Penandatangan</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2 @error('Nm_PP') is-invalid @enderror"
                                                name="Nm_PP" id="Nm_PP">
                                                <option value="">-- Pilih Nama Penandatangan --</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->nama }}|{{ $item->nip }}">
                                                        {{ $item->nama }} ({{ $item->jabatan }})</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="Nm_PP" class="form-control" id="Nm_PP" value="{{old('Nm_PP')}}" placeholder="Nama Pengusul/PPTK" required> --}}
                                        </div>
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP Penandatangan</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="NIP_PP" class="form-control" id="NIP_PP" value="{{ old('NIP_PP') }}" placeholder="NIP Penandatangan" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama Bendahara</label>
                                        <div class="col-sm-4">
                                            {{-- <select class="form-control select2 @error('Nm_Ben') is-invalid @enderror" name="Nm_Ben" id="Nm_Ben">
                                                <option value="">-- Pilih Nama Bendahara --</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->nama }}|{{ $item->nip }}">
                                                        {{ $item->nama }} ({{ $item->jabatan }})</option>
                                                @endforeach
                                            </select> --}}
                                            <input type="text" name="Nm_Ben" class="form-control" id="Nm_Ben" value="{{ old('Nm_Ben') ?? $dt_oto->Nm_Ben }}" placeholder="Nama Bendahara" required readonly>
                                        </div>
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP Bendahara</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="NIP_Ben" class="form-control" id="NIP_Ben" value="{{ old('NIP_Ben') ?? $dt_oto->NIP_Ben }}" placeholder="NIP Bendahara" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">Nama PPK</label>
                                        <div class="col-sm-4">
                                            {{--  <select class="form-control select2 @error('Nm_Keu') is-invalid @enderror" name="Nm_Keu" id="Nm_Keu">
                                                <option value="">-- Pilih Nama PPK --</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->nama }}|{{ $item->nip }}">
                                                        {{ $item->nama }} ({{ $item->jabatan }})</option>
                                                @endforeach
                                            </select> --}}
                                            <input type="text" name="Nm_Keu" class="form-control" id="Nm_Keu" value="{{old('Nm_Keu') ?? $dt_oto->Nm_Keu }}" required readonly> 
                                        </div>
                                        <label for="dt_rftrbprc" class="col-sm-2 col-form-label">NIP PPK</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="NIP_Keu" class="form-control" id="NIP_Keu"  value="{{ old('NIP_Keu') ?? $dt_oto->NIP_Keu }}" required readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <input type="text" name="id_oto" value="{{ $dt_oto->id }}" hidden>
                                    <input type="text" name="No_SPi" value="{{ $dt_oto->No_SPi }}" hidden>
                                    <input type="text" name="id_rc" id="id_rc" hidden>
									<input type="text" name="Trm_bank" value="{{ $dt_oto->Trm_bank }}" hidden>
									<input type="text" name="Trm_rek" value="{{ $dt_oto->Trm_rek }}" hidden>
									<input type="text" name="Ko_Bank" value="{{ $dt_oto->Ko_Bank }}" hidden>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover" width="100%"
                                            cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center">Nomor Pengajuan</th>
                                                    <th class="text-center" style="width: 3%">Tanggal Pengajuan</th>
                                                    <th class="text-center">Nomor Bukti</th>
                                                    <th class="text-center">Nama Rekanan</th>
                                                    <th class="text-center">Uraian</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="text-center">
                                                        @if (!empty($rincian))
                                                            <input type="checkbox" id="checkall">
                                                        @endif
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rincian as $item)
                                                    <tr>
                                                        <td>{{ $item->No_SPi }}</td>
                                                        <td class="text-center">{{ $item->Dt_SPi }}</td>
                                                        <td>{{ $item->No_bp }}</td>
                                                        <td>{{ nm_rekan($item->nm_BUcontr) }}</td>
                                                        <td>{{ $item->Ur_bprc }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($item->spirc_Rp, 2, ',', '.') }}</td>
                                                        <td class="text-center"><input class="check" type="checkbox"
                                                                value="{{ $item->id }}"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group row justify-content-center mt-3">
                                        <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit"
                                            id="submit" onclick="getData()">
                                            <i class="far fa-save pr-2"></i>Simpan
                                        </button>
                                        <a href="javascript:history.back()" class="col-sm-2 btn btn-danger ml-3">
                                            <i class="fas fa-backward pr-2"></i>Kembali
                                        </a>
                                    </div>
                            </form>
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
            $('#tb_add').DataTable();
            $('#dtrincian').DataTable();

            let ceklist = $('table tbody .check:checked')
            let cek = (ceklist.length > 0)
            $('#submit').prop('disabled', !cek);
        });

        $(document).on('click', '#checkall', function() {
            var isChecked = $('#checkall').prop('checked')
            $('.check').prop('checked', isChecked);

            if (isChecked > 0) {
                $('#submit').prop('disabled', false);
            } else {
                $('#submit').prop('disabled', true);
            }
        });

        $(document).on('click', '.check', function() {
            let cek = $('table tbody .check:checked')

            if (cek.length > 0) {
                $('#submit').prop('disabled', false);
            } else {
                $('#submit').prop('disabled', true);
            }
        });

        function getData() {
            let id_spi = $('#id_spi').val()
            console.log(id_spi);
            let dt = $('.check:checked')
            let data = []
            $.each(dt, function(index, elm) {
                data.push(elm.value)
            });

            $('#id_rc').val(data);

            // $.ajax({
            //     type: "post",
            //     url: "{{ route('spm_getData') }}",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         'id'  : id_spi,
            //         'dt' : data
            //     },
            //     success: function (data) {
            //         console.log(data);
            //         $("#tb_add").DataTable({
            //             "paging": false,
            //             "searching": false,
            //             "bInfo": false,
            //             "bDestroy": true,
            //             "data": data,
            //             "columns": [{
            //                     "data": null,
            //                     render: function(data, type, row, meta) {
            //                         return meta.row + meta.settings
            //                             ._iDisplayStart + 1;
            //                     }
            //                 },
            //                 {
            //                     "data": "No_SPi"
            //                 },
            //                 {
            //                     "data": "Dt_SPi"
            //                 },
            //                 {
            //                     "data": "No_bp"
            //                 },
            //                 {
            //                     "data": "Ur_bprc"
            //                 },
            //                 {
            //                     "data": "spirc_Rp"
            //                 },
            //                 // {
            //                 //     "data": null,
            //                 //     "bSortable": false,
            //                 //     "mRender": function (o) { return '<a href=#/' + o.userid + '><i class="fas fa-trash text-danger"></i></a>'; }
            //                 // }
            //             ],
            //             "columnDefs": [
            //                 {
            //                 "targets": 0,
            //                 "className": "text-center"
            //                 },
            //                 {
            //                 "targets": 2,
            //                 "className": "text-center"
            //                 },
            //                 {
            //                 "targets": 5,
            //                 "className": "text-right",
            //                 "render": $.fn.dataTable.render.number('.', ',', 2, '')
            //                 }
            //             ],
            //         });
            //     }
            // });
        }

        function cancel() {
            $('#checkall').prop('checked', false);
            $('.check').prop('checked', false);
        }

        $(document).on('change', '#Nm_PP', function() {
            var data = document.getElementById("Nm_PP").value;
            var nip = data.split("|");
            $('#NIP_PP').val(nip[1]);
        });

        $(document).on('change', '#Nm_Ben', function() {
            var data = document.getElementById("Nm_Ben").value;
            var nip = data.split("|");
            $('#NIP_Ben').val(nip[1]);
        });

        $(document).on('change', '#Nm_Keu', function() {
            var data = document.getElementById("Nm_Keu").value;
            var nip = data.split("|");
            $('#NIP_Keu').val(nip[1]);
        });

        $(document).on('change', '#Nm_Bank', function() {
            var data = document.getElementById("Nm_Bank").value;
            var nip = data.split("|");
            $('#No_Rektuju').val(nip[1]);
        });
    </script>
@endsection
