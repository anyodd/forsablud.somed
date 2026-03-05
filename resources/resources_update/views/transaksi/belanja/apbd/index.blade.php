    @extends('layouts.template')
    @section('title', 'Apbd')

    @section('content')
        <section class="content px-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="card shadow-lg mt-2">
                            <div class="card-header bg-info py-2">
                                <h5 class="card-title font-weight-bold">Data Belanja : APBD - SP2D</h5><br>
                            </div>
                            <div class="card-body px-2 py-2">
                                <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal"
                                    data-backdrop="static" data-target="#modal_create"><i class="fas fa-plus-circle"></i> Tambah</button>
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
                                    <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%"
                                        cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" style="vertical-align: middle;">No</th>
                                                <th class="text-center" style="vertical-align: middle;">Nomor Bukti</th>
                                                <th class="text-center" style="vertical-align: middle;">Tanggal Bukti
                                                </th>
                                                <th class="text-center" style="vertical-align: middle;">Uraian</th>
                                                <th class="text-center" style="vertical-align: middle;">Nama Pihak Lain
                                                </th>
                                                <th class="text-center" style="vertical-align: middle;">Alamat Pihak Lain
                                                </th>
                                                <th class="text-center" style="vertical-align: middle;">Nilai (Rp)
                                                    Data</th>
                                                <th class="text-center" style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($belanja->count() > 0)
                                                @foreach ($belanja as $number => $belanja)
                                                    <tr>
                                                        <td class="text-center" style="max-width: 50px;">
                                                            {{ $loop->iteration }}.
                                                        </td>
                                                        <td>{{ $belanja->No_bp }}</td>
                                                        <td class="text-center">{{ date('d M Y', strtotime($belanja->dt_bp)) }}</td>                      
                                                        <td>{{ $belanja->Ur_bp }}</td>
                                                        <td>{{ $belanja->nm_BUcontr }}</td>
													{{--<td>{{ $belanja->adr_bucontr }}</td>--}}
														<td>{{ $belanja->Jn_Spm }}</td>
                                                        <td class="text-right">{{ number_format($belanja->jml,2,',','.') }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ route('subapbd.rincian', ['id' => $belanja->id_bp]) }}">
                                                                <button class="btn btn-sm btn-info mr-1" title="Detail">
                                                                    <i class="fa fa-angle-double-right"></i></button>
                                                            </a>
                                                            <button class="btn btn-sm btn-warning" type="button"
                                                                data-toggle="modal"
                                                                data-target="#modal_edit{{ $belanja->id_bp }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            @if ($belanja->jml == 0)
                                                                <button class="btn btn-sm btn-danger" type="button"
                                                                data-toggle="modal"
                                                                data-target="#modal{{ $belanja->id_bp }}"><i
                                                                    class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-danger" type="button"
                                                                data-toggle="modal"
                                                                data-target="#modal{{ $belanja->id_bp }}" disabled><i
                                                                    class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                            <div class="modal fade" id="modal{{ $belanja->id_bp }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalCenterTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-info">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLongTitle">
                                                                                Konfirmasi :</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-center">Yakin Mau Hapus Data
                                                                            </p>
                                                                            <p class="text-center">
                                                                                <b>{{ $belanja->No_bp }}</b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form
                                                                                action="{{ route('apbd.destroy', ['apbd' => $belanja->id_bp]) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-danger mr-3"
                                                                                    name="submit" title="Hapus">Ya, Hapus
                                                                                </button>
                                                                            </form>
                                                                            <button type="button" class="btn btn-primary"
                                                                                data-dismiss="modal">Kembali</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- edit dan delete --}}

                                                            <div class="modal fade" id="modal{{ $belanja->id_bp }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalCenterTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLongTitle">Konfirmasi :</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h6>Yakin mau hapus data Belanja
                                                                                {{ $belanja->Ur_Belanja }} ?</h6>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form
                                                                                action="{{ route('apbd.destroy', $belanja->id_bp) }}"
                                                                                method="post" class="">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger mr-3"
                                                                                    name="submit" title="Hapus">Ya, Hapus
                                                                                </button>
                                                                            </form>
                                                                            <button type="button" class="btn btn-primary"
                                                                                data-dismiss="modal">Kembali</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>
                                                    @include(
                                                        'transaksi.belanja.apbd.edit'
                                                    )
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>Tidak Ada Data</td>
                                                </tr>
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('transaksi.belanja.apbd.create')

        </section>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
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

            function Mymonth()
            {
                var slug = $('#bulan').val();
                console.log(slug);
                var url = '{{ route("apbd.bulan", ":slug") }}';
                url = url.replace(':slug', slug);
                window.location.href=url;
            }
        </script>
    @endsection
