<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptSpjPengeluaranController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-pengeluaran';
    }

    public static function Laporan($tahun, $bulan, $jn_spj)
    {
		$data = null;
		$ambilbidang = 0;
		$ambilskpd = 0;
		$ambilunit = 0;

		
        $pemda = DB::select("SELECT CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) AS Ko_pemda, ur_pemda AS nmpemda 
							FROM tb_pemda
							WHERE CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) = LEFT('".kd_unit()."',5)
							ORDER BY ko_wil1, ko_wil2 ");
        $tahun = Tahun();
		//$bulan1 = $bulan - 1 ;
		
		$bid = DB::SELECT("SELECT DISTINCT u.Ko_Urus AS kdurusan, u.Ur_Urus AS nmurusan, b.id_bidang AS idbidang, b.Ur_Bid AS nmbidang, 
						CONCAT(RIGHT(CONCAT('0',u.Ko_Urus),2),'.',RIGHT(CONCAT('0',b.Ko_Bid),2),' ',b.Ur_Bid) AS kode_bidang
						FROM pf_urus AS u
						INNER JOIN pf_bid AS b ON u.Ko_Urus=b.Ko_Urus
						WHERE CONCAT(RIGHT(CONCAT('0',u.Ko_Urus),2),'.',RIGHT(CONCAT('0',b.Ko_Bid),2)) = SUBSTRING('".kd_unit()."',7,5) ");

		$skpd = DB::SELECT("SELECT CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),' ',s.Ur_unit) AS kode_skpd, s.Ur_unit AS uraian_skpd
							FROM tb_unit AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0)) = LEFT('".kd_unit()."',14)");

		$unit = DB::SELECT("SELECT CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0),' ',s.ur_subunit) AS kode_unit, s.ur_subunit AS uraian_unit
							FROM tb_sub AS s
							WHERE CONCAT(
							LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) = LEFT('".kd_unit()."',18)");
							
		$Ko_tap_awl = DB::SELECT("SELECT jns.Ko_Tap, jns.Ur_Tap, dok.Dt_Tap 
								FROM pf_tap AS jns INNER JOIN ( SELECT COALESCE(MIN(a.Ko_Tap),0) AS Ko_Tap, MIN(a.Dt_Tap) AS Dt_Tap
								FROM tb_tap a 
								WHERE LEFT(ko_unit1,18) = '".kd_unit()."' AND Ko_Period = ".$tahun." AND Ko_Tap>=2 ) AS dok ON jns.Ko_Tap=dok.Ko_Tap ");					
		
		$Ko_tap = DB::SELECT("SELECT COALESCE(MAX(Ko_tap),".$Ko_tap_awl[0]->Ko_Tap.") AS Ko_tap FROM tb_tap WHERE Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' AND MONTH(CAST(Dt_Tap AS DATE)) <= ".$bulan." ");

		$id_tap = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=".$Ko_tap[0]->Ko_tap." AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' ");
		
		$apbd = DB::SELECT("SELECT apbd FROM tb_sub WHERE ko_unitstr = '".kd_unit()."' ");
		
		if($apbd[0]->apbd == 0){
			$rincianSpj = DB::select("WITH anggaran AS (								
										SELECT bel.Ko_Period AS tahun, bel.Ko_sKeg1, bel.Ko_sKeg2, bel.Ur_KegBL1, bel.Ur_KegBL2,
										LEFT(bel.ko_rkk,2) AS kdrek1, SUBSTRING(bel.ko_rkk,4,2) AS kdrek2, 
										SUBSTRING(bel.ko_rkk,7,2) AS kdrek3, SUBSTRING(bel.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(bel.Ko_Rkk,13,3) AS kdrek5, 
										RIGHT(bel.Ko_Rkk,4) AS kdrek6, bel.ko_rkk, sum(bel.To_Rp) AS jumlah
										FROM tb_tap AS bel 
										WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = LEFT('".kd_unit()."',18)
										AND (LEFT(bel.ko_rkk,2) IN (5)) AND bel.Ko_Pdp<>4
										GROUP BY bel.Ko_Period,bel.ko_rkk,bel.Ko_sKeg1, bel.Ko_sKeg2, bel.Ur_KegBL1, bel.Ur_KegBL2
									),
									spj_ini_gu AS (
										SELECT
											A.Ko_Period AS tahun, A.Ko_sKeg1, A.Ko_sKeg2, 
											LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
											SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
											RIGHT(A.Ko_Rkk,4) AS kdrek6, A.ko_rkk,
											SUM(A.nilai) AS nilai, SUM(A.nilai_lalu) AS nilai_lalu
										FROM
										(
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_spirc A INNER JOIN
											tb_spi B ON A.id_spi = B.id INNER JOIN
											tb_oto C ON B.id = C.id_spi INNER JOIN
											tb_npd D ON C.id = D.id_oto INNER JOIN
											(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
											WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_SPi IN(4,6,8)
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
										) A
										GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
									),
									ls_ini AS(
										SELECT
											A.Ko_Period AS tahun,A.Ko_sKeg1, A.Ko_sKeg2, 
											LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
											SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
											RIGHT(A.Ko_Rkk,4) AS kdrek6, A.ko_rkk,
											SUM(A.nilai) AS nilai, SUM(A.nilai_lalu) AS nilai_lalu
										FROM 
										(	
												SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
												SUM(
													CASE
														WHEN ( MONTH(CAST(C.dt_oto AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
														ELSE 0
													END
												) AS nilai,
												SUM(
													CASE
														WHEN ( MONTH(CAST(C.dt_oto AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
														ELSE 0
													END
												) AS nilai_lalu
												FROM tb_spirc A INNER JOIN
												tb_spi B ON A.id_spi = B.id INNER JOIN
												tb_oto C ON B.id = C.id_spi 
												WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
												AND B.Ko_SPi IN(2,3)
												GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
												UNION ALL
												SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, map.Ko_RKK, 
												SUM(
													CASE
														WHEN ( MONTH(CAST(C.dt_oto AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
														ELSE 0
													END
												) AS nilai,
												SUM(
													CASE
														WHEN ( MONTH(CAST(C.dt_oto AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
														ELSE 0
													END
												) AS nilai_lalu
												FROM tb_spirc A INNER JOIN
												tb_spi B ON A.id_spi = B.id INNER JOIN
												tb_oto C ON B.id = C.id_spi INNER JOIN
												pf_mapjr AS map ON A.ko_rkk = map.LO_K 
												WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
												AND B.Ko_SPi IN(9)
												GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, map.Ko_RKK
										) A
										GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
									),
									koreksi AS (
										SELECT
											A.tahun, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6,
											SUM(A.nilai_ls) AS nilai_ls, 0 AS nilai_gu,
											SUM(A.nilai_ls_lalu) AS nilai_ls_lalu, 0 AS nilai_gu_lalu
										FROM (
																				
											SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
											SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											0 AS nilai_ls,
											CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE -SUM(A.Rp_K) END AS nilai_ls_lalu
											FROM jr_sesuai A INNER JOIN 
											tb_sesuai B ON A.id_tbses=B.id_tbses 	
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='05') 
											AND ( MONTH(CAST(B.dt_sesuai AS DATE)) < ".$bulan." )
											AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK, A.Ko_sKeg1, A.Ko_sKeg2
											
											UNION ALL
										
											SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
											SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE -SUM(A.Rp_K) END AS nilai_ls,
											0 AS nilai_ls_lalu
											FROM jr_sesuai A INNER JOIN 
											tb_sesuai B ON A.id_tbses=B.id_tbses 
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='05') 
											AND ( MONTH(CAST(B.dt_sesuai AS DATE)) = ".$bulan.") 
											AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK, A.Ko_sKeg1, A.Ko_sKeg2
										) A
										GROUP BY A.tahun, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6
									)
									SELECT a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6 AS nmrek6,
									SUM(a.jumlah) AS anggaran, SUM(COALESCE(b.nilai, 0) + COALESCE(f.nilai_gu, 0)) AS nilai_gu_ini, SUM(COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)) AS nilai_ls_ini,
									SUM(
										CASE
											WHEN rek.Jns_LS = 1 THEN COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)
											ELSE 0
										END
									) AS nilai_ls_gaji_ini,
									SUM(
										CASE
											WHEN rek.Jns_LS != 1 THEN COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)
											ELSE 0
										END
									) AS nilai_ls_barang_jasa_ini,
									SUM(COALESCE(b.nilai_lalu, 0) + COALESCE(f.nilai_gu_lalu, 0)) AS nilai_gu_lalu, SUM(COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)) AS nilai_ls_lalu,
									SUM(
										CASE
											WHEN rek.Jns_LS = 1 THEN COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)
											ELSE 0
										END
									) AS nilai_ls_gaji_lalu,
									SUM(
										CASE
											WHEN rek.Jns_LS != 1 THEN COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)
											ELSE 0
										END
									) AS nilai_ls_barang_jasa_lalu
									FROM anggaran a
									LEFT JOIN spj_ini_gu b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2 = b.Ko_sKeg2
									AND a.kdrek1 = b.kdrek1 AND a.kdrek2 = b.kdrek2 AND a.kdrek3 = b.kdrek3 AND a.kdrek4 = b.kdrek4 AND a.kdrek5 = b.kdrek5 AND a.kdrek6 = b.kdrek6
									LEFT JOIN ls_ini c ON a.Ko_sKeg1 = c.Ko_sKeg1 AND a.Ko_sKeg2 = c.Ko_sKeg2
									AND a.kdrek1 = c.kdrek1 AND a.kdrek2 = c.kdrek2 AND a.kdrek3 = c.kdrek3 AND a.kdrek4 = c.kdrek4 AND a.kdrek5 = c.kdrek5 AND a.kdrek6 = c.kdrek6
									LEFT JOIN koreksi f ON a.Ko_sKeg1 = f.Ko_sKeg1 AND a.Ko_sKeg2 = f.Ko_sKeg2
									AND a.kdrek1 = f.kdrek1 AND a.kdrek2 = f.kdrek2 AND a.kdrek3 = f.kdrek3 AND a.kdrek4 = f.kdrek4 AND a.kdrek5 = f.kdrek5 AND a.kdrek6 = f.kdrek6
									INNER JOIN pf_rk6 AS rek ON a.kdrek1 = rek.Ko_Rk1 AND a.kdrek2 = rek.Ko_Rk2 AND a.kdrek3 = rek.Ko_Rk3 AND a.kdrek4 = rek.Ko_Rk4 
									AND a.kdrek5 = rek.Ko_Rk5 AND a.kdrek6 = rek.Ko_Rk6
									GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6
									ORDER BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6");
									
			$spjfooter = DB::select("WITH rincian_bukti AS (
										-- spj LS penerimaan
										SELECT 1 AS kode, SUM(A.spirc_Rp) AS debet, 0 AS kredit
										FROM tb_spirc A INNER JOIN
										tb_spi B ON A.id_spi = B.id INNER JOIN
										tb_oto C ON B.id = C.id_spi 
										WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND B.Ko_SPi IN (2,3,9)
										UNION ALL
										-- spj LS pengeluaran rinci
										SELECT 2 AS kode, 0 AS debet, SUM(A.spirc_Rp) AS kredit
										FROM tb_spirc A INNER JOIN
										tb_spi B ON A.id_spi = B.id INNER JOIN
										tb_oto C ON B.id = C.id_spi 
										WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND B.Ko_SPi IN (2,3,9)
										UNION ALL
										-- UP/GU penerimaan
										SELECT 3 AS kode, SUM(A.spirc_Rp) AS debet, 0 AS kredit
										FROM tb_spirc A INNER JOIN
										tb_spi B ON A.id_spi = B.id INNER JOIN
										tb_oto C ON B.id = C.id_spi 
										WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND B.Ko_SPi IN (1,4)
										UNION ALL
										-- GU Pengeluaran
										SELECT 4 AS kode, 0 AS debet, SUM(A.spirc_Rp) AS kredit
										FROM tb_spirc A INNER JOIN
										tb_spi B ON A.id_spi = B.id INNER JOIN
										tb_oto C ON B.id = C.id_spi 
										WHERE ( MONTH(CAST(C.dt_oto AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND B.Ko_SPi IN (4,6,8)
							UNION ALL
							-- bukti potongan Pajak penerimaan GU						
							SELECT 5 AS kode, SUM(E.tax_Rp) AS debet, 0 AS kredit
							FROM tb_tax E 
							INNER JOIN (
								SELECt MIN(B.id_bprc) AS id_bprc, A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr 
								FROM tb_bp A 
								INNER JOIN tb_bprc B ON A.id_bp=B.id_bp
								WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_unit1,18) = LEFT('".kd_unit()."',18))
								GROUP BY A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr ) F ON E.id_bp=F.id_bp 
							INNER JOIN tb_byr H ON F.id_bprc=H.id_bprc
							INNER JOIN tb_spirc A ON F.id_bprc=A.id_bprc
							INNER JOIN tb_spi B ON A.id_spi = B.id 
							LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan		
							WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (4,6,7,8)
							AND MONTH(CAST(H.dt_byr AS DATE)) <= ".$bulan." AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
							UNION ALL
							-- bukti potongan Pajak penerimaan LS			
							SELECT 5 AS kode, SUM(E.tax_Rp) AS debet, 0 AS kredit
							FROM tb_tax E 
							INNER JOIN (
								SELECt MIN(B.id_bprc) AS id_bprc, A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr 
								FROM tb_bp A 
								INNER JOIN tb_bprc B ON A.id_bp=B.id_bp
								WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_unit1,18) = LEFT('".kd_unit()."',18))
								GROUP BY A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr ) F ON E.id_bp=F.id_bp 
							INNER JOIN tb_spirc A ON F.id_bprc=A.id_bprc
							INNER JOIN tb_spi B ON A.id_spi = B.id 
							INNER JOIN tb_oto C ON B.id = C.id_spi
							INNER JOIN tb_npd D ON C.id = D.id_oto 
							-- INNER JOIN (SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) J ON D.id_npd = J.id_npd
							LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan		
							WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (2,3,9)
							AND MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." AND (A.Ko_Period = ".$tahun.") AND (LEFT(E.Ko_unit1,18) = LEFT('".kd_unit()."',18))
							UNION ALL							
							-- bukti potongan pengeluaran
							SELECT 6 AS kode, 0 AS debet, SUM(B.taxtor_Rp) AS kredit
							FROM tb_taxtor A 
							INNER JOIN tb_taxtorc B ON A.id_taxtor = B.id_taxtor
							INNER JOIN tb_tax E ON B.id_tax = E.id_tax
							INNER JOIN tb_bp H ON E.Ko_Period = H.Ko_Period AND E.Ko_unit1 = H.Ko_unit1 AND E.No_bp = H.No_bp
							LEFT JOIN tb_rekan I ON LEFT(H.Ko_unit1,18) = I.Ko_unitstr AND H.nm_BUcontr = I.id_rekan	
							WHERE H.Ko_Bp IN (3, 4, 5, 9, 41)
							AND MONTH(CAST(A.dt_taxtor AS DATE)) <= ".$bulan." AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
							UNION ALL
							-- penyetoran sisa up pengeluaran
							/*
							SELECT
								10 AS kode, a.setoransisa_tgl AS tgl_bukti, a.setoransisa_no AS no_bukti, a.uraian,
								0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6, 0 AS debet, a.nilai AS kredit
							FROM trn_setoransisa a
								INNER JOIN ref_subunit k ON a.idsubunit = k.idsubunit
								INNER JOIN ref_unit l ON k.idunit = l.idunit
								INNER JOIN ref_skpd m ON l.idskpd = m.idskpd
							WHERE a.tahun = :tahun5 AND a.idsubunit LIKE :idsubunit5 AND a.setoransisa_tgl BETWEEN :tgl_15 AND :tgl_25
								AND l.idunit LIKE :idunit5 AND m.idskpd LIKE :idskpd5
							UNION ALL
							*/
							-- jurnal
							SELECT 7 AS kode, CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE 0 END AS debet,
							CASE A.Ko_DK WHEN 'K' THEN SUM(A.Rp_K) ELSE 0 END AS kredit
							FROM jr_sesuai A INNER JOIN 
							tb_sesuai B ON A.id_tbses=B.id_tbses 	
							WHERE (A.Ko_Period = ".$tahun.") AND (A.Ko_Rkk='01.01.01.03.001.0001') 
							AND ( MONTH(CAST(B.dt_sesuai AS DATE)) <= ".$bulan." )
							AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							GROUP BY A.Ko_DK
							UNION ALL
							-- saldo awal					
							SELECT 0 AS kode,
							CASE e.SN_rk3 WHEN 'D' THEN w.soaw_Rp ELSE 0 END AS Debet, CASE e.SN_rk3 WHEN 'K' THEN  w.soaw_Rp ELSE 0 END AS Kredit
							FROM tb_soaw w LEFT JOIN
							pf_rk6 b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 
							AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
							pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
							pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
							pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
							WHERE (w.Ko_Period = ".$tahun.") AND (w.ko_rkk5 = '01.01.01.03.001')	
							AND (w.Ko_unitstr = LEFT('".kd_unit()."',18))	
						),
						bku AS (
							SELECT
							a.*,
							CASE
								WHEN kode = 1 THEN 1
								WHEN kode = 2 THEN 1
								WHEN kode = 3 THEN 1
								WHEN kode = 4 THEN 1
								WHEN kode = 5 THEN 2
								WHEN kode = 6 THEN 2
								WHEN kode = 7 THEN 6
								ELSE 6
							END AS kode_summary_spj
							FROM
							(
								SELECT 0 AS kode, SUM(COALESCE(a.debet,0)) AS debet, SUM(COALESCE(a.kredit,0)) AS kredit
								FROM rincian_bukti a
								WHERE a.kode = 0
								UNION ALL
								SELECT a.*
								FROM rincian_bukti a
								WHERE a.kode != 0
							) a
						)
						SELECT
							kode_summary_spj, SUM(COALESCE(debet,0)) AS debet, SUM(COALESCE(kredit,0)) AS kredit
						FROM bku
						GROUP BY kode_summary_spj
						ORDER BY kode_summary_spj");
		}//tutup if 
		else{
			$rincianSpj = DB::select("WITH anggaran AS (								
										SELECT bel.Ko_Period AS tahun, bel.Ko_sKeg1, bel.Ko_sKeg2, bel.Ur_KegBL1, bel.Ur_KegBL2,
										LEFT(bel.ko_rkk,2) AS kdrek1, SUBSTRING(bel.ko_rkk,4,2) AS kdrek2, 
										SUBSTRING(bel.ko_rkk,7,2) AS kdrek3, SUBSTRING(bel.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(bel.Ko_Rkk,13,3) AS kdrek5, 
										RIGHT(bel.Ko_Rkk,4) AS kdrek6, bel.ko_rkk, sum(bel.To_Rp) AS jumlah
										FROM tb_tap AS bel 
										WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = LEFT('".kd_unit()."',18)
										AND (LEFT(bel.ko_rkk,2) IN (5)) 
										GROUP BY bel.Ko_Period,bel.ko_rkk,bel.Ko_sKeg1, bel.Ko_sKeg2, bel.Ur_KegBL1, bel.Ur_KegBL2
									),
									spj_ini_gu AS (
										SELECT
											A.Ko_Period AS tahun, A.Ko_sKeg1, A.Ko_sKeg2, 
											LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
											SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
											RIGHT(A.Ko_Rkk,4) AS kdrek6, A.ko_rkk,
											SUM(A.nilai) AS nilai, SUM(A.nilai_lalu) AS nilai_lalu
										FROM
										(
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_spirc A INNER JOIN
											tb_spi B ON A.id_spi = B.id INNER JOIN
											tb_oto C ON B.id = C.id_spi INNER JOIN
											tb_npd D ON C.id = D.id_oto INNER JOIN
											(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
											WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_SPi IN(4,6,8)
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
											UNION ALL
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(B.dt_bp AS DATE)) = ".$bulan." ) THEN A.To_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(B.dt_bp AS DATE)) < ".$bulan." ) THEN A.To_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_bprc A INNER JOIN
											tb_bp B ON A.id_bp=B.id_bp
											WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_bp = 2 AND B.Jn_Spm>2
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
										) A
										GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
									),
									ls_ini AS(
										SELECT
											A.Ko_Period AS tahun,A.Ko_sKeg1, A.Ko_sKeg2, 
											LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
											SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
											RIGHT(A.Ko_Rkk,4) AS kdrek6, A.ko_rkk,
											SUM(A.nilai) AS nilai, SUM(A.nilai_lalu) AS nilai_lalu
										FROM 
										(	
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_spirc A INNER JOIN
											tb_spi B ON A.id_spi = B.id INNER JOIN
											tb_oto C ON B.id = C.id_spi INNER JOIN
											tb_npd D ON C.id = D.id_oto INNER JOIN
											(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
											WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_SPi IN(2,3)
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
											UNION ALL
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, map.Ko_RKK, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) = ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(D.Dt_npd AS DATE)) < ".$bulan." ) THEN A.spirc_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_spirc A INNER JOIN
											tb_spi B ON A.id_spi = B.id INNER JOIN
											tb_oto C ON B.id = C.id_spi INNER JOIN
											tb_npd D ON C.id = D.id_oto INNER JOIN
											(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd INNER JOIN 
											pf_mapjr AS map ON A.ko_rkk = map.LO_K 
											WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_SPi IN(9)
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, map.Ko_RKK
											UNION ALL
											SELECT A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk, 
											SUM(
												CASE
													WHEN ( MONTH(CAST(B.dt_bp AS DATE)) = ".$bulan." ) THEN A.To_Rp
													ELSE 0
												END
											) AS nilai,
											SUM(
												CASE
													WHEN ( MONTH(CAST(B.dt_bp AS DATE)) < ".$bulan." ) THEN A.To_Rp
													ELSE 0
												END
											) AS nilai_lalu
											FROM tb_bprc A INNER JOIN
											tb_bp B ON A.id_bp=B.id_bp
											WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											AND B.Ko_bp = 2 AND B.Jn_Spm IN (1,2)
											GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
										) A
										GROUP BY A.Ko_Period, A.Ko_sKeg1, A.Ko_sKeg2, A.ko_rkk
									),
									koreksi AS (
										SELECT
											A.tahun, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6,
											SUM(A.nilai_ls) AS nilai_ls, 0 AS nilai_gu,
											SUM(A.nilai_ls_lalu) AS nilai_ls_lalu, 0 AS nilai_gu_lalu
										FROM (
																				
											SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
											SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											0 AS nilai_ls,
											CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE -SUM(A.Rp_K) END AS nilai_ls_lalu
											FROM jr_sesuai A INNER JOIN 
											tb_sesuai B ON A.id_tbses=B.id_tbses 	
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='05') 
											AND ( MONTH(CAST(B.dt_sesuai AS DATE)) < ".$bulan." )
											AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK, A.Ko_sKeg1, A.Ko_sKeg2
											
											UNION ALL
										
											SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
											SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, 
											CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE -SUM(A.Rp_K) END AS nilai_ls,
											0 AS nilai_ls_lalu
											FROM jr_sesuai A INNER JOIN 
											tb_sesuai B ON A.id_tbses=B.id_tbses 
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='05') 
											AND ( MONTH(CAST(B.dt_sesuai AS DATE)) = ".$bulan.") 
											AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
											GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK, A.Ko_sKeg1, A.Ko_sKeg2
										) A
										GROUP BY A.tahun, A.Ko_Rkk, A.Ko_sKeg1, A.Ko_sKeg2, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6
									)
									SELECT  a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6 AS nmrek6,
									SUM(a.jumlah) AS anggaran, SUM(COALESCE(b.nilai, 0) + COALESCE(f.nilai_gu, 0)) AS nilai_gu_ini, SUM(COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)) AS nilai_ls_ini,
									SUM(
										CASE
											WHEN rek.Jns_LS = 1 THEN COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)
											ELSE 0
										END
									) AS nilai_ls_gaji_ini,
									SUM(
										CASE
											WHEN rek.Jns_LS != 1 THEN COALESCE(c.nilai, 0) + COALESCE(f.nilai_ls, 0)
											ELSE 0
										END
									) AS nilai_ls_barang_jasa_ini,
									SUM(COALESCE(b.nilai_lalu, 0) + COALESCE(f.nilai_gu_lalu, 0)) AS nilai_gu_lalu, SUM(COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)) AS nilai_ls_lalu,
									SUM(
										CASE
											WHEN rek.Jns_LS = 1 THEN COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)
											ELSE 0
										END
									) AS nilai_ls_gaji_lalu,
									SUM(
										CASE
											WHEN rek.Jns_LS != 1 THEN COALESCE(c.nilai_lalu, 0) + COALESCE(f.nilai_ls_lalu, 0)
											ELSE 0
										END
									) AS nilai_ls_barang_jasa_lalu
									FROM anggaran a
									LEFT JOIN spj_ini_gu b ON a.Ko_sKeg1 = b.Ko_sKeg1 AND a.Ko_sKeg2 = b.Ko_sKeg2
									AND a.kdrek1 = b.kdrek1 AND a.kdrek2 = b.kdrek2 AND a.kdrek3 = b.kdrek3 AND a.kdrek4 = b.kdrek4 AND a.kdrek5 = b.kdrek5 AND a.kdrek6 = b.kdrek6
									LEFT JOIN ls_ini c ON a.Ko_sKeg1 = c.Ko_sKeg1 AND a.Ko_sKeg2 = c.Ko_sKeg2
									AND a.kdrek1 = c.kdrek1 AND a.kdrek2 = c.kdrek2 AND a.kdrek3 = c.kdrek3 AND a.kdrek4 = c.kdrek4 AND a.kdrek5 = c.kdrek5 AND a.kdrek6 = c.kdrek6
									LEFT JOIN koreksi f ON a.Ko_sKeg1 = f.Ko_sKeg1 AND a.Ko_sKeg2 = f.Ko_sKeg2
									AND a.kdrek1 = f.kdrek1 AND a.kdrek2 = f.kdrek2 AND a.kdrek3 = f.kdrek3 AND a.kdrek4 = f.kdrek4 AND a.kdrek5 = f.kdrek5 AND a.kdrek6 = f.kdrek6
									INNER JOIN pf_rk6 AS rek ON a.kdrek1 = rek.Ko_Rk1 AND a.kdrek2 = rek.Ko_Rk2 AND a.kdrek3 = rek.Ko_Rk3 AND a.kdrek4 = rek.Ko_Rk4 
									AND a.kdrek5 = rek.Ko_Rk5 AND a.kdrek6 = rek.Ko_Rk6
									GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6
									ORDER BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, rek.Ur_Rk6");
									
			$spjfooter = DB::select("WITH rincian_bukti AS
						(
							-- LS Penerimaan Total
							SELECT 1 AS kode, SUM(A.spirc_Rp) AS debet, 0 AS kredit
							FROM tb_spirc A INNER JOIN
							tb_spi B ON A.id_spi = B.id INNER JOIN
							tb_oto C ON B.id = C.id_spi INNER JOIN
							tb_npd D ON C.id = D.id_oto INNER JOIN
							(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
							WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_SPi IN(2,3,9)
							UNION ALL
							SELECT 8 AS kode, SUM(A.To_Rp) AS debet, 0 AS kredit
							FROM tb_bprc A INNER JOIN
							tb_bp B ON A.id_bp=B.id_bp
							WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_bp = 2 AND B.Jn_Spm IN (1,2)							
							UNION ALL
							-- LS Pengeluaran Rinci
							SELECT 2 AS kode, 0 AS debet, SUM(A.spirc_Rp) AS kredit
							FROM tb_spirc A INNER JOIN
							tb_spi B ON A.id_spi = B.id INNER JOIN
							tb_oto C ON B.id = C.id_spi INNER JOIN
							tb_npd D ON C.id = D.id_oto INNER JOIN
							(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
							WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_SPi IN(2,3,9)
							UNION ALL
							SELECT 8 AS kode, 0 AS debet, SUM(A.To_Rp) AS kredit
							FROM tb_bprc A INNER JOIN
							tb_bp B ON A.id_bp=B.id_bp
							WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_bp = 2 AND B.Jn_Spm IN (1,2)
							UNION ALL
							-- up/gu penerimaan
							SELECT 3 AS kode, SUM(A.spirc_Rp) AS debet, 0 AS kredit
							FROM tb_spirc A INNER JOIN
							tb_spi B ON A.id_spi = B.id INNER JOIN
							tb_oto C ON B.id = C.id_spi INNER JOIN
							tb_npd D ON C.id = D.id_oto INNER JOIN
							(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
							WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_SPi IN(1, 4)
							UNION ALL
							SELECT 8 AS kode, SUM(A.To_Rp) AS debet, 0 AS kredit
							FROM tb_bprc A INNER JOIN
							tb_bp B ON A.id_bp=B.id_bp
							WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_bp = 2 AND B.Jn_Spm > 2
							UNION ALL
							-- gu Pengeluaran
							SELECT 4 AS kode, 0 AS debet, SUM(A.spirc_Rp) AS kredit
							FROM tb_spirc A INNER JOIN
							tb_spi B ON A.id_spi = B.id INNER JOIN
							tb_oto C ON B.id = C.id_spi INNER JOIN
							tb_npd D ON C.id = D.id_oto INNER JOIN
							(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
							WHERE ( MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_SPi IN(4, 6, 8)
							UNION ALL
							SELECT 8 AS kode, 0 AS debet, SUM(A.To_Rp) AS kredit
							FROM tb_bprc A INNER JOIN
							tb_bp B ON A.id_bp=B.id_bp
							WHERE ( MONTH(CAST(B.dt_bp AS DATE)) <= ".$bulan." ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							AND B.Ko_bp = 2 AND B.Jn_Spm > 2
							UNION ALL
							-- bukti potongan Pajak penerimaan GU						
							SELECT 5 AS kode, SUM(E.tax_Rp) AS debet, 0 AS kredit
							FROM tb_tax E 
							INNER JOIN tb_bp F ON E.id_bp=F.id_bp
							INNER JOIN tb_bprc G ON F.id_bp=G.id_bp
							INNER JOIN tb_byr H ON G.id_bprc=H.id_bprc
							INNER JOIN tb_spirc A ON G.id_bprc=A.id_bprc
							INNER JOIN tb_spi B ON A.id_spi = B.id 
							LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan		
							WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (4,6,7,8)
							AND MONTH(CAST(H.dt_byr AS DATE)) <= ".$bulan." AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
							UNION ALL
							-- bukti potongan Pajak penerimaan LS			
							SELECT 5 AS kode, SUM(E.tax_Rp) AS debet, 0 AS kredit
							FROM tb_tax E 
							INNER JOIN tb_bp F ON E.id_bp=F.id_bp
							INNER JOIN tb_bprc G ON F.id_bp=G.id_bp
							INNER JOIN tb_spirc A ON G.id_bprc=A.id_bprc
							INNER JOIN tb_spi B ON A.id_spi = B.id 
							INNER JOIN tb_oto C ON B.id = C.id_spi
							INNER JOIN tb_npd D ON C.id = D.id_oto 
							-- INNER JOIN (SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) J ON D.id_npd = J.id_npd
							LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan		
							WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (2,3,9)
							AND MONTH(CAST(D.Dt_npd AS DATE)) <= ".$bulan." AND (A.Ko_Period = ".$tahun.") AND (LEFT(E.Ko_unit1,18) = LEFT('".kd_unit()."',18))
							UNION ALL							
							-- bukti potongan pengeluaran
							SELECT 6 AS kode, 0 AS debet, SUM(B.taxtor_Rp) AS kredit
							FROM tb_taxtor A 
							INNER JOIN tb_taxtorc B ON A.id_taxtor = B.id_taxtor
							INNER JOIN tb_tax E ON B.id_tax = E.id_tax
							INNER JOIN tb_bp H ON E.Ko_Period = H.Ko_Period AND E.Ko_unit1 = H.Ko_unit1 AND E.No_bp = H.No_bp
							LEFT JOIN tb_rekan I ON LEFT(H.Ko_unit1,18) = I.Ko_unitstr AND H.nm_BUcontr = I.id_rekan	
							WHERE H.Ko_Bp IN (3, 4, 5, 9, 41)
							AND MONTH(CAST(A.dt_taxtor AS DATE)) <= ".$bulan." AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
							UNION ALL
							-- penyetoran sisa up pengeluaran
							/*
							SELECT
								10 AS kode, a.setoransisa_tgl AS tgl_bukti, a.setoransisa_no AS no_bukti, a.uraian,
								0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6, 0 AS debet, a.nilai AS kredit
							FROM trn_setoransisa a
								INNER JOIN ref_subunit k ON a.idsubunit = k.idsubunit
								INNER JOIN ref_unit l ON k.idunit = l.idunit
								INNER JOIN ref_skpd m ON l.idskpd = m.idskpd
							WHERE a.tahun = :tahun5 AND a.idsubunit LIKE :idsubunit5 AND a.setoransisa_tgl BETWEEN :tgl_15 AND :tgl_25
								AND l.idunit LIKE :idunit5 AND m.idskpd LIKE :idskpd5
							UNION ALL
							*/
							-- jurnal
							SELECT 7 AS kode, CASE A.Ko_DK WHEN 'D' THEN SUM(A.Rp_D) ELSE 0 END AS debet,
							CASE A.Ko_DK WHEN 'K' THEN SUM(A.Rp_K) ELSE 0 END AS kredit
							FROM jr_sesuai A INNER JOIN 
							tb_sesuai B ON A.id_tbses=B.id_tbses 	
							WHERE (A.Ko_Period = ".$tahun.") AND (A.Ko_Rkk='01.01.01.03.001.0001') 
							AND ( MONTH(CAST(B.dt_sesuai AS DATE)) <= ".$bulan." )
							AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
							GROUP BY A.Ko_DK
							UNION ALL
							-- saldo awal					
							SELECT 0 AS kode,
							CASE e.SN_rk3 WHEN 'D' THEN w.soaw_Rp ELSE 0 END AS Debet, CASE e.SN_rk3 WHEN 'K' THEN  w.soaw_Rp ELSE 0 END AS Kredit
							FROM tb_soaw w LEFT JOIN
							pf_rk6 b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 
							AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
							pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
							pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
							pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
							WHERE (w.Ko_Period = ".$tahun.") AND (w.ko_rkk5 = '01.01.01.03.001')	
							AND (w.Ko_unitstr = LEFT('".kd_unit()."',18))	
						),
						bku AS (
							SELECT
							a.*,
							CASE
								WHEN kode = 1 THEN 1
								WHEN kode = 2 THEN 1
								WHEN kode = 3 THEN 1
								WHEN kode = 4 THEN 1
								WHEN kode = 5 THEN 2
								WHEN kode = 6 THEN 2
								WHEN kode = 7 THEN 6
								WHEN kode = 8 THEN 3
								ELSE 6
							END AS kode_summary_spj
							FROM
							(
								SELECT 0 AS kode, SUM(COALESCE(a.debet,0)) AS debet, SUM(COALESCE(a.kredit,0)) AS kredit
								FROM rincian_bukti a
								WHERE a.kode = 0
								UNION ALL
								SELECT a.*
								FROM rincian_bukti a
								WHERE a.kode != 0
							) a
						)
						SELECT
							kode_summary_spj, SUM(COALESCE(debet,0)) AS debet, SUM(COALESCE(kredit,0)) AS kredit
						FROM bku
						GROUP BY kode_summary_spj
						ORDER BY kode_summary_spj");

		}// tutup else 
		
		$data = [
			'rincianSpj' => $rincianSpj,
			'spjfooter' => $spjfooter,
			'ambilbidang' => $bid,
			'ambilskpd' => $skpd,
			'ambilunit' => $unit,
			'refPemda' => $pemda,
			'tahun' => $tahun,
		];

        return [
            'data' => $data,
        ];
    }
}
