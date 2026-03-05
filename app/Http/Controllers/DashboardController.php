<?php

namespace App\Http\Controllers;

use App\Models\Tbtap;
use App\Models\Pftap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $anggaran = $this->anggaran();
		$transaksi = $this->transaksi();
		$kas = $this->bukubesar()
				->where('kdrek1', '=', 1)
				->where('kdrek2', '=', 1)
				->where('kdrek3', '=', 1);
		$kewajiban = $this->bukubesar()
				->where('kdrek1', '=', 2)
				->where('kdrek2', '=', 1);
		$asetlancar = $this->bukubesar()
				->where('kdrek1', '=', 1)
				->where('kdrek2', '=', 1);
		$piutang = $this->bukubesar()
				->where('kdrek1', '=', 1)
				->where('kdrek2', '=', 1)
				->where('kdrek3', '=', 6);
		$pendapatan = $this->bukubesar()
				->where('kdrek1', '=', 7);
		$asettetap = $this->bukubesar()
				->where('kdrek1', '=', 1)
				->where('kdrek2', '=', 3)
				->where('kdrek2', '!=', 7);		
		$persediaan = $this->bukubesar()
				->where('kdrek1', '=', 1)
				->where('kdrek2', '=', 1)
				->where('kdrek2', '=', 12);
		$beban = $this->bukubesar()
				->where('kdrek1', '=', 8);
		$ekuitas = $this->bukubesar()
				->where('kdrek1', '=', 3);
        $totalAnggaran = $anggaran->sum('total_anggaran');
        $totalRealisasi = $anggaran->sum('total_realisasi');
        $totalSisa = $anggaran->sum('sisa_anggaran');
		$jumlahklaim = $transaksi->sum('jumlahklaim');
		$nilaiklaim = $transaksi->sum('nilaiklaim');
		$jumlahtagihan = $transaksi->sum('jumlahtagihan');
		$nilaitagihan = $transaksi->sum('nilaitagihan');
		$jumlahkontrakls = $transaksi->sum('jumlahkontrakls');
		$nilaikontrakls = $transaksi->sum('nilaikontrakls');
		$jumlahbuktigu = $transaksi->sum('jumlahbuktigu');
		$nilaibuktigu = $transaksi->sum('nilaibuktigu');
		$saldokas = $kas->sum('saldo');
		$saldokewajiban = $kewajiban->sum('saldo');
		$saldoasetlancar = $asetlancar->sum('saldo');
		$saldopiutang = $piutang->sum('saldo');
		$saldopendapatan = $pendapatan->sum('saldo');
		$saldoasettetap = $asettetap->sum('saldo');
		$saldopersediaan = $persediaan->sum('saldo');
		$saldobeban = $beban->sum('saldo');
		$saldoekuitas = $ekuitas->sum('saldo');
		$saldosurplus = $pendapatan->sum('saldo') - $beban->sum('saldo');

        return view('dashboard.index', [

            'anggaran' => [
                'total_anggaran' => $totalAnggaran,
                'total_realisasi' => $totalRealisasi,
                'total_sisa' => $totalSisa,
                'persen_realisasi' => ($totalAnggaran == 0) ?: round(($totalRealisasi / $totalAnggaran) * 100, 2),
                'persen_sisa' => ($totalAnggaran == 0) ?: round(($totalSisa / $totalAnggaran) * 100, 2),
                'data_realisasi' => json_encode($anggaran->pluck('total_realisasi')->toArray()),
                'data_sisa' => json_encode($anggaran->pluck('sisa_anggaran')->toArray()),
                'data_persen_realisasi' => json_encode($anggaran->pluck('persen_realisasi')->toArray()),
            ],
            'data_anggaran' => $anggaran,
			'klaim' => [
                'jumlahklaim' => $jumlahklaim,
                'nilaiklaim' => $nilaiklaim,
            ],
			'tagihan' => [
                'jumlahtagihan' => $jumlahtagihan,
                'nilaitagihan' => $nilaitagihan,
            ],
			'kontrak' => [
                'jumlahkontrakls' => $jumlahkontrakls,
                'nilaikontrakls' => $nilaikontrakls,
            ],
			'buktigu' => [
                'jumlahbuktigu' => $jumlahbuktigu,
                'nilaibuktigu' => $nilaibuktigu,
            ],
			'realisasi' => $this->realisasi(),
			'kas' => [
                'kas' =>$saldokas,
            ],
			'kewajiban' => [
                'kewajiban' =>$saldokewajiban,
            ],
			'asetlancar' => [
                'asetlancar' =>$saldoasetlancar,
            ],
			'piutang' => [
                'piutang' =>$saldopiutang,
            ],
			'pendapatan' => [
                'pendapatan' =>$saldopendapatan,
            ],
			'asettetap' => [
                'asettetap' =>$saldoasettetap,
            ],
			'persediaan' => [
                'persediaan' =>$saldopersediaan,
            ],
			'beban' => [
                'beban' =>$saldobeban,
            ],
			'ekuitas' => [
                'ekuitas' =>$saldoekuitas,
            ],
			'surplus' => [
                'surplus' =>$saldosurplus,
            ],
			'persen' => [
                'persen_cashratio' => ($saldokewajiban == 0) ?: round(($saldokas / $saldokewajiban) * 100, 2),
				'persen_currentratio' => ($saldokewajiban == 0) ?: round(($saldoasetlancar / $saldokewajiban) * 100, 2),
				'persen_colllectionratio' => ($saldopendapatan == 0) ?: round(($saldopiutang / $saldopendapatan) * 100, 2),
				'persen_fixedratio' => ($saldoasettetap == 0) ?: round(($saldopendapatan / $saldoasettetap) * 100, 2),
				'persen_roi' => ($saldoasettetap == 0) ?: round(($saldosurplus / $saldoasettetap) * 100, 2),
				'persen_roe' => (($saldoekuitas-$saldosurplus) == 0) ?: round(($saldosurplus / ($saldoekuitas-$saldosurplus) ) * 100, 2),
				'persen_inventory' => ($saldopendapatan == 0) ?: round(($saldopersediaan / $saldopendapatan) * 100, 2),
				'persen_operasional' => ($saldobeban == 0) ?: round(($saldopendapatan / $saldobeban) * 100, 2),
            ],
        ]);
    }

    public function anggaran()
    {
		$period = Tahun();
        $unit = kd_unit();
		
		$setting = DB::SELECT("SELECT apbd FROM tb_sub WHERE ko_unitstr = '".kd_unit()."' ");
		
		$sumberdana = "  ";
		
		if(!empty($setting)) {
			$apbd = DB::SELECT("SELECT apbd FROM tb_sub WHERE ko_unitstr = '".kd_unit()."' ");
		} else {
			$apbd = DB::SELECT("SELECT 0 AS apbd FROM tb_sub LIMIT 1 ");
		}

		if($apbd[0]->apbd == 0 ) {
			$sumberdana = "  AND A.Ko_Pdp<>4";	
		}
		
		//$id_tap = Tbtap::where(['ko_period'=>$period, 'ko_unit1'=>$unit])->max('id_tap');
		
		$tap = DB::select("SELECT ".$period." AS Ko_Period,  COALESCE(MAX(a.ko_tap),0) AS ko_tap, COALESCE(MAX(id_tap),0) AS id_tap
                FROM tb_tap a
                LEFT JOIN pf_tap b ON a.Ko_Tap = b.Ko_Tap
                WHERE LEFT(a.ko_unit1,18) = '".$unit."' and a.Ko_Period = ".$period." ");
		$id_tap = $tap[0]->id_tap;
		$ko_tap = $tap[0]->ko_tap;

        $model = DB::select("SELECT q.Ko_Period, q.ko_unit1, q.Ko_Rk1, q.total_anggaran AS total_anggaran, q.total_realisasi AS total_realisasi,
		COALESCE(q.total_anggaran,0) - COALESCE(q.total_realisasi,0) as sisa_anggaran,
        case when q.total_anggaran > 0 then cast((COALESCE(q.total_realisasi,0) * 100) / COALESCE(q.total_anggaran,0) as decimal(18,2)) else 0 end as persen_realisasi,
        case when q.total_anggaran > 0 then cast(((COALESCE(q.total_anggaran,0) - COALESCE(q.total_realisasi,0)) * 100) / COALESCE(q.total_anggaran,0) as decimal(18,2)) else 0 end as persen_sisa 
		FROM 
		(
		SELECT ".$period." AS Ko_Period, '".$unit."' AS ko_unit1, 5 AS Ko_Rk1,  'BELANJA' AS Ur_Rk1, SUM(A.To_Rp) AS total_anggaran, 0 AS total_realisasi
		FROM tb_tap A INNER JOIN
		tb_sub1 C ON A.Ko_Period = C.Ko_Period AND A.ko_unit1 = C.ko_unit1
		WHERE A.Ko_Rk1 = 5 AND A.ko_tap = ".$ko_tap." AND A.id_tap = ".$id_tap." AND A.Ko_Period = ".$period." AND LEFT(A.ko_unit1,18)='".$unit."' ".$sumberdana."
		UNION ALL
		SELECT ".$period." AS Ko_Period, '".$unit."' AS ko_unit1, 5 AS Ko_Rk1,  'BELANJA' AS Ur_Rk1, 0 AS total_anggaran, SUM(jrrp_d)-SUM(jrrp_k) AS total_realisasi
		FROM jr_trans A
		WHERE A.Ko_jr=61 AND LEFT(A.Ko_Rkk,2)=5 AND A.Ko_Period = ".$period." AND A.ko_unitstr =LEFT('".$unit."',18)
		UNION ALL
		SELECT ".$period." AS Ko_Period, '".$unit."' AS ko_unit1, 5 AS Ko_Rk1,  'BELANJA' AS Ur_Rk1, 0 AS total_anggaran, SUM(Rp_D)-SUM(Rp_K) AS total_realisasi
		FROM jr_sesuai A
		WHERE LEFT(A.Ko_Rkk,2)=5 AND A.Ko_Period = ".$period." AND A.ko_unitstr =LEFT('".$unit."',18)
		) q "); 

        return collect($model);
    }
	
	public function transaksi()
    {
		$period = Tahun();
        $unit = kd_unit();

        $model = DB::select("select ".$period.", coalesce(sum(a.jumlahklaim),0) as jumlahklaim, coalesce(sum(nilaiklaim),0) as nilaiklaim, 
				coalesce(sum(a.jumlahkontrakls),0) as jumlahkontrakls, coalesce(sum(a.nilaikontrakls),0) as nilaikontrakls, 
				coalesce(sum(a.jumlahtagihan),0) as jumlahtagihan, coalesce(sum(a.nilaitagihan),0) as nilaitagihan, 
				coalesce(sum(a.jumlahbuktigu),0) as jumlahbuktigu, coalesce(sum(a.nilaibuktigu),0) as nilaibuktigu
				from (
				select count(a.ko_bp) as jumlahklaim, sum(b.To_Rp) as nilaiklaim, 0 as jumlahkontrakls, 0 as nilaikontrakls, 
				0 as jumlahtagihan, 0 as nilaitagihan, 0 as  jumlahbuktigu, 0 as nilaibuktigu 
				from tb_bp a 
				inner join tb_bprc b on a.id_bp=b.id_bp 
				where a.ko_bp=1 and LEFT(a.ko_unit1,18) ='".$unit."' and a.Ko_Period = ".$period."
				group by a.ko_bp
				union all
				select 0 as jumlahklaim, 0 as nilaiklaim, count(a.ko_bp) as jumlahkontrakls, sum(b.To_Rp) as nilaikontrakls, 
				0 as jumlahtagihan, 0 as nilaitagihan, 0 as  jumlahbuktigu, 0 as nilaibuktigu 
				from tb_bp a 
				inner join tb_bprc b on a.id_bp=b.id_bp 
				where a.ko_bp=3 and LEFT(a.ko_unit1,18) ='".$unit."' and a.Ko_Period = ".$period."
				group by a.ko_bp
				union all
				select 0 as jumlahklaim, 0 as nilaiklaim, 0 as jumlahkontrakls, 0 as nilaikontrakls, 
				count(a.ko_bp) as jumlahtagihan, sum(b.To_Rp) as nilaitagihan, 0 as  jumlahbuktigu, 0 as nilaibuktigu 
				from tb_bp a 
				inner join tb_bprc b on a.id_bp=b.id_bp 
				where a.ko_bp=4 and LEFT(a.ko_unit1,18) ='".$unit."' and a.Ko_Period = ".$period."
				group by a.ko_bp
				union all
				select 0 as jumlahklaim, 0 as nilaiklaim, 0 as jumlahkontrakls, 0 as nilaikontrakls, 
				0 as jumlahtagihan, 0 as nilaitagihan, count(a.ko_bp) as  jumlahbuktigu, sum(b.To_Rp) as nilaibuktigu 
				from tb_bp a 
				inner join tb_bprc b on a.id_bp=b.id_bp 
				where a.ko_bp=5 and LEFT(a.ko_unit1,18) ='".$unit."' and a.Ko_Period = ".$period."
				group by a.ko_bp
				) a "); 

        return collect($model);
    }
	
	public function realisasi()
    {	
		$pf_rk6 = "";
		$tahun = Tahun();
        $unit = kd_unit();
		$id_bidang = bidang_id(kd_unit());
		$pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = 0 GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";
		
		$model =DB::SELECT("SELECT A.Tahun, COALESCE(SUM(A.pdpt_real),0) /1000000 AS pdpt_real, COALESCE(SUM(A.blj_real),0) /1000000 AS blj_real, A.Kode FROM (
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Jan' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=1 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Feb' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=2 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Maret' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=3 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'April' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=4 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Mei' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=5 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Juni' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=6 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Juli' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=7 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Agustus' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=8 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Sep' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=9 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Okt' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=10 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Nov' AS Kode
		FROM jr_trans a 
        INNER JOIN ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=11 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, CASE WHEN b.Ko_Rk1 = 4 THEN SUM(a.jrRp_K)-SUM(a.jrRp_D) ELSE 0 END AS pdpt_real, CASE WHEN b.Ko_Rk1 = 5 THEN SUM(a.jrRp_D)-SUM(a.jrRp_K) ELSE 0 END AS blj_real, 'Des' AS Kode
		FROM jr_trans a 
        INNER JOIN  ".$pf_rk6." b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
		WHERE MONTH(a.dt_bukti)=12 AND (b.Ko_Rk1 IN (4,5))
		AND a.Ko_Period = ". $tahun . " AND a.Ko_unitstr = LEFT('". $unit . "',18)
		GROUP BY b.Ko_Rk1
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'Jan' AS Kode
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'Feb' AS Kode
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'Maret' AS Kode
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'April' AS Kode
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'Mei' AS Kode
		UNION ALL
		SELECT ".$tahun." AS Tahun, 0 AS pdpt_real, 0 AS blj_real, 'Juni' AS Kode) A
		GROUP BY A.Tahun, A.Kode");
		
		return collect($model);
       
    }
	
	public function bukubesar ()
    {	
		$tahun = Tahun();
        $unit = kd_unit();
		$id_bidang = bidang_id(kd_unit());

		$model =DB::SELECT("SELECT a.tahun, a.Ko_unitstr, a.kdrekgab, a.nmrekgab, 
			CASE a.saldo_normal WHEN 'D' THEN SUM(a.debet)  - SUM(a.kredit) ELSE SUM(a.kredit) - SUM(a.debet) END AS saldo, 
			a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.kdrek6, a.saldo_normal
			FROM
			(
				SELECT a.tahun, a.Ko_unitstr, CASE 4
				WHEN 6 THEN concat(lpad(a.kdrek1,2,0),'.',lpad(a.kdrek2,2,0),'.', lpad(a.kdrek3,2,0),'.',lpad(a.kdrek4,2,0),'.',lpad(a.kdrek5,3,0),'.',
				lpad(a.kdrek6,4,0)) 
				WHEN 5 THEN concat(lpad(a.kdrek1,2,0),'.',lpad(a.kdrek2,2,0),'.', lpad(a.kdrek3,2,0),'.',lpad(a.kdrek4,2,0),'.',lpad(a.kdrek5,3,0)) 
				WHEN 4 THEN concat(lpad(a.kdrek1,2,0),'.',lpad(a.kdrek2,2,0),'.', lpad(a.kdrek3,2,0),'.',lpad(a.kdrek4,2,0)) 
				WHEN 3 THEN concat(lpad(a.kdrek1,2,0),'.',lpad(a.kdrek2,2,0),'.', lpad(a.kdrek3,2,0)) 
				WHEN 2 THEN concat(lpad(a.kdrek1,2,0),'.',lpad(a.kdrek2,2,0)) 
				WHEN 1 THEN lpad(a.kdrek1,2,0) END AS kdrekgab,
				CASE 4
				WHEN 6 THEN b.Ur_Rk6
				WHEN 5 THEN c.Ur_Rk5
				WHEN 4 THEN d.Ur_Rk4
				WHEN 3 THEN e.Ur_Rk3
				WHEN 2 THEN f.Ur_Rk2
				WHEN 1 THEN i.Ur_Rk1
				END AS nmrekgab,
				a.debet,
				a.kredit,
				a.kdrek1 AS kdrek1,
				CASE 4
				WHEN 1 THEN 0
				ELSE a.kdrek2
				END AS kdrek2,
				CASE
				WHEN 4 < 3 THEN 0
				ELSE a.kdrek3
				END AS kdrek3,
				CASE
				WHEN 4 < 4 THEN 0
				ELSE a.kdrek4
				END AS kdrek4,
				CASE
				WHEN 4 < 5 THEN 0
				ELSE a.kdrek5
				END AS kdrek5,
				CASE
				WHEN 4 < 6 THEN 0
				ELSE a.kdrek6
				END AS kdrek6, 
				e.SN_rk3 AS saldo_normal
				FROM (
				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
				SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, RIGHT(a.ko_rkk5,3) AS kdrek5, lpad(1,4,0) AS kdrek6, 
				soaw_Rp_D AS debet, soaw_Rp_K AS kredit
				FROM tb_soaw a
				WHERE (a.Ko_Period = ". $tahun . ") AND (LEFT(a.ko_rkk5,2) IN (1, 2)) AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				UNION ALL

				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
				SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, RIGHT(a.ko_rkk5,3) AS kdrek5, lpad(1,4,0) AS kdrek6, 
				soaw_Rp_D AS debet, soaw_Rp_K AS kredit
				FROM tb_soaw a
				WHERE (a.Ko_Period = ". $tahun . ") AND (a.ko_rkk5='03.01.01.01.001') AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				UNION ALL

				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
				SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, SUBSTRING(a.ko_rkk5,10,2) AS kdrek4, RIGHT(a.ko_rkk5,3) AS kdrek5, lpad(3,4,0) AS kdrek6, 
				soaw_Rp_D AS debet, soaw_Rp_K AS kredit
				FROM tb_soaw a
				WHERE (a.Ko_Period = ". $tahun . ") AND (a.ko_rkk5='03.01.01.01.002') AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				UNION ALL

				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.ko_rkk5,2) AS kdrek1, SUBSTRING(a.ko_rkk5,4,2) AS kdrek2, 
				SUBSTRING(a.ko_rkk5,7,2) AS kdrek3, '01' AS kdrek4, '01' AS kdrek5, lpad(1,4,0) AS kdrek6, 
				soaw_Rp_D AS debet, soaw_Rp_K AS kredit
				FROM tb_soaw a
				WHERE (a.Ko_Period = ". $tahun . ") AND (a.ko_rkk5='03.01.01.02.001') AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				UNION ALL

				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
				SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
				SUM(a.jrRp_D) AS debet, SUM(a.jrRp_K) AS kredit
				FROM jr_trans a 
				WHERE (a.Ko_Period = ". $tahun . ") AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				GROUP BY a.Ko_Period, a.Ko_unitstr, a.Ko_Rkk
				UNION ALL
				SELECT a.Ko_Period AS tahun, a.Ko_unitstr AS Ko_unitstr, LEFT(a.Ko_Rkk,2) AS kdrek1, SUBSTRING(a.Ko_Rkk,4,2) AS kdrek2, 
				SUBSTRING(a.Ko_Rkk,7,2) AS kdrek3, SUBSTRING(a.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(a.Ko_Rkk,13,3) AS kdrek5, RIGHT(a.Ko_Rkk,4) AS kdrek6, 
				SUM(a.Rp_D) AS debet, SUM(a.Rp_K) AS kredit
				FROM jr_sesuai a 
				WHERE (a.Ko_Period = ". $tahun . ") AND a.Ko_unitstr LIKE LEFT('". $unit . "',18)
				GROUP BY a.Ko_Period, a.Ko_unitstr, a.Ko_Rkk
				)  a LEFT JOIN
				( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = 0 GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) ) b ON a.kdrek1 = b.Ko_Rk1 AND a.kdrek2 = b.Ko_Rk2 AND a.kdrek3 = b.Ko_Rk3 AND a.kdrek4 = b.Ko_Rk4 AND a.kdrek5 = b.Ko_Rk5 
				AND a.kdrek6 = b.Ko_Rk6 INNER JOIN
				pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
				pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
				pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3 INNER JOIN
				pf_rk2 f ON e.Ko_Rk1 = f.Ko_Rk1 AND e.Ko_Rk2 = f.Ko_Rk2 INNER JOIN
				pf_rk1 i ON f.Ko_Rk1 = i.Ko_Rk1
			) a
			GROUP BY a.tahun, a.Ko_unitstr, a.kdrekgab, a.nmrekgab, a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, kdrek5, a.kdrek6, a.saldo_normal");
		
		return collect($model);
	}
	
}
