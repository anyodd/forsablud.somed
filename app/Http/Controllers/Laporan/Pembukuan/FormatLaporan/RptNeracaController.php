<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptNeracaController extends Controller
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
							

		DB::statement("CALL SP_SaldoAkhir ( 4, ".$tahun.", '".$tgl_2."','".kd_unit()."')"); 
                
		$neraca = DB::select("WITH saldo_berjalan AS
                    (
                        SELECT temp1.tahun, temp1.kdrek1, temp1.kdrek2, temp1.kdrek3, temp1.kdrek4,
                            SUM(
                            CASE
                                WHEN temp1.kdrek1 = 1 THEN temp1.debet - temp1.kredit
                                WHEN temp1.kdrek1 = 2 THEN temp1.kredit - temp1.debet
                                WHEN temp1.kdrek1 = 3 AND temp1.kdrek2 = 1 AND temp1.kdrek3 = 1 AND temp1.kdrek4 = 1 THEN temp1.kredit - temp1.debet
								WHEN temp1.kdrek1 = 3 AND temp1.kdrek2 = 1 AND temp1.kdrek3 = 1 AND temp1.kdrek4 = 2 THEN temp1.saldo
                                ELSE 0
                            END) AS saldo_tahun_ini
                        FROM
                            (
                                SELECT q.tahun, q.kdrek1, q.kdrek2, q.kdrek3, q.kdrek4, q.kdrek5, q.kdrek6, q.debet, q.kredit, 0 AS Saldo
                                FROM tb_saldo q
                                WHERE (q.kdrek1 IN (1,2,3)) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 4 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								UNION ALL
								/*memunculkan nilai surplus defisit lo thn berjalan*/
								SELECT q.tahun, '03', '01', '01', '02', '01', 1, q.debet, q.kredit, q.kredit-q.debet AS saldo
                                FROM tb_saldo q
                                WHERE (q.kdrek1 = 7) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 4 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								UNION ALL
								SELECT q.tahun, '03', '01', '01', '02', '01', 1, q.debet, q.kredit, -(q.debet-q.kredit) AS saldo
                                FROM tb_saldo q
                                WHERE (q.kdrek1 = 8) AND q.Ko_unitstr = LEFT('".kd_unit()."',18) AND kode = 4 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
                            ) temp1
                        GROUP BY temp1.tahun,temp1.kdrek1,temp1.kdrek2,temp1.kdrek3,temp1.kdrek4
                    ),
                    saldo_awal AS
                    (
                        SELECT temp1.tahun, temp1.kdrek1, temp1.kdrek2, temp1.kdrek3, temp1.kdrek4, sum(temp1.saldo_tahun_lalu) AS saldo_tahun_lalu
                        FROM
                        (
                            SELECT w.Ko_Period AS tahun, LEFT(w.ko_rkk5,2) AS kdrek1, SUBSTRING(w.ko_rkk5,4,2) AS kdrek2, SUBSTRING(w.ko_rkk5,7,2) AS kdrek3, 
							SUBSTRING(w.ko_rkk5,10,2) AS kdrek4, SUBSTRING(w.ko_rkk5,13,3) AS kdrek5, 1 AS kdrek6, 
							CASE
                                WHEN LEFT(w.ko_rkk5,2) = 1 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 2 THEN w.soaw_Rp_K
                                WHEN LEFT(w.ko_rkk5,2) = 3 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS nilai, e.SN_rk3 AS d_k,
                            CASE
                                WHEN LEFT(w.ko_rkk5,2) = 1 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 2 THEN w.soaw_Rp_K
                                WHEN LEFT(w.ko_rkk5,2) = 3 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS saldo_tahun_lalu
                            FROM tb_soaw w LEFT JOIN
								". $pf_rk6 . " b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE (w.Ko_Period = ".$tahun.") AND (LEFT(w.ko_rkk5,2) IN (1, 2, 3)) AND w.Ko_unitstr = LEFT('".kd_unit()."',18) AND w.ko_rkk5 NOT LIKE '03.01.01.01.002'
							UNION ALL
							SELECT w.Ko_Period AS tahun, LEFT(w.ko_rkk5,2) AS kdrek1, SUBSTRING(w.ko_rkk5,4,2) AS kdrek2, SUBSTRING(w.ko_rkk5,7,2) AS kdrek3, 
							SUBSTRING(w.ko_rkk5,10,2) AS kdrek4, SUBSTRING(w.ko_rkk5,13,3) AS kdrek5, 3 AS kdrek6, 
							CASE
                                WHEN LEFT(w.ko_rkk5,2) = 1 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 2 THEN w.soaw_Rp_K
                                WHEN LEFT(w.ko_rkk5,2) = 3 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS nilai, e.SN_rk3 AS d_k,
                            CASE
                                WHEN LEFT(w.ko_rkk5,2) = 1 THEN w.soaw_Rp_D
                                WHEN LEFT(w.ko_rkk5,2) = 2 THEN w.soaw_Rp_K
                                WHEN LEFT(w.ko_rkk5,2) = 3 THEN w.soaw_Rp_K
                                ELSE 0
                            END AS saldo_tahun_lalu
                            FROM tb_soaw w LEFT JOIN
								". $pf_rk6 . " b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 3 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3 
                            WHERE (w.Ko_Period = ".$tahun.") AND (LEFT(w.ko_rkk5,2) IN (3)) AND w.Ko_unitstr = LEFT('".kd_unit()."',18) AND w.ko_rkk5 LIKE '03.01.01.01.002'
                        ) temp1
                        GROUP BY temp1.tahun, temp1.kdrek1,temp1.kdrek2,temp1.kdrek3,temp1.kdrek4
                    ),
                    saldo_total AS
                    (
                        SELECT
                        COALESCE(a.tahun, b.tahun) AS tahun,
                        COALESCE(a.kdrek1, b.kdrek1) AS kdrek1,
                        COALESCE(a.kdrek2, b.kdrek2) AS kdrek2,
                        COALESCE(a.kdrek3, b.kdrek3) AS kdrek3,
                        COALESCE(a.kdrek4, b.kdrek4) AS kdrek4,
                        COALESCE(b.saldo_tahun_lalu, 0) AS saldo_awal,
                        COALESCE(a.saldo_tahun_ini,0) AS saldo_akhir
                        FROM saldo_berjalan a LEFT JOIN
                        saldo_awal b ON a.tahun = b.tahun AND a.kdrek1 = b.kdrek1 AND a.kdrek2 = b.kdrek2 AND a.kdrek3 = b.kdrek3 AND a.kdrek4 = b.kdrek4
                    )
                    SELECT
                    a.kdrek1, d.Ur_Rk1 AS nmrek1, a.kdrek2, c.Ur_Rk2 AS nmrek2, a.kdrek3, b.Ur_Rk3 AS nmrek3, SUM(a.saldo_awal) AS saldo_awal, SUM(a.saldo_akhir) AS saldo_akhir
                    FROM saldo_total a
                    INNER JOIN pf_rk3 b ON a.kdrek1 = b.Ko_Rk1 AND a.kdrek2 = b.Ko_Rk2 AND a.kdrek3 = b.Ko_Rk3
                    INNER JOIN pf_rk2 c ON a.kdrek1 = c.Ko_Rk1 AND a.kdrek2 = c.Ko_Rk2
                    INNER JOIN pf_rk1 d ON a.kdrek1 = d.Ko_Rk1
                    GROUP BY a.kdrek1, d.Ur_Rk1, a.kdrek2, c.Ur_Rk2, a.kdrek3, b.Ur_Rk3
                    ORDER BY a.kdrek1, a.kdrek2, a.kdrek3 ASC");

		$data = [
			'neraca' => $neraca,
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
