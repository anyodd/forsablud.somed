<?php

namespace App\Http\Controllers\Setting\Pemda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tbpemda; 
use App\Models\Pfwil1; 
use App\Models\Pfwil2;

class PemdaController extends Controller
{
  public function index()
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unit1');
    $Ko_Wil1 = substr($ko_unit1, 0, 2);
    $Ko_Wil2 = substr($ko_unit1, 3, 2);
    
    $pemda = Tbpemda::where([ 'Ko_Period'=>$Ko_Period, 'Ko_Wil1'=>$Ko_Wil1, 'Ko_Wil2' => $Ko_Wil2 ])->get();
    
    return view('setting.pemda.index', compact('pemda', 'Ko_Period'));
  }

  public function create()
  {
    $Ko_Period = Session::get('Ko_Period');
    $user = getUser('username');
    $pemda = Tbpemda::all();
    $prov = Pfwil1::orderBy('Ko_Wil1')->get();
    $kabkota = Pfwil2::orderBy('Ko_Wil1')->orderBy('Ko_Wil2')->get();

    // belum ada filter jika Ko_Wil1 dan 2 sudah ada

    return view('setting.pemda.create', compact('Ko_Period', 'pemda', 'prov', 'kabkota' ));
  }

  public function store(Request $request)
  {
    $Ko_Period = Session::get('Ko_Period');
    $user = getUser('username');

    // belum ada validasi jika duplikasi

    $rules = [
      "Ko_Wil1" => "required",
      "Ko_Wil2" => "required",
      "Ur_Pemda" => "required",
      "Ibukota" => "required",
      "Ur_Kpl" => "required",
      "Ur_Sekda" => "required",
      "Ur_PPKD" => "required",
      "Ur_BUD" => "required",
    ];

    $messages = [
      "Ko_Wil1.required" => "Provinsi wajib diisi.",
      "Ko_Wil2.required" => "Kabupaten/Kota wajib diisi.",
      "Ur_Pemda.required" => "Nama Pemerintah Daerah wajib diisi.",
      "Ibukota.required" => "Nama Ibukota Kabupaten/Kota wajib diisi.",
      "Ur_Kpl.required" => "Nama Kepala Daerah wajib diisi.",
      "Ur_Sekda.required" => "Nama Sekretaris Daerah wajib diisi.",
      "Ur_PPKD.required" => "Nama PPKD wajib diisi.",
      "Ur_BUD.required" => "Nama BUD wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tbpemda::create([
      'Ko_Period' => $Ko_Period,
      'tb_ulog' => $user,
      'Ko_Wil1' => $request->Ko_Wil1,
      'Ko_Wil2' => $request->Ko_Wil2,
      'Ur_Pemda' => $request->Ur_Pemda,
      'Ibukota' => $request->Ibukota,
      'Ur_Kpl' => $request->Ur_Kpl,
      'Ur_Sekda' => $request->Ur_Sekda,
      'Ur_PPKD' => $request->Ur_PPKD,
      'Ur_BUD' => $request->Ur_BUD,
    ]);

    return redirect()->route("pemda.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $pemda = DB::select(DB::raw('select a.*, b.Ur_Wil2, c.Ur_Wil1 from tb_pemda a 
      left join pf_wil2 b on a.Ko_Wil1 = b.Ko_Wil1 and a.Ko_Wil2 = b.Ko_Wil2 
      left join pf_wil1 c on a.Ko_Wil1 = c.Ko_Wil1
      where a.id = '.$id));

    // dd($pemda);

    return view('setting.pemda.edit', compact('pemda'));
  }

  public function update(Request $request, $id)
  {
    $user = getUser('username');

    $pemda = Tbpemda::find($id);

    $rules = [
      "Ur_Pemda" => "required",
      "Ibukota" => "required",
      "Ur_Kpl" => "required",
      "Ur_Sekda" => "required",
      "Ur_PPKD" => "required",
      "Ur_BUD" => "required",
    ];

    $messages = [
      "Ur_Pemda.required" => "Nama Pemerintah Daerah wajib diisi.",
      "Ibukota.required" => "Nama Ibukota Kabupaten/Kota wajib diisi.",
      "Ur_Kpl.required" => "Nama Kepala Daerah wajib diisi.",
      "Ur_Sekda.required" => "Nama Sekretaris Daerah wajib diisi.",
      "Ur_PPKD.required" => "Nama PPKD wajib diisi.",
      "Ur_BUD.required" => "Nama BUD wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $pemda->Ur_Pemda = $request->Ur_Pemda;
    $pemda->Ibukota = $request->Ibukota;
    $pemda->Ur_Kpl = $request->Ur_Kpl;
    $pemda->Ur_Sekda = $request->Ur_Sekda;
    $pemda->Ur_PPKD = $request->Ur_PPKD;
    $pemda->Ur_BUD = $request->Ur_BUD;
    $pemda->tb_ulog = $user;
    $pemda->updated_at = now();
    $pemda->save();

    return redirect()->route("pemda.index");
  }

  public function destroy($id)
  {
    $pemda = Tbpemda::find($id);
    $pemda->delete();

    return redirect()->route("pemda.index");
  }

  public function GetKabkotaList(Request $request)
  {
    $pfwil2 = Pfwil2::where("Ko_Wil1", $request->Ko_Wil1)->orderBy('Ko_Wil2')->get();

    return response()->json($pfwil2);
  }



}
