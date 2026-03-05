<?php

namespace App\Http\Controllers\Pengesahan;

use Session;
use App\Models\Tbsp2;
use App\Models\Tbsp3;
// use Validator;
use App\Models\Jrtran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class Sp2bController extends Controller
{
    public function index()
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = tb_sub('Ko_unitstr');
        $user = getUser('username');

        // sp3b yg belum di sp2b
        $data = DB::select("SELECT a.* FROM tb_sp3 a
                                LEFT OUTER JOIN tb_sp2 b ON a.No_sp3 = b.No_sp3 && a.Ko_Period = b.Ko_Period && a.Ko_unitstr = b.Ko_unitstr
                                WHERE ISNULL(b.id_sp2) and a.Ko_Period = $Ko_Period and a.Ko_unitstr = '$Ko_unitstr' ORDER BY a.bln_sp3");
        $calon_sp2b = collect($data);

        $sp2b = Tbsp2::where(['Ko_Period' => $Ko_Period, 'Ko_unitstr' => $Ko_unitstr])->get();

        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '" . kd_unit() . "'");

        //dd($pegawai);

        return view('pengesahan.sp2b.index', compact('data', 'calon_sp2b', 'sp2b', 'pegawai'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request);
        $user = getUser('username');
        $Ko_Period = Tahun();
        $Ko_unitstr = tb_sub('Ko_unitstr');
        $No_sp3 = $request->No_sp3;
        $No_sp2 = $request->No_sp2;
        $id_sp3 = $request->id_sp3;

        $jd = DB::select(DB::raw("
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_D, 0 AS Jrtrans_Rp,
                    c.spirc_Rp AS jrRp_D, 0 AS jrRp_K, 'D' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.Ko_RKK		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi = 5
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_K, 0 AS Jrtrans_Rp,
                        0 AS jrRp_D, c.spirc_Rp AS jrRp_K, 'K' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.Ko_RKK		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi = 5
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_D, 0 AS Jrtrans_Rp,
                    c.spirc_Rp AS jrRp_D, 0 AS jrRp_K, 'D' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.KAS_KGU		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi = 5
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_K, 0 AS Jrtrans_Rp,
                        0 AS jrRp_D, c.spirc_Rp AS jrRp_K, 'K' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.KAS_KGU		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi = 5
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_D, 0 AS Jrtrans_Rp,
                    c.spirc_Rp AS jrRp_D, 0 AS jrRp_K, 'D' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.Ko_RKK
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi IN (2,3,4,6,8,9) 	
                    
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_K, 0 AS Jrtrans_Rp,
                        0 AS jrRp_D, c.spirc_Rp AS jrRp_K, 'K' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.Ko_RKK		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi IN (2,3,4,6,8,9) 
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_D, 0 AS Jrtrans_Rp,
                    c.spirc_Rp AS jrRp_D, 0 AS jrRp_K, 'D' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.KAS_D		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi IN (2,3,4,6,8,9) 
                    UNION ALL
                    SELECT NULL, d.Ko_Period, d.Ko_unitstr, 61, 6, g.date_end AS dt_bukti,
                    c.No_bp, c.Ur_bprc, c.Ko_bprc, f.No_sp2, c.Ko_Pdp, c.ko_pmed, 1 AS ko_kas, c.ko_sKeg1, c.ko_sKeg2, h.LRA_K, 0 AS Jrtrans_Rp,
                        0 AS jrRp_D, c.spirc_Rp AS jrRp_K, 'K' AS Ko_DK, 0 AS Tag, d.tb_ulog, d.created_at, d.updated_at
                    FROM  tb_oto a 
                    INNER JOIN tb_spi b ON a.ko_period = b.ko_period AND a.ko_unitstr = b.ko_unitstr AND a.no_spi = b.no_spi
                    INNER JOIN tb_spirc c ON b.Ko_Period = c.Ko_Period AND b.ko_unitstr = c.Ko_unitstr AND b.no_SPi = c.No_spi
                    INNER JOIN tb_sp3rc d ON a.Ko_Period = d.Ko_Period AND a.Ko_unitstr = d.Ko_unitstr AND a.No_oto = d.No_oto
                    INNER JOIN tb_sp3 e ON d.id_sp3 = e.id_sp3
                    INNER JOIN tb_sp2 f ON e.id_sp3 = f.id_sp3
                    INNER JOIN pf_bln g ON e.bln_sp3 = g.id_bln
                    INNER JOIN pf_mapjr h ON c.Ko_Rkk = h.KAS_D		
                    WHERE  a.Ko_Period = '" . $Ko_Period . "' AND
			        a.Ko_unitstr = '" . $Ko_unitstr . "'  AND e.No_sp3 = '" . $No_sp3 . "' AND b.Ko_SPi IN (2,3,4,6,8,9); "));
        // dd($jd);


        $rules = [
            "No_sp2" => "required",
            "Dt_sp2" => "required",
            "Ur_sp2" => "required",
            "Nm_Kuasa" => "required",
            "NIP_Kuasa" => "required",
        ];

        $messages = [
            "No_sp2.required" => "Nomor SP2B wajib diisi.",
            "Dt_sp2.required" => "Tanggal SP2B wajib diisi.",
            "Ur_sp2.required" => "Uraian SP2B wajib diisi.",
            "Nm_Kuasa.required" => "Nama Kepala wajib diisi.",
            "NIP_Kuasa.required" => "NIP Kepala wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Alert::warning('GAGAL', "Pengesahan SP2B dari SP3B Nomor : $No_sp3 GAGAL !!!");
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $kuasa = explode("|", $request->Nm_Kuasa);
        // dd($kuasa);
        // $lo = DB::select('CALL sp_oper'); // harus single quote???
        // $lo = DB::select(DB::raw("  "));
        try {
            $data = new Tbsp2;
            $data->Ko_Period = $Ko_Period;
            $data->Ko_unitstr = $Ko_unitstr;
            $data->id_sp3 = $id_sp3;
            $data->No_sp3 = $No_sp3;
            $data->No_sp2 = $request->No_sp2;
            $data->Dt_sp2 = $request->Dt_sp2;
            $data->Ur_sp2 = $request->Ur_sp2;
            $data->Nm_Kuasa  = $kuasa[0];
            $data->NIP_Kuasa = $kuasa[1];
            $data->tb_ulog = $user;
            $data->save();

            $inserts = [];

            // dd($bids);
            foreach ($jd as $bid) {
                $inserts[] =  [
                    'Ko_Period' => $Ko_Period,
                    'Ko_unitstr' => $Ko_unitstr,
                    'Ko_jr' => 61,
                    'Ko_jrasal' => 6,
                    'dt_bukti' => $request->Dt_sp2,
                    'Buktijr_No' => $bid->No_bp,
                    'jr_urbprc' => $bid->Ur_bprc,
                    'Ko_buktirc' => $bid->Ko_bprc,
                    'rftr_bprc' => $bid->Ko_bprc,
                    'Ko_Pdp' => $bid->Ko_Pdp,
                    'ko_pmed' => $bid->ko_pmed,
                    'ko_kas' => $bid->ko_kas,
                    'Ko_sKeg1' => $bid->ko_sKeg1,
                    'Ko_sKeg2' => $bid->ko_sKeg2,
                    'Ko_Rkk' => $bid->LRA_D,
                    'Jrtrans_Rp' => $bid->Jrtrans_Rp,
                    'jrRp_D' => $bid->jrRp_D,
                    'jrRp_K' => $bid->jrRp_K,
                    'Ko_DK' => $bid->Ko_DK,
                    'Tag' => $bid->Tag,
                    'tb_ulog' => $bid->tb_ulog,
                    'created_at' => now(),
                ];
            }
            // insert ke jurnal
            Jrtran::insert($inserts);
            // $rows_inserted = DB::table('bank_information')
            //     ->insertUsing(['user_id', 'bank_id', 'account_name', 'account_number'], $jd1);
            Alert::success('Berhasil', "Pengesahan SP2B dari SP3B Nomor : $No_sp3 berhasil !!!");
        } catch (\Throwable $e) {
            report($e);
            // } finally {
            //     # code...
        }
        //




        return redirect()->route("sp2b.index");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = getUser('username');

        $data = Tbsp2::find($id);

        $No_sp3 = $data->No_sp3;

        $rules = [
            "No_sp2" => "required",
            "Dt_sp2" => "required",
            "Ur_sp2" => "required",
            "Nm_Kuasa" => "required",
            "NIP_Kuasa" => "required",
        ];

        $messages = [
            "No_sp2.required" => "Tanggal dokumen wajib diisi.",
            "Dt_sp2.required" => "Tanggal dokumen wajib diisi.",
            "Ur_sp2.required" => "Uraian dokumen wajib diisi.",
            "Nm_Kuasa.required" => "Nama Kepala/Kuasa wajib diisi.",
            "NIP_Kuasa.required" => "NIP Kepala/Kuasa wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Alert::warning('GAGAL', "Edit Dokumen SP2B Nomor SP3B: $No_sp3 Tidak Berhasil !!!");
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Alert::success('Berhasil', "Edit Dokumen SP2B Nomor SP3B: $No_sp3 berhasil !!!");
        $kuasa = explode("|", $request->Nm_Kuasa);
        $data->No_sp2 = $request->No_sp2;
        $data->Dt_sp2 = $request->Dt_sp2;
        $data->Ur_sp2 = $request->Ur_sp2;
        $data->Nm_Kuasa  = $kuasa[0];
        $data->NIP_Kuasa = $kuasa[1];
        $data->tb_ulog = $request->tb_ulog;
        $data->updated_at = now();
        $data->save();

        return redirect()->route("sp2b.index");
    }

    public function destroy($id)
    {
        $data = Tbsp2::find($id);
        $data->delete();

        Alert::success('Berhasil', "Dokumen SP2B $data->No_sp2 berhasil dihapus !!!");

        return redirect()->route("sp2b.index");
    }
}
