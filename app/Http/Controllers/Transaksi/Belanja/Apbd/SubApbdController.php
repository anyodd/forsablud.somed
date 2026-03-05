<?php

namespace App\Http\Controllers\Transaksi\Belanja\Apbd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr; 
use App\Models\Tbtap;
use App\Models\Tbbyr;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use RealRashid\SweetAlert\Facades\Alert;


class SubApbdController extends Controller
{
    public function index()
    {
        // 
    }

    public function rincian($id_bp)
    {
        $cek        = Tbbyr::where('id_bprc',$id_bp)->first();
        $rincian    = DB::select(DB::raw('SELECT a.*, b.* 
            FROM tb_bp a
            JOIN tb_bprc b 
            ON a.id_bp = b.id_bp
            WHERE a.id_bp = "'.$id_bp.'"'));
        return view('transaksi.belanja.subapbd.rincian', compact( 'rincian','cek' ));
    }

    public function create()
    {
        // 
    }

    public function tambah($idbp)
    {
        $data = Tbbp::where('id_bp',$idbp)->where('Ko_Period',Tahun())->first();
        $PD = 1;

        $caridata = DB::select('call vdata_btransAP('.Tahun().', "'.kd_bidang().'",'.$PD.')');
        $datafinal = collect($caridata);

        $max = Tbbprc::where('Ko_Period', Tahun())
        ->where('No_bp', $data->No_bp)
        ->where('Ko_Unit1', $data->Ko_unit1)
        ->max('Ko_bprc');

        return view('transaksi.belanja.subapbd.create', compact('data', 'max','datafinal' ));
    }

    public function store(Request $request)
    {
        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "To_Rp" => "required",
            "Ko_Pdp" => "required",
        ];

        $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "To_Rp.required" => "Nilai (Rp) wajib diisi.",
            "Ko_Pdp.required" => "Jenis Sumber Kegiatan Wajib Diisi",
        ];
        $validator = FacadesValidator::make($request->all(), $rules, $messages);

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
            'Ko_Pdp' => 1,
            'ko_pmed' => 99,
            'To_Rp' => $request->To_Rp,
            'ko_kas' => $request->Ko_kas,
            'tb_ulog' => getUser('username'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        Alert::success('Berhasil', "Data Berhasil Ditambah");
        return redirect()->route('subapbd.rincian', $request->id_bp);
    }


    public function show($id)
    {

        $rincian = Tbbprc::where('id',$id)->get();
        return view('transaksi.belanja.subtagihan.show', compact('rincian'));
    }

    public function edit($id)
    {
        $data = Tbbprc::where('id_bprc',$id)->first();
        $kegiatan = Tbtap::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $PD = 1;

        $caridata = DB::select('call vdata_btransAP('.$tahun.', "'.$kounit1.'",'.$PD.')');;
        $datafinal = collect($caridata);
        $ko_skeg1 = Tbbprc::where('id_bprc',$id)->value('ko_skeg1');
        $ko_skeg2 = Tbbprc::where('id_bprc',$id)->value('ko_skeg2');
        $ko_rkk = Tbbprc::where('id_bprc',$id)->value('ko_rkk');
        $dt_view = collect($caridata)->where('ko_skeg1',$ko_skeg1)->where('ko_skeg2',$ko_skeg2)->where('ko_rkk',$ko_rkk)->first();
        // dd($data);
        return view('transaksi.belanja.subapbd.edit', compact('data','datafinal', 'dt_view'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "Ur_bprc" => "required",
            "rftr_bprc" => "required",
            "To_Rp" => "required",
            "dt_rftrbprc" => "required",
        ];
        
        $messages = [
            "Ur_bprc.required" => "Uraian Pembayaran Wajib Diisi",
            "rftr_bprc.required" => "Nomor Bukti Wajib Diisi",
            "To_Rp.required" => "Nilai (Rp) wajib diisi.",
            "dt_rftrbprc.required" => "Tanggal referensi wajib diisi.",
        ];
        $validator = FacadesValidator::make($request->all(), $rules, $messages);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = Tbbprc::find($id);

        $data->To_Rp = $request->To_Rp;
        $data->Ko_sKeg1 = $request->Ko_sKeg1;
        $data->Ko_sKeg2 = $request->Ko_sKeg2;
        $data->Ko_Rkk = $request->Ko_Rkk;
        $data->Ur_bprc = $request->Ur_bprc;
        $data->rftr_bprc = $request->rftr_bprc;
        $data->dt_rftrbprc = $request->dt_rftrbprc;
        $data->Ko_kas = $request->Ko_kas;
        $data->tb_ulog = getUser('username');
        $data->updated_at = now();
        $data->save();

        Alert::success('Berhasil', 'Data berhasil dirubah');
        return redirect()->route('subapbd.rincian', $data->id_bp);
    }

    public function destroy($id)
    {
        $idbp = Tbbprc::select('id_bp')->where('id_bprc',$id)->first();
        $bprc = DB::select(DB::raw('select a.* 
            from tb_bprc a
            join tb_spirc b
            ON a.rftr_bprc = b.rftr_bprc
            where a.id_bprc ='.$id.' and a.Ko_Period = b.Ko_Period and left(a.Ko_unit1,18) = b.Ko_unitstr
            AND a.No_bp  = b.No_bp'));

        if(empty($bprc)){
            $bprc = Tbbprc::where('id_bprc',$id);
            $bprc->delete();
            Alert::success('Berhasil', "Data Rincian Belanja berhasil Dihapus");

            return redirect()->route('subapbd.rincian', $idbp->id_bp);
        }else{
            //Alert::success('Yeay!', 'berhasil dihapus');
            return back()->with('alert','Data Pengajuan SPJ Telah Tersedia, tidak dapat dilakukan perubahan data.');
            //return back();
        }
    }

}
