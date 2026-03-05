<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLpeController extends Controller
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
                
		$lpe = DB::select("SELECT a.kode, a.uraian, COALESCE(SUM(a.saldo_akhir),0) AS saldo_akhir, COALESCE(SUM(a.saldo_awal), 0) AS saldo_awal
						FROM (					
							SELECT a.kode, a.uraian, COALESCE(a.saldo,0) AS saldo_akhir, COALESCE(b.saldo, 0) AS saldo_awal
							FROM
							(
							SELECT a.kode, a.uraian, SUM(a.saldo) AS saldo 
							FROM (
								SELECT 1 AS kode, 'Ekuitas Awal' AS uraian, 0  AS saldo
								UNION ALL
								SELECT 1 AS kode, 'Ekuitas Awal' AS uraian, SUM(a.soaw_Rp_K) AS saldo
								FROM tb_soaw a
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 3 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 AND SUBSTRING(a.ko_rkk5,10,2) = 1
								AND a.Ko_unitstr = '".kd_unit()."'
								GROUP BY a.Ko_unitstr
								UNION ALL
								SELECT 1 AS kode, 'Ekuitas Awal' AS uraian, SUM(a.soaw_Rp_K) AS saldo
								FROM tb_soaw a
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 3 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 AND SUBSTRING(a.ko_rkk5,10,2) = 2
								AND a.Ko_unitstr = '".kd_unit()."'
								GROUP BY a.Ko_unitstr
								) a
								GROUP BY a.kode, a.uraian
							) a LEFT JOIN
							(
							SELECT 1 AS kode, 'Ekuitas Awal' AS uraian, SUM(a.soaw_Rp_K) AS saldo
							FROM tb_soaw a
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 3 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 AND SUBSTRING(a.ko_rkk5,10,2) = 1  
							AND SUBSTRING(a.ko_rkk5,13,3) = 1 AND a.Ko_unitstr = '".kd_unit()."' 
							GROUP BY a.Ko_unitstr
							) b ON a.kode = b.kode
							UNION ALL

							SELECT a.kode, a.uraian, COALESCE(a.saldo,0) AS saldo_akhir, COALESCE(b.saldo, 0) AS saldo_awal
							FROM
							(
							SELECT a.kode, a.uraian, SUM(a.saldo) AS saldo 
							FROM (
								SELECT 2 AS kode, 'Surplus/Defisit LO' AS uraian, 0  AS saldo
								UNION ALL
								SELECT 2 AS kode, 'Surplus/Defisit LO' AS uraian, SUM(a.kredit - a.debet) AS saldo
								FROM tb_saldo a
								WHERE a.tahun = ".$tahun." AND a.kdrek1 = 7 AND a.Ko_unitstr = '".kd_unit()."' AND a.kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								GROUP BY a.tahun, a.Ko_unitstr, a.kdrek1, a.bukti_tgl, a.kode
								UNION ALL
								SELECT 2 AS kode, 'Surplus/Defisit LO' AS uraian, -SUM(a.debet - a.kredit) AS saldo
								FROM tb_saldo a
								WHERE a.tahun = ".$tahun." AND a.kdrek1 = 8 AND a.Ko_unitstr = '".kd_unit()."' AND a.kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								GROUP BY a.tahun, a.Ko_unitstr, a.kdrek1, a.bukti_tgl, a.kode
								) a
								GROUP BY a.kode, a.uraian
							) a LEFT JOIN
							(
							SELECT a.kode, a.uraian, SUM(a.saldo) AS saldo 
							FROM (
								SELECT 2 AS kode, 'Surplus/Defisit LO' AS uraian, SUM(a.soaw_Rp_K) AS saldo
								FROM tb_soaw a
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 7 AND a.Ko_unitstr = '".kd_unit()."' 
								GROUP BY a.Ko_unitstr
								UNION ALL
								SELECT 2 AS kode, 'Surplus/Defisit LO' AS uraian, SUM(-a.soaw_Rp_D) AS saldo
								FROM tb_soaw a
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 8 AND a.Ko_unitstr = '".kd_unit()."' 
								GROUP BY a.Ko_unitstr
								) a
								GROUP BY a.kode, a.uraian
							) b ON a.kode = b.kode
							UNION ALL
							
							SELECT a.kode, a.uraian, COALESCE(a.saldo,0) AS saldo_akhir, COALESCE(b.saldo, 0) AS saldo_awal
							FROM
							(
							SELECT a.kode, a.uraian, SUM(a.saldo) AS saldo 
							FROM (
								SELECT 3 AS kode, 'Dampak Kumulatif Perubahan Kebijakan/Kesalahan Mendasar' AS uraian, 0  AS saldo
								UNION ALL
								SELECT 3 AS kode, 'Dampak Kumulatif Perubahan Kebijakan/Kesalahan Mendasar' AS uraian, SUM(a.kredit - a.debet) AS saldo
								FROM tb_saldo a
								WHERE a.tahun = ".$tahun." AND a.kdrek1 = 3 AND a.kdrek2 = 1 AND a.kdrek3 = 1 AND a.kdrek4 = 1 AND a.kdrek5 = 2 AND a.Ko_unitstr = '".kd_unit()."' 
								AND kode = 5 AND CAST(bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
								GROUP BY a.Ko_unitstr, a.kdrek1, a.kdrek2, a.kdrek3, a.kdrek4, a.kdrek5, a.tahun
								UNION ALL
								SELECT 3 AS kode, 'Dampak Kumulatif Perubahan Kebijakan/Kesalahan Mendasar' AS uraian, -SUM(a.soaw_Rp_K) AS saldo
								FROM tb_soaw a
								WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 3 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 
								AND SUBSTRING(a.ko_rkk5,10,2) = 1  AND SUBSTRING(a.ko_rkk5,13,3) = 2 AND a.Ko_unitstr = '".kd_unit()."' 
								GROUP BY a.Ko_unitstr, a.ko_rkk5 /*menghilangkan koreksi ekuitas thn lalu*/
								) a
								GROUP BY a.kode, a.uraian
							) a LEFT JOIN
							(
							SELECT 3 AS kode, 'Dampak Kumulatif Perubahan Kebijakan/Kesalahan Mendasar' AS uraian, SUM(a.soaw_Rp_K) AS saldo
							FROM tb_soaw a
							WHERE a.Ko_Period = ".$tahun." AND LEFT(a.ko_rkk5,2) = 3 AND SUBSTRING(a.ko_rkk5,4,2) = 1 AND SUBSTRING(a.ko_rkk5,7,2) = 1 
							AND SUBSTRING(a.ko_rkk5,10,2) = 1  AND SUBSTRING(a.ko_rkk5,13,3) = 2 AND a.Ko_unitstr = '".kd_unit()."' 
							GROUP BY a.Ko_unitstr, a.ko_rkk5
							) b ON a.kode = b.kode
						) a
						GROUP BY a.kode, a.uraian");


		$data = [
			'lpe' => $lpe,
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
