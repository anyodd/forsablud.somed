@extends('layouts.template')
@section('title', 'Rincian Bukti Termin')
@section('style') 
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> @yield('title') </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/termin">Bukti Termin</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">RINCIAN</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="card-body">
                <a href="{{ route('subtermin.tambah', Request::segment(3)) }}">
                  <button class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle pr-1"></i>
                    Tambah 
                  </button>
                </a>
                <a href="{{route('termin.pajak', $idbp)}}">
                  <button class="btn btn-sm btn-warning mx-1">
                    <i class="fas fa-money-check pr-1"></i>
                    Potong Pajak
                  </button>
                </a>
                <a href="{{ route('termin.bulan',Session::get('bulan'))}}" class="btn btn-sm btn-success float-right">
                    <i class="far fa-arrow-alt-circle-left"> Kembali</i>
                </a>
              <br><br>
              <!-- <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSubBlu">Tambah</button>
                  </div>
              </div>
              <br> -->
              <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width: 5%;">No Rincian</th>
                    <th class="text-center" style="width: 10%; vertical-align: middle;">No Bukti</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">No Ref Bukti</th>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Ref Bukti</th>
                    <th class="text-center" style="vertical-align: middle;">Kode Kegiatan APBD</th>
                    <th class="text-center" style="vertical-align: middle;">Kode Kegiatan BLU</th>
                    <th class="text-center" style="vertical-align: middle;">Kode Akun</th>
                    <th class="text-center " style="vertical-align: middle;">Nilai (Rp)</th>
                    <th class="text-center" style="width: 10%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rincian as $r)
                  <tr>
                    <td class="text-center">{{ $r->Ko_bprc }}</td>                       
                    <td>{{ $r->No_bp }}</td>                      
                    <td>{{ $r->Ur_bprc }}</td>                      
                    <td>{{ $r->rftr_bprc }}</td>                      
                    <td class="text-center">{{ date('d M Y', strtotime($r->dt_rftrbprc)) }}</td>                      
                    <td>{{ $r->Ko_sKeg1 }}</td>                      
                    <td>{{ $r->Ko_sKeg2 }}</td>
                    <td>{{ $r->Ko_Rkk }}</td>                      
                    <td class="text-right">{{ number_format($r->To_Rp,2,',','.') }}</td>                       
                    <td>
                      <div class="row justify-content-center" >
                        <div class="col-sm-3">
                            <a href="{{route('subtermin.edit',$r->id_bprc)}}">
                              <button class="btn btn-sm btn-warning" style="display: flex; align-items: center; justify-content: center;" title="Edit">
                              <i class="fas fa-edit"></i></button>
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-sm btn-danger" style="display: flex; align-items: center; justify-content: center;" data-toggle="modal" data-target="#modal2{{ $r->id_bprc }}" title="Hapus Rincian"> 
                              <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <div class="modal fade" id="modal2{{ $r->id_bprc }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h6>Yakin mau hapus data ?</h6>
                              </div>
                              <div class="modal-footer">
                                <form action="{{ route('subtermin.destroy', $r->id_bprc) }}" method="post" class="">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger" name="submit" title="Hapus">Ya, Hapus
                                  </button>
                                </form>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                              </div>
                            </div>
                          </div>
                      </div>
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
@include('transaksi.belanja.subtermin.popup.rekening')

@endsection

@section('script')  

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

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
      var url = '{{ route("termin.bulan", ":slug") }}';
      url = url.replace(':slug', slug);
      window.location.href=url;
  }
</script>

@endsection