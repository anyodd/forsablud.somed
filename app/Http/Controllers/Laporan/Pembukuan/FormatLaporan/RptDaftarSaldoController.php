<?php

namespace App\Http\Controllers\Laporan\Pembukuan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptDaftarSaldoController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.pembukuan.cetak-lapkeu';
    }

    public static function Laporan($tahun, $tgl_1, $tgl_2, $idlevelrekening, $kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6)
    {
		$data = null;
		$ambilbidang = 0;
		$ambilskpd = 0;
		$ambilunit = 0;
		$ambilprogram = 0;
		$ambilkegiatan = 0;

		if ($kdrek2) {
			$pecahidkdrek2 = explode('.', $kdrek2);
			$kdrek2_req = $pecahidkdrek2[1];
		} else {
			$kdrek2_req = "%";
		}
		
		if ($kdrek3) {
			$pecahidkdrek3 = explode('.', $kdrek3);
			$kdrek3_req = $pecahidkdrek3[2];
		} else {
			$kdrek3_req = "%";
		}

		if ($kdrek4) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4) = explode('.', $kdrek4);
			$kdrek4_req = $kdrek4;
		} else {
			$kdrek4_req = "%";
		}

		if ($kdrek5) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5) = explode('.', $kdrek5);
			$kdrek5_req = $kdrek5;
		} else {
			$kdrek5_req = "%";
		}

		if ($kdrek6) {
			list($kdrek1, $kdrek2, $kdrek3, $kdrek4, $kdrek5, $kdrek6) = explode('.', $kdrek6);
			$kdrek6_req = $kdrek6;
		} else {
			$kdrek6_req = "%";
		}

		
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
		
		DB::statement("CALL SP_SaldoAkhir ( ".$idlevelrekening.", ".$tahun.", '".$tgl_2."','".kd_unit()."')"); 
                
		$daftarsaldobukubesar = DB::select("SELECT
                            a.kdrekgab AS koderekening,
                            a.nmrekgab AS uraian,
                            a.saldo_normal,
                            CASE WHEN a.saldo_normal='D' THEN SUM(a.debet)-SUM(a.kredit)
                            ELSE 0 END AS debet,
                            CASE WHEN a.saldo_normal='K' THEN SUM(a.kredit)-SUM(a.debet)
                            ELSE 0 END AS kredit
                        FROM tb_saldo a
                        WHERE a.Ko_unitstr = LEFT('".kd_unit()."',18) AND a.kode = ".$idlevelrekening." AND CAST(a.bukti_tgl AS DATE) = CAST('".$tgl_2."' AS DATE)
                            AND a.kdrek1 LIKE '%".$kdrek1."' AND a.kdrek2 LIKE '%".$kdrek2_req."' AND a.kdrek3 LIKE '%".$kdrek3_req."'
							AND a.kdrek4 LIKE '%".$kdrek4_req."' AND a.kdrek5 LIKE '%".$kdrek5_req."' AND a.kdrek6 LIKE '%".$kdrek6_req."'
                        GROUP BY a.kdrekgab, a.nmrekgab,  a.saldo_normal
                        ORDER BY a.kdrekgab, a.nmrekgab");


		$data = [
			'daftarsaldobukubesar' => $daftarsaldobukubesar,
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
