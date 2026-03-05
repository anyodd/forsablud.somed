<?php

namespace App\Http\Controllers\Definitif\Spd;

use App\Http\Controllers\Controller;
use App\Models\Tbpd;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SpdController extends Controller
{
    public function index()
    {
        $spd = Tbpd::where('Ko_Period', Tahun())->where('Ko_unit1', 'like', kd_unit().'%')->get();

        return view('definitif.spd.index', compact('spd'));
    }

    public function create()
    {
        $query_pd = "SELECT dt_PD AS min, CURDATE() AS max FROM tb_pd
                    WHERE Ko_Period = ?
                    AND Ko_unit1 LIKE ?
                    AND dt_PD = (SELECT MAX(dt_PD) FROM tb_pd WHERE Ko_Period = ? AND Ko_unit1 LIKE ?)
                    LIMIT 1";

        $date = DB::select($query_pd, [
            Tahun(),
            kd_unit() . "%",
            Tahun(),
            kd_unit() . "%",
        ]);

        return view('definitif.spd.create', compact('date'));
    }
    
    public function store(Request $request)
    {
        $user = Session::get('userData')['username'];

        $query_pd = "SELECT dt_PD AS min, CURDATE() AS max FROM tb_pd
                    WHERE Ko_Period = ?
                    AND Ko_unit1 LIKE ?
                    AND dt_PD = (SELECT MAX(dt_PD) FROM tb_pd WHERE Ko_Period = ? AND Ko_unit1 LIKE ?)
                    LIMIT 1";

        $date = DB::select($query_pd, [
            Tahun(),
            kd_unit() . "%",
            Tahun(),
            kd_unit() . "%",
        ]);
        
        $rules = [
            "noSpd" => "required",
            // "tanggalSpd" => "required|after_or_equal:" . $date[0]->min,
            "tanggalSpd" => "required",
            "uraianSpd" => "required",
            "nmPenandatanganSpd" => "required",
            "nipPenandatanganSpd" => "required",
        ];

        $messages = [
            "noSpd.required" => "Nomor SPD wajib diisi.",
            "tanggalSpd.required" => "Tanggal SPD wajib diisi.",
            "tanggalSpd.after_or_equal" => "Tanggal SPD mendahului tanggal SPD terakhir.",
            "uraianSpd.required" => "Uraian SPD wajib diisi.",
            "nmPenandatanganSpd.required" => "Nama wajib diisi.",
            "nipPenandatanganSpd.required" => "NIP wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Tbpd::create([
            'Ko_Period' => Tahun(),
            'Ko_unit1' => kd_bidang(),
            'No_PD' => $request->noSpd,
            'dt_PD' => $request->tanggalSpd,
            'Ur_PD' => $request->uraianSpd,
            'NIP_Pj' => $request->nipPenandatanganSpd,
            'Nm_PJ' => $request->nmPenandatanganSpd,
            'fl_PD' => 0,
            'tb_ulog' => $user,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        toast('SPD Nomor ' . $request->noSpd . ' berhasil dibuat', 'success');

        return redirect()->route('spd.index');
    }

    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        $spd = Tbpd::find($id);

        return view('definitif.spd.edit', compact('spd'));
    }

    public function update(Request $request, $id)
    {
        $user = Session::get('userData')['username'];
        
        $spd = Tbpd::find($id);
        
        $rules = [
            "noSpd" => "required",
            "tanggalSpd" => "required",
            "uraianSpd" => "required",
            "nmPenandatanganSpd" => "required",
            "nipPenandatanganSpd" => "required"
        ];

        $messages = [
            "noSpd.required" => "Nomor SPD wajib diisi.",
            "tanggalSpd.required" => "Tanggal SPD wajib diisi.",
            "uraianSpd.required" => "Uraian SPD wajib diisi.",
            "nmPenandatanganSpd.required" => "Nama wajib diisi.",
            "nipPenandatanganSpd.required" => "NIP wajib diisi."
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $spd->No_PD = $request->noSpd;
        $spd->dt_PD = $request->tanggalSpd;
        $spd->Ur_PD = $request->uraianSpd;
        $spd->Nm_PJ = $request->nmPenandatanganSpd;
        $spd->NIP_Pj = $request->nipPenandatanganSpd;
        $spd->tb_ulog = $user;
        $spd->updated_at = now();
        $spd->save();

        toast('SPD Nomor ' . $request->noSpd . ' berhasil diubah', 'success');

        return redirect()->route('spd.index');
    }

    public function destroy($id)
    {
        $spd = Tbpd::find($id);
        $spd->delete();

        toast('SPD Nomor ' . $spd->No_PD . ' berhasil dihapus', 'success');

        return redirect()->route('spd.index');
    }
}
