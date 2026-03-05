<?php

namespace App\Http\Controllers\Transaksi\Belanja\Kontrak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap;
use App\Models\Tbcontr; 
use App\Models\Tbcontrc; 
use Illuminate\Support\Facades\Validator as FacadesValidator;
use RealRashid\SweetAlert\Facades\Alert;


class SubKontrakController extends Controller
{
    public function index()
    {
        $kontrak = Tbcontr::all();
        return view('transaksi.belanja.subkontrak.index', compact('kontrak'));
    }

    public function rincian($id)
    {
        // $kegiatan = Tbtap::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();

        $rincian = DB::select(DB::raw('select a.*, b.* 
            from tb_contr a
            join tb_contrc b 
            on a.id_contr = b.id_contr
            where b.Ko_Period="'.Tahun().'" AND b.Ko_unit1="'.kd_bidang().'" AND a.id_contr = "'.$id.'"'));
        // dd($rincian);
        return view('transaksi.belanja.subkontrak.rincian', compact( 'rincian','sumber','sumber2' ));
    }

    public function create($id_contr)
    {
        $data = Tbcontr::where('id_contr',$id_contr)->first();
        // dd($data);
        $Ko_Unit = Session::get('ko_unit1');
        $Period = Session::get('Ko_Period');
        $penerimaan = Tbbprc::all();
        $kegiatan = Tbtap::GROUPBY('Ko_Rkk')->get();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $PD = 1;

        $caridata = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",'.$PD.')');
        dd($caridata);
        $datafinal = collect($caridata);
        $max = Tbcontrc::where('Ko_Period', Tahun())
        ->where('id_contr', $data->id_contr)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_contrc');

        // belum ada filter jika Ko_Wil1 dan 2 sudah ada
        return view('transaksi.belanja.subkontrak.create', compact('penerimaan','sumber','sumber2','kegiatan', 'data', 'Ko_Unit', 'Period', 'max','datafinal'));
    }

    public function tambah($id_contr)
    {
        $data = Tbcontr::where('id_contr',$id_contr)->first();
        $Ko_Unit = Session::get('ko_unit1');
        $Period = Session::get('Ko_Period');
        $penerimaan = Tbbprc::all();
        $kegiatan = Tbtap::GROUPBY('Ko_Rkk')->get();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $PD = 1;

        $caridata = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",'.$PD.')');
        $datafinal = collect($caridata);
        $max = Tbcontrc::where('Ko_Period', Tahun())
        ->where('id_contr', $data->id_contr)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_contrc');

        // belum ada filter jika Ko_Wil1 dan 2 sudah ada
        return view('transaksi.belanja.subkontrak.create', compact('penerimaan','sumber','sumber2','kegiatan', 'data', 'Ko_Unit', 'Period', 'max','datafinal'));
    }

    public function store(Request $request)
    {
        $tb_ulog = 'user';
        $created_at = NOW();
        $updated_at = NOW();
        $rules = [
            "Ko_sKeg1" => "required",
            "Ko_sKeg2" => "required",
            "Ko_Rkk" => "required",
            "To_Rp" => "required",
          ];
      
          $messages = [
            "Ko_sKeg1.required" => "Uraian Program wajib diisi.",
            "Ko_sKeg2.required" => "Uraian Kegiatan Wajib Diisi",
            "Ko_Rkk.required" => "RKK wajib diisi.",
            "To_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = FacadesValidator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        //   dd($request);

        Tbcontrc::create([          
            'id_contr' => $request->id_contr,
            'Ko_Period' => $request->Ko_period,
            'Ko_unit1' => $request->Ko_unit1,      
            'No_contr' => $request->No_contr,
            'Ko_contrc' => $request->Ko_contrc,
            'Ko_sKeg1' => $request->Ko_sKeg1,
            'Ko_sKeg2' => $request->Ko_sKeg2,
            'Ko_Rkk' => $request->Ko_Rkk,
            'To_Rp' => inrupiah($request->To_Rp),
            'Tag' => 0,
            'tb_ulog' => $tb_ulog,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);
        
        Alert::success('Berhasil', "Data Berhasil Ditambah");
        return redirect()->route('subkontrak.rincian', $request->id_contr);
    }

    public function show($id)
    {

        $rincian = Tbbprc::where('id',$id)->get();
        return view('transaksi.belanja.subkontrak.show', compact('rincian'));
    }

    public function edit($id)
    {
        $data = Tbcontrc::where('id_contrc',$id)->first();
        $ko_skeg1 = Tbcontrc::where('id_contrc',$id)->value('ko_skeg1');
        $ko_skeg2 = Tbcontrc::where('id_contrc',$id)->value('ko_skeg2');
        $ko_rkk = Tbcontrc::where('id_contrc',$id)->value('ko_rkk');
        $caridata = DB::select('call vdata_btrans('.Tahun().', "'.kd_bidang().'",1)');
        $datafinal = collect($caridata);
        // $dt_view = collect($caridata)->where('ko_skeg1', $ko_skeg1)->where('ko_skeg2', $ko_skeg2)->where('ko_rkk', $ko_rkk)->first();
        $dt_view = collect($caridata)->where('ko_skeg1', $ko_skeg1)->where('ko_skeg2', $ko_skeg2)->first();
        // dd($dt_view);
        return view('transaksi.belanja.subkontrak.edit', compact('data','datafinal','dt_view'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "To_Rp" => "required",
          ];
      
          $messages = [
            "To_Rp.required" => "Uraian Program wajib diisi.",
          ];
          $validator = FacadesValidator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
  
        Tbcontrc::where('id_contrc', $id)->update([
            'To_Rp' => inrupiah($request->To_Rp),
            'updated_at' => NOW()
        ]);
        $id = Tbcontrc::where('id_contrc', $id)->value('id_contr');
        Alert::success('Berhasil', "Data Berhasil Diubah");
        return redirect()->route('subkontrak.rincian', $id);
    }

    public function destroy($id)
    {
        $idbp = Tbcontrc::select('id_contr')->where('id_contrc',$id)->first();
        $contrc = Tbcontrc::where('id_contrc',$id);
        $contrc->delete();
        Alert::success('Berhasil', "Data Rincian Kontrak berhasil Dihapus");

        return redirect()->route('subkontrak.rincian', $idbp->id_contr);
    }
}
