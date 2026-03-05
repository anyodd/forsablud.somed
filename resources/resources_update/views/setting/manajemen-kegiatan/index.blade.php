@extends('layouts.admin.app')

@section('content')
    <div class="page-title-box">
        <div class="row">
            <div class="col">
                <h2 class="my-2 font-30 ">Program - Kegiatan</h2>
            </div>
            <div class="col-auto align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">FMIS</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Parameter</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Global</a></li>
                    <li class="breadcrumb-item active">Program - Kegiatan</li>
                </ol>
            </div>
        </div>
    </div>


    <div class="container-fluid pt-1">
        <ul class="nav nav-pills nav-fill" id="nav-parent" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link font-13 active" id="tab-urusan-bidang" data-toggle="tab" href="#urusan-bidang" role="tab"
                    aria-controls="urusan-bidang" aria-selected="true">Urusan dan Bidang</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link font-13 disabled" id="tab-program" data-toggle="tab" href="#program" role="tab"
                    aria-controls="program" aria-selected="false">Program</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link font-13 disabled" id="tab-kegiatan" data-toggle="tab" href="#kegiatan" role="tab"
                    aria-controls="kegiatan" aria-selected="false">Kegiatan</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link font-13 disabled" id="tab-sub-kegiatan" data-toggle="tab" href="#sub-kegiatan" role="tab"
                    aria-controls="sub-kegiatan" aria-selected="false">Sub Kegiatan</a>
            </li>
        </ul>

        <div class="tab-content" id="tab-parent">
            <div class="tab-pane active" id="urusan-bidang" role="tabpanel" aria-labelledby="tab-urusan-bidang">
                <div class="p-2">
                    <h4>Urusan dan Bidang</h4>
                    <li>
                        <small>untuk melihat rincian program, kegiatan dan Sub Kegiatan <b><i>double click</i></b> atau
                            pilih menu <b>Lihat</b> item bidang pada Urusan dan Bidang pemerintahan yang sesuai</small>
                    </li>
                </div>
                <div class="row pt-3">
                    @foreach ($urusan as $ur)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light curs-point collapsed" data-toggle="collapse"
                                    data-target="#urusan-{{ $loop->iteration }}" aria-expanded="false"
                                    aria-controls="urusan-{{ $loop->iteration }}">
                                    <h4 class="card-title">{{ '[' . $ur->kdurusan . '] ' . $ur->nmurusan }}</h4>
                                </div>
                                <div id="urusan-{{ $loop->iteration }}" class="collapse"
                                    aria-labelledby="urusan-{{ $loop->iteration }}" style="">
                                    <ul class="list-group list-group-flush border-bottom">
                                        @foreach ($ur->bidangs as $bid)
                                            <li class="list-group-item align-items-center curs-point tab-next"
                                                data-target="#tab-program"
                                                data-code="{{ Crypt::encryptString($bid->idbidang) }}" data-type="bidang"
                                                data-info="{{ $ur->kdurusan . '.' . $bid->kdbidang . ' - ' . $bid->nmbidang }}" data-urusan="{{ $ur->kdurusan . ' - ' . $ur->nmurusan }}">
                                                <div class="row">
                                                    <div class="pl-2" style="width: 11%">
                                                        <button type="button" class="btn btn-sm btn-soft-primary btn-next">
                                                            <i class="fas fa-forward"></i> Lihat Program
                                                        </button>
                                                    </div>
                                                    <div class="my-auto" style="width: 89%">
                                                        <span class="mr-2">{{ $loop->iteration . ')' }}</span>
                                                        {{ '[' . $ur->kdurusan . '.' . $bid->kdbidang . '] ' . $bid->nmbidang }}
                                                        <span class="badge badge-soft-success menu-arrow jmlprogram ml-2"
                                                            data-toggle="tooltip" data-placement="right"
                                                            data-original-title="Jumlah Program">{{ $bid->programs()->where('stsprog', 1)->count() }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="program" role="tabpanel" aria-labelledby="tab-program">
                <div class="table-responsive pt-1">
                    <table class="table table-borderless table-hover table-pointer bg-light rounded"
                        id="tabel-program-info" width="100%">
                        <tr class="p-2 border-bottom" >
                            <td colspan="4"> Program-Kegiatan / <b>Program</b></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Urusan</td>
                            <td width="2%">:</td>
                            <td class="info-urusan "></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Bidang</td>
                            <td width="2%">:</td>
                            <td class="info-bidang"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive my-3">
                    <table class="table table-borderless table-hover table-pointer" id="tabel-program" width="100%">
                        <thead class="bg-dark text-center">
                            <tr>
                                <th class="text-white" width="10%"></th>
                                <th class="text-white" width="5%">No</th>
                                <th class="text-white" width="10%">Kode Program</th>
                                <th class="text-white">Nama Program</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="kegiatan" role="tabpanel" aria-labelledby="tab-kegiatan">
                <div class="table-responsive pt-1">
                    <table class="table table-borderless table-hover table-pointer bg-light rounded"
                        id="tabel-kegiatan-info" width="100%">
                        <tr class="p-2 border-bottom" >
                            <td colspan="4"> Program-Kegiatan / <b>Kegiatan</b></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Urusan</td>
                            <td width="2%">:</td>
                            <td class="info-urusan "></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Bidang</td>
                            <td width="2%">:</td>
                            <td class="info-bidang"></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Program</td>
                            <td width="2%">:</td>
                            <td class="info-program"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive my-3">
                    <table class="table table-borderless table-hover table-pointer" id="tabel-kegiatan" width="100%">
                        <thead class="bg-dark text-center">
                            <tr>
                                <th class="text-white" width="10%"></th>
                                <th class="text-white" width="5%">No</th>
                                <th class="text-white" width="10%">Kode Kegiatan</th>
                                <th class="text-white">Nama Kegiatan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="sub-kegiatan" role="tabpanel" aria-labelledby="tab-sub-kegiatan">
                <div class="table-responsive pt-1">
                    <table class="table table-borderless table-hover table-pointer bg-light rounded"
                        id="tabel-sub-kegiatan-info" width="100%">
                        <tr class="p-2 border-bottom" >
                            <td colspan="4"> Program-kegiatan / <b>Sub-Kegiatan</b></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Urusan</td>
                            <td width="2%">:</td>
                            <td class="info-urusan "></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Bidang</td>
                            <td width="2%">:</td>
                            <td class="info-bidang"></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Program</td>
                            <td width="2%">:</td>
                            <td class="info-program"></td>
                        </tr>
                        <tr class="p-2">
                            <td width="8%" >
                                <button type="button" class="btn btn-soft-success btn-xs ml-2 btn-next btn-round"><i
                                        class="fas fa-angle-left"></i> kembali</button>
                            </td>
                            <td width="10%">Kegiatan</td>
                            <td width="2%">:</td>
                            <td class="info-kegiatan"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive my-3">
                    <table class="table table-borderless" id="tabel-sub-kegiatan" width="100%">
                        <thead class="bg-dark text-center">
                            <tr>
                                <th class="text-white" width="5%">No</th>
                                <th class="text-white" width="10%">Kode Sub Kegiatan</th>
                                <th class="text-white">Nama Sub Kegiatan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts_end')
    <script type="text/javascript">
        var table = [];
        var url = '{!! route('parameter.program-kegiatan.datatable') !!}';
        var tabKey = {
            urusan: 0,
            bidang: 1,
            program: 2,
            kegiatan: 3
        };
        var tabOrder = [
            'urusan',
            'bidang',
            'program',
            'kegiatan'
        ];
        var code = [];
        var info = [];

        $(function() {
            $(document).on('dblclick', '.tab-next', function() {
                var target = $(this).data('target');
                var pane = $(target).attr('href');
                var tabIndex = $('.tab-pane').index($('.tab-pane' + pane));
                var type = $(this).data('type');
                code[tabKey[type]] = $(this).data('code');
                info[tabKey[type]] = $(this).data('info');

                if (type == 'bidang') {
                    info[tabKey.urusan] = $(this).data('urusan');
                }

                var prevTarget = 'urusan-bidang';
                var prevTab = 'bidang';

                $.each(tabOrder, function(key, tab) {
                    var tabTarget = tab;

                    if (tab == 'urusan' || tab == 'bidang') {
                        tabTarget = 'urusan-bidang';
                        prevTarget = 'urusan-bidang';
                        prevTab = 'bidang';
                    }

                    $(pane).find('.info-' + tab).html('<strong>' + info[tabKey[tab]] + '</strong>');
                    $(pane).find('.info-' + tab).closest('tr').addClass('tab-next')
                        .data('target', '#tab-' + tabTarget)
                        .data('code', code[tabKey[prevTab]])
                        .data('type', prevTarget)
                        .data('info', info[tabKey[prevTab]])
                        .data('urusan', info[tabKey.urusan]);

                    prevTarget = tab;
                    prevTab = tab;
                });

                initProKegTable('tabel-' + pane.replace('#', ''), tabIndex, code[tabKey[type]]);
                resetProKegTab(tabIndex + 1);
                changeTab(target);
            });

            $(document).on('click', '.btn-next', function() {
                $(this).closest('.tab-next').trigger('dblclick');
            });
        });

        function formatChildTable(id, index) {
            if (id == 'tabel-urusan-bidang-detail') {
                return '<div class="table-responsive py-2 px-3">' +
                    '<table class="table table-pointer" id="' + id + '-' + index + '">' +
                    '<thead class="text-center">' +
                    '<tr>' +
                    '<th width="10%">No</th>' +
                    '<th width="10%">Kode Bidang</th>' +
                    '<th>Nama Bidang</th>' +
                    '</tr>' +
                    '</thead>' +
                    '</table>' +
                    '</div>';
            }

            return '<div class="row">' +
                '<div class="col-12">' +
                '<p>Format tabel belum ada</p>' +
                '</div>' +
                '</div>';
        }

        function initProKegTable(id, index, code) {
            if (id.includes('detail')) {
                var tableId = '#' + id + '-' + index;
            } else {
                var tableId = '#' + id;
            }

            if ($.fn.DataTable.isDataTable(tableId)) {
                $(tableId).DataTable().destroy();
            }

            if (id == 'tabel-urusan-bidang-detail') {
                $(tableId).DataTable({
                    serverSide: true,
                    processing: true,
                    lengthChange: false,
                    info: false,
                    ajax: {
                        url: url,
                        data: function(d) {
                            d.table = 'tabel-urusan-bidang-detail';
                            d.code = code;
                        }
                    },
                    order: [1, 'asc'],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kdbidang',
                            name: 'kdbidang',
                            className: 'text-center'
                        },
                        {
                            data: 'nmbidang',
                            name: 'nmbidang'
                        },
                    ],
                    createdRow: function(row, data, index) {
                        $(row).addClass('tab-next')
                            .data('target', '#tab-program')
                            .data('code', data.code)
                            .data('type', 'bidang')
                            .data('info', data.nmbidang);
                    }
                });
            } else if (id == 'tabel-program') {
                table[index] = $(tableId).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        data: function(d) {
                            d.table = 'tabel-program';
                            d.code = code;
                        }
                    },
                    order: [2, 'asc'],
                    columns: [{
                            data: 'action',
                            name: 'action',
                            className: 'text-center',
                            width: '10%',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center',
                            width: '5%',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kdprogram',
                            name: 'kdprogram',
                            className: 'text-center',
                            width: '10%'
                        },
                        {
                            data: 'nmprogram',
                            name: 'nmprogram'
                        },
                    ],
                    createdRow: function(row, data, index) {
                        $(row).addClass('tab-next')
                            .data('target', '#tab-kegiatan')
                            .data('code', data.code)
                            .data('type', 'program')
                            .data('info', data.kdprogram + ' - ' + data.nmprogram);
                    }
                });
            } else if (id == 'tabel-kegiatan') {
                table[index] = $(tableId).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        data: function(d) {
                            d.table = 'tabel-kegiatan';
                            d.code = code;
                        }
                    },
                    order: [2, 'asc'],
                    columns: [{
                            data: 'action',
                            name: 'action',
                            className: 'text-center',
                            width: '10%',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center',
                            width: '5%',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kdkegiatan',
                            name: 'kdkegiatan',
                            className: 'text-center',
                            width: '10%'
                        },
                        {
                            data: 'nmkegiatan',
                            name: 'nmkegiatan'
                        },
                    ],
                    createdRow: function(row, data, index) {
                        $(row).addClass('tab-next')
                            .data('target', '#tab-sub-kegiatan')
                            .data('code', data.code)
                            .data('type', 'kegiatan')
                            .data('info', data.kdkegiatan + ' - ' + data.nmkegiatan);
                    }
                });
            } else if (id == 'tabel-sub-kegiatan') {
                table[index] = $(tableId).DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        data: function(d) {
                            d.table = 'tabel-sub-kegiatan';
                            d.code = code;
                        }
                    },
                    order: [1, 'asc'],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center',
                            width: '5%',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kdsubkegiatan',
                            name: 'kdsubkegiatan',
                            className: 'text-center',
                            width: '10%'
                        },
                        {
                            data: 'nmsubkegiatan',
                            name: 'nmsubkegiatan'
                        },
                    ]
                });
            }
        }

        function resetProKegTab(tabIndex) {
            for (let index = tabIndex; index < $('.tab-pane').length; index++) {
                var tableId = '#' + $('.tab-pane:eq(' + index + ') .table:eq(1)').attr('id');
                $('.tab-pane:eq(' + index + ') .table:eq(0) tr').each(function() {
                    $(this).find('td:eq(3)').empty();
                });

                if ($.fn.DataTable.isDataTable(tableId)) {
                    $(tableId).DataTable().destroy();
                    $(tableId).find('tbody').remove();
                }
            }
        }

        function changeTab(target) {
            $(target).removeClass('disabled').trigger('click');

            var navElm = $('#nav-parent .nav-link');
            var tableIndex = $('#tab-parent .tab-pane').index($('#tab-parent .tab-pane.active'));

            navElm.each(function() {
                var navIndex = navElm.index($(this));

                if (navIndex > tableIndex) {
                    $(this).addClass('disabled');
                }
            });
        }
    </script>
@endpush
