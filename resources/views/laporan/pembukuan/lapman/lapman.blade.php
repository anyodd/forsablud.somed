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
            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">LO</a></li>
            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">LPSAL</a></li>
        </ul>
        <button class="btn btn-primary m-2 cetak" href="#" onclick="tabPilih()"><i class="fa fa-print pr-1"></i>
            cetak</button>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" ambil="lo" id="tab_1">
                @include('laporan.pembukuan.lapman.lo')
            </div>

            <div class="tab-pane" ambil="lpsal" id="tab_2">
                @include('laporan.pembukuan.lapman.lpsal')
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    function tabPilih() {
        var id = $("div.tab-pane.active").attr("ambil");
        // alert(id);

        $.ajax({
            type: "post",
            url: "{{ route('lapman.pdf.cetak') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'lapman': id
            },
            success: function(data) {
                // 
            }
        })
    }
</script>

@endsection