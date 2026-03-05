<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\Tboto;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\Environment\Console;

class PDFSpmController extends Controller
{
    public function spm()
    {   
        $no_spm = Tboto::where([ 'Ko_Period'=>Tahun(), 'Ko_unitstr'=>kd_unit() ])->get(['No_oto', 'Ur_oto']);

        // dd($no_spm);

        return view('laporan.penatausahaan.spm.spm', compact('no_spm'));
    }

    public function cetakSpm(Request $request)
    {   
        $period = Session::get('Period');
        $ko_unitstr = kd_unit();
        $ko_unit1 = kd_bidang();

        $query = "SELECT a.*, b.Ur_SPi AS keperluan, c.Ko_Rkk, c.spirc_Rp, d.Ur_spi, e.ur_rk6, b.Dt_SPi, f.Nm_Pimp, f.NIP_Pimp,
                (SELECT SUM(a.spirc_Rp) FROM tb_spirc a 
                LEFT JOIN tb_oto b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_SPi = b.No_SPi
                WHERE b.No_oto = ? AND b.Ko_Period = ? AND b.Ko_unitstr = ?) AS total
                FROM tb_oto a
                LEFT JOIN tb_spi b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_SPi = b.No_SPi
                LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.Ko_unitstr = c.Ko_unitstr AND a.No_SPi = c.No_spi
                LEFT JOIN pf_spi d ON b.Ko_SPi = d.ko_spi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) e ON c.Ko_Rkk = e.RKK6
                LEFT JOIN tb_sub f ON c.Ko_Period = f.Ko_Period AND c.Ko_unitstr = f.Ko_unitstr
                WHERE a.No_oto = ? AND a.Ko_Period = ? AND a.Ko_unitstr = ?";

        $oto = DB::select($query, [
            $request->pilihSpm,
            $period,
            $ko_unitstr,
            $request->pilihSpm,
            $period,
            $ko_unitstr
        ]);

        $query = "SELECT a.*, d.ur_rk6
                FROM tb_tax a
                LEFT JOIN tb_spirc b ON a.No_bp = b.No_bp AND a.Ko_Period = b.Ko_Period
                LEFT JOIN tb_oto c ON b.Ko_Period = c.Ko_Period AND b.Ko_unitstr = c.Ko_unitstr AND b.No_spi = c.No_SPi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) d ON a.Ko_Rkk = d.RKK6
                WHERE c.No_oto = ? AND c.Ko_Period = ? AND c.Ko_unitstr = ?";

        $tax = DB::select($query, [
            $request->pilihSpm,
            $period,
            $ko_unitstr
        ]);
        
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('laporan.penatausahaan.spm.spmpdf', compact('oto', 'tax', 'data'))->setPaper('A4', 'portrait');

        return $pdf->download('SPM_' . $request->pilihSpm . '.pdf');
    }

    public function pilihSpm(Request $request)
    {   
        $period = Session::get('Period');
        $ko_unitstr = kd_unit();
        $ko_unit1 = kd_bidang();

        $query = "SELECT a.*, b.Ur_SPi AS keperluan, c.Ko_Rkk, c.spirc_Rp, d.Ur_spi, e.ur_rk6, b.Dt_SPi, f.Nm_Pimp, f.NIP_Pimp,
                (SELECT SUM(a.spirc_Rp) FROM tb_spirc a 
                LEFT JOIN tb_oto b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_SPi = b.No_SPi
                WHERE b.No_oto = ? AND b.Ko_Period = ? AND b.Ko_unitstr = ?) AS total
                FROM tb_oto a
                LEFT JOIN tb_spi b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_SPi = b.No_SPi
                LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.Ko_unitstr = c.Ko_unitstr AND a.No_SPi = c.No_spi
                LEFT JOIN pf_spi d ON b.Ko_SPi = d.ko_spi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) e ON c.Ko_Rkk = e.RKK6
                LEFT JOIN tb_sub f ON c.Ko_Period = f.Ko_Period AND c.Ko_unitstr = f.Ko_unitstr
                WHERE a.No_oto = ? AND a.Ko_Period = ? AND a.Ko_unitstr = ?";

        $oto = DB::select($query, [
            $request->no_spm,
            $period,
            $ko_unitstr,
            $request->no_spm,
            $period,
            $ko_unitstr
        ]);

        $query = "SELECT a.*, d.ur_rk6
                FROM tb_tax a
                LEFT JOIN tb_spirc b ON a.No_bp = b.No_bp AND a.Ko_Period = b.Ko_Period
                LEFT JOIN tb_oto c ON b.Ko_Period = c.Ko_Period AND b.Ko_unitstr = c.Ko_unitstr AND b.No_spi = c.No_SPi
                LEFT JOIN
                (SELECT CONCAT(
                LPAD(Ko_Rk1,2,0),'.' ,
                LPAD(Ko_Rk2,2,0),'.' ,
                LPAD(Ko_Rk3,2,0),'.' ,
                LPAD(Ko_Rk4,2,0),'.' ,
                LPAD(Ko_Rk5,3,0),'.' ,
                LPAD(Ko_Rk6,3,0)
                ) AS RKK6, ur_rk6
                FROM pf_rk6) d ON a.Ko_Rkk = d.RKK6
                WHERE c.No_oto = ? AND c.Ko_Period = ? AND c.Ko_unitstr = ?";

        $tax = DB::select($query, [
            $request->no_spm,
            $period,
            $ko_unitstr
        ]);

        return view('laporan.penatausahaan.spm.spmpilih', compact('oto', 'tax'));
    }
}
