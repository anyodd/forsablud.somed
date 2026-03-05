<?php

namespace App\Http\Controllers\Pengajuan\SppNihilPanjar;

use App\Http\Controllers\Controller;
use App\Models\Tb_spi;
use App\Models\Tb_spirc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SppNihilPanjarRinciController extends Controller
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

        $sppnihilpanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $Ko_Period,
            $Ko_unitstr,
            $request->No_spi
        ])[0];

        toast('Data Rincian SPP Nihil Panjar Nomor ' . $request->No_spi . ' Berhasil Ditambahkan!', 'success');

        return redirect()->route('sppnihilpanjar-rinci.pilih', $sppnihilpanjar->id);
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
        
        $sppnihilpanjar_rinci = Tb_spirc::find($id);

        $sppnihilpanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $sppnihilpanjar_rinci->Ko_Period,
            $sppnihilpanjar_rinci->Ko_unitstr,
            $sppnihilpanjar_rinci->No_spi
        ])[0];

        $data_transaksi = DB::select('CALL vdata_btrans (' . $period . ', "' .  $ko_unit1. '", ' . $pd . ')');
        
        return view('pengajuan.sppnihilpanjarrinci.edit', compact('sppnihilpanjar_rinci', 'sppnihilpanjar', 'data_transaksi'));
    }

    public function update(Request $request, $id)
    {
        $Ko_Period = '2020';
        $Ko_unitstr = '14.02.01.02.01.001';
        $tb_ulog = 'blud';

        $sppnihilpanjar_rinci = Tb_spirc::find($id);

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

            $sppnihilpanjar_rinci->Ko_Period = $Ko_Period;
            $sppnihilpanjar_rinci->Ko_unitstr = $Ko_unitstr;
            $sppnihilpanjar_rinci->No_spi = $request->No_spi;   
            $sppnihilpanjar_rinci->Ko_spirc = $request->Ko_spirc;     
            $sppnihilpanjar_rinci->No_bp = null;
            $sppnihilpanjar_rinci->Ko_bprc = null;
            $sppnihilpanjar_rinci->Ko_Rkk = $request->Ko_Rkk;
            $sppnihilpanjar_rinci->Ko_Pdp = null;
            $sppnihilpanjar_rinci->ko_pmed = null;
            $sppnihilpanjar_rinci->rftr_bprc = null;
            $sppnihilpanjar_rinci->dt_rftrbprc = null;
            $sppnihilpanjar_rinci->No_PD = $request->pd;
            $sppnihilpanjar_rinci->Ko_sKeg1 = $request->Ko_sKeg1;
            $sppnihilpanjar_rinci->Ko_sKeg2 = $request->Ko_sKeg2;
            $sppnihilpanjar_rinci->Ur_bprc = null;
            $sppnihilpanjar_rinci->spirc_Rp = $request->spirc_Rp;
            $sppnihilpanjar_rinci->tb_ulog = $tb_ulog;
            $sppnihilpanjar_rinci->save();

        $sppnihilpanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $Ko_Period,
            $Ko_unitstr,
            $request->No_spi
        ])[0];

        toast('Data Rincian SPP Nihil Panjar Nomor ' . $request->No_spi . ' Berhasil Diubah!', 'success');

        return redirect()->route('sppnihilpanjar-rinci.pilih', $sppnihilpanjar->id);
    }

    public function destroy($id)
    {
        $sppnihilpanjar_rinci = Tb_spirc::find($id);
        $sppnihilpanjar_rinci->delete($id);
        
        $sppnihilpanjar = DB::select('SELECT * FROM tb_spi WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $sppnihilpanjar_rinci->Ko_Period,
            $sppnihilpanjar_rinci->Ko_unitstr,
            $sppnihilpanjar_rinci->No_spi
        ]);

        toast('Data Rincian SPP Nihil Panjar ' . $sppnihilpanjar_rinci->rftr_bprc . ' Berhasil Dihapus!', 'success');

        return redirect()->route('sppnihilpanjar-rinci.pilih', $sppnihilpanjar[0]->id);
    }

    public function pilih($id)
    {
        $sppnihilpanjar[0] = Tb_spi::find($id);

        $sppnihilpanjar_rinci = DB::select('SELECT * FROM tb_spirc WHERE Ko_Period = ? AND Ko_unitstr = ? AND No_spi = ?', [
            $sppnihilpanjar[0]->Ko_Period,
            $sppnihilpanjar[0]->Ko_unitstr,
            $sppnihilpanjar[0]->No_SPi,
        ]);
        
        return view('pengajuan.sppnihilpanjarrinci.index', compact('sppnihilpanjar_rinci', 'sppnihilpanjar'));
    }

    public function tambah($id)
    {
        $period = Session::get('Period');
        $ko_unit1 = kd_bidang();
        $pd = 2;
        
        $sppnihilpanjar = Tb_spi::find($id);

        $data_transaksi = DB::select('CALL vdata_btrans (' . $period . ', "' .  $ko_unit1. '", ' . $pd . ')');

        $max = Tb_spirc::where('Ko_Period', $sppnihilpanjar->Ko_Period)
                    ->where('Ko_unitstr', $sppnihilpanjar->Ko_unitstr)
                    ->where('No_spi', $sppnihilpanjar->No_SPi)
                    ->max('Ko_spirc');

        return view('pengajuan.sppnihilpanjarrinci.create', compact('sppnihilpanjar', 'data_transaksi', 'max'));
    }
}
