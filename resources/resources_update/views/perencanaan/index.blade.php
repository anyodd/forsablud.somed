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
          {{-- <div class="card-body">
            <div class="row">
              <div class="col-12">
                <table class="table table-hover text-nowrap dtable">
                  <tbody>
                    <tr>
                      <td style="width: 10px"><b>Periode</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ Tahun() }}</td>
                    </tr>
                    <tr>
                      <td style="width: 10px"><b>Unit</b></td>
                      <td style="width: 1px">:</td>
                      <td>{{ nm_bidang() }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div> --}}
          <div class="card-body">
            <div class="row">
              <div class="col-12 mb-2 xs-2">
                <a href="{{ route('rba.pdf') }}" class="btn btn-outline-primary"><i class="fas fa-print"></i> RBA</a>
                <a href="{{ route('rka1_pendapatan') }}" class="btn btn-outline-primary"><i class="fas fa-print"></i> RKA</a>
              </div>
                {{-- <div class="col-12">
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-file-alt"></i>
                            Kegiatan APBD
                        </h3>
                      </div>
                        <div class="card-body">
                            <table class="table table-hover text-nowrap dtable">
                                <thead>
                                  <tr>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $item)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg1 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ur_sKeg }}</td>
                                            <td><a href="{{ route('program', $item->Ko_sKeg1) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12 col-sm-12">
                  <div class="card card-primary card-primary card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Kegiatan BLUD</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Kegiatan APBD</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                          <div class="card-body">
                            <table class="table table-hover text-nowrap dtable">
                                <thead>
                                  <tr>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt as $item)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg1 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ur_sKeg }}</td>
                                            <td><a href="{{ route('program', $item->Ko_sKeg1) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                          <div class="card-body">
                            <table class="table table-hover text-nowrap dtable">
                                <thead>
                                  <tr>
                                    <th>Kode Kegiatan</th>
                                    <th>Nama Kegiatan</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dt2 as $item)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $item->Ko_sKeg1 }}</td>
                                            <td style="vertical-align: middle">{{ $item->Ur_sKeg }}</td>
                                            <td><a href="{{ route('program', $item->Ko_sKeg1) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card -->
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    
                </div>
            </div>
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