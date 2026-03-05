<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use PDF;
use Illuminate\Support\Facades\DB;

class DPAController extends Controller
{
    public function dpa1() #dpa pendapatan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);
        // dd($unit);
        $datadpa1 = DB::select('call qr_DPA1('.Tahun().',"'.kd_bidang().'")');
        $ambildatadpa1 = collect($datadpa1);
        
        $jumlah = $ambildatadpa1->sum('To_Rp');

        return view('laporan.perencanaan.dpa.dpa1', compact('ambildatadpa1', 'jumlah','unit'));
    }

    public function dpa1_pdf() #dpa pendapatan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);

        $datapdfdpa1 = DB::select('call qr_DPA1('.Tahun().',"'.kd_bidang().'")');
        $ambildatapdfdpa1 = collect($datapdfdpa1);

        $jumlah = $ambildatapdfdpa1->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.dpa.dpa1_pdf', compact('ambildatapdfdpa1', 'jumlah','unit'))->setPaper('A4', 'portrait');
        return $pdf->stream('DPA Belanja Langsung Tahun '.$Ko_Period.'.pdf');
    }

    public function dpa2() #dpa belanja langsung
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);
  
        $datadpa2 = DB::select('call qr_DPA2('.Tahun().',"'.kd_bidang().'")');
        $ambildatadpa2 = collect($datadpa2);
        
        $jumlah = $ambildatadpa2->sum('To_Rp');

        return view('laporan.perencanaan.dpa.dpa2', compact('ambildatadpa2', 'jumlah','unit'));
    }

    public function dpa2_pdf() #dpa belanja langsung
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);

        $datapdfdpa2 = DB::select('call qr_DPA2('.Tahun().',"'.kd_bidang().'")');
        $ambildatapdfdpa2 = collect($datapdfdpa2);

        $jumlah = $ambildatapdfdpa2->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.dpa.dpa2_pdf', compact('ambildatapdfdpa2', 'jumlah','unit'))->setPaper('A4', 'portrait');
        return $pdf->stream('DPA Belanja Langsung Tahun '.$Ko_Period.'.pdf');
    }

    public function dpa3() #dpa penerimaan pembiayaan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);
  
        $datadpa3 = DB::select('call qr_DPA3('.Tahun().',"'.kd_bidang().'")');
        $ambildatadpa3 = collect($datadpa3);
        // dd($datadpa3);
        $jumlah = $ambildatadpa3->sum('To_Rp');
        return view('laporan.perencanaan.dpa.dpa3', compact('ambildatadpa3', 'jumlah','unit'));
    }

    public function dpa3_pdf() #dpa penerimaan pembiayaan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);

        $datapdfdpa3 = DB::select('call qr_DPA3('.Tahun().',"'.kd_bidang().'")');
        $ambildatapdfdpa3 = collect($datapdfdpa3);

        $jumlah = $ambildatapdfdpa3->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.dpa.dpa3_pdf', compact('ambildatapdfdpa3', 'jumlah','unit'))->setPaper('A4', 'portrait');
        return $pdf->stream('DPA Penerimaan Pembiayaan Tahun '.$Ko_Period.'.pdf');
    }

    public function dpa4() #dpa pengeluaran pembiayaan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);
  
        $datadpa4 = DB::select('call qr_DPA4('.Tahun().',"'.kd_bidang().'")');
        $ambildatadpa4 = collect($datadpa4);

        $jumlah = $ambildatadpa4->sum('To_Rp');
        return view('laporan.perencanaan.dpa.dpa4', compact('ambildatadpa4', 'jumlah','unit'));
    }

    public function dpa4_pdf() #dpa pengeluaran pembiayaan
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $unit = substr($Ko_unitstr,6,8);

        $datapdfdpa4 = DB::select('call qr_DPA4('.Tahun().',"'.kd_bidang().'")');
        $ambildatapdfdpa4 = collect($datapdfdpa4);

        $jumlah = $ambildatapdfdpa4->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.dpa.dpa4_pdf', compact('ambildatapdfdpa4', 'jumlah','unit'))->setPaper('A4', 'portrait');
        return $pdf->stream('DPA Pengeluaran Pembiayaan Tahun '.$Ko_Period.'.pdf');
    }
}
