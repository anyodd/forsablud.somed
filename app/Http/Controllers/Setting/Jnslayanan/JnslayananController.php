<?php

namespace App\Http\Controllers\Setting\Jnslayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pfpmed; 

class JnslayananController extends Controller
{
    public function index()
    {
        $pmed = Pfpmed::orderBy('ko_pmed')->get();
        return view('setting.jnslayanan.index', compact('pmed'));
    }

    public function create()
    {
        $max = Pfpmed::all()->max('ko_pmed');

        return view('setting.jnslayanan.create', compact('max'));
    }

    public function store(Request $request)
    {
        $user = getUser('username');

        $rules = [
            "ko_pmed" => "required",
            "ur_pmed" => "required",
        ];

        $messages = [
          "ko_pmed.required" => "Kode Jenis Layanan wajib diisi.",
          "ur_pmed.required" => "Jenis Layanan wajib diisi.",
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

      Pfpmed::create([
          'tb_ulog' => $user,
          'ko_pmed' => $request->ko_pmed,
          'ur_pmed' => $request->ur_pmed,
      ]);

      return redirect()->route("jnslayanan.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($ko_pmed)
  {
    $pmed = Pfpmed::find($ko_pmed);

    return view('setting.jnslayanan.edit', compact('pmed'));
}

public function update(Request $request, $ko_pmed)
{
   $user = getUser('username');

   $pmed = Pfpmed::find($ko_pmed);

   $rules = [
      "ur_pmed" => "required",
  ];

  $messages = [
      "ur_pmed.required" => "Nama Jenis Pelayanan wajib diisi.",
  ];

  $validator = Validator::make($request->all(), $rules, $messages);

  if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
  }

  $pmed->ur_pmed = $request->ur_pmed;
  $pmed->updated_at = now();
  $pmed->save();

  return redirect()->route("jnslayanan.index");
}

public function destroy($ko_pmed)
{
    $pmed = Pfpmed::find($ko_pmed);
    $pmed->delete();

    return redirect()->route("jnslayanan.index");
}
}
