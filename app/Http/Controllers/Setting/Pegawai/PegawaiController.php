<?php

namespace App\Http\Controllers\Setting\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pfpj; 
use App\Models\Tbpjb; 
use App\Models\Tbsub1; 

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Tbpjb::where('tb_pjb.Ko_unit1', 'like', kd_unit().'%')
                    ->leftJoin('tb_sub1', 'tb_pjb.Ko_unit1', '=', 'tb_sub1.ko_unit1')
                    ->where('tb_sub1.Ko_period', Tahun())
                    ->orderBy('id_pj')
                    ->get([ 'tb_pjb.*', 'tb_sub1.ur_subunit1' ]);

                    // dd($pegawai);
        return view('setting.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $jabatan = Pfpj::orderBy('id_pj')->get();
        $bidang = Tbsub1::where('Ko_Period', Tahun())->where('Ko_unit1', 'like', kd_unit().'%')->orderBy('Ko_Sub1')->get();

        return view('setting.pegawai.create', compact('jabatan', 'bidang'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            "Nm_pjb" => "required",
            "NIP_pjb" => "required",
            "id_pj" => "required",
            "kd_bidang" => "required",
        ];

        $messages = [
            "Nm_pjb.required" => "Nama pegawai wajib diisi.",
            "NIP_pjb.required" => "NIP pegawai wajib diisi.",
            "id_pj.required" => "Jabatan wajib diisi.",
            "kd_bidang.required" => "Bidang wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $dt = DB::select("SELECT * FROM tb_pjb WHERE LEFT(Ko_unit1,18) = '".kd_unit()."' && NIP_pjb = '".$request->NIP_pjb."'");

        if(empty($dt)){
            Tbpjb::create([
            'id_pj'    => $request->id_pj,
            'Ko_unit1' => $request->kd_bidang,
            'Nm_pjb'   => $request->Nm_pjb,
            'NIP_pjb'  => $request->NIP_pjb,
            ]);
        }else{
            Alert::warning('Gagal Input',' NIP sudah ada');
            return redirect()->route("pegawai.index");
        }
        Alert::success('Berhasil', 'Data berhasil dibuat');
        return redirect()->route("pegawai.index");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // $pegawai = Tbpjb::find($id);
        $pegawai = Tbpjb::where('id_pjb', $id)->leftjoin('tb_sub1',  'tb_pjb.Ko_unit1', '=', 'tb_sub1.ko_unit1')
                        ->where('tb_sub1.Ko_period', Tahun())->first();
        $jabatan = Pfpj::orderBy('id_pj')->get();
        $bidang = Tbsub1::where('Ko_Period', Tahun())->where('Ko_unit1', 'like', kd_unit().'%')->orderBy('Ko_Sub1')->get();

        return view('setting.pegawai.edit', compact('pegawai', 'jabatan', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "Nm_pjb" => "required",
            "NIP_pjb" => "required",
            "id_pj" => "required",
            "kd_bidang" => "required",
        ];

        $messages = [
            "Nm_pjb.required" => "Nama pegawai wajib diisi.",
            "NIP_pjb.required" => "NIP pegawai wajib diisi.",
            "id_pj.required" => "Jabatan wajib diisi.",
            "kd_bidang.required" => "Bidang wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = Tbpjb::find($id);
        $data->id_pj    = $request->id_pj;
        $data->Nm_pjb   = $request->Nm_pjb;
        // $data->NIP_pjb  = $request->NIP_pjb;
        $data->Ko_unit1 = $request->kd_bidang;
        $data->updated_at = now();
        $data->save();
        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route("pegawai.index");
    }

    public function destroy($id)
    {
        $data = Tbpjb::find($id);
        $data->delete();

        return redirect()->route("pegawai.index");
    }
}
