<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuPembantuBelanjaGUController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-pengeluaran';
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
                
		$rincianBku = DB::select("WITH rincian_bukti AS
                    (
                        -- up/gu penerimaan
                        SELECT 3 AS kode, 0 AS kode_2, D.Dt_npd AS tgl_bukti, D.No_npd AS no_bukti, D.Ur_npd AS uraian,
                        0 AS kdrek1, 0 AS kdrek2, 0 AS kdrek3, 0 AS kdrek4, 0 AS kdrek5, 0 AS kdrek6, SUM(A.spirc_Rp) AS debet, 0 AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
						WHERE ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (1, 4)
						GROUP BY D.No_npd, D.Dt_npd, D.Ur_npd
                        UNION ALL
                        -- gu Pengeluaran
                        SELECT 4 AS kode, 0 AS kode_2, A.dt_rftrbprc AS tgl_bukti, A.No_bp AS no_bukti, A.Ur_bprc AS uraian,
						LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(A.Ko_Rkk,4) AS kdrek6, 0 AS debet, SUM(A.spirc_Rp) AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
						WHERE ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (4, 6, 8)
						GROUP BY  A.No_bp, D.Dt_npd, A.Ur_bprc, A.ko_rkk, A.dt_rftrbprc
                        UNION ALL
						-- jurnal GU
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						CASE a.Ko_DK WHEN 'D' THEN SUM(a.Rp_D) ELSE 0 END AS debet, 0 AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.03.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='D')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.03.001.0001') AND (a.Ko_DK='D')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk
						UNION ALL
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						0 AS debet, CASE a.Ko_DK WHEN 'K' THEN SUM(a.Rp_K) ELSE 0 END AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.03.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='K')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.03.001.0001') AND (a.Ko_DK='K')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk
                    )
                    SELECT
					a.*
					FROM
					(
						SELECT 0 AS kode, 0 AS kode_2, (CAST('".$tgl_1."' AS DATETIME) - INTERVAL 1 DAY ) AS tgl_bukti, '' AS no_bukti, 'Saldo Awal' AS uraian,
                        0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6, SUM(COALESCE(a.debet,0)) AS debet, SUM(COALESCE(a.kredit,0)) AS kredit
						FROM rincian_bukti a
						WHERE a.kode = 0 OR ( CAST(a.tgl_bukti AS DATE) < CAST('".$tgl_1."' AS DATETIME) )
						UNION ALL
						SELECT a.*
						FROM rincian_bukti a
						WHERE a.kode != 0 AND ( CAST(a.tgl_bukti AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE))
					) a
                    ORDER BY a.tgl_bukti ASC, a.kode ASC, a.no_bukti ASC, a.kode_2 ASC, a.debet DESC, a.kdrek1 ASC, a.kdrek2 ASC, a.kdrek3 ASC, a.kdrek4 ASC, a.kdrek5 ASC, a.kdrek6 ASC");

		$data = [
			'rincianBku' => $rincianBku,
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
