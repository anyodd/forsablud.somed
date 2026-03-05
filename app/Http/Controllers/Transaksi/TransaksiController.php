<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $tgl_awal =  $request->tgl_jurnal == "" ? "" : substr($request->tgl_jurnal, 6, 4)."-".substr($request->tgl_jurnal, 0, 2)."-".substr($request->tgl_jurnal, 3, 2);
        $tgl_akhir = $request->tgl_jurnal == "" ? "" : substr($request->tgl_jurnal, 19, 4)."-".substr($request->tgl_jurnal, 13, 2)."-".substr($request->tgl_jurnal, 16, 2);
       
        if ($request->transaksi == null && $request->bidang == null) {
            $data = DB::select('SELECT b.ur_subunit1 bidang, d.Ur_bp jenis, a.*,SUM(c.To_Rp) Rupiah,e.No_spi pengajuan,f.Dt_SPi tgl_pengajuan FROM tb_bp a
                LEFT JOIN tb_sub1 b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.ko_unit1
                LEFT JOIN tb_bprc c ON a.id_bp = c.id_bp
                LEFT JOIN pf_bp d ON a.Ko_bp = d.ko_bp
                LEFT JOIN tb_spirc e ON a.Ko_Period = e.Ko_Period && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.No_bp = e.No_bp
                LEFT JOIN tb_spi f ON e.Ko_Period = f.Ko_period && e.Ko_unitstr = f.Ko_unitstr && e.No_spi = f.No_spi
                WHERE a.Ko_Period = "'.Tahun().'" && LEFT(a.Ko_unit1,18) = "'.kd_unit().'" && a.Ko_bp = "0"
                GROUP BY a.id_bp');
        } elseif($request->transaksi == '0' && $request->bidang == '0') {
            $data = DB::select('SELECT b.ur_subunit1 bidang, d.Ur_bp jenis, a.*,SUM(c.To_Rp) Rupiah,e.No_spi pengajuan,f.Dt_SPi tgl_pengajuan FROM tb_bp a
                LEFT JOIN tb_sub1 b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.ko_unit1
                LEFT JOIN tb_bprc c ON a.id_bp = c.id_bp
                LEFT JOIN pf_bp d ON a.Ko_bp = d.ko_bp
                LEFT JOIN tb_spirc e ON a.Ko_Period = e.Ko_Period && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.No_bp = e.No_bp
                LEFT JOIN tb_spi f ON e.Ko_Period = f.Ko_period && e.Ko_unitstr = f.Ko_unitstr && e.No_spi = f.No_spi
                WHERE a.Ko_Period = "'.Tahun().'" && LEFT(a.Ko_unit1,18) = "'.kd_unit().'" && a.dt_bp BETWEEN "'.$tgl_awal.'" AND "'.$tgl_akhir.'"
                GROUP BY a.id_bp');
        } elseif($request->transaksi != '0' && $request->bidang == '0') {
            $data = DB::select('SELECT b.ur_subunit1 bidang, d.Ur_bp jenis, a.*,SUM(c.To_Rp) Rupiah,e.No_spi pengajuan,f.Dt_SPi tgl_pengajuan FROM tb_bp a
                LEFT JOIN tb_sub1 b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.ko_unit1
                LEFT JOIN tb_bprc c ON a.id_bp = c.id_bp
                LEFT JOIN pf_bp d ON a.Ko_bp = d.ko_bp
                LEFT JOIN tb_spirc e ON a.Ko_Period = e.Ko_Period && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.No_bp = e.No_bp
                LEFT JOIN tb_spi f ON e.Ko_Period = f.Ko_period && e.Ko_unitstr = f.Ko_unitstr && e.No_spi = f.No_spi
                WHERE a.Ko_Period = "'.Tahun().'" && LEFT(a.Ko_unit1,18) = "'.kd_unit().'" && a.Ko_bp = "'.$request->transaksi.'" && a.dt_bp BETWEEN "'.$tgl_awal.'" AND "'.$tgl_akhir.'"
                GROUP BY a.id_bp');
        } elseif($request->transaksi == '0' && $request->bidang != '0') {
            $data = DB::select('SELECT b.ur_subunit1 bidang, d.Ur_bp jenis, a.*,SUM(c.To_Rp) Rupiah,e.No_spi pengajuan,f.Dt_SPi tgl_pengajuan FROM tb_bp a
                LEFT JOIN tb_sub1 b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.ko_unit1
                LEFT JOIN tb_bprc c ON a.id_bp = c.id_bp
                LEFT JOIN pf_bp d ON a.Ko_bp = d.ko_bp
                LEFT JOIN tb_spirc e ON a.Ko_Period = e.Ko_Period && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.No_bp = e.No_bp
                LEFT JOIN tb_spi f ON e.Ko_Period = f.Ko_period && e.Ko_unitstr = f.Ko_unitstr && e.No_spi = f.No_spi
                WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.$request->bidang.'" && a.dt_bp BETWEEN "'.$tgl_awal.'" AND "'.$tgl_akhir.'"
                GROUP BY a.id_bp');
        } elseif($request->transaksi != '0' && $request->bidang != '0') {
            $data = DB::select('SELECT b.ur_subunit1 bidang, d.Ur_bp jenis, a.*,SUM(c.To_Rp) Rupiah,e.No_spi pengajuan,f.Dt_SPi tgl_pengajuan FROM tb_bp a
                LEFT JOIN tb_sub1 b ON a.Ko_Period = b.Ko_Period && a.Ko_unit1 = b.ko_unit1
                LEFT JOIN tb_bprc c ON a.id_bp = c.id_bp
                LEFT JOIN pf_bp d ON a.Ko_bp = d.ko_bp
                LEFT JOIN tb_spirc e ON a.Ko_Period = e.Ko_Period && LEFT(a.Ko_unit1,18) = e.Ko_unitstr && a.No_bp = e.No_bp
                LEFT JOIN tb_spi f ON e.Ko_Period = f.Ko_period && e.Ko_unitstr = f.Ko_unitstr && e.No_spi = f.No_spi
                WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.$request->bidang.'" && a.Ko_bp = "'.$request->transaksi.'" && a.dt_bp BETWEEN "'.$tgl_awal.'" AND "'.$tgl_akhir.'"
                GROUP BY a.id_bp');
        }

        $transaksi = DB::table('pf_bp')->get();
        $bidang    = DB::select('SELECT a.ko_unit1, a.ur_subunit1 bidang FROM tb_sub1 a WHERE a.Ko_Period = "'.Tahun().'" && LEFT(a.ko_unit1,18) = "'.kd_unit().'"');
        return view('transaksi.transaksi.index',compact('transaksi','bidang','data'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return view('transaksi.transaksi.rincian');
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
