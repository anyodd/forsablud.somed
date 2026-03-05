@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Data Pengajuan</h5> 
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
                    <th class="text-center" style="vertical-align: middle;width: 3%">No.</th>
                      <th class="text-center" style="vertical-align: middle">Nomor SPP</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal SPP</th>
                      <th class="text-center" style="vertical-align: middle">Jenis</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="vertical-align: middle; width: 8%">Status</th>
                      <th class="text-center" style="width: 8%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($spi))
                  @foreach($spi as $number => $spi)
                  <tr>
                    <td style="text-align: center">{{$loop->iteration}}.</td>                                         
                    <td>{{ $spi->No_SPi }}</td>                      
                    <td class="text-center">{{ \Carbon\Carbon::parse($spi->Dt_SPi)->format('d-m-Y')}}</td>                      
                    <td>{{ $spi->Ur_spi }}</td>
                    <td>{{ $spi->Ur_SPi }}</td>  
                    <td class="text-right">{{ number_format($spi->t_rp,2,',','.') }}</td>  
                    <td class="text-center">
                      @if ($spi->Tag_v ==  0)
                      <span class="badge badge-secondary">Belum diajukan</span>
                      @elseif($spi->Tag_v == 1)
                      <span class="badge badge-warning">Belum diverifikasi</span>
                      @elseif($spi->Tag_v == 2)
                      <span class="badge badge-primary">Otorisasi</span>    
                      @endif
                    </td>
                    <td class="align-top">
						<div class="row justify-content-center">
						  <div class="btn-group">
							<button type="button" class="btn btn-sm btn-primary dropdown-toggle mx-1" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-print"></i></button>
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu" style="">
							  <a class="dropdown-item" href="{{route('verifikasi.cetak_ksppd',$spi->id)}}" target="_blank">Kelengkapan S-PPD</a>
							  <a class="dropdown-item" href="{{route('verifikasi.cetak_sptjb',$spi->id)}}" target="_blank">SPTJB</a>
							  <a class="dropdown-item" href="{{route('verifikasi.cetak_sptjverif',$spi->id)}}" target="_blank">SPTJ Verif</a>
							</div>
						  </div>
							@if ($spi->Tag_v == 1)
							<form action="{{route('verifikasi.show',$spi->id)}}" method="get">
							  <button type="submit" class="btn btn-sm btn-info file-alt mx-1" title="Lihat Rincian" name="submit">
							  <i class="fas fa-eye"></i>
							  </button>
							</form>
							@else
							<form action="{{route('verifikasi.show',$spi->id)}}" method="get">
							  <button type="submit" class="btn btn-sm btn-info file-alt mx-1" title="Lihat Rincian" name="submit" disabled>
							  <i class="fas fa-eye"></i>
							  </button>
							</form>
						</div>  
                      @endif
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="11">Tidak Ada Data</td>
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
</section>  

@endsection

@section('script')

<script>
  $(document).ready(function() {
    $('#example').DataTable( {
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal( {
            header: function ( row ) {
              var data = row.data();
              return 'Details for '+data[0]+' '+data[1];
            }
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
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
    var url = '{{ route("verifikasi.bulan", ":slug") }}';
    url = url.replace(':slug', slug);
    window.location.href=url;
  }

</script>

@endsection