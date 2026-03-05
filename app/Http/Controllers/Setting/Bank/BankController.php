<?php

namespace App\Http\Controllers\Setting\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pfbank; 

class BankController extends Controller
{
  public function index()
  {
    $blud = DB::select(DB::raw('SELECT a.*, b.Ko_unitstr, b.ur_subunit 
      FROM pf_bank a 
      LEFT JOIN tb_sub b ON a.Ko_unitstr = b.Ko_unitstr
      WHERE a.Ko_unitstr = "'.kd_unit().'"'));

    $bank = Pfbank::where([ 'Ko_unitstr'=>kd_unit() ])->orderBy('Ko_Bank')->get();

    return view('setting.bank.index', compact('bank', 'blud'));
  }

  public function create()
  {
    $ko_unit1 = getUser('ko_unit1');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $Ko_Sub = intval(substr($ko_unit1, 15, 3));

    $blud = DB::select(DB::raw('SELECT a.*, b.Ko_unitstr, b.ur_subunit 
      FROM pf_bank a 
      LEFT JOIN tb_sub b ON a.Ko_unitstr = b.Ko_unitstr
      WHERE a.Ko_unitstr = "'.kd_unit().'"'));

    $max = Pfbank::where([ 'Ko_unitstr'=>kd_unit() ])->max('Ko_Bank');

    return view('setting.bank.create', compact('max', 'blud'));
  }

  public function store(Request $request)
  {
    $ko_unit1 = kd_bidang();
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $Ko_Sub = intval(substr($ko_unit1, 15, 3));

    $rules = [
      "Ko_Bank" => "required",
      "Ur_Bank" => "required",
      "No_Rek" => "required",
      "Tag" => "required",
    ];

    $messages = [
      "Ko_Bank.required" => "Kode Bank wajib diisi.",
      "Ur_Bank.required" => "Nama Bank wajib diisi.",
      "No_Rek.required" => "Nomor Rekening wajib diisi.",
      "Tag.required" => "Status Bank wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Pfbank::create([
      'tb_ulog' => getUser('username'),
      'Ko_Wil1' => $Ko_Wil1,
      'Ko_Wil2' => $Ko_Wil2,
      'Ko_Urus' => $Ko_Urus,
      'Ko_Bid' => $Ko_Bid,
      'Ko_Unit' => $Ko_Unit,
      'Ko_Sub' => $Ko_Sub,
      'Ko_unitstr' => kd_unit(),
      'Ko_Bank' => $request->Ko_Bank,
      'Ur_Bank' => $request->Ur_Bank,
      'No_Rek' => $request->No_Rek,
      'Tag' => $request->Tag,
    ]);

    return redirect()->route("bank.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($Ko_Bank)
  {
    $bank = Pfbank::where([ 'Ko_unitstr'=>kd_unit(), 'Ko_Bank'=>$Ko_Bank ])->first();

    return view('setting.bank.edit', compact('bank'));
  }

  public function update(Request $request, $Ko_Bank)
  {
    $rules = [
      "Ur_Bank" => "required",
      "No_Rek" => "required",
      "Tag" => "required",
    ];

    $messages = [
      "Ur_Bank.required" => "Nama Bank wajib diisi.",
      "No_Rek.required" => "Nomor Rekening wajib diisi.",
      "Tag.required" => "Status Bank wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Pfbank::where([ 'Ko_unitstr'=>kd_unit(), 'Ko_Bank'=>$Ko_Bank ])
            ->update([
              'Ur_Bank'=>$request->Ur_Bank,
              'No_Rek'=>$request->No_Rek,
              'Tag'=>$request->Tag,
              'tb_ulog'=>getUser('username'),
              'updated_at'=>now(),
    ]);

    return redirect()->route("bank.index");
  }

  public function destroy($Ko_Bank)
  {
    $bank = Pfbank::where([ 'Ko_unitstr'=>kd_unit(), 'Ko_Bank'=>$Ko_Bank ]);
    $bank->delete();

    return redirect()->route("bank.index");
  }
}
