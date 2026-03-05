@extends('layouts.template')

@section('content')
<div class="row">
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">Bukti Penerimaan Pendapatan</a>
  <a href="{{ route('stspendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Surat Tanda Setoran</a>
  <a href="{{ route('rppendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Rekapitulasi Penerimaan Pendapatan</a>
  <a href="{{ route('bkupenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Buku Kas Umum Penerimaan</a>
  <a href="{{ route('bkupenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Buku Pembantu</a>
  <a href="{{ route('lpjbendahara') }}" class="col-sm btn btn-info ml-3 py-1">LPJ Bendahara</a>
  <a href="{{ route('otopenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Otorisasi Penerimaan</a>
</div>

<div class="card-body pt-0">
  <div class="container py-2">
    <select id="pilih" class="form-control select2">
      <option selected="selected" disabled>-- Pilih --</option>
      @foreach ($dt as $item)
          <option value="{{$item->id_bp}}">{{$item->No_bp}} - {{$item->ur_bp}}</option>
      @endforeach
    </select>
  </div>
  <div class="container py-4" style="background: white">
      <div class="col-sm-2">
        <a href="javascript:cetak();"><button class="btn btn-primary" id="cetak"><i class="fas fa-print"></i> Cetak</button></a>
          </a>
      </div>
  
        <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
        <h4 class="my-0" style="text-align: center"><b>BUKTI PENERIMAAN PENDAPATAN</b></h4>
        <br>
          <table class="table table-sm table-bordered" id="a" width="100%" cellspacing="0">
            <tbody>
              <tr>
                <td style="vertical-align: middle;" colspan="7" id="nomor"> Nomor:</td>
                <td style="vertical-align: middle;" colspan="2" id="tanggal">Tanggal:</td>
              </tr>

              <tr>
                <td colspan="3" style="width: 40%">Jenis Pelayanan
                <br><p id="jenislayanan"></p>
                </td>
                <td colspan="6">Diterima:
                <br><p id="diterima"></p>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;" colspan="2" rowspan="1">Diterima dari</td>
                <td style="text-align: center;vertical-align: middle;width: 3%" colspan="1" rowspan="1"> :</td>
                <td style="vertical-align: middle;" colspan="6" rowspan="1"><p id="diterimadari"></p></td>
              </tr>
              <tr>
              <!-- Baris 4 -->
                <td style="vertical-align: middle;" colspan="2" rowspan="1"> Sejumlah</td>
                <td style="text-align: center;vertical-align: middle;" colspan="1" rowspan="1">:</td>
                <td style="vertical-align: middle;" colspan="6" rowspan="1"><p id="torp">
                <br><p id="terbilang"></p></td>
              </tr>

              <tr>
              <!-- Baris 5 -->
                <td style="vertical-align: middle;" colspan="2" rowspan="1"> Keterangan</td>
                <td style="text-align: center;vertical-align: middle;" colspan="1" rowspan="1">:</td>
                <td style="vertical-align: middle;" colspan="6" rowspan="1"><p id="ket"></p></td>
              </tr>
            </tbody>
          </table><br>
          <table style="width: 100%">
              <tbody>
                  <tr>
                      <td style="text-align: center;width: 50%"> 
                          
                      </td>
                      <td style="text-align: center"> 
                          <strong>{{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }},<br>
                              Bendahara Penerimaan<br>
                              <br><br><br>
                              {{ tb_sub('Nm_Bend') }}<br>
                              NIP. {{ tb_sub('Nm_Bend') }}
                          <br><br><br></strong> 
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>        
    </div>
  </div>
</div>

@endsection

@section('script')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

        })
    </script>
     <script>
      $(function(){
          $('#pilih').select2();
          $('#pilih').change( function(){
              var id = $(this).val();
              $.ajax({
                  type: 'get',
                  url: 'bppendapatan/d_bpp/'+ id,
                  dataType: 'json',
                  success: function(data) {
                      console.log(data);
                      var nomor = data['data']['No_bp'];
                      var tanggal = data['data']['dt_bp'];
                      var jlyn = data['data']['Ur_Pdp'];
                      var dtrm = data['data']['Ur_kas'];
                      var dtrmdr = data['data']['nm_BUcontr'];
                      var torp = 'Rp. '+comma(data['data']['to_rp']);
                      var ket = data['data']['ur_bp'];
                      var tbl = 'Terbilang ('+terbilang(parseFloat(data['data']['to_rp']).toFixed())+')';
                      
                      $('#cetak').val(id);
                      $('#nomor').html('Nomor : ' + nomor);
                      $('#tanggal').html('Tanggal : ' + tanggal);
                      $('#jenislayanan').html(jlyn);
                      $('#diterima').html(dtrm);
                      $('#diterimadari').html(dtrmdr);
                      $('#torp').html(torp);
                      $('#ket').html(ket);
                      $('#terbilang').html(tbl);
                  },
              })
          })
      });

      function cetak() {
          var id =  document.getElementById("cetak").value;
          window.open('bppendapatan/print_bpp/'+id,'_blank');
          
      };

      function comma(val){
      val = parseFloat(val).toFixed();
      val = val.replace(',', '');
      var array = val.split('');
      var index = -3;
      while (array.length + index > 0) {
          array.splice(index, 0, '.');
          // Decrement by 4 since we just added another unit to the array.
          index -= 4;
      }
        return array.join('');
      };   

      function terbilang(bilangan) {
      bilangan    = String(bilangan);
      var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
      var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
      var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

      var panjang_bilangan = bilangan.length;

      if (panjang_bilangan > 15) {
      kaLimat = "Diluar Batas";
      return kaLimat;
      }

      for (i = 1; i <= panjang_bilangan; i++) {
      angka[i] = bilangan.substr(-(i),1);
      }

      i = 1;
      j = 0;
      kaLimat = "";


      while (i <= panjang_bilangan) {

      subkaLimat = "";
      kata1 = "";
      kata2 = "";
      kata3 = "";

      if (angka[i+2] != "0") {
          if (angka[i+2] == "1") {
          kata1 = "Seratus";
          } else {
          kata1 = kata[angka[i+2]] + " Ratus";
          }
      }

      if (angka[i+1] != "0") {
          if (angka[i+1] == "1") {
          if (angka[i] == "0") {
              kata2 = "Sepuluh";
          } else if (angka[i] == "1") {
              kata2 = "Sebelas";
          } else {
              kata2 = kata[angka[i]] + " Belas";
          }
          } else {
          kata2 = kata[angka[i+1]] + " Puluh";
          }
      }

      if (angka[i] != "0") {
          if (angka[i+1] != "1") {
          kata3 = kata[angka[i]];
          }
      }


      if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
          subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
      }


      kaLimat = subkaLimat + kaLimat;
      i = i + 3;
      j = j + 1;

      }

      if ((angka[5] == "0") && (angka[6] == "0")) {
      kaLimat = kaLimat.replace("Satu Ribu","Seribu");
      }

      return kaLimat+"Rupiah";
      }

  </script>
@endsection
