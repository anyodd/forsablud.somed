@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content px-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <!-- About Me Box -->
                    <div class="card card-info shadow-lg mt-2">
                        <div class="card-header py-2">
                            <h3 class="card-title">Surat Tanda Setoran</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body px-2 py-2">
                            <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-backdrop="static"
                                data-target="#modal-create"><i class="fas fa-plus-circle pr-1"></i> Tambah</button>
                            <select class="form-control-sm float-right" name="bulan" id="bulan" onchange="Mymonth()">
                                <option value="1" {{$bulan == 1 ? 'selected' : ''}}>Januari</option>
                                <option value="2" {{$bulan == 2 ? 'selected' : ''}}>Februari</option>
                                <option value="3" {{$bulan == 3 ? 'selected' : ''}}>Maret</option>
                                <option value="4" {{$bulan == 4 ? 'selected' : ''}}>April</option>
                                <option value="5" {{$bulan == 5 ? 'selected' : ''}}>Mei</option>
                                <option value="6" {{$bulan == 6 ? 'selected' : ''}}>Juni</option>
                                <option value="7" {{$bulan == 7 ? 'selected' : ''}}>Juli</option>
                                <option value="8" {{$bulan == 8 ? 'selected' : ''}}>Agustus</option>
                                <option value="9" {{$bulan == 9 ? 'selected' : ''}}>September</option>
                                <option value="10" {{$bulan == 10 ? 'selected' : ''}}>Oktober</option>
                                <option value="11" {{$bulan == 11 ? 'selected' : ''}}>November</option>
                                <option value="12" {{$bulan == 12 ? 'selected' : ''}}>Desember</option>
                            </select>
                            <p class="form-control-sm font-weight-bold float-right">Bulan</p>
                            <div class="table-responsive">
                                <table id="example1" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">No STS</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Uraian</th>
                                            <th class="text-center">Bendahara</th>
                                            <th class="text-center">NIP Bendahara</th>
                                            <th class="text-center">Nilai (Rp)</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    @if (count($sts ?? '') > 0)
                                        <tbody>
                                            @foreach ($sts as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                                    <td>{{ $item->No_sts }}</td>
                                                    <td class="text-center">{{ date('d M Y', strtotime($item->dt_sts)) }}</td>                      
                                                    <td>{{ $item->Ur_sts }}</td>
                                                    <td>{{ $item->Nm_Ben }}</td>
                                                    <td>{{ $item->NIP_Ben }}</td>
                                                    <td class="text-right">{{ number_format($item->total,0,'','.') }}</td>
                                                    <td class="text-center" style="width: 15%">
                                                        <a href="{{ route('sts_pdf', $item->id_sts)}}" class="btn btn-sm btn-primary" target="_blank" style="float: right;" title="Preview/Cetak">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <a href="{{ route('sts.detail', $item->id_sts)}}"
                                                            class="btn btn-sm btn-info" title="Tambah rincian"> <i
                                                                class="fa fa-angle-double-right"></i>
                                                        </a>
                                                        <button class="btn btn-warning btn-sm ml-2 mr-2" title="Edit data" id="edit"
                                                            data-toggle="modal" data-target="#modal-edit{{$item->id_sts}}"
                                                            ><i class="fa fa-edit"> </i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$item->id_sts}}" >
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="delete{{ $item->id_sts }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <h6>Yakin mau hapus data sts nomor {{ $item->No_sts }} ?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <form action="{{ route('sts.destroy', $item->id_sts) }}" method="post" class="">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Kembali</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                @include('transaksi.penerimaan.sts.edit')
                                            @endforeach
                                        </tbody>
                                    @endif

                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        @include('transaksi.penerimaan.sts.create')

    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            $('.select2').select2()
            $('.select3').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#modal-create').on('hidden.bs.modal', function(){
                $(this).find('form')[0].reset();
            });

            $(document).on('change','#pegawai', function () {
                var data = document.getElementById("pegawai").value;
                var nip = data.split("|");
                $('#nip').val(nip[1]);
            });

            $(document).on('change','#editpegawai', function () {
                var data = document.getElementById("editpegawai").value;
                var nip = data.split("|");
                $('#NIP_Benedit').val(nip[1]);
            });
        })

        function Mymonth()
        {
            var slug = $('#bulan').val();
            console.log(slug);
            var url = '{{ route("sts.bulan", ":slug") }}';
            url = url.replace(':slug', slug);
            window.location.href=url;
        }
    </script>
@endsection
