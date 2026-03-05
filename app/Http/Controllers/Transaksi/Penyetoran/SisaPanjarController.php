<?php

namespace App\Http\Controllers\Transaksi\Penyetoran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbsikas; 
use Barryvdh\DomPDF\Facade as PDF;
use RealRashid\SweetAlert\Facades\Alert;


class SisaPanjarController extends Controller
{
    public function index()
    {
        $Ko_Period = Tahun();
        $unit = kd_unit();
        $bidang = kd_bidang();
        $data = Tbsikas::orderBy('id_sikas')->orderBy('Ko_Period')->orderBy('id_sikas','desc')->where('Ko_sikas','2')->where('Ko_Period',$Ko_Period)->get();
        return view('transaksi.penyetoran.sisapanjar.index', compact('data'));
    }

    public function rincian($id_bp)
    {

    }

    public function create()
    {
        $data = DB::select(DB::raw('select a.*, b.* 
                                    from tb_oto a
                                    inner join tb_spi b
                                    on a.No_SPi = b.No_SPi
                                    where b.Ko_SPi = 7'));
        return view('transaksi.penyetoran.sisapanjar.create', compact('data'));
    }

    public function tambah()
    {
        $data = DB::select(DB::raw('select a.*, b.* 
                                    from tb_oto a
                                    inner join tb_spi b
                                    on a.No_SPi = b.No_SPi
                                    where b.Ko_SPi = 7'));

        return view('transaksi.penyetoran.sisapanjar.create', compact('data'));
    }

    public function store(Request $request)
    {
        $Ko_Period = 2020;
        $Ko_unitstr = kd_bidang();
        $ko_sikas = '2';
        $Tag = '0';
        $tb_ulog = 'admin';

        $rules = [
            "sikas_no" => "required",
            "dt_sikas" => "required",
            "sikas_ur" => "required",
            "sikas_Rp" => "required",
            "dNo_oto" => "required",
          ];
      
          $messages = [
            "sikas_no.required" => "Nomor Bukti wajib diisi.",
            "dt_sikas.required" => "Tanggal wajib diisi.",
            "sikas_ur.required" => "Uraian wajib diisi.",
            "sikas_Rp.required" => "Nilai Penyetoran wajib diisi.",
            "dNo_oto.required" => "Nilai Penyetoran wajib diisi.",
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
            'no_oto' => $request->no_oto,
            'sikas_Rp' => $request->sikas_Rp,
            'Tag' => $Tag,
            'tb_ulog' => $tb_ulog,
            'created_at' => NOW(),
            'update_at' => NOW(),
        ]);

        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect()->route("sisapanjar.index");
    }

    public function show($id_bp)
    {
    }

    public function edit($id_bp)
    {   
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        //
    }

    public function print($id)
    {
        
    }

}