<?php

namespace App\Http\Controllers\Transaksi\Belanja\Panjar;

use App\Http\Controllers\Controller;
use App\Models\Pfpmed;
use App\Models\Tbbp;
use App\Models\Tbbprc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PanjarRinciController extends Controller
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
        $tb_ulog = Session::get('userData')['username'];

        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "dt_rftrbprc" => "required",
            "To_Rp" => "required",
            "Ko_kas" => "required",
            "Ko_Rkk" => "required",
          ];
      
          $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "dt_rftrbprc.required" => "Tanggal Wajib Diisi",
            "To_Rp.required" => "Nilai wajib diisi",
            "Ko_kas.required" => "Cara Pembayaran wajib diisi",
            "Ko_Rkk.required" => "Kode RKK wajib diisi",

          ];

          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

        Tbbprc::create([          
            'id_bp' => $request->id_bp,
            'Ko_Period' => $request->Ko_period,
            'Ko_unit1' => $request->Ko_unit1,      
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
            'Ko_pmed' => $request->Ko_pmed,
            'To_Rp' => $request->To_Rp,
            'ko_kas' => $request->Ko_kas,
            'tb_ulog' => $tb_ulog,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        toast("Data Rincian dari Panjar Nomor " . $request->No_bp . " Berhasil Ditambahkan!", "success");

        return redirect()->route("panjar-rinci.pilih", $request->id_bp);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $panjar = Tbbprc::find($id);

        // $kegiatan = DB::select("SELECT a.*, c.ur_rk6 FROM tb_spirc a
        //                         INNER JOIN tb_spi b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_spi = b.No_SPi
        //                         INNER JOIN
        //                         (
        //                         SELECT CONCAT(
        //                         LPAD(Ko_Rk1,2,0),'.' ,
        //                         LPAD(Ko_Rk2,2,0),'.' ,
        //                         LPAD(Ko_Rk3,2,0),'.' ,
        //                         LPAD(Ko_Rk4,2,0),'.' ,
        //                         LPAD(Ko_Rk5,3,0),'.' ,
        //                         LPAD(Ko_Rk6,4,0)
        //                         ) AS RKK6, ur_rk6
        //                         FROM pf_rk6) c ON a.Ko_Rkk = c.RKK6
        //                         WHERE b.Ko_SPi = ?", [7]);

        $kegiatan = DB::select("SELECT a.*, c.ur_rk6, d.Ur_KegBL1, e.Ur_KegBL2 FROM tb_spirc a
        INNER JOIN tb_spi b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_spi = b.No_SPi
        INNER JOIN (
        SELECT CONCAT(
        LPAD(Ko_Rk1,2,0),'.' ,
        LPAD(Ko_Rk2,2,0),'.' ,
        LPAD(Ko_Rk3,2,0),'.' ,
        LPAD(Ko_Rk4,2,0),'.' ,
        LPAD(Ko_Rk5,3,0),'.' ,
        LPAD(Ko_Rk6,4,0)
        ) AS RKK6, ur_rk6
        FROM pf_rk6) c ON a.Ko_Rkk = c.RKK6
        INNER JOIN tb_kegs1 d ON a.Ko_sKeg1 = d.Ko_sKeg1 AND a.Ko_Period = d.Ko_Period AND a.`Ko_unitstr` = LEFT(d.`ko_unit1`,18)
        INNER JOIN tb_kegs2 e ON a.Ko_sKeg2 = e.Ko_sKeg2 AND a.Ko_Period = e.Ko_Period AND a.`Ko_unitstr` = LEFT(e.`ko_unit1`,18)
        WHERE b.Ko_unitstr = ? AND b.Ko_SPi = ? GROUP BY a.id", [kd_unit(),7]);

        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
        $dt_view = collect($kegiatan)->where('Ko_sKeg1',$ko_skeg1)->where('Ko_sKeg2',$ko_skeg2)->where('Ko_Rkk',$ko_rkk)->first();
        
        return view('transaksi.belanja.panjarrinci.edit', compact('panjar', 'kegiatan','dt_view'));
    }

    public function update(Request $request, $id)
    {
        $tb_ulog = Session::get('userData')['username'];

        $panjar_detail = Tbbprc::find($id);

        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "dt_rftrbprc" => "required",
            "To_Rp" => "required",
            "Ko_kas" => "required",
            "Ko_Rkk" => "required",
          ];
      
          $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "dt_rftrbprc.required" => "Tanggal Wajib Diisi",
            "To_Rp.required" => "Nilai wajib diisi",
            "Ko_kas.required" => "Cara Pembayaran wajib diisi",
            "Ko_Rkk.required" => "Kode RKK wajib diisi",

          ];

          $validator = Validator::make($request->all(), $rules, $messages);
      
          if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
          }

          Tbbprc::where('id_bprc', $id)->update([  
            'Ur_bprc' => $request->Ur_bprc,
            'rftr_bprc' => $request->rftr_bprc,
            'dt_rftrbprc' => $request->dt_rftrbprc,
            'No_PD' => $request->No_PD,
            'Ko_sKeg1' => $request->Ko_sKeg1,
            'Ko_sKeg2' => $request->Ko_sKeg2,
            'Ko_Rkk' => $request->Ko_Rkk,
            'Ko_Pdp' => $request->Ko_Pdp,
            'Ko_pmed' => $request->Ko_pmed,
            'To_Rp' => $request->To_Rp,
            'ko_kas' => $request->Ko_kas,
            'updated_at' => now(),
        ]);
        
        toast("Data Rincian dari Panjar Nomor " . $request->No_bp . " Berhasil Diubah!", "success");

        return redirect()->route("panjar-rinci.pilih", $request->id_bp);
    }

    public function destroy($id)
    {
        $idn = Tbbprc::where('id_bprc',$id)->value('id_bp');
        $panjar_rinci = Tbbprc::find($id);
        $panjar_rinci->delete();

        toast("Data Rincian dari Panjar Berhasil Dihapus!", "success");
        return redirect()->route("panjar-rinci.pilih", $idn);
    }

    public function pilih($id)
    {
        $panjar = Tbbp::find($id);
        $panjar_detail = Tbbprc::where('id_bp', $id)->get();
        
        return view('transaksi.belanja.panjarrinci.index', compact('panjar', 'panjar_detail'));
    }

    public function tambah($id)
    {
        $panjar = Tbbp::find($id);
        $pfpmed = Pfpmed::get()->max();
        
        $kegiatan = DB::select("SELECT a.*, c.ur_rk6, d.Ur_KegBL1, e.Ur_KegBL2 FROM tb_spirc a
                                INNER JOIN tb_spi b ON a.Ko_Period = b.Ko_Period AND a.Ko_unitstr = b.Ko_unitstr AND a.No_spi = b.No_SPi
                                INNER JOIN (
                                SELECT CONCAT(
                                LPAD(Ko_Rk1,2,0),'.' ,
                                LPAD(Ko_Rk2,2,0),'.' ,
                                LPAD(Ko_Rk3,2,0),'.' ,
                                LPAD(Ko_Rk4,2,0),'.' ,
                                LPAD(Ko_Rk5,3,0),'.' ,
                                LPAD(Ko_Rk6,4,0)
                                ) AS RKK6, ur_rk6
                                FROM pf_rk6) c ON a.Ko_Rkk = c.RKK6
                                INNER JOIN tb_kegs1 d ON a.Ko_sKeg1 = d.Ko_sKeg1 AND a.Ko_Period = d.Ko_Period AND a.`Ko_unitstr` = LEFT(d.`ko_unit1`,18)
                                INNER JOIN tb_kegs2 e ON a.Ko_sKeg2 = e.Ko_sKeg2 AND a.Ko_Period = e.Ko_Period AND a.`Ko_unitstr` = LEFT(e.`ko_unit1`,18)
                                WHERE b.Ko_unitstr = ? AND b.Ko_SPi = ? GROUP BY a.id", [kd_unit(),7]);
        
        $max = Tbbprc::where('Ko_Period',Tahun())
        ->where('No_bp', $panjar->No_bp)
        ->where('Ko_Unit1', $panjar->Ko_unit1)
        ->max('Ko_bprc');
                                    
        return view('transaksi.belanja.panjarrinci.create', compact('panjar', 'kegiatan', 'pfpmed', 'max'));
    }
}
