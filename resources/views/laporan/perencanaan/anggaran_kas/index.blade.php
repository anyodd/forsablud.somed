@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Laporan Anggaran Kas</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="list-group">
              <a href="{{ route('lap_ang_kas_pendapatan') }}" class="list-group-item list-group-item-action" target="_blank"  title="Cetak"><h6>Anggaran Kas Pendapatan</h6></a>
              <a href="{{ route('lap_ang_kas_belanja_keg') }}" class="list-group-item list-group-item-action" target="_blank"  title="Cetak"><h6>Anggaran Kas Belanja - Per Kegiatan</h6></a>
              <a href="{{ route('lap_ang_kas_pembiayaan') }}" class="list-group-item list-group-item-action" target="_blank"  title="Cetak"><h6>Anggaran Kas Pembiayaan</h6></a>
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