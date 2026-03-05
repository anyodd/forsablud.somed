<?php

namespace App\Http\Controllers\Transaksi\Belanja\Kuitansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Tbbyr; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap;
use App\Models\Tbtax;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use PhpParser\Node\Stmt\TryCatch;
use RealRashid\SweetAlert\Facades\Alert;

class SubKuitansiController extends Controller
{
  public function index()
  {
    $kuitansi = Tbbprc::all();
    return view('transaksi.belanja.subkuitansi.index', compact('kuitansi'));
  }

  public function rincian($id_bp)
  {
    $sumber  = Pfjnpdp::all();
    $sumber2 = Pfjnpdpr::all();
    $idbp    = $id_bp;
    $rincian = DB::select(DB::raw('SELECT a.* FROM tb_bprc a
               INNER JOIN tb_bprc b ON a.id_bprc = b.id_bprc
               WHERE a.id_bp = "'.$id_bp.'"'));
    $rkk6 = DB::select(DB::raw("SELECT CONCAT(
      LPAD(Ko_Rk1,2,0),'.' ,
      LPAD(Ko_Rk2,2,0),'.' ,
      LPAD(Ko_Rk3,2,0),'.' ,
      LPAD(Ko_Rk4,2,0),'.' ,
      LPAD(Ko_Rk5,3,0),'.' ,
      LPAD(Ko_Rk6,4,0)
      ) AS RKK6, ur_rk6
      FROM pf_rk6
      WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1'"));
    return view('transaksi.belanja.subkuitansi.rincian', compact( 'rincian','sumber','sumber2','rkk6','idbp'));
  }

  public function create($idbp)
  {
    $data = Tbbp::where('id_bp',$idbp)->first();
    $kounit1 = '14.02.01.02.01.001.001';
    $Ko_Unit = Session::get('ko_unit1');
    $Period = Session::get('Ko_Period');
    $penerimaan = Tbbprc::all();
    $kegiatan = Tbtap::GROUPBY('Ko_Rkk')->get();
    $sumber = Pfjnpdp::all();
    $sumber2 = Pfjnpdpr::all();
    $tahun = 2020;
    $kounit1 = '14.02.01.02.01.001.001';
    $PD = 2;

    $caridata = DB::select('call vdata_btrans('.$tahun.', "'.$kounit1.'",'.$PD.')');
    $datafinal = collect($caridata);
    $max = Tbbprc::where('Ko_Period', '2020')
    ->where('No_bp', $data->No_bp)
    ->where('Ko_Unit1', $data->Ko_unit1)
    ->max('Ko_bprc');

    return view('transaksi.belanja.subkuitansi.create', compact('penerimaan','sumber','sumber2','kegiatan', 'data', 'Ko_Unit', 'Period', 'max' , 'datafinal' ));
  }

  public function tambah($idbp)
  {
    $data = Tbbp::where('id_bp',$idbp)->first();
    $Ko_Unit = kd_bidang();
    $Period = Tahun();
    $penerimaan = Tbbprc::all();
    $kegiatan = Tbtap::GROUPBY('Ko_Rkk')->get();
    $sumber = Pfjnpdp::all();
    $sumber2 = Pfjnpdpr::all();
    $PD = 1;

    $caridata = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",'.$PD.')');
    $datafinal = collect($caridata);
    $max = Tbbprc::where('Ko_Period', Tahun())
    ->where('No_bp', $data->No_bp)
    ->where('Ko_Unit1', $data->Ko_unit1)
    ->max('Ko_bprc');

    return view('transaksi.belanja.subkuitansi.create', compact('penerimaan','sumber','sumber2','kegiatan', 'data', 'Ko_Unit', 'Period', 'max' , 'datafinal' ));
  }

  public function store(Request $request)
  {
    $UrByr = 'Pembayaran '.$request->Ur_bprc;
    $max1 = Tbbyr::where('Ko_Period', Tahun())->max('id_byr');

    $NoByr = $request->No_bp.'-'.$max1;
    if($request->Ko_kas==1){$KoBank='2';}else{$KoBank='0';}

    $rules = [
      "Ko_sKeg1" => "required",
      "Ur_bprc" => "required",
      "rftr_bprc" => "required",
      "To_Rp" => "required",
    ];

    $messages = [
      "Ko_sKeg1.required" => "Data rincian panjar belum dipilih",
      "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
      "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
      "To_Rp.required" => "Nilai (Rp) wajib diisi.",

    ];
    
    $validator = FacadesValidator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $up = DB::select("SELECT a.id FROM tb_spirc a 
          WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.No_bp = '001-Kas' && a.Ko_Rkk = '01.01.01.03.001.0001'");
          
    if (empty($up)) {
      Alert::warning('Gagal', "Data Uang Persediaan (UP) belum ada !!");
      return redirect()->route('subkuitansi.rincian', $request->id_bp);
    } else {
      Tbbprc::create([          
        'id_bp' => $request->id_bp,
        'Ko_Period' => Tahun(),
        'Ko_unit1' => kd_bidang(),      
        'No_bp' => $request->No_bp,
        'Ko_bprc' => $request->Ko_bprc,
        'Ur_bprc' => $request->Ur_bprc,
        'rftr_bprc' => $request->rftr_bprc,
        'dt_rftrbprc' => $request->dt_rftrbprc,
        'No_PD' => $request->No_PD,
        'Ko_sKeg1' => $request->Ko_sKeg1,
        'Ko_sKeg2' => $request->Ko_sKeg2,
        'Ko_Rkk' => $request->Ko_Rkk,
        'Ko_Pdp' => 1,
        'ko_pmed' => 99,
        'To_Rp' => $request->To_Rp,
        'ko_kas' => $request->Ko_kas,
        'tb_ulog' => getUser('username'),
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      $id_bprc = DB::table('tb_bprc')->where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang(),'No_bp' =>$request->No_bp, 'Ko_bprc' => $request->Ko_bprc])->value('id_bprc');    
      
      Tbbyr::create([          
        'id_bprc' => $id_bprc,
        'Ko_Period' => Tahun(),
        'Ko_unitstr' => kd_unit(),
        'No_byr' => $NoByr,      
        'No_bp' => $request->No_bp,
        'Ko_bprc' => $request->Ko_bprc,
        'dt_byr' => $request->dt_bp,
        'Ur_byr' => $UrByr,
        'ko_kas' => $request->Ko_kas,
        'Ko_Bank' => $KoBank,
        'Nm_byr' => $request->nm_input,
        'Tag' => '0',
        'tb_ulog' => getUser('username'),
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      Alert::success('Berhasil', "Data Berhasil Ditambah");
      return redirect()->route('subkuitansi.rincian', $request->id_bp);
    }
  }

  public function show($id)
  {

    $rincian = Tbbprc::where('id',$id)->get();
    return view('transaksi.belanja.subkuitansi.show', compact('rincian'));
  }

  public function edit($id)
  {
    $PD = 1;
    $caridata = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",'.$PD.')');
    $datafinal = collect($caridata);
    $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
    $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
    $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
    $dt_view = collect($caridata)->where('ko_skeg1', $ko_skeg1)->where('ko_skeg2', $ko_skeg2)->where('ko_rkk', $ko_rkk)->first();
    $data = Tbbprc::where('id_bprc',$id)->first();
    return view('transaksi.belanja.subkuitansi.edit', compact('data','datafinal','dt_view'));
  }

  public function update(Request $request, $id)
  {
    $rules = [
      "Ur_bprc" => "required",
      "rftr_bprc" => "required",
      "To_Rp" => "required",
    ];

    $messages = [
      "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
      "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
      "To_Rp.required" => "Nilai (Rp) wajib diisi.",

    ];
    $validator = FacadesValidator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tbbprc::where('id_bprc', $id)->update([      
      'No_bp' => $request->No_bp,
      'Ko_bprc' => $request->Ko_bprc,
      'Ur_bprc' => $request->Ur_bprc,
      'rftr_bprc' => $request->rftr_bprc,
      'dt_rftrbprc' => $request->dt_rftrbprc,
      'No_PD' => $request->No_PD,
      'Ko_sKeg1' => $request->Ko_sKeg1,
      'Ko_sKeg2' => $request->Ko_sKeg2,
      'Ko_Rkk' => $request->Ko_Rkk,
      'To_Rp' => $request->To_Rp,
      'ko_kas' => $request->Ko_kas,
      'updated_at' => now(),
    ]);

    $idbp = Tbbprc::select('id_bp', 'Ko_bprc')->where('id_bprc',$id)->first();

    $id_bp = $idbp->id_bp;
    $Ko_bprc = $idbp->Ko_bprc;

     $UrByr = 'Pembayaran '.$request->Ur_bprc;

    if($request->Ko_kas==1){$KoBank='2';}else{$KoBank='0';}

    // Tbbyr::where([ 'Ko_Period'=>Tahun(), 'Ko_unitstr'=>kd_unit(), 'id_bprc'=>$id_bp, 'Ko_bprc'=>$Ko_bprc ])->update([
    Tbbyr::where('id_bprc',$id)->update([
      'No_bp' => $request->No_bp,
      'Ko_bprc' => $request->Ko_bprc,
      // 'dt_byr' => $request->dt_bp,
      'dt_byr' => $request->dt_rftrbprc,
      'Ur_byr' => $UrByr,
      'ko_kas' => $request->Ko_kas,
      'Ko_Bank' => $KoBank,
      'tb_ulog' => getUser('username'),
      'updated_at' => now(),
    ]);

    $idn = Tbbprc::where('id_bprc', $id)->value('id_bp');
    Alert::success('Berhasil', "Data Rincian berhasil Diubah");
    return redirect()->route('subkuitansi.rincian', $idn);
  }

  public function potongpajak(Request $request)
  {
    $request->validate([
      'id_bp'          => 'required',
      'Ko_Period'      => 'required',
      'Ko_unit1'       => 'required',
      'No_bp'          => 'required',
      'Ko_tax'         => 'required',
      'Ko_Rkk'         => 'required',
      'tax_Rp'         => 'required',
    ]);

    try {
      Tbtax::Create([
        'id_bp' => $request->id_bp,
        'Ko_Period' => Tahun(),
        'Ko_unit1' => kd_bidang(),
        'No_bp' => $request->No_bp,
        'Ko_tax' => $request->Ko_tax,
        'Ko_Rkk' => $request->Ko_Rkk,
        'tax_Rp' => $request->tax_Rp,
        'Tag' => 0,
        'tb_ulog' => 'admin',
      ]);
    } catch (\Illuminate\Database\QueryException $e) {
        $e->getMessage();
    }
    Alert::success('Berhasil', "Pajak $request->Ko_Rkk berhasil ditambah");
    return back();
  }

  public function destroy($id)
  {
    $idbp = Tbbprc::select('id_bp', 'Ko_bprc')->where('id_bprc',$id)->first();

    $id_bp = $idbp->id_bp;
    $Ko_bprc = $idbp->Ko_bprc;
    $bprc = DB::select(DB::raw("SELECT b.* FROM tb_bprc a 
      JOIN tb_spirc b
      ON a.No_bp = b.No_bp = a.Ko_Period = b.Ko_Period && LEFT(a.Ko_unit1,18) = b.Ko_unitstr
      WHERE a.id_bprc ='".$id."'"));  

    if(empty($bprc)){
      Tbbprc::where('id_bprc',$id)->delete();
      Tbbyr::where('id_bprc',$id)->delete();
      Alert::success('Berhasil', "Data Rincian Belanja berhasil Dihapus");

      return redirect()->route('subkuitansi.rincian', $idbp->id_bp);
    }else{
      return back()->with('alert','Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data.');
    }
  }

}
