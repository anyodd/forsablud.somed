<?php

namespace App\Http\Controllers\Definitif\Penetapan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tbtap;
use App\Models\Pftap;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

use function Symfony\Component\String\b;

class PenetapanController extends Controller
{
    public function index() 
    {
        $period = Tahun();
        $unit = kd_bidang();
        
        $query = "SELECT
        a.id, a.Ko_Period, a.id_tap, a.Ko_Tap, b.Ur_Tap, a.No_Tap, a.Dt_Tap, a.No_DPA, a.Dt_DPA
        FROM tb_tap a
        JOIN pf_tap b ON a.Ko_Tap = b.Ko_Tap WHERE a.Ko_Period = ? AND a.ko_unit1 = ? GROUP BY a.id_tap";

        $tap = DB::select($query, [$period, $unit]);

        return view('definitif.penetapan.index', compact('tap'));
    }

    public function create()
    {
        $period = Session::get('Period');

        $id_tap = Tbtap::where('ko_period', $period)->max('id_tap');
        //$ko_tap = Pftap::all();
		$ko_tap = DB::select('CALL SP_JnPosting('.Tahun().', "'.kd_bidang().'")'); // 25-07-2024 Horison
		$ko_tap_last = DB::select('CALL SP_LastPosting('.Tahun().', "'.kd_bidang().'")'); // 25-07-2024 Horison

        $rba5 = DB::select('CALL SP_RBA5('.Tahun().', "'.kd_bidang().'")'); // harus single quote???

        $gbrincirba = collect($rba5)->groupBy('Ur_Rk1')->map(function ($group) {
            return [
                'rincian' => $group->all(),
                'subrincian' => $group->groupBy('Ko_Rc'),
                'subtotal' => $group->sum('To_Rp'),
            ];
        });

        return view('definitif.penetapan.create', compact('id_tap', 'ko_tap', 'gbrincirba', 'ko_tap_last' ));
    }

