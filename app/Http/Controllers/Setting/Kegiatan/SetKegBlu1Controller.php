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
use App\Models\Tbsub1; 
use RealRashid\SweetAlert\Facades\Alert;

class SetKegBlu1Controller extends Controller
{
  public function index(Request $request)
  {
    $Ko_Period = Tahun();
    // $ko_unit1 = getUser('ko_unit1');
    $ko_unit1 = $request->ko_unit1;
    $nm_bidang = Tbsub1::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>$ko_unit1 ])->value('ur_subunit1');
    $Ko_sKeg1 = $request->Ko_sKeg1;
    $Ur_sKeg = $request->Ur_sKeg;

    $data = DB::select(DB::raw("SELECT a.*, b.Ko_KegBL2 FROM tb_kegs1 a 
                                LEFT JOIN (SELECT Ko_sKeg1, Ko_KegBL1, MIN(Ko_KegBL2) AS Ko_KegBL2 FROM tb_kegs2 
                                            WHERE Ko_Period = ".Tahun()." AND ko_unit1 = '".$ko_unit1."' AND Ko_sKeg1 = '".$Ko_sKeg1."' 
                                            GROUP BY Ko_sKeg1, Ko_KegBL1) AS b 
                                ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_KegBL1 = b.Ko_KegBL1
                                WHERE a.Ko_Period = ".Tahun()." AND a.ko_unit1 = '".$ko_unit1."' AND a.Ko_sKeg1 = '".$Ko_sKeg1."'"));
    $kegs1 = collect($data);

    $max = Tb_keg1::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>$ko_unit1, 'Ko_sKeg1'=>$request->Ko_sKeg1 ])->max('Ko_KegBL1');

    return view('setting.kegiatan.kegs1.index', compact('kegs1', 'Ko_Period', 'Ko_sKeg1', 'Ur_sKeg', 'max', 'ko_unit1', 'nm_bidang'));
  }

  public function create()
  {
        //
  }

  public function store(Request $request)
  {
    // dd($request->all());

    Tb_keg1::create([
      'Ko_Period' => Tahun(),
      'ko_unit1' => $request->ko_unit1,
      'Ko_sKeg1' => $request->Ko_sKeg1,
      'Ko_KegBL1' => $request->Ko_KegBL1,
      'Ur_KegBL1' => $request->Ur_KegBL1,
      'tb_ulog' => getUser('username'),
    ]);
    Alert::success('Berhasil !!!', 'Data Program BLUD Nomor ' . $request->Ko_KegBL1 . ' berhasil dibuat');

    return redirect()->route("setkegs1.index", ['Ko_sKeg1'=>$request->Ko_sKeg1, 'Ur_sKeg'=>$request->Ur_sKeg, 'ko_unit1'=>$request->ko_unit1]);
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
    $user = getUser('username');

    $kegs1 = Tb_keg1::find($id);
    $Ko_sKeg1 = $kegs1->Ko_sKeg1;

    $rules = [
      "Ur_KegBL1" => "required",
    ];

    $messages = [
      "Ur_KegBL1.required" => "Program BLUD wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $kegs1->Ur_KegBL1 = $request->Ur_KegBL1;
    $kegs1->tb_ulog = $user;
    $kegs1->updated_at = now();
    $kegs1->save();

    Alert::success('Berhasil !!!', 'Data Program BLUD Nomor '. $kegs1->Ko_KegBL1 . ' berhasil dirubah');

    return redirect()->route("setkegs1.index", [ 'Ko_sKeg1'=>$Ko_sKeg1 ]);
  }

  public function destroy($id)
  {
    $kegs1 = Tb_keg1::find($id);
    $Ko_sKeg1 = $kegs1->Ko_sKeg1;

    $kegs1->delete();

    return redirect()->route("setkegs1.index", [ 'Ko_sKeg1'=>$Ko_sKeg1 ]);
  }
}
