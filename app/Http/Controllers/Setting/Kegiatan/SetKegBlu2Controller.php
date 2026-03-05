<?php

namespace App\Http\Controllers\Setting\Kegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tb_keg; 
use App\Models\Tb_keg1; 
use App\Models\Tb_keg2; 
use App\Models\Tbsub1; 
use RealRashid\SweetAlert\Facades\Alert;

class SetKegBlu2Controller extends Controller
{
  public function index(Request $request)
  {
    // dd($request->all());
    $ko_unit1 = $request->ko_unit1;
    $Ko_sKeg1 = $request->Ko_sKeg1;
    $Ur_sKeg = $request->Ur_sKeg;
    $Ko_KegBL1 = $request->Ko_KegBL1;
    $Ur_KegBL1 = $request->Ur_KegBL1;
    $nm_bidang = Tbsub1::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>$ko_unit1 ])->value('ur_subunit1');

    $data = DB::select(DB::raw("SELECT a.*, b.Ko_sKeg2 as Ko_sKeg2_ang FROM tb_kegs2 a 
      LEFT JOIN (SELECT Ko_sKeg2 FROM tb_ang
      WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".$ko_unit1."' AND Ko_sKeg1 = '".$Ko_sKeg1."' 
      GROUP BY Ko_sKeg2) AS b 
      ON a.Ko_sKeg2 = b.Ko_sKeg2
      WHERE a.Ko_Period = ".Tahun()." AND a.ko_unit1 = '".$ko_unit1."' AND a.Ko_sKeg1 = '".$Ko_sKeg1."' AND a.Ko_KegBL1 = '".$Ko_KegBL1."'"));
    $kegs2 = collect($data);

    // return $kegs2;

    $max = Tb_keg2::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>$ko_unit1, 'Ko_sKeg1'=>$Ko_sKeg1, 'Ko_KegBL1'=>$Ko_KegBL1 ])->max('Ko_KegBL2');

    return view('setting.kegiatan.kegs2.index', compact('kegs2', 'Ko_sKeg1', 'Ur_sKeg', 'Ko_KegBL1', 'Ur_KegBL1', 'max', 'ko_unit1', 'nm_bidang'));
  }

  public function create()
  {
        //
  }

  public function store(Request $request)
  {
    // dd($request->all());

    Tb_keg2::create([
      'Ko_Period' => Tahun(),
      'ko_unit1' => $request->ko_unit1,
      'Ko_sKeg1' => $request->Ko_sKeg1,
      'Ko_KegBL1' => $request->Ko_KegBL1,
      'Ko_KegBL2' => $request->Ko_KegBL2,
      'Ur_KegBL2' => $request->Ur_KegBL2,
      'tb_ulog' => getUser('username'),
    ]);
    Alert::success('Yeay!', 'Data Kegiatan BLUD Nomor ' . $request->Ko_KegBL2 . ' berhasil dibuat');

    return redirect()->route("setkegs2.index", [
      'Ko_sKeg1'=>$request->Ko_sKeg1, 
      'Ko_KegBL1'=>$request->Ko_KegBL1, 
      'ko_unit1'=>$request->ko_unit1, 
      'nm_bidang'=>$request->nm_bidang, 
      'Ur_sKeg'=>$request->Ur_sKeg
    ]);
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
        //
  }

  public function update(Request $request, $id)
  {
    $kegs2 = Tb_keg2::find($id);

    $rules = [
      "Ur_KegBL2" => "required",
    ];

    $messages = [
      "Ur_KegBL2.required" => "Kegiatan BLUD wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $kegs2->Ur_KegBL2 = $request->Ur_KegBL2;
    $kegs2->tb_ulog = getUser('username');
    $kegs2->updated_at = now();
    $kegs2->save();

    Alert::success('Yeay!', 'Data Kegiatan BLUD Nomor ' . $kegs2->Ko_KegBL2 . ' berhasil dirubah');

    return redirect()->route("setkegs2.index", ['Ko_sKeg1'=>$request->Ko_sKeg1, 'Ko_KegBL1'=>$request->Ko_KegBL1, 'Ur_sKeg'=>$request->Ur_sKeg, 'Ur_KegBL1'=>$request->Ur_KegBL1]);
  }

  public function destroy($id)
  {
    $kegs2 = Tb_keg2::find($id);
    $Ko_sKeg1 = $kegs2->Ko_sKeg1;
    $Ko_KegBL1 = $kegs2->Ko_KegBL1;

    $kegs2->delete();

    return redirect()->route("setkegs2.index", ['ko_unit1'=>$kegs2->ko_unit1, 'Ko_sKeg1'=>$Ko_sKeg1, 'Ko_KegBL1'=>$Ko_KegBL1]);
  }
}
