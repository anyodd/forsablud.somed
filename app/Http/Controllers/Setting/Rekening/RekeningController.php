<?php

namespace App\Http\Controllers\Setting\Rekening;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pfrk1; 
use App\Models\Pfrk2; 
use App\Models\Pfrk3; 
use App\Models\Pfrk4; 
use App\Models\Pfrk5; 
use App\Models\Pfrk6; 

class RekeningController extends Controller
{
  public function index()
  {
    $rek1 = Pfrk1::all();
    $rek2 = Pfrk2::where('Ko_Rk1', 'bayu')->get();
    $rek3 = Pfrk3::where('Ko_Rk1', 'bayu')->get();
    $rek4 = Pfrk4::where('Ko_Rk1', 'bayu')->get();
    $rek5 = Pfrk5::where('Ko_Rk1', 'bayu')->get();
    $rek6 = Pfrk6::where('Ko_Rk1', 'bayu')->get();

    $active1 = "active";
    $active2 = "";
    $active3 = "";
    $active4 = "";
    $active5 = "";
    $active6 = "";
    $hide2 = "hidden";
    $hide3 = "hidden";
    $hide4 = "hidden";
    $hide5 = "hidden";
    $hide6 = "hidden";

    return view('setting.rekening.index', compact('rek1', 'rek2', 'rek3', 'rek4', 'rek5', 'rek6', 'active1', 'active2', 'active3', 'active4', 'active5', 'active6', 'hide2', 'hide3', 'hide4', 'hide5', 'hide6'));
  }

  public function rek(Request $request)
  {
    $result = explode(',', $request->submit);
    // dd($result[0], $result[1], $result[2], $result[3], $result[4], $result[5]);

    $Ko_Rk1 = $result[0];
    $Ko_Rk2 = $result[1];
    $Ko_Rk3 = $result[2];
    $Ko_Rk4 = $result[3];
    $Ko_Rk5 = $result[4];
    $Ko_Rk6 = $result[5];

    if ($Ko_Rk1 != "by" && $Ko_Rk2 == "by" ) {
      $active1 = "";
      $active2 = "active";
      $active3 = "";
      $active4 = "";
      $active5 = "";
      $active6 = "";
      $hide2 = "";
      $hide3 = "hidden";
      $hide4 = "hidden";
      $hide5 = "hidden";
      $hide6 = "hidden";
    } elseif ($Ko_Rk1 != "by" && $Ko_Rk2 !="by" && $Ko_Rk3 == "by" ) {
      $active1 = "";
      $active2 = "";
      $active3 = "active";
      $active4 = "";
      $active5 = "";
      $active6 = "";
      $hide2 = "";
      $hide3 = "";
      $hide4 = "hidden";
      $hide5 = "hidden";
      $hide6 = "hidden";
    } elseif ($Ko_Rk1 != "by" && $Ko_Rk2 !="by" && $Ko_Rk3 != "by" && $Ko_Rk4 == "by") {
      $active1 = "";
      $active2 = "";
      $active3 = "";
      $active4 = "active";
      $active5 = "";
      $active6 = "";
      $hide2 = "";
      $hide3 = "";
      $hide4 = "";
      $hide5 = "hidden";
      $hide6 = "hidden";
    } elseif ($Ko_Rk1 != "by" && $Ko_Rk2 !="by" && $Ko_Rk3 != "by" && $Ko_Rk4 != "by" && $Ko_Rk5 == "by") {
      $active1 = "";
      $active2 = "";
      $active3 = "";
      $active4 = "";
      $active5 = "active";
      $active6 = "";
      $hide2 = "";
      $hide3 = "";
      $hide4 = "";
      $hide5 = "";
      $hide6 = "hidden";
    } elseif ($Ko_Rk1 != "by" && $Ko_Rk2 !="by" && $Ko_Rk3 != "by" && $Ko_Rk4 != "by" && $Ko_Rk5 != "by" && $Ko_Rk6 == "by") {
      $active1 = "";
      $active2 = "";
      $active3 = "";
      $active4 = "";
      $active5 = "";
      $active6 = "active";
      $hide2 = "";
      $hide3 = "";
      $hide4 = "";
      $hide5 = "";
      $hide6 = "";
    }

    $rek1 = Pfrk1::all();
    $rek2 = Pfrk2::where('Ko_Rk1', $Ko_Rk1)->get();
    $rek3 = Pfrk3::where([ 'Ko_Rk1'=>$Ko_Rk1, 'Ko_Rk2'=>$Ko_Rk2 ])->get();
    $rek4 = Pfrk4::where([ 'Ko_Rk1'=>$Ko_Rk1, 'Ko_Rk2'=>$Ko_Rk2, 'Ko_Rk3'=>$Ko_Rk3 ])->get();
    $rek5 = Pfrk5::where([ 'Ko_Rk1'=>$Ko_Rk1, 'Ko_Rk2'=>$Ko_Rk2, 'Ko_Rk3'=>$Ko_Rk3, 'Ko_Rk4'=>$Ko_Rk4 ])->get();
    $rek6 = Pfrk6::where([ 'Ko_Rk1'=>$Ko_Rk1, 'Ko_Rk2'=>$Ko_Rk2, 'Ko_Rk3'=>$Ko_Rk3,  'Ko_Rk4'=>$Ko_Rk4, 'Ko_Rk5'=>$Ko_Rk5 ])->get();

    return view('setting.rekening.index', compact('rek1', 'rek2', 'rek3', 'rek4', 'rek5', 'rek6', 'hide2', 'hide3', 'hide4', 'hide5', 'hide6', 'active1', 'active2', 'active3', 'active4', 'active5', 'active6'));
  }

  public function rekening1(Request $request)
  {
    // $cities = City::where('province_id', $request->get('id'))->pluck('name', 'id');
    // return response()->json($cities);
  }

  public function rekening2(Request $request)
  {
    $rk_2 = Pfrk2::where('Ko_Rk1', $request->get('id'))->pluck('id','Ur_Rk2');
    return response()->json($rk_2);
  }

  public function rekening3(Request $request)
  {

  }

  public function rekening4(Request $request)
  {

  }

  public function rekening5(Request $request)
  {

  }

  public function rekening6(Request $request)
  {

  }
}
