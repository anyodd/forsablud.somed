@extends('layouts.template')
@section('style') @endsection

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            @if(getUser('user_level') == 1 || getUser('user_level') == 98 || getUser('user_level') == 99)
            <h5 class="card-title font-weight-bold">Data RBA</h5> 
            @else
            <h5 class="card-title font-weight-bold">Data RBA : {{ nm_bidang() }}</h5> 
            @endif
          </div>
          <div class="col-12 mb-2 mt-2">
            <a href="{{ route('rba.pdf') }}" class="btn btn-outline-primary"><i class="fas fa-print"></i> RBA</a>
            <a href="{{ route('laporan.perencanaan.cetak-rka.index') }}" class="btn btn-outline-primary"><i class="fas fa-print"></i> RKA</a>
          </div>
          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="tabelKeg" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">{{ getUser('user_level') }}</th>
                    @if( getUser('user_level') == 1 || getUser('user_level') == 98 || getUser('user_level') == 99)
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Bidang</th>
                    @endif
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Kode Kegiatan</th>
                    <th class="text-center" style="vertical-align: middle; width: 10%;">Kode Aktivitas</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Aktivitas</th>
                    <th class="text-center" style="vertical-align: middle;">Nilai (Rp)</th>
                    <th class="text-center" style="vertical-align: middle; width: 5%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($aktivitas->count() > 0)
                  @foreach($aktivitas as $number => $aktivitas)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>                      
                    @if( getUser('user_level') == 1 || getUser('user_level') == 98 || getUser('user_level') == 99)
                    <td class="text-center">{{ bidang_id($aktivitas->ko_unit1) }}</td>  
                    @endif                    
                    <td class="text-center">{{ $aktivitas->Ko_sKeg1 }}</td>                      
                    <td class="text-center">{{ $aktivitas->Ko_sKeg2 }}</td>                      
                    <td>{{ $aktivitas->Ur_KegBL2 }}</td>  
                    <td class="text-right">{{ number_format($aktivitas->jumlah, 2, ',', '.') }}</td>  
                    @if($aktivitas->ko_unit1 == kd_bidang())
                    <td class="text-center"><a href="{{ route('akun',[$aktivitas->Ko_sKeg1, $aktivitas->Ko_sKeg2, $aktivitas->Ko_KegBL1]) }}" class="btn btn-outline-primary"><i class="fas fa-angle-double-right"></i></a></td>  
                    @endif 
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="3">Tidak Ada Data</td>
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
    $('#tabelKeg').DataTable( {
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
</script>

@endsection