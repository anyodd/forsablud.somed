<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\STS;

use App\Models\Tbstsrc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbbyr;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class StsrcController extends Controller
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
        $idrc = explode(',',$request->id_rc);
        $rincian = Tbbyr::where(['Ko_Period'=> Tahun(), 'Ko_unitstr' => kd_unit()])->get();
        $dt_rc = collect($rincian)->whereIn('id_byr',$idrc);

        $max = Tbstsrc::where('id_sts', $request->id_sts)->max('Ko_stsrc');
        if ($max != NULL) {
            $kostsrc = $max + 1;
        } else {
            $kostsrc = 1;
        }

        foreach ($dt_rc as $key => $value) {
            Tbstsrc::create([
              'id_sts'     => $request->id_sts,
              'Ko_Period'  => Tahun(),
              'Ko_unitstr' => kd_unit(),
              'No_sts'     => $request->No_sts,
              'Ko_stsrc'   => $kostsrc++,
              'No_byr'     => $value->No_byr,
              'tb_ulog'    => getUser('username'),
              'Tag'        => 0,
            ]);
        }

        // $request->validate([
        //     'No_byr'        => 'required',
        // ]);

        // Tbstsrc::Create([
        //     'id_sts' => $request->id_sts,
        //     'Ko_Period' => Tahun(),
        //     'Ko_unitstr' => kd_unit(),
        //     'No_sts' => $request->No_sts,
        //     'Ko_stsrc' => $request->Ko_stsrc,
        //     'No_byr' => $request->No_byr,
        //     'tb_ulog' => 'admin',
        //     'Tag' => 0,
        // ]);

        Alert::success('Berhasil', "Rincian STS berhasil ditambah");
        return redirect()->route('sts.detail', $request->id_sts);
    }
    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        // $stsdetail = Tbstsrc::where('id_sts', $tb_sts_id)->get();
        // $id_sts = Tbsts::where('id_sts', $tb_sts_id)->value('id_sts');
        // $Ko_Period = Tahun();
        // $Ko_unitstr = kd_unit();
        // $No_sts = Tbsts::find($tb_sts_id);

        // $max = Tbstsrc::where('id_sts', $tb_sts_id)->max('Ko_stsrc');

        $stsrinci = Tbstsrc::where('id_stsrc', $id)->first();

        $nobayar = DB::table('tb_byr')
                    ->join('tb_bp', function($join){
                        $join->on('tb_byr.No_bp', '=', 'tb_bp.No_bp');
                    })->where(['tb_bp.Ko_bp' => 1,'tb_bp.Ko_Period' => Tahun(), 'tb_bp.Ko_unit1' => kd_bidang()])
                    ->get();    
        
        return view('transaksi.penerimaan.stsrinci.edit',compact('stsrinci','nobayar'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'No_byredit'        => 'required',
        ]);

        try {
            Tbstsrc::where('id_stsrc', $id)->update([
                'No_byr' => $request->No_byredit,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }
        $id = Tbstsrc::where('id_stsrc',$id)->value('id_sts');
        Alert::success('Berhasil', "STS $request->No_sts berhasil di ubah");
        return redirect()->route('sts.detail', $id);
    }

    public function destroy($stsrinci)
    {
        $id = Tbstsrc::where('id_stsrc',$stsrinci)->value('id_sts');

        Tbstsrc::where('id_stsrc', $stsrinci)->delete();
        Alert::success('Berhasil', "Rinsian STS: berhasil dihapus");
        return redirect()->route('sts.detail', $id);
    }
}
