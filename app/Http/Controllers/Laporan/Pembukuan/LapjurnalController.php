<?php

namespace App\Http\Controllers\Laporan\Pembukuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Collection; 
use Carbon\Carbon;

class LapjurnalController extends Controller
{
  public function index(Request $request)
  {
    $tgl_awal =  $request->tgl_jurnal == "" ? "" : substr($request->tgl_jurnal, 6, 4)."-".substr($request->tgl_jurnal, 0, 2)."-".substr($request->tgl_jurnal, 3, 2);
    $tgl_akhir = $request->tgl_jurnal == "" ? "" : substr($request->tgl_jurnal, 19, 4)."-".substr($request->tgl_jurnal, 13, 2)."-".substr($request->tgl_jurnal, 16, 2);

    switch ($request->jns_jurnal) {
      case 'jr_trans':
        $sp_jurnal = DB::select("call sp_jurnal(".Tahun().", '".kd_unit()."', '".$tgl_awal."', '".$tgl_akhir."' )");
        $jurnal = collect($sp_jurnal);

        $judul = "JURNAL TRANSAKSI";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        return view('laporan.pembukuan.lapkeu.lapjurnal_index', compact('jurnal', 'judul', 'periode'));
      break;

      case 'jr_sesuai':
        $sp_jurnal_sesuai = DB::select("call sp_jurnal_sesuai(".Tahun().", '".kd_unit()."', '".$tgl_awal."', '".$tgl_akhir."' )");
        $jurnal = collect($sp_jurnal_sesuai);

        $judul = "JURNAL PENYESUAIAN";
        $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        return view('laporan.pembukuan.lapkeu.lapjurnal_index', compact('jurnal', 'judul', 'periode'));
      break;

      case 'jr_soaw':
        $sp_jurnal_soawal = DB::select("call sp_jurnal_soawal(".Tahun().", '".kd_unit()."')");
        $jurnal = collect($sp_jurnal_soawal);

        $judul = "JURNAL SALDO AWAL";
        $periode = "Tahun ".Tahun();

        return view('laporan.pembukuan.lapkeu.lapjurnal_index', compact('jurnal', 'judul', 'periode'));
      break;
      
      default:
        $bayu = DB::select("call sp_jurnal_soawal(2022, 'bayu')");
        $jurnal = collect($bayu);

        $judul = "";
        $periode = "";

        return view('laporan.pembukuan.lapkeu.lapjurnal_index', compact('jurnal', 'judul', 'periode'));
      break;
    }


  }

  public function show($id)
  {
        //
  }

}
