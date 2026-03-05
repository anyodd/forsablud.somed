<?php

namespace App\Http\Controllers\Setting\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tbunit; 
use App\Models\Pfurus; 
use App\Models\Pfbid; 
use App\Models\Pfunit; 

class UnitController extends Controller
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


    $user = getUser('username');

    $unitsub = DB::select(DB::raw('SELECT a.*, COUNT(b.Ko_Sub) AS jumkosub FROM tb_unit a
      LEFT JOIN tb_sub b ON a.Ko_Unit = b.Ko_Unit AND a.Ko_Wil1 = b.Ko_Wil1 AND a.Ko_Wil2 = b.Ko_Wil2
      WHERE a.Ko_Period = '.$Ko_Period.' AND a.Ko_Wil1 = '.$Ko_Wil1.' AND a.Ko_Wil2 = '.$Ko_Wil2.' AND a.Ko_Urus = '.$Ko_Urus.' AND a.Ko_Bid = '.$Ko_Bid.' AND a.Ko_Unit = '.$Ko_Unit.'
      GROUP BY a.Ko_Wil1, a.Ko_Wil2, a.Ko_Urus, a.Ko_Bid, a.Ko_Unit' ));

    $unit = collect($unitsub);

    return view('setting.unit.index', compact('unit', 'Ko_Period'));
  }

  public function create()
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $user = getUser('username');

    $unit = Pfunit::all();

    return view('setting.unit.create', compact('Ko_Period', 'unit'));
  }

  public function store(Request $request)
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $user = getUser('username');

    // belum ada validasi jika duplikasi

    $rules = [
      "Ko_Unit" => "required",
      "Nm_Jln" => "required",
      "Nm_Pimp" => "required",
      "NIP_Pimp" => "required",
      "Nm_Keu" => "required",
      "NIP_Keu" => "required",
      "Nm_Bend" => "required",
      "NIP_Bend" => "required",
    ];

    $messages = [
      "Ko_Unit.required" => "Unit wajib diisi.",
      "Nm_Jln.required" => "Alamat wajib diisi.",
      "Nm_Pimp.required" => "Nama Kepala Unit wajib diisi.",
      "NIP_Pimp.required" => "NIP Kepala Unit wajib diisi.",
      "Nm_Keu.required" => "Nama Kabag Keuangan wajib diisi.",
      "NIP_Keu.required" => "NIP Kabag Keuangan wajib diisi.",
      "Nm_Bend.required" => "Nama Bendahara wajib diisi.",
      "NIP_Bend.required" => "NIP Bendahara wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tbunit::create([
      'Ko_Period' => $Ko_Period,
      'Ko_Wil1' => $Ko_Wil1,
      'Ko_Wil2' => $Ko_Wil2,
      'Ko_Urus' => $Ko_Urus,
      'Ko_Bid' => $Ko_Bid,
      'Ko_Unit' => $request->Ko_Unit,
      'Nm_Jln' => $request->Nm_Jln,
      'Nm_Pimp' => $request->Nm_Pimp,
      'NIP_Pimp' => $request->NIP_Pimp,
      'Nm_Keu' => $request->Nm_Keu,
      'NIP_Keu' => $request->NIP_Keu,
      'Nm_Bend' => $request->Nm_Bend,
      'NIP_Bend' => $request->NIP_Bend,
      'Ur_Unit' => "-",
      'tb_ulog' => $user,
    ]);

    return redirect()->route("unit.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $tbunit = Tbunit::find($id);
    $unit = Pfunit::all();

    return view('setting.unit.edit', compact('tbunit', 'unit'));
  }

  public function update(Request $request, $id)
  {
    $user = getUser('username');

    $unit = Tbunit::find($id);

    $rules = [
      // "Ko_Unit" => "required",
      "Nm_Jln" => "required",
      "Nm_Pimp" => "required",
      "NIP_Pimp" => "required",
      "Nm_Keu" => "required",
      "NIP_Keu" => "required",
      "Nm_Bend" => "required",
      "NIP_Bend" => "required",
    ];

    $messages = [
      // "Ko_Unit.required" => "Nama Unit wajib diisi.",
      "Nm_Jln.required" => "Alamat wajib diisi.",
      "Nm_Pimp.required" => "Nama Kepala Unit wajib diisi.",
      "NIP_Pimp.required" => "NIP Kepala Unit wajib diisi.",
      "Nm_Keu.required" => "Nama Kabag Keuangan wajib diisi.",
      "NIP_Keu.required" => "NIP Kabag Keuangan wajib diisi.",
      "Nm_Bend.required" => "Nama Bendahara wajib diisi.",
      "NIP_Bend.required" => "NIP Bendahara wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    // $unit->Ko_Unit = $request->Ko_Unit;
    $unit->Nm_Jln = $request->Nm_Jln;
    $unit->Nm_Pimp = $request->Nm_Pimp;
    $unit->NIP_Pimp = $request->NIP_Pimp;
    $unit->Nm_Keu = $request->Nm_Keu;
    $unit->NIP_Keu = $request->NIP_Keu;
    $unit->Nm_Bend = $request->Nm_Bend;
    $unit->NIP_Bend = $request->NIP_Bend;
    $unit->tb_ulog = $user;
    $unit->updated_at = now();
    $unit->save();

    return redirect()->route("unit.index");
  }

  public function destroy($id)
  {
    $unit = Tbunit::find($id);
    $unit->delete();

    return redirect()->route("unit.index");
  }
}
