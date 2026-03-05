<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PDF;

class LapAngKasController extends Controller
{
  public function index()
  {
    return view('laporan.perencanaan.anggaran_kas.index');
  }

  public function lap_ang_kas_pendapatan()
  {

    $pdf = PDF::loadView('laporan.perencanaan.anggaran_kas.lap_ang_kas_pendapatan')->setPaper('A4', 'landscape');
    return $pdf->stream('Laporan Anggaran Kas Pendapatan.pdf',  array("Attachment" => false));
    
  }

  public function lap_ang_kas_belanja_keg()
  {

    $pdf = PDF::loadView('laporan.perencanaan.anggaran_kas.lap_ang_kas_belanja_keg')->setPaper('A4', 'landscape');
    return $pdf->stream('Laporan Anggaran Kas Belanja - Per Kegiatan.pdf',  array("Attachment" => false));
    
  }

  public function lap_ang_kas_pembiayaan()
  {

    $pdf = PDF::loadView('laporan.perencanaan.anggaran_kas.lap_ang_kas_pembiayaan')->setPaper('A4', 'landscape');
    return $pdf->stream('Laporan Anggaran Kas Pembiayaan.pdf',  array("Attachment" => false));
    
  }

}
