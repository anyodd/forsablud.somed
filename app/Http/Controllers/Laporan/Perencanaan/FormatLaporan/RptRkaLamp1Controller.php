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

class RptRkaLamp1Controller extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.perencanaan.cetak-rka';
    }

    public static function Laporan($tahun, $rkaperubahan = null)
    {
        $pemda = DB::select("SELECT CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) AS Ko_pemda, ur_pemda AS nmpemda 
							FROM tb_pemda
							WHERE CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) = LEFT('".kd_unit()."',5)
							ORDER BY ko_wil1, ko_wil2 ");
        $tahun = $tahun;
		
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
		
		if($rkaperubahan==null){

		foreach ($unit as $row0) {
			$rek1 = DB::SELECT("SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
				FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
				FROM tb_ang_rc a INNER JOIN pf_rk1 i ON LEFT(a.ko_rkk,2)=i.Ko_Rk1
				WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (4,5)	) A
				GROUP BY A.kdrek1, A.nmrek1
				ORDER BY A.kdrek1, A.nmrek1");

			$b=0;
			$pdt=0;
			$blj=0;
			$biaya_m=0;
			$biaya_l=0;
			$objRek1=array();
			foreach ($rek1 as $row) {
				$rek2 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
					FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
					FROM tb_ang_rc a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
					WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row->kdrek1."	) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					ORDER BY A.kdrek1, A.kdrek2, A.nmrek2");

					$c=0;
					$objRek2=array();
					foreach ($rek2 as $row2) {
						$rek3 = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
							FROM tb_ang_rc a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3");

						$d=0;
						$objRek3=array();
						foreach ($rek3 as $row3) {
							$objRek3[$d]=array(
								'kode_rekening'=>$row3->kode_rekening,
								'nama_rekening'=>$row3->nama_rekening,
								'jumlah'=>$row3->jumlah,
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
					} // Rek2
					$objRek1[$b]=array(
						'kode_rekening'=>$row->kode_rekening,
						'nama_rekening'=>$row->nama_rekening,
						'jumlah'=>$row->jumlah,
						'rek_2'=>$objRek2,
					);
					$b=$b+1;
				if($row->kdrek1 == 4){
					$pdt = $pdt + $row->jumlah;
				}
				if($row->kdrek1 == 5){
					$blj = $blj + $row->jumlah;
				}
			} // Rek1

			$rek1b = DB::SELECT("SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
				FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
				FROM tb_ang_rc a INNER JOIN pf_rk1 i ON LEFT(a.ko_rkk,2)=i.Ko_Rk1
				WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (6)	) A
				GROUP BY A.kdrek1, A.nmrek1
				ORDER BY A.kdrek1, A.nmrek1");

			$e=0;
			$objRek1b=array();
			foreach ($rek1b as $row1m) {
				$rek2b = DB::SELECT("SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
					FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
					FROM tb_ang_rc a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
					WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row1m->kdrek1."	) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					ORDER BY A.kdrek1, A.kdrek2, A.nmrek2");

					$f=0;
					$objRek2b=array();
					foreach ($rek2b as $row2m) {
						$rek3b = DB::SELECT("SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
							FROM tb_ang_rc a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row1m->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2m->kdrek2."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							ORDER BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3");

						$g=0;
						$objRek3b=array();
						foreach ($rek3b as $row3m) {
							$objRek3b[$g]=array(
								'kode_rekening'=>$row3m->kode_rekening,
								'nama_rekening'=>$row3m->nama_rekening,
								'jumlah'=>$row3m->jumlah,
							);
							$g=$g+1;
						} // Rek3
					$objRek2b[$f]=array(
						'kode_rekening'=>$row2m->kode_rekening,
						'nama_rekening'=>$row2m->nama_rekening,
						'jumlah'=>$row2m->jumlah,
						'rek_3'=>$objRek3b,
					);
					$f=$f+1;

					if($row2m->kdrek1 == 6 && $row2m->kdrek2 == 1){
						$biaya_m = $biaya_m + $row2m->jumlah;
					}
					if($row2m->kdrek1 == 6 && $row2m->kdrek2 == 2){
						$biaya_l = $biaya_l + $row2m->jumlah;
					}
				} // Rek2
				$objRek1b[$e]=array(
					'kode_rekening'=>$row1m->kode_rekening,
					'nama_rekening'=>$row1m->nama_rekening,
					'jumlah'=>$row1m->jumlah,
					'rek_2'=>$objRek2b,
				);
				$e=$e+1;
			} // Rek1

			$obj[$a]=array(
				'nama_pemda'=>$pemda[0]->nmpemda,
				'tahun'=>$tahun,
				'kode_skpd'=>$kdskpd,
				'uraian_skpd'=>$urskpd,
				'kode_unit'=>$kdunit,
				'uraian_unit'=>$urunit,
				'rek_1'=>$objRek1,
				'rek_16'=>$objRek1b,
				'jml_pendapatan'=>$pdt,
				'jml_belanja'=>$blj,
				'surplus'=>$pdt - $blj,
				'jml_biaya_m'=>$biaya_m,
				'jml_biaya_l'=>$biaya_l,
				'jml_biaya_netto'=>$biaya_m - $biaya_l,
				'silpa'=> $pdt - $blj + $biaya_m - $biaya_l,
				'rkaperubahan'=>$rkaperubahan,
			);

			} //dokumen
		//end for each
		}
		else{
		//mulai for each
		foreach ($unit as $row0) {	
			$dok = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=2 AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".$row0->kode_unit."' ");

			$rek1 = DB::SELECT("SELECT temp1.kdrek1,temp1.kode_rekening,temp1.nama_rekening,sum(temp1.jumlah_sebelum) as jumlah_sebelum,sum(temp1.jumlah_setelah) as jumlah_setelah,
			sum(temp1.jumlah_setelah)-sum(temp1.jumlah_sebelum) AS bertambah_berkurang
			FROM
			( 	SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, 0 AS jumlah_sebelum,COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
				FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
						FROM tb_ang_rc a INNER JOIN pf_rk1 i ON LEFT(a.ko_rkk,2)=i.Ko_Rk1
						WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (4,5)	) A
				GROUP BY A.kdrek1, A.nmrek1
				UNION
				SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
				FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
						FROM tb_tap a INNER JOIN pf_rk1 i ON a.Ko_Rk1=i.Ko_Rk1
						WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1 IN (4,5)
						AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
				GROUP BY A.kdrek1, A.nmrek1
			) temp1
			GROUP BY kdrek1,kode_rekening,nama_rekening
			ORDER BY kdrek1,kode_rekening,nama_rekening");

			$b=0;
			$pdt_sebelum=$pdt_setelah=$pdt_bertambah_berkurang=0;
			$blj_sebelum=$blj_setelah=$blj_bertambah_berkurang=0;
			$biaya_m_sebelum=$biaya_m_setelah=$biaya_m_bertambah_berkurang=0;
			$biaya_l_sebelum=$biaya_l_setelah=$biaya_l_bertambah_berkurang=0;
			$objRek1=array();
			foreach ($rek1 as $row) {
				$rek2 = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
				sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
				FROM
				( 	SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
						FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
							FROM tb_ang_rc a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row->kdrek1."	) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					UNION
					SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah, 0 AS jumlah_setelah
						FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
						FROM tb_tap a INNER JOIN pf_rk2 f ON a.Ko_Rk1=f.Ko_Rk1 AND a.Ko_Rk2=f.Ko_Rk2
						WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1=".$row->kdrek1."
						AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
					GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
				) temp2
				GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
				ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

					$c=0;
					$objRek2=array();
					foreach ($rek2 as $row2) {
						$rek3 = DB::SELECT("SELECT temp3.kdrek1,temp3.kdrek2,temp3.kdrek3,temp3.kode_rekening,temp3.nama_rekening,sum(temp3.jumlah_sebelum) AS jumlah_sebelum,
						sum(temp3.jumlah_setelah) AS jumlah_setelah, sum(temp3.jumlah_setelah)-sum(temp3.jumlah_sebelum) AS bertambah_berkurang
						FROM
						( 	SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening,
							0 AS jumlah_sebelum ,COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
								FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
									FROM tb_ang_rc a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
									WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2->kdrek2."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							UNION
							SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening,
							COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
								FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
								FROM tb_tap a INNER JOIN pf_rk3 e ON a.Ko_Rk1=e.Ko_Rk1 AND a.Ko_Rk2=e.Ko_Rk2 AND a.Ko_Rk3=e.Ko_Rk3
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1=".$row->kdrek1." AND a.Ko_Rk2=".$row2->kdrek2."
								AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
						) temp3
						GROUP BY kdrek1,kdrek2,kdrek3,kode_rekening,nama_rekening
						ORDER BY kdrek1,kdrek2,kdrek3,kode_rekening,nama_rekening");

						$d=0;
						$objRek3=array();
						foreach ($rek3 as $row3) {
							$objRek3[$d]=array(
								'kode_rekening'=>$row3->kode_rekening,
								'nama_rekening'=>$row3->nama_rekening,
								'jumlah_sebelum'=>$row3->jumlah_sebelum,
								'jumlah_setelah'=>$row3->jumlah_setelah,
								'bertambah_berkurang'=>$row3->bertambah_berkurang,
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
					} // Rek2
					$objRek1[$b]=array(
						'kode_rekening'=>$row->kode_rekening,
						'nama_rekening'=>$row->nama_rekening,
						'jumlah_sebelum'=>$row->jumlah_sebelum,
						'jumlah_setelah'=>$row->jumlah_setelah,
						'bertambah_berkurang'=>$row->bertambah_berkurang,
						'rek_2'=>$objRek2,
					);
					$b=$b+1;
					if($row->kdrek1 == 4){
						$pdt_sebelum = $pdt_sebelum + $row->jumlah_sebelum;
						$pdt_setelah = $pdt_setelah + $row->jumlah_setelah;
						$pdt_bertambah_berkurang = $pdt_bertambah_berkurang + $row->bertambah_berkurang;
					}
					if($row->kdrek1 == 5){
						$blj_sebelum = $blj_sebelum + $row->jumlah_sebelum;
						$blj_setelah = $blj_setelah + $row->jumlah_setelah;
						$blj_bertambah_berkurang = $blj_bertambah_berkurang + $row->bertambah_berkurang;
					}
				} // Rek1

				$rek1b = DB::SELECT("SELECT temp1.kdrek1,temp1.kode_rekening,temp1.nama_rekening,sum(temp1.jumlah_sebelum) as jumlah_sebelum,sum(temp1.jumlah_setelah) as jumlah_setelah,
				sum(temp1.jumlah_setelah)-sum(temp1.jumlah_sebelum) AS bertambah_berkurang
				FROM
				( 	SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, 0 AS jumlah_sebelum,COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
					FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
							FROM tb_ang_rc a INNER JOIN pf_rk1 i ON LEFT(a.ko_rkk,2)=i.Ko_Rk1
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (6)	) A
					GROUP BY A.kdrek1, A.nmrek1
					UNION
					SELECT A.kdrek1 AS kdrek1, A.kdrek1 AS kode_rekening, A.nmrek1 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
					FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, i.Ur_Rk1 AS nmrek1, a.To_Rp AS jumlah
							FROM tb_tap a INNER JOIN pf_rk1 i ON a.Ko_Rk1=i.Ko_Rk1
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1 IN (6)
							AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
					GROUP BY A.kdrek1, A.nmrek1
				) temp1
				GROUP BY kdrek1,kode_rekening,nama_rekening
				ORDER BY kdrek1,kode_rekening,nama_rekening");

				$e=0;
				$objRek1b=array();
				foreach ($rek1b as $row1m) {
					$rek2b = DB::SELECT("SELECT temp2.kdrek1, temp2.kdrek2, temp2.kode_rekening, temp2.nama_rekening, sum(temp2.jumlah_sebelum) as jumlah_sebelum, sum(temp2.jumlah_setelah) as jumlah_setelah,
					sum(temp2.jumlah_setelah)-sum(temp2.jumlah_sebelum) AS bertambah_berkurang
					FROM
					( 	SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, 0 AS jumlah_sebelum, COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
						FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
							FROM tb_ang_rc a INNER JOIN pf_rk2 f ON LEFT(a.ko_rkk,2)=f.Ko_Rk1 AND  SUBSTRING(a.ko_rkk,4,2) = f.Ko_Rk2
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row1m->kdrek1."	) A
						GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
						UNION
						SELECT A.kdrek1, A.kdrek2, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, A.nmrek2 AS nama_rekening, COALESCE(SUM(A.jumlah),0) AS jumlah, 0 AS jumlah_setelah
							FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, f.Ur_Rk2 AS nmrek2, a.To_Rp AS jumlah
							FROM tb_tap a INNER JOIN pf_rk2 f ON a.Ko_Rk1=f.Ko_Rk1 AND a.Ko_Rk2=f.Ko_Rk2
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1=".$row1m->kdrek1."
							AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
						GROUP BY A.kdrek1, A.kdrek2, A.nmrek2
					) temp2
					GROUP BY kdrek1,kdrek2,kode_rekening,nama_rekening
					ORDER BY kdrek1,kdrek2,kode_rekening,nama_rekening");

						$f=0;
						$objRek2b=array();
						foreach ($rek2b as $row2m) {
							$rek3b = DB::SELECT("SELECT temp3.kdrek1,temp3.kdrek2,temp3.kdrek3,temp3.kode_rekening,temp3.nama_rekening,sum(temp3.jumlah_sebelum) AS jumlah_sebelum,
							sum(temp3.jumlah_setelah) AS jumlah_setelah, sum(temp3.jumlah_setelah)-sum(temp3.jumlah_sebelum) AS bertambah_berkurang
							FROM
							( 	SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening,
								0 AS jumlah_sebelum ,COALESCE(SUM(A.jumlah),0) AS jumlah_setelah
									FROM ( SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
										FROM tb_ang_rc a INNER JOIN pf_rk3 e ON LEFT(a.ko_rkk,2)=e.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = e.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = e.Ko_Rk3
										WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2)=".$row1m->kdrek1." AND SUBSTRING(a.ko_rkk,4,2)=".$row2m->kdrek2."	) A
								GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
								UNION
								SELECT A.kdrek1, A.kdrek2, A.kdrek3, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, A.nmrek3 AS nama_rekening,
								COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum, 0 AS jumlah_setelah
									FROM (  SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, e.Ur_Rk3 AS nmrek3, a.To_Rp AS jumlah
									FROM tb_tap a INNER JOIN pf_rk3 e ON a.Ko_Rk1=e.Ko_Rk1 AND a.Ko_Rk2=e.Ko_Rk2 AND a.Ko_Rk3=e.Ko_Rk3
									WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_Rk1=".$row1m->kdrek1." AND a.Ko_Rk2=".$row2m->kdrek2."
									AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap."	) A
								GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.nmrek3
							) temp3
							GROUP BY kdrek1,kdrek2,kdrek3,kode_rekening,nama_rekening
							ORDER BY kdrek1,kdrek2,kdrek3,kode_rekening,nama_rekening");

							$g=0;
							$objRek3b=array();
							foreach ($rek3b as $row3m) {
								$objRek3b[$g]=array(
									'kode_rekening'=>$row3m->kode_rekening,
									'nama_rekening'=>$row3m->nama_rekening,
									'jumlah_sebelum'=>$row3m->jumlah_sebelum,
									'jumlah_setelah'=>$row3m->jumlah_setelah,
									'bertambah_berkurang'=>$row3m->bertambah_berkurang,
								);
								$g=$g+1;
							} // Rek3
						$objRek2b[$f]=array(
							'kode_rekening'=>$row2m->kode_rekening,
							'nama_rekening'=>$row2m->nama_rekening,
							'jumlah_sebelum'=>$row2m->jumlah_sebelum,
							'jumlah_setelah'=>$row2m->jumlah_setelah,
							'bertambah_berkurang'=>$row2m->bertambah_berkurang,
							'rek_3'=>$objRek3b,
						);
						$f=$f+1;

						if($row2m->kdrek1 == 6 && $row2m->kdrek2 == 1){
							$biaya_m_sebelum = $biaya_m_sebelum + $row2m->jumlah_sebelum;
							$biaya_m_setelah = $biaya_m_setelah + $row2m->jumlah_setelah;
							$biaya_m_bertambah_berkurang = $biaya_m_bertambah_berkurang + $row2m->bertambah_berkurang;
						}

						if($row2m->kdrek1 == 6 && $row2m->kdrek2 == 2){
							$biaya_l_sebelum = $biaya_l_sebelum + $row2m->jumlah_sebelum;
							$biaya_l_setelah = $biaya_l_setelah + $row2m->jumlah_setelah;
							$biaya_l_bertambah_berkurang = $biaya_l_bertambah_berkurang + $row2m->bertambah_berkurang;
						}
					} // Rek2
				$objRek1b[$e]=array(
					'kode_rekening'=>$row1m->kode_rekening,
					'nama_rekening'=>$row1m->nama_rekening,
					'jumlah_sebelum'=>$row1m->jumlah_sebelum,
					'jumlah_setelah'=>$row1m->jumlah_setelah,
					'bertambah_berkurang'=>$row1m->bertambah_berkurang,
					'rek_2'=>$objRek2b,
				);
				$e=$e+1;
			} // Rek1

			$obj[$a]=array(
				'nama_pemda'=>$pemda[0]->nmpemda,
				'tahun'=>$tahun,
				'kode_skpd'=>$kdskpd,
				'uraian_skpd'=>$urskpd,
				'kode_unit'=>$kdunit,
				'uraian_unit'=>$urunit,
				'rek_1'=>$objRek1,
				'rek_16'=>$objRek1b,
				'jml_pendapatan_sebelum'=>$pdt_sebelum,
				'jml_pendapatan_setelah'=>$pdt_setelah,
				'jml_pendapatan_bertambah_berkurang'=>$pdt_bertambah_berkurang,
				'jml_belanja_sebelum'=>$blj_sebelum,
				'jml_belanja_setelah'=>$blj_setelah,
				'jml_belanja_bertambah_berkurang'=>$blj_bertambah_berkurang,
				'surplus_sebelum'=>$pdt_sebelum - $blj_sebelum,
				'surplus_setelah'=>$pdt_setelah - $blj_setelah,
				'surplus_bertambah_berkurang'=>$pdt_bertambah_berkurang - $blj_bertambah_berkurang,
				'jml_biaya_m_sebelum'=>$biaya_m_sebelum,
				'jml_biaya_m_setelah'=>$biaya_m_setelah,
				'jml_biaya_m_bertambah_berkurang'=>$biaya_m_bertambah_berkurang,
				'jml_biaya_l_sebelum'=>$biaya_l_sebelum,
				'jml_biaya_l_setelah'=>$biaya_l_setelah,
				'jml_biaya_l_bertambah_berkurang'=>$biaya_l_bertambah_berkurang,
				'jml_biaya_netto_sebelum'=>$biaya_m_sebelum - $biaya_l_sebelum,
				'jml_biaya_netto_setelah'=>$biaya_m_setelah - $biaya_l_setelah,
				'jml_biaya_netto_bertambah_berkurang'=>$biaya_m_bertambah_berkurang - $biaya_l_bertambah_berkurang,
				'silpa_sebelum'=> $pdt_sebelum - $blj_sebelum + $biaya_m_sebelum - $biaya_l_sebelum,
				'silpa_setelah'=> $pdt_setelah - $blj_setelah + $biaya_m_setelah - $biaya_l_setelah,
				'silpa_bertambah_berkurang'=> $pdt_bertambah_berkurang - $blj_bertambah_berkurang + $biaya_m_bertambah_berkurang - $biaya_l_bertambah_berkurang,
				'rkaperubahan'=>$rkaperubahan,
			);

			} //dokumen
		//end for each
		}
		//tutup else jika tercentang
        return $obj;
    }
}
