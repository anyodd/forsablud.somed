<?php

namespace App\Http\Controllers\Pembukuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RebuildController extends Controller
{
    public function index()
    {
        return view('pembukuan.rebuild.index');
    }

    public function process()
    {
        $data = DB::table('tb_sub1')->get();

        $apbd = DB::SELECT("SELECT apbd FROM tb_sub WHERE ko_unitstr = '".kd_unit()."' ");

        $sp = " ";

        if($apbd[0]->apbd == 1) {
			$sp = "_1";	
		}

        DB::beginTransaction();
        try { DB::statement('CALL SP_Hapus_Jurnal("'.kd_unit().'")'); 
            DB::commit(); 
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        } 
        
        // DB::beginTransaction();
        // try { DB::statement('CALL SP_Rebuild_Jurnal("'.kd_unit().'")'); 
        //     DB::commit(); 
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //    return false;
        // } // 07-08-2024 Pramuka

        DB::beginTransaction();
        try { DB::statement('CALL SP_Rebuild_Jurnal'.$sp.'("'.kd_unit().'")'); 
            DB::commit(); 
        } catch (\Throwable $th) {
            DB::rollBack();
           return false;
        } 

        return view('pembukuan.rebuild.data',compact('data'));
    }
}
