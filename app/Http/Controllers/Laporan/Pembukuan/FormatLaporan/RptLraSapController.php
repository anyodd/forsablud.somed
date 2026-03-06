<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLraSapController extends Controller
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
		$idlevelrekening = 4;


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
												
		
		$Ko_tap = DB::SELECT("SELECT MAX(Ko_tap) AS Ko_tap FROM tb_tap WHERE Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' AND CAST(Dt_Tap AS DATE) <= CAST('".$tgl_2."' AS DATE) ");

		$id_tap = DB::SELECT("SELECT MAX(id_tap) AS id_tap FROM tb_tap WHERE Ko_tap=".$Ko_tap[0]->Ko_tap." AND Ko_Period = ".$tahun." AND LEFT(Ko_unit1,18) = '".kd_unit()."' AND CAST(Dt_Tap AS DATE) <= CAST('".$tgl_2."' AS DATE) ");
		$sumberdana = "  ";
		if(tb_sub('apbd') == 0 ) {
			$sumberdana = "  AND bel.Ko_Pdp<>".kd_pdp_apbd();	
		}

		$apbd = request('apbd');

		$virtual_apbd = "";
		if ($apbd == 'true') {
			if(tb_sub('apbd') == 1) { // Hanya tarik virtual APBD jika toggle APBD menyala
				$virtual_apbd = "
				UNION ALL
				SELECT CONCAT(bel.Ko_Period, '-4-1-4-0') as kodebuatan,
				bel.Ko_Period AS tahun, 4 as kdrek1, 1 as kdrek2, 4 as kdrek3, 0 as kdrek4, sum(bel.To_Rp) AS jumlah
				FROM tb_tap AS bel
				WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = '".kd_unit()."'
				AND bel.Ko_Pdp = ".kd_pdp_apbd()." 
				AND (LEFT(bel.ko_rkk,2) = 5 OR (LEFT(bel.ko_rkk,2)=6 AND SUBSTRING(bel.ko_rkk,4,2)=2))
				GROUP BY bel.Ko_Period
				";
			}
		}

		$query = DB::select("WITH anggaran AS (
							SELECT CONCAT(bel.Ko_Period,'-',n.kdrek1,'-',n.kdrek2,'-',n.kdrek3,'-',n.kdrek4) as kodebuatan, 
							bel.Ko_Period AS tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4, sum(bel.To_Rp) AS jumlah
							FROM tb_tap AS bel INNER JOIN
							pf_rek_sap n ON LEFT(bel.ko_rkk,2) = n.Ko_Rk1 AND SUBSTRING(bel.ko_rkk,4,2) = n.Ko_Rk2 AND SUBSTRING(bel.ko_rkk,7,2) = n.Ko_Rk3 AND SUBSTRING(bel.ko_rkk,10,2) = n.Ko_Rk4 AND SUBSTRING(bel.ko_rkk,13,3) = n.Ko_Rk5							
							WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = '".kd_unit()."' ".$sumberdana."
							AND (LEFT(bel.ko_rkk,2) = 4 OR (LEFT(bel.ko_rkk,2)=6 AND SUBSTRING(bel.ko_rkk,4,2)=1))
							GROUP BY bel.Ko_Period, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
							UNION ALL
							SELECT CONCAT(bel.Ko_Period,'-',n.kdrek1,'-',n.kdrek2,'-',n.kdrek3,'-',n.kdrek4) as kodebuatan, 
							bel.Ko_Period AS tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4, sum(bel.To_Rp) AS jumlah
							FROM tb_tap AS bel INNER JOIN
							tb_kegs2 jjj ON bel.Ko_sKeg2=jjj.Ko_sKeg2 AND bel.Ko_sKeg1=jjj.Ko_sKeg1 AND bel.Ko_unit1=jjj.Ko_unit1 INNER JOIN
							tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
							tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
							pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
							pf_keg l ON k.id_keg=l.id_keg INNER JOIN
							pf_prg m ON l.id_prog=m.id_prog INNER JOIN
							pf_rek_sap n ON LEFT(bel.ko_rkk,2) = n.Ko_Rk1 AND SUBSTRING(bel.ko_rkk,4,2) = n.Ko_Rk2 AND SUBSTRING(bel.ko_rkk,7,2) = n.Ko_Rk3 AND SUBSTRING(bel.ko_rkk,10,2) = n.Ko_Rk4 AND SUBSTRING(bel.ko_rkk,13,3) = n.Ko_Rk5							
							WHERE bel.Ko_tap=".$Ko_tap[0]->Ko_tap." AND bel.id_tap=".$id_tap[0]->id_tap." AND LEFT(bel.Ko_unit1,18) = '".kd_unit()."' ".$sumberdana."
							AND (LEFT(bel.ko_rkk,2) = 5 OR (LEFT(bel.ko_rkk,2)=6 AND SUBSTRING(bel.ko_rkk,4,2)=2))
							GROUP BY bel.Ko_Period, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4
							".$virtual_apbd."
						),
						realisasi AS (
							SELECT CONCAT(
									realisasitahunini.tahun,'-',n.kdrek1,'-',n.kdrek2,'-',n.kdrek3,'-',n.kdrek4) AS kodebuatan,
									realisasitahunini.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4,
									sum(realisasitahunini.nilaiRealisasi) as nilaiRealisasi, sum(realisasitahunini.nilaiRealisasiperiodelalu) as nilaiRealisasiperiodelalu
							FROM (
									SELECT a.Ko_Period AS tahun, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
									SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6,
									CASE WHEN CAST(a.dt_bukti AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_bukti AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND (LEFT(a.Ko_Rkk,2) = 4 OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=1)) 
									THEN a.jrRp_K-a.jrRp_D 
									WHEN CAST(a.dt_bukti AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_bukti AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND (LEFT(a.Ko_Rkk,2) = 5 OR (LEFT(a.Ko_Rkk,2) = 6 AND SUBSTRING(a.Ko_Rkk,4,2)=2)) 
									THEN a.jrRp_D-a.jrRp_K ELSE 0 END AS nilaiRealisasi, COALESCE(0,0) as nilaiRealisasiperiodelalu
									FROM jr_trans a INNER JOIN
									tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unitstr=LEFT(jjj.Ko_unit1,18) INNER JOIN
									tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
									tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
									pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
									pf_keg l ON k.id_keg=l.id_keg INNER JOIN
									pf_prg m ON l.id_prog=m.id_prog 
									WHERE ((LEFT(a.Ko_Rkk,2) IN (4,5)) OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=1) OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=2))
									AND CAST(a.dt_bukti AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_bukti AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND LEFT(a.Ko_unitstr,18) = '".kd_unit()."'
									UNION ALL
									SELECT a.Ko_Period AS tahun, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
									SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6,
									CASE WHEN CAST(a.dt_sesuai AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND (LEFT(a.Ko_Rkk,2) = 4 OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=1)) 
									THEN a.Rp_K-a.Rp_D 
									WHEN CAST(a.dt_sesuai AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND (LEFT(a.Ko_Rkk,2) = 5 OR (LEFT(a.Ko_Rkk,2) = 6 AND SUBSTRING(a.Ko_Rkk,4,2)=2)) 
									THEN a.Rp_D-a.Rp_K ELSE 0 END AS nilaiRealisasi, COALESCE(0,0) as nilaiRealisasiperiodelalu
									FROM jr_sesuai a LEFT OUTER JOIN
									tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unitstr=LEFT(jjj.Ko_unit1,18) LEFT OUTER JOIN
									tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 LEFT OUTER JOIN
									tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 LEFT OUTER JOIN
									pf_skeg k ON j.id_sub_keg=k.id_sub_keg LEFT OUTER JOIN
									pf_keg l ON k.id_keg=l.id_keg LEFT OUTER JOIN
									pf_prg m ON l.id_prog=m.id_prog 
									WHERE ((LEFT(a.Ko_Rkk,2) IN (4,5)) OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=1) OR (LEFT(a.Ko_Rkk,2)=6 AND SUBSTRING(a.Ko_Rkk,4,2)=2))
									AND CAST(a.dt_sesuai AS DATE) >= CAST('".$tgl_1."' AS DATE) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE)
									AND LEFT(a.Ko_unitstr,18) = '".kd_unit()."'
									UNION ALL
									SELECT a.Ko_Period AS tahun, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
									SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, SUBSTRING(a.ko_rkk5,13,3) AS kdrek5, lpad(1,4,0) AS kdrek6,
									COALESCE(0,0) AS nilaiRealisasi, 
									CASE WHEN (LEFT(a.ko_rkk5,2) = 4 OR (LEFT(a.ko_rkk5,2)= 6 AND SUBSTRING(a.ko_rkk5,4,2)=1)) 
									THEN a.soaw_Rp_K-a.soaw_Rp_D 
									WHEN (LEFT(a.ko_rkk5,2) = 5 OR (LEFT(a.ko_rkk5,2) = 6 AND SUBSTRING(a.ko_rkk5,4,2)=2)) 
									THEN a.soaw_Rp_D-a.soaw_Rp_K ELSE 0 END as nilaiRealisasiperiodelalu
									FROM tb_soaw a
									WHERE (a.Ko_Period = ". Tahun().") AND LEFT(a.Ko_unitstr,18) = '".kd_unit()."' AND (LEFT(a.ko_rkk5,2) IN (4, 5, 6)) 
							) realisasitahunini INNER JOIN
							pf_rek_sap n ON realisasitahunini.kdrek1 = n.Ko_Rk1 AND realisasitahunini.kdrek2 = n.Ko_Rk2 AND realisasitahunini.kdrek3 = n.Ko_Rk3 AND realisasitahunini.kdrek4 = n.Ko_Rk4 AND realisasitahunini.kdrek5 = n.Ko_Rk5	
							GROUP BY realisasitahunini.tahun, n.kdrek1, n.kdrek2, n.kdrek3, n.kdrek4

						),
						temp AS (
						SELECT
							CASE
									WHEN q.tahun IS NULL THEN w.tahun
									ELSE q.tahun
						END AS tahun,
							CASE
									WHEN q.kdrek1 IS NULL THEN w.kdrek1
									ELSE q.kdrek1
						END AS kdrek1,
							CASE
									WHEN q.kdrek2 IS NULL THEN w.kdrek2
									else q.kdrek2
						END AS kdrek2,
							CASE
									WHEN q.kdrek3 IS NULL THEN w.kdrek3
									ELSE q.kdrek3
						END AS kdrek3,
							CASE
									WHEN q.kdrek4 IS NULL THEN w.kdrek4
									ELSE q.kdrek4
						END AS kdrek4,
						COALESCE(q.jumlah,0) as jumlah, COALESCE(w.nilaiRealisasi,0) AS nilaiRealisasi, COALESCE(w.nilaiRealisasiperiodelalu,0) AS nilaiRealisasiperiodelalu
						FROM anggaran AS q
						LEFT JOIN realisasi AS w ON q.kodebuatan=w.kodebuatan
						UNION
						SELECT
							CASE
									WHEN q.tahun IS NULL THEN w.tahun
									ELSE q.tahun
						END AS tahun,
							CASE
									WHEN q.kdrek1 IS NULL THEN w.kdrek1
									ELSE q.kdrek1
						END AS kdrek1,
							CASE
									WHEN q.kdrek2 IS NULL THEN w.kdrek2
									else q.kdrek2
						END AS kdrek2,
							CASE
									WHEN q.kdrek3 IS NULL THEN w.kdrek3
									ELSE q.kdrek3
						END AS kdrek3,
							CASE
									WHEN q.kdrek4 IS NULL THEN w.kdrek4
									ELSE q.kdrek4
						END AS kdrek4,
						COALESCE(q.jumlah,0) as jumlah, COALESCE(w.nilaiRealisasi,0) AS nilaiRealisasi, COALESCE(w.nilaiRealisasiperiodelalu,0) AS nilaiRealisasiperiodelalu
						FROM anggaran AS q
						RIGHT JOIN realisasi AS w ON q.kodebuatan=w.kodebuatan						
						)
						SELECT
								temp.kdrek1 AS koderekening,
								rek1.nmrek1 AS uraian,
								SUM(temp.jumlah) AS temp_jumlah, SUM(temp.nilaiRealisasi) AS nilaiRealisasi,
								SUM(temp.nilaiRealisasiperiodelalu) AS nilaiRealisasiperiodelalu
						FROM temp
						INNER JOIN pf_sap1 AS rek1 ON temp.kdrek1 = rek1.kdrek1
						GROUP BY temp.kdrek1,rek1.nmrek1
						UNION ALL
						SELECT
								CONCAT(temp.kdrek1,'.',temp.kdrek2) AS koderekening,
								rek2.nmrek2,
								SUM(temp.jumlah) AS temp_jumlah, SUM(temp.nilaiRealisasi) AS nilaiRealisasi,
								SUM(temp.nilaiRealisasiperiodelalu) AS nilaiRealisasiperiodelalu
						FROM temp
						INNER JOIN pf_sap2 AS rek2 ON temp.kdrek1 = rek2.kdrek1 AND temp.kdrek2 = rek2.kdrek2
						WHERE ".$idlevelrekening." >=2
						GROUP BY temp.kdrek1,temp.kdrek2,rek2.nmrek2
						UNION ALL
						SELECT
								CONCAT(temp.kdrek1,'.',temp.kdrek2,'.',RIGHT(CONCAT('0', temp.kdrek3), 2)) AS koderekening,
								rek3.nmrek3,
								SUM(temp.jumlah) AS temp_jumlah, SUM(temp.nilaiRealisasi) AS nilaiRealisasi,
								SUM(temp.nilaiRealisasiperiodelalu) AS nilaiRealisasiperiodelalu
						FROM temp
						INNER JOIN pf_sap3 AS rek3 ON temp.kdrek1 = rek3.kdrek1 AND temp.kdrek2 = rek3.kdrek2 AND temp.kdrek3 = rek3.kdrek3
						WHERE ".$idlevelrekening." >=3
						GROUP BY temp.kdrek1,temp.kdrek2,temp.kdrek3,rek3.nmrek3
						UNION ALL
						SELECT
								CONCAT(temp.kdrek1,'.',temp.kdrek2,'.',RIGHT(CONCAT('0', temp.kdrek3), 2),
								'.',RIGHT(CONCAT('0', temp.kdrek4), 2)) AS koderekening,
								rek4.nmrek4,
								SUM(temp.jumlah) AS temp_jumlah, SUM(temp.nilaiRealisasi) AS nilaiRealisasi,
								SUM(temp.nilaiRealisasiperiodelalu) AS nilaiRealisasiperiodelalu
						FROM temp
						INNER JOIN pf_sap4 AS rek4 ON temp.kdrek1 = rek4.kdrek1 AND temp.kdrek2 = rek4.kdrek2
								AND temp.kdrek3 = rek4.kdrek3 AND temp.kdrek4 = rek4.kdrek4
						WHERE ".$idlevelrekening." >=4
						GROUP BY temp.kdrek1,temp.kdrek2,temp.kdrek3,temp.kdrek4,rek4.nmrek4
						ORDER BY koderekening");
		
		$data = [
			'rincianLRA' => $query,
			'ambilbidang' => $bid,
			'ambilskpd' => $skpd,
			'ambilunit' => $unit,
			'refPemda' => $pemda,
		];

        return [
            'data' => $data,
        ];
    }
}
