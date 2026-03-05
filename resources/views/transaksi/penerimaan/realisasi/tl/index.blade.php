@extends('layouts.template')
@section('title', 'Realisasi Piutang')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('content')

<section class="content px-0">
  <div class="container-fluid"><br>
    <div class="row">
      <div class="col-md-12">
          <a href="{{route('realisasi.bulan',date('m'))}}" class="btn btn-sm btn-primary">Pendapatan Rutin</a>
          <a href="#" class="btn btn-sm btn-primary disabled">Piutang</a>
          <a href="{{route('realisasipdd.bulan',date('m'))}}" class="btn btn-sm btn-primary">Pendapatan Diterima Dimuka</a>
      </div>
  </div>
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">@yield('title')</h5> 
          </div>

          <div class="card-body px-2 py-2">
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
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th class="text-center" style="vertical-align: middle;">Nomor Bukti</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Bukti</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">Nama kasir / penjamin</th>
                    <th class="text-center" style="vertical-align: middle;">Piutang (Rp)</th>
                    <th class="text-center" style="vertical-align: middle;">Realisasi (Rp)</th>
                    <th class="text-center" style="width: 7%;">#</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $number => $realisasi)
                  <tr>
                    <td class="text-center" >{{$loop->iteration}}</td> 
                    <td>{{ $realisasi->No_bp }}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($realisasi->dt_bp)) }}</td>                      
                    <td>{{ $realisasi->Ur_bp }}</td>                      
                    <td>{{ $realisasi->nm_BUcontr }}</td>                      
                    <td class="text-right">{{ number_format($realisasi->piutang,0,',','.') }}</td>                      
                    <td class="text-right">{{ number_format($realisasi->realisasi,0,',','.') }}</td>                      
                    <td class="text-center">
                      <a href= "{{ route('realisasitl.tambah',$realisasi->id_bp) }}" class="btn btn-sm btn-success" title="Realisasi" onclick="deleteItems()">
                        <i class="fas fa-money-check"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>

              </table>
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
    $('#example').DataTable();
  });

  function deleteItems() {
    localStorage.clear();
  }

  function Mymonth()
  {
    var slug = $('#bulan').val();
    console.log(slug);
    var url = '{{ route("realisasitl.bulan", ":slug") }}';
    url = url.replace(':slug', slug);
    window.location.href=url;
  }
</script>
@endsection