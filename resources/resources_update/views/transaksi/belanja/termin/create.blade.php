@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Tambah Data Termin</h5> 
          </div>

          <div class="card-body px-2 py-2">

            <form action="{{ route('termin.store') }}" method="post" class="form-horizontal">
              @csrf
              @if(session('errors'))
              <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                Something it's wrong:
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <div class="card-body">

                <div class="row form-group">
                  <div class="col-sm-2">
                    <label for="no_kontrak">Nomor Kontrak</label>
                  </div>
                  <div class="col-sm">
                    <div class="input-group input-group-sm-1">
                      <input type="text" class="form-control" id="no_kontrak" name="no_kontrak" value="{{ old('no_kontrak') }}" placeholder="-- pilih nomor kontrak --" readonly>
                      <span class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalCariKontrak">Cari!</button>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="modalCariKontrak">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Cari Kontrak</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="card card-info">
                                <div class="card-body">
                                  <table class="table table-sm table-bordered table-hover mb-0" id="tabelTap" width="100%" cellspacing="0">
                                    <thead>
                                      <tr>
                                        <th>Nomor Kontrak</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Uraian Kontrak</th>
                                        <th>Pihak Lain</th>
                                        <th>Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($kontrak as $item)
                                      <tr>
                                        <td>{{$item->No_contr}}</td>
                                        <td>{{$item->dt_contr}}</td>
                                        <td>{{$item->Ur_contr}}</td>
                                        <td>{{$item->rekan_nm}}</td>
                                        <td>
                                          <button class="btn btn-warning btn-sm py-0" data-dismiss="modal" title="Pilih data" id="select"
                                          data-no_kontrak = "{{ $item->No_contr }}"
                                          data-nm_kontrak = "{{ $item->Ur_contr }}"
                                          data-rekan_nm = "{{ $item->rekan_nm }}"
                                          data-id_rekan = "{{ $item->id_rekan }}"
                                          ><i class="fa fa-choose"> </i>Pilih</button>
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <!-- /.card -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div><!-- /.container-fluid -->
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                {{-- klo include ini, php nya gak kebaca? 

                @include('transaksi.belanja.termin.popup.modal_cari_kontrak')

                --}}


                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nomor Dokumen</label>
                  <div class="col-sm">
                    <input type="text" name="NoBp" class="form-control @error('NoBp') is-invalid @enderror" value="{{old('NoBp')}}" placeholder="Masukan Nomor Dokumen">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Tanggal Dokumen</label>
                  <div class="col-sm">
                    <input type="date" name="DtBp" class="form-control @error('DtBp') is-invalid @enderror" value="{{ date( Tahun().'-m-d') }}" min="{{ Tahun().'-01-01' }}" max="{{ Tahun().'-12-31' }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Uraian</label>
                  <div class="col-sm">
                    <input type="text" id="nm_kontrak" name="UrBp" class="form-control @error('UrBp') is-invalid @enderror" value="{{old('UrBp')}}" placeholder="Keterangan Transaksi">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Nama Pihak Lain</label>
                  <div class="col-sm">
                    <input type="text" id="rekan_nm" name="rekan_nm" class="form-control @error('rekan_nm') is-invalid @enderror" value="{{old('rekan_nm')}}" readonly>
                    <input type="text" id="id_rekan" name="id_rekan" class="form-control @error('id_rekan') is-invalid @enderror" value="{{old('id_rekan')}}" hidden>
                  </div>
                </div>

                <div class="form-group row justify-content-center mt-3">
                  <button type="submit" id="" class="col-sm-2 btn btn-primary ml-3" name="submit">
                    <i class="far fa-save pr-2"></i>Simpan
                  </button>
                  <a href="{{ route('termin.bulan',Session::get('bulan')) }}" class="col-sm-2 btn btn-danger ml-3">
                    <i class="fas fa-backward pr-2"></i>Kembali
                  </a> 
                </div>

              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>  


@endsection

@section('script')  
<script>
  $(function () {
    $('.select2').select2();
  })
</script>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#tabelTap').DataTable({
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function(row) {
              var data = row.data();
              return 'Details for ' + data[0] + ' ' + data[1];
            }
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table'
          })
        }
      }
    });
  });
</script>

<script>
 $(function () {
  $(document).on('click','#select',function() {
    var v1 = $(this).data('no_kontrak');
    var v2 = $(this).data('nm_kontrak')  + ' Termin ke ..';
    var v3 = $(this).data('rekan_nm');
    var v4 = $(this).data('id_rekan');
    $('#no_kontrak').val(v1);
    $('#nm_kontrak').val(v2);
    $('#rekan_nm').val(v3);
    $('#id_rekan').val(v4);
  });
})
</script>
@endsection