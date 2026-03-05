<?php

namespace App\Http\Controllers\Setting\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tbsub1; 

class UnitSub1Controller extends Controller
{
    public function index()
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $Ko_Sub = intval(substr($ko_unit1, 15, 3));

    // dd($Ko_Wil1, $Ko_Wil2, $Ko_Urus, $Ko_Bid, $Ko_Unit, $Ko_Sub);

    $unitsub1 = Tbsub1::where([ 'Ko_Period'=>$Ko_Period, 'Ko_Wil1'=>$Ko_Wil1, 'Ko_Wil2'=>$Ko_Wil2, 'Ko_Urus'=>$Ko_Urus, 'Ko_Bid'=>$Ko_Bid, 'Ko_Unit'=>$Ko_Unit, 'Ko_Sub'=>$Ko_Sub ])
    ->get();

    return view('setting.unitsub1.index', compact('unitsub1', 'Ko_Period'));
  }

  public function create()
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $Ko_Sub = intval(substr($ko_unit1, 15, 3));

    $bayu = Tbsub1::where([ 'Ko_Wil1'=>$Ko_Wil1, 'Ko_Wil2'=>$Ko_Wil2, 'Ko_Unit'=>$Ko_Unit, 'Ko_Sub'=>$Ko_Sub ])->get();
    $max = $bayu->max('Ko_Sub1');

    return view('setting.unitsub1.create', compact('Ko_Period', 'max'));
  }

  public function store(Request $request)
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $id_sub = getUser('id_sub');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $Ko_Sub = intval(substr($ko_unit1, 15, 3));
    $user = getUser('username');

    // belum ada validasi jika duplikasi

    $rules = [
      "Ko_Sub1" => "required",
      "ur_subunit1" => "required",
      "Nm_Jln" => "required",
      "Nm_Pimp" => "required",
      "NIP_Pimp" => "required",
      // "Nm_Keu" => "required",
      // "NIP_Keu" => "required",
      "Nm_Bend" => "required",
      "NIP_Bend" => "required",
    ];

    $messages = [
      "Ko_Sub1.required" => "Kode Bidang wajib diisi.",
      "ur_subunit1.required" => "Nama Bidang wajib diisi.",
      "Nm_Jln.required" => "Alamat Bidang wajib diisi.",
      "Nm_Pimp.required" => "Nama Kepala Bidang wajib diisi.",
      "NIP_Pimp.required" => "NIP Kepala Bidang wajib diisi.",
      // "Nm_Keu.required" => "Nama Kabag Keuangan Bidang wajib diisi.",
      // "NIP_Keu.required" => "NIP Kabag Keuangan Bidang wajib diisi.",
      "Nm_Bend.required" => "Nama Bendahara Bidang wajib diisi.",
      "NIP_Bend.required" => "NIP Bendahara Bidang wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $ko_unit10 = collect(DB::select(DB::raw("SELECT CONCAT(LPAD('".$Ko_Wil1."',2,0),'.',LPAD('".$Ko_Wil2."',2,0),'.',LPAD('".$Ko_Urus."',2,0),
        '.',LPAD('".$Ko_Bid."',2,0),'.',LPAD('".$Ko_Unit."',2,0),'.',LPAD('".$Ko_Sub."',3,0),'.',LPAD('".$request->Ko_Sub1."',3,0)) AS ko_unit1")))->first();

    Tbsub1::create([
      'Ko_Period' => $Ko_Period,
      'id_sub' => $id_sub,
      'Ko_Wil1' => $Ko_Wil1,
      'Ko_Wil2' => $Ko_Wil2,
      'Ko_Urus' => $Ko_Urus,
      'Ko_Bid' => $Ko_Bid,
      'Ko_Unit' => $Ko_Unit,
      'Ko_Sub' => $Ko_Sub,
      'Ko_Sub1' => $request->Ko_Sub1,
      'ko_unit1' => $ko_unit10->ko_unit1,
      'ur_subunit1' => $request->ur_subunit1,
      'Nm_Jln' => $request->Nm_Jln,
      'Nm_Pimp' => $request->Nm_Pimp,
      'NIP_Pimp' => $request->NIP_Pimp,
      // 'Nm_Keu' => $request->Nm_Keu,
      // 'NIP_Keu' => $request->NIP_Keu,
      'Nm_Bend' => $request->Nm_Bend,
      'NIP_Bend' => $request->NIP_Bend,
      'tb_ulog' => $user,
    ]);

    return redirect()->route("unitsub1.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $unitsub1 = Tbsub1::find($id);

    return view('setting.unitsub1.edit', compact('unitsub1'));
  }

  public function update(Request $request, $id)
  {
    $user = getUser('username');

    $unitsub1 = Tbsub1::find($id);

    $rules = [
      "ur_subunit1" => "required",
      "Nm_Jln" => "required",
      "Nm_Pimp" => "required",
      "NIP_Pimp" => "required",
      // "Nm_Keu" => "required",
      // "NIP_Keu" => "required",
      "Nm_Bend" => "required",
      "NIP_Bend" => "required",
    ];

    $messages = [
      "ur_subunit1.required" => "Nama Bidang wajib diisi.",
      "Nm_Jln.required" => "Alamat Bidang wajib diisi.",
      "Nm_Pimp.required" => "Nama Kepala Bidang wajib diisi.",
      "NIP_Pimp.required" => "NIP Kepala Bidang wajib diisi.",
      // "Nm_Keu.required" => "Nama Kabag Keuangan Bidang wajib diisi.",
      // "NIP_Keu.required" => "NIP Kabag Keuangan Bidang wajib diisi.",
      "Nm_Bend.required" => "Nama Bendahara Bidang wajib diisi.",
      "NIP_Bend.required" => "NIP Bendahara Bidang wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $unitsub1->ur_subunit1 = $request->ur_subunit1;
    $unitsub1->Nm_Jln = $request->Nm_Jln;
    $unitsub1->Nm_Pimp = $request->Nm_Pimp;
    $unitsub1->NIP_Pimp = $request->NIP_Pimp;
    // $unitsub1->Nm_Keu = $request->Nm_Keu;
    // $unitsub1->NIP_Keu = $request->NIP_Keu;
    $unitsub1->Nm_Bend = $request->Nm_Bend;
    $unitsub1->NIP_Bend = $request->NIP_Bend;
    $unitsub1->tb_ulog = $user;
    $unitsub1->updated_at = now();
    $unitsub1->save();

    return redirect()->route("unitsub1.index");
  }

  public function destroy($id)
  {
    $unitsub1 = Tbsub1::find($id);
    $unitsub1->delete();

    return redirect()->route("unitsub1.index");
  }
}
