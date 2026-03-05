<?php

namespace App\Http\Controllers\Pembukuan\Saldoawal;

use App\Models\Soaw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Soawlp;
use RealRashid\SweetAlert\Facades\Alert;
use Svg\Tag\Rect;

class SoawController extends Controller
{
    public function index()
    {
        $saldo = DB::select(DB::raw("SELECT a.*, b.Ur_Rk5 FROM tb_soaw a
            LEFT JOIN pf_rk5 b ON a.ko_rkk5 = b.ko_rek5
            WHERE a.Ko_Period = ".Tahun()." AND a.Ko_unitstr = '".kd_unit()."' AND LEFT(a.ko_rkk5,2) IN (01,02,03)"));
        
        $debet  = collect($saldo)->sum('soaw_Rp_D');
        $kredit = collect($saldo)->sum('soaw_Rp_K');

        $rkk5 = DB::select(DB::raw("SELECT * FROM pf_rk5 WHERE Ko_Rk1 IN (01,02,03)"));

        return view('pembukuan.saldoawal.index', compact('saldo', 'rkk5','debet','kredit'));
    }

    public function lo()
    {
        $saldo = DB::select(DB::raw("SELECT a.*, b.Ur_Rk5 FROM tb_soaw a
            LEFT JOIN pf_rk5 b ON a.ko_rkk5 = b.ko_rek5
            WHERE a.Ko_Period = ".Tahun()." AND a.Ko_unitstr = '".kd_unit()."' AND LEFT(a.ko_rkk5,2) IN (07,08)"));
        
        $debet  = collect($saldo)->sum('soaw_Rp_D');
        $kredit = collect($saldo)->sum('soaw_Rp_K');

        $rkk5 = DB::select(DB::raw("SELECT * FROM pf_rk5 WHERE Ko_Rk1 IN (07,08)"));

        return view('pembukuan.saldoawal.lo', compact('saldo', 'rkk5','debet','kredit'));
    }

    public function lra()
    {
        $saldo = DB::select(DB::raw("SELECT a.*, b.Ur_Rk5 FROM tb_soaw a
            LEFT JOIN pf_rk5 b ON a.ko_rkk5 = b.ko_rek5
            WHERE a.Ko_Period = ".Tahun()." AND a.Ko_unitstr = '".kd_unit()."' AND LEFT(a.ko_rkk5,2) IN (04,05,06)"));
        
        $debet  = collect($saldo)->sum('soaw_Rp_D');
        $kredit = collect($saldo)->sum('soaw_Rp_K');

        $rkk5 = DB::select(DB::raw("SELECT * FROM pf_rk5 WHERE Ko_Rk1 IN (04,05,06)"));

        return view('pembukuan.saldoawal.lra', compact('saldo', 'rkk5','debet','kredit'));
    }

    public function lpsal()
    {
        $pf_lpsal = DB::select("SELECT * FROM pf_lpsal a
                    WHERE a.id NOT IN(SELECT b.Ko_id FROM tb_soawlp b WHERE b.Ko_Period = '".Tahun()."' 
                    && b.Ko_unitstr = '".kd_unit()."' && b.Ko_lp = 1)");

        $data = DB::select("SELECT * FROM tb_soawlp a
                LEFT JOIN pf_lpsal b ON a.Ko_id = b.id
                WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unitstr = '".kd_unit()."' && a.Ko_lp = 1 
                ORDER BY b.id ASC");

        return view('pembukuan.saldoawal.lpsal',compact('pf_lpsal','data'));
    }

    public function store_lpsal(Request $request)
    {
        Soawlp::create([
            'Ko_Period' => Tahun(),
            'Ko_unitstr' => kd_unit(),
            'Ko_lp' => 1,
            'Ko_id' => $request->Ko_id,
            'soaw_Rp' => inrupiah($request->soaw_Rp),
        ]);
        Alert::success('Berhasil', "Data Berhasil Disimpan");
        return redirect('saldoawal/lpsal');
    }

    public function delete_lpsal($id)
    {
        $data = Soawlp::where('id_soawlp',$id)->first();
        $data->delete();

        Alert::success('Berhasil', "Data Berhasil Dihapus");
        return redirect('saldoawal/lpsal');
    }

    public function lpe()
    {
        $pf_lpe = DB::select("SELECT * FROM pf_lpe a
                    WHERE a.id NOT IN(SELECT b.Ko_id FROM tb_soawlp b WHERE b.Ko_Period = '".Tahun()."' 
                    && b.Ko_unitstr = '".kd_unit()."' && b.Ko_lp = 2)");

        $data = DB::select("SELECT * FROM tb_soawlp a
                LEFT JOIN pf_lpe b ON a.Ko_id = b.id
                WHERE a.Ko_Period = '".Tahun()."' && Ko_unitstr = '".kd_unit()."' && a.Ko_lp = 2 
                ORDER BY b.id ASC");

        return view('pembukuan.saldoawal.lpe',compact('pf_lpe','data'));
    }

    public function store_lpe(Request $request)
    {
        Soawlp::create([
            'Ko_Period' => Tahun(),
            'Ko_unitstr' => kd_unit(),
            'Ko_lp' => 2,
            'Ko_id' => $request->Ko_id,
            'soaw_Rp' => inrupiah($request->soaw_Rp),
        ]);
        Alert::success('Berhasil', "Data Berhasil Disimpan");
        return redirect('saldoawal/lpe');
    }

    public function delete_lpe($id)
    {
        $data = Soawlp::where('id_soawlp',$id)->first();
        $data->delete();

        Alert::success('Berhasil', "Data Berhasil Dihapus");
        return redirect('saldoawal/lpe');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ko_rkk5'  => 'required',
            'soaw_Rp'  => 'required',
        ]);

        $soaw_Rp = inrupiah($request->soaw_Rp);
        $rk   = substr($request->Ko_rkk5,0,2);
        $rk_1 = substr($request->Ko_rkk5,0,11);
        $rk_6 = substr($request->Ko_rkk5,0,5);

        if (in_array($rk,['05','08'])) {
            if ($soaw_Rp < 0) {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            } else {
                $rp_d = $soaw_Rp;
                $rp_k = '';
            }
        } elseif($rk == '01') {
            if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.03.07.02','01.03.07.03','01.05.05.01','01.05.06.01','01.04.03.03','01.03.03.03'])) {
                if ($soaw_Rp < 0) {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                } else {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                }
            } else {
                if ($soaw_Rp < 0) {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                } else {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                }
            }
        } elseif($rk == '06') {
            if ($rk_6 == '06.02') {
                if ($soaw_Rp < 0) {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                } else {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                }
            } else {
                if ($soaw_Rp < 0) {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                } else {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                }
            }
        } elseif($rk == '03') {
            if ($soaw_Rp < 0) {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            } else {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            }
        } else {
            if ($soaw_Rp < 0) {
                $rp_d = $soaw_Rp;
                $rp_k = '';
            } else {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            }
        }

        try {
            Soaw::Create([
                'Ko_Period'  => Tahun(),
                'Ko_unitstr' => kd_unit(),
                'ko_rkk5'    => $request->Ko_rkk5,
                'soaw_Rp'    => $soaw_Rp,
                'soaw_Rp_D'  => $rp_d,
                'soaw_Rp_K'  => $rp_k,
                'Tag'        => $request->Tag,
                'tb_ulog'    => getUser('username'),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $e->getMessage();
            if (in_array($rk,['01','02','03'])) {
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal');
            }elseif(in_array($rk,['07','08'])){
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal/lo');
            }else{
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal/lra');
            }
        }

        Alert::success('Berhasil', "Saldo berhasil ditambah");
        if (in_array($rk,['01','02','03'])) {
            return redirect('saldoawal');
        }elseif(in_array($rk,['07','08'])){
            return redirect('saldoawal/lo');
        }else{
            return redirect('saldoawal/lra');
        }
        
    }

    public function show(Soaw $soaw)
    {
        //
    }

    public function edit($id)
    {
       //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Ko_rkk5'  => 'required',
            'soaw_Rp'  => 'required',
        ]);

        $soaw_Rp = inrupiah($request->soaw_Rp);
        $rk   = substr($request->Ko_rkk5,0,2);
        $rk_1 = substr($request->Ko_rkk5,0,11);
        $rk_6 = substr($request->Ko_rkk5,0,5);

        if (in_array($rk,['05','08'])) {
            if ($soaw_Rp < 0) {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            } else {
                $rp_d = $soaw_Rp;
                $rp_k = '';
            }
        } elseif($rk == '01') {
            if (in_array($rk_1,['01.01.10.01','01.03.07.01','01.03.07.02','01.03.07.03','01.05.05.01','01.05.06.01','01.04.03.03','01.03.03.03'])) {
                if ($soaw_Rp < 0) {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                } else {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                }
            } else {
                if ($soaw_Rp < 0) {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                } else {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                }
            }
        } elseif($rk == '06') {
            if ($rk_6 == '06.02') {
                if ($soaw_Rp < 0) {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                } else {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                }
            } else {
                if ($soaw_Rp < 0) {
                    $rp_d = $soaw_Rp;
                    $rp_k = '';
                } else {
                    $rp_d = '';
                    $rp_k = $soaw_Rp;
                }
            }
        } elseif($rk == '03') {
            if ($soaw_Rp < 0) {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            } else {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            }
        } else {
            if ($soaw_Rp < 0) {
                $rp_d = $soaw_Rp;
                $rp_k = '';
            } else {
                $rp_d = '';
                $rp_k = $soaw_Rp;
            }
        }


        try {
            Soaw::where('id',$id)->update([
                'ko_rkk5'    => $request->Ko_rkk5,
                'soaw_Rp'    => $soaw_Rp,
                'soaw_Rp_D'  => $rp_d,
                'soaw_Rp_K'  => $rp_k,
                'Tag'        => $request->Tag,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $e->getMessage();
            if (in_array($rk,['01','02','03'])) {
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal');
            }elseif(in_array($rk,['07','08'])){
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal/lo');
            }else{
                Alert::warning('Gagal', "Kode Akun Sudah Ada");
                return redirect('saldoawal/lra');
            }
        }

        Alert::success('Berhasil', "Saldo berhasil diubah");
        if (in_array($rk,['01','02','03'])) {
            return redirect('saldoawal');
        }elseif(in_array($rk,['07','08'])){
            return redirect('saldoawal/lo');
        }else{
            return redirect('saldoawal/lra');
        }
    }

    public function destroy($saldoawal)
    {
        $sawal = Soaw::find($saldoawal);
        $sawal->delete();

        Alert::success('Berhasil', "Penyesuaian berhasil dihapus");
        return back();
    }
}
