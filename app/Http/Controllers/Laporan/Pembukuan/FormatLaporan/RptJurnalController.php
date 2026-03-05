<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptJurnalController extends Controller
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
		$id_bidang = bidang_id(kd_unit());
		$pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = ".$id_bidang." GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";
		
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
                
		$query = DB::select("WITH datajurnal AS (
					SELECT (@id:=@id+1) AS id, a.dt_bukti AS bukti_tgl, a.Buktijr_No AS bukti_no, c.ur_subunit AS nmsubunit,
					CONCAT(a.ko_unitstr,' . ',a.Ko_Rkk) AS rekening,
					b.Ur_Rk6 AS nmrek6, a.jrRp_D AS debet, a.jrRp_K AS kredit, a.jr_urbprc AS keterangan, a.Ko_Rkk AS koderekening
					FROM jr_trans a 
					INNER JOIN ". $pf_rk6 . " b ON LEFT(a.ko_rkk,2) = b.Ko_Rk1 AND SUBSTRING(a.ko_rkk,4,2) = b.Ko_Rk2 AND SUBSTRING(a.ko_rkk,7,2) = b.Ko_Rk3 
					AND SUBSTRING(a.Ko_Rkk,10,2) = b.Ko_Rk4 AND SUBSTRING(a.Ko_Rkk,13,3) = b.Ko_Rk5 AND RIGHT(a.Ko_Rkk,4) = b.Ko_Rk6
					INNER JOIN tb_sub c ON a.ko_unitstr = CONCAT(LPAD(c.ko_wil1,2,0),'.' ,LPAD(c.ko_wil2,2,0),'.', LPAD(c.ko_urus,2,0),'.', LPAD(c.ko_bid,2,0),'.',LPAD(c.ko_unit,2,0),'.',LPAD(c.ko_sub,3,0))
					,(SELECT @id:=0) d 
					WHERE a.ko_unitstr = LEFT('".kd_unit()."',18) AND a.Ko_Period = ".$tahun." AND a.dt_bukti BETWEEN '".$tgl_1."' AND '".$tgl_2."' 
					)
					SELECT id, nmsubunit, bukti_tgl, bukti_no, rekening, nmrek6, sum(debet) AS debet, sum(kredit) AS kredit, keterangan FROM datajurnal
					GROUP BY id, nmsubunit, bukti_tgl, bukti_no, rekening, nmrek6, keterangan
					ORDER BY bukti_tgl, bukti_no, id, rekening, nmrek6, keterangan");

		$data = [
			'rincianJurnal' => $query,
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
