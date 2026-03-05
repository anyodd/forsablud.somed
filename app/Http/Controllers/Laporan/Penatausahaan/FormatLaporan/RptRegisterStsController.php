<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptRegisterStsController extends Controller
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
                
		 $registersts = DB::select("SELECT B.tahun, A.Ko_unitstr, A.dt_sts AS tgl_sts, A.No_sts AS no_sts, A.Ur_sts AS uraian, SUM(B.real_rp) AS nilai
							FROM  (
							SELECT B.Ko_Period AS tahun, B.Ko_unitstr, B.dt_sts, B.No_sts, B.Ur_sts, A.No_byr
							FROM tb_sts B 
							INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
							WHERE  (A.Ko_Period = ".$tahun.")  
							AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
							AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
							GROUP BY B.dt_sts, B.No_sts, B.Ur_sts, B.Ko_Period, B.Ko_unitstr, A.No_byr
							) A INNER JOIN (
							SELECT B.Ko_Period AS tahun, A.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
							FROM tb_byr B 
							INNER JOIN tb_bprc A ON B.id_bprc = A.id_bprc
							WHERE  (A.Ko_Period = ".$tahun.")  
							AND ( CAST(B.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE)) 
							AND (B.Ko_unitstr = LEFT('".kd_unit()."',18))	
							GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk
							) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
							GROUP BY A.Ko_unitstr, A.dt_sts, A.No_sts, A.Ur_sts, B.tahun
							ORDER BY A.dt_sts ASC");


		$data = [
			'registersts' => $registersts,
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
