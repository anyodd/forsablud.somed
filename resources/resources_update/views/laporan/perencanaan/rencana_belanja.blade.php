@extends('layouts.template')

@section('content')
<div class="row">
<a href="#" class="col-sm-2 btn btn-success ml-3 py-2 ">Rencana Bisnis dan Anggaran Pendapatan</a>
  <a href="#" class="col-sm-2 btn btn-success ml-3 py-1 disabled">Rencana Bisnis dan Anggaran Belanja</a>
  <a href="#" class="col-sm-2 btn btn-success ml-3 py-1">Rencana Bisnis dan Anggaran Pembiayaan</a>
</div>
<br>
<section class="content px-0">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-lg mt-2">
          
          <div class="card-body px-2 py-2">
            
            <div class="table-responsive">
              <table class=" table-bordered " id="example" width="100%" cellspacing="0">
                <thead class="thead-light">
                    
                    <div class="text-center" id="example" style="top:85;left:273">
                    <span id="_17.3" style=" font-family:Times New Roman; font-size:17.3px; color:#000000">PEMERINTAH PROVINSI/KABUPATEN/KOTA </span>
                    </div>  

                    <div class="text-center" id="example" style="top:85;left:273">
                    <span id="_17.3" style=" font-family:Times New Roman; font-size:17.3px; color:#000000">DINAS</span>
                    </div> 
                    <br>
                    <div class="text-center" id="example" style="top:173;left:314">
                    <span id="_17.3" style=" font-family:Times New Roman; font-size:17.3px; color:#000000">RENCANA BISNIS DAN ANGGARAN</span>
                    </div>
                    <div class="text-center" id="example" style="top:173;left:314">
                    <span id="_17.3" style=" font-family:Times New Roman; font-size:17.3px; color:#000000">ANGGARAN PENDAPATAN TAHUN ANGGARAN</span>
                    </div>
<br><br>
                  <tr>
                    <th class="text-center" >No</th>
                    <th class="text-center">Uraian </th>
                    <th class="text-center">Jumlah (Rp)</th>
                  </tr>

                  <tr>
                    <th class="text-center" >1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                  </tr>

                  <tr>
                    <th class="text-center" > </th>
                    <th>Pendapatan
                        <br>
                        Jasa Layanan
                        <br>
                        a. <br>b.<br>c.<br><br>

                        Hibah
                        <br>
                        a. <br>b.<br>c.<br><br>

                       Anggaran Pendapatan Belanja Daerah
                        <br>
                        a. <br>b.<br>c.<br><br>

                        Lain-lain Pendapatan Badan Layanan
                        Umum Daerah yang sah
                        <br>
                        a. <br>b.<br>c.<br><br>
                    </th>
                    <th><br><br>Rp<br>Rp<br>Rp<br>
                        <br><br>Rp<br>Rp<br>Rp<br> 
                        <br><br>Rp<br>Rp<br>Rp<br>  
                        <br><br>Rp<br>Rp<br>Rp<br>
                </th>
                  </tr>

                  <tr>
                    <th></th>
                    <th class="text-center">Jumlah </th>
                    <th>Rp</th>
                  </tr>
                </thead>
                <tbody>

                
                  
                 
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

<script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



@endsection