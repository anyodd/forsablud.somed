<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Pfrk6;
use App\Models\Tb_ang;
use App\Models\Tb_keg;
use App\Models\Tb_keg1;
use App\Models\Tb_keg2;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AkunController extends Controller
{
    public function index()
    {
        //
    }

    public function akun($id1,$id2,$id3)
    {
        $Ko_sKeg1 = $id1; $Ko_sKeg2 = $id2; $Ko_KegBL1 = $id3;
        $id_bidang = bidang_id(kd_unit());
        $pf_rk6 = "( SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 = 4) AND (a.id_bidang = ( SELECT SUM(b.id_bidang) AS id_bidang FROM ( SELECT 0 AS id_bidang UNION SELECT id_bidang FROM pf_rk6 WHERE id_bidang = ".$id_bidang." GROUP BY id_bidang ) b )) 
		UNION SELECT a.* FROM pf_rk6 a WHERE (a.Ko_Rk1 <> 4) AND (a.id_bidang = 0) )";
        
        $map  = Tb_keg::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1])->first();
        $map2 = Tb_keg1::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_KegBL1' => $id3])->first();
        $map3 = Tb_keg2::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_sKeg2' => $id2])->first();

        $ls = DB::select("SELECT a.* FROM (
            SELECT a.* , CASE WHEN b.id_bidang IS NOT NULL THEN a.id_bidang ELSE 0 END AS kode_bid
            FROM ". $pf_rk6 . " a LEFT OUTER JOIN pf_bid b ON a.id_bidang=b.id_bidang
            WHERE Ko_Rk1 IN (4)) a 
            WHERE LEFT(a.Ko_RKK,11) IN ('04.01.04.16','04.01.04.18') 
            AND a.kode_bid=
            ( SELECT DISTINCT CASE WHEN b.id_bidang IS NOT NULL THEN a.id_bidang ELSE 0 END AS kode_bid
            FROM pf_bid a LEFT OUTER JOIN ". $pf_rk6 . " b ON a.id_bidang=b.id_bidang
            WHERE a.id_bidang=$id_bidang )
            UNION ALL
            SELECT a.*, $id_bidang as kode_bid FROM (
            SELECT a.* FROM (". $pf_rk6 . ") a
            WHERE Ko_Rk1 IN (5,6)) a
            WHERE LEFT(a.Ko_RKK,11) NOT IN ('05.01.02.99','05.02.01.99','05.02.02.99','05.02.03.99','05.02.04.99','05.02.05.99','05.02.06.99')");
    
        // $dt = Tb_ang::where(['Ko_Period' => Tahun(), 'ko_unit1' => kd_bidang(), 'Ko_sKeg1' => $id1, 'Ko_sKeg2' => $id2])->get();
        $dt = Tb_ang::select('tb_ang.*',DB::raw('SUM(tb_ang_rc.To_Rp) As jml'))
            ->leftJoin('tb_ang_rc', function ($join) {
                $join->on('tb_ang.Ko_sKeg1', '=', 'tb_ang_rc.Ko_sKeg1');
                $join->on('tb_ang.Ko_sKeg2', '=', 'tb_ang_rc.Ko_sKeg2');
                $join->on('tb_ang.Ko_Rkk', '=', 'tb_ang_rc.Ko_Rkk');
                $join->on('tb_ang.Ko_Period', '=', 'tb_ang_rc.Ko_Period');
                $join->on('tb_ang.ko_unit1', '=', 'tb_ang_rc.ko_unit1');
            })
            ->where(['tb_ang.Ko_Period' => Tahun(), 'tb_ang.ko_unit1' => kd_bidang(), 'tb_ang.Ko_sKeg1' => $id1, 'tb_ang.Ko_sKeg2' => $id2])
            ->groupBy('tb_ang.Ko_Rkk')
            ->get();
        // dd($dt);

        $jml = Tb_keg2::select(DB::raw('SUM(tb_ang_rc.To_Rp) As jml'))
                ->leftJoin('tb_ang', function ($join) {
                    $join->on('tb_kegs2.Ko_sKeg1', '=', 'tb_ang.Ko_sKeg1');
                    $join->on('tb_kegs2.Ko_sKeg2', '=', 'tb_ang.Ko_sKeg2');
                    $join->on('tb_kegs2.ko_unit1', '=', 'tb_ang.ko_unit1');
                    $join->on('tb_kegs2.Ko_Period', '=', 'tb_ang.Ko_Period');
                })->leftJoin('tb_ang_rc', function ($join) {
                    $join->on('tb_ang.Ko_sKeg1', '=', 'tb_ang_rc.Ko_sKeg1');
                    $join->on('tb_ang.Ko_sKeg2', '=', 'tb_ang_rc.Ko_sKeg2');
                    $join->on('tb_ang.Ko_Rkk', '=', 'tb_ang_rc.Ko_Rkk');
                    $join->on('tb_ang.ko_unit1', '=', 'tb_ang_rc.ko_unit1');
                    $join->on('tb_ang.Ko_Period', '=', 'tb_ang_rc.Ko_Period');
                })
                ->where(['tb_kegs2.Ko_Period' => Tahun(), 'tb_kegs2.ko_unit1' => kd_bidang(), 'tb_kegs2.Ko_sKeg1' => $id1, 'tb_kegs2.Ko_sKeg2' => $id2])
                ->groupBy('tb_kegs2.Ko_sKeg1')
                ->value('jml');

                // return view('perencanaan.akun',compact('dt','ls','map','map2','map3','Ko_sKeg1','Ko_sKeg2','Ko_KegBL1','jml'));
                return view('perencanaan.rba.akun',compact('dt','ls','map','map2','map3','Ko_sKeg1','Ko_sKeg2','Ko_KegBL1','jml'));
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ur_Rc'   => 'required',
        ]);
		
		$Ko_Rkk = collect(DB::select("SELECT CONCAT(LPAD(".$request->Ko_Rk1.",2,0),'.' ,LPAD(".$request->Ko_Rk2.",2,0),'.' ,LPAD(".$request->Ko_Rk3.",2,0),'.' ,LPAD(".$request->Ko_Rk4.",2,0),'.' ,LPAD(".$request->Ko_Rk5.",3,0),'.' ,LPAD(".$request->Ko_Rk6.",4,0)) AS Ko_Rkk"))->first();

        //dd($Ko_Rkk);
        try
        {
            Tb_ang::Create([
                'Ko_Period' => Tahun(),
                'ko_unit1'  => kd_bidang(),
                'Ko_sKeg1'  => $request->Ko_sKeg1,
                'Ko_sKeg2'  => $request->Ko_sKeg2,
                'Ko_Rk1'    => $request->Ko_Rk1,
                'Ko_Rk2'    => $request->Ko_Rk2,
                'Ko_Rk3'    => $request->Ko_Rk3,
                'Ko_Rk4'    => $request->Ko_Rk4,
                'Ko_Rk5'    => $request->Ko_Rk5,
                'Ko_Rk6'    => $request->Ko_Rk6,
				'Ko_Rkk' 	=> $Ko_Rkk->Ko_Rkk,
                'Ur_Rc'     => $request->Ur_Rc,
            ]);
    
            Alert::success('Berhasil', "Akun berhasil ditambah");
    
            return redirect('kegiatan/program/subkegiatan/akun/'.$request->Ko_sKeg1.'-'.$request->Ko_sKeg2.'-'.$request->Ko_KegBL1);
            // return redirect('akun/'.$request->Ko_sKeg1.'-'.$request->Ko_sKeg2.'-'.$request->Ko_KegBL1);
        }
        catch(Exception $e)
        {
            Alert::warning('Maaf', "Akun Sudah ditambah");
            return back();
        }
        
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
        $rules = [
            "Ko_Rk1" => "required",
        ];

        $messages = [
            "Ko_Rk1.required" => "Nomor Rekening wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Alert::warning('Gagal', "Nomor Rekening belum dipilih");
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
		
		$Ko_Rkk = collect(DB::select("SELECT CONCAT(LPAD(".$request->Ko_Rk1.",2,0),'.' ,LPAD(".$request->Ko_Rk2.",2,0),'.' ,LPAD(".$request->Ko_Rk3.",2,0),'.' ,LPAD(".$request->Ko_Rk4.",2,0),'.' ,LPAD(".$request->Ko_Rk5.",3,0),'.' ,LPAD(".$request->Ko_Rk6.",4,0)) AS Ko_Rkk"))->first();

        Tb_ang::where('id', $id)->update([
            'Ko_Rk1'    => $request->Ko_Rk1,
            'Ko_Rk2'    => $request->Ko_Rk2,
            'Ko_Rk3'    => $request->Ko_Rk3,
            'Ko_Rk4'    => $request->Ko_Rk4,
            'Ko_Rk5'    => $request->Ko_Rk5,
            'Ko_Rk6'    => $request->Ko_Rk6,
			'Ko_Rkk' 	=> $Ko_Rkk->Ko_Rkk,
            'Ur_Rc'     => $request->Ur_Rc,
        ]);

        Alert::success('Berhasil', "Akun berhasil diupdate");
        return redirect('kegiatan/program/subkegiatan/akun/'.$request->Ko_sKeg1.'-'.$request->Ko_sKeg2.'-'.$request->Ko_KegBL1);
    }

    public function destroy($id)
    {
        $dt = Tb_ang::find($id);
        
        // set variable
        $ctrl = count(DB::select(
            'SELECT * FROM tb_bprc WHERE Ko_Period = ? AND Ko_unit1 = ? AND Ko_sKeg1 = ? AND Ko_sKeg2 = ? AND Ko_Rkk = ?', [
                $dt->Ko_Period, $dt->ko_unit1, $dt->Ko_sKeg1, $dt->Ko_sKeg2, $dt->Ko_Rkk
            ]));
            
        // validate - cek apakah akun ada di tabel transaksi
        if($ctrl != 0):
            Alert::error('Perhatian', 'Tidak dapat menghapus, rincian akun sudah digunakan dalam transaksi');
            return back();
        else:
            $dt->delete();
            Alert::success('Berhasil', "Data berhasil dihapus");
            return back();
        endif;
    }
}
