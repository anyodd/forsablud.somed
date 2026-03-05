@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Potong Pajak</h5> 
          </div>

          <div class="card-body px-2 py-2">
            <div class="row">
              <table class="table-borderless table-sm text-nowrap">
                <tbody>
                  <tr>
                    <td style="width: 10px"><b>No. Tagihan</b></td>
                    <td style="width: 1px">:</td>
                    <td>{{$tagihan->No_bp}}</td>
                  </tr>
                  <tr>
                    <td style="width: 10px"><b>Uraian</b></td>
                    <td style="width: 1px">:</td>
                    <td>{{$tagihan->Ur_bp}}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <a href="" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modalPajak" data-backdrop="static"><i class="fas fa-plus"></i> Tambah Pajak</a>
            <a href="{{route('tagihanlalu.rincian',$tagihan->id_bp)}}" class="btn btn-info btn-sm mb-2"><i class="fas fa-reply"></i> Kembali</a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="vertical-align: middle; width: 3%;">No</th>
                    <th class="text-center" style="vertical-align: middle">No Tagihan</th>
                    <th class="text-center" style="vertical-align: middle">Uraian</th>
                    <th class="text-center" style="vertical-align: middle">Jenis Pajak</th>
                    <th class="text-center" style="vertical-align: middle">Pajak (Rupiah)</th>
                    <th class="text-center" style="vertical-align: middle; width: 7%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($pajak))
                  @foreach($pajak as $number => $pajak)
                  <tr>
                    <td class="text-center">{{ $loop->iteration}}.</td>                          
                    <td>{{ $pajak->No_bp }}</td>                       
                    <td>{{ $pajak->Ko_tax }}</td>                      
                    <td>{{ $pajak->ur_rk6 }}</td>                      
                    <td class="text-right">{{ number_format($pajak->tax_Rp,2,',','.') }}</td>                 
                    <td>
                      <div class="row justify-content-center" >
                          <button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#editPajak{{$pajak->id_tax}}" title="Edit">
                            <i class="fas fa-edit"></i>
                          </button>

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{$pajak->id_tax}}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{$pajak->id_tax}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data pajak: {{$pajak->Ko_tax}} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{route('tagihanlalu.destroyPajak',$pajak->id_tax)}}" method="post" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
                                </button>
                              </form>
                              <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </td>

                  </tr>

                  <!-- modal edit potong pajak -->
                  <div class="modal fade" id="editPajak{{$pajak->id_tax}}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Potong Pajak Tagihan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- About Me Box -->
                                            <div class="card card-info">

                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <form action="{{route('tagihanlalu.editpotongpajak',$pajak->id_tax)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label for="No_byr">Kode/No/Uraian BP</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="id_bp" value="{{$tagihan->id_bp}}" readonly>
                                                                    <input type="text" class="form-control" name="No_bp" value="{{$tagihan->No_bp}}" readonly>
                                                                    <input type="text" class="form-control" name="Ur_bp" value="{{$tagihan->Ur_bp}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label for="No_byr">Periode/Unit/Ko Bukti</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="Ko_Period" value="{{$tagihan->Ko_Period}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="Ko_unit1" value="{{$tagihan->Ko_unit1}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="Ko_bp" value="{{$tagihan->Ko_bp}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label for="Ko_tax">Uraian</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" name="Ko_tax" placeholder="Uraian Pajak "
                                                                    class="form-control @error('Ko_tax') is-invalid @enderror"
                                                                    value="{{ old('Ko_tax',$pajak->Ko_tax) ?? '' }}" required>
                                                                @error('Ko_tax')
                                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        {{-- modal rekening --}}
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label for="No_byr">Kode Rekening</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" id="Ko_Rkk_edit" name="Ko_Rkk" value="{{$pajak->Ko_Rkk}}"
                                                                        readonly>
                                                                    <span class="input-group-append">
                                                                        <button type="button" class="btn btn-info btn-flat"
                                                                            data-toggle="modal"
                                                                            data-target="#modal_rekening">Cari!</button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Modal rekening --}}
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label for="tax_Rp">Nilai Pajak</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="number" name="tax_Rp" placeholder="Nilai Pajak (Rp) "
                                                                    class="form-control @error('tax_Rp') is-invalid @enderror"
                                                                    value="{{ old('tax_Rp',$pajak->tax_Rp) ?? '' }}" required>
                                                                @error('tax_Rp')
                                                                    <div class="invalid-feedback"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-save"></i> Save
                                                            </button>
                                                            <button class="btn btn-sm btn-success float-right" data-dismiss="modal" id="btnback">
                                                                <i class="far fa-arrow-alt-circle-left"> Back</i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="card-footer">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- modal edit potong pajak -->

                  @endforeach
                  @else
                  <tr>
                    <td class="text-center" colspan="6">Tidak Ada Data</td>
                  </tr>
                  @endif
                </tbody>

              </table>

              <!-- modal tambah potong pajak -->
              <div class="modal fade" id="modalPajak">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Potong Pajak Tagihan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- About Me Box -->
                                        <div class="card card-info">

                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <form action="{{route('tagihanlalu.potongpajak')}}" method="POST">
                                                    @csrf
                                                    <div class="row form-group">
                                                        <div class="col-md-2">
                                                            <label for="No_byr">Kode/No/Uraian BP</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="id_bp" value="{{$tagihan->id_bp}}" readonly>
                                                                <input type="text" class="form-control" name="No_bp" value="{{$tagihan->No_bp}}" readonly>
                                                                <input type="text" class="form-control" name="Ur_bp" value="{{$tagihan->Ur_bp}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-2">
                                                            <label for="No_byr">Periode/Unit/Ko Bukti</label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="Ko_Period" value="{{$tagihan->Ko_Period}}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="Ko_unit1" value="{{$tagihan->Ko_unit1}}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" name="Ko_bp" value="{{$tagihan->Ko_bp}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-md-2">
                                                            <label for="Ko_tax">Uraian</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" name="Ko_tax" placeholder="Uraian Pajak "
                                                                class="form-control @error('Ko_tax') is-invalid @enderror"
                                                                value="{{ old('Ko_tax') ?? '' }}" required>
                                                            @error('Ko_tax')
                                                                <div class="invalid-feedback"> {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- modal rekening --}}
                                                    <div class="row form-group">
                                                        <div class="col-md-2">
                                                            <label for="No_byr">Kode Rekening</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" id="Ko_Rkk" name="Ko_Rkk"
                                                                     required>
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-info btn-flat"
                                                                        data-toggle="modal"
                                                                        data-target="#modal_rekening">Cari!</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Modal rekening --}}
                                                    <div class="row form-group">
                                                        <div class="col-md-2">
                                                            <label for="tax_Rp">Nilai Pajak</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="number" name="tax_Rp" placeholder="Nilai Pajak (Rp) "
                                                                class="form-control @error('tax_Rp') is-invalid @enderror"
                                                                value="{{ old('tax_Rp') ?? '' }}" required>
                                                            @error('tax_Rp')
                                                                <div class="invalid-feedback"> {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-save"></i> Save
                                                        </button>
                                                        <button class="btn btn-sm btn-success float-right" data-dismiss="modal" id="btnback">
                                                            <i class="far fa-arrow-alt-circle-left"> Back</i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="card-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- modal tambah potong pajak -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  
@include('transaksi.belanja.tagihan.utang.pajak.popup.rekening')
@endsection

@section('script')
<script>
  $(function () {
      $(document).on('click', '#pilihrek', function() {
      var kd_r = $(this).data('kd_rek');
      $('#Ko_Rkk').val(kd_r);
      $('#Ko_Rkk_edit').val(kd_r);
      $('#modal_rekening').hide();
  });

  $(document).on('click', '#btnback', function () {
      location.reload();
    });
  })
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