<?php

namespace App\Http\Controllers\Pembukuan;

use App\Models\Jrsesuai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbspirc;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PenyesuaianrinciController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Sesuai_Rp'  => 'required',
            'Ko_DK'      => 'required',
        ]);

        $Rp = inrupiah($request->Sesuai_Rp);

        if ($request->Ko_DK == 'D') {
            $Rp_D = $Rp;
            $Rp_K = '';
        } else { 
            $Rp_K = $Rp;
            $Rp_D = '';
        }

        Jrsesuai::create([
            'id_tbses'    => $request->id_tbses,
            'Ko_Period'   => Tahun(),
            'Ko_unitstr'  => kd_bidang(),
            'Sesuai_No'   => $request->Sesuai_No,
            'dt_sesuai'   => $request->dt_sesuai,
            'No_bp'       => $request->No_bp,
            'Ko_bprc'     => $request->Ko_bprc,
            'Ko_sKeg1'    => $request->Ko_sKeg1,
            'Ko_sKeg2'    => $request->Ko_sKeg2,
            'Ko_Rkk'      => $request->Ko_Rkk,
            'Rp_D'        => $Rp_D,
            'Rp_K'        => $Rp_K,
            'Ko_DK'       => $request->Ko_DK,
            'Tag'         => '0',
            'tb_ulog'     => getUser('username'),
        ]);

        $data  = DB::select(DB::raw('SELECT SUM(Rp_D - Rp_K) rupiah FROM jr_sesuai WHERE id_tbses = "'.$request->id_tbses.'" GROUP BY id_tbses'));
        if ($data[0]->rupiah != 0) {
            Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                'Tag' => '0',
            ]);
        } else {
            Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                'Tag' => '1',
            ]);
        }
		
        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect()->route('penyesuaian.detail',$request->id_tbses);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $rekening  = DB::select(DB::raw('SELECT * FROM pf_rk6'));
        $transaksi = Tbspirc::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit()])->orderBy('dt_rftrbprc','DESC')->get();
        $data = Jrsesuai::where('id_jr',$id)->first();
        return view('pembukuan.penyesuaiandetail.edit',compact('rekening','transaksi','data'));
    }

    public function update(Request $request, $id)
    {
        if ($request->Ko_DK == 'D') {
            $Rp_D = inrupiah($request->Rp_D);
            $Rp_K = '';
        } else { 
            $Rp_K = inrupiah($request->Rp_K);
            $Rp_D = '';
        }

        Jrsesuai::where('id_jr',$id)->update([
            'No_bp'       => $request->No_bp,
            'Ko_bprc'     => $request->Ko_bprc,
            'Ko_sKeg1'    => $request->Ko_sKeg1,
            'Ko_sKeg2'    => $request->Ko_sKeg2,
            'Ko_Rkk'      => $request->Ko_Rkk,
            'Rp_D'        => $Rp_D,
            'Rp_K'        => $Rp_K,
            'Tag'         => '0',
            'tb_ulog'     => getUser('username'),
        ]);

        $data  = DB::select(DB::raw('SELECT SUM(Rp_D - Rp_K) rupiah FROM jr_sesuai WHERE id_tbses = "'.$request->id_tbses.'" GROUP BY id_tbses'));
        if ($data[0]->rupiah != 0) {
            Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                'Tag' => '0',
            ]);
        } else {
            Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                'Tag' => '1',
            ]);
        }

        Alert::success('Berhasil', "Data berhasil diedit");
        return redirect()->route('penyesuaian.detail',$request->id_tbses);

    }

    public function destroy($id,Request $request)
    {
        $data  = DB::select(DB::raw('SELECT SUM(Rp_D - Rp_K) rupiah FROM jr_sesuai WHERE id_tbses = "'.$request->id_tbses.'" GROUP BY id_tbses'));
        if ($data[0]->rupiah != '') {
            if ($data[0]->rupiah != 0) {
                Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                    'Tag' => '0',
                ]);
            } else {
                Jrsesuai::where('id_tbses', $request->id_tbses)->update([
                    'Tag' => '1',
                ]);
            }
            $jrsesuai = Jrsesuai::where('id_jr',$id)->first();
            $jrsesuai->delete();

            Alert::success('Berhasil', "Data berhasil dihapus");
            return redirect()->route('penyesuaian.detail',$request->id_tbses);
        } else {
            Alert::success('Berhasil', "Data berhasil dihapus");
            return redirect()->route('penyesuaian.detail',$request->id_tbses);
        }
    }
}
