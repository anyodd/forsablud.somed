<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PDFSppController extends Controller
{
    public function spp()
    {   
        $no_spp = Tb_spi::where([ 'Ko_Period'=>Tahun(), 'Ko_unitstr'=>kd_unit() ])->get(['No_SPi', 'Ur_SPi']);
        
        return view('laporan.penatausahaan.spp.spp', compact('no_spp'));
    }

    public function cetakSpp(Request $request)
    {   
        $period = Tahun();
        $ko_unitstr = kd_unit();

        $query = "SELECT a.*, b.Nm_Pimp, b.NIP_Pimp, b.Nm_Keu, b.NIP_Keu, b.Nm_Bend, b.NIP_Bend, c.Dt_SPi, d.Ur_spi, e.ur_rk6,
                (SELECT SUM(spirc_Rp) FROM tb_spirc WHERE No_spi = ? AND Ko_Period = ? AND Ko_unitstr = ?) AS total
                FROM tb_spirc a
                LEFT JOIN tb_sub b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr
                LEFT JOIN tb_spi c ON a.Ko_Period = c.Ko_Period AND a.Ko_unitstr = c.Ko_unitstr AND a.No_spi = c.No_SPi
                LEFT JOIN pf_spi d ON c.Ko_SPi = d.ko_spi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) e
                ON a.Ko_Rkk = e.RKK6
                WHERE a.No_spi = ? AND a.Ko_Period = ? AND a.Ko_unitstr = ?";
        
        $spirc = DB::select($query, [
            $request->pilihSpp,
            $period,
            $ko_unitstr,
            $request->pilihSpp,
            $period,
            $ko_unitstr
        ]);

        $query = "SELECT
                a.No_bp,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.06.001.001' THEN a.tax_Rp ELSE 0 END) AS ppn,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.001.001' THEN a.tax_Rp ELSE 0 END) AS pph21,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.002.001' THEN a.tax_Rp ELSE 0 END) AS pph22,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.003.001' THEN a.tax_Rp ELSE 0 END) AS pph23,
                SUM(a.tax_Rp) AS total
                FROM tb_tax a
                LEFT JOIN tb_spirc b ON a.No_bp = b.No_bp AND a.Ko_Period = b.Ko_Period
                WHERE b.No_spi = ? AND b.Ko_Period = ?";

        $tax = DB::select($query, [
            $request->pilihSpp,
            $request->pilihSpp
        ]);

        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'spirc' => $spirc,
            'tax' => $tax,
        ];

        $pdf = PDF::loadView('laporan.penatausahaan.spp.spppdf', compact('data', 'spirc', 'tax'))->setPaper('A4', 'portrait');

        return $pdf->download('SPP_' . $request->pilihSpp . '.pdf');
    }

    public function pilihSpp(Request $request)
    {
        $period = Session::get('Period');
        $ko_unitstr = kd_unit();

        $query = "SELECT a.*, b.Nm_Pimp, b.NIP_Pimp, b.Nm_Keu, b.NIP_Keu, b.Nm_Bend, b.NIP_Bend, c.Dt_SPi, d.Ur_spi, e.ur_rk6,
                (SELECT SUM(spirc_Rp) FROM tb_spirc WHERE No_spi = ? AND Ko_Period = ? AND Ko_unitstr = ?) AS total
                FROM tb_spirc a
                LEFT JOIN tb_sub b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr
                LEFT JOIN tb_spi c ON a.Ko_Period = c.Ko_Period AND a.Ko_unitstr = c.Ko_unitstr AND a.No_spi = c.No_SPi
                LEFT JOIN pf_spi d ON c.Ko_SPi = d.ko_spi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) e
                ON a.Ko_Rkk = e.RKK6
                WHERE a.No_spi = ? AND a.Ko_Period = ? AND a.Ko_unitstr = ?";
        
        $spirc = DB::select($query, [
            $request->no_spp,
            $period,
            $ko_unitstr,
            $request->no_spp,
            $period,
            $ko_unitstr
        ]);

        $query = "SELECT
                a.No_bp,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.06.001.001' THEN a.tax_Rp ELSE 0 END) AS ppn,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.001.001' THEN a.tax_Rp ELSE 0 END) AS pph21,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.002.001' THEN a.tax_Rp ELSE 0 END) AS pph22,
                MAX(CASE WHEN a.Ko_Rkk = '02.01.01.05.003.001' THEN a.tax_Rp ELSE 0 END) AS pph23,
                SUM(a.tax_Rp) AS total
                FROM tb_tax a
                LEFT JOIN tb_spirc b ON a.No_bp = b.No_bp AND a.Ko_Period = b.Ko_Period
                WHERE b.No_spi = ? AND b.Ko_Period = ?";

        $tax = DB::select($query, [
            $request->no_spp,
            $request->no_spp
        ]);

        return view('laporan.penatausahaan.spp.spppilih', compact('spirc', 'tax'));
    }
}
