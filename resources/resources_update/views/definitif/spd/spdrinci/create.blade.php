@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                        <h5 class="card-title font-weight-bold">TAMBAH RINCIAN SPD - {{ nm_bidang() }}</h5>
                    </div>
                    <div class="card-body px-2 py-2">
                        <form action="{{ route('spd-rinci.store') }}" method="post">
                            @csrf
                            @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                                Perhatian!
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
                                    <label for="nomorSpd" class="col-sm-3 col-form-label">Nomor SPD</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nomorSpd" class="form-control" id="nomorSpd"
                                            value="{{ $spd->No_PD }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggalSpd" class="col-sm-3 col-form-label">Tanggal SPD</label>
                                    <div class="col-sm-2">
                                        <input type="date" name="tanggalSpd" class="form-control" id="tanggalSpd"
                                            value="{{ $spd->dt_PD }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="uraianSpd" class="col-sm-3 col-form-label">Uraian SPD</label>
                                    <div class="col-sm-9">
                                        <textarea name="uraianSpd" class="form-control" id="uraianSpd" rows="3"
                                            readonly>{{ $spd->Ur_PD }}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="waktu" class="col-sm-3 col-form-label">Waktu SPD</label>
                                    <div class="col-sm-9">
                                        <select name="waktu" class="form-control" id="waktu" onchange="tampil_form()">
                                            <option value="" selected>-- Pilih Waktu --</option>
                                            @foreach ($pf_pdtap as $row)
                                            <option value="{{ $row->Ko_pdtap }}">{{ $row->Ur_pdtap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row opsi2">
                                    <label for="periode" class="col-sm-3 col-form-label">Periode</label>
                                    <div class="col-sm-9">
                                        <select name="periode" class="form-control" id="periode"></select>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="nomorRincian" class="col-sm-3 col-form-label">Nomor Rincian</label>
                                    <div class="col-sm-9">
                                        <button type="button" class="btn btn-sm btn-dark" title="klik"
                                            data-toggle="modal" data-target="#modalAmbilDataTap">
                                            <input type="hidden" name="nomorRincian"
                                                class="form-control @error('nomorRincian') is-invalid @enderror"
                                                id="nomorRincian" value="{{ $ko_pdrc->Ko_PDrc }}" readonly>
                                            <input type="hidden" name="koRk1"
                                                class="form-control @error('koRk1') is-invalid @enderror" id="koRk1"
                                                value="{{ $tap[0]->Ko_Rk1 }}" readonly>
                                            <input type="hidden" name="idSpd"
                                                class="form-control @error('idSpd') is-invalid @enderror" id="idSpd"
                                                value="{{ $spd->id }}" readonly>
                                            <i class="fa fa-edit"></i> Ambil Data
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="nomorKegiatanApbd" class="col-sm-3 col-form-label">Nomor Keg.
                                        APBD</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nomorKegiatanApbd" class="form-control tampil"
                                            id="nomorKegiatanApbd" readonly>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="nomorKegiatanBlu" class="col-sm-3 col-form-label">Nomor Keg.
                                        BLU</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nomorKegiatanBlu" class="form-control tampil"
                                            id="nomorKegiatanBlu" readonly>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="kodeAkun" class="col-sm-3 col-form-label">Kode Akun</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kodeAkun" class="form-control tampil" id="kodeAkun"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="nilaiRupiah" class="col-sm-3 col-form-label">Nilai</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="nilaiRupiah" class="form-control tampil"
                                            id="nilaiRupiah" readonly>
                                    </div>
                                </div>
                                <div class="form-group row opsi">
                                    <label for="uraianAkun" class="col-sm-3 col-form-label">Uraian Akun</label>
                                    <div class="col-sm-9">
                                        <textarea name="uraianAkun" class="form-control tampil" id="uraianAkun" rows="3"
                                            readonly></textarea>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mt-3">
                                    <button type="submit" class="col-sm-2 btn btn-primary ml-3" name="submit">
                                        <i class="far fa-save pr-2"></i>Simpan
                                    </button>
                                    <a href="{{ route('spd-rinci.pilih', $spd->id) }}"
                                        class="col-sm-2 btn btn-danger ml-3">
                                        <i class="fas fa-backward pr-2"></i>Kembali
                                    </a>
                                </div>
                            </div>

                            <div class="modal fade" id="modalAmbilDataTap" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Daftar Penetapan (Klik 2x
                                                pada Baris untuk Memilih SPD)</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="text-align:left">
                                            <table class="table table-sm table-bordered table-hover mb-0" width="100%"
                                                cellspacing="0" id="tabelTap" style="text-align: center;">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="vertical-align: middle;">Kode Kegiatan</th>
                                                        <th style="vertical-align: middle;">Kode Sub Kegiatan</th>
                                                        <th style="vertical-align: middle;">Kode Akun</th>
                                                        <th style="vertical-align: middle;">Uraian Akun</th>
                                                        <th style="vertical-align: middle;">Nilai (Rp)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tap as $row)
                                                    <tr ondblclick="ambilTap('{{ $row->id }}')">
                                                        <td>{{ $row->Ko_sKeg1 }}</td>
                                                        <td>{{ $row->Ko_sKeg2 }}</td>
                                                        <td>{{ $row->Ko_Rkk }}</td>
                                                        <td style="text-align: left">{{ $row->Ur_Rk6 }}</td>
                                                        <td style="text-align: right">{{ number_format($row->To_Rp, 2,
                                                            ",", ".") }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer"></div>
                                    </div>
                                </div>
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

<script src="{{asset('template')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.opsi').hide();
        $('.opsi2').hide();
        $('.opsi').val('');

        $('#tabelTap').DataTable({
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

    function tampil_form()
    {
        Ko_pdtap = $('#waktu').val();

        if(Ko_pdtap == 0) {
            $('.opsi').hide();
            $('.opsi2').hide();
        } else if(Ko_pdtap != 9) {
            $('.opsi').hide();
            $('.opsi2').show();
            if (Ko_pdtap == 1) {
                jlh_data = 12
            } else if (Ko_pdtap == 2) {
                jlh_data = 4
            } else if (Ko_pdtap == 3) {
                jlh_data = 3
            } else if (Ko_pdtap == 4) {
                jlh_data = 2
            } else if (Ko_pdtap == 5) {
                jlh_data = 1
            };

            data_periode = '<option value="" selected>-- Pilih Periode --</option>';

            for(i = 1; i < jlh_data + 1 ; i++) {
                data_periode += '<option value="' + i + '">' + i + '</option>';
            };
            
            $('#periode').html(data_periode);

        } else {
            $('.tampil').val('');
            $('.opsi').show();
            $('.opsi2').hide();
        }
    };

    function ambilTap(id)
    {
        var id = id;
        
        $.ajax({
            type: "POST",
            url: "{{ route('spd-rinci.getTap') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
            },
            dataType: "JSON",
            success: function(data){
                $('#nomorKegiatanApbd').val(data[0].Ko_sKeg1);
                $('#nomorKegiatanBlu').val(data[0].Ko_sKeg2);
                $('#kodeAkun').val(data[0].Ko_Rkk);
                $('#nilaiRupiah').val(data[0].To_Rp);
                $('#uraianAkun').val(data[0].Ur_Rk6);
                
                $('#modalAmbilDataTap').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        })
    }
</script>
@endsection