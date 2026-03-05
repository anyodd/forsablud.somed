@extends('layouts.template')
@section('style') @endsection

@section('content')

<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">

        <div class="card card-info card-tabs mt-2">
          <div class="card-header p-0 pt-1">

            <ul class="nav nav-tabs" id="rekening" role="tablist">
              <li class="nav-item">
                <a class="nav-link {!! $active1 !!}" id="akun1-tab" data-toggle="pill" href="#akun1" role="tab" aria-controls="akun1" aria-selected="true">Akun 1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {!! $active2 !!}" id="akun2-tab" data-toggle="pill" href="#akun2" role="tab" aria-controls="akun2" aria-selected="false" {{$hide2}}>Akun 2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {!! $active3 !!}" id="akun3-tab" data-toggle="pill" href="#akun3" role="tab" aria-controls="akun3" aria-selected="false" {{$hide3}}>Akun 3</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {!! $active4 !!}" id="akun4-tab" data-toggle="pill" href="#akun4" role="tab" aria-controls="akun4" aria-selected="false" {{$hide4}}>Akun 4</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {!! $active5 !!}" id="akun5-tab" data-toggle="pill" href="#akun5" role="tab" aria-controls="akun5" aria-selected="false" {{$hide5}}>Akun 5</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {!! $active6 !!}" id="akun6-tab" data-toggle="pill" href="#akun6" role="tab" aria-controls="akun6" aria-selected="false" {{$hide6}}>Akun 6</a>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="rekeningContent">

              <div class="tab-pane fade show {!! $active1 !!}" id="akun1" role="tabpanel" aria-labelledby="akun1-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example1" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center">Kode Akun 1</th>
                        <th class="text-center">Uraian Akun 1</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek1->count() > 0)
                      @foreach($rek1 as $number => $rek1)
                      <tr>
                        <td class="text-center" style="width: 15%; vertical-align: middle;">
                          {{ str_pad($rek1->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}
                        </td>                      
                        <td class="py-0">
                          <form action="{{ route('rek') }}" method="get" class="">
                            <button type="submit" class="btn btn-light text-left" name="submit" value="{{ $rek1->Ko_Rk1 }},by,by,by,by,by">
                              {{ $rek1->Ur_Rk1 }}
                            </button>
                          </form>
                        </td>     
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade show {!! $active2 !!}" id="akun2" role="tabpanel" aria-labelledby="akun2-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example2" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center">Kode Akun 2</th>
                        <th class="text-center">Uraian Akun 2</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek2->count() > 0)
                      @foreach($rek2 as $number => $rek2)
                      <tr>
                        <td class="text-center" style="width: 15%; vertical-align: middle;">
                          {{ str_pad($rek2->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek2->Ko_Rk2, 2, '0', STR_PAD_LEFT) }}
                        </td>                       
                        <td class="py-0">
                          <form action="{{ route('rek') }}" method="get" class="">
                            <button type="submit" class="btn btn-light text-left" name="submit" value="{{ $rek2->Ko_Rk1 }},{{ $rek2->Ko_Rk2 }},by,by,by,by">
                              {{ $rek2->Ur_Rk2 }}
                            </button>
                          </form>
                        </td> 
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>

              </div>
              <div class="tab-pane fade show {!! $active3 !!}" id="akun3" role="tabpanel" aria-labelledby="akun3-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example3" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center" style="vertical-align: middle; width: 5%;">Kode Akun 3</th>
                        <th class="text-center" style="vertical-align: middle;">Uraian Akun 3</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek3->count() > 0)
                      @foreach($rek3 as $number => $rek3)
                      <tr>
                        <td class="text-center" style="width: 15%;">
                          {{ str_pad($rek3->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek3->Ko_Rk2, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek3->Ko_Rk3, 2, '0', STR_PAD_LEFT) }}
                        </td>                      
                        <td class="py-0">
                          <form action="{{ route('rek') }}" method="get" class="">
                            <button type="submit" class="btn btn-light text-left" name="submit" value="{{ $rek3->Ko_Rk1 }},{{ $rek3->Ko_Rk2 }},{{ $rek3->Ko_Rk3 }},by,by,by">
                              {{ $rek3->Ur_Rk3 }}
                            </button>
                          </form>
                        </td> 
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td colspan="2">Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade show {!! $active4 !!}" id="akun4" role="tabpanel" aria-labelledby="akun4-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example4" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center" style="vertical-align: middle; width: 5%;">Kode Akun 4</th>
                        <th class="text-center" style="vertical-align: middle;">Uraian Akun 4</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek4->count() > 0)
                      @foreach($rek4 as $number => $rek4)
                      <tr>
                        <td class="text-center" style="width: 15%;">
                          {{ str_pad($rek4->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek4->Ko_Rk2, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek4->Ko_Rk3, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek4->Ko_Rk4, 2, '0', STR_PAD_LEFT) }}
                        </td>                      
                        <td class="py-0">
                          <form action="{{ route('rek') }}" method="get" class="">
                            <button type="submit" class="btn btn-light text-left" name="submit" value="{{ $rek4->Ko_Rk1 }},{{ $rek4->Ko_Rk2 }},{{ $rek4->Ko_Rk3 }},{{ $rek4->Ko_Rk4 }},by,by">
                              {{ $rek4->Ur_Rk4 }}
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade show {!! $active5 !!}" id="akun5" role="tabpanel" aria-labelledby="akun5-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example5" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center">Kode Akun 5</th>
                        <th class="text-center">Uraian Akun 5</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek5->count() > 0)
                      @foreach($rek5 as $number => $rek5)
                      <tr>
                        <td class="text-center" style="width: 15%;">
                          {{ str_pad($rek5->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek5->Ko_Rk2, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek5->Ko_Rk3, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek5->Ko_Rk4, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek5->Ko_Rk5, 3, '0', STR_PAD_LEFT) }}
                        </td>                      
                        <td class="py-0">
                          <form action="{{ route('rek') }}" method="get" class="">
                            <button type="submit" class="btn btn-light text-left" name="submit" value="{{ $rek5->Ko_Rk1 }},{{ $rek5->Ko_Rk2 }},{{ $rek5->Ko_Rk3 }},{{ $rek5->Ko_Rk4 }},{{ $rek5->Ko_Rk5 }},by">
                              {{ $rek5->Ur_Rk5 }}
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade show {!! $active6 !!}" id="akun6" role="tabpanel" aria-labelledby="akun6-tab">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover mb-0" id="example6" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-center" style="vertical-align: middle;">Kode Akun 6</th>
                        <th class="text-center" style="vertical-align: middle;">Uraian Akun 6</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($rek6->count() > 0)
                      @foreach($rek6 as $number => $rek6)
                      <tr>
                        <td class="text-center" style="width: 15%;">
                          {{ str_pad($rek6->Ko_Rk1, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek6->Ko_Rk2, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek6->Ko_Rk3, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek6->Ko_Rk4, 2, '0', STR_PAD_LEFT) }}.{{ str_pad($rek6->Ko_Rk5, 3, '0', STR_PAD_LEFT) }}.{{ str_pad($rek6->Ko_Rk6, 4, '0', STR_PAD_LEFT) }}
                        </td>                      
                        <td>{{ $rek6->Ur_Rk6 }}</td>                      
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td>Tidak Ada Data</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
          <!-- /.card -->
        </div>

      </div>
    </section>  

    @endsection

    @section('script')

    <script>
      $(document).ready(function() {
        $('#example1').DataTable( {
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
      $(document).ready(function() {
        $('#example2').DataTable( {
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
      $(document).ready(function() {
        $('#example3').DataTable( {
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
      $(document).ready(function() {
        $('#example4').DataTable( {
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
      $(document).ready(function() {
        $('#example5').DataTable( {
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
      $(document).ready(function() {
        $('#example6').DataTable( {
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