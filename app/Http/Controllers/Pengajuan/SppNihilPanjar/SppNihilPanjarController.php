<?php

namespace App\Http\Controllers\Pengajuan\SppNihilPanjar;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SppNihilPanjarController extends Controller
{
    public function index()
    {
        $period = Session::get('Period');
      
        $sppnihilpanjar = Tb_spi::where('Ko_SPi', 8)->where(['Ko_Period' => $period,'Ko_unitstr' => kd_unit()])->get();

        return view('pengajuan.sppnihilpanjar.index', compact('sppnihilpanjar'));
    }

    public function create()
    {
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
        return view('pengajuan.sppnihilpanjar.create',compact('pegawai'));
        
    }

    public function store(Request $request)
    {
        $Ko_Period = Session::get('Period');
        $Ko_unitstr = kd_unit();
        $Ko_SPi = '8';
        $tb_ulog = Session::get('userData')['username'];
        $Tag = '0';
    
        $rules = [
            "No_SPi" => "required",
            "Dt_SPi" => "required",
            "Ur_SPi" => "required",
            "Nm_PP" => "required",
            "NIP_PP" => "required",
            "Nm_Ben" => "required",
            "NIP_Ben" => "required",
            "Nm_Keu" => "required",
            "NIP_Keu" => "required",
          ];
      
          $messages = [
            "No_SPi.required" => "Nomor Bukti wajib diisi",
            "Dt_SPi.required" => "Tanggal wajib diisi",
            "Ur_SPi.required" => "Uraian wajib diisi",
            "Nm_PP.required" => "Nama Pengusul wajib diisi",
            "NIP_PP.required" => "NIP Pengusul wajib diisi",
            "Nm_Ben.required" => "Nama Bendahara wajib diisi",
            "NIP_Ben.required" => "NIP Bendahara wajib diisi",
            "Nm_Keu.required" => "Nama PPK wajib diisi",
            "NIP_Keu.required" => "NIP PPK wajib diisi",
          ];
      
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
          $PP  = explode("|",$request->Nm_PP);
          $Ben = explode("|",$request->Nm_Ben);
          $Keu = explode("|",$request->Nm_Keu);
        Tb_spi::create([          
            'Ko_Period' => $Ko_Period,
            'Ko_unitstr' => $Ko_unitstr,
            'Ko_SPi' => $Ko_SPi,
            'No_SPi' => $request->No_SPi,
            'Dt_SPi' => $request->Dt_SPi,
            'Ur_SPi' => $request->Ur_SPi,
            'Nm_PP'   => $PP[0],
            'NIP_PP'  => $PP[1],
            'Nm_Ben'  => $Ben[0],
            'NIP_Ben' => $Ben[1],
            'Nm_Keu'  => $Keu[0],
            'NIP_Keu' => $Keu[1],
            'tb_ulog' => $tb_ulog,
            'Tag' => $Tag,
            'created_at' => now(),
            'updated_at' => now(),
            'oto_ulog' => $tb_ulog,
            'otodated_at' => now(),
        ]);

        toast('Data SPP Nihil Panjar Nomor ' . $request->No_SPi . ' Berhasil Ditambah!', 'success');

        return redirect()->route("sppnihilpanjar.index");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sppnihilpanjar = Tb_spi::find($id);
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
        
        return view('pengajuan.sppnihilpanjar.edit', compact('sppnihilpanjar','pegawai'));
    }

    public function update(Request $request, $id)
    {
        $Ko_Period = Session::get('Period');
        $Ko_unitstr = kd_unit();
        $Ko_SPi = '8';
        $tb_ulog = Session::get('userData')['username'];
        $Tag = '0';

        $spppanjar = Tb_spi::find($id);

        $rules = [
            "No_SPi" => "required",
            "Dt_SPi" => "required",
            "Ur_SPi" => "required",
            "Nm_PP" => "required",
            "NIP_PP" => "required",
            "Nm_Ben" => "required",
            "NIP_Ben" => "required",
            "Nm_Keu" => "required",
            "NIP_Keu" => "required",
          ];
      
          $messages = [
            "No_SPi.required" => "Nomor Bukti wajib diisi",
            "Dt_SPi.required" => "Tanggal wajib diisi",
            "Ur_SPi.required" => "Uraian wajib diisi",
            "Nm_PP.required" => "Nama Pengusul wajib diisi",
            "NIP_PP.required" => "NIP Pengusul wajib diisi",
            "Nm_Ben.required" => "Nama Bendahara wajib diisi",
            "NIP_Ben.required" => "NIP Bendahara wajib diisi",
            "Nm_Keu.required" => "Nama PPK wajib diisi",
            "NIP_Keu.required" => "NIP PPK wajib diisi",
          ];
      
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

          $PP  = explode("|",$request->Nm_PP);
          $Ben = explode("|",$request->Nm_Ben);
          $Keu = explode("|",$request->Nm_Keu);

            $spppanjar->Ko_Period  = $Ko_Period;
            $spppanjar->Ko_unitstr = $Ko_unitstr;
            $spppanjar->Ko_SPi = $Ko_SPi;
            $spppanjar->No_SPi = $request->No_SPi;
            $spppanjar->Dt_SPi = $request->Dt_SPi;
            $spppanjar->Ur_SPi = $request->Ur_SPi;
            $spppanjar->Nm_PP   = $PP[0];
            $spppanjar->NIP_PP  = $PP[1];
            $spppanjar->Nm_Ben  = $Ben[0];
            $spppanjar->NIP_Ben = $Ben[1];
            $spppanjar->Nm_Keu  = $Keu[0];
            $spppanjar->NIP_Keu = $Keu[1];
            $spppanjar->tb_ulog = $tb_ulog;
            $spppanjar->Tag = $Tag;
            $spppanjar->created_at = $request->created_at;
            $spppanjar->updated_at = now();
            $spppanjar->oto_ulog = $tb_ulog;
            $spppanjar->otodated_at = now();
            $spppanjar->save();

        toast('Data SPP Nihil Panjar Nomor ' . $request->No_SPi . ' Berhasil Diubah!', 'success');

        return redirect()->route("sppnihilpanjar.index");
    }

    public function destroy($id)
    {
        $sppnihilpanjar = Tb_spi::find($id);
        $sppnihilpanjar->delete();

        return redirect()->route('sppnihilpanjar.index');
    }

    public function verifikasi(Request $request, $id)
    {
        Tb_spi::where('id',$id)->update([
            'Tag_v' => $request->Tag_v,
        ]);

        Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
        return redirect()->route('sppnihilpanjar.index');
    }
}
