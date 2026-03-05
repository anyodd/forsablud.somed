@extends('layouts.template')
@section('style')@endsection

@section('content')

<div class="card-body pt-0">
    <div class="container py-1">
        <form action="{{ route('spp.pdf.cetak') }}" method="post">
            @csrf
            <div class="form-group row">
                <select class="col-sm-10 col-form-label pilihSpp" name="pilihSpp" id="pilihSpp"
                    style="margin-right: 0pt; width: 966px" onchange="sppList()">
                    <option value="" readonly>-- Pilih S-PPD --</option>
                    @foreach ($no_spp as $row)
                    <option value="{{ $row->No_SPi }}">{{ $row->No_SPi }} - {{ $row->Ur_SPi }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary col-sm-1 form-control ml-1" type="submit">
                    <i class="fa fa-print"></i> cetak
                </button>
            </div>
        </form>
    </div>
    <div id='isiData'>
        <div class="container py-4" style="background: white">
            <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
            <h4 class="my-0" style="text-align: center"><b>SURAT PERMINTAAN PEMBAYARAN</b></h4>
            <h5 class="my-0" style="text-align: center">Nomor : .....</h5><br>

            <div class="container px-4" style="font-size: 13pt">
                <div class="row">
                    <p>Yth. Pemimpin BLUD</p>
                    <p class="paragraph mb-0" style="text-align: justify">Dengan memperhatikan RBA <b>{{ nm_unit()
                            }}</b> Nomor ..... tanggal .....,
                        bersama
                        ini kami mengajukan
                        permintaan pembayaran sebagai berikut:</p>
                </div>
                <div class="row">
                    <table class="table-borderless" style="width: 100%">
                        <thead>
                            <tr>
                                <td class="td pl-0">a.</td>
                                <td>Subkegiatan</td>
                                <td>:</td>
                                <td>........................................</td>
                            </tr>
                            <tr>
                                <td class="td pl-0">b.</td>
                                <td>Tahun Anggaran</td>
                                <td>:</td>
                                <td>........................................</td>
                            </tr>
                            <tr>
                                <td class="td pl-0">c.</td>
                                <td>Pembayaran yang Diminta</td>
                                <td>:</td>
                                <td>........................................</td>
                            </tr>
                            <tr>
                                <td class="td pl-0"></td>
                                <td></td>
                                <td></td>
                                <td>(terbilang: <b>{{ terbilang('0') . " rupiah" }}</b>)</td>
                            </tr>
                            <tr>
                                <td class="td pl-0">d.</td>
                                <td>Nama dan Nomor Rekening Bank</td>
                                <td>:</td>
                                <td>........................................</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="row pt-2">
                    <p class="paragraph" style="text-align: justify">Rincian belanja sebagai berikut:</p>
                </div>
                <div class="row">
                    <div class="col-sm-6 px-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" width="100%">
                                <thead style="text-align: center">
                                    <tr style="height: 56pt">
                                        <th rowspan="2" style="vertical-align: middle">No.</th>
                                        <th rowspan="2" style="vertical-align: middle">Kode<br>Rekening</th>
                                        <th rowspan="2" style="vertical-align: middle">Uraian</th>
                                        <th rowspan="2" style="vertical-align: middle">Jumlah<br>Belanja</th>
                                    </tr>
                                </thead>
                                <tbody id="isiRekening">
                                    <tr>
                                        <td style="text-align: center">1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">2</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot id="totalRekening">
                                    <tr>
                                        <th colspan="3" style="text-align: center">TOTAL</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6 pl-1">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" width="100%">
                                <thead style="text-align: center">
                                    <tr>
                                        <th colspan="5">Potongan</th>
                                    </tr>
                                    <tr>
                                        <th>PPN</th>
                                        <th>PPh 21</th>
                                        <th>PPh 22</th>
                                        <th>PPh 23</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center">...</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">...</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center">...</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                <br>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td style="text-align: center; padding-left: 0px">Disetujui Oleh<br>Nama
                                    Pimpinan<br><br><br>Nama
                                    Lengkap<br>NIP. .........</td>
                                <td></td>
                                <td style="text-align: center">Diverifikasi Oleh<br>Pejabat Keuangan<br><br><br>Nama
                                    Lengkap<br>NIP.
                                    .........</td>
                                <td></td>
                                <td style="text-align: center; padding-right: 0px">{{ nm_ibukota() }}, {{
                                    Carbon\Carbon::now()->format('j F Y')
                                    }}<br>Pejabat
                                    Keuangan<br><br><br>Nama Lengkap<br>NIP. .........</td>
                            </tr>
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
        $('.pilihSpp').select2();
    })
    
    function sppList() {
        var no_spp = $('#pilihSpp').val();
    
        $.ajax({
            type: "post",
            url: "{{ route('spp.pdf.pilih') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'no_spp': no_spp
            },
            success: function(data) {
                    $('#isiData').html(data);
                } 
            }) 
        }
</script>

@endsection