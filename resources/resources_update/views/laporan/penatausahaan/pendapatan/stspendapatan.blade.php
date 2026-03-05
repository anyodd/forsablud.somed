@extends('layouts.template')

@section('content')
<div class="row">
  <a href="{{ route('bppendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Bukti Penerimaan Pendapatan</a>
  <a href="#" class="col-sm btn btn-info ml-3 py-1 disabled">Surat Tanda Setoran</a>
  <a href="{{ route('rppendapatan') }}" class="col-sm btn btn-info ml-3 py-1">Rekapitulasi Penerimaan Pendapatan</a>
  <a href="{{ route('bkupenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Buku Kas Umum Penerimaan</a>
  <a href="{{ route('bprincian') }}" class="col-sm btn btn-info ml-3 py-1">Buku Pembantu</a>
  <a href="{{ route('lpjbendahara') }}" class="col-sm btn btn-info ml-3 py-1">LPJ Bendahara</a>
  <a href="{{ route('otopenerimaan') }}" class="col-sm btn btn-info ml-3 py-1">Otorisasi Penerimaan</a>
</div>

<div class="card-body pt-0">
  <div class="container py-2">
    <select id="pilih" class="form-control select2">
        <option selected="selected" disabled>-- Pilih --</option>
        @foreach ($dt as $item)
            <option value="{{ $item->id_sts }}">{{ $item->No_sts }} - {{ $item->ur_sts }}</option>
        @endforeach
    </select>
  </div>
  
  <div class="container py-4" style="background: white">
    <div class="col-sm-2">
      <a href="javascript:cetak();"><button class="btn btn-primary" id="cetak"><i class="fas fa-print"></i> Cetak</button></a>
      </a>
    </div>
    <h4 class="my-0" style="text-align: center"><b>{{ nm_unit() }}</b></h4>
    <h4 class="my-0" style="text-align: center"><b>SURAT TANDA SETORAN</b></h4>
    <br>

    <table class="table table-sm table-bordered" width="100%" cellspacing="0">
      <tbody>

        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">Nomor</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 48%" id="nomor"></td>
          <td style="padding-top: 0; padding-bottom: 0; width: 30%" id="tanggal">Tanggal:</td>
        </tr>
        
        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">Bank</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 48%" id="bank"></td>
          <td style="padding-top: 0; padding-bottom: 0; width: 30%"></td>
        </tr>

        <tr>
          <td style="padding-top: 0; padding-bottom: 0; width: 20%">No. Rekening</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 2%">:</td>
          <td style="padding-top: 0; padding-bottom: 0; width: 48%" id="no_rek"></td>
          <td style="padding-top: 0; padding-bottom: 0; width: 30%"></td>
        </tr>

        <tr>
          <td colspan="4"><p id="to_rp1">Harap diterima uang dari Bendahara senilai Rp. </p>
            <p id="terbilang">(................................................................Rupiah)</p>
          </td>
        </tr>

        <tr>
          <td colspan="4">Rincian Penerimaan yang disetorkan adalah:</td>
        </tr>

        
        <tr>
          <td class="text-center" style="vertical-align: middle;" colspan="1" >Kode Rekening</td>
          <td class="text-center" style="vertical-align: middle;" colspan="2" >Uraian</td>
          <td class="text-center" style="vertical-align: middle;" colspan="6" >Nilai</td>
        </tr>

        <tr>
          <td class="text-center" style="vertical-align: middle;" colspan="1" id="ko_rkk"></td>
          <td style="vertical-align: middle;" colspan="2" id="pdp"></td>
          <td class="text-right" style="vertical-align: middle;" colspan="6" id="to_rp2"></td>
        </tr>

        <tr>
          <td class="text-center" style="vertical-align: middle;" colspan="3" >Jumlah</td>
          <td class="text-right" style="vertical-align: middle;" colspan="6" id="to_rp3">Rp.</td>
        </tr>
      
        <tr>
          <td colspan="9" id="byr">Uang tersebut telah diterima oleh Bank pada tanggal
          </td>
        </tr>
        <tr>
          <td style="vertical-align: middle;" colspan="1"  ><br>
              <br><br><br><br></td>
          </td>
          <td style="vertical-align: middle;" colspan="2"  ></td>
          <td class="text-center" style="vertical-align: middle;" colspan="6"  >
              {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}<br>Bendahara Penerimaan,
              <br><br><br>Nama Bendahara<br>NIP.</td>
          </td>
          </tr>
      </tbody>
    </table> 
    
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
                  url: 'stspendapatan/d_stsp/'+ id,
                  dataType: 'json',
                  success: function(data) {
                      console.log(data);
                      var nomor = data['data']['No_sts'];
                      var tanggal = data['data']['dt_sts'];
                      var bank = data['data']['Ur_Bank'];
                      var no_rek = data['data']['No_Rek'];
                      var ko_rkk = data['data']['Ko_rkk'];
                      var pdp = data['data']['Ur_Pdp'];
                      var to_rp = data['data']['to_rp'];
                      var dt_byr = data['data']['dt_byr'];

                      
                      var torp = 'Rp. '+comma(data['data']['to_rp']);
                      var tbl = '('+terbilang(parseFloat(data['data']['to_rp']).toFixed())+')';
                      
                      $('#cetak').val(id);
                      $('#nomor').html(nomor);
                      $('#tanggal').html('Tanggal : ' + tanggal);
                      $('#bank').html(bank);
                      $('#no_rek').html(no_rek);
                      $('#ko_rkk').html(ko_rkk);
                      $('#pdp').html(pdp);
                      $('#to_rp1').html('Harap diterima uang dari Bendahara senilai '+torp);
                      $('#to_rp2').html(torp);
                      $('#to_rp3').html(torp);
                      $('#terbilang').html(tbl);
                      $('#torp').html(torp);
                      $('#terbilang').html(tbl);
                      $('#byr').html('Uang tersebut telah diterima oleh Bank pada tanggal '+dt_byr);
                  },
              })
          })
      });

      function cetak() {
          var id =  document.getElementById("cetak").value;
          window.open('stspendapatan/print_stsp/'+id,'_blank');
          
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