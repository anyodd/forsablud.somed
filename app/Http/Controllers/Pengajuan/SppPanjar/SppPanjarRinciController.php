<?php

namespace App\Http\Controllers\Pengajuan\SppPanjar;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SppPanjarRinciController extends Controller
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
        $Ko_Period = Session::get('Period');
        $Ko_unitstr = '14.02.01.02.01.001';
        $Ko_unitstr = kd_unit();
        $tb_ulog = Session::get('userData')['username'];

        $rules = [
            "Ko_sKeg1" => "required",
            "Ko_sKeg2" => "required",
            "Ko_Rkk" => "required",
            "spirc_Rp" => "required",
          ];
      
          $messages = [
            "Ko_sKeg1.required" => "Kegiatan wajib diisi.",
            "Ko_sKeg2.required" => "Kegiatan wajib diisi.",
            "Ko_Rkk.required" => "Kode Akun wajib diisi.",
            "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        Tb_spirc::create([          
            'Ko_Period' => $Ko_Period,
            'Ko_unitstr' => $Ko_unitstr,
            'No_spi' => $request->No_spi,   
            'Ko_spirc' => $request->Ko_spirc,     
            'No_bp' => null,
            'Ko_bprc' => null,
            'Ko_Rkk' => $request->Ko_Rkk,
            'Ko_Pdp' => null,
            'ko_pmed' => null,
            'rftr_bprc' => null,
            'dt_rftrbprc' => null,
            'No_PD' => $request->pd,
            'Ko_sKeg1' => $request->Ko_sKeg1,
            'Ko_sKeg2' => $request->Ko_sKeg2,
            'Ur_bprc' => null,
            'spirc_Rp' => $request->spirc_Rp,
            'tb_ulog' => $tb_ulog,
        ]);

        $spppanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $Ko_Period,
            $Ko_unitstr,
            $request->No_spi
        ])[0];

        toast('Data Rincian SPP Panjar Nomor ' . $request->No_spi . ' Berhasil Ditambahkan!', 'success');

        return redirect()->route('spppanjar-rinci.pilih', $spppanjar->id);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $period = Session::get('Period');
        $ko_unit1 = kd_bidang();
        $pd = 2;
        
        $spppanjar_rinci = Tb_spirc::find($id);

        $spppanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $spppanjar_rinci->Ko_Period,
            $spppanjar_rinci->Ko_unitstr,
            $spppanjar_rinci->No_spi
        ])[0];

        $data_transaksi = DB::select('CALL vdata_btrans (' . $period . ', "' .  $ko_unit1 . '", ' . $pd . ')');
        
        return view('pengajuan.spppanjarrinci.edit', compact('spppanjar_rinci', 'spppanjar', 'data_transaksi'));
    }

    public function update(Request $request, $id)
    {
        $Ko_Period = Session::get('Period');
        $Ko_unitstr = kd_unit();
        $tb_ulog = Session::get('userData')['username'];

        $spppanjar_rinci = Tb_spirc::find($id);

        $rules = [
            "Ko_sKeg1" => "required",
            "Ko_sKeg2" => "required",
            "Ko_Rkk" => "required",
            "spirc_Rp" => "required",
          ];
      
          $messages = [
            "Ko_sKeg1.required" => "Kegiatan wajib diisi.",
            "Ko_sKeg2.required" => "Kegiatan wajib diisi.",
            "Ko_Rkk.required" => "Kode Akun wajib diisi.",
            "spirc_Rp.required" => "Nilai (Rp) wajib diisi.",
          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

            $spppanjar_rinci->Ko_Period = $Ko_Period;
            $spppanjar_rinci->Ko_unitstr = $Ko_unitstr;
            $spppanjar_rinci->No_spi = $request->No_spi;   
            $spppanjar_rinci->Ko_spirc = $request->Ko_spirc;     
            $spppanjar_rinci->No_bp = null;
            $spppanjar_rinci->Ko_bprc = null;
            $spppanjar_rinci->Ko_Rkk = $request->Ko_Rkk;
            $spppanjar_rinci->Ko_Pdp = null;
            $spppanjar_rinci->ko_pmed = null;
            $spppanjar_rinci->rftr_bprc = null;
            $spppanjar_rinci->dt_rftrbprc = null;
            $spppanjar_rinci->No_PD = $request->pd;
            $spppanjar_rinci->Ko_sKeg1 = $request->Ko_sKeg1;
            $spppanjar_rinci->Ko_sKeg2 = $request->Ko_sKeg2;
            $spppanjar_rinci->Ur_bprc = null;
            $spppanjar_rinci->spirc_Rp = $request->spirc_Rp;
            $spppanjar_rinci->tb_ulog = $tb_ulog;
            $spppanjar_rinci->save();

        $spppanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $Ko_Period,
            $Ko_unitstr,
            $request->No_spi
        ])[0];

        toast('Data Rincian SPP Panjar Nomor ' . $request->No_spi . ' Berhasil Diubah!', 'success');

        return redirect()->route('spppanjar-rinci.pilih', $spppanjar->id);
    }

    public function destroy($id)
    {
        $spppanjar_rinci = Tb_spirc::find($id);
        $spppanjar_rinci->delete($id);
        
        $spppanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $spppanjar_rinci->Ko_Period,
            $spppanjar_rinci->Ko_unitstr,
            $spppanjar_rinci->No_spi
        ]);

        toast('Data Rincian SPP Panjar ' . $spppanjar_rinci->rftr_bprc . ' Berhasil Dihapus!', 'success');

        return redirect()->route('spppanjar-rinci.pilih', $spppanjar[0]->id);
    }

    public function pilih($id)
    {
        $spppanjar[0] = Tb_spi::find($id);

        $spppanjar_rinci = DB::select('SELECT * FROM tb_spirc WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $spppanjar[0]->Ko_Period,
            $spppanjar[0]->Ko_unitstr,
            $spppanjar[0]->No_SPi,
        ]);
        
        return view('pengajuan.spppanjarrinci.index', compact('spppanjar_rinci', 'spppanjar'));
    }

    public function tambah($id)
    {
        $period = Session::get('Period');
        $ko_unit1 = kd_bidang();
        $pd = 2;
        
        $spppanjar = Tb_spi::find($id);

        $data_transaksi = DB::select('CALL vdata_btrans (' . $period . ', "' .  $ko_unit1. '", ' . $pd . ')');

        $max = Tb_spirc::where('Ko_Period', $spppanjar->Ko_Period)
                    ->where('Ko_unitstr', $spppanjar->Ko_unitstr)
                    ->where('No_spi', $spppanjar->No_SPi)
                    ->max('Ko_spirc');

        return view('pengajuan.spppanjarrinci.create', compact('spppanjar', 'data_transaksi', 'max'));
    }
}
