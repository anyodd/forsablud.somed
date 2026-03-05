<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptStsController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-penerimaan';
    }

    public static function Laporan()
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
                
		// $model = TrnPendSts::getData($this->tahun, $this->idsubunit, $this->no_laporan)->firstOrFail();
		// $modelRinc = collect(DB::select(<<<SQL
        //             SELECT tpsr.tahun
        //                 ,tpsr.idsubunit
        //                 ,tpsr.no_sts
        //                 ,tpbr.kdrek1
        //                 ,tpbr.kdrek2
        //                 ,tpbr.kdrek3
        //                 ,tpbr.kdrek4
        //                 ,tpbr.kdrek5
        //                 ,tpbr.kdrek6
        //                 ,SUM(tpbr.nilai) AS nilai
        //                 ,CONCAT(tpbr.kdrek1, '.', tpbr.kdrek2, '.', tpbr.kdrek3, '.', RIGHT(CONCAT('00', tpbr.kdrek4), 2), '.', RIGHT(CONCAT('00', tpbr.kdrek5), 2), '.', RIGHT(CONCAT('0000', tpbr.kdrek6), 4)) AS entity_code
        //                 ,rek6.nmrek6 AS nama_rekening
        //             FROM trn_pend_sts tps
        //             RIGHT JOIN trn_pend_sts_rinc tpsr
        //                 ON tps.tahun = tpsr.tahun
        //                 AND tps.idsubunit = tpsr.idsubunit
        //                 AND tps.no_sts = tpsr.no_sts
        //             LEFT JOIN trn_pend_bp_rinc tpbr
        //                 ON tpsr.tahun = tpbr.tahun
        //                 AND tpsr.idsubunit = tpbr.idsubunit
        //                 AND tpsr.no_bp = tpbr.no_bp
        //             LEFT JOIN src_rek6 rek6
        //                 ON tpbr.tahun = rek6.tahun
        //                 AND tpbr.kdrek1 = rek6.kdrek1
        //                 AND tpbr.kdrek2 = rek6.kdrek2
        //                 AND tpbr.kdrek3 = rek6.kdrek3
        //                 AND tpbr.kdrek4 = rek6.kdrek4
        //                 AND tpbr.kdrek5 = rek6.kdrek5
        //                 AND tpbr.kdrek6 = rek6.kdrek6
        //             WHERE tps.tahun = :tahun
        //                 AND tps.idsubunit = :idsubunit
        //                 AND tps.no_sts = :no_sts
        //             GROUP BY tpsr.tahun
        //                 ,tpsr.idsubunit
        //                 ,tpsr.no_sts
        //                 ,tpbr.kdrek1
        //                 ,tpbr.kdrek2
        //                 ,tpbr.kdrek3
        //                 ,tpbr.kdrek4
        //                 ,tpbr.kdrek5
        //                 ,tpbr.kdrek6
        //                 ,rek6.nmrek6
        //         SQL, [
        //             ':tahun' => $this->tahun,
        //             ':idsubunit' => $this->idsubunit,
        //             ':no_sts' => $this->no_laporan,
        //         ]));


		$data = [
			'model' => $model,
            'modelRinc' => $modelRinc,
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
