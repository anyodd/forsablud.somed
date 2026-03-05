<?php

namespace App\Http\Controllers\Pembukuan;

use App\Http\Controllers\Controller;
use App\Models\Jrtran;
use Illuminate\Http\Request;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbyroto;
use App\Models\Pfbank;
use App\Models\tbnpd;
use App\Models\Tboto;
use Illuminate\Support\Facades\Crypt;
use PDF;

class SpmController extends Controller
{
    public function index()
    {

        $data = DB::select(DB::raw("SELECT a.*, SUM(c.spirc_Rp) Jumlah, d.byroto_Rp Bayar  FROM tb_oto a
                LEFT JOIN tb_spi b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.No_SPi = b.No_spi
                LEFT JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period && b.Ko_unitstr = c.Ko_unitstr && b.No_SPi = c.No_spi
                LEFT JOIN (SELECT a.No_oto,a.No_SPi,SUM(b.byroto_Rp) byroto_Rp FROM tb_oto a
                LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.No_oto = b.No_oto
                WHERE a.Ko_Period = '" . Tahun() . "' && a.Ko_unitstr = '" . kd_unit() . "'
                GROUP BY a.No_oto
                ) d ON a.No_oto = d.No_oto && a.No_SPi = d.No_SPi
                WHERE a.Ko_unitstr = '" . kd_unit() . "' && a.Ko_Period = '" . Tahun() . "' && b.Ko_SPi <> 5
                GROUP BY a.id ORDER BY a.Dt_oto, a.No_SPi, a.id ASC"));

        $dt_oto = collect($data);

        $data1 = DB::select(DB::raw("SELECT a.*, b.No_Rek, b.Ur_Bank
                FROM tb_byroto a
                LEFT JOIN pf_bank b ON a.Ko_unitstr = b.Ko_unitstr AND a.Ko_Bank = b.Ko_Bank
                WHERE a.Ko_unitstr = '" . kd_unit() . "' AND b.Ko_unitstr = '" . kd_unit() . "' AND a.Ko_Period = " . Tahun()));
        $spm = collect($data1);

        $data = DB::select('CALL SP_Otorisasi_Usul(' . Tahun() . ', "' . kd_unit() . '")');
        $data2 = DB::select('CALL SP_Otorisasi_Byr(' . Tahun() . ', "' . kd_unit() . '")');
        $otorisasi = collect($data);
        $otorisasi2 = collect($data2);

        return view('pembukuan.spm.index', compact('otorisasi', 'otorisasi2', 'dt_oto', 'spm'));
    }

    public function create()
    {
        //
    }

    public function tambah($id)
    {
        $id = Crypt::decrypt($id);
        
        $data = DB::select(DB::raw("SELECT a.id, a.id_spi, a.Ko_Period, a.ko_unitstr, a.No_SPi, a.No_oto, a.Dt_Oto AS tgl_oto, a.Ur_Oto, a.Trm_Nm, a.Trm_rek, a.Trm_bank, a.Trm_NPWP, 
                a.Nm_Kuasa, a.NIP_Kuasa, d.Nm_Ben, d.NIP_Ben, d.Nm_Keu, d.NIP_Keu, d.Ko_Bank, b.id_byro, SUM(c.spirc_Rp) AS Jumlah
                FROM tb_oto a
                LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period AND a.No_oto = b.No_oto
                LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.No_SPi = c.No_spi
                LEFT JOIN tb_spi d ON c.Ko_Period = d.Ko_Period and c.Ko_unitstr = d.Ko_unitstr AND c.No_SPi = d.No_spi
                WHERE a.Ko_Period = '" . Tahun() . "' AND a.Ko_unitstr = '" . kd_unit() . "' AND d.Ko_SPi <> 5
                GROUP BY a.id, a.id_spi, a.Ko_Period, a.ko_unitstr, a.No_SPi, a.No_oto, a.Dt_Oto, a.Ur_Oto, a.Trm_Nm, a.Trm_rek, a.Trm_bank, a.Trm_NPWP, 
                a.Nm_Kuasa, a.NIP_Kuasa, d.Nm_Ben, d.NIP_Ben, d.Nm_Keu, d.NIP_Keu, d.Ko_Bank, b.id_byro"));
 
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                WHERE LEFT(a.Ko_unit1,18) = '" . kd_unit() . "'");

        $rekan = DB::select("SELECT * FROM tb_rekan WHERE Ko_unitstr = '" . kd_unit() . "'");

        $dt_oto = collect($data)->where('id', $id)->first();
     
        $bank = Pfbank::where('Ko_unitstr', kd_unit())->get();

        $rincian =  DB::select("SELECT a.*,c.nm_BUcontr FROM (
                    SELECT a.id,b.*,a.No_bp,a.Ur_bprc,a.spirc_Rp FROM tb_spirc a
                    JOIN (SELECT a.No_oto,a.Ko_Period,a.Ko_unitstr, a.Dt_oto,b.id id_spi,b.No_SPi,b.Dt_SPi FROM tb_oto a
                    JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                    WHERE a.id = '" . $id . "') b ON a.No_spi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                    GROUP BY a.id) a
                    LEFT JOIN tb_byroto b ON a.No_bp = b.No_bp && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                    LEFT JOIN tb_bp c ON a.No_bp = c.No_bp && a.Ko_Period = c.Ko_Period && a.Ko_unitstr = LEFT(c.Ko_unit1,18)
                    WHERE b.id_byro IS NULL");

        // $rincian =  DB::select("
        //         SELECT a.*,c.nm_BUcontr
        //     FROM (
        //     SELECT a.id, a.Ko_Period, a.Ko_unitstr, a.No_spi, a.Ko_spirc,  a.No_bp, a.Ko_bprc, a.Ur_bprc, a.rftr_bprc, a.dt_rftrbprc,
        // 		a.No_PD, a.Ko_sKeg1, a.Ko_sKeg2, a.Ko_Rkk, a.Ko_Pdp, a.ko_pmed, a.spirc_Rp,
        // 		b.Dt_oto, b.No_oto
        //     FROM tb_spirc a
        // 	JOIN (SELECT a.No_oto,a.Ko_Period,a.Ko_unitstr, a.Dt_oto,b.id id_spi,b.No_SPi,b.Dt_SPi
        // 				FROM tb_oto a
        // 				JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
        // 				WHERE a.id = '" . $id . "') b ON a.No_spi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
        //     GROUP BY a.id) a
        //     LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.no_spi = b.no_spi
        //     && a.no_oto = b.no_oto && a.No_bp = b.No_bp
        //     LEFT JOIN tb_bp c ON a.No_bp = c.No_bp && a.Ko_Period = c.Ko_Period && a.Ko_unitstr = LEFT(c.Ko_unit1,18)
        //     WHERE b.id_byro IS NULL
        //     GROUP BY a.id
        //         ");

        return view('pembukuan.spm.tambah', compact('dt_oto', 'bank', 'rincian', 'pegawai', 'rekan'));
    }

    public function store(Request $request)
    {
        $idrc = explode(',', $request->id_rc);
        $url  = crypt::encrypt($request->id_oto);
        $rincian =  DB::select("SELECT a.*, b.ko_kas, c.Ko_bp, c.nm_BUcontr
                    FROM (SELECT a.id, a.Ko_Period, a.Ko_unitstr, a.No_spi, a.Ko_spirc,  a.No_bp, a.Ko_bprc, a.Ur_bprc, a.rftr_bprc, a.dt_rftrbprc,
                    	a.No_PD, a.Ko_sKeg1, a.Ko_sKeg2, a.Ko_Rkk, a.Ko_Pdp, a.ko_pmed, a.spirc_Rp,
                    	b.Dt_oto, b.No_oto, b.Ko_SPi
                    	FROM tb_spirc a
                    	JOIN
                    	(SELECT a.No_oto,a.Ko_Period,a.Ko_unitstr, a.Dt_oto,b.id AS id_spi, b.Ko_SPi, b.No_SPi,b.Dt_SPi
                    	FROM tb_oto a
                    	JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                    	WHERE a.id = '" . $request->id_oto . "')
                    	b
                    	ON a.No_spi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                    	GROUP BY a.id) a
                    	LEFT JOIN tb_byroto b
                    	ON a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr && a.no_spi = b.no_spi && a.no_oto = b.no_oto && a.No_bp = b.No_bp
                    	LEFT JOIN tb_bp c ON a.No_bp = c.No_bp && a.Ko_Period = c.Ko_Period && a.Ko_unitstr = LEFT(c.Ko_unit1,18)
                    	WHERE b.id_byro IS NULL
                    GROUP BY a.id");

        $dt_rc = collect($rincian)->whereIn('id', $idrc);

        $PP  = explode("|", $request->Nm_PP);
        // $Ben = explode("|", $request->Nm_Ben);
        // $Keu = explode("|", $request->Nm_Keu);

        try {
            tbnpd::create([
                'id_oto'     => $request->id_oto,
                'Ko_Period'  => Tahun(),
                'Ko_unitstr' => kd_unit(),
                'No_oto'     => $request->No_oto,
                'No_npd'     => $request->No_npd,
                'Dt_npd'     => $request->Dt_npd,
                'Ur_npd'     => $request->Ur_npd,
                'Nm_PP'      => $PP[0],
                'NIP_PP'     => $request->NIP_PP,
                'Nm_Ben'     => $request->Nm_Ben,
                'NIP_Ben'    => $request->NIP_Ben,
                'Nm_Keu'     => $request->Nm_Keu,
                'NIP_Keu'    => $request->Nm_Keu,
                'Tag'        => 0,
                'Tag_v'      => 0,
                'tb_ulog'    => getUser('username'),
            ]);
        } catch (\Throwable $th) {
            $url = crypt::encrypt($request->id_oto);
            // $url = $request->id_oto;
            Alert::warning('Gagal', 'Nomor pembayaran sudah ada');
            return redirect()->route('spm.tambah', $url);
        }

        $npd = DB::select("SELECT id_npd FROM tb_npd WHERE No_npd = '" . $request->No_npd . "' && Ko_Period = '" . Tahun() . "' && Ko_unitstr = '" . kd_unit() . "' ");

        $byroto = Tbbyroto::where('id_npd', $npd['0']->id_npd)->max('Ko_byro');
        if ($byroto != NULL) {
            $ko_byro = $byroto + 1;
        } else {
            $ko_byro = 1;
        }

        // $bank =  explode("|", $request->Nm_Bank);

        foreach ($dt_rc as $key => $value) {
            Tbbyroto::create([
                'id_npd'     => $npd['0']->id_npd,
                'Ko_Period'  => Tahun(),
                'Ko_unitstr' => kd_unit(),
                'Ko_byro'    => $ko_byro++,
                'dt_byro'    => $request->Dt_npd,
                'Ur_byro'    => $request->Ur_npd,
                'No_oto'     => $request->No_oto,
                'No_SPi'     => $request->No_SPi,
                'No_npd'     => $request->No_npd,
                'No_bp'      => $value->No_bp,
                'Ko_bprc'    => $value->Ko_bprc,
                'byroto_Rp'  => $value->spirc_Rp,
                'ko_kas'     => 1,
                'Ko_Bank'    => $request->Ko_Bank,
                'No_Rektuju' => $request->Trm_rek,
                'Nm_Bank'    => $request->Trm_bank,
                'Nm_Byro'    => $request->Nm_Byro,
                'Tag'        => 0,
                'tb_ulog'    => getUser('username'),
            ]);
        };

        //     -- Referensi ko_spi (kode pengajuan SPP)
        // 		/*
        // 		1	Kas Awal/UP
        // 		2	LS NON Kontrak
        // 		3	Kontrak
        // 		4	GU
        // 		5	Pendapatan
        // 		6	NIHIL
        // 		7	Panjar
        // 		8	NIHIL Panjar
        // 		9	Utang
        // 		*/
        // if ($value->Ko_SPi == 1) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => '01.01.01.03.001.001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => '01.01.01.04.001.0001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // } elseif ($value->Ko_SPi == 4 || $value->Ko_SPi == 7) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' =>   '01.01.01.03.001.0001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => '01.01.01.04.001.0001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // } elseif ($value->Ko_SPi == 2 || $value->Ko_SPi == 3 || $value->Ko_SPi == 9) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_D,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_KLS,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // };
        // if ($value->Ko_SPi == 4 || $value->Ko_SPi == 7) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_D,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_KLS,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // } elseif ($value->Ko_SPi == 4 || $value->Ko_SPi == 7) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' =>   '01.01.01.03.001.0001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => '01.01.01.04.001.0001',
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // } elseif ($value->Ko_SPi == 2 || $value->Ko_SPi == 3 || $value->Ko_SPi == 9) {
        //     foreach ($dt_rc as $key => $value) {
        //         $data = array(
        //             array(
        //                 // debet
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_D,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => $value->spirc_Rp,
        //                 'jrRp_K' => 0,
        //                 'Ko_DK' => 'D',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             ),
        //             array(
        //                 //kredit
        //                 'Ko_Period' => Tahun(),
        //                 'Ko_unitstr' => kd_unit(),
        //                 'Ko_jr' => 71,
        //                 'Ko_jrasal' => 5,
        //                 'dt_bukti' => $request->Dt_npd,
        //                 'Buktijr_No' => $request->No_npd,
        //                 'jr_urbprc' => $request->Ur_npd,
        //                 'Ko_buktirc' => $value->Ko_bprc,
        //                 'rftr_bprc' => $value->No_bp,
        //                 'Ko_Pdp' => $value->Ko_Pdp,
        //                 'ko_pmed' => $value->ko_pmed,
        //                 'ko_kas' => $value->ko_kas,
        //                 'Ko_sKeg1' => $value->Ko_sKeg1,
        //                 'Ko_sKeg2' => $value->Ko_sKeg2,
        //                 'Ko_Rkk' => $value->KAS_KLS,
        //                 'Jrtrans_Rp' => 0,
        //                 'jrRp_D' => 0,
        //                 'jrRp_K' => $value->spirc_Rp,
        //                 'Ko_DK' => 'K',
        //                 'Tag' => 0,
        //                 'tb_ulog' => getUser('username'),
        //                 'created_at' => now(),
        //             )
        //         );
        //         Jrtran::insert($data);
        //     };
        // };

        Tbbyroto::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit(), 'No_npd' => $request->No_npd])->update([
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('spm.show', $url);
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $row = DB::select(DB::raw("SELECT a.*, b.id_byro, SUM(c.spirc_Rp) AS Jumlah
                FROM tb_oto a
                LEFT JOIN tb_byroto b ON a.Ko_Period = b.Ko_Period AND a.No_oto = b.No_oto
                LEFT JOIN tb_spirc c ON a.Ko_Period = c.Ko_Period AND a.No_SPi = c.No_spi
                LEFT JOIN tb_spi d ON c.Ko_Period = d.Ko_Period and c.Ko_unitstr = d.Ko_unitstr AND c.No_SPi = d.No_spi
                WHERE a.Ko_Period = '" . Tahun() . "' AND a.Ko_unitstr = '" . kd_unit() . "' AND d.Ko_SPi <> 5
                GROUP BY a.ko_period, a.ko_unitstr, a.no_spi"));
        $dt_oto = collect($row)->where('id', $id)->first();
        $data = DB::select("SELECT a.*,SUM(b.byroto_Rp) total FROM tb_npd a
            LEFT JOIN tb_byroto b ON a.id_npd = b.id_npd
            WHERE a.Ko_Period = '" . Tahun() . "' && a.Ko_unitstr = '" . kd_unit() . "' && a.id_oto = '" . $id . "'
            GROUP BY a.id_npd");

        return view('pembukuan.spm.detail', compact('dt_oto', 'data'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_unit();
        $user = getUser('username');

        $rules = [
            "No_byro" => "required",
            "dt_byro" => "required",
            "Ur_byro" => "required",
            "Ko_Bank" => "required",
            "No_Rektuju" => "required",
            "Nm_Bank" => "required",
            "Nm_Byro" => "required",
        ];

        $messages = [
            "No_byro.required" => "Nomor SPM wajib diisi.",
            "dt_byro.required" => "Tanggal SPM wajib diisi.",
            "Ur_byro.required" => "Uraian wajib diisi.",
            "Ko_Bank.required" => "Bank pembayar wajib diisi.",
            "No_Rektuju.required" => "Nomor rekening bank penerima wajib diisi.",
            "Nm_Bank.required" => "Bank penerima wajib diisi.",
            "Nm_Byro.required" => "Nama pembayar wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Alert::warning('GAGAL !!!', 'Realisasi SPM Nomor ' . $request->No_byro . ' GAGAL dibuat !!!');
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = Tbbyroto::find($id);

        $data->No_byro = $request->No_byro;
        $data->dt_byro = $request->dt_byro;
        $data->Ur_byro = $request->Ur_byro;
        $data->Ko_Bank = $request->Ko_Bank;
        $data->No_Rektuju = $request->No_Rektuju;
        $data->Nm_Bank = $request->Nm_Bank;
        $data->Nm_Byro = $request->Nm_Byro;
        $data->tb_ulog = $user;
        $data->updated_at = now();
        $data->save();

        Alert::success('BERHASIL !!!', 'Realisasi SPM Nomor ' . $request->No_byro . ' berhasil dirubah !!!');

        return redirect()->route("spm.index");
    }

    public function destroy($id)
    {
        $row = DB::select("SELECT id_oto, No_npd FROM tb_npd WHERE id_npd = '" . $id . "' GROUP BY id_oto");
        $data = Tbnpd::find($id);
        $data2 = Tbbyroto::where('No_npd', $row['0']->No_npd);

        $data->delete();
        $data2->delete();

        $url = crypt::encrypt($row['0']->id_oto);
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('spm.show', $url);
    }

    public function getData(Request $request)
    {
        $row  = DB::select("SELECT a.id id_spirc,b.*,a.No_bp,a.Ur_bprc,a.spirc_Rp FROM tb_spirc a
                JOIN (SELECT a.No_oto,a.Dt_oto,b.id id_spi,b.No_SPi,b.Dt_SPi FROM tb_oto a
                JOIN tb_spi b ON a.No_SPi = b.No_SPi && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                WHERE a.id = '" . $request->id . "') b ON a.No_spi = b.No_SPi
                GROUP BY a.id");
        $data = collect($row)->whereIn('id_spirc', $request->dt);
        return response()->json($data);
    }

    public function spd_spm_pdf($id)
    {
    
        $ttd = tbnpd::where('id_oto',$id)->first();
        $data = tbnpd::join('tb_byroto', 'tb_byroto.id_npd','=','tb_npd.id_npd')
                ->where('id_oto', '=', $id)
                ->first();
        $dba = DB::select("SELECT * FROM tb_tap WHERE Ko_Period = '".Tahun()."' && LEFT(ko_unit1,18) = '".kd_unit()."' HAVING MAX(id_tap)");
        $qr_sp2d = collect(DB::select('CALL SP_S_PencairanDana("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_npd . '")')); 
        $qr_pot = collect(DB::select('CALL SP_Pot_PencairanDana("' . Tahun() . '","' . kd_unit() . '", "' . $data->No_npd . '")'));
        $jumlah = collect($qr_sp2d)->where('Nm_Kode', 'Rincian')->sum('Jumlah');
        
        $pdf = PDF::loadView('pembukuan.spm.spd_pdf', compact('data', 'qr_sp2d', 'jumlah','dba','qr_pot','ttd'))->setPaper('A4', 'portrait');
        return $pdf->stream('S-PD: ' . $data->No_npd . '.pdf',  array("Attachment" => false));
    }
}
