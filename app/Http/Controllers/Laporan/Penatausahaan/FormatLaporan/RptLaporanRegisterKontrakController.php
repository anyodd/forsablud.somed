<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptLaporanRegisterKontrakController extends Controller
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
                
		$registerKontrak = DB::select("SELECT A.Ko_Period AS tahun, A.Ko_unit1, LEFT(A.Ko_unit1,18) AS Ko_unitstr, 
							A.No_contr AS kontrak_no, A.dt_contr AS kontrak_tgl, 
							A.Ur_contr, A.nm_BU, C.rekan_nm AS penerima_nm, A.adr_BU AS penerima_alamat,
							B.Ko_sKeg1 AS kdkegiatan, B.Ko_sKeg2 AS kdsubkegiatan, D.Ur_KegBL2 AS nmsubkegiatan, B.Ko_Rkk, E.Ur_Rk6,
							SUM(B.To_Rp) AS nilai
							FROM tb_contr A 
							LEFT JOIN tb_contrc B ON A.Ko_Period = B.Ko_Period AND A.Ko_unit1 = B.Ko_unit1 AND A.No_contr = B.No_contr
							LEFT JOIN tb_rekan C ON A.nm_BU =C.id_rekan
							LEFT JOIN tb_kegs2 D ON B.Ko_Period = D.Ko_Period AND B.Ko_unit1 = D.Ko_unit1 AND B.Ko_sKeg1 = D.Ko_sKeg1 AND B.Ko_sKeg2 = D.Ko_sKeg2
							LEFT JOIN pf_rk6 E ON B.Ko_Rkk = E.Ko_RKK
							WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_unit1,18) = LEFT('".kd_unit()."',18))
							AND (CAST(A.dt_contr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE))
							GROUP BY A.Ko_Period, A.Ko_unit1, A.No_contr, A.dt_contr, A.Ur_contr, 
							A.nm_BU, C.rekan_nm, A.adr_BU, B.Ko_sKeg1, B.Ko_sKeg2, D.Ur_KegBL2, B.Ko_Rkk, E.Ur_Rk6
							ORDER BY A.dt_contr, A.Ko_Period, A.Ko_unit1, A.No_contr");


		$data = [
			'registerKontrak' => $registerKontrak,
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
