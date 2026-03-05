<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLpSalController extends Controller
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
                
		$lpsal = DB::select("WITH data_LPSAL as(
						SELECT 1 AS Kd_Grup_1, 1 AS Kd_Grup_2, 'Saldo Anggaran Lebih Awal' AS Nm_Grup_1, 'Saldo Anggaran Lebih Awal' AS Nm_Grup_2, 0 AS Realisasi, 0 AS RealisasiX0
						UNION ALL

						SELECT 1, 1, 'Saldo Anggaran Lebih Awal', 'Saldo Anggaran Lebih Awal',
								CASE A.saldo_normal
								WHEN 'D' THEN A.Debet - A.Kredit
								ELSE A.Kredit - A.Debet
								END AS Realisasi, 0
						FROM tb_saldo A
						WHERE (A.kdrek1 = 6) AND (A.kdrek2 = 1) AND (A.kdrek3 = 1) AND (A.kdrek4 < 99) AND A.Ko_unitstr = LEFT('".kd_unit()."',18) 
						AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
						UNION ALL

						SELECT 1, 1, 'Saldo Anggaran Lebih Awal', 'Saldo Anggaran Lebih Awal', 0,
						CASE
								WHEN ( LEFT(A.ko_rkk5,2) = 4 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,7,2)=1)) THEN SUM(A.soaw_Rp_K)
								WHEN ( LEFT(A.ko_rkk5,2) = 5 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,7,2)=2)) THEN SUM(A.soaw_Rp_D)
								ELSE 0 END AS RealisasiX0
						FROM tb_soaw A
						WHERE (LEFT(A.ko_rkk5,2) = 6) AND (SUBSTRING(A.ko_rkk5,4,2) = 1) AND (SUBSTRING(A.ko_rkk5,7,2) = 1) AND (SUBSTRING(A.ko_rkk5,10,2) < 99)
						AND A.Ko_Period = ".$tahun." AND A.Ko_unitstr = LEFT('".kd_unit()."',18)
						GROUP BY A.ko_rkk5
						UNION ALL

						SELECT 1, 2, 'Saldo Anggaran Lebih Awal', 'Penggunaan SAL sebagai Penerimaan Pembiayaan Tahun Berjalan', 0, 0
						UNION ALL

						SELECT 1, 2, 'Saldo Anggaran Lebih Awal', 'Penggunaan SAL sebagai Penerimaan Pembiayaan Tahun Berjalan',
								CASE A.saldo_normal
								WHEN 'D' THEN A.Debet - A.Kredit
								ELSE A.Kredit - A.Debet
								END AS Realisasi, 0
						FROM tb_saldo A
						WHERE (A.kdrek1 = 6) AND (A.kdrek2 = 1) AND (A.kdrek3 = 1) AND A.Ko_unitstr = LEFT('".kd_unit()."',18) 
						AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
						UNION ALL

						SELECT 1, 2, 'Saldo Anggaran Lebih Awal', 'Penggunaan SAL sebagai Penerimaan Pembiayaan Tahun Berjalan', 0,
						CASE
								WHEN ( LEFT(A.ko_rkk5,2) = 4 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=1)) THEN SUM(A.soaw_Rp_K)
								WHEN ( LEFT(A.ko_rkk5,2) = 5 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=2)) THEN SUM(A.soaw_Rp_D)
								ELSE 0 END AS RealisasiX0
						FROM tb_soaw A
						WHERE (LEFT(A.ko_rkk5,2) = 6) AND (SUBSTRING(A.ko_rkk5,4,2) = 1) AND (SUBSTRING(A.ko_rkk5,7,2) = 1) 
						AND A.Ko_Period = ".$tahun." AND A.Ko_unitstr = LEFT('".kd_unit()."',18)
						GROUP BY A.ko_rkk5
						UNION ALL

						SELECT 2, 1, 'Sisa Lebih/Kurang Pembiayaan Anggaran (SILPA/SIKPA)', 'Sisa Lebih/Kurang Pembiayaan Anggaran (SILPA/SIKPA)',
								SUM(CASE
								WHEN A.kdrek1 = 4 THEN Realisasi
								WHEN A.kdrek1 = 5 THEN -Realisasi
								WHEN A.kdrek1 = 6 AND A.kdrek2 = 1 THEN Realisasi
								WHEN A.kdrek1 = 6 AND A.kdrek2 = 2 THEN -Realisasi
								END) AS Realisasi,
								SUM(CASE
								WHEN A.kdrek1 = 4 THEN RealisasiX0
								WHEN A.kdrek1 = 5 THEN -RealisasiX0
								WHEN A.kdrek1 = 6 AND A.kdrek2 = 1 THEN RealisasiX0
								WHEN A.kdrek1 = 6 AND A.kdrek2 = 2 THEN -RealisasiX0
								END) AS RealisasiX0
						FROM
							(
								SELECT A.kdrek1, A.kdrek2,
										SUM(CASE A.saldo_normal
										WHEN 'D' THEN A.Debet - A.Kredit
										ELSE A.Kredit - A.Debet
										END) AS Realisasi, 0 AS RealisasiX0
								FROM tb_saldo A
								WHERE ((A.kdrek1 IN (4, 5)) OR (A.kdrek1 = 6 AND A.kdrek2 < 3)) AND A.Ko_unitstr = LEFT('".kd_unit()."',18) 
								AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								GROUP BY A.kdrek1, A.kdrek2
								UNION ALL
								
								SELECT B.kdrek1, B.kdrek2, 0 AS Realisasi, sum(RealisasiX0) AS RealisasiX0  
								FROM (
										SELECT A.Ko_unitstr, LEFT(A.ko_rkk5,2) AS kdrek1, SUBSTRING(A.ko_rkk5,4,2) AS kdrek2, 0 AS Realisasi,
										CASE
										WHEN ( LEFT(A.ko_rkk5,2) = 4 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=1)) THEN SUM(A.soaw_Rp_K)
										WHEN ( LEFT(A.ko_rkk5,2) = 5 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=2)) THEN SUM(A.soaw_Rp_D)
										ELSE 0 END AS RealisasiX0
										FROM tb_soaw A
										WHERE ((LEFT(A.ko_rkk5,2) IN (4, 5)) OR (LEFT(A.ko_rkk5,2) = 6 AND SUBSTRING(A.ko_rkk5,4,2) < 3))
										AND A.Ko_Period = ".$tahun." AND A.Ko_unitstr = LEFT('".kd_unit()."',18)
										GROUP BY A.Ko_unitstr, A.ko_rkk5
									) B
								WHERE B.Ko_unitstr = LEFT('".kd_unit()."',18)
								GROUP BY B.kdrek1, B.kdrek2
							) A
						UNION ALL

						SELECT 3, 99 AS kdrek5, 'Koreksi SiLPA', 'Koreksi SiLPA' AS nmrek5, 0 AS Realisasi, 0 AS RealisasiX0  
						UNION ALL
						
						SELECT 3, 99 AS kdrek5, 'Koreksi SiLPA', B.Ur_Rk5 AS nmrek5, COALESCE(A.Realisasi, 0) AS Realisasi, 0
						FROM pf_rk5 B LEFT OUTER JOIN
								(
								SELECT A.tahun, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5,
										CASE A.saldo_normal
										WHEN 'D' THEN A.Debet - A.Kredit
										ELSE A.Kredit - A.Debet
										END AS Realisasi
								FROM tb_saldo A 
								WHERE A.tahun = ".$tahun." AND A.Ko_unitstr = LEFT('".kd_unit()."',18) 
								AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								) A ON A.kdrek1 = B.Ko_Rk1 AND A.kdrek2 = B.Ko_Rk2 AND A.kdrek3 = B.Ko_Rk3 AND A.kdrek4 = B.Ko_Rk4 AND A.kdrek5 = B.Ko_Rk5
						WHERE (B.Ko_Rk1 = 6) AND (B.Ko_Rk2 = 1) AND (B.Ko_Rk3 = 1) AND (B.Ko_Rk4 = 99)
						UNION ALL

						SELECT 3, 99 AS kdrek5, 'Koreksi SiLPA', B.Ur_Rk5 AS nmrek5, 0, COALESCE(A.Realisasi, 0) AS Realisasi
						FROM pf_rk5 B LEFT OUTER JOIN
								(
								SELECT B.tahun, B.kdrek1, B.kdrek2, B.kdrek3, B.kdrek4, B.kdrek5, SUM(B.Realisasi) AS Realisasi 
								FROM (
											SELECT A.Ko_unitstr, A.Ko_Period AS tahun, LEFT(A.ko_rkk5,2) AS kdrek1, SUBSTRING(A.ko_rkk5,4,2) AS kdrek2, SUBSTRING(A.ko_rkk5,7,2) AS kdrek3, 
											SUBSTRING(A.ko_rkk5,10,2) AS kdrek4, SUBSTRING(A.ko_rkk5,13,3) AS kdrek5,
											CASE
											WHEN ( LEFT(A.ko_rkk5,2) = 4 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=1)) THEN SUM(A.soaw_Rp_K)
											WHEN ( LEFT(A.ko_rkk5,2) = 5 OR (LEFT(A.ko_rkk5,2)=6 AND SUBSTRING(A.ko_rkk5,4,2)=2)) THEN SUM(A.soaw_Rp_D)
											ELSE 0 END AS Realisasi
											FROM tb_soaw A
											WHERE A.Ko_Period = ".$tahun." AND A.Ko_unitstr = LEFT('".kd_unit()."',18)
											GROUP BY A.Ko_unitstr, A.Ko_Period, A.ko_rkk5
										) B
								WHERE B.Ko_unitstr = LEFT('".kd_unit()."',18)
								GROUP BY B.tahun, B.kdrek1, B.kdrek2, B.kdrek3, B.kdrek4, B.kdrek5
								) A ON A.kdrek1 = B.Ko_Rk1 AND A.kdrek2 = B.Ko_Rk2 AND A.kdrek3 = B.Ko_Rk3 AND A.kdrek4 = B.Ko_Rk4 AND A.kdrek5 = B.Ko_Rk5
							WHERE (B.Ko_Rk1 = 6) AND (B.Ko_Rk2 = 1) AND (B.Ko_Rk3 = 1) AND (B.Ko_Rk4 = 99) 
						)
						SELECT A.Kd_Grup_1, A.Kd_Grup_2, A.Nm_Grup_1, A.Nm_Grup_2, A.Realisasi, A.RealisasiX0,
							CASE
							WHEN A.Kd_Grup_1 = 1 AND A.Kd_Grup_2 = 2 THEN -A.Realisasi
							ELSE A.Realisasi
							END AS Balik,
							CASE
							WHEN A.Kd_Grup_1 = 1 AND A.Kd_Grup_2 = 2 THEN -A.RealisasiX0
							ELSE A.RealisasiX0
							END AS BalikX0
						FROM
						(
							SELECT A.Kd_Grup_1, A.Kd_Grup_2, A.Nm_Grup_1, A.Nm_Grup_2, SUM(A.Realisasi) AS Realisasi, SUM(A.RealisasiX0) AS RealisasiX0
							FROM data_LPSAL A
							GROUP BY A.Kd_Grup_1, A.Kd_Grup_2, A.Nm_Grup_1, A.Nm_Grup_2
						) A");


		$data = [
			'lpsal' => $lpsal,
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
