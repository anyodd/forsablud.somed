<?php

namespace App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RptBukuKasPengeluaranController extends Controller
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
                
		$rincianBku = DB::select("WITH rincian_bukti AS
                    (
                        -- LS Penerimaan Total
                        SELECT 1 AS kode,  0 AS kode_2, D.Dt_npd AS tgl_bukti, D.No_npd AS no_bukti, D.Ur_npd AS uraian,
                        0 AS kdrek1, 0 AS kdrek2, 0 AS kdrek3, 0 AS kdrek4, 0 AS kdrek5, 0 AS kdrek6, SUM(A.spirc_Rp) AS debet, 0 AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
						WHERE ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (2,3,9)
						GROUP BY D.No_npd, D.Dt_npd, D.Ur_npd
                        UNION ALL
                        -- LS Pengeluaran Rinci
                        SELECT 2 AS kode, 0 AS kode_2, D.Dt_npd AS tgl_bukti, A.No_bp AS no_bukti, A.Ur_bprc AS uraian,
						LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(A.Ko_Rkk,4) AS kdrek6, 0 AS debet, SUM(A.spirc_Rp) AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
						WHERE ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (2,3,9)
						GROUP BY  A.No_bp, D.Dt_npd, A.Ur_bprc, A.ko_rkk,D.Dt_npd
                        UNION ALL
                        -- up/gu penerimaan
                        SELECT 3 AS kode, 0 AS kode_2, D.Dt_npd AS tgl_bukti, D.No_npd AS no_bukti, D.Ur_npd AS uraian,
                        0 AS kdrek1, 0 AS kdrek2, 0 AS kdrek3, 0 AS kdrek4, 0 AS kdrek5, 0 AS kdrek6, SUM(A.spirc_Rp) AS debet, 0 AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
						WHERE ( CAST(D.Dt_npd AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (1, 4)
						GROUP BY D.No_npd, D.Dt_npd, D.Ur_npd
                        UNION ALL
                        -- gu Pengeluaran
                        SELECT 4 AS kode, 0 AS kode_2, G.dt_byr AS tgl_bukti, A.No_bp AS no_bukti, A.Ur_bprc AS uraian,
						LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(A.Ko_Rkk,4) AS kdrek6, 0 AS debet, SUM(A.spirc_Rp) AS kredit
                        FROM tb_spirc A INNER JOIN
						tb_spi B ON A.id_spi = B.id INNER JOIN
						tb_oto C ON B.id = C.id_spi INNER JOIN
						tb_npd D ON C.id = D.id_oto INNER JOIN
						(SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd INNER JOIN
						tb_bprc F ON A.id_bprc=F.id_bprc INNER JOIN
						tb_byr G ON F.id_bprc=G.id_bprc
						WHERE ( CAST(G.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (A.Ko_Period = ".$tahun.") AND (A.Ko_unitstr = LEFT('".kd_unit()."',18))
						AND B.Ko_SPi IN (4, 6, 8)
						GROUP BY  A.No_bp, G.dt_byr, A.Ur_bprc, A.ko_rkk, G.dt_byr
                        UNION ALL
                        -- bukti potongan penerimaan GU			
						SELECT 5 AS kode, 1 AS kode_2, H.dt_byr AS tgl_bukti, F.No_Bp AS no_bukti, CONCAT('POTONG PAJAK :: ',I.rekan_nm) AS uraian,
						LEFT(E.ko_rkk,2) AS kdrek1, SUBSTRING(E.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(E.ko_rkk,7,2) AS kdrek3, SUBSTRING(E.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(E.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(E.Ko_Rkk,4) AS kdrek6, SUM(E.tax_Rp) AS debet, 0 AS kredit
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
						WHERE F.Ko_Bp IN (3, 4, 5, 9, 41) AND B.Ko_SPi IN (4,6,7,8)
						AND ( CAST(H.dt_byr AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
						GROUP BY H.dt_byr, F.No_Bp, I.rekan_nm, E.Ko_Rkk
						UNION ALL
                        -- bukti potongan penerimaan LS			
						SELECT 5 AS kode, 1 AS kode_2, D.Dt_npd AS tgl_bukti, F.No_Bp AS no_bukti, CONCAT('POTONG PAJAK :: ',I.rekan_nm) AS uraian,
						LEFT(E.ko_rkk,2) AS kdrek1, SUBSTRING(E.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(E.ko_rkk,7,2) AS kdrek3, SUBSTRING(E.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(E.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(E.Ko_Rkk,4) AS kdrek6, SUM(E.tax_Rp) AS debet, 0 AS kredit
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
						GROUP BY D.Dt_npd, F.No_Bp, I.rekan_nm, E.Ko_Rkk						
                        UNION ALL
                        -- bukti potongan pengeluaran
						SELECT 6 AS kode, 2 AS kode_2, A.dt_taxtor AS tgl_bukti, H.No_Bp AS no_bukti, CONCAT('SETORAN PAJAK :: ',I.rekan_nm) AS uraian,
						LEFT(A.ko_rkk,2) AS kdrek1, SUBSTRING(A.ko_rkk,4,2) AS kdrek2, 
						SUBSTRING(A.ko_rkk,7,2) AS kdrek3, SUBSTRING(A.Ko_Rkk,10,2) AS kdrek4, SUBSTRING(A.Ko_Rkk,13,3) AS kdrek5, 
						RIGHT(A.Ko_Rkk,4) AS kdrek6, 0 AS debet, SUM(B.taxtor_Rp) AS kredit
						FROM tb_taxtor A 
						INNER JOIN tb_taxtorc B ON A.id_taxtor = B.id_taxtor
						INNER JOIN tb_tax E ON B.id_tax = E.id_tax
						INNER JOIN tb_bp H ON E.Ko_Period = H.Ko_Period AND E.Ko_unit1 = H.Ko_unit1 AND E.No_bp = H.No_bp
						LEFT JOIN tb_rekan I ON LEFT(H.Ko_unit1,18) = I.Ko_unitstr AND H.nm_BUcontr = I.id_rekan	
						WHERE H.Ko_Bp IN (3, 4, 5, 9, 41)
						AND ( CAST(A.dt_taxtor AS DATE) <= CAST('".$tgl_2."' AS DATE) ) AND (H.Ko_Period = ".$tahun.") AND (H.Ko_unitstr = LEFT('".kd_unit()."',18))
						GROUP BY A.dt_taxtor, H.No_Bp, I.rekan_nm, A.Ko_Rkk
						UNION ALL
                        -- penyetoran sisa up pengeluaran
                        /*
						SELECT
                            10 AS kode, a.setoransisa_tgl AS tgl_bukti, a.setoransisa_no AS no_bukti, a.uraian,
                            0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6, 0 AS debet, a.nilai AS kredit
                        FROM trn_setoransisa a
                            INNER JOIN ref_subunit k ON a.idsubunit = k.idsubunit
                            INNER JOIN ref_unit l ON k.idunit = l.idunit
                            INNER JOIN ref_skpd m ON l.idskpd = m.idskpd
                        WHERE a.tahun = :tahun5 AND a.idsubunit LIKE :idsubunit5 AND a.setoransisa_tgl BETWEEN :tgl_15 AND :tgl_25
                            AND l.idunit LIKE :idunit5 AND m.idskpd LIKE :idskpd5
                        UNION ALL
						*/
						-- jurnal GU
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						CASE a.Ko_DK WHEN 'D' THEN SUM(a.Rp_D) ELSE 0 END AS debet, 0 AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.03.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='D')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.03.001.0001') AND (a.Ko_DK='D')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur, a.Ko_DK
						UNION ALL
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						0 AS debet, CASE a.Ko_DK WHEN 'K' THEN SUM(a.Rp_K) ELSE 0 END AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.03.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='K')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.03.001.0001') AND (a.Ko_DK='K')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur, a.Ko_DK
                        UNION ALL
						-- jurnal LS
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						CASE a.Ko_DK WHEN 'D' THEN SUM(a.Rp_D) ELSE 0 END AS debet, 0 AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.04.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='D')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.04.001.0001') AND (a.Ko_DK='D')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur, a.Ko_DK
						UNION ALL
						SELECT 7 AS kode, 0 AS kode_2, b.dt_sesuai AS tgl_bukti, b.Sesuai_No AS no_bukti, b.Sesuai_Ur AS Uraian,
						0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						0 AS debet, CASE a.Ko_DK WHEN 'K' THEN SUM(a.Rp_K) ELSE 0 END AS kredit
						FROM jr_sesuai a  INNER JOIN 
						(
						SELECT a.id_tbses, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur
						FROM jr_sesuai a INNER JOIN 
						tb_sesuai b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (a.Ko_Rkk = '01.01.01.04.001.0001') AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND (a.Ko_DK='K')
						) b ON a.id_tbses=b.id_tbses
						WHERE (a.Ko_Period = ".$tahun.") AND (NOT ((a.Ko_Rkk = '01.01.01.04.001.0001') AND (a.Ko_DK='K')) ) AND CAST(a.dt_sesuai AS DATE) <= CAST('".$tgl_2."' AS DATE) 
						AND (a.Ko_unitstr = LEFT('".kd_unit()."',18)) AND ( (LEFT(a.Ko_Rkk,2) = '05'))
						GROUP BY a.Ko_unitstr, a.Ko_Rkk, b.dt_sesuai, b.Sesuai_No, b.Sesuai_Ur, a.Ko_DK
                        UNION ALL
                        -- saldo awal					
						SELECT 0 AS kode, 0 AS kode_2, '".$tahun. "-01-01'  AS tgl_bukti, '' AS no_bukti, 'Saldo Awal'  AS uraian,
                        0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6,
						CASE e.SN_rk3 WHEN 'D' THEN w.soaw_Rp ELSE 0 END AS Debet, CASE e.SN_rk3 WHEN 'K' THEN  w.soaw_Rp ELSE 0 END AS Kredit
						FROM tb_soaw w LEFT JOIN
						pf_rk6 b ON LEFT(w.ko_rkk5,2) = b.Ko_Rk1 AND SUBSTRING(w.ko_rkk5,4,2) = b.Ko_Rk2 AND SUBSTRING(w.ko_rkk5,7,2) = b.Ko_Rk3 
						AND SUBSTRING(w.ko_rkk5,10,2) = b.Ko_Rk4 AND SUBSTRING(w.ko_rkk5,13,3) = b.Ko_Rk5 AND 1 = b.Ko_Rk6 INNER JOIN
						pf_rk5 c ON b.Ko_Rk1 = c.Ko_Rk1 AND b.Ko_Rk2 = c.Ko_Rk2 AND b.Ko_Rk3 = c.Ko_Rk3 AND b.Ko_Rk4 = c.Ko_Rk4 AND b.Ko_Rk5 = c.Ko_Rk5 INNER JOIN
						pf_rk4 d ON c.Ko_Rk1 = d.Ko_Rk1 AND c.Ko_Rk2 = d.Ko_Rk2 AND c.Ko_Rk3 = d.Ko_Rk3 AND c.Ko_Rk4 = d.Ko_Rk4 INNER JOIN
						pf_rk3 e ON d.Ko_Rk1 = e.Ko_Rk1 AND d.Ko_Rk2 = e.Ko_Rk2 AND d.Ko_Rk3 = e.Ko_Rk3
						WHERE (w.Ko_Period = ".$tahun.") AND (w.ko_rkk5 = '01.01.01.03.001')	
						AND (w.Ko_unitstr = LEFT('".kd_unit()."',18))	
                    )
                    SELECT
					a.*
					FROM
					(
						SELECT 0 AS kode, 0 AS kode_2, (CAST('".$tgl_1."' AS DATE) - INTERVAL 1 DAY ) AS tgl_bukti, '' AS no_bukti, 'Saldo Awal' AS uraian,
                        0  AS kdrek1, 0  AS kdrek2, 0  AS kdrek3, 0  AS kdrek4, 0  AS kdrek5, 0  AS kdrek6, SUM(COALESCE(a.debet,0)) AS debet, SUM(COALESCE(a.kredit,0)) AS kredit
						FROM rincian_bukti a
						WHERE a.kode = 0 OR ( CAST(a.tgl_bukti AS DATE) < CAST('".$tgl_1."' AS DATE) )
						UNION ALL
						SELECT a.*
						FROM rincian_bukti a
						WHERE a.kode != 0 AND ( CAST(a.tgl_bukti AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE))
					) a
                    ORDER BY a.tgl_bukti ASC, a.kode ASC, a.no_bukti ASC, a.kode_2 ASC, a.debet DESC, a.kdrek1 ASC, a.kdrek2 ASC, a.kdrek3 ASC, a.kdrek4 ASC, a.kdrek5 ASC, a.kdrek6 ASC");

		$data = [
			'rincianBku' => $rincianBku,
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
