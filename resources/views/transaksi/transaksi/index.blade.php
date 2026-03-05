@extends('layouts.template')
@section('title', 'Daftar Transaksi')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card shadow-lg mt-2">
                    <div class="card-header bg-info py-2">
                    <h5 class="card-title font-weight-bold">Filter Transaksi</h5> 
                    </div>
                    <div class="card-body py-0">
                        <form action="{{ route('transaksi.index') }}" method="get">
                            @csrf
                            <div class="form-group row mb-0">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col">
                                            <code>Pilih Transaksi</code>
                                            <select name="transaksi" class="form-control select2" id="">
                                                <option value="0">-- Semua Transaksi --</option>
                                                @foreach ($transaksi as $item)
                                                    <option value="{{$item->ko_bp}}">{{$item->Ur_bp}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <code>Pilih Bidang</code>
                                            <select name="bidang" class="form-control select2" id="">
                                                <option value="0">-- Semua Bidang --</option>
                                                @foreach ($bidang as $ls)
                                                    <option value="{{$ls->ko_unit1}}">{{$ls->bidang}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <code>Periode Transaksi</code>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <input type="text" name="tgl_jurnal" class="col form-control" id="reservation">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <code>.</code>
                                            <button type="submit" class="col btn btn-primary float-right" name="submit">
                                                <i class="fa fa-search"> FILTER</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-info mt-2">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold">Daftar Transaksi</h5> 
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-sm table-bordered table-striped" style="width: 100;font-size: 10pt">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No</th>
                                    <th class="text-center">Bidang</th>
                                    <th class="text-center">Jenis Transaksi</th>
                                    <th class="text-center">No Bukti</th>
                                    <th class="text-center" style="width: 6%">Tanggal Bukti</th> 
                                    <th class="text-center">Uraian</th>
                                    <th class="text-center">Rupiah</th>
                                    <th class="text-center">No Pengajuan</th>
                                    <th class="text-center" style="width: 6%">Tanggal Pengajuan</th> 
                                    {{-- <th class="text-center" style="width: 2%">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) > 0)
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}.</td>
                                            <td>{{$item->bidang}}</td>
                                            <td class="text-center">{{$item->jenis}}</td>
                                            <td>{{$item->No_bp}}</td>
                                            <td class="text-center">{{date('d-m-Y', strtotime($item->dt_bp))}}</td>
                                            <td>{{$item->Ur_bp}}</td>
                                            <td class="text-right">{{number_format($item->Rupiah,2,',','.')}}</td>
                                            <td>{{$item->pengajuan}}</td>
                                            <td class="text-center">{{date('d-m-Y', strtotime($item->tgl_pengajuan))}}</td>
                                            {{-- <td class="text-center">
                                                <a href="" id="rincian" class="btn btn-sm btn-info" title="rincian"><i class="fas fa-eye"></i></a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">Tidak ada data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div id="result-modal"></div>               
</section>
@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        tahun = {{ Tahun() }};

        $('#reservation').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: "MM/DD/YYYY"
            },
            startDate: "01/01/" + tahun,
        });
    
        $('.select2').select2()
        $("#table").DataTable({
            "responsive": true,
            "pageLength": 100,
            "buttons": ["excel"]
        }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
    })

</script>
@endsection
