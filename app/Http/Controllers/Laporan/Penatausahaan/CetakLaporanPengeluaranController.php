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
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRegisterSppController as RptRegisterSpp;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRegisterSpmController as RptRegisterSpm;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRegisterSp2dController as RptRegisterSp2d;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptSpjPengeluaranController as RptSpjPengeluaran;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptLaporanSpjPengeluaranController as RptLaporanSpjPengeluaran;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuKasPengeluaranController as RptBukuKasPengeluaran;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPajakController as RptBukuPajak;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPajakPerjenisController as RptBukuPajakPerjenis;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptKartuKendaliSubController as RptKartuKendaliSub;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptRincianKartuKendaliSubController as RptRincianKartuKendaliSub;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPembantuBelanjaGUController as RptBukuPembantuBelanjaGU;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptBukuPembantuBelanjaLSController as RptBukuPembantuBelanjaLS;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptLaporanRegisterSpiNpdController as RptLaporanRegisterSpiNpd;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptLaporanRegisterKontrakController as RptLaporanRegisterKontrak;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptLaporanDaftarRealisasiKontrakController as RptLaporanDaftarRealisasiKontrak;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptDaftarPembayaranUtangController as RptDaftarPembayaranUtang;
use App\Http\Controllers\Laporan\Penatausahaan\FormatLaporan\RptDaftarPembayaranUtangAwalController as RptDaftarPembayaranUtangAwal;

class CetakLaporanPengeluaranController extends Controller
{
	private $modul = 'laporan';
    private $view;
	
