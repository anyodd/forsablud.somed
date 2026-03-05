<?php

namespace App\Http\Controllers\Pengajuan\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use App\Models\Tblogv;
use App\Models\Tbspirc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class VerifikasiController extends Controller
{
    public function index()
    {
      $spi = DB::select(DB::raw('SELECT a.*,c.Ur_spi,SUM(b.spirc_Rp) t_rp FROM tb_spi a
            LEFT JOIN tb_spirc b
            ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            LEFT JOIN pf_spi c 
            ON a.Ko_SPi = c.ko_spi
            WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"
            GROUP BY a.id ORDER BY a.id DESC'));
      return view('pengajuan.verifikasi.index',compact('spi'));
    }

    public function v_bulan(Request $request,$id)
    {
      $bulan = $id;
      $request->session()->put('bulan', $bulan);

      $spi = DB::select(DB::raw('SELECT a.*,c.Ur_spi,SUM(b.spirc_Rp) t_rp FROM tb_spi a
          LEFT JOIN tb_spirc b
          ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
          LEFT JOIN pf_spi c 
          ON a.Ko_SPi = c.ko_spi
          WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'" && MONTH(a.Dt_spi) = "'.$bulan.'"
          GROUP BY a.id ORDER BY a.id DESC'));

      return view('pengajuan.verifikasi.index',compact('spi','bulan'));
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
      $no_spi = Tb_spi::where('id',$id)->value('No_SPi');
      $id_spi = Tb_spi::where('id',$id)->value('id');
      
      $spirc = DB::select("SELECT a.*,b.dt_bp FROM tb_spirc a
      LEFT JOIN tb_bp b ON a.No_bp = b.No_bp && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = LEFT(b.Ko_unit1,18)
      WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.No_spi = '".$no_spi."'");
      return view('pengajuan.verifikasi.detail',compact('spirc','id_spi'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
      $bulan = Session::get('bulan');
      Tb_spi::where('id',$id)->update([
          'Tag_v' => $request->Tag_v,
      ]);

      Alert::success('Berhasil', 'Data berhasil diverifikasi');
      return redirect()->route('verifikasi.bulan',$bulan);
    }

    public function destroy($id)
    {
        //
    }

  public function batal(Request $request, $id)
  {
    $bulan = Session::get('bulan');
    try {
      Tblogv::create([
        'Tag_v'   => $request->Tag_vSpi,
        'id_spi'  => $request->id_spi,
        'ur_logv' => $request->ur_logv,
        'Tag'     => '0',
        'tb_ulog' => 'verifikatur',
        'created_at' => now(),
        'updated_at' => now()
      ]);
  
      Tb_spi::where('id',$id)->update([
        'Tag_v' => $request->Tag_v,
      ]);
    } catch (\Illuminate\Database\QueryException $e) {
      $e->getMessage();
    }
    
    Alert::success('Berhasil', 'Data berhasil dikembalikan');
    return redirect()->route('verifikasi.bulan',$bulan);
  }

  public function cetak_ksppd($id)
  {
    $data = DB::select(DB::raw('SELECT a.*,c.Ur_spi,SUM(b.spirc_Rp) t_rp FROM tb_spi a
            LEFT JOIN tb_spirc b
            ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            LEFT JOIN pf_spi c 
            ON a.Ko_SPi = c.ko_spi
            WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"
            GROUP BY a.id ORDER BY a.id DESC'));
    $pegawai= collect($data)->where('id',$id)->first();
    $pdf = PDF::loadView('pengajuan.verifikasi.cetak.ksppd',compact('pegawai'))->setPaper('A4', 'potrait');
    return $pdf->stream('kelengkapan.pdf');
  }

  public function cetak_sptjb($id)
  {
    $row = DB::SELECT("SELECT s.Ur_Unit
							FROM tb_unit AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0)) = LEFT('".kd_unit()."',14)");
    $unit = collect($row)->first();
    $list = DB::select(DB::raw('SELECT a.*,c.Ur_spi,SUM(b.spirc_Rp) t_rp FROM tb_spi a
            LEFT JOIN tb_spirc b
            ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            LEFT JOIN pf_spi c 
            ON a.Ko_SPi = c.ko_spi
            WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"
            GROUP BY a.id ORDER BY a.id DESC'));
    $data= collect($list)->where('id',$id)->first();
    $pdf = PDF::loadView('pengajuan.verifikasi.cetak.sptjb',compact('unit','data'))->setPaper('A4', 'potrait');
    return $pdf->stream('cetak_sptjb.pdf');
  }

  public function cetak_sptjverif($id)
  {
    $row = DB::SELECT("SELECT s.Ur_Unit
							FROM tb_unit AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0)) = LEFT('".kd_unit()."',14)");
    $unit = collect($row)->first();
    $list = DB::select(DB::raw('SELECT a.*,c.Ur_spi,SUM(b.spirc_Rp) t_rp FROM tb_spi a
            LEFT JOIN tb_spirc b
            ON a.No_SPi = b.No_spi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
            LEFT JOIN pf_spi c 
            ON a.Ko_SPi = c.ko_spi
            WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'"
            GROUP BY a.id ORDER BY a.id DESC'));
    $data= collect($list)->where('id',$id)->first();
    $pdf = PDF::loadView('pengajuan.verifikasi.cetak.sptjverif',compact('unit','data'))->setPaper('A4', 'potrait');
    return $pdf->stream('cetak_sptjverif.pdf');
  }

}
