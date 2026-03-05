<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\Blu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap;
use App\Models\Tbbyr;
use RealRashid\SweetAlert\Facades\Alert;

class SubPenerimaanBluController extends Controller
{
    public function index()
    {   //
    }

    public function rincian($id_bp)
    {
        $cek = Tbbyr::where('id_bprc',$id_bp)->where('Ko_Period', Tahun())->first();
        $kobp = Tbbp::where('id_bp',$id_bp)->first();

        $rincian = DB::select('SELECT a.*, b.*, c.id_bprc idbprcbyr
                    FROM tb_bp a
                    JOIN tb_bprc b ON a.id_bp = b.id_bp
                    LEFT JOIN tb_byr c ON b.id_bprc = c.id_bprc 
                    WHERE a.id_bp = "'.$id_bp.'"
                    && a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'" 
                    GROUP BY b.Ko_bprc');

        return view('transaksi.penerimaan.subblu.rincian', compact( 'rincian','cek','kobp'));
    }

    public function create($id)
    {
        $data = Tbbp::where('id_bp',$id)->first();
        $PD = 2;

        $max = Tbbprc::where('Ko_Period', Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_bprc');

        $caridata = DB::select('CALL SP_Anggaran_Pdpt('.Tahun().', "'.kd_bidang().'")');
        $datafinal = collect($caridata);
        return view('transaksi.penerimaan.subblu.create', compact('data', 'max' , 'datafinal' ));
    }

    public function tambah($id)
    {
        $data = Tbbp::where('id_bp',$id)->where('Ko_Period',Tahun())->first();
        $PD = 2;

        $max = Tbbprc::where('Ko_Period',Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', kd_bidang())
        ->max('Ko_bprc');

        $caridata = DB::select('CALL SP_Anggaran_Pdpt('.Tahun().', "'.kd_bidang().'")');
        $datafinal = collect($caridata);
        return view('transaksi.penerimaan.subblu.create', compact('data', 'max' , 'datafinal' ));
    }

    public function tambahtl($id)
    {
        $data = Tbbp::where('id_bp',$id)->where('Ko_Period',Tahun())->first();
        $PD = 2;

        $max = Tbbprc::where('Ko_Period',Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', kd_bidang())
        ->max('Ko_bprc');
        $datafinal = DB::select(DB::raw('SELECT * FROM tb_sopiut WHERE Ko_Period = "'.Tahun().'" && Ko_unit1 = "'.kd_bidang().'"'));
        return view('transaksi.penerimaan.subblu.createtl', compact('data', 'max' , 'datafinal' ));
    }

    public function store(Request $request)
    {
        // id_bprc
        // Ko_Period
        // Ko_unitstr
        // No_byr
        // dt_byr
        // Ur_byr
        // No_bp
        // Ko_bprc
        // real_rp
        // ko_kas
        // Ko_Bank
        // Nm_Byr
        // Tag
        // tb_ulog
        // created_at
        // updated_at

        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "To_Rp" => "required",
            "Ko_Pdp" => "required",
            "Ko_pmed" => "required",
          ];
      
          $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "To_Rp.required" => "Nilai (Rp) wajib diisi.",
            "Ko_Pdp.required" => "Jenis Sumber Kegiatan Wajib Diisi",
            "Ko_pmed.required" => "Rincian Sumber Kegiatan wajib diisi.",

          ];
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
 
        Tbbprc::create([          
            'id_bp' => $request->id_bp,
            'Ko_Period' => Tahun(),
            'Ko_unit1' => kd_bidang(),      
            'No_bp' => $request->No_bp,
            'Ko_bprc' => $request->Ko_bprc,
            'Ur_bprc' => $request->Ur_bprc,
            'rftr_bprc' => $request->rftr_bprc,
            'dt_rftrbprc' => $request->dt_rftrbprc,
            'No_PD' => $request->No_PD,
            'Ko_sKeg1' => $request->Ko_sKeg1,
            'Ko_sKeg2' => $request->Ko_sKeg2,
            'Ko_Rkk' => $request->Ko_Rkk,
            'Ko_Pdp' => $request->Ko_Pdp,
            'ko_pmed' => $request->Ko_pmed,
            'To_Rp' => inrupiah($request->To_Rp),
            'ko_kas' => $request->Ko_kas,
            'tb_ulog' => getUser('username'),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
        
        Alert::success('Berhasil', "Data Berhasil Ditambah");
        return redirect()->route('subpenerimaan.rincian', $request->id_bp);
    }

    public function show($id_bprc)
    {
        $rincian = Tbbprc::where('id_bp',$id_bprc)->get();
        return view('transaksi.penerimaan.subblu.show', compact('rincian'));
    }

    public function edit($id)
    {
        $data = Tbbprc::where('id_bprc',$id)->first();
        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
        $Ko_Unit = kd_bidang();
        $Period = Tahun();
        $Ko_unitstr = kd_unit();
        $penerimaan = Tbbprc::all();
        $kegiatan = Tbtap::GROUPBY('Ko_Rkk')->get();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $PD = 2;
        $max = Tbbprc::where('Ko_Period', Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_bprc');
        $caridata = DB::select('CALL SP_Anggaran_Pdpt('.Tahun().', "'.kd_bidang().'")');
        $datafinal = collect($caridata);
        
        $dt_view = collect($caridata)->where('ko_skeg1', $ko_skeg1)->where('ko_skeg2', $ko_skeg2)->where('ko_rkk', $ko_rkk)->first();
        return view('transaksi.penerimaan.subblu.edit', compact('dt_view','penerimaan','sumber','sumber2','kegiatan', 'data', 'Ko_Unit', 'Period', 'max' , 'datafinal' ));
    }

    public function update(Request $request, $id_bprc)
    {
        $rules = [
            "To_Rp" => "required",
          ];
      
          $messages = [
            "To_Rp.required" => "Nomor Bukti wajib diisi.",
          ];
      
          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }
        Tbbprc::where('id_bprc', $id_bprc)->update([
            'dt_rftrbprc' => $request->dt_rftrbprc,
            'No_bp' => $request->No_bp,
            'Ko_sKeg1' => $request->Ko_sKeg1,
            'Ko_sKeg2' => $request->Ko_sKeg2,
            'Ko_Rkk' => $request->Ko_Rkk,
            'rftr_bprc' => $request->rftr_bprc,
            'Ko_Pdp' => $request->Ko_Pdp,
            'Ur_bprc' => $request->Ur_bprc,
            'ko_pmed' => $request->Ko_pmed,
            'To_Rp' => inrupiah($request->To_Rp),
            'ko_kas' => $request->Ko_kas,
            'updated_at' => NOW()
        ]);

        $id = Tbbprc::where('id_bprc',$id_bprc)->value('id_bp');

        Alert::success('Berhasil', "Data Rincian Penerimaan berhasil dirubah");
        return redirect()->route('subpenerimaan.rincian', $id);
    }

    public function destroy($id)
    {
        $idbp = Tbbprc::select('id_bp')->where('id_bprc',$id)->first();
        $bprc = DB::select(DB::raw('select a.* 
                                    from tb_bprc a
                                    join tb_byr b
                                    ON a.id_bprc = b.id_bprc
                                    where a.id_bprc ='.$id));     
        if(empty($bprc)){
            $bprc = Tbbprc::where('id_bprc',$id);
            $bprc->delete();
            Alert::success('Berhasil', "Data Rincian Penerimaan berhasil Dihapus");

            return redirect()->route('subpenerimaan.rincian', $idbp->id_bp);
        }else{
            //Alert::success('Yeay!', 'berhasil dihapus');
            return back()->with('alert','Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data.');
            //return back();
            }
        }
}

