<?php

namespace App\Http\Controllers\Transaksi\Pembiayaan;

use App\Models\Tbbprc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbbp;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPSTORM_META\type;

class PembiayaanrinciController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_bp'     => 'required',
            'Ko_Period' => 'required',
            'Ko_unit1'  => 'required',
            'No_bp'     => 'required',
            'Ko_bprc'   => 'required',
            'Ur_bprc'   => 'required',
            'rftr_bprc' => 'required',
            'dt_rftrbprc' => 'required',
            'No_PD'     =>'required',
            'sKo_sKeg1' => 'required',
            'sKo_sKeg2' => 'required',
            'Ko_Rkk'    => 'required',
            'ur_skeg'   => 'required',
            'To_Rp'     => 'required',
            'ko_kas'    => 'required',
        ]);

        Tbbprc::create([
            'id_bp'         => $request->id_bp,
            'Ko_Period'     => $request->Ko_Period,
            'Ko_unit1'      => $request->Ko_unit1,
            'No_bp'         => $request->No_bp,
            'Ko_bprc'       => $request->Ko_bprc,
            'Ur_bprc'       => $request->Ur_bprc,
            'rftr_bprc'     => $request->rftr_bprc,
            'dt_rftrbprc'   => $request->dt_rftrbprc,
            'No_PD'         => $request->No_PD,
            'Ko_sKeg1'      => $request->sKo_sKeg1,
            'Ko_sKeg2'      => $request->sKo_sKeg2,
            'Ko_Rkk'        => $request->Ko_Rkk,
            'Ko_Pdp'        => '1',
            'ko_pmed'       => '99',
            'To_Rp'         => $request->To_Rp,
            'ko_kas'        => $request->ko_kas,
            'Tag'           => '0',
            'tb_ulog'       => 'admin',
        ]);

        Alert::success('Berhasil', "Pembiayaan Rinci berhasil ditambah");
        return redirect()->route('pembiayaan.detail', $request->id_bp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_bp = Tbbprc::find($id)->value('id_bp');
        $tb_bp = Tbbp::find($id_bp);
        $kobank = DB::table('pf_bank')
                ->select('*')
                ->get();
        $n = Tbbprc::where(['id_bprc' =>$id_bp])->value('id_bp');
        $type = Tbbp::where(['id_bp' =>$n])->value('Ko_bp');
        if ($type == 6) { $type = 1; } else { $type = 2; }
        $kegiatan = DB::select('CALL vdata_pbtrans("' . Tahun() . '", "' . kd_bidang() . '", "'.$type.'")'); 
        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('Ko_sKeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('Ko_sKeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('Ko_Rkk');
        $dt_view = collect($kegiatan)->where('ko_skeg1',$ko_skeg1)->where('ko_skeg2',$ko_skeg2)->first();
        
        $data = Tbbprc::find($id);
        return view('transaksi.pembiayaanrinci.edit', compact('tb_bp','kobank','kegiatan','data','dt_view'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_bp'     => 'required',
            'Ko_Period' => 'required',
            'Ko_unit1'  => 'required',
            'No_bp'     => 'required',
            'Ko_bprc'   => 'required',
            'Ur_bprc'   => 'required',
            'rftr_bprc' => 'required',
            'dt_rftrbprc' => 'required',
            'No_PD'     =>'required',
            'sKo_sKeg1' => 'required',
            'sKo_sKeg2' => 'required',
            'Ko_Rkk'    => 'required',
            'ur_skeg'   => 'required',
            'To_Rp'     => 'required',
            'ko_kas'    => 'required',
        ]);

        Tbbprc::where('id_bprc',$id)->update([
            'No_bp'         => $request->No_bp,
            'Ko_bprc'       => $request->Ko_bprc,
            'Ur_bprc'       => $request->Ur_bprc,
            'rftr_bprc'     => $request->rftr_bprc,
            'dt_rftrbprc'   => $request->dt_rftrbprc,
            'No_PD'         => $request->No_PD,
            'Ko_sKeg1'      => $request->sKo_sKeg1,
            'Ko_sKeg2'      => $request->sKo_sKeg2,
            'Ko_Rkk'        => $request->Ko_Rkk,
            'To_Rp'         => $request->To_Rp,
            'ko_kas'        => $request->ko_kas,
        ]);

        Alert::success('Berhasil', "Pembiayaan Rinci berhasil dirubah");
        return redirect()->route('pembiayaan.detail', $request->id_bp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idn = Tbbprc::where('id_bprc', $id)->value('id_bp');
        $dt = Tbbprc::where('id_bprc',$id);
        $dt->delete();
        Alert::success('Berhasil', "Pembiayaan Rinci berhasil dihapus");
        return redirect()->route('pembiayaan.detail', $idn);
    }
}
