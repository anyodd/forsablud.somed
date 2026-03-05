<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuKasPenerimaanTunaiController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-penerimaan';
    }

    public static function Laporan($tahun, $tgl_1, $tgl_2)
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
		$id_bidang = bidang_id(kd_unit());
		$pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = ".$id_bidang." GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";
		
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
                
		$bkupdpttunai = DB::select("WITH saldoawal_pdpt AS 
						(
							SELECT B.Ko_unitstr, D.real_rp AS Debet, 0 AS Kredit
							FROM tb_bprc A INNER JOIN 
							tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
							tb_bp B ON A.id_bp = B.id_bp 
							WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(D.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) 
							AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
							AND ( B.Ko_bp IN (1, 42, 42, 11) )
							AND A.ko_kas = 2 
						),
						saldoawal_sts as (
							SELECT DISTINCT A.Ko_unitstr, 0 AS Debet, SUM(B.real_rp) AS Kredit
							FROM  (
									SELECT B.Ko_Period, B.Ko_unitstr, A.No_byr
									FROM tb_sts B 
									INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr
						 ) A INNER JOIN (
									SELECT B.Ko_Period, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
									FROM tb_byr B 
									INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) AND A.ko_kas = 2 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr
							) B ON A.Ko_Period = B.Ko_Period AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
							GROUP BY A.Ko_unitstr	
						),             
						current_pdpt AS (
							SELECT B.Ko_unitstr, D.dt_byr AS tgl_bukti, 2 AS Kode, 1 AS Urut, D.No_byr AS no_bukti, CONCAT(D.Ur_byr,' (Pembayaran atas ',B.No_bp,')') AS Uraian,
							LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
							SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, C.Ur_Rk6 AS nmrek6, A.Ko_Rkk, D.real_rp AS Debet, 0 AS Kredit
							FROM tb_bprc A INNER JOIN 
							tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
							tb_bp B ON A.id_bp = B.id_bp LEFT JOIN
							". $pf_rk6 . " C ON LEFT(A.Ko_Rkk,2) = C.Ko_Rk1 AND SUBSTRING(A.Ko_Rkk,4,2) = C.Ko_Rk2 AND SUBSTRING(A.Ko_Rkk,7,2) = C.Ko_Rk3 
							AND SUBSTRING(A.Ko_Rkk,10,2) = C.Ko_Rk4 AND SUBSTRING(A.Ko_Rkk,13,3) = C.Ko_Rk5 AND RIGHT(A.Ko_Rkk,4) = C.Ko_Rk6
							WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
							AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
							AND ( B.Ko_bp IN (1, 42, 43, 11) ) AND A.ko_kas = 2 	
						),
						current_sts AS (
							SELECT DISTINCT B.Ko_unitstr, B.dt_sts AS tgl_bukti, 2 AS Kode, 2 AS Urut, B.No_sts AS no_bukti, B.Ur_sts AS Uraian,
							LEFT(C.Ko_Rkk,2) AS kdrek1, SUBSTRING(C.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(C.Ko_Rkk,7,2) AS kdrek3, 
							SUBSTRING(C.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(C.Ko_Rkk,13,3) AS kdrek5, RIGHT(C.Ko_Rkk,4) AS kdrek6, D.Ur_Rk6 AS nmrek6, C.Ko_Rkk, 0 AS Debet, SUM(C.real_rp) AS Kredit
							FROM 
							(
								SELECT B.Ko_Period, B.Ko_unitstr, B.No_sts, B.dt_sts, B.Ur_sts, A.No_byr
								FROM tb_sts B 
								INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
								WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
								AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
								GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_sts, B.dt_sts, B.Ur_sts, A.No_byr
							) B 
							INNER JOIN (
								SELECT B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk, SUM(B.real_rp) AS real_rp
								FROM tb_byr B 
								INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
								WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE) ) 
								AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) AND A.ko_kas = 2 	
								GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk
							) C ON B.Ko_Period = C.Ko_Period AND B.Ko_unitstr = C.Ko_unitstr AND B.No_byr = C.No_byr LEFT JOIN
							". $pf_rk6 . " D ON LEFT(C.Ko_Rkk,2) = D.Ko_Rk1 AND SUBSTRING(C.Ko_Rkk,4,2) = D.Ko_Rk2 AND SUBSTRING(C.Ko_Rkk,7,2) = D.Ko_Rk3
							AND SUBSTRING(C.Ko_Rkk,10,2) = D.Ko_Rk4 AND SUBSTRING(C.Ko_Rkk,13,3) = D.Ko_Rk5 AND RIGHT(C.Ko_Rkk,4) = D.Ko_Rk6
							WHERE  (B.Ko_Period = ".$tahun.") AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
							AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
							GROUP BY B.Ko_unitstr, B.dt_sts, B.No_sts, B.Ur_sts, C.Ko_Rkk, D.Ur_Rk6
						)
						SELECT A.tgl_bukti, A.kode, A.Urut, A.no_bukti, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.Ko_Rkk, 
						SUM(A.debet) AS debet, SUM(A.kredit) AS kredit, (SUM(A.debet) - SUM(A.kredit)) AS saldo
						FROM
						(
							SELECT (CAST('".$tgl_1."' AS DATETIME) - INTERVAL 1 DAY ) AS tgl_bukti, 
							1 AS Kode, 1 AS Urut, '' AS no_bukti, A.Ko_unitstr,
							0 AS kdrek1, 0 AS kdrek2, 0 AS kdrek3, 0 AS kdrek4, 0 AS kdrek5, 0 AS kdrek6, 'Saldo Awal' AS nmrek6, '01.01.01.02.001.0001' AS Ko_Rkk,
							SUM(A.Debet) AS Debet, SUM(A.Kredit) AS Kredit
							FROM (
								SELECT * from saldoawal_pdpt
								UNION ALL
								SELECT * from saldoawal_sts
							) A
							GROUP BY A.Ko_unitstr
							UNION ALL
							SELECT A.tgl_bukti, A.Kode, A.Urut, A.no_bukti, A.Ko_unitstr, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Uraian AS nmrek6, A.Ko_Rkk, A.Debet, A.Kredit
							FROM
							(
								SELECT * from current_pdpt
								UNION ALL
								SELECT * from current_sts
							) A
						) A
						GROUP BY A.tgl_bukti, A.kode, A.no_bukti, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.nmrek6, A.Ko_Rkk
						ORDER BY A.kode ASC, A.tgl_bukti, A.Urut ASC, A.no_bukti, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6");

		$data = [
			'bkupdpttunai' => $bkupdpttunai,
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
