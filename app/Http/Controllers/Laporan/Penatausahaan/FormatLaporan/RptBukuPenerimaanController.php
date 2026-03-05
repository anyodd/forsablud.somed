<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuPenerimaanController extends Controller
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
		$id_bidang = 0;
		$pf_rk6 = " ";
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
                
		$rekappdpt = DB::select("WITH rinc_pdpt AS (
								SELECT A.tahun, A.Ko_unitstr, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Ko_Rkk, A.tgl_bukti, A.no_bukti, SUM(A.jumlah) AS jumlah
								FROM
								(
									SELECT A.Ko_Period AS tahun, B.Ko_unitstr, D.dt_byr AS tgl_bukti, A.No_bp AS no_bukti, 
									LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, 
									A.Ko_Rkk, SUM(D.real_rp) AS Jumlah
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp 
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (1, 42, 43) )
									GROUP BY A.Ko_Period , B.Ko_unitstr, D.dt_byr, A.No_bp, A.Ko_Rkk
									UNION ALL
									SELECT A.Ko_Period AS tahun, B.Ko_unitstr, D.dt_byr AS tgl_bukti, A.No_bp AS no_bukti, 
									LEFT(C.Ko_Rkk,2) AS kdrek1, SUBSTRING(C.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(C.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(C.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(C.Ko_Rkk,13,3) AS kdrek5, RIGHT(C.Ko_Rkk,4) AS kdrek6, 
									C.Ko_Rkk, SUM(D.real_rp) AS Jumlah
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp INNER JOIN 
									pf_mapjr C ON A.Ko_Rkk=C.Lo_D
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (11) )
									GROUP BY A.Ko_Period , B.Ko_unitstr, D.dt_byr, A.No_bp, C.Ko_Rkk
									
									UNION ALL
									SELECT A.Ko_Period AS tahun, A.Ko_unitstr, B.dt_sesuai AS tgl_bukti, B.Sesuai_No AS no_bukti, 
									LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, 
									A.Ko_Rkk, SUM(A.Rp_K) AS Jumlah
									FROM jr_sesuai A INNER JOIN 
									tb_sesuai B ON A.id_tbses=B.id_tbses 
									WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2) = '04') 
									AND ( CAST(A.dt_sesuai AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE) )
									AND (A.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									GROUP BY A.Ko_unitstr, A.Ko_Rkk, A.Ko_unitstr, B.dt_sesuai, B.Sesuai_No
									UNION ALL
									SELECT A.Ko_Period AS tahun, A.Ko_unitstr, B.dt_sesuai AS tgl_bukti, B.Sesuai_No AS no_bukti, 
									LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, 
									A.Ko_Rkk, -SUM(A.Rp_D) AS Jumlah
									FROM jr_sesuai A INNER JOIN 
									tb_sesuai B ON A.id_tbses=B.id_tbses 
									WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2) = '04') 
									AND ( CAST(A.dt_sesuai AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE) )
									AND (A.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									GROUP BY A.Ko_unitstr, A.Ko_Rkk, A.Ko_unitstr, B.dt_sesuai, B.Sesuai_No
								) A
								GROUP BY A.tahun, A.Ko_unitstr, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Ko_Rkk, A.tgl_bukti, A.no_bukti
								HAVING SUM(A.jumlah)<>0
							)
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, CONCAT(A.kdrek1,'.',A.kdrek2) AS kode_rekening, rek.Ur_Rk2 AS nmrek, 
							NULL AS tgl_bukti, NULL AS no_bukti, COALESCE(SUM(A.jumlah),0) AS jumlah, 2 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN pf_rk2 AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2
							GROUP BY A.Ko_unitstr, A.tahun, A.kdrek1, A.kdrek2, rek.Ur_Rk2
							UNION ALL
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2)) AS kode_rekening, rek.Ur_Rk3,
							NULL AS tgl_bukti, NULL AS no_bukti, COALESCE(SUM( A.jumlah),0) AS jumlah, 3 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN pf_rk3 AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3
							GROUP BY A.Ko_unitstr, A.tahun, A.kdrek1, A.kdrek2, A.kdrek3, rek.Ur_Rk3
							UNION ALL
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2)) AS kode_rekening, rek.Ur_Rk4,
							NULL AS tgl_bukti, NULL AS no_bukti, COALESCE(SUM( A.jumlah),0) AS jumlah, 4 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN pf_rk4 AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3 AND A.kdrek4 = rek.Ko_Rk4
							GROUP BY A.Ko_unitstr, A.tahun, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, rek.Ur_Rk4
							UNION ALL
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, CONCAT(A.kdrek1,'.',A.kdrek2,'.',RIGHT(CONCAT('0',A.kdrek3),2),'.',RIGHT(CONCAT('0',A.kdrek4),2),'.',RIGHT(CONCAT('00',A.kdrek5),3)) AS kode_rekening, rek.Ur_Rk5,
							NULL AS tgl_bukti, NULL AS no_bukti, COALESCE(SUM( A.jumlah),0) AS jumlah, 5 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN pf_rk5 AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3 AND A.kdrek4 = rek.Ko_Rk4 AND A.kdrek5 = rek.Ko_Rk5
							GROUP BY A.Ko_unitstr, A.tahun, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, rek.Ur_Rk5
							UNION ALL
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, A.Ko_Rkk AS kode_rekening, rek.Ur_Rk6,
							NULL AS tgl_bukti, NULL AS no_bukti, SUM( A.jumlah) AS jumlah, 5.1 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN ". $pf_rk6 . " AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3 AND A.kdrek4 = rek.Ko_Rk4 AND A.kdrek5 = rek.Ko_Rk5 AND A.kdrek6 = rek.Ko_Rk6
							GROUP BY A.Ko_unitstr, A.tahun, A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Ko_Rkk, rek.Ur_Rk6
							UNION ALL
							SELECT A.Ko_unitstr, 0 AS kdprogram, 0 AS kdkegiatan, 0 AS kdsubkegiatan, 0 AS kdaktivitas, A.Ko_Rkk AS kode_rekening, rek.Ur_Rk6,
							A.tgl_bukti, A.no_bukti, COALESCE(A.jumlah,0), 6 AS kdlevel
							FROM rinc_pdpt A
							INNER JOIN ". $pf_rk6 . " AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3 AND A.kdrek4 = rek.Ko_Rk4 AND A.kdrek5 = rek.Ko_Rk5 AND A.kdrek6 = rek.Ko_Rk6
							ORDER BY kode_rekening, kdlevel, tgl_bukti, no_bukti");


		$data = [
			'rekappdpt' => $rekappdpt,
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
