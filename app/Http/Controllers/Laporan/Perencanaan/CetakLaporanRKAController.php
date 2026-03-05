<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Tbpjb;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaCoverController as RptRkaCover;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaLamp1Controller as RptRkaLamp1;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaLamp2Controller as RptRkaLamp2;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaLamp3Controller as RptRkaLamp3;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaLamp4Controller as RptRkaLamp4;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptRkaLamp5Controller as RptRkaLamp5;

class CetakLaporanRKAController extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.perencanaan.cetak-rka';
    }

    public function export(Request $request)
    {
        $rkaperubahan_req = $request->rkaperubahan_check;
        $tahun = $request->tahun;
        $jenis_laporan_req = $request->jenis_laporan;
        $idkegiatan=$request->idkegiatan;
		
        $ibukota 			= $request->ibukota;
        $tgl_laporan 		= $request->tgl_laporan;
		$penandatanganPimpinan = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 1
		])->first();

        switch ($jenis_laporan_req) {
            case 1;
                $model = RptRkaCover::Laporan($tahun);
                $Orientasi = 'Potrait';
                $FooterLeft = NULL;
                $FooterRight = NULL;
                $view = $this->view . '.rkacover';
                break;
            case 2;
                $model = RptRkaLamp1::Laporan($tahun, $rkaperubahan_req);
                $Orientasi = 'Potrait';
                $FooterLeft = 'printed by ' . config('app.name') . '';
                $FooterRight = 'Halaman [page]';
                $view = $this->view . '.rkalamp1';
                break;
            case 3;
                $model = RptRkaLamp2::Laporan($tahun, $rkaperubahan_req);
                if ($rkaperubahan_req == NULL) {
                    $Orientasi = 'Potrait';
                } else {
                    $Orientasi = 'Landscape';
                }
                $FooterLeft = 'printed by ' . config('app.name') . '';
                $FooterRight = 'Halaman [page]';
                $view = $this->view . '.rkalamp2';
                break;
            case 4;
                $model = RptRkaLamp3::Laporan($tahun, $rkaperubahan_req);
                $Orientasi = 'Landscape';
                $FooterLeft = 'printed by ' . config('app.name') . '';
                $FooterRight = 'Halaman [page]';
                $view = $this->view . '.rkalamp3';
                break;
            case 5;
                $model = RptRkaLamp4::Laporan($tahun, $idkegiatan, $rkaperubahan_req);
                if ($rkaperubahan_req == NULL) {
                    $Orientasi = 'Potrait';
                } else {
                    $Orientasi = 'Landscape';
                }
                $FooterLeft = 'printed by ' . config('app.name') . '';
                $FooterRight = 'Halaman [page]';
                $view = $this->view . '.rkalamp4';
                break;
            case 6;
                $model = RptRkaLamp5::Laporan($tahun, $rkaperubahan_req);
                $Orientasi = 'Potrait';
                $FooterLeft = 'printed by ' . config('app.name') . '';
                $FooterRight = 'Halaman [page]';
                $view = $this->view . '.rkalamp5';
                break;
        }

        $param = [
            'title' => 'Rencana Kerja dan Anggaran',
            'model' => $model,
            'ibukota' => $ibukota,
			'tgl_laporan' => $tgl_laporan,
			'penandatanganPimpinan' => $penandatanganPimpinan,
            'pages' => 1,
            'rkaperubahan_req' => $rkaperubahan_req,
        ];

        $pdf = PDF::loadView($view, $param)->setPaper('Folio', $Orientasi);
		
		$pdf->setOptions([
            'defaultFont' => 'serif',
            //'isHtml5ParserEnabled' => true,
            //'isRemoteEnabled' => true,
            'font_height_ratio' => '1',
        ]);
		
            //->setOrientation($Orientasi)
            //->setOption('page-size', 'Folio')
            //->setOption('footer-font-name', 'Helvetica')
            //->setOption('footer-font-size', 9)
            //->setOption('footer-left', $FooterLeft)
            //->setOption('footer-right', $FooterRight)
            //->setOption('footer-line', false);
        return $pdf->stream('RptRKA.pdf');
    }

    public function laporan(Request $request)
    {
        $tahun = Tahun();
        $idsubunit_req = kd_unit();

        $jns = [
            ['id' => 1, 'uraian' => 'Cover RKA'],
            ['id' => 2, 'uraian' => 'Rekapitulasi RKA'],
            ['id' => 3, 'uraian' => 'RKA Pendapatan'],
            ['id' => 4, 'uraian' => 'RKA Rekapitulasi Belanja'],
            ['id' => 5, 'uraian' => 'RKA Belanja'],
            ['id' => 6, 'uraian' => 'RKA Pembiayaan'],
        ];
        $jnslap = collect($jns)->pluck('uraian', 'id')->all();
		
		$ibukota = nm_ibukota();

        return view($this->view . '.index', [
            'tahun' => $tahun,
            'jnslap' => $jnslap,
            'prefix' => $this->modul,
            'idsubunit' =>  $idsubunit_req,
            'ibukota' => $ibukota,
        ]);
    }

    public function selectProgram(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT m.Ur_Prg AS nmprogram, m.Ko_Prg AS idprogram, CONCAT(LPAD(m.Ko_Prg,2,0),' - ',m.Ur_Prg) AS program_display 
                    FROM tb_ang_rc AS a INNER JOIN
                        tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
                        tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
                        tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
                        pf_skeg k ON j.Ko_sKeg1=k.Ko_sKeg1 INNER JOIN
                        pf_keg l ON k.Ko_Keg=l.Ko_Keg AND k.Ko_Prg=l.Ko_Prg AND k.Ko_bid=l.Ko_bid AND k.Ko_Urus=l.Ko_Urus INNER JOIN
                        pf_prg m ON l.Ko_Prg=m.Ko_Prg AND l.Ko_bid=m.Ko_bid AND l.Ko_Urus=m.Ko_Urus
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." ");

        $refprogram = collect($data)->pluck('program_display', 'idprogram')->all();
        return response()->json(['refprogram' => $refprogram], 200);
    }

    public function selectKegiatan(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT l.Ur_Keg AS nmkegiatan, l.Ko_Prg AS idprogram, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg) AS idkegiatan, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg,' - ',l.Ur_Keg) AS kegiatan_display
                    FROM tb_ang_rc AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.Ko_sKeg1=k.Ko_sKeg1 INNER JOIN
						pf_keg l ON k.Ko_Keg=l.Ko_Keg AND k.Ko_Prg=l.Ko_Prg AND k.Ko_bid=l.Ko_bid AND k.Ko_Urus=l.Ko_Urus 
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." AND l.Ko_Prg='" . $id."' ");

        $refkegiatan = collect($data)->pluck('kegiatan_display', 'idkegiatan')->all();
        return response()->json(['refkegiatan' => $refkegiatan], 200);
    }

    public function selectSubKegiatan(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT k.Ur_sKeg AS nmsubkegiatan, k.Ko_Prg AS idprogram, CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg) AS idkegiatan, CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg,'.',LPAD(k.Ko_sKeg,3,0)) AS idsubkegiatan, CONCAT(k.Ko_sKeg1,' - ',k.Ur_sKeg) AS subkegiatan_display
                    FROM tb_ang_rc AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.Ko_sKeg1=k.Ko_sKeg1
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $id."' ");

        $refsubkegiatan = collect($data)->pluck('subkegiatan_display', 'idsubkegiatan')->all();
        return response()->json(['refsubkegiatan' => $refsubkegiatan], 200);
    }

}
