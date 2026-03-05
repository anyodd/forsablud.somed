<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function pengeluaran_rss()
    {
        $data = Tb_spi::all();
        // dd($data);
        return view('laporan.penatausahaan.bendahara.pengeluaran.rss',compact('data'));
    }

    public function pengeluaran_bku()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.bku');
    }

    public function pengeluaran_bpb()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.bpb');
    }

    public function pengeluaran_bpk()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.bpk');
    }

    public function pengeluaran_bppk()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.bppk');
    }

    public function pengeluaran_bppj()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.bppj');
    }

    public function pengeluaran_lpj()
    {
        return view('laporan.penatausahaan.bendahara.pengeluaran.lpj');
    }
}
