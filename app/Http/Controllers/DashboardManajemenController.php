<?php

namespace App\Http\Controllers;

use App\Models\Tbtap;
use App\Models\Pftap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardManajemenController extends Controller
{

    public function index(Request $request)
    {
		$anggaran = $this->anggaran();
		$totalAnggaran = $anggaran->sum('total_anggaran');
        $totalRealisasi = $anggaran->sum('total_realisasi');
        $totalSisa = $anggaran->sum('sisa_anggaran');
		$userPemda = $this->userPemda();
		$userforsaRs = $this->userforsaRs();
		$userforsaPkm = $this->userforsaPkm();
		$userforsaNon = $this->userforsaNon();
		$jmluserPemda = $userPemda->count('id_pemda');
		$jmluserforsaRs = $userforsaRs->count('kode_unit');
		$jmluserforsaPkm = $userforsaPkm->count('kode_unit');
		$jmluserforsaNon = $userforsaNon->count('kode_unit');

        return view('dashboardmanajemen.index', [
			'anggaran' => [
                'total_anggaran' => $totalAnggaran,
                'total_realisasi' => $totalRealisasi,
                'total_sisa' => $totalSisa,
                'persen_realisasi' => ($totalAnggaran == 0) ?: round(($totalRealisasi / $totalAnggaran) * 100, 2),
                'persen_sisa' => ($totalAnggaran == 0) ?: round(($totalSisa / $totalAnggaran) * 100, 2),
				'data_anggaran' => json_encode($anggaran->pluck('total_anggaran')->toArray()),
                'data_realisasi' => json_encode($anggaran->pluck('total_realisasi')->toArray()),
                'data_sisa' => json_encode($anggaran->pluck('sisa_anggaran')->toArray()),
                'data_skpd' => json_encode($anggaran->pluck('nmskpd')->toArray(), JSON_HEX_APOS),
                'data_persen_realisasi' => json_encode($anggaran->pluck('persen_realisasi')->toArray()),
            ],
			'userforsaRs' => [
                'jmluserforsaRs' => $jmluserforsaRs,
            ],
			'userforsaPkm' => [
                'jmluserforsaPkm' => $jmluserforsaPkm,
            ],
			'userforsaNon' => [
                'jmluserforsaNon' => $jmluserforsaNon,
            ],
			'userPemda' => [
                'jmluserPemda' => $jmluserPemda,
            ],
			'data_pemda' => $userPemda,
			'data_forsaRs' => $userforsaRs,
			'data_forsaPkm' => $userforsaPkm,
			'data_forsaNon' => $userforsaNon,
        ]);
    }
	
	public function userPemda()
    { 
                
        $pemda = DB::SELECT("SELECT (@id:=@id+1) AS kdurut, a.* FROM(
                    SELECT c.id AS id_pemda, concat(a.Ko_Wil1,'.',right(concat('0',a.Ko_Wil2),2)) AS kode_pemda, a.Ur_Wil2 AS nama_kab, c.ibukota, 
                    b.Ko_Wil1 AS id_prov, b.Ur_Wil1 AS nama_prov, concat(b.Ko_Wil1,' - ', 'PROVINSI ',b.Ur_Wil1) AS nama_prov_display
                    FROM pf_wil2 a 
                    INNER JOIN pf_wil1 b on a.Ko_Wil1 = b.Ko_Wil1 
                    INNER JOIN tb_pemda c on a.id = c.id_kabkota
					WHERE b.Ur_Wil1 NOT LIKE '%SIMULASI%'
                    ORDER BY a.Ko_Wil1, a.Ko_Wil2 ) a, (SELECT @id:=0) b  ");
		
		return collect($pemda);
       
    }

    public function userforsaRs()
    {
		$period = Tahun();

        $model = DB::select("SELECT 2 AS Kode, a.*
					FROM 
					(
						SELECT MAX(a.Ko_Tap) AS Jenis, b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid, b.id_unit
						FROM tb_tap a INNER JOIN 
						(
							SELECT 
							CONCAT( LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) AS kode_unit, s.ur_subunit AS uraian_unit, b.id_bidang, b.Ur_Bid, s.id AS id_unit
							FROM tb_sub AS s INNER JOIN
							tb_unit AS u ON s.id_unit=u.id INNER JOIN 
							pf_bid AS b ON u.id_bidang=b.id_bidang
						) b ON LEFT(a.ko_unit1,18)=b.kode_unit
						WHERE Ko_Period=".$period." 
						GROUP BY b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid
					) a INNER JOIn pf_tap b ON a.Jenis=b.Ko_Tap
					WHERE a.Jenis>=2 
					AND a.uraian_unit LIKE '%RS%' 
					AND a.uraian_unit NOT LIKE '%Simulasi%'
					AND a.Ur_Bid LIKE '%KESEHATAN%' ");  

        return collect($model);
    }
	
	public function userforsaPkm()
    {
		$period = Tahun();

        $model = DB::select("SELECT 2 AS Kode, a.*
					FROM 
					(
						SELECT MAX(a.Ko_Tap) AS Jenis, b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid, b.id_unit
						FROM tb_tap a INNER JOIN 
						(
							SELECT 
							CONCAT( LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) AS kode_unit, s.ur_subunit AS uraian_unit, b.id_bidang, b.Ur_Bid, s.id AS id_unit
							FROM tb_sub AS s INNER JOIN
							tb_unit AS u ON s.id_unit=u.id INNER JOIN 
							pf_bid AS b ON u.id_bidang=b.id_bidang
						) b ON LEFT(a.ko_unit1,18)=b.kode_unit
						WHERE Ko_Period=".$period." 
						GROUP BY b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid
					) a INNER JOIn pf_tap b ON a.Jenis=b.Ko_Tap
					WHERE a.Jenis>=2 
					AND a.uraian_unit NOT LIKE '%RS%' 
					AND a.uraian_unit NOT LIKE '%Simulasi%'
					AND a.Ur_Bid LIKE '%KESEHATAN%' "); 

        return collect($model);
    }
	
	public function userforsaNon()
    {
		$period = Tahun();

        $model = DB::select("SELECT 2 AS Kode, a.*
					FROM (
						SELECT MAX(a.Ko_Tap) AS Jenis, b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid, b.id_unit
						FROM tb_tap a INNER JOIN 
						(
							SELECT 
							CONCAT( LPAD(s.ko_wil1,2,0),'.' ,
							LPAD(s.ko_wil2,2,0),'.', 
							LPAD(s.ko_urus,2,0),'.', 
							LPAD(s.ko_bid,2,0),'.',
							LPAD(s.ko_unit,2,0),'.',
							LPAD(s.ko_sub,3,0)) AS kode_unit, s.ur_subunit AS uraian_unit, b.id_bidang, b.Ur_Bid, s.id AS id_unit
							FROM tb_sub AS s INNER JOIN
							tb_unit AS u ON s.id_unit=u.id INNER JOIN 
							pf_bid AS b ON u.id_bidang=b.id_bidang
						) b ON LEFT(a.ko_unit1,18)=b.kode_unit
						WHERE Ko_Period=".$period." 
						GROUP BY b.kode_unit, b.uraian_unit, b.id_bidang, b.Ur_Bid
					) a INNER JOIn pf_tap b ON a.Jenis=b.Ko_Tap
					WHERE a.Jenis>=2 
					AND a.uraian_unit NOT LIKE '%Simulasi%'
					AND a.Ur_Bid NOT LIKE '%KESEHATAN%' "); 

        return collect($model);
    }

	public function anggaran()
    {
		$period = Tahun();
		
        $model = DB::SELECT("SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(q.ur_subunit,'Puskesmas','PKM'),'PUSKESMAS','PKM'),'UPTD Laboratorium Lingkungan','Lab. Lingkungan'),'Balai Pelatihan Kesehatan Provinsi Sumatera Selatan','Balai Pelatihan Kesehatan'),'RSK Mata Masyarakat Provinsi Sumatera Selatan','RSK Mata Masyarakat'),'RSUD dr. Tengku Mansyur Kota Tanjungbalai','RSUD dr. Tengku Mansyur'),'RSUD Drs Jacobus Luna, M.Si.','RSUD Drs Jacobus Luna'),'UPTD','') AS nmskpd,
					COALESCE(q.total_anggaran,0) AS total_anggaran,
					COALESCE(w.total_realisasi,0) AS total_realisasi,
					COALESCE(q.total_anggaran,0) - COALESCE(w.total_realisasi,0) AS sisa_anggaran,
					CASE WHEN q.total_anggaran > 0 THEN CAST((COALESCE(w.total_realisasi,0) * 100) / COALESCE(q.total_anggaran,0) AS decimal(18,2)) 
					ELSE 0 END AS persen_realisasi,
					CASE 
					WHEN q.total_anggaran > 0 THEN CAST(((COALESCE(q.total_anggaran,0) - COALESCE(w.total_realisasi,0)) * 100) / COALESCE(q.total_anggaran,0) AS decimal(18,2)) 
					ELSE 0 END AS persen_sisa
					FROM 
					(
						SELECT a.Ko_unitstr, a.ur_subunit, SUM(a.total_anggaran) AS total_anggaran  
						FROM (
							SELECT LEFT(a.ko_unit1,18) AS Ko_unitstr, a.ur_subunit, SUM(a.To_Rp) AS total_anggaran 
							FROM tb_tap a INNER JOIN (
							SELECT MAX(a.id_tap) AS id_tap, a.ko_unit1
							FROM tb_tap a WHERE ko_period = ".$period." 
							GROUP BY a.ko_unit1
							) b ON a.id_tap=b.id_tap AND a.ko_unit1=b.ko_unit1
							WHERE a.Ko_Rk1=5
							GROUP BY a.ko_unit1, a.ur_subunit
						) a
						GROUP BY a.Ko_unitstr, a.ur_subunit
					) q JOIN 
					(
						SELECT a.tahun, a.Ko_unitstr, a.kdrek1, SUM(a.debet) AS total_realisasi
						FROM 
							(
								SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr,  LEFT(a.Ko_Rkk,2) AS kdrek1, SUM(a.jrRp_D) AS debet, SUM(a.jrRp_K) AS kredit
								FROM jr_trans a 
								WHERE (a.Ko_Period = ".$period." ) 
								GROUP BY a.Ko_Period, a.Ko_unitstr, a.Ko_Rkk
								UNION ALL
								SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr,  LEFT(a.Ko_Rkk,2) AS kdrek1, SUM(a.Rp_D) AS debet, SUM(a.Rp_K) AS kredit
								FROM jr_sesuai a 
								WHERE (a.Ko_Period = ".$period." ) 
								GROUP BY a.Ko_Period, a.Ko_unitstr, a.Ko_Rkk
							)  a 
							WHERE a.kdrek1 = 5
							GROUP BY a.tahun, a.Ko_unitstr, a.kdrek1
					) w ON q.Ko_unitstr=w.Ko_unitstr
					ORDER BY CASE WHEN q.total_anggaran > 0 THEN CAST((COALESCE(w.total_realisasi,0) / COALESCE(q.total_anggaran,0)) * 100 AS decimal(18,2)) ELSE 0 END DESC");
        return collect($model);
    }		
}
