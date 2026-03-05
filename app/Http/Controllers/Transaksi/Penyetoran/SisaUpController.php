<?php

namespace App\Http\Controllers\Transaksi\Penyetoran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap; 
use App\Models\Tbsikas; 
use Barryvdh\DomPDF\Facade as PDF;
use RealRashid\SweetAlert\Facades\Alert;


class SisaUpController extends Controller
{
    public function index()
    {
        $Ko_Period = Tahun();
        $unit = kd_unit();
        $data = Tbsikas::where('Ko_sikas','1')
                ->where('Ko_Period',$Ko_Period)
                ->where('Ko_unitstr', $unit)
                ->get();
        return view('transaksi.penyetoran.sisaup.index', compact('data'));
    }

    public function create()
    {
        return view('transaksi.penyetoran.sisaup.create');
    }

    public function tambah()
    {
        return view('transaksi.penyetoran.sisaup.create');
    }

    public function store(Request $request)
    {
        $Ko_Period = Tahun();
        $Ko_unitstr = kd_bidang();
        $ko_sikas = '1';
        $no_oto = '0';
        $Tag = '0';
        $tb_ulog = 'admin';

        $rules = [
            "sikas_no" => "required",
            "dt_sikas" => "required",
            "sikas_ur" => "required",
            "sikas_Rp" => "required",
          ];
      
          $messages = [
            "sikas_no.required" => "Nomor Bukti wajib diisi.",
            "dt_sikas.required" => "Tanggal wajib diisi.",
            "sikas_ur.required" => "Uraian wajib diisi.",
            "sikas_Rp.required" => "Nilai Penyetoran wajib diisi.",
          ];
      
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        Tbsikas::create([          
            'Ko_Period' => $Ko_Period,
            'Ko_unitstr' => $Ko_unitstr,
            'ko_sikas' => $ko_sikas,
            'sikas_no' => $request->sikas_no,
            'dt_sikas' => $request->dt_sikas,
            'sikas_ur' => $request->sikas_ur,
            'no_oto' => $no_oto,
            'sikas_Rp' => $request->sikas_Rp,
            'Tag' => $Tag,
            'tb_ulog' => $tb_ulog,
            'created_at' => NOW(),
            'update_at' => NOW(),
        ]);

        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect()->route("sisaup.index");
    }

    public function show($id_bp)
    {
    }

    public function edit($id)
    {   
        $data = Tbsikas::find($id);
        return view('transaksi.penyetoran.sisaup.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "sikas_no" => "required",
            "dt_sikas" => "required",
            "sikas_ur" => "required",
            "sikas_Rp" => "required",
        ];
      
        $messages = [
        "sikas_no.required" => "Nomor Bukti wajib diisi.",
        "dt_sikas.required" => "Tanggal wajib diisi.",
        "sikas_ur.required" => "Uraian wajib diisi.",
        "sikas_Rp.required" => "Nilai Penyetoran wajib diisi.",
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Tbsikas::where('id_sikas', $id)->update([          
            'sikas_no' => $request->sikas_no,
            'dt_sikas' => $request->dt_sikas,
            'sikas_ur' => $request->sikas_ur,
            'sikas_Rp' => $request->sikas_Rp,
        ]);

        Alert::success('Berhasil', "Data berhasil dirubah");
        return redirect()->route("sisaup.index");
    }

    public function destroy($id)
    {
        $data = Tbsikas::find($id);
        $data->delete();

        Alert::success('Berhasil', "Data berhasil dihapus");
        return redirect()->route("sisaup.index");
    }

}
