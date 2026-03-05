@extends('layouts.template')

@section('content')
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
        @if(!empty($spjgu))
          <div class="card-header bg-info py-2">
          <h5 class="card-title font-weight-bold">Rincian Ls Tagihan Nomor: {{$spjgu1->No_SPi}}</h5> 
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
                      <th class="text-center" style="vertical-align: middle">No</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      <th class="text-center" style="vertical-align: middle">Penyedia</th>
                      <th class="text-center" style="vertical-align: middle">Nilai (Rp)</th>
                      <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 0;?>
                @foreach ($spjgu as $spjgu2)
                <?php $no++ ;?>
                  <tr>              
                    <td class="text-center" style="vertical-align: middle;width: 3%">{{$no}}</td>                       
                    <td class="text-center" style="vertical-align: middle">{{ $spjgu2->No_bp }}</td>                    
                    <td class="text-center" style="vertical-align: middle">{{ $spjgu2->dt_bp }}</td> 
                    <td style="vertical-align: middle">{{ $spjgu2->Ur_bprc }}</td>                      
                    <td class="text-center" style="vertical-align: middle">{{ $spjgu2->nm_BUcontr }}</td>                      
                    <td class="text-right" style="vertical-align: middle">{{ number_format($spjgu2->spirc_Rp,2,',','.') }}</td>                              
                    <td>
                      <div class="row justify-content-center">
                        <button type="button" class="btn btn-sm btn-info file-alt" data-toggle="modal" data-target="#modal{{ $spjgu2->id }}" title="Detail Rincian">
                            <i class="fas fa-info-circle"></i>
                          </button>

                      &nbsp&nbsp&nbsp

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal2{{ $spjgu2->id }}" title="Hapus Rincian"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{ $spjgu2->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Detail Rincian SPP Ganti Uang (GU) - Nomor Bukti {{ $spjgu2->No_spi }}</h5>
                              </div>
                              <div class="modal-body">
                                  <!-- Default box -->
                                  <div class="container-fluid">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <!-- /.card-body -->
                                                  <div class="card">
                                                      <div class="card-body card-secondary">
                                                          <div class="row">
                                                              <div class="col-sm-12">
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">No. Rincian</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-2">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_spirc }}" readonly>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Bukti yg diajukan</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-5">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->No_bp }}" readonly>
                                                                      </div>
                                                                      <div class="col-sm">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_bprc }}" readonly>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Kegiatan</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_sKeg1 }}" readonly>
                                                                      </div>
                                                                      <div class="col-sm-5">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_sKeg2 }}" readonly>
                                                                      </div>
                                                                      <label for="" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Kode Akun</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-8">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_Rkk }}" readonly>
                                                                      </div>
                                                                      <label for="" class="col-sm col-form-label">Nama Akun</label>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Jenis Sumber</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-4">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ko_Pdp }}" readonly>
                                                                      </div>

                                                                      <label for="" class="col-sm-2 col-form-label">Sumber</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->ko_pmed }}" readonly>
                                                                      </div>
                                                                      <label for="" class="col-sm col-form-label">Jenis Sumber</label>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">No. Ref Bukti</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-4">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->rftr_bprc }}" readonly>
                                                                      </div>

                                                                      <label for="" class="col-sm-2 col-form-label">Tgl. Ref. Bukti</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->dt_rftrbprc }}" readonly>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Uraian Bukti</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm">
                                                                          <input type="text" class="form-control" value="{{ $spjgu2->Ur_bprc }}" readonly>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group row">
                                                                      <label for="" class="col-sm-2 col-form-label">Nilai (Rp)</label>
                                                                      <label for="" class="col-form-label">:</label>
                                                                      <div class="col-sm-4">
                                                                          <input type="text" class="form-control" value="{{old('spirc_Rp', number_format($spjgu2->spirc_Rp,2,',','.'))}}" readonly>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <!-- /.card-footer-->
                                                      <div class="card-footer">
                                                          <div class="row">
                                                              <div class="col-md-10"></div>
                                                              <div class="col-md-1">   
                                                              </div>
                                                              <div class="col-md-1">
                                                                  <button class="btn btn-danger btn-block px-0" data-dismiss="modal">Kembali</button>
                                                              </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <!-- /.card -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      
                      <div class="modal fade" id="modal2{{ $spjgu2->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus rincian SPP Ganti Uang (GU) dengan nomor bukti {{ $spjgu2->No_bp }} ?</h6>
                            </div>
                            <div class="modal-footer">
                            <form action="{{ route('hapusrincianspjgu', $spjgu2->id) }}" method="post" class="">
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
                      <th class="text-center" style="vertical-align: middle">No</th>
                      <th class="text-center" style="vertical-align: middle">Nomor Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Tanggal Bukti</th>
                      <th class="text-center" style="vertical-align: middle">Uraian</th>
                      <th class="text-center" style="vertical-align: middle">Penyedia</th>
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