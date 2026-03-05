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

class RptDpaLamp4Controller extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.perencanaan.cetak-dpa';
    }

    public static function Laporan($tahun, $idkegiatan, $idjnsdokumen_req, $idnorev)
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

			$keg = DB::SELECT("SELECT DISTINCT m.Ur_Prg AS nmprogram, m.Ko_Prg AS kode_program, l.Ur_Keg AS nmkegiatan, l.Ko_Prg AS idprogram, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg) AS kode_kegiatan
						FROM tb_tap AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
						pf_keg l ON k.id_keg=l.id_keg INNER JOIN
						pf_prg m ON l.id_prog=m.id_prog INNER JOIN
						pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
						pf_urus o ON n.id_urus=o.id_urus
						WHERE LEFT(j.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."' " )[0];

			$kdprogram = $keg->kode_program;
			$nmprogram = $keg->nmprogram;
			$kdkegiatan = $keg->kode_kegiatan;
			$nmkegiatan = $keg->nmkegiatan;

			$pagu = DB::SELECT("SELECT dat.Ko_urus AS Ko_urus, dat.kode_bid AS idbidang, dat.idunit, LEFT(dat.kode_subkegiatan,2) AS idprogram, LEFT(dat.kode_subkegiatan,7) AS idkegiatan,
				SUM(dat.jumlah) AS jml_belanja, SUM(dat.pagu_min) AS pagu_min, SUM(dat.pagu_plus) AS pagu_plus
				FROM (
						SELECT a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
						a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, '".$urunit."' AS idunit, 0 AS pagu_min, 0 AS pagu_plus
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
						WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
					) AS dat
				GROUP BY dat.Ko_urus, dat.kode_bid, dat.idunit, dat.kode_subkegiatan
				ORDER BY dat.kode_subkegiatan");

			$pagumin = $pagu[0]->pagu_min;
			$paguplus = $pagu[0]->pagu_plus;
			$paguskg = $pagu[0]->jml_belanja;

			if(!empty($pagu)){
				$pagumin = $pagu[0]->pagu_min;
				$paguplus = $pagu[0]->pagu_plus;
				$paguskg = $pagu[0]->jml_belanja;
			} else {
				$pagumin = 0;
				$paguplus = 0;
				$paguskg = 0;
			}

			$indKeg = DB::SELECT("SELECT '" . $idkegiatan."' AS kode, 'Hasil' AS nmindikator, 100 AS target_tahun2, 'Indikator Kegiatan' AS uraian, '%' AS singkatan");

			$ik=0;
			$objIk=array();
			foreach ($indKeg as $rowIk) {
				$objIk[$ik]=array(
					'nmindikator'=>$rowIk->nmindikator,
					'target'=>$rowIk->target_tahun2,
					'uraian_sat'=>$rowIk->uraian,
					'satuan'=>$rowIk->singkatan,
				);
				$ik=$ik+1;
			}// Indikator Kegiatan

			$indProg = DB::SELECT("SELECT '" . $idkegiatan."' AS kode, 'Capaian Program' AS nmindikator, 100 AS target_tahun2, 'Indikator Program' AS uraian, '%' AS singkatan");

			$ip=0;
			$objIp=array();
			foreach ($indProg as $rowIp) {
				$objIp[$ip]=array(
					'nmindikator'=>$rowIp->nmindikator,
					'target'=>$rowIp->target_tahun2,
					'uraian_sat'=>$rowIp->uraian,
					'satuan'=>$rowIp->singkatan,
				);
				$ip=$ip+1;
			}// Indikator Program

			$subkeg = DB::SELECT("SELECT dat.kode_subkegiatan, dat.nmsubkegiatan, dat.sumberdana, COALESCE(dat.nmlokasi,'Lokasi belum ditentukan') AS nmlokasi,  
				dat.mulai, dat.akhir, SUM(dat.jumlah) AS jml_belanja
				FROM 
				( SELECT 
					CASE 1
					WHEN 1 THEN 'Januari'
						WHEN 2 THEN 'Februari'
						WHEN 3 THEN 'Maret'
						WHEN 4 THEN 'April'
						WHEN 5 THEN 'Mei'
						WHEN 6 THEN 'Juni'
						WHEN 7 THEN 'Juli'
						WHEN 8 THEN 'Agustus'
						WHEN 9 THEN 'September'
						WHEN 10 THEN 'Oktober'
						WHEN 11 THEN 'Nopember'
						WHEN 12 THEN 'Desember'
					END AS mulai,
					CASE 12
						WHEN 1 THEN 'Januari'
						WHEN 2 THEN 'Februari'
						WHEN 3 THEN 'Maret'
						WHEN 4 THEN 'April'
						WHEN 5 THEN 'Mei'
						WHEN 6 THEN 'Juni'
						WHEN 7 THEN 'Juli'
						WHEN 8 THEN 'Agustus'
						WHEN 9 THEN 'September'
						WHEN 10 THEN 'Oktober'
						WHEN 11 THEN 'Nopember'
						WHEN 12 THEN 'Desember'
					END AS akhir, a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
					a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, CASE j.ko_dana WHEN 1 THEN 'APBD' WHEN 2 THEN 'BLUD' ELSE 'BOK' END AS sumberdana, '".$urunit."' AS nmlokasi, 0 AS pagu_min, 0 AS pagu_plus
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
					WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
				) AS dat
				GROUP BY dat.kode_subkegiatan, dat.nmsubkegiatan, dat.sumberdana, dat.nmlokasi, dat.mulai, dat.akhir
				ORDER BY dat.kode_subkegiatan");

			$su=0;
			$objSub=array();
			if(!empty($subkeg)) {
				foreach ($subkeg as $sk) {
				$indSubKeg = DB::SELECT("SELECT '".$sk->kode_subkegiatan."' AS kode, 'Keluaran' AS nmindikator, 100 AS target_tahun2, 'Indikator SubKegiatan' AS uraian, '%' AS singkatan");

				$is=0;
				$objIs=array();
				foreach ($indSubKeg as $rowIs) {
					$objIs[$is]=array(
						'nmindikator'=>$rowIs->nmindikator,
						'target'=>$rowIs->target_tahun2,
						'uraian_sat'=>$rowIs->uraian,
						'satuan'=>$rowIs->singkatan,
					);
					$is=$is+1;
				}// Indikator Sub Kegiatan

				$query = DB::select("WITH rincbelanja_arsip AS ( 
					SELECT CASE WHEN A.kode_bid='0-00' THEN LEFT(A.kode_skpd,4) ELSE A.kode_bid END AS kode_bid, A.kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6,
					CONVERT(A.kdrek1, CHAR) AS kode_rekening1, A.nmrek1, 
					CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6)) AS kode_rekening7, A.uraian_aktivitas, 
					CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6),'.',RIGHT(CONCAT('00000',A.Ko_Rc),6)) AS kode_rekening8, A.uraian_blj,
					COALESCE(SUM(A.jml_volume),0) AS jml_volume, 
					COALESCE(SUM(A.harga),0) AS harga, 
					CONVERT(A.satuan, CHAR) AS satuan,
					COALESCE(SUM(A.jumlah),0) AS jumlah
					FROM (
						SELECT a.Ko_Period AS tahun, '".$kdskpd."' AS kode_skpd, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, jjj.Ur_KegBL2 as uraian_aktivitas, a.Ko_sKeg2 AS idrefaktivitas, 
						LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
						i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, Ko_Rc, Ur_Rc1 AS uraian_blj,
						a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram
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
						WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg,'.',LPAD(k.Ko_sKeg,3,0))='".$sk->kode_subkegiatan."' 
					) A
					GROUP BY A.kode_bid, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
					A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.kode_skpd, A.satuan, A.uraian_blj, A.uraian_aktivitas, A.idrefaktivitas 
				)
				SELECT A.kode_bid AS kode_bid, A.kode_skpd AS kode_skpd, '00.0-00.000' AS kode_subkegiatan, A.kode_rekening1 AS kode, A.nmrek1 AS uraian, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 1 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_rekening1, A.nmrek1
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening2, A.nmrek2,
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 5 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening2, A.nmrek2
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening3, A.nmrek3, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 6 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening3, A.nmrek3
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening4, A.nmrek4, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 7 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening4, A.nmrek4
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening5, A.nmrek5, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 8 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening5, A.nmrek5
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening6, A.nmrek6, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 9 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening6, A.nmrek6
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening7, A.uraian_aktivitas AS uraian_aktivitas, 
				0 AS jml_volume, 0 AS harga, '' AS satuan, SUM(A.jumlah) AS jumlah, 10 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening7, A.uraian_aktivitas
				UNION
				SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening8, A.uraian_blj AS uraian_blj, 
				SUM(A.jml_volume) AS jml_volume, SUM(A.harga) AS harga, MAX(A.satuan) AS satuan, 
				SUM(A.jumlah) AS jumlah, 11 AS kdlevel
				FROM rincbelanja_arsip A
				GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening8, A.uraian_blj
				ORDER BY kode_bid, kode_subkegiatan, kode, kdlevel");
			
					$objSub[$su]=array(
						'kdsubkegiatan'=>$sk->kode_subkegiatan,
						'nmsubkegiatan'=>$sk->nmsubkegiatan,
						'mulai'=>$sk->mulai,
						'akhir'=>$sk->akhir,
						'sumberdana'=>$sk->sumberdana,
						'lokasi'=>$sk->nmlokasi,
						'jumlah'=>$sk->jml_belanja,
						'keluaran'=>$objIs,
						'rincian'=>$query,
					);
					$su=$su+1;
				} // subkegiatan
			}

			$obj[$a]=array(
				'nama_pemda'=>$pemda[0]->nmpemda,
				'tahun'=>$tahun,
				'kdurusan'=>$kode_urusan,
				'nmurusan'=>$nmurusan,
				'kdbidang'=>$kode_bidang,
				'nmbidang'=>$nmbidang,
				'kdprogram'=>$kdprogram,
				'nmprogram'=>$nmprogram,
				'kdkegiatan'=>$kdkegiatan,
				'nmkegiatan'=>$nmkegiatan,
				'kode_skpd'=>$kdskpd,
				'uraian_skpd'=>$urskpd,
				'kode_unit'=>$kdunit,
				'uraian_unit'=>$urunit,
				'pagumin'=>$pagumin,
				'paguskg'=>$paguskg,
				'paguplus'=>$paguplus,
				'keluaran'=>$objIk,
				'hasil'=>$objIp,
				'subkeg'=>$objSub,
	   
			);

			} //dokumen
		}//tutup 
		else{
			foreach ($unit as $row0) {
				$dok = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=2 AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".$row0->kode_unit."' ");

				$keg = DB::SELECT("SELECT DISTINCT m.Ur_Prg AS nmprogram, m.Ko_Prg AS kode_program, l.Ur_Keg AS nmkegiatan, l.Ko_Prg AS idprogram, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg) AS kode_kegiatan
							FROM tb_tap AS a INNER JOIN
							tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
							tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
							tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
							pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
							pf_keg l ON k.id_keg=l.id_keg INNER JOIN
							pf_prg m ON l.id_prog=m.id_prog INNER JOIN
							pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
							pf_urus o ON n.id_urus=o.id_urus
							WHERE LEFT(j.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."' " )[0];

				$kdprogram = $keg->kode_program;
				$nmprogram = $keg->nmprogram;
				$kdkegiatan = $keg->kode_kegiatan;
				$nmkegiatan = $keg->nmkegiatan;

				$pagu = DB::SELECT("SELECT dat.Ko_urus AS Ko_urus, dat.kode_bid AS idbidang, dat.idunit, LEFT(dat.kode_subkegiatan,2) AS idprogram, LEFT(dat.kode_subkegiatan,7) AS idkegiatan,
					SUM(dat.jumlah) AS jml_belanja, SUM(dat.pagu_min) AS pagu_min, SUM(dat.pagu_plus) AS pagu_plus
					FROM (
							SELECT a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
							a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, '".$urunit."' AS idunit, 0 AS pagu_min, 0 AS pagu_plus
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
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
						) AS dat
					GROUP BY dat.Ko_urus, dat.kode_bid, dat.idunit, dat.kode_subkegiatan
					ORDER BY dat.kode_subkegiatan");

				$pagumin = $pagu[0]->pagu_min;
				$paguplus = $pagu[0]->pagu_plus;
				$paguskg = $pagu[0]->jml_belanja;

				if(!empty($pagu)){
					$pagumin = $pagu[0]->pagu_min;
					$paguplus = $pagu[0]->pagu_plus;
					$paguskg = $pagu[0]->jml_belanja;
				} else {
					$pagumin = 0;
					$paguplus = 0;
					$paguskg = 0;
				}

				$pagu_sebelum = DB::SELECT("SELECT dat.Ko_urus AS Ko_urus, dat.kode_bid AS idbidang, dat.idunit, LEFT(dat.kode_subkegiatan,2) AS idprogram, LEFT(dat.kode_subkegiatan,7) AS idkegiatan,
					SUM(dat.jumlah) AS jml_belanja, SUM(dat.pagu_min) AS pagu_min, SUM(dat.pagu_plus) AS pagu_plus
					FROM (
							SELECT a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
							a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, '".$urunit."' AS idunit, 0 AS pagu_min, 0 AS pagu_plus
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
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
						) AS dat
					GROUP BY dat.Ko_urus, dat.kode_bid, dat.idunit, dat.kode_subkegiatan
					ORDER BY dat.kode_subkegiatan");

				if(!empty($pagu_sebelum)){
				$pagumin_sebelum = $pagu_sebelum[0]->pagu_min;
				$paguplus_sebelum = $pagu_sebelum[0]->pagu_plus;
				$paguskg_sebelum = $pagu_sebelum[0]->jml_belanja;
				} else {
				$pagumin_sebelum = 0;
				$paguplus_sebelum = 0;
				$paguskg_sebelum = 0;
				}

				$indKeg = DB::SELECT("SELECT '" . $idkegiatan."' AS kode, 'Hasil' AS nmindikator_sebelum, 100 AS target_tahun2_sebelum, 'Indikator Kegiatan' AS uraian_sebelum, '%' AS singkatan_sebelum, 'Hasil' AS nmindikator_sesudah, 100 AS target_tahun2_sesudah, 'Indikator Kegiatan' AS uraian_sesudah, '%' AS singkatan_sesudah");

				$ik=0;
				$objIk=array();
				foreach ($indKeg as $rowIk) {
					$objIk[$ik]=array(
						'nmindikator_sebelum' => $rowIk->nmindikator_sebelum,
						'target_sebelum' => $rowIk->target_tahun2_sebelum,
						'uraian_sat_sebelum' => $rowIk->uraian_sebelum,
						'satuan_sebelum' => $rowIk->singkatan_sebelum,
						'nmindikator_sesudah' => $rowIk->nmindikator_sesudah,
						'target_sesudah' => $rowIk->target_tahun2_sesudah,
						'uraian_sat_sesudah' => $rowIk->uraian_sesudah,
						'satuan_sesudah' => $rowIk->singkatan_sesudah,
					);
					$ik=$ik+1;
				}// Indikator Kegiatan

				$indProg = DB::SELECT("SELECT '" . $idkegiatan."' AS kode, 'Capaian Program' AS nmindikator_sebelum, 100 AS target_tahun2_sebelum, 'Indikator Program' AS uraian_sebelum, '%' AS singkatan_sebelum, 'Capaian Program' AS nmindikator_sesudah, 100 AS target_tahun2_sesudah, 'Indikator Program' AS uraian_sesudah, '%' AS singkatan_sesudah");

				$ip=0;
				$objIp=array();
				foreach ($indProg as $rowIp) {
					$objIp[$ip]=array(
						'nmindikator_sebelum' => $rowIp->nmindikator_sebelum,
						'target_sebelum' => $rowIp->target_tahun2_sebelum,
						'uraian_sat_sebelum' => $rowIp->uraian_sebelum,
						'satuan_sebelum' => $rowIp->singkatan_sebelum,
						'nmindikator_sesudah' => $rowIp->nmindikator_sesudah,
						'target_sesudah' => $rowIp->target_tahun2_sesudah,
						'uraian_sat_sesudah' => $rowIp->uraian_sesudah,
						'satuan_sesudah' => $rowIp->singkatan_sesudah,
					);
					$ip=$ip+1;
				}// Indikator Program

				$subkeg = DB::SELECT("SELECT A.kode_subkegiatan, A.nmsubkegiatan, A.sumberdana, A.nmlokasi, A.mulai, A.akhir, 
					SUM(A.jml_belanja_sebelum) AS jml_belanja_sebelum, SUM(A.jml_belanja_setelah) AS jml_belanja_setelah 
					FROM (
							SELECT dat.kode_subkegiatan, dat.nmsubkegiatan, dat.sumberdana, COALESCE(dat.nmlokasi,'Lokasi belum ditentukan') AS nmlokasi,  
							dat.mulai, dat.akhir, SUM(dat.jumlah) AS jml_belanja_setelah, 0 AS jml_belanja_sebelum
							FROM 
							( SELECT 
								CASE 1
								WHEN 1 THEN 'Januari'
									WHEN 2 THEN 'Februari'
									WHEN 3 THEN 'Maret'
									WHEN 4 THEN 'April'
									WHEN 5 THEN 'Mei'
									WHEN 6 THEN 'Juni'
									WHEN 7 THEN 'Juli'
									WHEN 8 THEN 'Agustus'
									WHEN 9 THEN 'September'
									WHEN 10 THEN 'Oktober'
									WHEN 11 THEN 'Nopember'
									WHEN 12 THEN 'Desember'
								END AS mulai,
								CASE 12
									WHEN 1 THEN 'Januari'
									WHEN 2 THEN 'Februari'
									WHEN 3 THEN 'Maret'
									WHEN 4 THEN 'April'
									WHEN 5 THEN 'Mei'
									WHEN 6 THEN 'Juni'
									WHEN 7 THEN 'Juli'
									WHEN 8 THEN 'Agustus'
									WHEN 9 THEN 'September'
									WHEN 10 THEN 'Oktober'
									WHEN 11 THEN 'Nopember'
									WHEN 12 THEN 'Desember'
								END AS akhir, a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
								a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, CASE j.ko_dana WHEN 1 THEN 'APBD' WHEN 2 THEN 'BLUD' ELSE 'BOK' END AS sumberdana, '".$urunit."' AS nmlokasi, 0 AS pagu_min, 0 AS pagu_plus
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
							) AS dat
							GROUP BY dat.kode_subkegiatan, dat.nmsubkegiatan, dat.sumberdana, dat.nmlokasi, dat.mulai, dat.akhir
							UNION ALL
							SELECT dat_0.kode_subkegiatan, dat_0.nmsubkegiatan, dat_0.sumberdana, COALESCE(dat_0.nmlokasi,'Lokasi belum ditentukan') AS nmlokasi,  
							dat_0.mulai, dat_0.akhir, 0 AS jml_belanja_setelah, SUM(dat_0.jumlah) AS jml_belanja_sebelum
							FROM 
							( SELECT 
								CASE 1
								WHEN 1 THEN 'Januari'
									WHEN 2 THEN 'Februari'
									WHEN 3 THEN 'Maret'
									WHEN 4 THEN 'April'
									WHEN 5 THEN 'Mei'
									WHEN 6 THEN 'Juni'
									WHEN 7 THEN 'Juli'
									WHEN 8 THEN 'Agustus'
									WHEN 9 THEN 'September'
									WHEN 10 THEN 'Oktober'
									WHEN 11 THEN 'Nopember'
									WHEN 12 THEN 'Desember'
								END AS mulai,
								CASE 12
									WHEN 1 THEN 'Januari'
									WHEN 2 THEN 'Februari'
									WHEN 3 THEN 'Maret'
									WHEN 4 THEN 'April'
									WHEN 5 THEN 'Mei'
									WHEN 6 THEN 'Juni'
									WHEN 7 THEN 'Juli'
									WHEN 8 THEN 'Agustus'
									WHEN 9 THEN 'September'
									WHEN 10 THEN 'Oktober'
									WHEN 11 THEN 'Nopember'
									WHEN 12 THEN 'Desember'
								END AS akhir, a.Ko_Period AS tahun, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, 
								a.To_Rp AS jumlah, a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, 'BLUD' AS sumberdana, '".$urunit."' AS nmlokasi, 0 AS pagu_min, 0 AS pagu_plus
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $idkegiatan."'
							) AS dat_0
							GROUP BY dat_0.kode_subkegiatan, dat_0.nmsubkegiatan, dat_0.sumberdana, dat_0.nmlokasi, dat_0.mulai, dat_0.akhir
						) A
					GROUP BY A.kode_subkegiatan, A.nmsubkegiatan, A.sumberdana, A.nmlokasi, A.mulai, A.akhir
					ORDER BY A.kode_subkegiatan");

				$su=0;
				$objSub=array();
				if(!empty($subkeg)) {
					foreach ($subkeg as $sk) {
						
					$indSubKeg = DB::SELECT("SELECT '".$sk->kode_subkegiatan."' AS kode, 'Keluaran' AS nmindikator, 100 AS target_tahun2, 'Indikator SubKegiatan' AS uraian, '%' AS singkatan");

					$is=0;
					$objIs=array();
					foreach ($indSubKeg as $rowIs) {
						$objIs[$is]=array(
							'nmindikator'=>$rowIs->nmindikator,
							'target'=>$rowIs->target_tahun2,
							'uraian_sat'=>$rowIs->uraian,
							'satuan'=>$rowIs->singkatan,
						);
						$is=$is+1;
					}// Indikator Sub Kegiatan

					$query = DB::select("WITH rincbelanja_arsip AS ( SELECT CASE WHEN A.kode_bid='0-00' THEN LEFT(A.kode_skpd,4) ELSE A.kode_bid END AS kode_bid, A.kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6,
							CONVERT(A.kdrek1, CHAR) AS kode_rekening1, A.nmrek1, 
							CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6)) AS kode_rekening7, A.uraian_aktivitas, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6),'.',RIGHT(CONCAT('00000',A.Ko_Rc),6)) AS kode_rekening8, A.uraian_blj,
							COALESCE(SUM(A.jml_volume),0) AS jml_volume_setelah, 
							COALESCE(SUM(A.harga),0) AS harga_setelah, 
							CONVERT(A.satuan, CHAR) AS satuan_setelah,
							COALESCE(SUM(A.jumlah),0) AS jumlah_setelah,
							0 AS jml_volume_sebelum, 
							0 AS harga_sebelum, 
							0 AS satuan_sebelum,
							0 AS jumlah_sebelum
							FROM (
								SELECT a.Ko_Period AS tahun, '".$kdskpd."' AS kode_skpd, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, jjj.Ur_KegBL2 as uraian_aktivitas, a.Ko_sKeg2 AS idrefaktivitas, 
								LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
								i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, Ko_Rc, Ur_Rc1 AS uraian_blj,
								a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = ".$idjnsdokumen_req." AND a.id_tap = ".$idnorev." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg,'.',LPAD(k.Ko_sKeg,3,0))='".$sk->kode_subkegiatan."' 
							) A
							GROUP BY A.kode_bid, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
							A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.kode_skpd, A.satuan, A.uraian_blj, A.uraian_aktivitas, A.idrefaktivitas 
							UNION ALL
							SELECT CASE WHEN A.kode_bid='0-00' THEN LEFT(A.kode_skpd,4) ELSE A.kode_bid END AS kode_bid, A.kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6,
							CONVERT(A.kdrek1, CHAR) AS kode_rekening1, A.nmrek1, 
							CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6)) AS kode_rekening7, A.uraian_aktivitas, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4),'.',RIGHT(CONCAT('00000',A.idrefaktivitas),6),'.',RIGHT(CONCAT('00000',A.Ko_Rc),6)) AS kode_rekening8, A.uraian_blj,
							0 AS jml_volume_setelah, 
							0 AS harga_setelah, 
							0 AS satuan_setelah,
							0 AS jumlah_setelah,
							COALESCE(SUM(A.jml_volume),0) AS jml_volume_sebelum, 
							COALESCE(SUM(A.harga),0) AS harga_sebelum, 
							CONVERT(A.satuan, CHAR) AS satuan_sebelum,
							COALESCE(SUM(A.jumlah),0) AS jumlah_sebelum
							FROM (
								SELECT a.Ko_Period AS tahun, '".$kdskpd."' AS kode_skpd, o.Ur_urus AS nmurusan, o.Ko_urus, n.Ko_Bid AS kode_bid, n.Ur_bid AS nmbidang, jjj.Ur_KegBL2 as uraian_aktivitas, a.Ko_sKeg2 AS idrefaktivitas, 
								LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
								i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, Ko_Rc, Ur_Rc1 AS uraian_blj,
								a.Ko_sKeg1 AS kode_subkegiatan, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0 AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg,'.',LPAD(k.Ko_sKeg,3,0))='".$sk->kode_subkegiatan."' 
							) A
							GROUP BY A.kode_bid, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
							A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.kode_skpd, A.satuan, A.uraian_blj, A.uraian_aktivitas, A.idrefaktivitas 
						)
						SELECT A.kode_bid AS kode_bid, A.kode_skpd AS kode_skpd, '00.0-00.000' AS kode_subkegiatan, A.kode_rekening1 AS kode, A.nmrek1 AS uraian, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS bertambah_berkurang, 1 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_rekening1, A.nmrek1
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening2, A.nmrek2,
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 5 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening2, A.nmrek2
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening3, A.nmrek3, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 6 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening3, A.nmrek3
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening4, A.nmrek4, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 7 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening4, A.nmrek4
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening5, A.nmrek5, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 8 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening5, A.nmrek5
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening6, A.nmrek6, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 9 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening6, A.nmrek6
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening7, A.uraian_aktivitas AS uraian_aktivitas, 
						0 AS jml_volume_sebelum, 0 AS jml_volume_setelah, 
						0 AS harga_sebelum, 0 AS harga_setelah,
						'' AS satuan_sebelum, '' AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 10 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening7, A.uraian_aktivitas
						UNION
						SELECT A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening8, A.uraian_blj AS uraian_blj, 
						SUM(A.jml_volume_sebelum) AS jml_volume_sebelum, SUM(A.jml_volume_setelah) AS jml_volume_setelah, 
						SUM(A.harga_sebelum) AS harga_sebelum, SUM(A.harga_setelah) AS harga_setelah,
						MAX(A.satuan_sebelum) AS satuan_sebelum, MAX(A.satuan_setelah) AS satuan_setelah,
						SUM(A.jumlah_sebelum) AS jumlah_sebelum, SUM(A.jumlah_setelah) AS jumlah_setelah, SUM(A.jumlah_setelah)-SUM(A.jumlah_sebelum) AS delta_blj, 11 AS kdlevel
						FROM rincbelanja_arsip A
						GROUP BY A.kode_bid, A.kode_skpd, A.kode_subkegiatan, A.kode_rekening8, A.uraian_blj
						ORDER BY kode_bid, kode_subkegiatan, kode, kdlevel");

						$objSub[$su]=array(
							'kdsubkegiatan'=>$sk->kode_subkegiatan,
							'nmsubkegiatan'=>$sk->nmsubkegiatan,
							'mulai'=>$sk->mulai,
							'akhir'=>$sk->akhir,
							'sumberdana'=>$sk->sumberdana,
							'lokasi'=>$sk->nmlokasi,
							'jumlah_sebelum' => $sk->jml_belanja_sebelum,
							'jumlah_setelah' => $sk->jml_belanja_setelah,
							'keluaran'=>$objIs,
							'rincian'=>$query,
						);
						$su=$su+1;
					} // subkegiatan
				}
				
				$obj[$a]=array(
					'nama_pemda'=>$pemda[0]->nmpemda,
					'tahun'=>$tahun,
					'kdurusan'=>$kode_urusan,
					'nmurusan'=>$nmurusan,
					'kdbidang'=>$kode_bidang,
					'nmbidang'=>$nmbidang,
					'kdprogram'=>$kdprogram,
					'nmprogram'=>$nmprogram,
					'kdkegiatan'=>$kdkegiatan,
					'nmkegiatan'=>$nmkegiatan,
					'kode_skpd'=>$kdskpd,
					'uraian_skpd'=>$urskpd,
					'kode_unit'=>$kdunit,
					'uraian_unit'=>$urunit,
					'pagumin'=>$pagumin,
					'paguskg'=>$paguskg,
					'paguplus'=>$paguplus,
					'pagumin_sebelum' => $pagumin_sebelum,
					'paguskg_sebelum' => $paguskg_sebelum,
					'paguplus_sebelum' => $paguplus_sebelum,
					'keluaran'=>$objIk,
					'hasil'=>$objIp,
					'subkeg'=>$objSub,
				);

			} //dokumen
		}

        return $obj;
    }
}
