<?php

namespace App\Http\Controllers\Setting\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tbsub;
use App\Models\Tbunit;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class UnitSubController extends Controller
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

    // dd($Ko_Wil1, $Ko_Wil2, $Ko_Urus, $Ko_Bid, $Ko_Unit);

    $user = getUser('username');

    $unitsub1 = DB::select(DB::raw('SELECT a.*, COUNT(b.Ko_Sub1) AS jumkosub1 FROM tb_sub a 
      LEFT JOIN tb_sub1 b ON a.Ko_Wil1 = b.Ko_Wil1 AND a.Ko_Wil2 = b.Ko_Wil2 AND a.Ko_Unit = b.Ko_Unit AND a.Ko_Sub = b.Ko_Sub
      WHERE a.Ko_Period = '.$Ko_Period.' AND a.Ko_Wil1 = '.$Ko_Wil1.' AND a.Ko_Wil2 = '.$Ko_Wil2.' AND a.Ko_Unit = '.$Ko_Unit.' and a.Ko_Sub = '.$Ko_Sub.' AND a.Ko_Urus = '.$Ko_Urus.' AND a.Ko_Bid = '.$Ko_Bid.'
      GROUP BY a.Ko_Wil1, a.Ko_Wil2, a.Ko_Urus, a.Ko_Bid, a.Ko_Unit, a.Ko_Sub' ));

    $unitsub = collect($unitsub1);

    return view('setting.unitsub.index', compact('unitsub', 'Ko_Period'));
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
    $user = getUser('username');

    // $maxkosub = DB::select(DB::raw('SELECT MAX(Ko_Sub) FROM tb_sub WHERE Ko_Wil1 = 14 AND Ko_Wil2 = 3 AND Ko_Unit = 1'));

    // dd($maxkosub);

    $bayu = Tbsub::where([ 'Ko_Wil1'=>$Ko_Wil1, 'Ko_Wil2'=>$Ko_Wil2, 'Ko_Unit'=>$Ko_Unit ])->get();
    $max = $bayu->max('Ko_Sub');

    return view('setting.unitsub.create', compact('Ko_Period', 'max'));
  }

  public function store(Request $request)
  {
    $Ko_Period = Tahun();
    $ko_unit1 = getUser('ko_unitstr');
    $Ko_Wil1 = intval(substr($ko_unit1, 0, 2));
    $Ko_Wil2 = intval(substr($ko_unit1, 3, 2));
    $Ko_Urus = intval(substr($ko_unit1, 6, 2));
    $Ko_Bid = intval(substr($ko_unit1, 9, 2));
    $Ko_Unit = intval(substr($ko_unit1, 12, 2));
    $user = getUser('username');

    // belum ada validasi jika duplikasi

    $rules = [
      "Ko_Sub" => "required",
      "ur_subunit" => "required",
      "Nm_Jln" => "required",
      "Nm_Pimp" => "required",
      "NIP_Pimp" => "required",
      "Nm_Keu" => "required",
      "NIP_Keu" => "required",
      "Nm_Bend" => "required",
      "NIP_Bend" => "required",
      "apbd" => "required",
    ];

    $messages = [
      "Ko_Sub.required" => "Kode BLUD wajib diisi.",
      "ur_subunit.required" => "Nama BLUD wajib diisi.",
      "Nm_Jln.required" => "Alamat BLUD wajib diisi.",
      "Nm_Pimp.required" => "Nama Kepala BLUD wajib diisi.",
      "NIP_Pimp.required" => "NIP Kepala BLUD wajib diisi.",
      "Nm_Keu.required" => "Nama Kabag Keuangan BLUD wajib diisi.",
      "NIP_Keu.required" => "NIP Kabag Keuangan BLUD wajib diisi.",
      "Nm_Bend.required" => "Nama Bendahara BLUD wajib diisi.",
      "NIP_Bend.required" => "NIP Bendahara BLUD wajib diisi.",
      "apbd.required" => "Setting APBD dimunculkan atau tidak wajib diisi.",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    Tbsub::create([
      'Ko_Period' => $Ko_Period,
      'Ko_Wil1' => $Ko_Wil1,
      'Ko_Wil2' => $Ko_Wil2,
      'Ko_Urus' => $Ko_Urus,
      'Ko_Bid' => $Ko_Bid,
      'Ko_Unit' => $Ko_Unit,
      'Ko_Sub' => $request->Ko_Sub,
      'ur_subunit' => $request->ur_subunit,
      'Nm_Jln' => $request->Nm_Jln,
      'Nm_Pimp' => $request->Nm_Pimp,
      'NIP_Pimp' => $request->NIP_Pimp,
      'Nm_Keu' => $request->Nm_Keu,
      'NIP_Keu' => $request->NIP_Keu,
      'Nm_Bend' => $request->Nm_Bend,
      'NIP_Bend' => $request->NIP_Bend,
      'set_PD' => $request->set_PD,
      'apbd' => $request->apbd,
      'tb_ulog' => $user,
    ]);

    return redirect()->route("unitsub.index");
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $unitsub = Tbsub::find($id);

    return view('setting.unitsub.edit', compact('unitsub'));
  }

  public function update(Request $request, $id)
  {
    $user = getUser('username');
    $unitsub = Tbsub::find($id);

    $rules = [
      "ur_subunit" => "required",
      "Nm_Jln"     => "required",
      "Nm_Pimp"    => "required",
      "NIP_Pimp"   => "required",
      "Nm_Keu"     => "required",
      "NIP_Keu"    => "required",
      "Nm_Bend"    => "required",
      "NIP_Bend"   => "required",
      "apbd"       => "required",
      "img_pemda"  => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
      "img_blud"   => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
    ];

    $messages = [
      "ur_subunit.required" => "Nama BLUD wajib diisi.",
      "Nm_Jln.required"     => "Alamat BLUD wajib diisi.",
      "Nm_Pimp.required"    => "Nama Kepala BLUD wajib diisi.",
      "NIP_Pimp.required"   => "NIP Kepala BLUD wajib diisi.",
      "Nm_Keu.required"     => "Nama Kabag Keuangan BLUD wajib diisi.",
      "NIP_Keu.required"    => "NIP Kabag Keuangan BLUD wajib diisi.",
      "Nm_Bend.required"    => "Nama Bendahara BLUD wajib diisi.",
      "NIP_Bend.required"   => "NIP Bendahara BLUD wajib diisi.",
      "apbd.required"       => "Setting APBD dimunculkan atau tidak wajib diisi.",
      "img_pemda.required"  => "File gambar jpeg,png,jpg,gif,svg dan maksimal 2 mb",
      "img_blud.required"   => "File gambar jpeg,png,jpg,gif,svg dan maksimal 2 mb",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $unit = Str::replace('.','',kd_unit());

    if (!empty($request->img_pemda)) {
      $pemda = $unit.'.'.$request->img_pemda->extension(); 
      $request->img_pemda->move(public_path('logo/pemda'), $pemda);
    }
     
    if (!empty($request->img_blud)) {
      $blud  = $unit.'.'.$request->img_blud->extension();  
      $request->img_blud->move(public_path('logo/blud'), $blud);
    }

    if (!empty($pemda)) {
      $unitsub->logo_pemda = $pemda;
    }
    
    if (!empty($blud)) {
      $unitsub->logo_blud  = $blud;
    }

    $unitsub->ur_subunit = $request->ur_subunit;
    $unitsub->Nm_Jln     = $request->Nm_Jln;
    $unitsub->Nm_Pimp    = $request->Nm_Pimp;
    $unitsub->NIP_Pimp   = $request->NIP_Pimp;
    $unitsub->Nm_Keu     = $request->Nm_Keu;
    $unitsub->NIP_Keu    = $request->NIP_Keu;
    $unitsub->Nm_Bend    = $request->Nm_Bend;
    $unitsub->NIP_Bend   = $request->NIP_Bend;
    $unitsub->set_PD     = $request->set_PD;
    $unitsub->APBD       = $request->apbd;
    $unitsub->tb_ulog    = $user;
    $unitsub->updated_at = now();
    $unitsub->save();

    Alert::success('Berhasil', "Data berhasil diupdate");
    return redirect()->route("unitsub.index");
  }

  public function delpemda($id)
  {
    $unit = Tbsub::find($id);
    $file = public_path('logo/pemda/').$unit->logo_pemda; 
    unlink($file);
    $unit->logo_pemda = null;
    $unit->tb_ulog    = getUser('username');
    $unit->updated_at = now();
    $unit->save();

    Alert::success('Berhasil', "Logo PEMDA berhasil dihapus");
    return back();
  }

  public function delblud($id)
  {
    $unit = Tbsub::find($id);
    $file = public_path('logo/blud/').$unit->logo_blud; 
    unlink($file);
    $unit->logo_blud  = null;
    $unit->tb_ulog    = getUser('username');
    $unit->updated_at = now();
    $unit->save();

    Alert::success('Berhasil', "Logo BLUD berhasil dihapus");
    return back();
  }

  public function destroy($id)
  {
    $unitsub = Tbsub::find($id);
    $unitsub->delete();

    return redirect()->route("unitsub.index");
  }
}
