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

class RptDpaLamp2Controller extends Controller
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
		
		$a = 0;
        $obj = array();
		if($idjnsdokumen_req==2){
		foreach ($unit as $row0) {
			$rek1 = DB::SELECT("SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
				FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
				FROM tb_tap a INNER JOIN pf_rk1 i ON LEFT(a.ko_rkk,2)=i.Ko_Rk1
				WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (4)	) A
				GROUP BY A.kdrek1, A.nmrek1
				ORDER BY A.kdrek1, A.nmrek1");

            $b = 0;
            $pdt = 0;
            $blj = 0;
            $biaya_m = 0;
            $biaya_l = 0;
            $objRek1 = array();
            foreach ($rek1 as $row) {
                $rek2 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
					FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
					FROM tb_tap a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
					WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=".$row->kdrek1."	) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					ORDER BY A.kdrek1, A.kdrek2, A.nmrek2");

                $c = 0;
                $objRek2 = array();
                foreach ($rek2 as $row2) {
                    $rek3 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
							FROM tb_tap a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3");

                    $d = 0;
                    $objRek3 = array();
                    foreach ($rek3 as $row3) {
                        $rek4 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening, A.nmrek4 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
								FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, d.Ur_Rk4 AS nmrek4, a.To_Rp AS jumlah
								FROM tb_tap a INNER JOIN pf_rk4 d ON LEFT(a.ko_rkk,2)=d.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = d.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = d.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = d.Ko_Rk4
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3."	) A
								GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4
								ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.nmrek4");

                        $e = 0;
                        $objRek4 = array();
                        foreach ($rek4 as $row4) {
                            $rek5 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4,  A.kdrek5, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening, A.nmrek5 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
                                FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, c.Ur_Rk5 AS nmrek5, a.To_Rp AS jumlah
								FROM tb_tap a INNER JOIN pf_rk5 c ON LEFT(a.ko_rkk,2)=c.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = c.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = c.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = c.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = c.Ko_Rk5 
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4."	) A
                                GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5
                                ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.nmrek5");

                            $f = 0;
                            $objRek5 = array();
                            foreach ($rek5 as $row5) {
                                $rek6 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5,A.kdrek6,
                                    CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening,
                                    A.nmrek6 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah, COALESCE(SUM(A.jml_volume),0) AS volume, COALESCE(SUM(A.harga),0) AS harga, A.satuan
                                    FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga 
									FROM tb_tap a INNER JOIN ". $pf_rk6 . " b ON LEFT(a.ko_rkk,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
									WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	AND SUBSTRING(a.Ko_Rkk,7,2)=".$row3->kdrek3." AND SUBSTRING(a.Ko_Rkk,10,3)=".$row4->kdrek4." AND SUBSTRING(a.Ko_Rkk,13,3)=".$row5->kdrek5."	) A
                                    GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan
                                    ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.satuan");

                                $g = 0;
                                $objRek6 = array();
                                foreach ($rek6 as $row6) {
                                    $objRek6[$g] = array(
                                        'kode_rekening' => $row6->kode_rekening,
                                        'nama_rekening' => $row6->nama_rekening,
                                        'volume' => $row6->volume,
                                        'harga' => $row6->harga,
                                        'satuan' => $row6->satuan,
                                        'jumlah' => $row6->jumlah,
                                    );
                                    $g = $g + 1;
                                } // Rek6
                                $objRek5[$f] = array(
                                    'kode_rekening' => $row5->kode_rekening,
                                    'nama_rekening' => $row5->nama_rekening,
                                    'jumlah' => $row5->jumlah,
                                    'rek_6' => $objRek6,
                                );
                                $f = $f + 1;
                            } // Rek5
                            $objRek4[$e] = array(
                                'kode_rekening' => $row4->kode_rekening,
                                'nama_rekening' => $row4->nama_rekening,
                                'jumlah' => $row4->jumlah,
                                'rek_5' => $objRek5,
                            );
                            $e = $e + 1;
                        } // Rek4
                        $objRek3[$d] = array(
                            'kode_rekening' => $row3->kode_rekening,
                            'nama_rekening' => $row3->nama_rekening,
                            'jumlah' => $row3->jumlah,
                            'rek_4' => $objRek4,
                        );
                        $d = $d + 1;
                    } // Rek3
                    $objRek2[$c] = array(
                        'kode_rekening' => $row2->kode_rekening,
                        'nama_rekening' => $row2->nama_rekening,
                        'jumlah' => $row2->jumlah,
                        'rek_3' => $objRek3,
                    );
                    $c = $c + 1;
                } // Rek2
                $objRek1[$b] = array(
                    'kode_rekening' => $row->kode_rekening,
                    'nama_rekening' => $row->nama_rekening,
                    'jumlah' => $row->jumlah,
                    'rek_2' => $objRek2,
                );
                $b = $b + 1;
                if ($row->kdrek1 == 4) {
                    $pdt = $pdt + $row->jumlah;
                }
            } // Rek1

            $obj[$a] = array(
                'nama_pemda' => $pemda[0]->nmpemda,
                'tahun' => $tahun,
                'kode_skpd' => $kdskpd,
                'uraian_skpd' => $urskpd,
                'kode_unit' => $kdunit,
                'uraian_unit' => $urunit,
                'rek_1' => $objRek1,
                'jml_pendapatan' => $pdt,
            );
        } //dokumen
    }
    else{
    foreach ($unit as $row0) {
		$dok = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=2 AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".$row0->kode_unit."' ");

		$query = DB::select("WITH rincbelanja_arsip AS ( SELECT LEFT('".$kdskpd."',5) AS kode_bid, '".$kdskpd."' AS kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, 
					A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6, A.kdrek1 AS kode_rekening1, A.nmrek1, 
					CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, 
					0 AS jml_volume_sebelum, COALESCE(SUM(A.jml_volume),0) AS jml_volume_setelah, 0 AS harga_sebelum, COALESCE(SUM(A.harga),0) AS harga_setelah, '' AS satuan_sebelum, A.satuan AS satuan_setelah,
					0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
					FROM (
							SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
							i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
							a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram
							FROM tb_tap AS a LEFT JOIN
							". $pf_rk6 . " b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6 INNER JOIN
							pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
							pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
							pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3 INNER JOIN
							pf_rk2 f ON e.Ko_Rk1 = f.Ko_Rk1 AND e.Ko_Rk2 = f.Ko_Rk2 INNER JOIN
							pf_rk1 i ON f.Ko_Rk1 = i.Ko_Rk1 INNER JOIN
							tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
							tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
							tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
							pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
							pf_keg l ON k.id_keg=l.id_keg INNER JOIN
							pf_prg m ON l.id_prog=m.id_prog INNER JOIN
							pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
							pf_urus o ON n.id_urus=o.id_urus
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (4)
					) A
					GROUP BY A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
					A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.satuan
					UNION ALL
					SELECT LEFT('".$kdskpd."',5) AS kode_bid, '".$kdskpd."' AS kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, 
					A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.kdrek1 AS kode_rekening1, A.nmrek1, 
					CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, 
					COALESCE(SUM(A.jml_volume),0) AS jml_volume_sebelum, 0 AS jml_volume_setelah, COALESCE(SUM(A.harga),0) AS harga_sebelum, 0 AS harga_setelah, A.satuan AS satuan_sebelum, '' AS satuan_setelah,
					COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
					FROM (
							SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
							i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
							a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram
							FROM tb_tap AS a LEFT JOIN
							". $pf_rk6 . " b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6 INNER JOIN
							pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
							pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
							pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3 INNER JOIN
							pf_rk2 f ON e.Ko_Rk1 = f.Ko_Rk1 AND e.Ko_Rk2 = f.Ko_Rk2 INNER JOIN
							pf_rk1 i ON f.Ko_Rk1 = i.Ko_Rk1 INNER JOIN
							tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
							tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
							tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
							pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
							pf_keg l ON k.id_keg=l.id_keg INNER JOIN
							pf_prg m ON l.id_prog=m.id_prog INNER JOIN
							pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
							pf_urus o ON n.id_urus=o.id_urus
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (4) 
					) A
					GROUP BY A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
					A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.satuan
				)
				SELECT A.kode_rekening1 AS kode, A.nmrek1 AS uraian, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 1 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening1, A.nmrek1
				UNION
				SELECT A.kode_rekening1, A.nmprogram, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 2 AS kdlevel
				FROM rincbelanja_arsip A
				WHERE A.kode_rekening1 NOT IN (4,6)
				GROUP BY A.kode_rekening1, A.nmprogram
				UNION
				SELECT A.kode_rekening1, A.nmkegiatan, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 3 AS kdlevel
				FROM rincbelanja_arsip A
				WHERE A.kode_rekening1 NOT IN (4,6)
				GROUP BY A.kode_rekening1, A.nmkegiatan
				UNION
				SELECT A.kode_rekening1, A.nmsubkegiatan, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 4 AS kdlevel
				FROM rincbelanja_arsip A
				WHERE A.kode_rekening1 NOT IN (4,6)
				GROUP BY A.kode_rekening1, A.nmsubkegiatan
				UNION
				SELECT A.kode_rekening2, A.nmrek2,
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 5 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening2, A.nmrek2
				UNION
				SELECT A.kode_rekening3, A.nmrek3, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 6 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening3, A.nmrek3
				UNION
				SELECT A.kode_rekening4, A.nmrek4, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 7 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening4, A.nmrek4
				UNION
				SELECT A.kode_rekening5, A.nmrek5, 
				0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
				0 AS harga_sebelum, 0 AS harga_setelah,
				'' AS satuan_sebelum, '' AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 8 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening5, A.nmrek5
				UNION
				SELECT A.kode_rekening6, A.nmrek6, 
				SUM(A.jml_volume_sebelum) AS jml_volume_sebelum, SUM(A.jml_volume_setelah) AS jml_volume_setelah, 
				SUM(A.harga_sebelum) AS harga_sebelum, SUM(A.harga_setelah) AS harga_setelah,
				MAX(A.satuan_sebelum) AS satuan_sebelum, MAX(A.satuan_setelah) AS satuan_setelah,
				SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang , 9 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_rekening6, A.nmrek6
				ORDER BY kode, kdlevel");

			$obj[$a]=array(
				'nama_pemda' => $pemda[0]->nmpemda,
                'tahun' => $tahun,
                'kode_skpd' => $kdskpd,
                'uraian_skpd' => $urskpd,
                'kode_unit' => $kdunit,
                'uraian_unit' => $urunit,
                'pendapatan_perubahan' => $query,
			);

			} //dokumen
		}// tutup else
        return $obj;
    }
}
