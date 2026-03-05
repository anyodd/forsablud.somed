<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuPenerimaanHarianController extends Controller
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
		
		$Ko_tap = DB::SELECT("SELECT MAX(Ko_tap) AS Ko_tap FROM tb_tap WHERE Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' AND CAST(Dt_Tap AS DATE) <= CAST('".$tgl_2."' AS DATE) ");

		$id_tap = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=".$Ko_tap[0]->Ko_tap." AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' AND CAST(Dt_Tap AS DATE) <= CAST('".$tgl_2."' AS DATE) ");
                
		$rincianSpj = DB::select("SELECT A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Ko_Rkk, rek.Ur_Rk6 AS nmrek6, SUM(A.Anggaran) AS Anggaran, SUM(A.Terima_Lalu) AS Terima_Lalu, SUM(A.Setor_Lalu) AS Setor_Lalu, SUM(A.Terima_Lalu) - SUM(A.Setor_Lalu) AS Sisa_Lalu, SUM(A.Terima_Ini) AS Terima_Ini,
							SUM(A.Setor_Ini) AS Setor_Ini, SUM(A.Terima_Ini) - SUM(A.Setor_Ini) AS Sisa_Ini, SUM(A.Terima_Lalu) + SUM(A.Terima_Ini) AS Tot_Terima, SUM(A.Setor_Lalu) + SUM(A.Setor_Ini) AS Tot_Setor,
							(SUM(A.Terima_Lalu) + SUM(A.Terima_Ini)) - (SUM(A.Setor_Lalu) + SUM(A.Setor_Ini)) AS Tot_Sisa, SUM(A.Anggaran) - (SUM(A.Terima_Lalu) + SUM(A.Terima_Ini)) AS Sisa_Anggaran
							FROM (
									SELECT bel.Ko_Period AS tahun, LEFT(bel.ko_rkk,2) AS kdrek1, SUBSTRING(bel.ko_rkk,4,2) AS kdrek2, 
									SUBSTRING(bel.ko_rkk,7,2) AS kdrek3, SUBSTRING(bel.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(bel.Ko_Rkk,13,3) AS kdrek5, 
									RIGHT(bel.Ko_Rkk,4) AS kdrek6, bel.ko_rkk, sum(bel.To_Rp) AS Anggaran, 
									0 AS Terima_Lalu, 0 AS Setor_Lalu, 0 AS Terima_Ini, 0 AS Setor_Ini
									FROM tb_tap AS bel 
									WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = LEFT('".kd_unit()."',18)
									AND (LEFT(bel.ko_rkk,2) IN (4)) 
									GROUP BY bel.Ko_Period,bel.ko_rkk
									
									UNION ALL
									SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, 0 AS Anggaran, 
									SUM(D.real_rp) AS Terima_Lalu, 0 AS Setor_Lalu, 0 AS Terima_Ini, 0 AS Setor_Ini
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp 
									WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (1, 42, 43) )
									GROUP BY A.Ko_Period, A.Ko_Rkk
									UNION ALL
									SELECT A.Ko_Period AS tahun, LEFT(C.Ko_Rkk,2) AS kdrek1, SUBSTRING(C.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(C.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(C.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(C.Ko_Rkk,13,3) AS kdrek5, RIGHT(C.Ko_Rkk,4) AS kdrek6, C.Ko_Rkk, 0 AS Anggaran, 
									SUM(D.real_rp) AS Terima_Lalu, 0 AS Setor_Lalu, 0 AS Terima_Ini, 0 AS Setor_Ini
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp INNER JOIN 
									pf_mapjr C ON A.Ko_Rkk=C.Lo_D
									WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (11) )
									GROUP BY A.Ko_Period, C.Ko_Rkk
									
									UNION ALL
									SELECT B.tahun, LEFT(B.Ko_Rkk,2) AS kdrek1, SUBSTRING(B.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(B.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(B.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(B.Ko_Rkk,13,3) AS kdrek5, RIGHT(B.Ko_Rkk,4) AS kdrek6, B.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, SUM(B.real_rp) AS Setor_Lalu, 0 AS Terima_Ini, 0 AS Setor_Ini
									FROM  (
									SELECT B.Ko_Period AS tahun, B.Ko_unitstr, A.No_byr
									FROM tb_sts B 
									INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr
									) A INNER JOIN (
									SELECT B.Ko_Period AS tahun, A.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
									FROM tb_byr B 
									INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
									INNER JOIN tb_bp D ON A.id_bp = D.id_bp 
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( D.Ko_bp IN (1, 42, 43) )
									GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk
									) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
									GROUP BY B.tahun, B.Ko_Rkk
									UNION ALL
									SELECT B.tahun, LEFT(B.Ko_Rkk,2) AS kdrek1, SUBSTRING(B.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(B.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(B.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(B.Ko_Rkk,13,3) AS kdrek5, RIGHT(B.Ko_Rkk,4) AS kdrek6, B.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, SUM(B.real_rp) AS Setor_Lalu, 0 AS Terima_Ini, 0 AS Setor_Ini
									FROM  (
									SELECT B.Ko_Period AS tahun, B.Ko_unitstr, A.No_byr
									FROM tb_sts B 
									INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr
									) A INNER JOIN (
									SELECT B.Ko_Period AS tahun, C.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
									FROM tb_byr B 
									INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
									INNER JOIN tb_bp D ON A.id_bp = D.id_bp 
									INNER JOIN pf_mapjr C ON A.Ko_Rkk=C.Lo_D
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <  CAST('".$tgl_1."' AS DATE) ) AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( D.Ko_bp IN (11) )
									GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, C.Ko_Rkk
									) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
									GROUP BY B.tahun, B.Ko_Rkk
									
									UNION ALL
									SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, 0 AS Setor_Lalu, SUM(D.real_rp) AS Terima_Ini, 0 AS Setor_Ini
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp 
									WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (1, 42, 43) )
									GROUP BY A.Ko_Period, A.Ko_Rkk
									UNION ALL
									SELECT A.Ko_Period AS tahun, LEFT(C.Ko_Rkk,2) AS kdrek1, SUBSTRING(C.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(C.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(C.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(C.Ko_Rkk,13,3) AS kdrek5, RIGHT(C.Ko_Rkk,4) AS kdrek6, C.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, 0 AS Setor_Lalu, SUM(D.real_rp) AS Terima_Ini, 0 AS Setor_Ini
									FROM tb_bprc A INNER JOIN 
									tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
									tb_bp B ON A.id_bp = B.id_bp INNER JOIN 
									pf_mapjr C ON A.Ko_Rkk=C.Lo_D
									WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
									AND ( B.Ko_bp IN (11) )
									GROUP BY A.Ko_Period, C.Ko_Rkk

									UNION ALL
									SELECT B.tahun, LEFT(B.Ko_Rkk,2) AS kdrek1, SUBSTRING(B.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(B.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(B.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(B.Ko_Rkk,13,3) AS kdrek5, RIGHT(B.Ko_Rkk,4) AS kdrek6, B.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, 0 AS Setor_Lalu, 0 AS Terima_Ini, SUM(B.real_rp) AS Setor_Ini
									FROM  (
									SELECT B.Ko_Period AS tahun, B.Ko_unitstr, A.No_byr
									FROM tb_sts B 
									INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr
									) A INNER JOIN (
									SELECT B.Ko_Period AS tahun, A.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
									FROM tb_byr B 
									INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
									INNER JOIN tb_bp D ON A.id_bp = D.id_bp 
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE)) AND ( D.Ko_bp IN (1, 42, 43) )
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18))	
									GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk
									) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
									GROUP BY B.tahun, B.Ko_Rkk
									UNION ALL
									SELECT B.tahun, LEFT(B.Ko_Rkk,2) AS kdrek1, SUBSTRING(B.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(B.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(B.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(B.Ko_Rkk,13,3) AS kdrek5, RIGHT(B.Ko_Rkk,4) AS kdrek6, B.Ko_Rkk, 0 AS Anggaran, 
									0 AS Terima_Lalu, 0 AS Setor_Lalu, 0 AS Terima_Ini, SUM(B.real_rp) AS Setor_Ini
									FROM  (
									SELECT B.Ko_Period AS tahun, B.Ko_unitstr, A.No_byr
									FROM tb_sts B 
									INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
									GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr
									) A INNER JOIN (
									SELECT B.Ko_Period AS tahun, C.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
									FROM tb_byr B 
									INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
									INNER JOIN tb_bp D ON A.id_bp = D.id_bp 
									INNER JOIN pf_mapjr C ON A.Ko_Rkk=C.Lo_D
									WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE)) AND ( D.Ko_bp IN (11) )
									AND (B.Ko_unitstr = LEFT('".kd_unit()."',18))	
									GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, C.Ko_Rkk
									) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
									GROUP BY B.tahun, B.Ko_Rkk
									
									UNION ALL
									SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, 0 AS Anggaran,
									CASE A.Ko_DK WHEN 'D' THEN -SUM(A.Rp_D) ELSE SUM(A.Rp_K) END AS Terima_Lalu,
									CASE A.Ko_DK WHEN 'D' THEN -SUM(A.Rp_D) ELSE SUM(A.Rp_K) END AS Setor_Lalu,
									0 AS Terima_Ini, 
									0 AS Setor_Ini
									FROM jr_sesuai A INNER JOIN 
									tb_sesuai B ON A.id_tbses=B.id_tbses 	
									WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='04') 
									AND ( CAST(B.dt_sesuai AS DATE) < CAST('".$tgl_1."' AS DATE) )
									AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
									GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK
									
									UNION ALL
								
									SELECT A.Ko_Period AS tahun, LEFT(A.Ko_Rkk,2) AS kdrek1, SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
									SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, 0 AS Anggaran,
									0 AS Terima_Lalu,
									0 AS Setor_Lalu, 
									CASE A.Ko_DK WHEN 'D' THEN -SUM(A.Rp_D) ELSE SUM(A.Rp_K) END AS Terima_Ini,
									CASE A.Ko_DK WHEN 'D' THEN -SUM(A.Rp_D) ELSE SUM(A.Rp_K) END AS Setor_Ini
									FROM jr_sesuai A INNER JOIN 
									tb_sesuai B ON A.id_tbses=B.id_tbses 
									WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_Rkk,2)='04') 
									AND ( CAST(B.dt_sesuai AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
									AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
									GROUP BY A.Ko_Period, A.Ko_Rkk, A.Ko_DK
							) A
							INNER JOIN ". $pf_rk6 . " AS rek ON A.kdrek1 = rek.Ko_Rk1 AND A.kdrek2 = rek.Ko_Rk2 AND A.kdrek3 = rek.Ko_Rk3 AND A.kdrek4 = rek.Ko_Rk4 
							AND A.kdrek5 = rek.Ko_Rk5 AND A.kdrek6 = rek.Ko_Rk6
							GROUP BY A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.Ko_Rkk, rek.Ur_Rk6
							ORDER BY A.Ko_Rkk ASC");


		$data = [
			'rincianSpj' => $rincianSpj,
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
