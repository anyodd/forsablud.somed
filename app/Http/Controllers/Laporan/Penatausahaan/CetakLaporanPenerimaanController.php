<?php

namespace App\Http\Controllers\Laporan\Penatausahaan;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tbpjb;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptTbpController as RptTbp;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptStsController as RptSts;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPenerimaanController as RptBukuPenerimaan;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPenerimaanRinciController as RptBukuPenerimaanRinci;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptSpjPendapatanController as RptSpjPendapatan;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuKasPenerimaanController as RptBkuPenerimaan;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRegisterTbpController as RptRegisterTbp;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRegisterStsController as RptRegisterSts;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPenerimaanHarianController as RptBukuPenerimaanHarian;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptDaftarPembayaranPiutangController as RptDaftarPembayaranPiutang;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptDaftarPembayaranPiutangAwalController as RptDaftarPembayaranPiutangAwal;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptPertanggungjawabanController as RptPertanggungjawaban;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuKasPenerimaanTunaiController as RptBukuKasPenerimaanTunai;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuKasPenerimaanBankController as RptBukuKasPenerimaanBank;

class CetakLaporanPenerimaanController extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-penerimaan';
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        $jenis_laporan_req = $request->jenis_laporan;
		$tgl_1 =  $request->tgl_1;
		$tgl_2 = $request->tgl_2;
		$bulan = $request->bulan;
		$jn_spj = $request->jn_spj;
				
		// if($request->idsumberdana == -1 || $request->idsumberdana == null){
		// $idsumberdana = -1;
        // }else{
		// $idsumberdana=$request->idsumberdana;
        // }
		
		$idlevelrekening=$request->idlevelrekening;
        $kdrek1 = $request->idkdrek1; 
		$kdrek2 = $request->idkdrek2; 
		$kdrek3 = $request->idkdrek3; 
		$kdrek4 = $request->idkdrek4; 
		$kdrek5 = $request->idkdrek5; 
		$kdrek6 = $request->idkdrek6;
		
        $ibukota 			= $request->ibukota;
        $tgl_laporan 		= $request->tgl_laporan;
		$penandatanganPimpinan = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 1
		])->first();
        $penandatanganBendahara = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 7
		])->first();
		$penandatanganBendaharaPembantu = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 8
		])->first();

        switch ($jenis_laporan_req) {
            case 1;
                $model = RptTbp::Laporan($tahun);
                $view = $this->view . '.cetaklaporan1';
                break;
            case 2;
                $model = RptSts::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan2';
                break;
            case 3;
                $model = RptBukuPenerimaan::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan3';
                break;
            case 4;
                $model = RptBukuPenerimaanRinci::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan4';
                break;
            case 5;
			   if ($bulan == null) {die("Harus Di Pilih Bulan SPJ..!!");}
                $model = RptSpjPendapatan::Laporan($tahun, $bulan, $jn_spj);
                $view = $this->view . '.cetaklaporan5';
                break;
            case 6;
                $model = RptBkuPenerimaan::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan6';
                break;
			case 7;
                $model = RptRegisterTbp::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan7';
                break;
			case 8;
                $model = RptRegisterSts::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan8';
                break;
			case 9;
                $model = RptBukuPenerimaanHarian::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan9';
                break;
			case 10;
                $model = RptDaftarPembayaranPiutang::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan10';
                break;
			case 11;
                $model = RptDaftarPembayaranPiutangAwal::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan11';
                break;
			case 12;
				if ($bulan == null) {die("Harus Di Pilih Bulan SPJ..!!");}
                $model = RptPertanggungjawaban::Laporan($tahun, $bulan, $jn_spj);
                $view = $this->view . '.cetaklaporan12';
                break;
			case 13;
                $model = RptBukuKasPenerimaanTunai::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan13';
                break;
			case 14;
                $model = RptBukuKasPenerimaanBank::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan14';
                break;
        }
	
		return view($view, [
            'model' => $model,
			'tgl_1' =>  $tgl_1,
			'tgl_2' =>  $tgl_2,
			'bulan' =>  $bulan,
			'jn_spj' => $jn_spj,
			'ibukota' => $ibukota,
			'tgl_laporan' => $tgl_laporan,
			'penandatanganPimpinan' => $penandatanganPimpinan,
			'penandatanganBendahara' => $penandatanganBendahara,
			// 'penandatanganBendaharaPembantu' => $penandatanganBendaharaPembantu,
			// 'idsumberdana' =>  $idsumberdana,
        ]);
		
    }

    public function laporan(Request $request)
    {
        $tahun = Tahun();
        $idsubunit_req = kd_unit();
		
        $jns = [
			['id' => 0, 'uraian' => 'Pilih Jenis Laporan'],
            // ['id' => 1, 'uraian' => 'Tanda Bukti Penerimaan'],
            // ['id' => 2, 'uraian' => 'STS'],
            ['id' => 3, 'uraian' => 'Buku Rekapitulasi Penerimaan'],
            ['id' => 4, 'uraian' => 'Buku Pembantu Per Rincian Penerimaan'],
            ['id' => 5, 'uraian' => 'SPJ Pendapatan'],
			['id' => 12, 'uraian' => 'Laporan Pertanggungjawaban'],
            ['id' => 6, 'uraian' => 'Buku Kas Penerimaan'],
			['id' => 13, 'uraian' => 'Buku Pembantu Kas Tunai'],
			['id' => 14, 'uraian' => 'Buku Pembantu Kas Bank'],
			['id' => 7, 'uraian' => 'Register Tanda Bukti Penerimaan'],
			['id' => 8, 'uraian' => 'Register STS'],
			['id' => 9, 'uraian' => 'Buku Pendapatan Harian'],
			['id' => 10, 'uraian' => 'Daftar Pembayaran Piutang'],
			['id' => 11, 'uraian' => 'Daftar Pembayaran Piutang Tahun Lalu'],
        ];
        $jnslap = collect($jns)->pluck('uraian', 'id')->all();
		
		$rek1 = [
            ['id' => 1, 'uraian' => '1 ASET'],
            ['id' => 2, 'uraian' => '2 KEWAJIBAN'],
            ['id' => 3, 'uraian' => '3 EKUITAS'],
            ['id' => 4, 'uraian' => '4 PENDAPATAN DAERAH'],
            ['id' => 5, 'uraian' => '5 BELANJA DAERAH'],
            ['id' => 6, 'uraian' => '6 PEMBIAYAAN DAERAH'],
			['id' => 7, 'uraian' => '7 PENDAPATAN DAERAH-LO'],
			['id' => 8, 'uraian' => '8 BEBAN DAERAH'],
        ];
        $getRek1 = collect($rek1)->pluck('uraian', 'id')->all();
		
		$RefSD = [
            ['id' => 1, 'uraian' => '1 Jasa Layanan'],
            ['id' => 2, 'uraian' => '2 Hibah'],
            ['id' => 3, 'uraian' => '3 Hasil Kerjasama'],
			['id' => 4, 'uraian' => '4 APBD'],
			['id' => 5, 'uraian' => '5 Lain Pendapatan BLUD'],
			['id' => 6, 'uraian' => '6 SILPA'],
        ];
        $getRefSumberDana = collect($RefSD)->pluck('uraian', 'id')->all();
		
		$bulan = [
			[ 'id' => 1, 'uraian' => 'Januari'],
			[ 'id' => 2, 'uraian' => 'Februari'],
			[ 'id' => 3, 'uraian' => 'Maret'],
			[ 'id' => 4, 'uraian' => 'April'],
			[ 'id' => 5, 'uraian' => 'Mei'],
			[ 'id' => 6, 'uraian' => 'Juni'],
			[ 'id' => 7, 'uraian' => 'Juli'],
			[ 'id' => 8, 'uraian' => 'Agustus'],
			[ 'id' => 9, 'uraian' => 'September'],
			[ 'id' => 10, 'uraian' => 'Oktober'],
			[ 'id' => 11, 'uraian' => 'November'],
			[ 'id' => 12, 'uraian' => 'Desember'],
		];

        $getBulan = collect($bulan)->pluck('uraian', 'id')->all();
		
		$ibukota = nm_ibukota();

        return view($this->view . '.index', [
            'tahun' => $tahun,
            'jnslap' => $jnslap,
			'getRek1' => $getRek1,
			'getBulan' => $getBulan,
			'getRefSumberDana' => $getRefSumberDana,
			'ibukota' => $ibukota,
            'prefix' => $this->modul,
        ]);
    }


	 public function selectRek2(Request $request, $id = null)
    {
        $data = DB::select("SELECT CONCAT (ko_Rk2,' ',Ur_Rk2) AS uraianrek2, CONCAT (ko_Rk1,'.',ko_Rk2) AS idkdrek2 FROM pf_rk2
        WHERE ko_Rk1 = :kdrek1
        ORDER BY ko_Rk2 ASC", [':kdrek1' => $id]);
        $refrek2 = collect($data)->pluck('uraianrek2', 'idkdrek2')->all();
        return response()->json(['refrek2' => $refrek2], 200);
    }

    public function selectRek3(Request $request, $id = null)
    {
        $pecahidkdrek2 = explode('.', $id);
        if (count($pecahidkdrek2) == 2) {
            $data = DB::select("SELECT CONCAT (ko_Rk3,' ',Ur_Rk3) AS uraianrek3, CONCAT (ko_Rk1,'.',ko_Rk2,'.',ko_Rk3) AS idkdrek3 FROM pf_rk3
            WHERE ko_Rk1 = :kdrek1 AND ko_Rk2 = :kdrek2
            ORDER BY ko_Rk3 ASC", [':kdrek1' => $pecahidkdrek2[0], ':kdrek2' => $pecahidkdrek2[1]]);
            $refrek3 = collect($data)->pluck('uraianrek3', 'idkdrek3')->all();
            return response()->json(['refrek3' => $refrek3], 200);
        }
        if (count($pecahidkdrek2) == 3) {
            $data = DB::select("SELECT CONCAT (ko_Rk4,' ',Ur_Rk4) AS uraianrek4, CONCAT (ko_Rk1,'.',ko_Rk2,'.',ko_Rk3,'.',ko_Rk4) AS idkdrek4 FROM pf_rk4
            WHERE ko_Rk1 = :kdrek1 AND ko_Rk2 = :kdrek2 AND ko_Rk3 = :kdrek3
            ORDER BY ko_Rk4 ASC", [':kdrek1' => $pecahidkdrek2[0], ':kdrek2' => $pecahidkdrek2[1], ':kdrek3' => $pecahidkdrek2[2]]);
            $refrek3 = collect($data)->pluck('uraianrek4', 'idkdrek4')->all();
            return response()->json(['refrek4' => $refrek3], 200);
        }
        if (count($pecahidkdrek2) == 4) {
            $pecahidkdrek2 = explode('.', $id);
            $data = DB::select("SELECT CONCAT (ko_Rk5,' ',Ur_Rk5) AS uraianrek5, CONCAT (ko_Rk1,'.',ko_Rk2,'.',ko_Rk3,'.',ko_Rk4,'.',ko_Rk5) AS idkdrek5 FROM pf_rk5
            WHERE ko_Rk1 = :kdrek1 AND ko_Rk2 = :kdrek2 AND ko_Rk3 = :kdrek3 AND ko_Rk4 = :kdrek4
            ORDER BY ko_Rk5 ASC", [':kdrek1' => $pecahidkdrek2[0], ':kdrek2' => $pecahidkdrek2[1], ':kdrek3' => $pecahidkdrek2[2], ':kdrek4' => $pecahidkdrek2[3]]);
            $refrek3 = collect($data)->pluck('uraianrek5', 'idkdrek5')->all();
            return response()->json(['refrek5' => $refrek3], 200);
        }
        if (count($pecahidkdrek2) == 5) {
            $pecahidkdrek2 = explode('.', $id);
            $data = DB::select("SELECT CONCAT (ko_Rk6,' ',Ur_Rk6) AS uraianrek6, CONCAT (ko_Rk1,'.',ko_Rk2,'.',ko_Rk3,'.',ko_Rk4,'.',ko_Rk5,'.',ko_Rk6) AS idkdrek6 FROM pf_rk6
            WHERE ko_Rk1 = :kdrek1 AND ko_Rk2 = :kdrek2 AND ko_Rk3 = :kdrek3 AND ko_Rk4 = :kdrek4 AND ko_Rk5 = :kdrek5
            ORDER BY ko_Rk6 ASC", [':kdrek1' => $pecahidkdrek2[0], ':kdrek2' => $pecahidkdrek2[1], ':kdrek3' => $pecahidkdrek2[2], ':kdrek4' => $pecahidkdrek2[3], ':kdrek5' => $pecahidkdrek2[4]]);
            $refrek3 = collect($data)->pluck('uraianrek6', 'idkdrek6')->all();
            return response()->json(['refrek6' => $refrek3], 200);
        }
    }

    public function getNoTBP()
    {
        $data = DB::select("SELECT D.No_byr AS no_bp -- , D.Ur_byr AS uraian, SUM(D.real_rp) AS nilai
				FROM tb_bprc A INNER JOIN 
				tb_byr D ON A.id_bprc = D.id_bprc INNER JOIN 
				tb_bp B ON A.id_bp = B.id_bp 
				WHERE  (A.Ko_Period = ".$tahun.") AND ( CAST(D.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
				AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 
				AND ( B.Ko_bp IN (1, 42, 43, 11) )
				GROUP BY D.No_byr, D.Ur_byr");

        $refnobp = collect($data)->pluck('no_bp', 'no_bp')->all();
        return $refnobp;
    }

    public function getNoSTS()
    {
        $data = DB::select("SELECT A.No_sts AS no_sts -- , A.Ur_sts AS uraian, SUM(B.real_rp) AS nilai
				FROM  (
				SELECT B.Ko_Period AS tahun, B.Ko_unitstr, B.dt_sts, B.No_sts, B.Ur_sts, A.No_byr
				FROM tb_sts B 
				INNER JOIN tb_stsrc A ON 	B.id_sts = A.id_sts
				WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_sts AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
				AND (B.Ko_unitstr = LEFT('".kd_unit()."',18)) 	
				GROUP BY B.dt_sts, B.No_sts, B.Ur_sts, B.Ko_Period, B.Ko_unitstr, A.No_byr
				) A INNER JOIN (
				SELECT B.Ko_Period AS tahun, A.Ko_Rkk, B.Ko_unitstr, B.No_byr, SUM(B.real_rp) AS real_rp
				FROM tb_byr B 
				INNER JOIN tb_bprc A ON 	B.id_bprc = A.id_bprc
				WHERE  (A.Ko_Period = ".$tahun.")  AND ( CAST(B.dt_byr AS DATE) BETWEEN  CAST('".$tgl_1."' AS DATE) AND CAST('".$tgl_2."' AS DATE)) 
				AND (B.Ko_unitstr = LEFT('".kd_unit()."',18))	
				GROUP BY B.Ko_Period, B.Ko_unitstr, B.No_byr, A.Ko_Rkk
				) B ON A.tahun = B.tahun AND A.Ko_unitstr = B.Ko_unitstr AND A.No_byr = B.No_byr
				GROUP BY A.No_sts, A.Ur_sts");

        $refnosts = collect($data)->pluck('no_sts', 'no_sts')->all();
        return $refnosts;
    }

   

}
