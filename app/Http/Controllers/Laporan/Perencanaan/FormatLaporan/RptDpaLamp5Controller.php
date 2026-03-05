<?php

namespace App\Http\Controllers\Laporan\Perencanaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class RptDpaLamp5Controller extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.perencanaan.cetak-dpa';
    }

    public static function Laporan($tahun, $idjnsdokumen_req, $idnorev)
    {
        $pemda = DB::select("SELECT CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) AS Ko_pemda, ur_pemda AS nmpemda 
							FROM tb_pemda
							WHERE CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) = LEFT('".kd_unit()."',5)
							ORDER BY ko_wil1, ko_wil2 ");
        $tahun = $tahun;
        $id_bidang = bidang_id(kd_unit());
		$pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = ".$id_bidang." GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";

        $bid = DB::SELECT("SELECT DISTINCT u.Ko_Urus AS kdurusan, u.Ur_Urus AS nmurusan, b.id_bidang AS idbidang, b.Ur_Bid AS nmbidang, CONCAT(RIGHT(CONCAT('0',u.Ko_Urus),2),'.',RIGHT(CONCAT('0',b.Ko_Bid),2)) AS kode_bidang
						FROM pf_urus AS u
						INNER JOIN pf_bid AS b ON u.Ko_Urus=b.Ko_Urus
						WHERE CONCAT(RIGHT(CONCAT('0',u.Ko_Urus),2),'.',RIGHT(CONCAT('0',b.Ko_Bid),2)) = SUBSTRING('".kd_unit()."',7,5) ");
        $kode_urusan = $bid[0]->kdurusan;
        $nmurusan = $bid[0]->nmurusan;
        $kode_bidang = $bid[0]->kode_bidang;
        $nmbidang = $bid[0]->nmbidang;

		$skpd = DB::SELECT("SELECT CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0)) AS kode_skpd, s.Ur_unit AS uraian_skpd
							FROM tb_unit AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0)) = LEFT('".kd_unit()."',14)");

		$kdskpd = $skpd[0]->kode_skpd;
		$urskpd = $skpd[0]->uraian_skpd;

		$unit = DB::SELECT("SELECT CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) AS kode_unit, s.ur_subunit AS uraian_unit
							FROM tb_sub AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) = LEFT('".kd_unit()."',18)");

		$kdunit = $unit[0]->kode_unit;
		$urunit = $unit[0]->uraian_unit;

        $a=0;
        $obj=array();
		if($idjnsdokumen_req==2){
			foreach ($unit as $row0) {
				$rek2 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
					FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
					FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
					WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=1 ) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					ORDER BY A.kdrek1, A.kdrek2, A.nmrek2");

                    $c=0;
                    $biaya_m=0;
                    $objRek2=array();
                    foreach ($rek2 as $row2) {
                        $rek3 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
							FROM tb_tap a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3");

                        $d=0;
                        $objRek3=array();
                        foreach ($rek3 as $row3) {
                            $rek4 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening, A.nmrek4 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
								FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, d.Ur_Rk4 AS nmrek4, a.To_Rp AS jumlah
								FROM tb_tap a INNER JOIN pf_rk4 d ON LEFT(a.ko_rkk,2)=d.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = d.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = d.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = d.Ko_Rk4
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3."	) A
								GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4
								ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4");

                            $e=0;
                            $objRek4=array();
                            foreach ($rek4 as $row4) {
                                $rek5 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4,  A.kdrek5, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening, A.nmrek5 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
                                    FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, c.Ur_Rk5 AS nmrek5, a.To_Rp AS jumlah
                                    FROM tb_tap a INNER JOIN pf_rk5 c ON LEFT(a.ko_rkk,2)=c.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = c.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = c.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = c.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = c.Ko_Rk5 
                                    WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4."	) A
                                    GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5
                                    ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5");

                                $f=0;
                                $objRek5=array();
                                foreach ($rek5 as $row5) {
                                    $rek6 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5,A.kdrek6,
                                        CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening,
                                        A.nmrek6 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah, COALESCE(SUM(A.jml_volume),0) AS volume, COALESCE(SUM(A.harga),0) AS harga, A.satuan
                                        FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga 
                                        FROM tb_tap a INNER JOIN ". $pf_rk6 . " b ON LEFT(a.ko_rkk,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
                                        WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row5->kdrek5."	) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan
                                        ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan");

                                    $g=0;
                                    $objRek6=array();
                                    foreach ($rek6 as $row6) {
                                        $objRek6[$g]=array(
                                            'kode_rekening'=>$row6->kode_rekening,
                                            'nama_rekening'=>$row6->nama_rekening,
                                            'jumlah'=>$row6->jumlah,
                                        );
                                        $g=$g+1;
                                    } // Rek6
                                    $objRek5[$f]=array(
                                        'kode_rekening'=>$row5->kode_rekening,
                                        'nama_rekening'=>$row5->nama_rekening,
                                        'jumlah'=>$row5->jumlah,
                                        'rek_6'=>$objRek6,
                                    );
                                    $f=$f+1;
                                } // Rek5
                                $objRek4[$e]=array(
                                    'kode_rekening'=>$row4->kode_rekening,
                                    'nama_rekening'=>$row4->nama_rekening,
                                    'jumlah'=>$row4->jumlah,
                                    'rek_5'=>$objRek5,
                                );
                                $e=$e+1;
                            } // Rek4
                            $objRek3[$d]=array(
                                'kode_rekening'=>$row3->kode_rekening,
                                'nama_rekening'=>$row3->nama_rekening,
                                'jumlah'=>$row3->jumlah,
                                'rek_4'=>$objRek4,
                            );
                            $d=$d+1;
                        } // Rek3
                        $objRek2[$c]=array(
                            'kode_rekening'=>$row2->kode_rekening,
                            'nama_rekening'=>$row2->nama_rekening,
                            'jumlah'=>$row2->jumlah,
                            'rek_3'=>$objRek3,
                        );
                        $c=$c+1;
                        $biaya_m=$biaya_m + $row2->jumlah;
                    } // Rek2

                    $rek21 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
                        FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                        FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                        WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=2 ) A
                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                        ORDER BY A.kdrek1, A.kdrek2, A.nmrek2");

                        $c1=0;
                        $biaya_l=0;
                        $objRek21=array();
                        foreach ($rek21 as $row21) {
                            $rek31 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
                                FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
                                FROM tb_tap a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	) A
                                GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
                                ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3");

                            $d1=0;
                            $objRek31=array();
                            foreach ($rek31 as $row31) {
                                $rek41 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening, A.nmrek4 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
								FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, d.Ur_Rk4 AS nmrek4, a.To_Rp AS jumlah
								FROM tb_tap a INNER JOIN pf_rk4 d ON LEFT(a.ko_rkk,2)=d.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = d.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = d.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = d.Ko_Rk4
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3."	) A
								GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4
								ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4");

                                $e1=0;
                                $objRek41=array();
                                foreach ($rek41 as $row41) {
                                    $rek51 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4,  A.kdrek5, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening, A.nmrek5 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
                                        FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, c.Ur_Rk5 AS nmrek5, a.To_Rp AS jumlah
                                        FROM tb_tap a INNER JOIN pf_rk5 c ON LEFT(a.ko_rkk,2)=c.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = c.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = c.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = c.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = c.Ko_Rk5 
                                        WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4."	) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5
                                        ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5");

                                    $f1=0;
                                    $objRek51=array();
                                    foreach ($rek51 as $row51) {
                                        $rek61 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5,A.kdrek6,
                                            CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening,
                                            A.nmrek6 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah, COALESCE(SUM(A.jml_volume),0) AS volume, COALESCE(SUM(A.harga),0) AS harga, A.satuan
                                            FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga 
                                            FROM tb_tap a INNER JOIN ". $pf_rk6 . " b ON LEFT(a.ko_rkk,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
                                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=6 AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row51->kdrek5."	) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan
                                            ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan");

                                        $g1=0;
                                        $objRek61=array();
                                        foreach ($rek61 as $row61) {
                                            $objRek61[$g1]=array(
                                                'kode_rekening'=>$row61->kode_rekening,
                                                'nama_rekening'=>$row61->nama_rekening,
                                                'jumlah'=>$row61->jumlah,
                                            );
                                            $g1=$g1+1;
                                        } // Rek6
                                        $objRek51[$f1]=array(
                                            'kode_rekening'=>$row51->kode_rekening,
                                            'nama_rekening'=>$row51->nama_rekening,
                                            'jumlah'=>$row51->jumlah,
                                            'rek_6'=>$objRek61,
                                        );
                                        $f1=$f1+1;
                                    } // Rek5
                                    $objRek41[$e1]=array(
                                        'kode_rekening'=>$row41->kode_rekening,
                                        'nama_rekening'=>$row41->nama_rekening,
                                        'jumlah'=>$row41->jumlah,
                                        'rek_5'=>$objRek51,
                                    );
                                    $e1=$e1+1;
                                } // Rek4
                                $objRek31[$d1]=array(
                                    'kode_rekening'=>$row31->kode_rekening,
                                    'nama_rekening'=>$row31->nama_rekening,
                                    'jumlah'=>$row31->jumlah,
                                    'rek_4'=>$objRek41,
                                );
                                $d1=$d1+1;
                            } // Rek3
                            $objRek21[$c1]=array(
                                'kode_rekening'=>$row21->kode_rekening,
                                'nama_rekening'=>$row21->nama_rekening,
                                'jumlah'=>$row21->jumlah,
                                'rek_3'=>$objRek31,
                            );
                            $c1=$c1+1;
                            $biaya_l=$biaya_l + $row21->jumlah;
                        } // Rek2

                    $obj[$a]=array(
                        'nama_pemda' => $pemda[0]->nmpemda,
                        'tahun'=>$tahun,
                        'kode_skpd'=>$kdskpd,
                        'uraian_skpd'=>$urskpd,
                        'kode_unit'=>$kdunit,
                        'uraian_unit'=>$urunit,
                        'rek_terima'=>$objRek2,
                        'jml_terima'=>$biaya_m,
                        'rek_keluar'=>$objRek21,
                        'jml_keluar'=>$biaya_l,
                        'jml_biaya_netto'=>$biaya_m - $biaya_l,
                    );

			} //dokumen
		}//tutup if jika apbd murni (idjnsdokumen 2)
		else{
			foreach ($unit as $row0) {
				$dok = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=2 AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".$row0->kode_unit."' ");

                $rek2 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                    sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                    FROM
                    (
                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                        FROM 
                        (
                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=2 
                        ) A
                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                        UNION
                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                        FROM 
                        (
                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=2 
                        ) A
                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                    ) temp2
                    GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                    ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                    $c=0;
                    $biaya_m_sebelum=$biaya_m_setelah=$biaya_m_bertambah_berkurang=0;
                    $objRek2=array();
                    foreach ($rek2 as $row2) {
                        $rek3 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                            sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                            FROM
                            (
                                SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                FROM 
                                (
                                    SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                    FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                    WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2." 
                                ) A
                                GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                UNION
                                SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                FROM 
                                (
                                    SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                    FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                    WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2." 
                                ) A
                                GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                            ) temp2
                            GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                            ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                            $d=0;
                            $objRek3=array();
                            foreach ($rek3 as $row3) {
                                $rek4 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                                    sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                                    FROM
                                    (
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                        FROM 
                                        (
                                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." 
                                        ) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        UNION
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                        FROM 
                                        (
                                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." 
                                        ) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                    ) temp2
                                    GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                                    ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                                $e=0;
                                $objRek4=array();
                                foreach ($rek4 as $row4) {
                                    $rek5 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                                        sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                                        FROM
                                        (
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                            UNION
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        ) temp2
                                        GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                                        ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                                $f=0;
                                $objRek5=array();
                                foreach ($rek5 as $row5) {
                                    $rek6 = DB::SELECT("SELECT temp6.kdrek1, temp6.kdrek2, temp6.kdrek3,temp6.kdrek4,temp6.kdrek5, temp6.kode_rekening, temp6.nama_rekening, sum(temp6.jumlah_sebelum) as jumlah_sebelum, sum(temp6.jumlah_setelah) as jumlah_setelah,
                                    sum(temp6.jumlah_setelah)-sum(temp6.jumlah_sebelum) AS bertambah_berkurang
                                    FROM
                                    (
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row5->kdrek5."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                            UNION
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row5->kdrek5."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        ) temp6
                                        GROUP BY kdrek1,kdrek2,kdrek3,kdrek4,kdrek5,kdrek6,kode_rekening,nama_rekening
                                        ORDER BY kdrek1,kdrek2,kdrek3,kdrek4,kdrek5,kdrek6,kode_rekening,nama_rekening");

                                        $g=0;
                                        $objRek6=array();
                                        foreach ($rek6 as $row6) {
                                            $objRek6[$g]=array(
                                                'kode_rekening'=>$row6->kode_rekening,
                                                'nama_rekening'=>$row6->nama_rekening,
                                                'jumlah_sebelum'=>$row6->jumlah_sebelum,
                                                'jumlah_setelah'=>$row6->jumlah_setelah,
                                                'bertambah_berkurang'=>$row6->bertambah_berkurang,
                                            );
                                            $g=$g+1;
                                        } // Rek6
                                        $objRek5[$f]=array(
                                            'kode_rekening'=>$row5->kode_rekening,
                                            'nama_rekening'=>$row5->nama_rekening,
                                            'jumlah_sebelum'=>$row5->jumlah_sebelum,
                                            'jumlah_setelah'=>$row5->jumlah_setelah,
                                            'bertambah_berkurang'=>$row5->bertambah_berkurang,
                                            'rek_6'=>$objRek6,
                                        );
                                        $f=$f+1;
                                    } // Rek5
                                    $objRek4[$e]=array(
                                        'kode_rekening'=>$row4->kode_rekening,
                                        'nama_rekening'=>$row4->nama_rekening,
                                        'jumlah_sebelum'=>$row4->jumlah_sebelum,
                                        'jumlah_setelah'=>$row4->jumlah_setelah,
                                        'bertambah_berkurang'=>$row4->bertambah_berkurang,
                                        'rek_5'=>$objRek5,
                                    );
                                    $e=$e+1;
                                } // Rek4
                                $objRek3[$d]=array(
                                    'kode_rekening'=>$row3->kode_rekening,
                                    'nama_rekening'=>$row3->nama_rekening,
                                    'jumlah_sebelum'=>$row3->jumlah_sebelum,
                                    'jumlah_setelah'=>$row3->jumlah_setelah,
                                    'bertambah_berkurang'=>$row3->bertambah_berkurang,
                                    'rek_4'=>$objRek4,
                                );
                                $d=$d+1;
                            } // Rek3
                            $objRek2[$c]=array(
                                'kode_rekening'=>$row2->kode_rekening,
                                'nama_rekening'=>$row2->nama_rekening,
                                'jumlah_sebelum'=>$row2->jumlah_sebelum,
                                'jumlah_setelah'=>$row2->jumlah_setelah,
                                'bertambah_berkurang'=>$row2->bertambah_berkurang,
                                'rek_3'=>$objRek3,
                        );
                        $c=$c+1;
                        $biaya_m_sebelum=$biaya_m_sebelum + $row2->jumlah_sebelum;
                        $biaya_m_setelah=$biaya_m_setelah + $row2->jumlah_setelah;
                        $biaya_m_bertambah_berkurang=$biaya_m_bertambah_berkurang + $row2->bertambah_berkurang;

                    } // Rek2

                    $rek21 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                    sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                    FROM
                    (
                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                        FROM 
                        (
                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=2 
                        ) A
                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                        UNION
                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                        FROM 
                        (
                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=2 
                        ) A
                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                    ) temp2
                    GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                    ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                    $c1=0;
                    $biaya_l_sebelum=$biaya_l_setelah=$biaya_l_bertambah_berkurang=0;
                    $objRek21=array();
                    foreach ($rek21 as $row21) {
                        $rek31 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                            sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                            FROM
                            (
                                SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                FROM 
                                (
                                    SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                    FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                    WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."
                                ) A
                                GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                UNION
                                SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                FROM 
                                (
                                    SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                    FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                    WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."
                                ) A
                                GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                            ) temp2
                            GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                            ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");
                        $d1=0;
                        $objRek31=array();
                        foreach ($rek31 as $row31) {
                            $rek41 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                                    sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                                    FROM
                                    (
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                        FROM 
                                        (
                                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3."
                                        ) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        UNION
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                        FROM 
                                        (
                                            SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                            FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                            WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3."
                                        ) A
                                        GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                    ) temp2
                                    GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                                    ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");
                
                            $e1=0;
                            $objRek41=array();
                            foreach ($rek41 as $row41) {
                                $rek51 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
                                        sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
                                        FROM
                                        (
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                            UNION
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        ) temp2
                                        GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
                                        ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

                                $f1=0;
                                $objRek51=array();
                                foreach ($rek51 as $row51) {
                                    $rek61 = DB::SELECT("SELECT temp6.kdrek1, temp6.kdrek2, temp6.kdrek3,temp6.kdrek4,temp6.kdrek5, temp6.kode_rekening, temp6.nama_rekening, sum(temp6.jumlah_sebelum) as jumlah_sebelum, sum(temp6.jumlah_setelah) as jumlah_setelah,
                                    sum(temp6.jumlah_setelah)-sum(temp6.jumlah_sebelum) AS bertambah_berkurang
                                    FROM
                                    (
                                        SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row51->kdrek5."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                            UNION
                                            SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
                                            FROM 
                                            (
                                                SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
                                                FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
                                                WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (6)	AND SUBSTRING(a.ko_rkk,4,2)=".$row21->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row31->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row41->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row51->kdrek5."
                                            ) A
                                            GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
                                        ) temp6
                                        GROUP BY kdrek1,kdrek2,kdrek3,kdrek4,kdrek5,kdrek6,kode_rekening,nama_rekening
                                        ORDER BY kdrek1,kdrek2,kdrek3,kdrek4,kdrek5,kdrek6,kode_rekening,nama_rekening");

                                    $g1=0;
                                    $objRek61=array();
                                    foreach ($rek61 as $row61) {
                                        $objRek61[$g1]=array(
                                            'kode_rekening'=>$row61->kode_rekening,
                                            'nama_rekening'=>$row61->nama_rekening,
                                            'jumlah_sebelum'=>$row61->jumlah_sebelum,
                                            'jumlah_setelah'=>$row61->jumlah_setelah,
                                            'bertambah_berkurang'=>$row61->bertambah_berkurang,
                                        );
                                        $g1=$g1+1;
                                    } // Rek6
                                    $objRek51[$f1]=array(
                                        'kode_rekening'=>$row51->kode_rekening,
                                        'nama_rekening'=>$row51->nama_rekening,
                                        'jumlah_sebelum'=>$row51->jumlah_sebelum,
                                        'jumlah_setelah'=>$row51->jumlah_setelah,
                                        'bertambah_berkurang'=>$row51->bertambah_berkurang,
                                        'rek_6'=>$objRek61,
                                    );
                                    $f1=$f1+1;
                                } // Rek5
                                $objRek41[$e1]=array(
                                    'kode_rekening'=>$row41->kode_rekening,
                                    'nama_rekening'=>$row41->nama_rekening,
                                    'jumlah_sebelum'=>$row41->jumlah_sebelum,
                                    'jumlah_setelah'=>$row41->jumlah_setelah,
                                    'bertambah_berkurang'=>$row41->bertambah_berkurang,
                                    'rek_5'=>$objRek51,
                                );
                                $e1=$e1+1;
                            } // Rek4
                            $objRek31[$d1]=array(
                                'kode_rekening'=>$row31->kode_rekening,
                                'nama_rekening'=>$row31->nama_rekening,
                                'jumlah_sebelum'=>$row31->jumlah_sebelum,
                                'jumlah_setelah'=>$row31->jumlah_setelah,
                                'bertambah_berkurang'=>$row31->bertambah_berkurang,
                                'rek_4'=>$objRek41,
                            );
                            $d1=$d1+1;
                        } // Rek3
                        $objRek21[$c1]=array(
                            'kode_rekening'=>$row21->kode_rekening,
                            'nama_rekening'=>$row21->nama_rekening,
                            'jumlah_sebelum'=>$row21->jumlah_sebelum,
                            'jumlah_setelah'=>$row21->jumlah_setelah,
                            'bertambah_berkurang'=>$row21->bertambah_berkurang,
                            'rek_3'=>$objRek31,
                        );
                        $c1=$c1+1;
                        $biaya_l_sebelum=$biaya_l_sebelum + $row21->jumlah_sebelum;
                        $biaya_l_setelah=$biaya_l_setelah + $row21->jumlah_setelah;
                        $biaya_l_bertambah_berkurang=$biaya_l_bertambah_berkurang + $row21->bertambah_berkurang;
                    } // Rek2


                $obj[$a]=array(
                    'nama_pemda' => $pemda[0]->nmpemda,
                    'tahun'=>$tahun,
                    'kode_skpd'=>$kdskpd,
                    'uraian_skpd'=>$urskpd,
                    'kode_unit'=>$kdunit,
                    'uraian_unit'=>$urunit,
                    'rek_terima'=>$objRek2,
                    'jml_terima_sebelum'=>$biaya_m_sebelum,
                    'jml_terima_setelah'=>$biaya_m_setelah,
                    'jml_terima_bertambah_berkurang'=>$biaya_m_bertambah_berkurang,
                    'rek_keluar'=>$objRek21,
                    'jml_keluar_sebelum'=>$biaya_l_sebelum,
                    'jml_keluar_setelah'=>$biaya_l_setelah,
                    'jml_keluar_bertambah_berkurang'=>$biaya_l_bertambah_berkurang,
                    'jml_biaya_netto_sebelum'=>$biaya_m_sebelum - $biaya_l_sebelum,
                    'jml_biaya_netto_setelah'=>$biaya_m_setelah - $biaya_l_setelah,
                    'jml_biaya_netto_bertambah_berkurang'=>$biaya_m_bertambah_berkurang - $biaya_l_bertambah_berkurang,
                );

            }
		}// tutup else (selain apbd murni)

        return $obj;
    }
}