    public function __construct()
    {
        $this->view = $this->modul.'.penatausahaan.cetak-pengeluaran';
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        $jenis_laporan_req = $request->jenis_laporan;
		$tgl_1 =  $request->tgl_1;
		$tgl_2 = $request->tgl_2;
		$bulan = $request->bulan;
		$pajak = $request->pajak;
		$jn_spj = $request->jn_spj;

        if($request->idprogram == -1){
        $idprogram = -1;
        $idkegiatan = -1;
        $idsubkegiatan = -1;
        }else{
        $idprogram=$request->idprogram;
        $idkegiatan=$request->idkegiatan;
        $idsubkegiatan=$request->idsubkegiatan;
        }
        
        if($request->idkegiatan == -1 || $request->idkegiatan == null){
        $idkegiatan = -1;
        $idsubkegiatan = -1;
        }else{
        $idkegiatan=$request->idkegiatan;
        $idsubkegiatan=$request->idsubkegiatan;
        }
        
        if($request->idsubkegiatan == -1 || $request->idsubkegiatan == null){
        $idsubkegiatan = -1;
        }else{
        $idsubkegiatan=$request->idsubkegiatan;
        }
				
		// if($request->idsumberdana == -1 || $request->idsumberdana == null){
		// $idsumberdana = -1;
        // }else{
		// $idsumberdana=$request->idsumberdana;
        // }
		
		// $idlevelrekening=$request->idlevelrekening;
        // $kdrek1 = $request->idkdrek1; 
		// $kdrek2 = $request->idkdrek2; 
		// $kdrek3 = $request->idkdrek3; 
		// $kdrek4 = $request->idkdrek4; 
		// $kdrek5 = $request->idkdrek5; 
		// $kdrek6 = $request->idkdrek6;
		
        $ibukota 			= $request->ibukota;
        $tgl_laporan 		= $request->tgl_laporan;
		$penandatanganPimpinan = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 1
		])->first();
        $penandatanganBendahara = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 5
		])->first();
		$penandatanganBendaharaPembantu = Tbpjb::where([
			'Ko_unit1' => kd_bidang(),
			'id_pj' => 6
		])->first();

        switch ($jenis_laporan_req) {
            case 1;
                $model = RptRegisterSpp::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan1';
                break;
            case 2;
                $model = RptRegisterSpm::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan2';
                break;
            case 3;
                $model = RptRegisterSp2d::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan3';
                break;
            case 4;
			if ($bulan == null) {die("Harus Di Pilih Bulan SPJ..!!");}
                $model = RptSpjPengeluaran::Laporan($tahun, $bulan, $jn_spj);
                $view = $this->view . '.cetaklaporan4';
                break;
            case 5;
                $model = RptBukuKasPengeluaran::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan5';
                break;
            case 6;
                $model = RptBukuPajak::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan6';
                break;
			case 7;
			 if ($pajak == null) {die("Harus Di Pilih Jenis Potongan Pajak..!!");}
                $model = RptBukuPajakPerjenis::Laporan($tahun, $tgl_1, $tgl_2, $pajak);
                $view = $this->view . '.cetaklaporan7';
                break;
			case 8;
                $model = RptKartuKendaliSub::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan8';
                break;
			case 9;
                $model = RptRincianKartuKendaliSub::Laporan($tahun, $tgl_1, $tgl_2, $idprogram, $idkegiatan, $idsubkegiatan);
                $view = $this->view . '.cetaklaporan9';
                break;
            case 10;
                $model = RptBukuPembantuBelanjaGU::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan10';
                break;
			case 11;
                $model = RptBukuPembantuBelanjaLS::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan11';
                break;
            case 12;
                $model = RptLaporanRegisterSpiNpd::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan12';
                break;
			case 13;
                $model = RptLaporanRegisterKontrak::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan13';
                break;
            case 14;
                $model = RptLaporanDaftarRealisasiKontrak::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan14';
                break;
			case 15;
                $model = RptDaftarPembayaranUtang::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan15';
                break;
			case 16;
                $model = RptDaftarPembayaranUtangAwal::Laporan($tahun, $tgl_1, $tgl_2);
                $view = $this->view . '.cetaklaporan16';
                break;
			case 17;
              if ($bulan == null) {die("Harus Di Pilih Bulan SPJ..!!");}
                $model = RptLaporanSpjPengeluaran::Laporan($tahun, $bulan, $jn_spj);
                $view = $this->view . '.cetaklaporan17';
                break;
        }
	
		return view($view, [
            'model' => $model,
			'tgl_1' =>  $tgl_1,
			'tgl_2' =>  $tgl_2,
			'bulan' =>  $bulan,
			'jn_spj' => $jn_spj,
            'idprogram' =>  $idprogram,
			'idkegiatan' =>  $idkegiatan,
			'idsubkegiatan' =>  $idsubkegiatan,
			'ibukota' => $ibukota,
			'tgl_laporan' => $tgl_laporan,
			'penandatanganPimpinan' => $penandatanganPimpinan,
			'penandatanganBendahara' => $penandatanganBendahara,
			//'idsumberdana' =>  $idsumberdana,
        ]);
		
    }

    public function laporan(Request $request)
    {
        $tahun = Tahun();
        $idsubunit_req = kd_unit();
		
        $jns = [
			['id' => 0, 'uraian' => 'Pilih Jenis Laporan'],
            ['id' => 1, 'uraian' => 'Register S-PPD (SPP)'], 
            ['id' => 2, 'uraian' => 'Register S-OPD (SPM)'], 
            ['id' => 3, 'uraian' => 'Register S-PD (SP2D)'], 
            ['id' => 4, 'uraian' => 'SPJ Pengeluaran'], 
			['id' => 17, 'uraian' => 'SPJ Pengeluaran Per Subkegiatan'], 
            ['id' => 5, 'uraian' => 'Buku Kas Pengeluaran'], 
            ['id' => 6, 'uraian' => 'Buku Pajak'], 
			['id' => 7, 'uraian' => 'Buku Pajak Per Jenis Pajak'], 
			['id' => 8, 'uraian' => 'Kartu Kendali Sub Kegiatan'],
			['id' => 9, 'uraian' => 'Rincian Kartu Kendali Subkegiatan'],
            ['id' => 10, 'uraian' => 'Buku Pembantu Belanja GU'],
			['id' => 11, 'uraian' => 'Buku Pembantu Belanja LS'],
            ['id' => 12, 'uraian' => 'Register S-PPD s.d S-PD (UP, GU, LS)'],
			['id' => 13, 'uraian' => 'Register Kontrak/SPK'],
            ['id' => 14, 'uraian' => 'Realisasi Pembayaran Per Nomor Kontrak (On Progress)'],
			['id' => 15, 'uraian' => 'Daftar Pembayaran Utang (On Progress)'],
			['id' => 16, 'uraian' => 'Daftar Pembayaran Utang Tahun Lalu (On Progress)'],
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
		
		$pajak = DB::select("SELECT  Ko_RKK AS id, Ur_Rk6 AS uraian FROM pf_rk6 WHERE Ko_RKK LIKE '02.01.01%'
							 AND Ko_Period=".Tahun()." ");
							 
		$getPajak = collect($pajak)->pluck('uraian', 'id')->all();					 
		
		$ibukota = nm_ibukota();

        return view($this->view . '.index', [
            'tahun' => $tahun,
            'jnslap' => $jnslap,
			'getRek1' => $getRek1,
			'getBulan' => $getBulan,
			'getRefSumberDana' => $getRefSumberDana,
			'getPajak' => $getPajak,
			'ibukota' => $ibukota,
            'prefix' => $this->modul,
        ]);
    }


	public function selectProgram(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT m.Ur_Prg AS nmprogram, m.Ko_Prg AS idprogram, CONCAT(LPAD(m.Ko_Prg,2,0),' - ',m.Ur_Prg) AS program_display 
                    FROM tb_ang_rc AS a INNER JOIN
                        tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
                        tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
                        tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
                        pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
						pf_keg l ON k.id_keg=l.id_keg INNER JOIN
						pf_prg m ON l.id_prog=m.id_prog INNER JOIN
						pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
						pf_urus o ON n.id_urus=o.id_urus
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." ");

        $refprogram = collect($data)->pluck('program_display', 'idprogram')->all();
        return response()->json(['refprogram' => $refprogram], 200);
    }

    public function selectKegiatan(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT l.Ur_Keg AS nmkegiatan, l.Ko_Prg AS idprogram, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg) AS idkegiatan, CONCAT(LPAD(l.Ko_Prg,2,0),'.',l.Ko_Keg,' - ',l.Ur_Keg) AS kegiatan_display
                    FROM tb_ang_rc AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
						pf_keg l ON k.id_keg=l.id_keg INNER JOIN
						pf_prg m ON l.id_prog=m.id_prog INNER JOIN
						pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
						pf_urus o ON n.id_urus=o.id_urus 
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." AND l.Ko_Prg='" . $id."' ");

        $refkegiatan = collect($data)->pluck('kegiatan_display', 'idkegiatan')->all();
        return response()->json(['refkegiatan' => $refkegiatan], 200);
    }

    public function selectSubKegiatan(Request $request, $id = null)
    {
        $data = DB::select("SELECT DISTINCT k.Ur_sKeg AS nmsubkegiatan, k.Ko_Prg AS idprogram, CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg) AS idkegiatan, CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg,'.',LPAD(k.Ko_sKeg,3,0)) AS idsubkegiatan, CONCAT(k.Ko_sKeg1,' - ',k.Ur_sKeg) AS subkegiatan_display
                    FROM tb_ang_rc AS a INNER JOIN
						tb_kegs2 jjj ON a.Ko_sKeg2=jjj.Ko_sKeg2 AND a.Ko_sKeg1=jjj.Ko_sKeg1 AND a.Ko_unit1=jjj.Ko_unit1 INNER JOIN
						tb_kegs1 jj ON jjj.Ko_KegBL1=jj.Ko_KegBL1 AND jjj.Ko_sKeg1=jj.Ko_sKeg1 AND jjj.Ko_unit1=jj.Ko_unit1 INNER JOIN
						tb_keg j ON jj.Ko_sKeg1=j.Ko_sKeg1 AND jj.Ko_unit1=j.Ko_unit1 INNER JOIN
						pf_skeg k ON j.id_sub_keg=k.id_sub_keg INNER JOIN
						pf_keg l ON k.id_keg=l.id_keg INNER JOIN
						pf_prg m ON l.id_prog=m.id_prog INNER JOIN
						pf_bid n ON m.id_bidang=n.id_bidang INNER JOIN
						pf_urus o ON n.id_urus=o.id_urus
                    WHERE LEFT(j.Ko_unit1,18) = '".kd_unit()."' AND a.Ko_Period=".Tahun()." AND CONCAT(LPAD(k.Ko_Prg,2,0),'.',k.Ko_Keg)='" . $id."' ");

        $refsubkegiatan = collect($data)->pluck('subkegiatan_display', 'idsubkegiatan')->all();
        return response()->json(['refsubkegiatan' => $refsubkegiatan], 200);
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

   

}
