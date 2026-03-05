<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLoSapController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.pembukuan.cetak-lapkeu';
    }

    public static function Laporan($tahun, $tgl_2)
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
        $id_bidang = bidang_id(kd_unit());
		$pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = ".$id_bidang." GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";
		
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
                
		$rincianLO = DB::select("WITH saldo_berjalan AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4,
                            SUM(
                            CASE
                                WHEN n.kdrek1 = 9 THEN temp1.debet - temp1.kredit
                                WHEN n.kdrek1 = 8 THEN temp1.kredit - temp1.debet
                                ELSE 0
                            END) AS saldo_tahun_ini
                        FROM
                            (
                                SELECT q.tahun, q.kdrek1, q.kdrek2, q.kdrek3, q.kdrek4, q.kdrek5, q.kdrek6, q.debet, q.kredit
                                FROM tb_saldo q
                                WHERE (q.kdrek1 IN (7,8)) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
                            ) temp1 LEFT JOIN 
							pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    saldo_awal AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
                        FROM
                        (
                            SELECT w.Ko_Period AS tahun, LEFT(w.ko_rkk5,2) AS kdrek1, SUBSTRING(w.ko_rkk5,4,2) AS kdrek2, SUBSTRING(w.ko_rkk5,7,2) AS kdrek3, 
							SUBSTRING(w.ko_rkk5,10,2) AS kdrek4, SUBSTRING(w.ko_rkk5,13,3) AS kdrek5, 1 AS kdrek6, 
							CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS nilai, e.SN_rk3 AS d_k,
                            CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS saldo_tahun_lalu
                            FROM tb_soaw w LEFT JOIN
								". $pf_rk6 . " b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE (w.Ko_Period = ".$tahun.") AND (LEFT(w.ko_rkk5,2) IN (7, 8)) AND w.Ko_unitstr = LEFT('".kd_unit()."',18)
                        ) temp1 LEFT JOIN 
						pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    LO AS
                    (
						SELECT *
						FROM
						(
							SELECT temp1.tahun,
								CONCAT(temp1.kdrek1,'.',RIGHT(CONCAT('0', temp1.kdrek2), 2),'.',RIGHT(CONCAT('0', temp1.kdrek3), 2)) AS koderekening,
								temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3,
								sum(temp1.saldo_tahun_ini) AS saldo_tahun_ini, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
							FROM
							(
								SELECT saldo_berjalan.tahun, saldo_berjalan.kdrek1, saldo_berjalan.kdrek2, saldo_berjalan.kdrek3,
									saldo_berjalan.saldo_tahun_ini, 0 AS saldo_tahun_lalu
								FROM saldo_berjalan
								UNION ALL
								SELECT saldo_awal.tahun, saldo_awal.kdrek1, saldo_awal.kdrek2, saldo_awal.kdrek3,
									0 AS saldo_tahun_ini, saldo_awal.saldo_tahun_lalu
								FROM saldo_awal
							) temp1
								INNER JOIN pf_sap3 rek3 ON temp1.kdrek1 = rek3.kdrek1 AND temp1.kdrek2 = rek3.kdrek2 AND temp1.kdrek3 = rek3.kdrek3
								INNER JOIN pf_sap2 rek2 ON temp1.kdrek1 = rek2.kdrek1 AND temp1.kdrek2 = rek2.kdrek2
								INNER JOIN pf_sap1 rek1 ON temp1.kdrek1 = rek1.kdrek1
							GROUP BY temp1.tahun, temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3
						) temp2
						WHERE temp2.koderekening NOT LIKE '10.01%' AND temp2.koderekening NOT LIKE '10.02%' AND temp2.koderekening NOT LIKE '10.03%'
                        AND temp2.koderekening NOT LIKE '10.04%' AND temp2.koderekening NOT LIKE '10.05%' AND temp2.koderekening NOT LIKE '10.06%'
                        AND temp2.koderekening NOT LIKE '11.01%' AND temp2.koderekening NOT LIKE '11.02%'
                    )
                    SELECT
                        CONCAT(kdrek1,'') AS koderekening, nmrek1 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,nmrek1
                    UNION ALL
                    SELECT
                        CONCAT(kdrek1,'.',RIGHT(CONCAT('0',kdrek2),2)) AS koderekening, nmrek2 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,kdrek2,nmrek2
                    UNION ALL
                    SELECT
                        koderekening, nmrek3 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY koderekening,nmrek3
                    ORDER BY koderekening");
		$rincianLO2 = DB::select("WITH saldo_berjalan AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4,
                            SUM(
                            CASE
                                WHEN n.kdrek1 = 9 THEN temp1.debet - temp1.kredit
                                WHEN n.kdrek1 = 8 THEN temp1.kredit - temp1.debet
                                ELSE 0
                            END) AS saldo_tahun_ini
                        FROM
                            (
                                SELECT q.tahun, q.kdrek1, q.kdrek2, q.kdrek3, q.kdrek4, q.kdrek5, q.kdrek6, q.debet, q.kredit
                                FROM tb_saldo q
                                WHERE (q.kdrek1 IN (7,8)) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
                            ) temp1 LEFT JOIN 
							pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    saldo_awal AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
                        FROM
                        (
                            SELECT w.Ko_Period AS tahun, LEFT(w.ko_rkk5,2) AS kdrek1, SUBSTRING(w.ko_rkk5,4,2) AS kdrek2, SUBSTRING(w.ko_rkk5,7,2) AS kdrek3, 
							SUBSTRING(w.ko_rkk5,10,2) AS kdrek4, SUBSTRING(w.ko_rkk5,13,3) AS kdrek5, 1 AS kdrek6, 
							CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS nilai, e.SN_rk3 AS d_k,
                            CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS saldo_tahun_lalu
                            FROM tb_soaw w LEFT JOIN
								". $pf_rk6 . " b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE (w.Ko_Period = ".$tahun.") AND (LEFT(w.ko_rkk5,2) IN (7, 8)) AND w.Ko_unitstr = LEFT('".kd_unit()."',18)
                        ) temp1 LEFT JOIN 
						pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    LO AS
                    (
						SELECT *
						FROM
						(
							SELECT temp1.tahun,
								CONCAT(temp1.kdrek1,'.',RIGHT(CONCAT('0', temp1.kdrek2), 2),'.',RIGHT(CONCAT('0', temp1.kdrek3), 2)) AS koderekening,
								temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3,
								sum(temp1.saldo_tahun_ini) AS saldo_tahun_ini, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
							FROM
							(
								SELECT saldo_berjalan.tahun, saldo_berjalan.kdrek1, saldo_berjalan.kdrek2, saldo_berjalan.kdrek3,
									saldo_berjalan.saldo_tahun_ini, 0 AS saldo_tahun_lalu
								FROM saldo_berjalan
								UNION ALL
								SELECT saldo_awal.tahun, saldo_awal.kdrek1, saldo_awal.kdrek2, saldo_awal.kdrek3,
									0 AS saldo_tahun_ini, saldo_awal.saldo_tahun_lalu
								FROM saldo_awal
							) temp1
								INNER JOIN pf_sap3 rek3 ON temp1.kdrek1 = rek3.kdrek1 AND temp1.kdrek2 = rek3.kdrek2 AND temp1.kdrek3 = rek3.kdrek3
								INNER JOIN pf_sap2 rek2 ON temp1.kdrek1 = rek2.kdrek1 AND temp1.kdrek2 = rek2.kdrek2
								INNER JOIN pf_sap1 rek1 ON temp1.kdrek1 = rek1.kdrek1
							GROUP BY temp1.tahun, temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3
						) temp2
						WHERE temp2.koderekening LIKE '10.01%' OR temp2.koderekening LIKE '10.02%' OR temp2.koderekening LIKE '10.03%'
                        OR temp2.koderekening LIKE '10.04%' OR temp2.koderekening LIKE '10.05%' OR temp2.koderekening LIKE '10.06%'
                    )
                    SELECT
                        CONCAT(kdrek1,'') AS koderekening, nmrek1 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,nmrek1
                    UNION ALL
                    SELECT
                        CONCAT(kdrek1,'.',RIGHT(CONCAT('0',kdrek2),2)) AS koderekening, nmrek2 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,kdrek2,nmrek2
                    UNION ALL
                    SELECT
                        koderekening, nmrek3 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY koderekening,nmrek3
                    ORDER BY koderekening");
		$rincianLO3 = DB::select("WITH saldo_berjalan AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4,
                            SUM(
                            CASE
                                WHEN n.kdrek1 = 9 THEN temp1.debet - temp1.kredit
                                WHEN n.kdrek1 = 8 THEN temp1.kredit - temp1.debet
                                ELSE 0
                            END) AS saldo_tahun_ini
                        FROM
                            (
                                SELECT q.tahun, q.kdrek1, q.kdrek2, q.kdrek3, q.kdrek4, q.kdrek5, q.kdrek6, q.debet, q.kredit
                                FROM tb_saldo q
                                WHERE (q.kdrek1 IN (7,8)) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
                            ) temp1 LEFT JOIN 
							pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    saldo_awal AS
                    (
                        SELECT temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
                        FROM
                        (
                            SELECT w.Ko_Period AS tahun, LEFT(w.ko_rkk5,2) AS kdrek1, SUBSTRING(w.ko_rkk5,4,2) AS kdrek2, SUBSTRING(w.ko_rkk5,7,2) AS kdrek3, 
							SUBSTRING(w.ko_rkk5,10,2) AS kdrek4, SUBSTRING(w.ko_rkk5,13,3) AS kdrek5, 1 AS kdrek6, 
							CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS nilai, e.SN_rk3 AS d_k,
                            CASE
                                WHEN LEFT(w.ko_rkk5,2) = 8 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 7 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS saldo_tahun_lalu
                            FROM tb_soaw w LEFT JOIN
								". $pf_rk6 . " b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE (w.Ko_Period = ".$tahun.") AND (LEFT(w.ko_rkk5,2) IN (7, 8)) AND w.Ko_unitstr = LEFT('".kd_unit()."',18)
                        ) temp1 LEFT JOIN 
						pf_rek_sap n ON temp1.kdrek1 = n.Ko_Rk1 AND temp1.kdrek2 = n.Ko_Rk2 AND temp1.kdrek3 = n.Ko_Rk3 AND temp1.kdrek4 = n.Ko_Rk4 AND temp1.kdrek5 = n.Ko_Rk5	
                        GROUP BY temp1.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
                    ),
                    LO AS
                    (
						SELECT *
						FROM
						(
							SELECT temp1.tahun,
								CONCAT(temp1.kdrek1,'.',RIGHT(CONCAT('0', temp1.kdrek2), 2),'.',RIGHT(CONCAT('0', temp1.kdrek3), 2)) AS koderekening,
								temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3,
								sum(temp1.saldo_tahun_ini) AS saldo_tahun_ini, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
							FROM
							(
								SELECT saldo_berjalan.tahun, saldo_berjalan.kdrek1, saldo_berjalan.kdrek2, saldo_berjalan.kdrek3,
									saldo_berjalan.saldo_tahun_ini, 0 AS saldo_tahun_lalu
								FROM saldo_berjalan
								UNION ALL
								SELECT saldo_awal.tahun, saldo_awal.kdrek1, saldo_awal.kdrek2, saldo_awal.kdrek3,
									0 AS saldo_tahun_ini, saldo_awal.saldo_tahun_lalu
								FROM saldo_awal
							) temp1
								INNER JOIN pf_sap3 rek3 ON temp1.kdrek1 = rek3.kdrek1 AND temp1.kdrek2 = rek3.kdrek2 AND temp1.kdrek3 = rek3.kdrek3
								INNER JOIN pf_sap2 rek2 ON temp1.kdrek1 = rek2.kdrek1 AND temp1.kdrek2 = rek2.kdrek2
								INNER JOIN pf_sap1 rek1 ON temp1.kdrek1 = rek1.kdrek1
							GROUP BY temp1.tahun, temp1.kdrek1, rek1.nmrek1, temp1.kdrek2, rek2.nmrek2, temp1.kdrek3, rek3.nmrek3
						) temp2
						WHERE temp2.koderekening LIKE '11.01%' or temp2.koderekening LIKE '11.02%'
                    )
                    SELECT
                        CONCAT(kdrek1,'') AS koderekening, nmrek1 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,nmrek1
                    UNION ALL
                    SELECT
                        CONCAT(kdrek1,'.',RIGHT(CONCAT('0',kdrek2),2)) AS koderekening, nmrek2 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY kdrek1,kdrek2,nmrek2
                    UNION ALL
                    SELECT
                        koderekening, nmrek3 AS uraian, SUM(saldo_tahun_ini) AS saldo_tahun_ini, SUM(saldo_tahun_lalu) AS saldo_tahun_lalu,
                        SUM(saldo_tahun_ini)-SUM(saldo_tahun_lalu) AS kenaikan_penurunan
                    FROM LO
                    GROUP BY koderekening,nmrek3
                    ORDER BY koderekening");

		$data = [
			'rincianLO' => $rincianLO,
			'rincianLO2' => $rincianLO2,
			'rincianLO3' => $rincianLO3,
			'ambilbidang' => $bid,
			'ambilskpd' => $skpd,
			'ambilunit' => $unit,
			'refPemda' => $pemda,
			'tahun' => $tahun,
		];

        return [
            'data' => $data,
			'refPemda' => $pemda,
        ];
    }
}
