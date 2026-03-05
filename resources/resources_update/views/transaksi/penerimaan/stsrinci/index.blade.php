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
                            <h3 class="card-title"> Data STS Rinci Nomor {{ $tb_sts->No_sts }} atas : {{ $tb_sts->Ur_sts ?? 'BLUD ' }} </h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body px-2 py-2">
                            <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#modal_stsbayar" data-backdrop="static"><i class="fas fa-plus-circle pr-1"></i>Tambah</i></button>
                            <a href="{{ route('sts.bulan',Session::get('bulan')) }}" class="btn btn-sm btn-success float-right">
                                <i class="fas fa-share fa-rotate-180"></i>Kembali
                            </a>
							<div class="table-responsive">
								<table id="example1" class="table table-sm table-bordered table-striped">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Uraian Bayar</th>
											<th class="text-center">Tanggal Bayar</th>
											<th class="text-center">Nilai (Rp)</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
									@if (count($stsdetail ?? '') > 0)
										<tbody>
											@foreach ($stsdetail as $item)
												<tr>
													<td class="text-center" style="width: 3%;">{{ $loop->iteration }}.</td>
													<td>{{ $item->Ur_byr }}</td>
													<td class="text-center">{{ $item->dt_byr }}</td>
													<td class="text-right">{{ number_format($item->total,0,'','.') }}</td>
													<td class="text-center">
														<form action="{{ route('stsrinci.destroy', $item->id_stsrc) }}" method="post" class="d-inline"
															onsubmit="return confirm('Yakin hapus {{ $item->id_stsrc }} ?')">
															@method("delete")
															@csrf
															<button title="Hapus data" type="submit" data-name=""
																data-table="sesuai" class="btn btn-sm btn-danger"><i
																	class="fa fa-trash pr-1"></i></button>
														</form>
													</td>
												</tr>
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
        @include('transaksi.penerimaan.stsrinci.popup_stsbayar')    
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "pageLength": 20,
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


            $("#example3").DataTable({
                "pageLength": 20,
            });
            $('#example4').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // $(document).on('click', '#pilih', function() {
            //     var kd_byr = $(this).data('no_byr');
            //     $('#No_byr').val(kd_byr);
            //     $('#modal_stsbayar').hide();
            // });

            let ceklist = $('table tbody .check:checked')
            let cek = (ceklist.length > 0)
            $('#submit').prop('disabled',!cek);

            $(document).on('click','#checkall', function () {
                var isChecked = $('#checkall').prop('checked')
                $('.check').prop('checked',isChecked);

                if(isChecked > 0) {
                $('#submit').prop('disabled',false);
                }else{
                $('#submit').prop('disabled',true);
                }
            });

            $(document).on('click','.check', function () {
                let cek = $('table tbody .check:checked')

                if(cek.length > 0) {
                $('#submit').prop('disabled',false);
                }else{
                $('#submit').prop('disabled',true);
                }
            });

            function getData() {
                let dt = $('.check:checked')
                let data = []
                $.each(dt, function (index, elm) { 
                    data.push(elm.value)
                });

                $('#id_rc').val(data);
                console.log(dt);
            }
            $(document).on('click','#submit', function () {
                let dt = $('.check:checked')
                let data = []
                $.each(dt, function (index, elm) { 
                    data.push(elm.value)
                });

                $('#id_rc').val(data);
            });

        })
    </script>
@endsection
