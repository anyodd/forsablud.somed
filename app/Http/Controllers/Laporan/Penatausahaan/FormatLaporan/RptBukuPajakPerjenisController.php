<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuPajakPerjenisController extends Controller
{
    private $modul = 'laporan';
    private $view;

    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-pengeluaran';
    }

    public static function Laporan($tahun, $tgl_1, $tgl_2, $pajak)
    {
		$data = null;
		$ambilnamajenispotongan = null;
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
							
		$ambilnamajenispotongan = DB::SELECT(<<<SQL
                SELECT Ur_Rk6 AS namajenispotongan FROM pf_rk6
                WHERE Ko_RKK=:Ko_RKK AND Ko_Period=:tahun
                SQL, [':Ko_RKK' => $pajak, ':tahun' => $tahun ]);
							
		$pajakperjenis = DB::select("WITH buktipengeluaran
									AS
									(
										SELECT F.id_bp, H.dt_byr AS tgl_bukti, F.No_Bp AS no_bukti, F.Ur_Bp AS uraian, I.rekan_nm, 
										E.Ko_Rkk, SUM(E.tax_Rp) AS pemotongan
										FROM tb_tax E 
										INNER JOIN (
											SELECt MIN(B.id_bprc) AS id_bprc, A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr 
											FROM tb_bp A 
											INNER JOIN tb_bprc B ON A.id_bp=B.id_bp
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_unit1,18) = LEFT('".kd_unit()."',18))
											GROUP BY A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr ) F ON E.id_bp=F.id_bp 
										INNER JOIN tb_byr H ON F.id_bprc=H.id_bprc
										INNER JOIN tb_spirc A ON F.id_bprc=A.id_bprc
										INNER JOIN tb_spi B ON A.id_spi = B.id 
										LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan
										WHERE F.Ko_Bp IN (3,4,5,9,41) AND B.Ko_SPi IN (4,6,7,8)
										AND ( CAST(H.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND ( E.Ko_Rkk LIKE '".$pajak."' )
										GROUP BY F.id_bp, H.dt_byr, F.No_Bp, F.Ur_Bp, I.rekan_nm, E.Ko_Rkk
										UNION ALL
										SELECT F.id_bp, D.Dt_npd AS tgl_bukti, F.No_Bp AS no_bukti, F.Ur_Bp AS uraian, I.rekan_nm, 
										E.Ko_Rkk, SUM(E.tax_Rp) AS pemotongan
										FROM tb_tax E 
										INNER JOIN (
											SELECt MIN(B.id_bprc) AS id_bprc, A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr 
											FROM tb_bp A 
											INNER JOIN tb_bprc B ON A.id_bp=B.id_bp
											WHERE (A.Ko_Period = ".$tahun.") AND (LEFT(A.Ko_unit1,18) = LEFT('".kd_unit()."',18))
											GROUP BY A.id_bp, A.No_Bp, A.Ko_Bp, A.Ko_unit1, A.nm_BUcontr ) F ON E.id_bp=F.id_bp 
										INNER JOIN tb_spirc A ON F.id_bprc=A.id_bprc
										INNER JOIN tb_spi B ON A.id_spi = B.id 
										INNER JOIN tb_oto C ON B.id = C.id_spi
										INNER JOIN tb_npd D ON C.id = D.id_oto 
										-- INNER JOIN (SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) J ON D.id_npd = J.id_npd
										LEFT JOIN tb_rekan I ON LEFT(F.Ko_unit1,18) = I.Ko_unitstr AND F.nm_BUcontr = I.id_rekan		
										WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (2,3,9)
										AND ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (LEFT(E.Ko_unit1,18) = LEFT('".kd_unit()."',18))
										AND ( E.Ko_Rkk LIKE '".$pajak."' )
										GROUP BY F.id_bp, D.Dt_npd, F.No_Bp, F.Ur_Bp, I.rekan_nm, E.Ko_Rkk
									),
									buktipengeluaran_pot
									AS
									(
										SELECT H.id_bp, A.dt_taxtor AS tgl_setor, H.No_Bp AS no_bukti,
										A.No_Bill AS kd_billing, A.No_ntpn AS ntpn, A.dt_taxtor AS tglbuku_ntpn, A.Ko_Rkk, SUM(B.taxtor_Rp) AS penyetoran
										FROM tb_taxtor A 
										INNER JOIN tb_taxtorc B ON A.id_taxtor = B.id_taxtor
										INNER JOIN tb_tax E ON B.id_tax = E.id_tax
										INNER JOIN tb_bp H ON E.Ko_Period = H.Ko_Period AND E.Ko_unit1 = H.Ko_unit1 AND E.No_bp = H.No_bp
										LEFT JOIN tb_rekan I ON LEFT(H.Ko_unit1,18) = I.Ko_unitstr AND H.nm_BUcontr = I.id_rekan	
										WHERE H.Ko_Bp IN (3,4,5,9,41)
										AND ( CAST(A.dt_taxtor AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
										AND ( A.Ko_Rkk LIKE '".$pajak."' )
										GROUP BY H.id_bp, A.dt_taxtor, H.No_Bp, A.Ko_Rkk
									)
									SELECT a.tgl_bukti AS tgl, a.no_bukti, a.uraian, a.rekan_nm, b.tgl_setor, b.kd_billing, b.ntpn, b.tglbuku_ntpn, a.pemotongan, b.penyetoran
									FROM  buktipengeluaran a RIGHT OUTER JOIN buktipengeluaran_pot b ON a.id_bp=b.id_bp AND a.Ko_Rkk=b.Ko_Rkk
								    ORDER BY a.tgl_bukti, a.no_bukti, a.uraian");
		$data = [
			'pajakperjenis' => $pajakperjenis,
			'ambilnamajenispotongan' => $ambilnamajenispotongan,
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
