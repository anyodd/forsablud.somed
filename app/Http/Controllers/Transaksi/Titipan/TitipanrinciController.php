<?php

namespace App\Http\Controllers\Transaksi\Titipan;

use App\Models\Tbbprc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbbp;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TitipanrinciController extends Controller
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
            'id_bp'       => 'required',
            'Ko_Period'   => 'required',
            'Ko_unit1'    => 'required',
            'No_bp'       => 'required',
            'Ko_bprc'     => 'required',
            'Ur_bprc'     => 'required',
            'rftr_bprc'   => 'required',
            'dt_rftrbprc' => 'required',
            'No_PD'       => 'required',
            'sKo_sKeg1'   => 'required',
            'sKo_sKeg2'   => 'required',
            'Ko_Rkk'      => 'required',
            'To_Rp'       => 'required',
            'ko_kas'      => 'required',
        ]);

        Tbbprc::create([
            'id_bp'       => $request->id_bp,
            'Ko_Period'   => $request->Ko_Period,
            'Ko_unit1'    => $request->Ko_unit1,
            'No_bp'       => $request->No_bp,
            'Ko_bprc'     => $request->Ko_bprc,
            'Ur_bprc'     => $request->Ur_bprc,
            'rftr_bprc'   => $request->rftr_bprc,
            'dt_rftrbprc' => $request->dt_rftrbprc,
            'No_PD'       => $request->No_PD,
            'Ko_sKeg1'    => $request->sKo_sKeg1,
            'Ko_sKeg2'    => $request->sKo_sKeg2,
            'Ko_Rkk'      => $request->Ko_Rkk,
            'Ko_Pdp'      => '1',
            'ko_pmed'     => '99',
            'To_Rp'       => inrupiah($request->To_Rp),
            'ko_kas'      => $request->ko_kas,
            'Tag'         => '0',
            'tb_ulog'     => 'admin',
        ]);


        Alert::success('Berhasil', "Titipan Rinci berhasil ditambah");
        return redirect()->route('titipan.detail', $request->id_bp);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Tbbprc::find($id);
        $ide = Tbbprc::find($id)->value('id_bp');
        $tb_bp = Tbbp::find($ide);
        $kobank = DB::table('pf_bank')
            ->select('*')
            ->get();
        
        $kegiatan = DB::select('CALL SP_Anggaran_Pdpt("' . Tahun() . '", "' . kd_bidang() . '")'); 
        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('Ko_sKeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('Ko_sKeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('Ko_Rkk');
        $dt_view = collect($kegiatan)->where('ko_skeg1',$ko_skeg1)->where('ko_skeg2',$ko_skeg2)->where('ko_rkk', $ko_rkk)->first();
       
        return view('transaksi.titipanrinci.edit', compact('tb_bp', 'data', 'kobank', 'kegiatan','dt_view'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'No_bp'         => 'required',
            'Ur_bprc'       => 'required',
            'rftr_bprc'     => 'required',
            'dt_rftrbprc'   => 'required',
            'No_PD'         => 'required',
            'sKo_sKeg1'     => 'required',
            'sKo_sKeg2'     => 'required',
            'Ko_Rkk'        => 'required',
            'To_Rp'         => 'required',
            'ko_kas'        => 'required',
        ]);

        Tbbprc::where('id_bprc', $id)->update([
            'Ko_Period'     => Tahun(),
            'Ko_unit1'      => kd_bidang(),
            'No_bp'         => $request->No_bp,
            'Ur_bprc'       => $request->Ur_bprc,
            'rftr_bprc'     => $request->rftr_bprc,
            'dt_rftrbprc'   => $request->dt_rftrbprc,
            'No_PD'         => $request->No_PD,
            'Ko_sKeg1'      => $request->sKo_sKeg1,
            'Ko_sKeg2'      => $request->sKo_sKeg2,
            'Ko_Rkk'        => $request->Ko_Rkk,
            'To_Rp'         => inrupiah($request->To_Rp),
            'ko_kas'        => $request->ko_kas,
        ]);

        Alert::success('Berhasil', "Titipan Rinci berhasil dirubah");
        return redirect()->route('titipan.detail', $request->id_bp);
    }

    public function destroy($id)
    {
        $data = Tbbprc::find($id);
        $data->delete();
        Alert::success('Berhasil', "Data berhasil dihapus");
        return Redirect()->route('titipan.detail',$data->id_bp);
    }
}
