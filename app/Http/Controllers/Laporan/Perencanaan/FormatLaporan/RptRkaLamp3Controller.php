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

class RptRkaLamp3Controller extends Controller
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

		if($rkaperubahan==null){
			//mulai for each
			foreach ($unit as $row0) {
		 
			$query = DB::select("WITH rincbelanja AS (
				SELECT
					CASE
						WHEN bel.kode_urusan=0 THEN bel.kode_urusan
						ELSE bel.kode_urusan
					END AS kdurusansungguhan,
					CASE
						WHEN bel.kode_urusan=0 THEN bel.nmurusan
						ELSE bel.nmurusan
					END AS nmurusansungguhan,
					CASE
						WHEN bel.kode_bidang=0 THEN bel.kode_bidang
						ELSE bel.kode_bidang
					END AS kdbidangsungguhan,
					CASE
						WHEN bel.kode_bidang=0 THEN bel.nmbidang
						ELSE bel.nmbidang
					END AS nmbidangsungguhan,
						bel.tahun, bel.kdrek1, bel.kdrek2, bel.kdrek3, bel.kdrek4, bel.kdrek5, bel.kdrek6, bel.jumlah,
						CONVERT(bel.kode_program, CHAR) AS kdprogram, bel.nmprogram,
						bel.kode_kegiatan AS kdkegiatan, bel.nmkegiatan,
						bel.kode_subkegiatan AS kdsubkegiatan, bel.nmsubkegiatan,
						CASE WHEN bel.kdrek1=4 THEN bel.jumlah ELSE 0 END AS jml_pendapatan,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=1 THEN bel.jumlah ELSE 0 END AS jml_operasi,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=2 THEN bel.jumlah ELSE 0 END AS jml_modal,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=3 THEN bel.jumlah ELSE 0 END AS jml_tidak,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=4 THEN bel.jumlah ELSE 0 END AS jml_transfer,
						CASE WHEN bel.kdrek1=5 THEN bel.jumlah ELSE 0 END AS jml_belanja,
					    CASE bel.ko_dana WHEN 1 THEN 'APBD' WHEN 2 THEN 'BLUD' ELSE 'BOK' END AS sumberdana, '".$urunit."' AS lokasi, 0 AS pagu_min, 0 AS pagu_plus
					FROM
					(    
						SELECT A.Tahun, A.Ko_urus AS kode_urusan, A.Ko_Bid AS kode_bidang, LEFT('".$kdskpd."',5) AS kode_bid, '".$kdskpd."' AS kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, 
						A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.nmbidang, A.nmurusan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6, A.kdrek1 AS kode_rekening1, A.nmrek1, 
						CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
						CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
						CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
						CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
						CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, A.ko_dana,
						COALESCE(SUM(A.jumlah),0) AS jumlah
						FROM (
								SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
								i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
								a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram, n.Ko_Bid, n.Ur_bid AS nmbidang, o.Ur_urus AS nmurusan, o.Ko_urus, j.ko_dana
								FROM tb_ang_rc AS a LEFT JOIN
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0
						) A
						GROUP BY A.Tahun, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
						A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.nmbidang, A.nmurusan, A.Ko_urus,  A.Ko_Bid, A.ko_dana
					) bel
				)
				SELECT rincbelanja.kdurusansungguhan AS kode, rincbelanja.nmurusansungguhan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
				rincbelanja.pagu_min, SUM(rincbelanja.jml_operasi) AS jml_operasi, SUM(rincbelanja.jml_modal) AS jml_modal, SUM(rincbelanja.jml_tidak) AS jml_tidak,
				SUM(rincbelanja.jml_transfer) AS jml_transfer, SUM(rincbelanja.jml_belanja) AS jml_belanja, rincbelanja.pagu_plus
				FROM rincbelanja
				GROUP BY rincbelanja.kdurusansungguhan, rincbelanja.nmurusansungguhan
				UNION
				SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2)) AS kode, rincbelanja.nmbidangsungguhan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
				rincbelanja.pagu_min, SUM(rincbelanja.jml_operasi) AS jml_operasi, SUM(rincbelanja.jml_modal) AS jml_modal, SUM(rincbelanja.jml_tidak) AS jml_tidak,
				SUM(rincbelanja.jml_transfer) AS jml_transfer, SUM(rincbelanja.jml_belanja) AS jml_belanja, rincbelanja.pagu_plus
				FROM rincbelanja
				GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan, rincbelanja.nmbidangsungguhan
				UNION
				SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2)) AS kode, rincbelanja.nmprogram AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
				rincbelanja.pagu_min, SUM(rincbelanja.jml_operasi) AS jml_operasi, SUM(rincbelanja.jml_modal) AS jml_modal, SUM(rincbelanja.jml_tidak) AS jml_tidak,
				SUM(rincbelanja.jml_transfer) AS jml_transfer, SUM(rincbelanja.jml_belanja) AS jml_belanja, rincbelanja.pagu_plus
				FROM rincbelanja
				GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram, rincbelanja.nmprogram
				UNION
				SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2),'.',LEFT(rincbelanja.kdkegiatan,1),'.',RIGHT(rincbelanja.kdkegiatan,2)) AS kode,
				rincbelanja.nmkegiatan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
				rincbelanja.pagu_min, SUM(rincbelanja.jml_operasi) AS jml_operasi, SUM(rincbelanja.jml_modal) AS jml_modal, SUM(rincbelanja.jml_tidak) AS jml_tidak,
				SUM(rincbelanja.jml_transfer) AS jml_transfer, SUM(rincbelanja.jml_belanja) AS jml_belanja, rincbelanja.pagu_plus
				FROM rincbelanja
				GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram,rincbelanja.kdkegiatan,rincbelanja.nmkegiatan
				UNION
				SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2),'.',LEFT(rincbelanja.kdkegiatan,1),'.',RIGHT(rincbelanja.kdkegiatan,2),'.',RIGHT(CONCAT('00',rincbelanja.kdsubkegiatan),3)) AS kode,
				rincbelanja.nmsubkegiatan AS uraian, rincbelanja.sumberdana AS sumberdana, rincbelanja.lokasi AS lokasi,
				rincbelanja.pagu_min AS pagu_min, SUM(rincbelanja.jml_operasi) AS jml_operasi, SUM(rincbelanja.jml_modal) AS jml_modal, SUM(rincbelanja.jml_tidak) AS jml_tidak,
				SUM(rincbelanja.jml_transfer) AS jml_transfer, SUM(rincbelanja.jml_belanja) AS jml_belanja, rincbelanja.pagu_plus AS pagu_plus
				FROM rincbelanja
				GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram,rincbelanja.kdkegiatan,rincbelanja.kdsubkegiatan,
				rincbelanja.nmsubkegiatan,rincbelanja.sumberdana,rincbelanja.lokasi,rincbelanja.pagu_min,rincbelanja.pagu_plus
				ORDER BY kode");

			$total=DB::SELECT("SELECT dat.tahun, SUM(dat.jml_pendapatan) AS jml_pendapatan, SUM(dat.jml_operasi) AS jml_operasi,
				SUM(dat.jml_modal) AS jml_modal, SUM(dat.jml_tidak) AS jml_tidak, SUM(dat.jml_transfer) AS jml_transfer, SUM(dat.jml_belanja) AS jml_belanja
				FROM (
						SELECT bel.tahun, bel.kdrek1, bel.kdrek2, bel.kdrek3, bel.kdrek4, bel.kdrek5, bel.kdrek6, bel.jumlah,
						CASE WHEN bel.kdrek1=4 THEN bel.jumlah ELSE 0 END AS jml_pendapatan,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=1 THEN bel.jumlah ELSE 0 END AS jml_operasi,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=2 THEN bel.jumlah ELSE 0 END AS jml_modal,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=3 THEN bel.jumlah ELSE 0 END AS jml_tidak,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=4 THEN bel.jumlah ELSE 0 END AS jml_transfer,
						CASE WHEN bel.kdrek1=5 THEN bel.jumlah ELSE 0 END AS jml_belanja
						FROM (
								SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
								i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
								a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram, n.Ur_bid AS nmbidang, o.Ur_urus AS nmurusan, o.Ko_urus
								FROM tb_ang_rc AS a LEFT JOIN
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (5)
						) bel 
					) AS dat
				GROUP BY dat.tahun");

			$obj[$a]=[
				'nama_pemda'=>$pemda[0]->nmpemda,
				'tahun'=>$tahun,
				'kode_skpd'=>$kdskpd,
				'uraian_skpd'=>$urskpd,
				'kode_unit'=>$kdunit,
				'uraian_unit'=>$urunit,
				'urusan'=>$query,
				'pendapatan'=>$total[0]->jml_pendapatan,
				'operasi'=>$total[0]->jml_operasi,
				'modal'=>$total[0]->jml_modal,
				'tidak_terduga'=>$total[0]->jml_tidak,
				'transfer'=>$total[0]->jml_transfer,
				'belanja'=>$total[0]->jml_belanja,
			];

			} //dokumen
		//end for each
		}
		//tutup if jika tidak centang
		//else jika tercentang
		else{
			///mulai for each
			foreach ($unit as $row0) {
			$dok = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=2 AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".$row0->kode_unit."' ");

			$query = DB::select("WITH rincbelanja AS (
					SELECT
						CASE
							WHEN bel.kode_urusan=0 THEN bel.kode_urusan
							ELSE bel.kode_urusan
						END AS kdurusansungguhan,
						CASE
							WHEN bel.kode_urusan=0 THEN bel.nmurusan
							ELSE bel.nmurusan
						END AS nmurusansungguhan,
						CASE
							WHEN bel.kode_bidang=0 THEN bel.kode_bidang
							ELSE bel.kode_bidang
						END AS kdbidangsungguhan,
						CASE
							WHEN bel.kode_bidang=0 THEN bel.nmbidang
							ELSE bel.nmbidang
						END AS nmbidangsungguhan,
							bel.tahun, bel.kdrek1, bel.kdrek2, bel.kdrek3, bel.kdrek4, bel.kdrek5, bel.kdrek6, bel.jumlah,
							 CONVERT(bel.kode_program, CHAR) AS kdprogram, bel.nmprogram,
							bel.kode_kegiatan AS kdkegiatan, bel.nmkegiatan,
							bel.kode_subkegiatan AS kdsubkegiatan, bel.nmsubkegiatan,
							CASE WHEN bel.kdrek1=4 THEN bel.jumlah ELSE 0 END AS jml_pendapatan,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=1 THEN bel.jumlah ELSE 0 END AS jml_operasi,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=2 THEN bel.jumlah ELSE 0 END AS jml_modal,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=3 THEN bel.jumlah ELSE 0 END AS jml_tidak,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=4 THEN bel.jumlah ELSE 0 END AS jml_transfer,
							CASE WHEN bel.kdrek1=5 THEN bel.jumlah ELSE 0 END AS jml_belanja,
						    CASE bel.ko_dana WHEN 1 THEN 'APBD' WHEN 2 THEN 'BLUD' ELSE 'BOK' END AS sumberdana, '".$urunit."' AS lokasi, 0 AS pagu_min, 0 AS pagu_plus
						FROM
						(    
							SELECT A.Tahun, A.Ko_urus AS kode_urusan, A.Ko_Bid AS kode_bidang, LEFT('".$kdskpd."',5) AS kode_bid, '".$kdskpd."' AS kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, 
							A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.nmbidang, A.nmurusan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6, A.kdrek1 AS kode_rekening1, A.nmrek1, 
							CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, A.ko_dana,
							COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM (
									SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
									i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
									a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram, n.Ko_Bid, n.Ur_bid AS nmbidang, o.Ur_urus AS nmurusan, o.Ko_urus, j.ko_dana
									FROM tb_ang_rc AS a LEFT JOIN
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
									WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0
							) A
							GROUP BY A.Tahun, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
							A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.nmbidang, A.nmurusan, A.Ko_urus,  A.Ko_Bid, A.ko_dana
						) bel
					),
					A AS (
					SELECT rincbelanja.kdurusansungguhan AS kode, rincbelanja.nmurusansungguhan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
					SUM(rincbelanja.jml_belanja) AS jml_belanja
					FROM rincbelanja
					GROUP BY rincbelanja.kdurusansungguhan, rincbelanja.nmurusansungguhan
					UNION
					SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2)) AS kode, rincbelanja.nmbidangsungguhan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
					SUM(rincbelanja.jml_belanja) AS jml_belanja
					FROM rincbelanja
					GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan, rincbelanja.nmbidangsungguhan
					UNION
					SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2)) AS kode, rincbelanja.nmprogram AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
					SUM(rincbelanja.jml_belanja) AS jml_belanja
					FROM rincbelanja
					GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram, rincbelanja.nmprogram
					UNION
					SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2),'.',LEFT(rincbelanja.kdkegiatan,1),'.',RIGHT(rincbelanja.kdkegiatan,2)) AS kode,
					rincbelanja.nmkegiatan AS uraian, rincbelanja.sumberdana, rincbelanja.lokasi,
					SUM(rincbelanja.jml_belanja) AS jml_belanja
					FROM rincbelanja
					GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram,rincbelanja.kdkegiatan,rincbelanja.nmkegiatan
					UNION
					SELECT CONCAT(rincbelanja.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja.kdprogram),2),'.',LEFT(rincbelanja.kdkegiatan,1),'.',RIGHT(rincbelanja.kdkegiatan,2),'.',RIGHT(CONCAT('00',rincbelanja.kdsubkegiatan),3)) AS kode,
					rincbelanja.nmsubkegiatan AS uraian, rincbelanja.sumberdana AS sumberdana, rincbelanja.lokasi AS lokasi,
					SUM(rincbelanja.jml_belanja) AS jml_belanja
					FROM rincbelanja
					GROUP BY rincbelanja.kdurusansungguhan,rincbelanja.kdbidangsungguhan,rincbelanja.kdprogram,rincbelanja.kdkegiatan,rincbelanja.kdsubkegiatan,
					rincbelanja.nmsubkegiatan,rincbelanja.sumberdana,rincbelanja.lokasi
					),
					rincbelanja_arsip AS (SELECT
						CASE
							WHEN bel.kode_urusan=0 THEN bel.kode_urusan
							ELSE bel.kode_urusan
						END AS kdurusansungguhan,
						CASE
							WHEN bel.kode_urusan=0 THEN bel.nmurusan
							ELSE bel.nmurusan
						END AS nmurusansungguhan,
						CASE
							WHEN bel.kode_bidang=0 THEN bel.kode_bidang
							ELSE bel.kode_bidang
						END AS kdbidangsungguhan,
						CASE
							WHEN bel.kode_bidang=0 THEN bel.nmbidang
							ELSE bel.nmbidang
						END AS nmbidangsungguhan,
							bel.tahun, bel.kdrek1, bel.kdrek2, bel.kdrek3, bel.kdrek4, bel.kdrek5, bel.kdrek6, bel.jumlah,
							 CONVERT(bel.kode_program, CHAR) AS kdprogram, bel.nmprogram,
							bel.kode_kegiatan AS kdkegiatan, bel.nmkegiatan,
							bel.kode_subkegiatan AS kdsubkegiatan, bel.nmsubkegiatan,
							CASE WHEN bel.kdrek1=4 THEN bel.jumlah ELSE 0 END AS jml_pendapatan,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=1 THEN bel.jumlah ELSE 0 END AS jml_operasi,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=2 THEN bel.jumlah ELSE 0 END AS jml_modal,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=3 THEN bel.jumlah ELSE 0 END AS jml_tidak,
							CASE WHEN bel.kdrek1=5 AND bel.kdrek2=4 THEN bel.jumlah ELSE 0 END AS jml_transfer,
							CASE WHEN bel.kdrek1=5 THEN bel.jumlah ELSE 0 END AS jml_belanja,
						    CASE bel.ko_dana WHEN 1 THEN 'APBD' WHEN 2 THEN 'BLUD' ELSE 'BOK' END AS sumberdana, '".$urunit."' AS lokasi, 0 AS pagu_min, 0 AS pagu_plus
						FROM
						(    
							SELECT A.Tahun, A.Ko_urus AS kode_urusan, A.Ko_Bid AS kode_bidang, LEFT('".$kdskpd."',5) AS kode_bid, '".$kdskpd."' AS kode_skpd, LEFT(A.kode_subkegiatan,2) AS kode_program, LEFT(A.kode_subkegiatan,7) AS kode_kegiatan, A.kode_subkegiatan, 
							A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, A.nmbidang, A.nmurusan, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5, A.kdrek6, A.kdrek1 AS kode_rekening1, A.nmrek1, 
							CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening2, A.nmrek2, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening3, A.nmrek3, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening4, A.nmrek4, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2)) AS kode_rekening5, A.nmrek5, 
							CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('0',A.kdrek5),2),'.',RIGHT(CONCAT('000',A.kdrek6),4)) AS kode_rekening6, A.nmrek6, A.ko_dana, 
							COALESCE(SUM(A.jumlah),0) AS jumlah
							FROM (
									SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
									i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
									a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram, n.Ko_Bid, n.Ur_bid AS nmbidang, o.Ur_urus AS nmurusan, o.Ko_urus, j.ko_dana
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
									WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND a.Ko_tap = 2 AND a.id_tap = ".$dok[0]->id_tap." AND LEFT(a.ko_rkk,2) IN (5) AND a.To_Rp<>0
							) A
							GROUP BY A.Tahun, A.kdrek1, A.kdrek2, A.kdrek3,  A.kdrek4, A.kdrek5,  A.kdrek6, A.nmprogram, A.nmkegiatan, A.nmsubkegiatan, 
							A.nmrek1, A.nmrek2, A.nmrek3, A.nmrek4, A.nmrek5, A.nmrek6, A.kode_subkegiatan, A.nmbidang, A.nmurusan, A.Ko_urus,  A.Ko_Bid, A.ko_dana 
						) bel
					),
					B AS (
					SELECT rincbelanja_arsip.kdurusansungguhan AS kode, rincbelanja_arsip.nmurusansungguhan AS uraian, rincbelanja_arsip.sumberdana, rincbelanja_arsip.lokasi,
					SUM(rincbelanja_arsip.jml_belanja) AS jml_belanja
					FROM rincbelanja_arsip
					GROUP BY rincbelanja_arsip.kdurusansungguhan, rincbelanja_arsip.nmurusansungguhan
					UNION
					SELECT CONCAT(rincbelanja_arsip.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdbidangsungguhan),2)) AS kode, rincbelanja_arsip.nmbidangsungguhan AS uraian, rincbelanja_arsip.sumberdana, rincbelanja_arsip.lokasi,
					SUM(rincbelanja_arsip.jml_belanja) AS jml_belanja
					FROM rincbelanja_arsip
					GROUP BY rincbelanja_arsip.kdurusansungguhan,rincbelanja_arsip.kdbidangsungguhan, rincbelanja_arsip.nmbidangsungguhan
					UNION
					SELECT CONCAT(rincbelanja_arsip.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdprogram),2)) AS kode, rincbelanja_arsip.nmprogram AS uraian, rincbelanja_arsip.sumberdana, rincbelanja_arsip.lokasi,
					SUM(rincbelanja_arsip.jml_belanja) AS jml_belanja
					FROM rincbelanja_arsip
					GROUP BY rincbelanja_arsip.kdurusansungguhan,rincbelanja_arsip.kdbidangsungguhan,rincbelanja_arsip.kdprogram, rincbelanja_arsip.nmprogram
					UNION
					SELECT CONCAT(rincbelanja_arsip.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdprogram),2),'.',LEFT(rincbelanja_arsip.kdkegiatan,1),'.',RIGHT(rincbelanja_arsip.kdkegiatan,2)) AS kode,
					rincbelanja_arsip.nmkegiatan AS uraian, rincbelanja_arsip.sumberdana, rincbelanja_arsip.lokasi,
					SUM(rincbelanja_arsip.jml_belanja) AS jml_belanja
					FROM rincbelanja_arsip
					GROUP BY rincbelanja_arsip.kdurusansungguhan,rincbelanja_arsip.kdbidangsungguhan,rincbelanja_arsip.kdprogram,rincbelanja_arsip.kdkegiatan,rincbelanja_arsip.nmkegiatan
					UNION
					SELECT CONCAT(rincbelanja_arsip.kdurusansungguhan,'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdbidangsungguhan),2),'.',RIGHT(CONCAT('0',rincbelanja_arsip.kdprogram),2),'.',LEFT(rincbelanja_arsip.kdkegiatan,1),'.',RIGHT(rincbelanja_arsip.kdkegiatan,2),'.',RIGHT(CONCAT('00',rincbelanja_arsip.kdsubkegiatan),3)) AS kode,
					rincbelanja_arsip.nmsubkegiatan AS uraian, rincbelanja_arsip.sumberdana AS sumberdana, rincbelanja_arsip.lokasi AS lokasi,
					SUM(rincbelanja_arsip.jml_belanja) AS jml_belanja
					FROM rincbelanja_arsip
					GROUP BY rincbelanja_arsip.kdurusansungguhan,rincbelanja_arsip.kdbidangsungguhan,rincbelanja_arsip.kdprogram,rincbelanja_arsip.kdkegiatan,rincbelanja_arsip.kdsubkegiatan,
					rincbelanja_arsip.nmsubkegiatan,rincbelanja_arsip.sumberdana,rincbelanja_arsip.lokasi
					)
					SELECT temp1.kode,temp1.uraian,MAX(temp1.sumberdana) AS sumberdana, MAX(temp1.lokasi) AS lokasi,SUM(temp1.jumlah_sebelum) AS jumlah_sebelum,
					SUM(temp1.jumlah_setelah) AS jumlah_setelah, SUM(temp1.jumlah_setelah)-SUM(temp1.jumlah_sebelum) AS bertambah_berkurang 
					FROM
					(
						SELECT A.kode, A.uraian,A.sumberdana,A.lokasi,
						0 AS jumlah_sebelum, A.jml_belanja AS jumlah_setelah FROM A
						UNION
						SELECT B.kode, B.uraian,B.sumberdana,B.lokasi,
						B.jml_belanja AS jumlah_sebelum, 0 AS jumlah_setelah FROM B
					) temp1
					GROUP BY temp1.kode,temp1.uraian
					ORDER BY kode,uraian ");

			$total=DB::SELECT("SELECT dat.tahun, SUM(dat.jml_pendapatan) AS jml_pendapatan, SUM(dat.jml_operasi) AS jml_operasi,
				SUM(dat.jml_modal) AS jml_modal, SUM(dat.jml_tidak) AS jml_tidak, SUM(dat.jml_transfer) AS jml_transfer, SUM(dat.jml_belanja) AS jml_belanja
				FROM (
						SELECT bel.tahun, bel.kdrek1, bel.kdrek2, bel.kdrek3, bel.kdrek4, bel.kdrek5, bel.kdrek6, bel.jumlah,
						CASE WHEN bel.kdrek1=4 THEN bel.jumlah ELSE 0 END AS jml_pendapatan,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=1 THEN bel.jumlah ELSE 0 END AS jml_operasi,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=2 THEN bel.jumlah ELSE 0 END AS jml_modal,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=3 THEN bel.jumlah ELSE 0 END AS jml_tidak,
						CASE WHEN bel.kdrek1=5 AND bel.kdrek2=4 THEN bel.jumlah ELSE 0 END AS jml_transfer,
						CASE WHEN bel.kdrek1=5 THEN bel.jumlah ELSE 0 END AS jml_belanja
						FROM (
								SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk,2) AS kdrek1, SUBSTRING(a.ko_rkk,4,2) AS kdrek2, SUBSTRING(a.ko_rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
								i.Ur_Rk1 AS nmrek1, f.Ur_Rk2 AS nmrek2, e.Ur_Rk3 AS nmrek3, d.Ur_Rk4 AS nmrek4, c.Ur_Rk5 AS nmrek5, b.Ur_Rk6 AS nmrek6, a.To_Rp AS jumlah, a.V_1 AS jml_volume, V_sat AS satuan, Rp_1 AS harga, 
								a.Ko_sKeg1 AS kode_subkegiatan, a.Ko_sKeg2, j.Ur_sKeg AS nmsubkegiatan, l.Ur_Keg AS nmkegiatan, m.Ur_Prg AS nmprogram, n.Ur_bid AS nmbidang, o.Ur_urus AS nmurusan, o.Ko_urus
								FROM tb_ang_rc AS a LEFT JOIN
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
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.Ko_unit1,18) = '".$row0->kode_unit."' AND LEFT(a.ko_rkk,2) IN (5)
						) bel 
					) AS dat
				GROUP BY dat.tahun");

				$obj[$a]=[
					'nama_pemda'=>$pemda[0]->nmpemda,
					'tahun'=>$tahun,
					'kode_skpd'=>$kdskpd,
					'uraian_skpd'=>$urskpd,
					'kode_unit'=>$kdunit,
					'uraian_unit'=>$urunit,
					'urusan'=>$query,
				];

			} //dokumen
		} //tutup else jika tercentang
		return $obj;
	}
}
