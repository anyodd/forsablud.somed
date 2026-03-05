<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\Tbbprc;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade AS PDF;

class PendapatanController extends Controller
{
    public function bppendapatan() 
    {
        $dt = DB::table('vqr_buktipdp')
                ->where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang()])
                ->orderBy('id_bp')
                ->get();
        return view('laporan.penatausahaan.pendapatan.bppendapatan',compact('dt'));
    }

    public function d_bpp($id)
    {
        $dt = DB::table('vqr_buktipdp')
                ->where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang(), 'id_bp' => $id])
                ->first();
        return response()->json([
            'data' => $dt,
        ]);
    }

    public function print_bpp($id)
    {
        $dt = DB::table('vqr_buktipdp')
                ->where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang(), 'id_bp' => $id])
                ->first();
        $data = [
            'data' => $dt,
        ];
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_bppendapatan', $data);
        $pdf->setPaper('A4', 'potrait');
        
        return $pdf->stream();
    }

    public function stspendapatan() 
    {
        $dt = DB::table('vqr_sts')
                ->where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit()])
                ->orderBy('id_sts')
                ->get();
        return view('laporan.penatausahaan.pendapatan.stspendapatan', compact('dt'));
    }

    public function d_stsp($id)
    {
        $dt = DB::table('vqr_sts')
                ->where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'id_sts' => $id])
                ->first();
        return response()->json([
            'data' => $dt,
        ]);
    }

    public function print_stsp($id)
    {
        $dt = DB::table('vqr_sts')
        ->where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'id_sts' => $id])
        ->first();

        $data = [
            'data' => $dt,
        ];     

        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_sts',$data);
        $pdf->setPaper('A4', 'potrait');
        
        return $pdf->stream();
    }

    public function rppendapatan() 
    {
        return view('laporan.penatausahaan.pendapatan.rppendapatan');
    }

    public function rppendapatan_pdf()
    {
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_rppendapatan');
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream();
    }

    public function bkupenerimaan() 
    {
        $dt = DB::table('vqr_bkupdp')
                // ->where(['Ko_period' => Tahun(), 'Ko_unit1' => kd_bidang()])
                ->get();
                
        return view('laporan.penatausahaan.pendapatan.bkupenerimaan',compact('dt'));
    }

    public function bkupenerimaan_pdf()
    {
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_bkupenerimaan');
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream();
    }

    public function bprincian() 
    {
        return view('laporan.penatausahaan.pendapatan.bprincian');
    }

    public function bprincian_pdf()
    {
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_bprincian');
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream();
    }

    public function lpjbendahara() 
    {
        return view('laporan.penatausahaan.pendapatan.lpjbendahara');
    }

    public function lpjbendahara_pdf()
    {
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_lpjbendahara');
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream();
    }

    public function otopenerimaan() 
    {
        return view('laporan.penatausahaan.pendapatan.otopenerimaan');
    }

    public function otopenerimaan_pdf()
    {
        $pdf = PDF::loadView('laporan.penatausahaan.pendapatan.cetak_otopenerimaan');
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream();
    }

   

   
}
