<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tb_keg2;


class RbaController extends Controller
{
  public function index()
  {
    // if (getUser('user_level') == 1) {
    //   $aktivitas = Tb_keg2::where([ 'Ko_Period'=>Tahun() ])->where('ko_unit1', 'like', kd_unit().'%')->orderby('Ko_sKeg1')->orderby('Ko_sKeg2')->get();
    // } else {
    //   $aktivitas = Tb_keg2::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>kd_bidang() ])
    //                 ->orderby('ko_unit1')
    //                 ->orderby('Ko_sKeg1')
    //                 ->orderby('Ko_sKeg2')
    //                 ->get();
    // }

    if (getUser('user_level') == 1) {
      $kd_bidang = "like '".substr(kd_bidang(), 0, 18)."%'";
    } else {
      $kd_bidang = "= '".kd_bidang()."'";
    }
    

    $sql = DB::select(DB::raw("SELECT a.*, b.jumlah FROM tb_kegs2 a 
                                LEFT JOIN 
                                  (SELECT ko_unit1, Ko_sKeg1, Ko_sKeg2, SUM(To_Rp) as jumlah
                                  FROM tb_ang_rc 
                                  WHERE Ko_Period = ".Tahun()." AND ko_unit1 ".$kd_bidang."
                                  GROUP BY Ko_Period, ko_unit1, Ko_sKeg1, Ko_sKeg2) b
                                ON a.ko_unit1 = b.ko_unit1 AND CONCAT(a.Ko_sKeg1,a.Ko_sKeg2)  = CONCAT(b.Ko_sKeg1,b.Ko_sKeg2)
                                WHERE a.ko_unit1 ".$kd_bidang."
                                ORDER BY a.ko_unit1, a.Ko_sKeg1, a.Ko_sKeg2"));
    $aktivitas = collect($sql);

    // dd($aktivitas);

    return view('perencanaan.rba.index', compact('aktivitas'));
  }

  public function create()
  {
        //
  }

  public function store(Request $request)
  {
        //
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
        //
  }

  public function destroy($id)
  {
        //
  }
}
