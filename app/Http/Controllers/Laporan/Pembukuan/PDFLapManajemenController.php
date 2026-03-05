<?php

namespace App\Http\Controllers\Laporan\Pembukuan;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\laporanTrait;

class PDFLapManajemenController extends Controller
{
  use laporanTrait;

  public function index() 
  {
    return view('laporan.pembukuan.lapman.index');
  }

  public function jurnalshow()
  {
    $jurnal = DB::table('vqr_daftarjr')
    ->select('*')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unitstr', kd_unit())
    ->get();

    $totald = collect($jurnal)->sum('Debet');
    $totalk = collect($jurnal)->sum('Kredit');
    $net = $totald - $totalk;

    $footer  = DB::table('tb_sub')
    ->select('*')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unitstr', kd_unit())
    ->get();

    return view('laporan.pembukuan.lapman.jurnal', compact('jurnal', 'totald', 'totalk'));
  }

  public function cetakLapman(Request $request)
  {
    $pdf = PDF::loadView('laporan.pembukuan.lapman.' . $request->lapman . 'pdf')->setPaper('A4', 'portrait');

    return $pdf->stream($request->lapman . '.pdf');
  }

  public function bbshow()
  {
    $bb = DB::table('vqr_daftarBB')
    ->select('*')
    ->where('Ko_Period', Tahun())
    ->where('Ko_unitstr', kd_unit())
    ->get();

    // dd($bb);

    $totald = collect($bb)->sum('Debet');
    $totalk = collect($bb)->sum('Kredit');
    $net = $totald - $totalk;

    return view('laporan.pembukuan.lapman.bb', compact('bb', 'totald', 'totalk'));
  }

  public function regPiutang()
  {
    return view('laporan.pembukuan.lapman.regPiutang');
  }
  
  public function regPiutangIsi(Request $request)
  {
    $regPiutang = $this->registerPiutang($request);

    return view('laporan.pembukuan.lapman.regPiutangIsi', compact('regPiutang'));
  }

  public function regPiutangCetak(Request $request)
  {
    $regPiutang = $this->registerPiutang($request);
    $date1 = $request->date1;
    $date2 = $request->date2;

    $pdf = PDF::loadView('laporan.pembukuan.lapman.regPiutangCetak', compact('regPiutang', 'date1', 'date2'))->setPaper('A4', 'landscape');
    return $pdf->download('register_piutang.pdf');
  }

  public function bkublud()
  {
    $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
    return view('laporan.pembukuan.lapman.bku',compact('pegawai'));
  }

  public function bku_blud_isi(Request $request)
  {
    $data = $this->bku_blud($request);
    $pegawai = DB::select("SELECT * FROM tb_sub WHERE Ko_unitstr = '".kd_unit()."'");
    return view('laporan.pembukuan.lapman.bkuisi', compact('data','pegawai'));
  }

  public function bku_blud_cetak(Request $request)
  {
    $data = $this->bku_blud($request);
    $date1 = $request->date1;
    $date2 = $request->date2;

    $pdf = PDF::loadView('laporan.pembukuan.lapman.bkucetak', compact('data', 'date1', 'date2'))->setPaper('A4', 'landscape');
    return $pdf->stream('BKU_BLUD.pdf');
  }

  public function realisasipb()
  {
    return view('laporan.pembukuan.lapman.realisasipb');
  }

  public function realisasipb_isi(Request $request)
  {
    $awal = $request->date1 ?? Tahun() . "/01/01";
    $date1 = $request->date1;
    $date2 = $request->date2;
    $date3 = date('Y-m-d', strtotime($date1. ' -1 days'));

    $rows = DB::select("
              SELECT a.*,SUM(a.To_Rp) Rp_DPA, SUM(b.spirc_Rp) Rp_lalu, SUM(c.spirc_Rp) Rp_Real FROM tb_tap a
              LEFT JOIN (SELECT c.* FROM tb_oto a
              JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
              JOIN tb_spirc c ON b.No_SPi = c.No_spi && b.Ko_Period = c.Ko_Period && b.Ko_unitstr = c.Ko_unitstr
              WHERE a.Dt_oto BETWEEN '".$awal."' AND '".$date3."'
              GROUP BY c.id) b ON a.Ko_Period = b.Ko_Period && LEFT(a.ko_unit1,18) = b.Ko_unitstr && a.Ko_sKeg1 = b.Ko_sKeg1 && a.Ko_sKeg2 = b.Ko_sKeg2 && a.Ko_Rkk = b.Ko_Rkk
              LEFT JOIN (SELECT c.* FROM tb_oto a
              JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
              JOIN tb_spirc c ON b.No_SPi = c.No_spi && b.Ko_Period = c.Ko_Period && b.Ko_unitstr = c.Ko_unitstr
              WHERE a.Dt_oto BETWEEN '".$date1."' AND '".$date2."'
              GROUP BY c.id) c ON a.Ko_Period = c.Ko_Period && LEFT(a.ko_unit1,18) = c.Ko_unitstr && a.Ko_sKeg1 = c.Ko_sKeg1 && a.Ko_sKeg2 = c.Ko_sKeg2 && a.Ko_Rkk = c.Ko_Rkk
              WHERE a.Ko_Period = '".Tahun()."' && LEFT(a.ko_unit1,18) = '".kd_unit()."' && a.id_tap = (SELECT MAX(id_tap) FROM tb_tap WHERE Ko_Period = '".Tahun()."' && LEFT(ko_unit1,18) = '".kd_unit()."')
              GROUP BY a.Ko_Rkk
            ");
    
    $data = collect($rows)->groupBy('Ur_Rk6')->map(function ($group) {
      return [
        'tot_dpa'  => $group->sum('Rp_DPA'),
        'tot_lalu' => $group->sum('Rp_lalu'),
        'tot_real' => $group->sum('Rp_Real'),
      ];
    });

    return view('laporan.pembukuan.lapman.realisasipb_isi',compact('data'));
  }

  public function lapsoaw(Request $request)
  {
    switch ($request->saldo) {
      case 'NERACA':
        $neraca = DB::select("call qr_soaw_Neraca('".$request->period."','".kd_unit()."')");
        $data = collect($neraca);

        $judul = "SALDO AWAL NERACA";

        return view('laporan.pembukuan.lapman.saldoawal.neraca', compact('data', 'judul'));
      break;

      case 'LRA':
        $lra = DB::select("call qr_soaw_LRA('".$request->period."','".kd_unit()."')");
        $data = collect($lra);
        // dd($data);
        $judul = "SALDO AWAL LRA";
        // $periode = "Periode ".date_format(date_create($tgl_awal), "j F Y")." s.d. ".date_format(date_create($tgl_akhir), "j F Y");

        return view('laporan.pembukuan.lapman.saldoawal.lra', compact('data', 'judul'));
      break;

      case 'LO':
        $neraca = [];
        $data = collect($neraca);

        $judul = "SALDO AWAL LO";

        return view('laporan.pembukuan.lapman.saldoawal.neraca', compact('data', 'judul'));
      break;
      
      default:
        $data = [];
        $judul = "";
        $periode = "";

        return view('laporan.pembukuan.lapman.saldoawal.neraca', compact('judul', 'data'));
      break;
    }
  }
}
