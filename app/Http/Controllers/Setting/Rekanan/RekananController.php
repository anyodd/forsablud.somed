<?php

namespace App\Http\Controllers\Setting\Rekanan;

use App\Http\Controllers\Controller;
use App\Models\Tbrekan;
use App\Models\Pfusaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class RekananController extends Controller
{
    public function index()
    {
        $rekanan =  COLLECT(DB::select("select distinct a.*, b.ur_usaha, case when c.nm_BUcontr is null then 1 else 0 end as kode from tb_rekan a 
                        left join pf_usaha b on a.ko_usaha = b.ko_usaha 
                        left join  tb_bp c On a.id_rekan=c.nm_BUcontr
                        where a.ko_unitstr = '".kd_unit()."' "));
        // Tbrekan::where('Ko_unitstr',kd_unit())->leftjoin('pf_usaha', 'tb_rekan.ko_usaha', 'pf_usaha.ko_usaha')->get();



        return view('setting.rekanan.index',compact('rekanan'));
    }

    public function create()
    {
        $pf_usaha = Pfusaha::all();

        return view('setting.rekanan.create', compact('pf_usaha'));
    }

    public function store(Request $request)
    {
        $rules = [
            'rekan_nm'      => 'required',
            'rekan_npwp'    => 'required',
            'rekan_milikbank'    => 'required',
            'rekan_rekbank' => 'required',
            'rekan_nmbank'  => 'required',
            'rekan_adr'     => 'required',
            'ko_usaha'     => 'required',
        ];

        $messages = [
            'rekan_nm.required'      => 'Nama Rekanan wajib diisi.',
            'rekan_npwp.required'    => 'Nomor NPWP wajib diisi.',
            'rekan_milikbank.required' => 'Nama Pemilik Rekening wajib diisi.',
            'rekan_rekbank.required' => 'Rekening Bank wajib diisi.',
            'rekan_nmbank.required'  => 'Nama Bank wajib diisi.',
            'rekan_adr.required'     => 'Alamat wajib diisi.',
            'ko_usaha.required'     => 'Bentuk Perusahaan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Tbrekan::create([
          'Ko_unitstr'    => kd_unit(),
          'rekan_nm'      => $request->rekan_nm,
          'rekan_npwp'    => $request->rekan_npwp,
          'rekan_milikbank' => $request->rekan_milikbank,
          'rekan_rekbank' => $request->rekan_rekbank,
          'rekan_nmbank'  => $request->rekan_nmbank,
          'rekan_adr'     => $request->rekan_adr,
          'rekan_ph'      => $request->rekan_ph,
          'rekan_pimp'    => $request->rekan_pimp,
          'rekan_mail'    => $request->rekan_mail,
          'ko_usaha'      => $request->ko_usaha,
          'created_at'    => now(),
        ]);

        Alert::success('Berhasil', "Data berhasil ditembah");
        return redirect()->route('rekanan.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $rekanan = Tbrekan::where('id_rekan',$id)->first();
        $pf_usaha = Pfusaha::all();

        return view('setting.rekanan.edit', compact('rekanan', 'pf_usaha'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'rekan_nm'      => 'required',
            'rekan_npwp'    => 'required',
            'rekan_rekbank' => 'required',
            'rekan_nmbank'  => 'required',
            'rekan_adr'     => 'required',
            'rekan_mail'    => 'required',
            'ko_usaha'      => 'required',
        ];

        $messages = [
            'rekan_nm.required'      => 'Nama Rekanan wajib diisi.',
            'rekan_npwp.required'    => 'Nomor NPWP wajib diisi.',
            'rekan_rekbank.required' => 'Rekening Bank wajib diisi.',
            'rekan_nmbank.required'  => 'Nama Bank wajib diisi.',
            'rekan_adr.required'     => 'Alamat wajib diisi.',
            'rekan_mail.required'    => 'Email wajib diisi.',
            'ko_usaha.required'      => 'Bentuk Perusahaan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Tbrekan::where('id_rekan',$id)->update([
          'Ko_unitstr'    => kd_unit(),
          'rekan_nm'      => $request->rekan_nm,
          'rekan_npwp'    => $request->rekan_npwp,
          'rekan_milikbank' => $request->rekan_milikbank,
          'rekan_rekbank' => $request->rekan_rekbank,
          'rekan_nmbank'  => $request->rekan_nmbank,
          'rekan_adr'     => $request->rekan_adr,
          'rekan_ph'      => $request->rekan_ph,
          'rekan_pimp'    => $request->rekan_pimp,
          'rekan_mail'    => $request->rekan_mail,
          'ko_usaha'      => $request->ko_usaha,
          'updated_at'    => now(),
        ]);

        Alert::success('Berhasil', "Data berhasil dirubah");
        return redirect()->route('rekanan.index');
    }

    public function destroy($id)
    {
        $data = Tbrekan::where('id_rekan',$id)->select('id_rekan');
        $data->delete();

        Alert::success('Berhasil', "Data berhasil dihapus");
        return redirect()->route('rekanan.index');
    }
}
