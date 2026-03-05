@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pendapatan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
          </ol>
        </div>
      </div>
    </div> -->
</section>

  <!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <table class="table table-hover text-nowrap dtable">
                  <tbody>
                    <tr>
                      <td style="width: 10px"><b>Unit</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ nm_bidang() }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      <td><a href="{{ route('kegiatan.index') }}"> {{ $map->Ko_sKeg1 }} - {{ $map->Ur_sKeg }}</a></td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Sub Kegiatan</b></td>
                      <td style="width: 1px">:</td>
                      <td><a href="{{ route('program', $map2->Ko_sKeg1) }}">{{ $map2->Ko_KegBL1 }} - {{ $map2->Ur_KegBL1 }}</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="card float-right">
                    <a href="{{ route('program', $map2->Ko_sKeg1) }}" class="btn btn-outline-primary float-right"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>  
              </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-file-alt"></i>
                            Aktivitas
                        </h3>
                      </div>
                        <div class="card-body">
                            <table class="table table-hover text-nowrap dtable">
                                <thead>
                                  <tr>
                                    <th>Kode Kegiatan</th>
                                    <th>Kode Sub Kegiatan</th>
                                    <th>Kode Aktivitas</th>
                                    <th>Nama Aktivitas</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $item)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg1 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg2 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg2 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ur_KegBL2 }}</td>
                                            <td><a href="{{ route('akun',[$item->Ko_sKeg1, $item->Ko_sKeg2, $item->Ko_KegBL1]) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-2">
                    <div class="card">
                        <button type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
                    </div>  
                </div>
            </div> --}}
          </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.dtable').DataTable();
    });
</script>
@endsection