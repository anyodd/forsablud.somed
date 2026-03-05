<?php

namespace App\Http\Controllers\Pembukuan\Saldoawal;

use App\Http\Controllers\Controller;
use App\Models\Tbsopiut;
use App\Models\Tbtap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SopiutController extends Controller
{
    public function index()
    {
        $data = DB::select(DB::raw("SELECT a.*,b.ur_rk6 ur_rkk FROM tb_sopiut a
                LEFT JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
                WHERE a.Ko_Period = '".Tahun()."' && a.Ko_unit1 = '".kd_bidang()."'
                ORDER BY a.dt_piut DESC"));
        return view('pembukuan.saldopiutang.index',compact('data'));
    }

    public function create()
    {
        // $rekening = DB::select(DB::raw("SELECT Ko_Rkk rkk, Ur_Rk6 ur_rkk FROM pf_rk6 WHERE Ko_Rk1=1 && Ko_Rk2=1 && Ko_Rk3=6 && Ko_Rk4=16"));
        $rekening = DB::select(DB::raw("SELECT Ko_Rkk rkk, Ur_Rk6 ur_rkk FROM pf_rk6 WHERE LEFT(Ko_RKK,11) IN('01.01.06.16','01.01.06.18') ORDER BY Ko_RKK"));
        $max = Tbtap::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->max('id_tap');
        // $datafinal = DB::select(DB::raw('SELECT * FROM tb_tap a WHERE a Ko_Period = "'.Tahun().'" && ko_unit1 = "'.kd_bidang().'" && id_tap = "'.$max.'"'));
        $datafinal = DB::select(DB::raw('SELECT *,SUM(a.To_Rp) total FROM tb_tap a WHERE a.Ko_Period = "'.Tahun().'" && a.ko_unit1 = "'.kd_bidang().'" && a.id_tap = "'.$max.'"
        GROUP BY a.Ko_Period,a.ko_unit1,a.Ko_sKeg1,a.Ko_sKeg2,a.Ko_Rkk'));
        return view('pembukuan.saldopiutang.create',compact('rekening','datafinal'));
    }

    public function store(Request $request)
    {
        $rules = [
            'Ko_sKeg1'  => 'required',
            'Ko_sKeg2'  => 'required',
            'piut_doc'  => 'required',
            'dt_piut'   => 'required',
            'piut_ur'   => 'required',
            'piut_nm'   => 'required',
            'piut_addr' => 'required',
            'Ko_Rkk'    => 'required',
            'piut_Rp'   => 'required',
        ];
      
        $messages = [
            'Ko_sKeg1.required'  => 'uraian program wajib diisi.',
            'Ko_sKeg2.required'  => 'uraian kegiatan wajib diisi.',
            'piut_doc.required'  => 'nomor wajib diisi.',
            'dt_piut.required'   => 'tanggal wajib diisi.',
            'piut_ur.required'   => 'uraian piutang wajib diisi.',
            'piut_nm.required'   => 'nama wajib diisi.',
            'piut_addr.required' => 'alamat wajib diisi.',
            'Ko_Rkk.required'    => 'rekening wajib diisi.',
            'piut_Rp.required'   => 'nilai wajib diisi.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
       
        $cek = DB::select('SELECT * FROM tb_sopiut WHERE Ko_Period = "'.Tahun().'" && LEFT(Ko_unit1,18) =  "'.kd_unit().'" && piut_doc = "'.$request->piut_doc.'"');
        if (empty($cek)) {
            Tbsopiut::create([
                'Ko_sKeg1'   => $request->Ko_sKeg1,
                'Ko_sKeg2'   => $request->Ko_sKeg2,
                'Ko_Period'  => Tahun(),
                'Ko_unit1'   => kd_bidang(),
                'piut_doc'   => $request->piut_doc,
                'dt_piut'    => $request->dt_piut,
                'piut_ur'    => $request->piut_ur,
                'piut_nm'    => $request->piut_nm,
                'piut_addr'  => $request->piut_addr,
                'Ko_Rkk'     => $request->Ko_Rkk,
                'piut_Rp'    => inrupiah($request->piut_Rp),
                'Tag'        => '0',
                'tb_ulog'    => getUser('username'),
                'created_at' => now(),
            ]);
            Alert::success('Berhasil', 'Data berhasil ditambah');
        } else {
            Alert::warning('Gagal', 'Nomor dokumen sudah ada !');
        }
        return redirect()->route('saldoawalpiutang.index');
      
          
          
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Tbsopiut::find($id);
        $rekening = DB::select(DB::raw("SELECT Ko_Rkk rkk, Ur_Rk6 ur_rkk FROM pf_rk6 WHERE Ko_Rk1=1 && Ko_Rk2=1 && Ko_Rk3=6 && Ko_Rk4=16"));
        $max = Tbtap::where('Ko_Period', Tahun())->where('ko_unit1', kd_bidang())->max('id_tap');
        $datafinal = DB::select(DB::raw('SELECT *,SUM(a.To_Rp) total FROM tb_tap a WHERE a.Ko_Period = "'.Tahun().'" && a.ko_unit1 = "'.kd_bidang().'" && a.id_tap = "'.$max.'"
        GROUP BY a.Ko_Period,a.ko_unit1,a.Ko_sKeg1,a.Ko_sKeg2,a.Ko_Rkk'));
        $kegiatan = collect($datafinal)->where('Ko_sKeg1',$data->Ko_sKeg1)->where('Ko_sKeg2',$data->Ko_sKeg2)->first();
        $rek = collect($rekening)->where('rkk',$data->Ko_Rkk)->first();
        return view('pembukuan.saldopiutang.edit',compact('rekening','max','datafinal','data','kegiatan','rek'));
    }

    public function update(Request $request, $id)
    {
        Tbsopiut::where('id',$id)->update([
            'Ko_sKeg1'   => $request->Ko_sKeg1,
            'Ko_sKeg2'   => $request->Ko_sKeg2,
            'piut_doc'   => $request->piut_doc,
            'dt_piut'    => $request->dt_piut,
            'piut_ur'    => $request->piut_ur,
            'piut_nm'    => $request->piut_nm,
            'piut_addr'  => $request->piut_addr,
            'Ko_Rkk'     => $request->Ko_Rkk,
            'piut_Rp'    => inrupiah($request->piut_Rp),
            'tb_ulog'    => getUser('username'),
            'updated_at'=> now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil dirubah');
        return redirect()->route('saldoawalpiutang.index');
    }

    public function destroy($id)
    {
        $data = Tbsopiut::where('id',$id);
        $data->delete();
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('saldoawalpiutang.index');
    }
}
