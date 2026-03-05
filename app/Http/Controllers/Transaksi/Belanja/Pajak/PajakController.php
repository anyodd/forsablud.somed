<?php

namespace App\Http\Controllers\Transaksi\Belanja\Pajak;

use App\Models\Tbtap;
use App\Models\Tbtax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pfbank;
use RealRashid\SweetAlert\Facades\Alert;

class PajakController extends Controller
{
    public function index()
    {
        $pajak = DB::select(DB::raw('SELECT c.id_rekan,a.Ko_Period,a.Ko_unit1,c.rekan_nm, SUM(a.tax_Rp) t_tax FROM tb_tax a 
                    LEFT JOIN tb_bp b ON a.id_bp = b.id_bp
                    LEFT JOIN tb_rekan c ON	b.nm_BUcontr = c.id_rekan
                    WHERE b.Ko_bp IN(3,4,5,41) && b.Ko_Period = "'.Tahun().'" && b.Ko_unit1 = "'.kd_bidang().'"
                    GROUP BY b.nm_BUcontr
                    ORDER BY b.id_bp ASC'));
        return view('transaksi.belanja.pajak.index', compact('pajak'));
    }

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
        // $pajak_rinci = DB::select(DB::raw('SELECT c.id_rekan,c.rekan_nm,b.No_bp,b.Ur_bp,a.Ko_tax,a.Ko_Rkk,a.tax_Rp FROM tb_tax a 
        //                 LEFT JOIN tb_bp b ON a.id_bp = b.id_bp
        //                 LEFT JOIN tb_rekan c ON b.nm_BUcontr = c.id_rekan
        //                 WHERE c.id_rekan = "'.$id.'"
        //                 ORDER BY a.id_bp DESC'));

        $pajak_rinci = DB::select("SELECT c.id_rekan,c.rekan_nm,b.No_bp,b.Ur_bp,a.Ko_tax,a.Ko_Rkk,a.tax_Rp,d.ur_rk6 FROM tb_tax a 
                        LEFT JOIN tb_bp b ON a.id_bp = b.id_bp && a.Ko_unit1 = a.Ko_unit1 && a.Ko_Period = b.Ko_Period
                        LEFT JOIN tb_rekan c ON b.nm_BUcontr = c.id_rekan
                        LEFT JOIN pf_rk6 d ON a.Ko_Rkk = d.Ko_RKK 
                        WHERE c.id_rekan = '".$id."' && a.Ko_unit1 = '".kd_bidang()."' && a.Ko_Period = b.Ko_Period
                        ORDER BY a.id_bp DESC");

        return view('transaksi.belanja.pajak.rincian',compact('pajak_rinci'));
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
    public function update(Request $request, $pajak)
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
