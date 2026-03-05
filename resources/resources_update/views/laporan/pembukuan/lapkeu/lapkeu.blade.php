@extends('layouts.template')
@section('style')

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #1db790;
    }

    .nav-pills .nav-link:not(.active):hover {
        color: #1db790;
    }

    .cetak {
        color: #fff;
        background-color: #7f7f7f;
        border-color: #7f7f7f;
        box-shadow: none;
    }

    .cetak:hover {
        color: #fff;
        background-color: #2a2a2a;
        border-color: #2a2a2a;
    }

    .cetak:not(:disabled):not(.disabled).active,
    .cetak:not(:disabled):not(.disabled):active,
    .show>.cetak.dropdown-toggle {
        color: #fff;
        background-color: #2a2a2a;
        border-color: #2a2a2a;
    }

    .cetak.focus,
    .cetak:focus {
        color: #fff;
        background-color: #2a2a2a;
        border-color: #2a2a2a;
        box-shadow: 0 0 0 0 rgb(38 143 255 / 50%);
    }
</style>

@endsection

@section('content')

<div class="card mt-3 mx-2">
    <div class="card-header d-flex p-0">
        <ul class="nav nav-pills mr-auto p-2">
            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">LRA</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_6" data-toggle="tab">LPSAL</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Neraca</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="tab">LO</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">LAK</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">LPE</a></li>
        </ul>
        <button class="btn btn-primary m-2 cetak" href="#" onclick="tabPilih()"><i class="fa fa-print pr-1"></i>
            cetak</button>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" ambil="lra" id="tab_1">
                @include('laporan.pembukuan.lapkeu.lra')
            </div>

            <div class="tab-pane" ambil="neraca" id="tab_2">
                @include('laporan.pembukuan.lapkeu.neraca')
            </div>

            <div class="tab-pane" ambil="lak" id="tab_3">
                @include('laporan.pembukuan.lapkeu.lak')
            </div>

            <div class="tab-pane" ambil="lpe" id="tab_4">
                @include('laporan.pembukuan.lapkeu.lpe')
            </div>

            <div class="tab-pane" ambil="lo" id="tab_5">
                @include('laporan.pembukuan.lapkeu.lo')
            </div>

            <div class="tab-pane" ambil="lpsal" id="tab_6">
                @include('laporan.pembukuan.lapkeu.lpsal')
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    function tabPilih() {
        var id = $("div.tab-pane.active").attr("ambil");

        $.ajax({
            type: "post",
            url: "{{ route('lapkeu.pdf.cetak') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'lapkeu': id
            },
            success: function(data) {
                // 
            }
        })
    }
</script>

@endsection