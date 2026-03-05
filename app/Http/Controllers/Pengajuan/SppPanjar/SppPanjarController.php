<?php

namespace App\Http\Controllers\Pengajuan\SppPanjar;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SppPanjarController extends Controller
{
    public function index()
    {
        $spppanjar = Tb_spi::where('Ko_SPi', 7)->where(['Ko_Period' => Tahun(),'Ko_unitstr' => kd_unit()])->get();

        return view('pengajuan.spppanjar.index', compact('spppanjar'));
    }

    public function create()
    {
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");

        return view('pengajuan.spppanjar.create',compact('ko_bank','bank_rekan','pegawai'));
    }

    public function store(Request $request)
    {
        $bank_rekan = explode('||',$request->rekan_bank);
        $Ko_SPi = '7';
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
            'Ko_Period'  => Tahun(),
            'Ko_unitstr' => kd_unit(),
            'Ko_SPi'     => $Ko_SPi,
            'No_SPi'     => $request->No_SPi,
            'Dt_SPi'     => $request->Dt_SPi,
            'Ur_SPi'     => $request->Ur_SPi,
            'Ko_Bank'    => $request->Ko_Bank,
            'Nm_PP'      => $PP[0],
            'NIP_PP'     => $PP[1],
            'Nm_Ben'     => $Ben[0],
            'NIP_Ben'    => $Ben[1],
            'Nm_Keu'     => $Keu[0],
            'NIP_Keu'    => $Keu[1],
            'trm_bank'   => $bank_rekan[1],
            'trm_rek'    => $bank_rekan[0],
            'tb_ulog'    => getUser('username'),
            'Tag'        => $Tag,
        ]);

        // toast('Data SPP Panjar Nomor ' . $request->No_SPi . ' Berhasil Ditambah!', 'success');
        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect()->route("spppanjar.index");
    }
    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $spppanjar = Tb_spi::find($id);
        $ko_bank = DB::select("SELECT * FROM pf_bank where Ko_unitstr = '".kd_unit()."'");
        $bank_rekan = DB::select("SELECT * FROM tb_rekan where Ko_unitstr = '".kd_unit()."'");
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE LEFT(a.Ko_unit1,18) = '".kd_unit()."'");
        
        return view('pengajuan.spppanjar.edit', compact('spppanjar','ko_bank','bank_rekan','pegawai'));
    }

    public function update(Request $request, $id)
    {
        $bank_rekan = explode('||',$request->rekan_bank);
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
          Tb_spi::where('id',$id)->update([      
            'No_SPi'   => $request->No_SPi,
            'Dt_SPi'   => $request->Dt_SPi,
            'Ur_SPi'   => $request->Ur_SPi,
            'Ko_Bank'  => $request->Ko_Bank,
            'Nm_PP'    => $PP[0],
            'NIP_PP'   => $PP[1],
            'Nm_Ben'   => $Ben[0],
            'NIP_Ben'  => $Ben[1],
            'Nm_Keu'   => $Keu[0],
            'NIP_Keu'  => $Keu[1],
            'trm_bank' => $bank_rekan[1],
            'trm_rek'  => $bank_rekan[0],
        ]);

        // toast('Data SPP Panjar Nomor ' . $request->No_SPi . ' Berhasil Diubah!', 'success');
        Alert::success('Berhasil', "Data berhasil dirubah");
        return redirect()->route("spppanjar.index");
    }

    public function destroy($id)
    {
        $spppanjar = Tb_spi::find($id);
        $spppanjar->delete();

        return redirect()->route('spppanjar.index');
    }

    public function verifikasi(Request $request, $id)
    {
        Tb_spi::where('id',$id)->update([
            'Tag_v' => $request->Tag_v,
        ]);

        Alert::success('Berhasil', 'Data berhasil diajukan verifikasi');
        return redirect()->route('spppanjar.index');
    }
}