    public function store(Request $request)
    {
        $user = Session::get('userData')['username'];
        $period = Tahun();
        $unit = kd_bidang();

        $rules = [
            "noId" => "required",
            "kodePenetapanApbd" => "required",
            "nomorPenetapanApbd" => "required",
            "tanggalPenetapanApbd" => "required",
            "nomorDpa" => "required",
            "tanggalDpa" => "required",
        ];

        $messages = [
            "noId.required" => "No. Id wajib diisi.",
            "kodePenetapanApbd.required" => "Kode Penetapan APBD wajib diisi.",
            "nomorPenetapanApbd.required" => "Nomor Penetapan APBD wajib diisi.",
            "tanggalPenetapanApbd.required" => "Tanggal Penetapan APBD wajib diisi.",
            "nomorDpa.required" => "Nomor DPA wajib diisi.",
            "tanggalDpa.required" => "Tanggal DPA wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $query = "INSERT INTO tb_tap(id_tap, Ko_Tap, No_Tap, Dt_Tap, No_DPA, Dt_DPA, 
                    Ko_Period, ko_unit1, ur_subunit, ur_subunit1, Ko_sKeg1, Ur_KegBL1, Ko_sKeg2, Ur_KegBL2,
                    Ko_Rk1, Ur_Rk1, Ko_Rk2, Ur_Rk2, Ko_Rk3, Ur_Rk3, Ko_Rk4, Ur_Rk4, Ko_Rk5, Ur_Rk5, Ko_Rk6, Ur_Rk6, 
                    Ko_Rkk, Ko_Pdp, Ur_Pdp, Ko_Rc, Ur_Rc1, V_1, Rp_1, V_sat, To_Rp, tb_ulog, created_at, updated_at)
                SELECT(SELECT IFNULL(MAX(id_tap),0)+1 AS id_tap
                        FROM tb_tap
                        WHERE ko_period = '".Tahun()."' AND LEFT(ko_unit1,18) = '".kd_unit()."' ) AS id_tap, 
                    ?, ?,
                    ?, ?, ?,
                    A.Ko_Period, A.ko_unit1, D.ur_subunit, C.ur_subunit1, 
                    A.Ko_sKeg1, E.ur_KegBl1, A.Ko_sKeg2, F.ur_KegBl2,
                    A.Ko_Rk1, G.Ur_Rk1, A.Ko_Rk2, H.Ur_Rk2, A.Ko_Rk3, I.Ur_Rk3, A.Ko_Rk4, J.Ur_Rk4, A.Ko_Rk5, K.Ur_Rk5, A.Ko_Rk6, L.Ur_Rk6,
                    B.Ko_Rkk, B.Ko_Pdp, M.Ur_pdp, B.Ko_Rc, B.Ur_Rc1, B.V_1, B.Rp_1, B.V_sat, B.To_Rp,
                    ?, ?, ?
                FROM tb_ang_rc B INNER JOIN
                    tb_ang A ON A.Ko_Period = B.Ko_Period AND A.ko_unit1 = B.ko_unit1 AND A.Ko_sKeg1 = B.Ko_sKeg1 AND A.Ko_sKeg2 = B.Ko_sKeg2
                        AND A.Ko_Rkk = B.Ko_Rkk INNER JOIN
                    tb_sub1 C ON A.ko_unit1 = C.ko_unit1 INNER JOIN
                    tb_sub D ON C.Ko_Period = D.Ko_Period AND C.Ko_Wil1 = D.Ko_Wil1 AND C.Ko_Wil2 = D.Ko_Wil2 AND C.Ko_Urus = D.Ko_Urus
                        AND C.Ko_Bid = D.Ko_Bid AND C.Ko_Unit = D.Ko_Unit AND C.Ko_Sub = D.Ko_Sub INNER JOIN	
                    tb_kegs2 F ON A.Ko_Period = F.Ko_Period AND A.Ko_Unit1 = F.Ko_Unit1 AND A.Ko_sKeg1 = F.Ko_sKeg1 AND A.Ko_sKeg2 = F.Ko_sKeg2 INNER JOIN
                    tb_kegs1 E ON F.Ko_Period = E.Ko_Period AND F.Ko_Unit1 = E.Ko_Unit1 AND F.Ko_sKeg1 = E.Ko_sKeg1 AND F.Ko_KegBl1 = E.Ko_KegBl1 INNER JOIN
                    pf_rk1 G ON A.Ko_Rk1 = G.Ko_Rk1 INNER JOIN
                    pf_rk2 H ON A.Ko_Rk1 = H.Ko_Rk1 AND A.Ko_Rk2 = H.Ko_Rk2 INNER JOIN
                    pf_rk3 I ON A.Ko_Rk1 = I.Ko_Rk1 AND A.Ko_Rk2 = I.Ko_Rk2 AND A.Ko_Rk3 = I.Ko_Rk3 INNER JOIN
                    pf_rk4 J ON A.Ko_Rk1 = J.Ko_Rk1 AND A.Ko_Rk2 = J.Ko_Rk2 AND A.Ko_Rk3 = J.Ko_Rk3 AND A.Ko_Rk4 = J.Ko_Rk4 INNER JOIN
                    pf_rk5 K ON A.Ko_Rk1 = K.Ko_Rk1 AND A.Ko_Rk2 = K.Ko_Rk2 AND A.Ko_Rk3 = K.Ko_Rk3 AND A.Ko_Rk4 = K.Ko_Rk4 AND A.Ko_Rk5 = K.Ko_Rk5 INNER JOIN
                    pf_rk6 L ON A.Ko_Rk1 = L.Ko_Rk1 AND A.Ko_Rk2 = L.Ko_Rk2 AND A.Ko_Rk3 = L.Ko_Rk3 AND A.Ko_Rk4 = L.Ko_Rk4 AND A.Ko_Rk5 = L.Ko_Rk5 AND A.Ko_Rk6 = L.Ko_Rk6 LEFT OUTER JOIN
                    pf_jnpdp M ON B.Ko_Pdp = M.Ko_Pdp 
                WHERE A.Ko_Period = '".Tahun()."' AND LEFT(A.ko_unit1,18) = '".kd_unit()."'";
        DB::insert($query, [
            $request->kodePenetapanApbd,
            $request->nomorPenetapanApbd,
            $request->tanggalPenetapanApbd,
            $request->nomorDpa,
            $request->tanggalDpa,
            $user,
            NOW(),
            NOW()
        ]);

        Alert::success('Berhasil', 'Penetapan APBD Nomor ' . $request->kodePenetapanApbd . ' berhasil ditambahkan');

        return redirect()->route("penetapan.index");
    }

    public function show($id)
    {
        //
    }

    public function edit($id_tap)
    {
        $query = "SELECT a.*, MAX(b.Ur_Tap) AS Ur_Tap
                FROM tb_tap a
                LEFT JOIN pf_tap b ON a.Ko_Tap = b.Ko_Tap
                WHERE a.id_tap = ? AND a.ko_unit1 = ? and a.Ko_Period = ?";

        $tap = DB::select($query, [$id_tap, kd_bidang(), Tahun()])[0];

        return view('definitif.penetapan.edit', compact('tap'));
    }

    public function update(Request $request, $id_tap)
    {
        $rules = [
            "noId" => "required",
            "kodePenetapanApbd" => "required",
            "nomorPenetapanApbd" => "required",
            "tanggalPenetapanApbd" => "required",
            "nomorDpa" => "required",
            "tanggalDpa" => "required",
        ];

        $messages = [
            "noId.required" => "No. Id wajib diisi.",
            "kodePenetapanApbd.required" => "Kode Penetapan APBD wajib diisi.",
            "nomorPenetapanApbd.required" => "Nomor Penetapan APBD wajib diisi.",
            "tanggalPenetapanApbd.required" => "Tanggal Penetapan APBD wajib diisi.",
            "nomorDpa.required" => "Nomor DPA wajib diisi.",
            "tanggalDpa.required" => "Tanggal DPA wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // Menentukan Ko_Tap
        $sql = "SELECT * FROM tb_tap WHERE id_tap = ? AND LEFT(ko_unit1,18) = ? AND Ko_Period = ?";
        $Ko_Tap = DB::select($sql, [$id_tap, kd_unit(), Tahun()])[0]->Ko_Tap;

        $query = "UPDATE tb_tap
                SET id_tap  = ?, Ko_Tap = ?, No_Tap = ?, Dt_Tap = ?, No_DPA = ?, Dt_DPA = ?, tb_ulog = ?, updated_at = NOW()
                WHERE id_tap = ? AND LEFT(ko_unit1,18) = '".kd_unit()."' AND Ko_Period = '".Tahun()."'";

        DB::update($query, [
            $request->noId,
            $Ko_Tap,
            $request->nomorPenetapanApbd,
            $request->tanggalPenetapanApbd,
            $request->nomorDpa,
            $request->tanggalDpa,
            getUser('username'),
            $id_tap
        ]);

        Alert::success('Berhasil!', 'Data Penetapan APBD Nomor ' . $request->nomorPenetapanApbd . ' berhasil diubah');

        return redirect()->route("penetapan.index");
    }
    
    public function destroy($id)
    {
        $No_Tap = Tbtap::where('id', $id)->first()->No_Tap;

        $taps = Tbtap::where([ 'Ko_Period'=>Tahun(), 'ko_unit1'=>kd_bidang(), 'No_Tap'=>$No_Tap ])->get();

        foreach ($taps as $tap) {
            $tap->delete(); 
        };

        Alert::success('Yeay!', 'Data Penetapan APBD Nomor ' . $id . ' berhasil dihapus');

        return redirect()->route('penetapan.index');
    }
}
