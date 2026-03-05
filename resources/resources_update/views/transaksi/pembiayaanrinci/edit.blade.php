@extends('layouts.template')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1> Edit Rincian Pembiayaan </h1>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pembiayaanrinci.update', $data->id_bprc) }}" method="POST" >
                                @csrf
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="Ko_Period">K. BP & Per</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"  name="id_bp" id="id_bp" class="form-control"  value="{{ $tb_bp->id_bp }}" readonly>
                                            <input type="text"  name="Ko_Period" id="Ko_Period" class="form-control"  value="{{ $tb_bp->Ko_Period }}" readonly>

                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="Ko_unit1">Ref Unit & Nomer</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"  name="Ko_unit1" id="Ko_unit1" class="form-control"  value="{{ $tb_bp->Ko_unit1 }}" readonly>
                                            <input type="text"  name="No_bp" id="No_bp" class="form-control"  value="{{ $tb_bp->No_bp }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="Ko_bprc">No BP Rinci</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number"  name="Ko_bprc" id="Ko_bprc" class="form-control" value="{{$data->Ko_bprc}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="Ur_bprc">Uraian BP Rinci</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"  name="Ur_bprc" id="Ur_bprc" class="form-control" value="{{$data->Ur_bprc}}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="rftr_bprc">Bukti Transfer</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"  name="rftr_bprc" id="rftr_bprc" class="form-control" value="{{$data->rftr_bprc}}"> 
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="dt_rftrbprc">Tanggal Transfer</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="date"  name="dt_rftrbprc" id="dt_rftrbprc" class="form-control" value="{{$data->dt_rftrbprc}}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="No_PD">Nomor Penerimaan</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"  name="No_PD" id="No_PD" class="form-control" value="{{$data->No_PD}}">
                                        </div>
                                    </div>
                                    {{-- modal Kegiatan APBD --}}
                                    <div class="row form-group">
                                        <div class="col-sm-2">
                                            <label for="sKo_sKeg1">Nomor Keg APBD</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="sKo_sKeg1" name="sKo_sKeg1" readonly>
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_kegiatan">Cari!</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="sKo_sKeg2" name="sKo_sKeg2" value="{{$dt_view->ko_skeg1}}" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="Ko_Rkk"  name="Ko_Rkk" value="{{$dt_view->ko_rkk}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label for="ur_skeg">Kegiatan</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="ur_skeg"  name="ur_skeg" value="{{$dt_view->ur_kegbl2}}" readonly>
                                        </div>
                                    </div>
                                    {{-- END MODAL Kegiatan APBD--}}

                                    <div class="row form-group">
                                        <div class="col-md-2">
                                                <label for="To_Rp">Nilai</label>
                                        </div>
                                        <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="To_Rp" name="To_Rp" value="{{$data->To_Rp}}"  placeholder="Nilai pembiayaan">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                                <label for="ko_kas">Kode Kas/Bank</label>
                                        </div>
                                        <div class="col-md-10">
                                                <select id="ko_kas" name="ko_kas" class="form-control select2 select2-danger @error('ko_kas') is-invalid @enderror" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option value="" disabled>--Pilih Cara Pembayaran--</option>
                                                        @foreach ($kobank as $item)
                                                            <option value="{{$item->Ko_Bank}} {{$data->ko_kas == $item->Ko_Bank ? 'selected' : ''}}">{{$item->Ur_Bank}} - (Rek: {{$item->No_Rek}} )</option>
                                                        @endforeach
                                                </select>
                                                @error('ko_kas')
                                                    <div class="invalid-feedback"> {{ $message}}</div>
                                                @enderror

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <a href="{{ url()->previous() }}" class="btn btn-success float-right">
                                            <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                                        </a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('transaksi.pembiayaanrinci.popup_kegiatan')
@endsection

@section('script')
    <script>
        $(document).on('click','#pilih',function() {
        var kd_keg1 = $(this).data('k_skeg1');
        var kd_keg2 = $(this).data('k_skeg2');
        var u_keg = $(this).data('u_keg');
        var k_r = $(this).data('k_rek');
        $('#sKo_sKeg1').val(kd_keg1);
        $('#sKo_sKeg2').val(kd_keg2);
        $('#Ko_Rkk').val(k_r);
        $('#ur_skeg').val(u_keg);
        $('#modal_kegiatan').hide();
    });

    $("#tabelTap").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
    });
    </script>
@endsection