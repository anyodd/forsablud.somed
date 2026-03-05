<?php

namespace App\Http\Controllers\Laporan\Pembukuan;

use App\Http\Controllers\Controller;
use App\Models\Pfrk6;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class LapbbController extends Controller
{
    function index(Request $request)
    {
        $tgl_awal =  $request->period == "" ? "" : substr($request->period, 6, 4)."-".substr($request->period, 0, 2)."-".substr($request->period, 3, 2);
        $tgl_akhir = $request->period == "" ? "" : substr($request->period, 19, 4)."-".substr($request->period, 13, 2)."-".substr($request->period, 16, 2);
        $tgl_saldo = date('Y-m-d', strtotime($tgl_awal. ' -1 days'));
        
        if ($request->kd_rkk == '' || $request->period == '') {
            $data = [];
            $kd_rkk = '';
            $ur_rkk = '';
            $saldo = '';
        } else {
        $kd_rkk = substr($request->kd_rkk,0,20);
        $kd_rkk5 = substr($request->kd_rkk,0,15);
        $ur_rkk = substr($request->kd_rkk,21);
        // $row    = DB::select("
        //     SELECT * FROM (
        //         SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, a.jrRp_D debet, a.jrRp_K kredit FROM jr_trans a 
        //         WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'

        //         UNION ALL

        //         SELECT b.Ko_unitstr, b.Ko_Period, b.Ko_Rkk kd_rkk, b.dt_sesuai tgl_tr, b.No_bp uraian, b.Rp_D debet, b.Rp_K kredit FROM jr_sesuai b 
        //         WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."' && b.Ko_Rkk = '".$kd_rkk."' && b.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
        //     ) a ORDER BY a.tgl_tr ASC
        // ");
        // $data = collect($row);

        // $saldo_debet = DB::select("
        //     SELECT SUM(t_debet) debet, SUM(t_kredit) kredit, SUM(t_debet-t_kredit) saldo FROM (
        //     SELECT SUM(a.jrRp_D) t_debet, SUM(a.jrRp_K) t_kredit FROM jr_trans a 
        //     WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_bukti BETWEEN '".Tahun()."-01-01' AND '".$tgl_awal."'
        //     GROUP BY a.Ko_Rkk
            
        //     UNION ALL
            
        //     SELECT SUM(b.Rp_D) t_debet, SUM(b.Rp_K) t_kredit FROM jr_sesuai b 
        //     WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."' && b.Ko_Rkk = '".$kd_rkk."' && b.dt_sesuai BETWEEN '".Tahun()."-01-01' AND '".$tgl_awal."'
        //     GROUP BY b.Ko_Rkk ) a
        // ");
        
        // $saldo_kredit = DB::select("
        //     SELECT SUM(t_debet) debet, SUM(t_kredit) kredit, SUM(t_kredit-t_debet) saldo FROM (
        //     SELECT SUM(a.jrRp_D) t_debet, SUM(a.jrRp_K) t_kredit FROM jr_trans a 
        //     WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_bukti BETWEEN '".Tahun()."-01-01' AND '".$tgl_saldo."'
        //     GROUP BY a.Ko_Rkk
            
        //     UNION ALL
            
        //     SELECT SUM(b.Rp_D) t_debet, SUM(b.Rp_K) t_kredit FROM jr_sesuai b 
        //     WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."' && b.Ko_Rkk = '".$kd_rkk."' && b.dt_sesuai BETWEEN '".Tahun()."-01-01' AND '".$tgl_saldo."'
        //     GROUP BY b.Ko_Rkk ) a
        // ");

        $saldo_debet = DB::select("
            SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, a.ko_rkk5 kd_rkk,0 tgl_jr, 0 uraian, a.soaw_Rp_D debet,a.soaw_Rp_K kredit FROM tb_soaw a
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.ko_rkk5 = '".$kd_rkk5."'
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, a.jrRp_D debet, a.jrRp_K kredit FROM jr_trans a 
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'   
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, a.Rp_D debet, a.Rp_K kredit FROM jr_sesuai a
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            ) a
        ");

        $saldo_kredit = DB::select("
            SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, a.ko_rkk5 kd_rkk,0 tgl_jr, 0 uraian, a.soaw_Rp_K debet,a.soaw_Rp_D kredit FROM tb_soaw a
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.ko_rkk5 = '".$kd_rkk5."'
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, a.jrRp_K debet, a.jrRp_D kredit FROM jr_trans a 
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'   
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, a.Rp_K debet, a.Rp_D kredit FROM jr_sesuai a
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && a.Ko_Rkk = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            ) a
        ");
        
        $rk   = substr($kd_rkk,0,2);
        $rk_1 = substr($kd_rkk,0,11);
        $rk_6 = substr($kd_rkk,0,5);

        if (in_array($rk,['05','08'])) {
            $saldo  = $saldo_debet;
        } elseif($rk == '01') {
            if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.05.05.01'])) {
                $saldo = $saldo_kredit;
            } else {
                $saldo  = $saldo_debet;
            }
        } elseif($rk == '06') {
            if ($rk_6 == '06.02') {
                $saldo  = $saldo_debet;
            } else {
                $saldo = $saldo_kredit;
            }
        } else {
            $saldo = $saldo_kredit;
        }

        }
        
        // dd($saldo);
        $judul = "BUKU BESAR";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        // dd($rkk);

        return view('laporan.pembukuan.lapkeu.lapbb_index',compact('judul','periode','kd_rkk','ur_rkk','tgl_awal','saldo'));
    }

    public function search(Request $request)
    {
        $data = [];
        $search = $request->q;

        $data = DB::select("SELECT a.Ko_RKK,b.Ur_Rk6 FROM (SELECT a.Ko_Rkk FROM jr_trans a
        WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."'
        GROUP BY a.Ko_Rkk
        UNION ALL
        SELECT b.Ko_Rkk FROM jr_sesuai b
        WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."'
        GROUP BY b.Ko_Rkk
        UNION ALL
        SELECT d.Ko_RKK Ko_RKK FROM tb_soaw c
        LEFT JOIN pf_rk6 d ON c.ko_rkk5 = LEFT(d.Ko_RKK,15)
        WHERE c.Ko_unitstr = '33.05.01.02.01.001' && c.Ko_Period = '2022'
        GROUP BY c.ko_rkk5
        ) a
        LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
        WHERE b.Ur_Rk6 LIKE '%".$search."%'
        GROUP BY a.Ko_Rkk ORDER BY a.Ko_Rkk");

        return response()->json($data);
    }


    //rekap buku besar

    public function searchrekap(Request $request)
    {
        $data = [];
        $search = $request->q;

        $data = DB::select("SELECT a.Ko_RKK,b.Ur_Rk3 FROM (SELECT LEFT(a.Ko_Rkk,8) Ko_RKK FROM jr_trans a
        WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."'
        GROUP BY a.Ko_Rkk
        UNION ALL
        SELECT LEFT(b.Ko_Rkk,8) Ko_RKK FROM jr_sesuai b
        WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."'
        GROUP BY b.Ko_Rkk
        UNION ALL
        SELECT LEFT(c.ko_rkk5,8) Ko_RKK FROM tb_soaw c
        WHERE c.Ko_unitstr = '".kd_unit()."' && c.Ko_Period = '".Tahun()."'
        GROUP BY c.ko_rkk5
        ) a
        LEFT JOIN pf_rk3 b ON LEFT(a.Ko_Rkk,8) = b.Ko_Rek3
        WHERE b.Ur_Rk3 LIKE '%".$search."%'
        GROUP BY a.Ko_Rkk ORDER BY a.Ko_Rkk");

        return response()->json($data);
    }

    public function searchsubrekap(Request $request)
    {
        $data = [];
        $search = $request->q;

        $data = DB::select("SELECT a.Ko_RKK,b.Ur_Rk4 FROM (
            SELECT LEFT(a.Ko_Rkk,11) Ko_RKK FROM jr_trans a
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."'
            GROUP BY a.Ko_Rkk
            UNION ALL
            SELECT LEFT(b.Ko_Rkk,11) Ko_RKK FROM jr_sesuai b
            WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."'
            GROUP BY b.Ko_Rkk
            UNION ALL
            SELECT LEFT(c.ko_rkk5,11) Ko_RKK FROM tb_soaw c
            WHERE c.Ko_unitstr = '".kd_unit()."' && c.Ko_Period = '".Tahun()."'
            GROUP BY c.ko_rkk5
            ) a
            LEFT JOIN pf_rk4 b ON LEFT(a.Ko_Rkk,11) = b.ko_rek4
            WHERE b.Ur_Rk4 LIKE '%".$search."%'
            GROUP BY a.Ko_Rkk ORDER BY a.Ko_Rkk");

        return response()->json($data);
    }

    public function searchsub2rekap(Request $request)
    {
        $data = [];
        $search = $request->q;

        $data = DB::select("SELECT a.Ko_RKK,b.Ur_Rk5 FROM (
            SELECT LEFT(a.Ko_Rkk,15) Ko_RKK FROM jr_trans a
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."'
            GROUP BY a.Ko_Rkk
            UNION ALL
            SELECT LEFT(b.Ko_Rkk,15) Ko_RKK FROM jr_sesuai b
            WHERE b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."'
            GROUP BY b.Ko_Rkk
            UNION ALL
            SELECT LEFT(c.ko_rkk5,15) Ko_RKK FROM tb_soaw c
            WHERE c.Ko_unitstr = '".kd_unit()."' && c.Ko_Period = '".Tahun()."'
            GROUP BY c.ko_rkk5
            ) a
            LEFT JOIN pf_rk5 b ON LEFT(a.Ko_Rkk,15) = b.ko_rek5
            WHERE b.Ur_Rk5 LIKE '%".$search."%'
            GROUP BY a.Ko_Rkk ORDER BY a.Ko_Rkk");

        return response()->json($data);
    }


    function rekap(Request $request)
    {
        $tgl_awal =  $request->period == "" ? "" : substr($request->period, 6, 4)."-".substr($request->period, 0, 2)."-".substr($request->period, 3, 2);
        $tgl_akhir = $request->period == "" ? "" : substr($request->period, 19, 4)."-".substr($request->period, 13, 2)."-".substr($request->period, 16, 2);
        $tgl_saldo = date('Y-m-d', strtotime($tgl_awal. ' -1 days'));
        
        if ($request->kd_rkk == '' || $request->period == '') {
            $data = [];
            $kd_rkk = '';
            $ur_rkk = '';
            $saldo = '';
        } else {
        $kd_rkk = substr($request->kd_rkk,0,8);
        $ur_rkk = substr($request->kd_rkk,9);

        $saldo_debet = DB::select("
            SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.ko_rkk5,11) kd_rkk, b.Ur_Rk4 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_D) debet,SUM(a.soaw_Rp_K) kredit FROM tb_soaw a
            LEFT JOIN pf_rk4 b ON LEFT(a.ko_rkk5,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,8) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,11)
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,11) kd_rkk, b.Ur_Rk4 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_D) debet, SUM(a.jrRp_K) kredit FROM jr_trans a 
            LEFT JOIN pf_rk4 b ON LEFT(a.Ko_Rkk,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,8) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY LEFT(a.Ko_Rkk,11)
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,11) kd_rkk, b.Ur_Rk4 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_D) debet, SUM(a.Rp_K) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk4 b ON LEFT(a.Ko_Rkk,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,8) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY LEFT(a.Ko_Rkk,11)
            ) a
        ");

        $saldo_kredit = DB::select("
            SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.ko_rkk5,11) kd_rkk, b.Ur_Rk4 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_K) debet,SUM(a.soaw_Rp_D) kredit FROM tb_soaw a
            LEFT JOIN pf_rk4 b ON LEFT(a.ko_rkk5,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,8) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,11)
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,11) kd_rkk, b.Ur_Rk4 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_K) debet, SUM(a.jrRp_D) kredit FROM jr_trans a 
            LEFT JOIN pf_rk4 b ON LEFT(a.Ko_Rkk,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,8) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY LEFT(a.Ko_Rkk,11)
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,11) kd_rkk, b.Ur_Rk4 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_K) debet, SUM(a.Rp_D) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk4 b ON LEFT(a.Ko_Rkk,11) = LEFT(b.ko_rek4,11)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,8) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY LEFT(a.Ko_Rkk,11)
            ) a
        ");
        
        $rk   = substr($kd_rkk,0,2);
        $rk_1 = substr($kd_rkk,0,11);
        $rk_6 = substr($kd_rkk,0,5);

            if (in_array($rk,['05','08'])) {
                $saldo  = $saldo_debet;
            } elseif($rk == '01') {
                if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.05.05.01'])) {
                    $saldo = $saldo_kredit;
                } else {
                    $saldo  = $saldo_debet;
                }
            } elseif($rk == '06') {
                if ($rk_6 == '06.02') {
                    $saldo  = $saldo_debet;
                } else {
                    $saldo = $saldo_kredit;
                }
            } else {
                $saldo = $saldo_kredit;
            }
        }

        $judul = "BUKU BESAR";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        // dd($rkk);

        return view('laporan.pembukuan.lapkeu.lapbbrekap',compact('judul','periode','kd_rkk','ur_rkk','tgl_awal','saldo'));
    }
    
    function subrekap(Request $request)
    {
        $tgl_awal =  $request->period == "" ? "" : substr($request->period, 6, 4)."-".substr($request->period, 0, 2)."-".substr($request->period, 3, 2);
        $tgl_akhir = $request->period == "" ? "" : substr($request->period, 19, 4)."-".substr($request->period, 13, 2)."-".substr($request->period, 16, 2);
        $tgl_saldo = date('Y-m-d', strtotime($tgl_awal. ' -1 days'));
        
        if ($request->kd_rkk == '' || $request->period == '') {
            $data = [];
            $kd_rkk = '';
            $ur_rkk = '';
            $saldo = '';
        } else {
        $kd_rkk = substr($request->kd_rkk,0,11);
        $ur_rkk = substr($request->kd_rkk,12);
        
        $saldo_debet = DB::select("SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.ko_rkk5,15) kd_rkk, b.Ur_Rk5 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_D) debet,SUM(a.soaw_Rp_K) kredit FROM tb_soaw a
            LEFT JOIN pf_rk5 b ON LEFT(a.ko_rkk5,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,11) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,15)
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,15) kd_rkk, b.Ur_Rk5 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_D) debet, SUM(a.jrRp_K) kredit FROM jr_trans a 
            LEFT JOIN pf_rk5 b ON LEFT(a.Ko_Rkk,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,11) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'   
            GROUP BY LEFT(a.Ko_Rkk,15)
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,15) kd_rkk, b.Ur_Rk5 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_D) debet, SUM(a.Rp_K) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk5 b ON LEFT(a.Ko_Rkk,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,11) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            GROUP BY LEFT(a.Ko_Rkk,15)
            ) a
        ");

        $saldo_kredit = DB::select("SELECT * FROM (
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.ko_rkk5,15) kd_rkk, b.Ur_Rk5 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_K) debet,SUM(a.soaw_Rp_D) kredit FROM tb_soaw a
            LEFT JOIN pf_rk5 b ON LEFT(a.ko_rkk5,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,11) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,15)
            
            UNION
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,15) kd_rkk, b.Ur_Rk5 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_K) debet, SUM(a.jrRp_D) kredit FROM jr_trans a 
            LEFT JOIN pf_rk5 b ON LEFT(a.Ko_Rkk,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,11) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'   
            GROUP BY LEFT(a.Ko_Rkk,15)
            
            UNION 
            
            SELECT a.Ko_unitstr, a.Ko_Period, LEFT(a.Ko_Rkk,15) kd_rkk, b.Ur_Rk5 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_K) debet, SUM(a.Rp_D) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk5 b ON LEFT(a.Ko_Rkk,15) = LEFT(b.ko_rek5,15)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,11) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            GROUP BY LEFT(a.Ko_Rkk,15)
            ) a
        ");
        
        $rk   = substr($kd_rkk,0,2);
        $rk_1 = substr($kd_rkk,0,11);
        $rk_6 = substr($kd_rkk,0,5);

        if (in_array($rk,['05','08'])) {
            $saldo  = $saldo_debet;
        } elseif($rk == '01') {
            if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.05.05.01'])) {
                $saldo = $saldo_kredit;
            } else {
                $saldo  = $saldo_debet;
            }
        } elseif($rk == '06') {
            if ($rk_6 == '06.02') {
                $saldo  = $saldo_debet;
            } else {
                $saldo = $saldo_kredit;
            }
        } else {
            $saldo = $saldo_kredit;
        }

        }

        // dd($kd_rkk);
        $judul = "BUKU BESAR";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        // dd($rkk);

        return view('laporan.pembukuan.lapkeu.lapbbsub',compact('judul','periode','kd_rkk','ur_rkk','tgl_awal','saldo'));
    }

    function subrekaprinci(Request $request)
    {
        $tgl_awal =  $request->period == "" ? "" : substr($request->period, 6, 4)."-".substr($request->period, 0, 2)."-".substr($request->period, 3, 2);
        $tgl_akhir = $request->period == "" ? "" : substr($request->period, 19, 4)."-".substr($request->period, 13, 2)."-".substr($request->period, 16, 2);
        $tgl_saldo = date('Y-m-d', strtotime($tgl_awal. ' -1 days'));
        
        if ($request->kd_rkk == '' || $request->period == '') {
            $data = [];
            $kd_rkk = '';
            $ur_rkk = '';
            $saldo = '';
        } else {
        $kd_rkk = substr($request->kd_rkk,0,15);
        $ur_rkk = substr($request->kd_rkk,16);
        
        $saldo_debet = DB::select("
            SELECT a.Ko_unitstr, a.Ko_Period, b.Ko_RKK kd_rkk, b.Ur_Rk6 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_D) debet,SUM(a.soaw_Rp_K) kredit FROM tb_soaw a
            LEFT JOIN pf_rk6 b ON LEFT(a.ko_rkk5,15) = LEFT(b.Ko_RKK,15)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,15) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,15)

            UNION

            SELECT a.Ko_unitstr, a.Ko_Period,a.Ko_Rkk kd_rkk, b.Ur_Rk6 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_D) debet, SUM(a.jrRp_K) kredit FROM jr_trans a 
            LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,15) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            GROUP BY a.Ko_Rkk

            UNION 

            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, b.Ur_Rk6 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_D) debet, SUM(a.Rp_K) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,15) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY a.Ko_Rkk
        ");

        $saldo_kredit = DB::select("
            SELECT a.Ko_unitstr, a.Ko_Period, b.Ko_RKK kd_rkk, b.Ur_Rk6 ur_rkk,0 tgl_jr, 0 uraian, SUM(a.soaw_Rp_K) debet,SUM(a.soaw_Rp_D) kredit FROM tb_soaw a
            LEFT JOIN pf_rk6 b ON LEFT(a.ko_rkk5,15) = LEFT(b.Ko_RKK,15)
            WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && LEFT(a.ko_rkk5,15) = '".$kd_rkk."'
            GROUP BY LEFT(a.ko_rkk5,15)

            UNION

            SELECT a.Ko_unitstr, a.Ko_Period,a.Ko_Rkk kd_rkk, b.Ur_Rk6 ur_rkk, a.dt_bukti tgl_tr, a.Buktijr_No uraian, SUM(a.jrRp_K) debet, SUM(a.jrRp_D) kredit FROM jr_trans a 
            LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,15) = '".$kd_rkk."' && a.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'  
            GROUP BY a.Ko_Rkk

            UNION 

            SELECT a.Ko_unitstr, a.Ko_Period, a.Ko_Rkk kd_rkk, b.Ur_Rk6 ur_rkk, a.dt_sesuai tgl_tr, a.No_bp uraian, SUM(a.Rp_K) debet, SUM(a.Rp_D) kredit FROM jr_sesuai a
            LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."' && LEFT(a.Ko_Rkk,15) = '".$kd_rkk."' && a.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' 
            GROUP BY a.Ko_Rkk
        ");

        $rk   = substr($kd_rkk,0,2);
        $rk_1 = substr($kd_rkk,0,11);
        $rk_6 = substr($kd_rkk,0,5);

        if (in_array($rk,['05','08'])) {
            $saldo  = $saldo_debet;
        } elseif($rk == '01') {
            if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.05.05.01'])) {
                $saldo = $saldo_kredit;
            } else {
                $saldo  = $saldo_debet;
            }
        } elseif($rk == '06') {
            if ($rk_6 == '06.02') {
                $saldo  = $saldo_debet;
            } else {
                $saldo = $saldo_kredit;
            }
        } else {
            $saldo = $saldo_kredit;
        }

        }

        $judul = "BUKU BESAR";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        // dd($rkk);

        return view('laporan.pembukuan.lapkeu.lapbbsubrinci',compact('judul','periode','kd_rkk','ur_rkk','tgl_awal','saldo'));
    }

    function lapbbrekap(Request $request)
    {
        $tgl_awal =  $request->period == "" ? "" : substr($request->period, 6, 4)."-".substr($request->period, 0, 2)."-".substr($request->period, 3, 2);
        $tgl_akhir = $request->period == "" ? "" : substr($request->period, 19, 4)."-".substr($request->period, 13, 2)."-".substr($request->period, 16, 2);
        
        $rows = DB::select("
            SELECT b.Ko_Rek3 rkk3, b.Ur_Rk3 ur_rk3,a.* FROM (
            SELECT a.rkk,a.tgl_jr,b.Ur_Rk6 uraian, a.debet, a.kredit FROM (
            SELECT b.Ko_RKK rkk,0 tgl_jr, SUM(a.soaw_Rp_D) debet, SUM(a.soaw_Rp_K) kredit FROM tb_soaw a 
            LEFT JOIN pf_rk6 b ON a.ko_rkk5 = LEFT(b.Ko_RKK,15)
            WHERE a.Ko_unitstr = '".kd_unit()."' && a.Ko_Period = '".Tahun()."'
            GROUP BY a.ko_rkk5
            
            UNION ALL
            
            SELECT b.Ko_Rkk rkk, b.dt_bukti tgl_jr, SUM(b.jrRp_D) debet, SUM(b.jrRp_K) kredit FROM jr_trans b WHERE
            b.Ko_unitstr = '".kd_unit()."' && b.Ko_Period = '".Tahun()."' && b.dt_bukti BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
            GROUP BY b.Ko_Rkk
            
            UNION ALL
            
            SELECT c.Ko_Rkk rkk, c.dt_sesuai tgl_jr, SUM(c.Rp_D) debet, SUM(c.Rp_K) kredit FROM jr_sesuai c WHERE
            c.Ko_unitstr = '".kd_unit()."' && c.Ko_Period = '".Tahun()."' && c.dt_sesuai BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
            GROUP BY c.Ko_Rkk ) a
            LEFT JOIN pf_rk6 b ON a.rkk = b.Ko_RKK
            GROUP BY a.rkk) a
            LEFT JOIN pf_rk3 b ON LEFT(a.rkk,8) = b.Ko_Rek3
        ");

        $data = collect($rows)->groupBy('ur_rk3')->map(function ($group) {
            return [
                'debet' => $group->sum('debet'), 
                'kredit' => $group->sum('kredit'),
                'rincian' => $group->groupBy('uraian')->map(function ($group1) {
                    return [
                        'debet' => $group1->sum('debet'), 
                        'kredit' => $group1->sum('kredit'), 
                    ];
                }),
            ];
        });

        // dd($data);
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        return view('laporan.pembukuan.lapkeu.bbrekap',compact('data','periode'));
    }
}
