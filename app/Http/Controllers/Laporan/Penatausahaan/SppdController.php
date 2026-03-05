<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Http\Traits\laporanTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tb_spi;
use App\Models\Pfbank;
use PDF;

class SppdController extends Controller
{
  use laporanTrait;

  public function index()
  {
    $sppd_up = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => 1])->get();
    $sppd_gu = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => 4])->get();
    $sppd_ls = collect(DB::select(" SELECT * FROM tb_spi 
      where Ko_Period = '" . Tahun() . "' AND Ko_unitstr = '" . kd_unit() . "' AND Ko_SPi IN(2,3,9)"));
    $sppd_panjar = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => 7])->get();
    $sppd_nihil = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => 6])->orWhere('Ko_SPi', 8)->get();
    // $sppd_nihil = Tb_spi::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'Ko_SPi' => ['8','6']])->get();
    
    return view('laporan.penatausahaan.pengajuan.sppd.index', compact('sppd_up', 'sppd_gu', 'sppd_ls', 'sppd_panjar', 'sppd_nihil'));
  }

  public function sppd_pdf($id)
  {
    $spi = Tb_spi::find($id);

    $Ko_Wil1 = intval(substr(kd_unit(), 0, 2));
    $Ko_Wil2 = intval(substr(kd_unit(), 3, 2));
    $Ko_Urus = intval(substr(kd_unit(), 6, 2));
    $Ko_Bid = intval(substr(kd_unit(), 9, 2));
    $Ko_Unit = intval(substr(kd_unit(), 12, 2));
    $Ko_Sub = intval(substr(kd_unit(), 15, 3));

    $bank = Pfbank::where(['Ko_wil1' => $Ko_Wil1, 'Ko_Wil2' => $Ko_Wil2, 'Ko_Urus' => $Ko_Urus, 'Ko_Bid' => $Ko_Bid, 'Ko_Unit' => $Ko_Unit, 'Ko_Sub' => $Ko_Sub, 'Tag' => 1])->first();

    $qr_spp = DB::select("CALL SP_SPPD(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
	$qr_spp1 = DB::select("CALL SP_SPPD1(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
	$qr_spp2 = DB::select("CALL SP_SPPD2(" . Tahun() . ", '" . kd_unit() . "', '" . $spi->No_SPi . "')");
    $skas = collect($qr_spp1)->where('Anggaran',4)->sum('Total');

    if ($spi->Ko_SPi == 1) {
      $title = $spi->No_SPi;
      $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.sppd_up_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD UP: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
    } elseif ($spi->Ko_SPi == 2 || $spi->Ko_SPi == 3 || $spi->Ko_SPi == 9) {
      $title = $spi->No_SPi;
      $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.sppd_ls_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','qr_spp2','skas','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD LS: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
    } elseif ($spi->Ko_SPi == 4) {
      $title = $spi->No_SPi;
      $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.sppd_gu_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','qr_spp2','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD GU: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
    } elseif ($spi->Ko_SPi == 7) {
      $title = $spi->No_SPi;
      $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.sppd_panjar_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD Panjar: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
    } elseif ($spi->Ko_SPi == 6 || $spi->Ko_SPi == 8) {
      $title = $spi->No_SPi;
      $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.sppd_nihil_pdf', compact('spi', 'qr_spp', 'bank', 'qr_spp1','qr_spp2','title'))->setPaper('A4', 'portrait');
      return $pdf->stream('S-PPD Nihil: ' . $spi->No_SPi . '.pdf',  array("Attachment" => false));
    } {
      // code...
    }
  }

  public function regspp_isi(Request $request)
  {
    $regspp  = $this->regSPP($request);

    return view('laporan.penatausahaan.pengajuan.sppd.register_sppd_isi', compact('regspp'));
  }

  public function regspp_cetak(Request $request)
  {
    $regspp = $this->regSPP($request);
    $date1 = $request->date1;
    $date2 = $request->date2;

    $pdf = PDF::loadView('laporan.penatausahaan.pengajuan.sppd.register_sppd_cetak', compact('regspp', 'date1', 'date2'))->setPaper('A4', 'portrait');
    return $pdf->download('register_spp.pdf');
  }
}
