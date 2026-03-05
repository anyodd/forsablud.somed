<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptDaftarPembayaranUtangAwalController extends Controller
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
                
		 $daftarpiutang = DB::select("SELECT A.kode, A.ko_unitstr, A.tahun, A.tgl_bukti, B.tgl_terima, C.tgl_setor, A.no_bukti, B.no_bp, C.no_sts, A.Ur_bprc AS uraian,
									A.kdrek1, A.kdrek2, A.kdrek3, A.kdrek4, A.kdrek5, A.kdrek6, A.ko_rkk, D.Ur_Rk6, A.Tetapkan, B.Terima, C.Setor
									FROM (
										SELECT B.id_bp AS Kode, B.Ko_unitstr, A.Ko_Period AS tahun, B.dt_bp AS tgl_bukti, B.No_bp AS No_Bukti, B.No_bp, LEFT(A.Ko_Rkk,2) AS kdrek1, 
										SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
										SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk, A.Ur_bprc, 
										SUM(A.To_rp) AS Tetapkan
										FROM tb_bprc A INNER JOIN 
										tb_bp B ON A.id_bp = B.id_bp 
										WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(B.dt_bp AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
										AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
										AND ( B.Ko_bp IN (11) )
										GROUP BY A.Ko_Period, B.Ko_unitstr, B.dt_bp, A.Ko_Rkk, B.No_bp, B.id_bp, A.Ur_bprc
									) A LEFT JOIN 
									(
										SELECT B.id_bp AS Kode, B.Ko_unitstr, A.Ko_Period AS tahun, D.dt_byr AS tgl_terima, D.No_byr AS No_Bukti, B.No_bp, LEFT(A.Ko_Rkk,2) AS kdrek1, 
										SUBSTRING(A.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(A.Ko_Rkk,7,2) AS kdrek3, 
										SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, RIGHT(A.Ko_Rkk,4) AS kdrek6, A.Ko_Rkk,
										SUM(D.real_rp) AS Terima
										FROM tb_bprc A INNER JOIN 
										tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
										tb_bp B ON A.id_bp = B.id_bp 
										WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
										AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
										AND ( B.Ko_bp IN (11) )
										GROUP BY A.Ko_Period, B.Ko_unitstr, D.dt_byr, D.No_byr, A.Ko_Rkk, B.No_bp, B.id_bp
									) B ON A.Kode=B.Kode AND A.kdrek1=B.kdrek1 AND A.kdrek2=B.kdrek2 AND A.kdrek3=B.kdrek3 AND 
									A.kdrek4=B.kdrek4 AND A.kdrek5=B.kdrek5 AND A.kdrek6=B.kdrek6 LEFT JOIN 
									(
										SELECT B.Id_bp AS Kode, A.Ko_unitstr, B.tahun, A.dt_sts AS tgl_setor,  A.No_sts, B.No_bp, LEFT(B.Ko_Rkk,2) AS kdrek1, 
										SUBSTRING(B.Ko_Rkk,4,2) AS kdrek2, SUBSTRING(B.Ko_Rkk,7,2) AS kdrek3, 
										SUBSTRING(B.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(B.Ko_Rkk,13,3) AS kdrek5, RIGHT(B.Ko_Rkk,4) AS kdrek6, B.Ko_Rkk, 
										SUM(B.real_rp) AS Setor
										FROM  (
										SELECT B.Ko_Period AS tahun, B.Ko_unitstr, A.No_byr, B.dt_sts, B.No_sts
										FROM tb_sts B 
										INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
										WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
										AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
										GROUP BY B.Ko_Period, B.Ko_unitstr, A.No_byr, B.dt_sts, B.No_sts
										) A LEFT JOIN (
										SELECT B.Ko_Period AS tahun, A.Ko_Rkk, B.Ko_unitstr, B.No_byr, AA.No_bp, AA.Id_bp, SUM(B.real_rp) AS real_rp
										FROM tb_byr B 
										INNER JOIN tb_bprc A ON 	B.id_bprc = A.id_bprc
										INNER JOIN tb_bp AA ON 	A.id_bp = AA.id_bp
										WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE)) 
										AND (B.Ko_unitstr = LEFT('".kd_unit()."',18))	
										AND ( AA.Ko_bp IN (11) )
										GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk, AA.No_bp, AA.Id_bp
										) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
										GROUP BY B.tahun, B.Ko_Rkk, A.dt_sts, A.No_sts, B.No_bp, B.Id_bp
									) C ON A.Kode=C.Kode AND A.kdrek1=C.kdrek1 AND A.kdrek2=C.kdrek2 AND A.kdrek3=C.kdrek3 AND 
									A.kdrek4=C.kdrek4 AND A.kdrek5=C.kdrek5 AND A.kdrek6=C.kdrek6 LEFT JOIN 
									pf_rk6 D ON A.Ko_Rkk = D.Ko_RKK");


		$data = [
			'daftarpiutang' => $daftarpiutang,
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
