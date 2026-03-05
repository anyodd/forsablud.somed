<?php

namespace App\Http\Controllers\Pembukuan\Saldoawal;

use App\Http\Controllers\Controller;
use App\Models\Tbsouta;
use App\Models\Tbtap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SoutaController extends Controller
{
    public function index()
    {
        // $data = Tbsouta::where(['Ko_Period' => Tahun(), 'Ko_unit1' => kd_bidang()])->get();
        $maxko = Tbtap::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->max('Ko_Tap');
        $maxid = Tbtap::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->where('Ko_Tap', $maxko)->max('Id_tap');
        $data = DB::select('SELECT a.*, b.Ur_KegBL1 ur_keg, c.Ur_Rk6 ur_rkk FROM tb_souta a
                LEFT JOIN tb_tap b ON a.Ko_sKeg1 = b.Ko_sKeg1 && a.Ko_sKeg2 = b.Ko_sKeg2
                LEFT JOIN pf_rk6 c ON a.Ko_Rkk = c.Ko_RKK
                WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'" && b.Ko_Tap = "'.$maxko.'" && b.Id_tap = "'.$maxid.'"
                GROUP BY a.id');
     
        $kegiatan = DB::select(DB::raw('SELECT *,SUM(a.To_Rp) total FROM tb_tap a WHERE a.Ko_Period = "'.Tahun().'" && a.ko_unit1 = "'.kd_bidang().'" && a.Ko_Tap = "'.$maxko.'" && a.id_tap = "'.$maxid.'"
        GROUP BY a.Ko_Period,a.ko_unit1,a.Ko_sKeg1,a.Ko_sKeg2,a.Ko_Rkk'));
        $rekening = DB::select(DB::raw("SELECT Ko_RKK AS rkk, ur_rk6 ur_rkk FROM pf_rk6
        WHERE Ko_Rk1 = 02 && Ko_Rk2 = 01"));

        $rekan = DB::select("SELECT * FROM tb_rekan WHERE Ko_unitstr = '".kd_unit()."'");

        return view('pembukuan.saldoutang.index',compact('data','kegiatan','rekening','rekan'));
    }

 
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $cek  = DB::select('SELECT * FROM tb_souta WHERE Ko_Period = "'.Tahun().'" && LEFT(Ko_unit1,18) =  "'.kd_unit().'" && uta_doc = "'.$request->uta_doc.'"');
        $data = explode("|",$request->uta_nm);
  
        if (empty($cek)) {
            Tbsouta::create([
                'Ko_Period' => Tahun(),
                'Ko_unit1'  => kd_bidang(),
                'uta_doc'   => $request->uta_doc,
                'dt_uta'    => $request->dt_uta,
                'jt_uta'    => $request->jt_uta,
                'uta_ur'    => $request->uta_ur,
                'id_rekan'  => $data[0],
                'uta_nm'    => $data[1],
                'uta_addr'  => $data[2],
                'Ko_sKeg1'  => $request->Ko_sKeg1,
                'Ko_sKeg2'  => $request->Ko_sKeg2,
                'Ko_Rkk'    => $request->Ko_Rkk,
                'uta_Rp'    => inrupiah($request->uta_Rp),
                'Tag'       => '0',
                'tb_ulog'   => getUser('username'),
                'created_at'=> now(),
            ]);
            Alert::success('Berhasil', 'Data berhasil ditambah');
        } else {
            Alert::warning('Gagal', 'Nomor dokumen sudah ada !');
        }
          return redirect()->route('saldoawalutang.index');
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
        $data = explode("|",$request->uta_nm);
        Tbsouta::where('id',$id)->update([
            'uta_doc'   => $request->uta_doc,
            'dt_uta'    => $request->dt_uta,
            'jt_uta'    => $request->jt_uta,
            'uta_ur'    => $request->uta_ur,
            'id_rekan'  => $data[0],
            'uta_nm'    => $data[1],
            'uta_addr'  => $data[2],
            'Ko_sKeg1'  => $request->Ko_sKeg1,
            'Ko_sKeg2'  => $request->Ko_sKeg2,
            'Ko_Rkk'    => $request->Ko_Rkk,
            'uta_Rp'    => inrupiah($request->uta_Rp),
            'updated_at'=> now(),
        ]);
        
        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->route('saldoawalutang.index');
    }

    public function destroy($id)
    {
        $data = Tbsouta::where('id',$id);
        $data->delete();
        
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('saldoawalutang.index');
    }
}
