{{-- Advance Table Widget 2 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Data Transaksi Sampai Dengan Hari Ini</span>
        </h3>
        {{--<div class="card-toolbar">
            <ul class="nav nav-pills nav-pills-sm nav-dark-50">
                <li class="nav-item">
                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_1">Month</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_2">Week</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_1_3">Day</a>
                </li>
            </ul>
        </div>--}}
    </div>

    {{-- Body --}}
    <div class="card-body pt-3 pb-0">
        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-borderless table-vertical-center">
                <thead>
                    <tr>
                        <th class="p-0" style="width: 50px"></th>
                        <th class="p-0" style="min-width: 200px"></th>
                        <th class="p-0" style="min-width: 100px"></th>
                        <th class="p-0" style="min-width: 125px"></th>
                        <th class="p-0" style="min-width: 110px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light mr-1">
                                <span class="symbol-label">
                                    <img src="{{ asset('template/dist/img/icon_svg/Book-open.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Bukti Terima/Klaim</a>
                            <div>
                                <span class="font-weight-bolder"> {{ number_format($klaim['jumlahklaim'], 0, ',', '.') }} </span>
                                <a class="label label-md label-light-primary label-inline" >Dokumen</a>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-50 font-weight-bolder d-block font-size-md">
                               Rp. {{ format_money($klaim['nilaiklaim'], 2) }}
                            </span>
                        </td>
                        <td class="text-left">
                            <span class="text-muted font-weight-normal">
								Pendapatan Rutin Tahun Berjalan BLUD
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light">
                                <span class="symbol-label">
                                    <img src="{{ asset('template/dist/img/icon_svg/Box.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Tagihan Terbit</a>
                            <div>
                                <span class="font-weight-bolder"> {{ number_format($tagihan['jumlahtagihan'], 0, ',', '.') }} </span>
                                <a class="label label-md label-light-warning label-inline" href="#">Dokumen</a>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-50 font-weight-bolder d-block font-size-md">
                                 Rp. {{ format_money($tagihan['nilaitagihan'], 2) }}
                            </span>
                        </td>
                        <td class="text-left">
                            <span class="text-muted font-weight-normal">
                                Tagihan Tahun Berjalan BLUD
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light">
                                <span class="symbol-label">
                                    <img src="{{ asset('template/dist/img/icon_svg/Cupboard.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Kontrak Di LS-kan</a>
                            <div>
                                <span class="font-weight-bolder"> {{ number_format($kontrak['jumlahkontrakls'], 0, ',', '.') }} </span>
                                <a class="label label-md label-light-success label-inline" href="#">Dokumen</a>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-50 font-weight-bolder d-block font-size-md">
                                Rp. {{ format_money($kontrak['nilaikontrakls'], 2) }}
                            </span>
                        </td>
                        <td class="text-left">
                            <span class="text-muted font-weight-normal">
                               Tagihan Kontrak LS/SPK BLUD
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light">
                                <span class="symbol-label">
                                    <img src="{{ asset('template/dist/img/icon_svg/Library.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Bukti GU Terbit</a>
                            <div>
                               <span class="font-weight-bolder"> {{ number_format($buktigu['jumlahbuktigu'], 0, ',', '.') }} </span>
                               <a class="label label-md label-light-danger label-inline" href="#">Dokumen</a>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-50 font-weight-bolder d-block font-size-md">
                                 Rp. {{ format_money($buktigu['nilaibuktigu'], 2) }}
                            </span>
                        </td>
                        <td class="text-left">
                            <span class="text-muted font-weight-normal">
                                Bukti Kuitansi Pembayaran dgn Ganti Uang BLUD
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Detail</a>
                        </td>
                    </tr>
                    {{--<tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light">
                                <span class="symbol-label">
                                    <img src="{{ asset('media/svg/misc/014-kickstarter.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-50 font-weight-bolder text-hover-primary mb-1 font-size-md">Pajak Di Pungut</a>
                            <div>
                               <span class="font-weight-bolder"> {{ number_format($pajak['jumlahpajak'], 0, ',', '.') }} </span>
                               <a class="label label-md label-light-info label-inline" href="#">Dokumen</a>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-50 font-weight-bolder d-block font-size-md">
                                 Rp. {{ format_money($pajak['nilaipajak'], 2) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <span class="text-muted font-weight-300">
                                Pajak, Retribusi, Transfer
                            </span>
                        </td>
                        <td class="text-right">
                            <span class="label label-md label-light-info label-inline">In Progress</span>
                        </td>
                    </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
</div>
