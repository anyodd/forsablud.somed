<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Tb_keg;
use App\Models\Tb_keg1;
use App\Models\Tb_keg2;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dt = Tb_keg::where(['Ko_sKeg1' => '01.2.10.001','Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang()])->orderBy('Ko_sKeg1')->get();
        // $dt2 = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang()])->where('Ko_sKeg1', '!=', '01.2.10.001')->orderBy('Ko_sKeg1')->get();

        $dt = Tb_keg::where(['ko_dana' => '2','Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang()])->orderBy('Ko_sKeg1')->get();
        $dt2 = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang()])->where('ko_dana', '=', '1')->orderBy('Ko_sKeg1')->get();

        return view('perencanaan.index',compact('dt','dt2'));
    }

    public function program($id)
    {
        $map = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id])->first();
        $dt  = Tb_keg1::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id])->get();
        
        // if ($dt->isEmpty()) {
        //     Alert::warning('Data Tidak Ditemukan', "Silahkan Cek di Menu Setting");
        //     return back();
        // }else{
            return view('perencanaan.program',compact('dt','map'));
        // }
        
    }

    public function subkegiatan($id1,$id2)
    {   
        $map  = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1])->first();
        $map2 = Tb_keg1::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_KegBL1' => $id2])->first();
        $dt   = Tb_keg2::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_KegBL1' => $id2])->get();
       
        return view('perencanaan.subkegiatan',compact('dt','map','map2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
