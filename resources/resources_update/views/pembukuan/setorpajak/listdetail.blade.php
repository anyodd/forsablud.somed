@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          <div class="card-header bg-info py-2">
            <h5 class="card-title font-weight-bold">Rincian Setor Pajak</h5> 
          </div>
          
          <div class="card-body px-2 py-2">
            <button class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#ListPajak"><i class="fas fa-plus-circle"></i> Tambah </button>
            <a href="{{ route('setorpajak.show',$id_taxtor) }}" class="btn btn-info btn-sm mb-2"><i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="table-responsive">
              <table class="table table-sm table-bordered table-hover mb-0" id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
                      <th>Rekanan</th>
                      <th>No. Tagihan</th>
                      <th>Tgl. Tagihan</th>
                      <th>Tagihan</th>
                      <th>Total Tagihan</th>
                      <th>Jenis Pajak</th>
                      <th>Uraian Pajak</th>
                      <th>Pajak (Rp)</th>
                      <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($listdetail))
                  @foreach($listdetail as $item)
                  <tr>
                    <td class="text-center">{{$loop->iteration}}.</td>
                    <td>{{$item->rekan_nm}}</td>
                    <td>{{$item->No_bp}}</td>
                    <td>{{date('d/m/Y',strtotime($item->dt_bp))}}</td>
                    <td>{{$item->Ur_bp}}</td>
                    <td class="text-right">{{number_format($item->t_tag,2,',','.')}}</td>
                    <td>{{$item->ur_rk6}}</td>
                    <td>{{$item->Ko_tax}}</td>
                    <td class="text-right">{{number_format($item->taxtor_Rp,2,',','.')}}</td>                  
                    <td>
                      <div class="row justify-content-center" >

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal{{ $item->id_taxtorc }}" title="Hapus"> 
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="modal fade" id="modal{{ $item->id_taxtorc }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-info">
                              <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h6>Yakin mau hapus data setor pajak: {{ $item->Ur_taxtor }} ?</h6>
                            </div>
                            <div class="modal-footer">
                              <form action="{{ route('setorpajak.destroy_detail', $item->id_taxtorc) }}" method="post" class="">
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
                  @endforeach
                  @else
                  <tr>
                    <td>Tidak Ada Data</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  @endif
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- tambah rincian pajak --}}
    <div class="modal fade" id="ListPajak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title" id="exampleModalLongTitle">Rincian Setor Pajak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{route('setorpajak.store_detail')}}" method="post">
            @csrf
            @method('POST')
          <div class="modal-body">
            <div class="card-body px-2 py-2">
              <table id="datapajak" class="table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Rekanan</th>
                    <th>No. Tagihan</th>
                    <th>Tgl. Tagihan</th>
                    <th>Tagihan</th>
                    <th>Total Tagihan</th>
                    <th>Jenis Pajak</th>
                    <th>Uraian Pajak</th>
                    <th>Pajak (Rp)</th>
                    <th class="center">
                      @if (!empty($rincian))
                        <input type="checkbox" id="checkall">
                      @endif
                    </th>
                  </tr>
                </thead>
                <input type="text" id="id_tax" name="id_tax" hidden>
                <input type="text" id="id_taxtor" name="id_taxtor" value="{{$id_taxtr}}" hidden>
                <tbody>
                  @foreach ($rincian as $item)
                      <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{$item->rekan_nm}}</td>
                        <td>{{$item->No_bp}}</td>
                        <td>{{date('d/m/Y',strtotime($item->dt_bp))}}</td>
                        <td>{{$item->Ur_bp}}</td>
                        <td class="text-right">{{number_format($item->t_tag,2,',','.')}}</td>
                        <td>{{$item->ur_rk6}}</td>
                        <td>{{$item->Ko_tax}}</td>
                        <td class="text-right">{{number_format($item->tax_Rp,2,',','.')}}</td>
                        <td class="text-center"><input class="check" type="checkbox" value="{{$item->idtax}}"></td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger mr-3" name="submit" id="submit" onclick="getData()">Simpan</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    {{-- tambah rincian pajak --}}

  </div>
</section>  

@endsection

@section('script')

<script>
  $(document).ready(function() {
    $('#example').DataTable();
    $('#datapajak').DataTable();

    let ceklist = $('table tbody .check:checked')
    let cek = (ceklist.length < 0)
    $('#submit').prop('disabled',!cek);
  });

  $(document).on('click','#checkall', function () {
        var isChecked = $('#checkall').prop('checked')
        $('.check').prop('checked',isChecked);

        if(isChecked > 0) {
          $('#submit').prop('disabled',false);
        }else{
          $('#submit').prop('disabled',true);
        }
    });

    $(document).on('click','.check', function () {
        let cek = $('table tbody .check:checked')
        if(cek.length > 0) {
          $('#submit').prop('disabled',false);
        }else{
          $('#submit').prop('disabled',true);
        }
    });

    function getData() {
        let dt = $('.check:checked')
        let data = []
        $.each(dt, function (index, elm) { 
             data.push(elm.value)
        });

        $('#id_tax').val(data);
    }

    function cancel() {
        $('#checkall').prop('checked',false);
        $('.check').prop('checked',false);
    }
</script>

@endsection