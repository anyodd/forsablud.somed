@extends('layouts.template')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kasawal.index') }}">Data Kas Awal/UP</a></li>
    <li class="breadcrumb-item active pull-right" aria-current="page">Detail Rincian Kas Awal/UP</li>
  </ol>
</nav>

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
        @if(!empty($kasawal))
          <div class="card-header bg-info py-2">
          <h5 class="card-title font-weight-bold">Detail Rincian</h5> 
          </div>
          <div class="card-body px-2 py-2">
            <div class="table-responsive">
            @if (session('alert'))
                <div class="alert alert-danger">
                    {{ session('alert') }}
                </div>
            @endif
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle">No Rincian</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Rincian Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Uraian Bukti</th>
                      <th class="text-center" style="vertical-align: middle">No Ref. Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Tgl Ref. Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Kode Akun</th>
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                
                @foreach ($kasawal as $kasawal2)
                
                  <tr>              
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->Ko_spirc }}</td>                      
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->No_bp }}</td>    
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->Ko_spirc }}</td>                   
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->Ur_bprc }}</td> 
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->rftr_bprc }}</td>                      
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->dt_rftrbprc }}</td>                      
                    <td class="text-center" style="vertical-align: middle">{{ $kasawal2->Ko_Rkk }}</td>
                    <td class="text-center myDIV" style="vertical-align: middle">{{ $kasawal2->spirc_Rp }}</td>                    
                    <td>
                      <div class="row justify-content-center">
                        <form action="{{ route('edit', $kasawal2->id) }}" method="get" class="">
                          <button type="submit" class="btn btn-sm btn-warning" name="submit" title="Edit Rincian">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        &nbsp&nbsp&nbsp

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal2{{ $kasawal2->id }}" title="Hapus Rincian"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                      
                      <div class="modal fade" id="modal2{{ $kasawal2->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus rincian Kas Awal/UP dengan nomor bukti {{ $kasawal2->No_bp }} ?</h6>
                            </div>
                            <div class="modal-footer">
                            <form action="{{ route('hapusrinciankasawal', $kasawal2->id) }}" method="post" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                </button>
                              </form>
                              <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Kembali</button>
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
          @else
          <div class="card-header bg-info py-2">
          <h5 class="card-title font-weight-bold"> Detail Rincian </h5> 
          </div>
          <div class="card-body px-2 py-2"> 
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="vertical-align: middle">No Rincian</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Rincian Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Uraian Bukti</th>
                      <th class="text-center" style="vertical-align: middle">No Ref. Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Tgl Ref. Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Kode Akun</th>
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
          </div>
          @endif    
        </div>
      </div>
    </div>
  </div>
</section>   

@endsection

@section('script')

<script>
        let x = document.querySelectorAll(".myDIV");
        for (let i = 0, len = x.length; i < len; i++) {
            let num = Number(x[i].innerHTML)
                      .toLocaleString('en');
            x[i].innerHTML = num;
            x[i].classList.add("currSign");
        }
</script>
        
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

  </script>

  @endsection