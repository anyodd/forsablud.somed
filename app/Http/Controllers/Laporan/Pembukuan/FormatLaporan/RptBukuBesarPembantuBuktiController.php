<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuBesarPembantuBuktiController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.pembukuan.cetak-lapkeu';
    }

    public static function Laporan($tahun, $tgl_1, $tgl_2, $kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6)
    {
		$data = null;
		$ambilbidang = 0;
		$ambilskpd = 0;
		$ambilunit = 0;
		$ambilprogram = 0;
		$ambilkegiatan = 0;
	
		if ($kdrek2) {
			$pecahidkdrek2 = explode('.', $kdrek2);
			$kdrek2_req = $pecahidkdrek2[1];
		} else {
			$kdrek2_req = "%";
		}

		if ($kdrek3) {
			$pecahidkdrek3 = explode('.', $kdrek3);
			$kdrek3_req = $pecahidkdrek3[2];
		} else {
			$kdrek3_req = "%";
		}

		if ($kdrek4) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4) = explode('.', $kdrek4);
			$kdrek4_req = $kdrek4;
		} else {
			$kdrek4_req = "%";
		}

		if ($kdrek5) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5) = explode('.', $kdrek5);
			$kdrek5_req = $kdrek5;
		} else {
			$kdrek5_req = "%";
		}

		if ($kdrek6) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6) = explode('.', $kdrek6);
			$kdrek6_req = $kdrek6;
		} else {
			$kdrek6_req = "%";
		}
		
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
                
		$daftarBuktiBukuBesar = DB::select("WITH bukti_buku_besar AS (
                        SELECT a.* FROM
                        (
                            SELECT
								1 AS kode, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
								SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, b.Ur_Rk6 AS nmrek6, 
								a.dt_bukti AS tgl_bukti, a.Buktijr_No AS no_bukti, a.jr_urbprc AS uraian, e.SN_rk3 AS saldo_normal,
								SUM(a.jrRp_D) AS debet, SUM(a.jrRp_K) AS kredit
                            FROM jr_trans a LEFT JOIN
								". $pf_rk6 . " b ON LEFT(a.Ko_Rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.Ko_Rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.Ko_Rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE a.Ko_Period = ".$tahun." AND CAST(a.dt_bukti AS DATE) BETWEEN CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE) AND a.Ko_unitstr = LEFT('".kd_unit()."',18)
                                AND LEFT(a.Ko_Rkk,2) LIKE '%".$kdrek1."' AND SUBSTRING(a.Ko_Rkk,4,2) LIKE '%".$kdrek2_req."' AND SUBSTRING(a.Ko_Rkk,7,2) LIKE '%".$kdrek3_req."'
								AND SUBSTRING(a.Ko_Rkk,10,2) LIKE '%".$kdrek4_req."' AND SUBSTRING(a.Ko_Rkk,13,3) LIKE '%".$kdrek5_req."' AND RIGHT(a.Ko_Rkk,4) LIKE '%".$kdrek6_req."'
							GROUP BY a.Ko_Rkk, a.dt_bukti, a.Buktijr_No, a.jr_urbprc , b.Ur_Rk6, e.SN_rk3 
                            UNION ALL
							SELECT
								1 AS kode, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
								SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, b.Ur_Rk6 AS nmrek6, 
								a.dt_sesuai AS tgl_bukti, a.Sesuai_No AS no_bukti, aa.Sesuai_Ur AS uraian, e.SN_rk3 AS saldo_normal,
								SUM(a.Rp_D) AS debet, SUM(a.Rp_K) AS kredit
                            FROM jr_sesuai a INNER JOIN tb_sesuai aa ON a.Sesuai_No=aa.Sesuai_No AND a.Ko_unitstr=aa.Ko_unitstr LEFT JOIN
								". $pf_rk6 . " b ON LEFT(a.Ko_Rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.Ko_Rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.Ko_Rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE a.Ko_Period = ".$tahun." AND CAST(a.dt_sesuai AS DATE) BETWEEN CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE) AND a.Ko_unitstr = LEFT('".kd_unit()."',18)
                                AND LEFT(a.Ko_Rkk,2) LIKE '%".$kdrek1."' AND SUBSTRING(a.Ko_Rkk,4,2) LIKE '%".$kdrek2_req."' AND SUBSTRING(a.Ko_Rkk,7,2) LIKE '%".$kdrek3_req."'
								AND SUBSTRING(a.Ko_Rkk,10,2) LIKE '%".$kdrek4_req."' AND SUBSTRING(a.Ko_Rkk,13,3) LIKE '%".$kdrek5_req."' AND RIGHT(a.Ko_Rkk,4) LIKE '%".$kdrek6_req."'
							GROUP BY a.Ko_Rkk, a.dt_sesuai, a.Sesuai_No, aa.Sesuai_Ur , b.Ur_Rk6, e.SN_rk3 
                            UNION ALL							
                            SELECT
                                0 AS kode, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
								SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, SUBSTRING(a.ko_rkk5,13,3) AS kdrek5, lpad(1,4,0) AS kdrek6, b.Ur_Rk6 AS nmrek6, 
								CONCAT(".$tahun.",'-01-01') AS tgl_bukti, '' AS no_bukti, 'Saldo Awal' AS uraian, e.SN_rk3 AS saldo_normal,
								SUM(a.soaw_Rp_D) AS debet, SUM(a.soaw_Rp_K) AS kredit
                            FROM tb_soaw a LEFT JOIN
								". $pf_rk6 . " b ON LEFT(a.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk5,7,2) = b.Ko_Rk3 AND SUBSTRING(a.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(a.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
								pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
								pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
								pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
                            WHERE a.Ko_Period = ".$tahun." AND a.Ko_unitstr = LEFT('".kd_unit()."',18)
                                AND LEFT(a.ko_rkk5,2) LIKE '%".$kdrek1."' AND SUBSTRING(a.ko_rkk5,4,2) LIKE '%".$kdrek2_req."' AND SUBSTRING(a.ko_rkk5,7,2) LIKE '%".$kdrek3_req."'
								AND SUBSTRING(a.ko_rkk5,10,2) LIKE '%".$kdrek4_req."' AND SUBSTRING(a.ko_rkk5,13,3) LIKE '%".$kdrek5_req."' AND RIGHT(a.ko_rkk5,4) LIKE '%".$kdrek6_req."'
                                AND LEFT(a.ko_rkk5,2) IN (1,2,3)
                            GROUP BY a.ko_rkk5, b.Ur_Rk6, e.SN_rk3 
                        ) a
                    )
                    SELECT
                    *
                    FROM
                    (
                        SELECT
                            0 AS kode, a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, a.nmrek6, CAST('".$tgl_1."' AS DATE) AS tgl_bukti, '' AS no_bukti, 'Saldo Awal' AS uraian, a.saldo_normal, SUM(a.debet) AS debet, SUM(a.kredit) AS kredit
                        FROM bukti_buku_besar a
                        WHERE CAST(a.tgl_bukti AS DATE) < CAST('".$tgl_1."' AS DATE) OR a.kode = 0
                        GROUP BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, a.nmrek6, a.saldo_normal
                        UNION ALL
                        SELECT
                            a.kode, a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, a.nmrek6, a.tgl_bukti, a.no_bukti, a.uraian, a.saldo_normal, a.debet, a.kredit
                        FROM bukti_buku_besar a
                        WHERE CAST(a.tgl_bukti AS DATE) BETWEEN CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE) AND a.kode != 0
                    ) a
                    ORDER BY a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, a.nmrek6, a.kode, a.tgl_bukti, a.no_bukti");

		$data = [
			'daftarBuktiBukuBesar' => $daftarBuktiBukuBesar,
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
