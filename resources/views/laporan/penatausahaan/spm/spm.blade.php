@extends('layouts.template')
@section('style')@endsection

@section('content')

<div class="card-body pt-0">
    <div class="container py-1">
        <form action="{{ route('spm.pdf.cetak') }}" method="post">
            @csrf
            <div class="form-group row">
                <select class="col-sm-11 col-form-label pilihSpm" name="pilihSpm" id="pilihSpm"
                    style="margin-right: 0pt; width: 966px" onchange="spmList()">
                    <option value="" readonly>-- Pilih SPM --</option>
                    @foreach ($no_spm as $row)
                    <option value="{{ $row->No_oto }}">{{ $row->No_oto }} - {{ $row->Ur_oto }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary col-sm-1 form-control ml-1" type="submit">
                    <i class="fa fa-print"></i> cetak
                </button>
            </div>
        </form>
    </div>
    <div id="isiData">
        <div class="container py-4" style="background: white">
            <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
            <h4 class="my-0" style="text-align: center"><b>SURAT PERINTAH MEMBAYAR</b></h4>
            <h5 class="my-0" style="text-align: center">TAHUN ANGGARAN {{ Tahun() }}</h5><br>

            <div class="container px-4" style="font-size: 13pt">
                <div class="row justify-content-end">
                    <p class="mb-0">Nomor: ................................</p>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" width="100%">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="padding-top: 0; padding-bottom: 0">Kepada Pejabat
                                        Keuangan<br>{{
                                        nm_unit() }}<br>{{
                                        nm_ibukota() }}</td>
                                    <td colspan="4" style="padding-top: 0; padding-bottom: 0">Potongan-Potongan</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Supaya
                                        membayarkan<br>.....<br>kepada:</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        No.</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Kode<br>Rekening</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Uraian</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah<br>(Rp)</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Bendahara Pengeluaran/Pihak Ketiga<br>................</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        1</td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="3" colspan="3"
                                        style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Nomor
                                        Rekening:<br>................<br>Bank:<br>.................<br>NPWP:<br>...................
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Dasar Pembayaran:<br>......................
                                    </td>
                                    <td colspan="3"
                                        style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah
                                    </td>
                                    <td colspan=""
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Untuk Keperluan:<br>......................
                                    </td>
                                    <td rowspan="2" colspan="4"
                                        style="text-align: left; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        <b>Catatan:<br>Tidak mengurangi jumlah pembayaran SPM
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Pembebanan pada kode rekening:
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Kode<br>Rekening
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Uraian
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah<br>(Rp)
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        No.
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Kode<br>Rekening
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Uraian
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah<br>(Rp)
                                    </td>
                                <tr>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        a
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        i
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        u
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        .....
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        .....
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        .....
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        .....
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah SPP yang diminta
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        .........
                                    </td>
                                    <td colspan="3"
                                        style="text-align: right; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Jumlah SPM
                                    </td>
                                    <td
                                        style="text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        ..........
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Nomor dan Tanggal SPP:<br>.......................
                                    </td>
                                    <td colspan="4" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                        Terbilang:<br>...........................
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align: middle; padding-top: 0; padding-bottom: 0">
                                    </td>
                                    <td colspan="4"
                                        style="text-align: center; middle; padding-top: 0; padding-bottom: 0">
                                        {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->format('j F Y') }}<br>Pimpinan
                                        BLUD<br><br><br>Nama Lengkap<br>NIP. .........</td>
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

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('.pilihSpm').select2();
    })
    
    function spmList() {
        var no_spm = $('#pilihSpm').val();
    
        $.ajax({
            type: "post",
            url: "{{ route('spm.pdf.pilih') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'no_spm': no_spm
            },
            success: function(data) {
                    $('#isiData').html(data);
                } 
            }) 
        }
</script>

@endsection