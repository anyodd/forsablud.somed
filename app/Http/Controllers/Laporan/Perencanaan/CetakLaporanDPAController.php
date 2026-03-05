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
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaCoverController as RptDpaCover;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaLamp1Controller as RptDpaLamp1;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaLamp2Controller as RptDpaLamp2;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaLamp3Controller as RptDpaLamp3;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaLamp4Controller as RptDpaLamp4;
use App\Http\Controllers\Laporan\Perencanaan\FormatLaporan\RptDpaLamp5Controller as RptDpaLamp5;

class CetakLaporanDPAController extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.perencanaan.cetak-dpa';
    }

    public function export(Request $request)
    {
        $tahun=$request->tahun;
        $jenis_laporan_req=$request->jenis_laporan;
		$idprogram = $request->idprogram;
        $idkegiatan=$request->idkegiatan;

        $ibukota 			= $request->ibukota;
        $tgl_laporan 		= $request->tgl_laporan;
		$penandatanganPimpinan = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 1
		])->first();
		
        $idjnsdokumen_req=$request->idjnsdokumen;
        if($request->norevisi<0)
        {$norev_req=0;}
        else
        {$norev_req=$request->norevisi;}

        switch ($jenis_laporan_req){
            case 1;
                $model = RptDpaCover::Laporan($tahun, $idjnsdokumen_req);
                $Orientasi= 'Potrait';
                $FooterLeft=NULL;
                $FooterRight=NULL;
                $view = $this->view.'.dpacover';
                break;
            case 2;
                $model = RptDpaLamp1::Laporan($tahun, $idjnsdokumen_req, $norev_req);
                $Orientasi='Potrait';
                $FooterLeft='printed by ' . config('app.name') . '';
                $FooterRight='Halaman [page]';
                $view = $this->view.'.dpalamp1';
                break;
			 case 3;
                $model = RptDpaLamp2::Laporan($tahun, $idjnsdokumen_req,$norev_req);
                if ($idjnsdokumen_req == 2) {
                    $Orientasi = 'Potrait';
                } else {
                    $Orientasi = 'Landscape';
                }
                $FooterLeft='printed by ' . config('app.name') . '';
                $FooterRight='Halaman [page]';
                $view = $this->view.'.dpalamp2';
                break;
            case 4;
                $model = RptDpaLamp3::Laporan($tahun, $idjnsdokumen_req, $norev_req);
                $Orientasi='Landscape';
                $FooterLeft='printed by ' . config('app.name') . '';
                $FooterRight='Halaman [page]';
                $view = $this->view.'.dpalamp3';
                break;
			case 5;
            if($idprogram<1){die("Minimal dipilih sampai filter kegiatan");}
                $model = RptDpaLamp4::Laporan($tahun, $idkegiatan, $idjnsdokumen_req, $norev_req);
                if ($idjnsdokumen_req == 2) {
                    $Orientasi = 'Potrait';
                } else {
                    $Orientasi = 'Landscape';
                }
                $FooterLeft='printed by ' . config('app.name') . '';
                $FooterRight='Halaman [page]';
                $view = $this->view.'.dpalamp4';
                break;
            case 6;
                $model = RptDpaLamp5::Laporan($tahun, $idjnsdokumen_req, $norev_req);
                $Orientasi='Potrait';
                $FooterLeft='printed by ' . config('app.name') . '';
                $FooterRight='Halaman [page]';
                $view = $this->view.'.dpalamp5';
                break;
        }

        $param = [
            'title' => 'Dokumen Pelaksana Anggaran', //Tujuan dan Sasaran Jangka Menengah Pelayanan Perangkat Daerah
            'model' => $model,
            'ibukota' => $ibukota,
			'tgl_laporan' => $tgl_laporan,
			'penandatanganPimpinan' => $penandatanganPimpinan,
            'pages' => 1,
			'idjnsdokumen_req' => $idjnsdokumen_req,
        ];



		$pdf = PDF::loadView($view, $param)->setPaper('Folio', $Orientasi);
		
		$pdf->setOptions([
            'defaultFont' => 'serif',
            'isHtml5ParserEnabled' => true,
            //'isRemoteEnabled' => true,
            'font_height_ratio' => '1',
        ]);
		
		//->setOrientation($Orientasi)
		//->setOption('page-size', 'Folio')
		//->setOption('footer-font-name','Helvetica')
		//->setOption('footer-font-size', 7)
		//->setOption('footer-left', $FooterLeft)
		//->setOption('footer-right', $FooterRight)
		//->setOption('footer-line', false);
	   return $pdf->stream('RptDPA.pdf');
    } // end export

    public function laporan(Request $request)
    {		
        $tahun = Tahun();
		$idsubunit_req = kd_unit();

        $jns = [
            ['id' => 0,'uraian'=>'Pilih Jenis Laporan'],
            ['id' => 1,'uraian'=>'Cover DPA'],
            ['id' => 2,'uraian'=>'Rekapitulasi Ringkasan DPA'],
            ['id' => 3,'uraian'=>'DPA Pendapatan'],
            ['id' => 4,'uraian'=>'DPA Rekapitulasi Belanja'],
            ['id' => 5,'uraian'=>'DPA Rincian Belanja'],
            ['id' => 6,'uraian'=>'DPA Pembiayaan'],
        ];
        $jnslap = collect($jns)->pluck('uraian','id')->all();

        $jnsdok = DB::select("SELECT 0 AS idjnsdokumen, 'Pilih Jenis Dokumen' AS dokumen_display 
						UNION ALL
						SELECT jns.Ko_Tap AS idjnsdokumen, jns.Ur_Tap  AS dokumen_display
						FROM pf_tap AS jns
						WHERE jns.Ko_Tap IN (
							SELECT a.Ko_tap
							FROM tb_tap a 
							WHERE LEFT(a.ko_unit1,18)='".kd_unit()."' AND a.Ko_Period=".Tahun()." AND a.Ko_tap>=2 
							GROUP BY a.Ko_tap) ");
        $modeljnsdok = collect($jnsdok)->pluck('dokumen_display','idjnsdokumen')->all();
		
		$ibukota = nm_ibukota();

        return view($this->view.'.index', [
            'tahun' => $tahun,
            'jnslap' => $jnslap,
            'modeljnsdok' => $modeljnsdok,
            'prefix' => $this->modul,
			'idsubunit' =>  $idsubunit_req,
            'ibukota' => $ibukota,
        ]);
    }
 

	public function selectProgram(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT m.Ur_Prg AS nmprogram, m.Ko_Prg AS idprogram, CONCAT(LPAD(m.Ko_Prg,2,0),' - ',m.Ur_Prg) AS program_display 
                    FROM tb_tap AS a INNER JOIN
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
                    FROM tb_tap AS a INNER JOIN
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
                    FROM tb_tap AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.Ko_sKeg1=k.Ko_sKeg1
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $id."' ");

        $refsubkegiatan = collect($data)->pluck('subkegiatan_display', 'idsubkegiatan')->all();
        return response()->json(['refsubkegiatan' => $refsubkegiatan], 200);
    }

    public function selectJenisDokumen(Request $request, $id = null)
    {
        $data = DB::select("SELECT jns.Ko_Tap AS idjnsdokumen, jns.Ur_Tap  AS dokumen_display
					FROM pf_tap AS jns
					WHERE jns.Ko_Tap IN (
						SELECT a.Ko_tap
						FROM tb_tap a 
						WHERE LEFT(a.ko_unit1,18)='".kd_unit()."' AND a.Ko_Period=".Tahun()." AND a.Ko_tap>=2 
						GROUP BY a.Ko_tap) ");

        $refjnsdokumen = collect($data)->pluck('dokumen_display','idjnsdokumen')->all();
        return response()->json(['refjnsdokumen' => $refjnsdokumen], 200);
    }

    public function selectRevisi(Request $request, $id = null)
    {
        $data = DB::select("SELECT id_tap AS norevisi,
					CASE id_tap
					WHEN 0 AND Ko_tap=2 then 'Murni'
					ELSE CONCAT('Perubahan Ke-',id_tap) END AS uraian
					FROM tb_tap
					WHERE LEFT(ko_unit1,18)='".kd_unit()."' AND Ko_Period=".Tahun()." AND Ko_tap=".$id);

        $norevisi = collect($data)->pluck('uraian','norevisi')->all();
        return response()->json(['norevisi' => $norevisi], 200);
    }

}
