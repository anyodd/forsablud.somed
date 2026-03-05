<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLakController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.pembukuan.cetak-lapkeu';
    }

    public static function Laporan($tahun, $tgl_1, $tgl_2)
    {
		$data = null;
		$ambilbidang = 0;
		$ambilskpd = 0;
		$ambilunit = 0;
		$ambilprogram = 0;
		$ambilkegiatan = 0;

		
        $pemda = DB::select("SELECT CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) AS Ko_pemda, ur_pemda AS nmpemda 
							FROM tb_pemda
							WHERE CONCAT(LPAD(ko_wil1,2,0),'.',LPAD(ko_wil2,2,0)) = LEFT('".kd_unit()."',5)
							ORDER BY ko_wil1, ko_wil2 ");
        $tahun = Tahun();
		
		$bid = DB::SELECT("SELECT DISTINCT u.Ko_Urus AS kdurusan, u.Ur_Urus AS nmurusan, b.id AS idbidang, b.Ur_Bid AS nmbidang, 
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
		
		DB::statement("CALL SP_SaldoAkhir ( 5, ".$tahun.", '".$tgl_2."','".kd_unit()."')"); 
                
		$arusKasRinci = DB::select("WITH saldo_berjalan AS ( 
						SELECT
								CASE
									WHEN a.kdrek1 = 5 AND a.kdrek2 = 2 THEN 2
									WHEN a.kdrek1 = 6 THEN 3
									WHEN a.kdrek1 = 2 THEN 4
									ELSE 1
								END AS kd_aktivitas,
								CASE
									WHEN a.kdrek1 = 4 THEN 1
									WHEN a.kdrek1 = 5 THEN 2
									WHEN a.kdrek1 = 6 AND a.kdrek2 = 1 THEN 1
									WHEN a.kdrek1 = 6 AND a.kdrek2 = 2 THEN 2
									-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 1 THEN 1
									-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 2 THEN 2
									ELSE 0
								END AS kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, b.Ur_Rk3 AS nmrek3,
								SUM(a.saldo) AS saldo
						FROM tb_saldo a 
						INNER JOIN pf_rk3 b ON a.kdrek1=b.Ko_Rk1 AND a.kdrek2=b.Ko_Rk2 AND a.kdrek3=b.Ko_Rk3
						WHERE a.tahun = ".$tahun." AND a.bukti_tgl = '".$tgl_2."' AND a.Ko_unitstr='".kd_unit()."' AND a.Kode=5
						AND a.kdrek1 IN (4, 5, 6)
						AND NOT (a.kdrek1 = 6 AND a.kdrek2 = 3)
						AND NOT (a.kdrek1 = 6 AND a.kdrek2 = 1 AND a.kdrek3 = 1) 
						GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, b.Ur_Rk3
						UNION ALL
						SELECT
								4 AS kd_aktivitas,
								2 AS kd_arus,
								a.kdrek1, a.kdrek2, a.kdrek3,
								CASE
									WHEN a.kdrek1 = 6 AND a.kdrek2 = 1 AND a.kdrek3 = 1 AND a.kdrek4 = 99 THEN c.Ur_Rk4
									ELSE b.Ur_Rk3
								END AS nmrek3,
								SUM(a.saldo) AS saldo
						FROM tb_saldo a
						INNER JOIN pf_rk3 b ON a.kdrek1=b.Ko_Rk1 AND a.kdrek2=b.Ko_Rk2 AND a.kdrek3=b.Ko_Rk3
						INNER JOIN pf_rk4 c ON a.kdrek1=c.Ko_Rk1 AND a.kdrek2=c.Ko_Rk2 AND a.kdrek3=c.Ko_Rk3 AND a.kdrek4=c.Ko_Rk4
						WHERE a.tahun = ".$tahun." AND a.bukti_tgl = '".$tgl_2."' AND a.Ko_unitstr='".kd_unit()."' AND a.Kode=5
						AND a.kdrek1 IN (4, 5, 6, 9)
						AND NOT (a.kdrek1 = 6 AND a.kdrek2 = 3)
						AND (a.kdrek1 = 6 AND a.kdrek2 = 1 AND a.kdrek3 = 1 AND a.kdrek4 = 99)
						GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, b.Ur_Rk3, c.Ur_Rk4
					),
					saldo_awal AS (
						SELECT
								CASE
									WHEN LEFT(a.ko_rkk5,2) = 5 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									WHEN LEFT(a.ko_rkk5,2) = 6 THEN 3
									WHEN LEFT(a.ko_rkk5,2) = 2 THEN 4
									ELSE 1
								END AS kd_aktivitas,
								CASE
									WHEN LEFT(a.ko_rkk5,2) = 4 THEN 1
									WHEN LEFT(a.ko_rkk5,2) = 5 THEN 2
									WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
									WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
									-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									ELSE 0
								END AS kd_arus, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, b.Ur_Rk3 AS nmrek3,
								SUM(CASE
										WHEN b.SN_rk3 = 'D' THEN a.soaw_Rp_D
										WHEN b.SN_rk3 = 'K' THEN a.soaw_Rp_K
										ELSE 0
								END) AS saldo
						FROM tb_soaw a 	
						INNER JOIN pf_rk3 b ON LEFT(a.ko_rkk5,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=b.Ko_Rk3
						WHERE a.Ko_Period = ".$tahun." AND a.Ko_unitstr='".kd_unit()."'
						AND LEFT(a.ko_rkk5,2) IN (4, 5, 6)
						AND NOT (LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 3)
						AND NOT (LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1) 
						GROUP BY a.ko_rkk5, b.Ur_Rk3
						UNION ALL
						SELECT
								4 AS kd_aktivitas,
								2 AS kd_arus,
								LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, 
								CASE
									WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 AND SUBSTRING(a.ko_rkk5,10,2) = 99 THEN c.Ur_Rk4
									ELSE b.Ur_Rk3
								END AS nmrek3,
								SUM(CASE
										WHEN b.SN_rk3 = 'D' THEN a.soaw_Rp_D
										WHEN b.SN_rk3 = 'K' THEN a.soaw_Rp_K
										ELSE 0
								END) AS saldo
						FROM tb_soaw a
						INNER JOIN pf_rk3 b ON LEFT(a.ko_rkk5,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=b.Ko_Rk3
						INNER JOIN pf_rk4 c ON LEFT(a.ko_rkk5,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=b.Ko_Rk3 
						AND SUBSTRING(a.ko_rkk5,10,2)=c.Ko_Rk4
						WHERE a.Ko_Period = ".$tahun." AND a.Ko_unitstr='".kd_unit()."' 
						AND LEFT(a.ko_rkk5,2) IN (4, 5, 6)
						AND NOT (LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 3)
						AND (LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 AND SUBSTRING(a.ko_rkk5,10,2) = 99)
						GROUP BY a.ko_rkk5, b.Ur_Rk3, c.Ur_Rk4
					)
					SELECT a.kd_aktivitas,
					CASE
						WHEN a.kd_aktivitas = 1 THEN 'Aktivitas Operasi'
						WHEN a.kd_aktivitas = 2 THEN 'Aktivitas Investasi'
						WHEN a.kd_aktivitas = 3 THEN 'Aktivitas Pendanaan'
						ELSE 'Aktivitas Transitoris'
					END AS uraian_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, SUM(saldo) AS saldo, SUM(a.saldo_sa) AS saldo_sa
					FROM
					(
						SELECT a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, SUM(a.saldo) AS saldo, 0 AS saldo_sa
						FROM saldo_berjalan a
						GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
						UNION ALL
						SELECT a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, 0 AS saldo, SUM(a.saldo)  AS saldo_sa
						FROM saldo_awal a
						GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
					) a
					GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
					ORDER BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3 ASC");

		$saldoKasRkud = DB::select("WITH saldo_berjalan AS ( 
						SELECT
								CASE
									WHEN a.kdrek1 = 5 AND a.kdrek2 = 2 THEN 2
									WHEN a.kdrek1 = 6 THEN 3
									WHEN a.kdrek1 = 2 THEN 4
									ELSE 1
								END AS kd_aktivitas,
								CASE
									WHEN a.kdrek1 = 4 THEN 1
									WHEN a.kdrek1 = 5 THEN 2
									WHEN a.kdrek1 = 6 AND a.kdrek2 = 1 THEN 1
									WHEN a.kdrek1 = 6 AND a.kdrek2 = 2 THEN 2
									-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 1 THEN 1
									-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 2 THEN 2
									ELSE 0
								END AS kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, b.Ur_Rk3 AS nmrek3,
								SUM(a.saldo) AS saldo
						FROM tb_saldo a 
						INNER JOIN pf_rk3 b ON a.kdrek1=b.Ko_Rk1 AND a.kdrek2=b.Ko_Rk2 AND a.kdrek3=b.Ko_Rk3
						WHERE a.tahun = ".$tahun." AND a.bukti_tgl = '".$tgl_2."' AND a.Ko_unitstr='".kd_unit()."' AND a.Kode=5
						AND (a.kdrek1 = 1 AND a.kdrek2 = 1 AND a.kdrek3 = 1 ) 
						GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, b.Ur_Rk3
					),
					saldo_awal AS (
						SELECT
								CASE
									WHEN LEFT(a.ko_rkk5,2) = 5 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									WHEN LEFT(a.ko_rkk5,2) = 6 THEN 3
									WHEN LEFT(a.ko_rkk5,2) = 2 THEN 4
									ELSE 1
								END AS kd_aktivitas,
								CASE
									WHEN LEFT(a.ko_rkk5,2) = 4 THEN 1
									WHEN LEFT(a.ko_rkk5,2) = 5 THEN 2
									WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
									WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
									-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
									ELSE 0
								END AS kd_arus, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, b.Ur_Rk3 AS nmrek3,
								SUM(CASE
										WHEN b.SN_rk3 = 'D' THEN a.soaw_Rp_D
										WHEN b.SN_rk3 = 'K' THEN a.soaw_Rp_K
										ELSE 0
								END) AS saldo
						FROM tb_soaw a 	
						INNER JOIN pf_rk3 b ON LEFT(a.ko_rkk5,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=b.Ko_Rk3
						WHERE a.Ko_Period = ".$tahun." AND a.Ko_unitstr='".kd_unit()."'
						AND (LEFT(a.ko_rkk5,2) = 1 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 ) 
						GROUP BY a.ko_rkk5, b.Ur_Rk3
					)
					SELECT a.kd_aktivitas,
					CASE
						WHEN a.kd_aktivitas = 1 THEN 'Aktivitas Operasi'
						WHEN a.kd_aktivitas = 2 THEN 'Aktivitas Investasi'
						WHEN a.kd_aktivitas = 3 THEN 'Aktivitas Pendanaan'
						ELSE 'Aktivitas Transitoris'
					END AS uraian_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, SUM(saldo) AS saldo, SUM(a.saldo_sa) AS saldo_sa
					FROM
					(
						SELECT a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, SUM(a.saldo) AS saldo, 0 AS saldo_sa
						FROM saldo_berjalan a
						GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
						UNION ALL
						SELECT a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, 0 AS saldo, SUM(a.saldo)  AS saldo_sa
						FROM saldo_awal a
						GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
					) a
					GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3
					ORDER BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3 ASC");

		$saldoKasLainnya = DB::select("WITH saldo_berjalan AS ( 
							SELECT
									CASE
										WHEN a.kdrek1 = 5 AND a.kdrek2 = 2 THEN 2
										WHEN a.kdrek1 = 6 THEN 3
										WHEN a.kdrek1 = 2 THEN 4
										ELSE 1
									END AS kd_aktivitas,
									CASE
										WHEN a.kdrek1 = 4 THEN 1
										WHEN a.kdrek1 = 5 THEN 2
										WHEN a.kdrek1 = 6 AND a.kdrek2 = 1 THEN 1
										WHEN a.kdrek1 = 6 AND a.kdrek2 = 2 THEN 2
										-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 1 THEN 1
										-- WHEN a.kdrek1 = 2 AND a.kdrek2 = 2 THEN 2
										ELSE 0
									END AS kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, b.Ur_Rk3 AS nmrek3, a.kdrek4, c.Ur_Rk4 AS nmrek4,
									SUM(a.saldo) AS saldo
							FROM tb_saldo a
							INNER JOIN pf_rk3 b ON a.kdrek1=b.Ko_Rk1 AND a.kdrek2=b.Ko_Rk2 AND a.kdrek3=b.Ko_Rk3
							INNER JOIN pf_rk4 c ON a.kdrek1=c.Ko_Rk1 AND a.kdrek2=c.Ko_Rk2 AND a.kdrek3=c.Ko_Rk3 AND a.kdrek4=c.Ko_Rk4
							WHERE a.tahun = ".$tahun." AND a.bukti_tgl = '".$tgl_2."' AND a.Ko_unitstr='".kd_unit()."' AND a.Kode=5
							AND (a.kdrek1 = 1 AND a.kdrek2 = 1 AND a.kdrek3 = 1 ) 
							GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, b.Ur_Rk3, c.Ur_Rk4
						),
						saldo_awal AS (
							SELECT
									CASE
										WHEN LEFT(a.ko_rkk5,2) = 5 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
										WHEN LEFT(a.ko_rkk5,2) = 6 THEN 3
										WHEN LEFT(a.ko_rkk5,2) = 2 THEN 4
										ELSE 1
									END AS kd_aktivitas,
									CASE
										WHEN LEFT(a.ko_rkk5,2) = 4 THEN 1
										WHEN LEFT(a.ko_rkk5,2) = 5 THEN 2
										WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
										WHEN LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
										-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 1 THEN 1
										-- WHEN LEFT(a.ko_rkk5,2) = 9 AND SUBSTRING(a.ko_rkk5,4,2) = 2 THEN 2
										ELSE 0
									END AS kd_arus, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, b.Ur_Rk3 AS nmrek3,
									SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, c.Ur_Rk4 AS nmrek4, 
									SUM(CASE
											WHEN b.SN_rk3 = 'D' THEN a.soaw_Rp_D
											WHEN b.SN_rk3 = 'K' THEN a.soaw_Rp_K
											ELSE 0
									END) AS saldo
							FROM tb_soaw a 	
							INNER JOIN pf_rk3 b ON LEFT(a.ko_rkk5,2)=b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=b.Ko_Rk3
							INNER JOIN pf_rk4 c ON LEFT(a.ko_rkk5,2)=c.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2)=c.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2)=c.Ko_Rk3 AND SUBSTRING(a.ko_rkk5,10,2)=c.Ko_Rk4
							WHERE a.Ko_Period = ".$tahun." AND a.Ko_unitstr='".kd_unit()."'
							AND (LEFT(a.ko_rkk5,2) = 1 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 ) 
							GROUP BY a.ko_rkk5, b.Ur_Rk3, c.Ur_Rk4
						)
						SELECT
							a.kd_aktivitas,
							CASE
								WHEN a.kd_aktivitas = 1 THEN 'Aktivitas Operasi'
								WHEN a.kd_aktivitas = 2 THEN 'Aktivitas Investasi'
								WHEN a.kd_aktivitas = 3 THEN 'Aktivitas Pendanaan'
								ELSE 'Aktivitas Transitoris'
							END AS uraian_aktivitas,
							a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, a.kdrek4, a.nmrek4, SUM(saldo) AS saldo, SUM(a.saldo_sa) AS saldo_sa
						FROM
						(
							SELECT a.*, 0 AS saldo_sa
							FROM saldo_berjalan a
							UNION ALL
							SELECT a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, a.kdrek4, a.nmrek4, 0 AS saldo, a.saldo AS saldo_sa
							FROM saldo_awal a
						) a
						GROUP BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.nmrek3, a.kdrek4, a.nmrek4
						HAVING a.kdrek4<>1
						ORDER BY a.kd_aktivitas, a.kd_arus, a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4 ASC");


		$data = [
			'saldoKasRkud' => collect($saldoKasRkud)->first(),
			'arusKasRinci' => $arusKasRinci,
			'saldoKasLainnya' => $saldoKasLainnya,
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
