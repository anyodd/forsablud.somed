<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\Blu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbprc; 
use App\Models\Tbbyr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class PenerimaanBluController extends Controller
{
    // public function index()
    // {
    //   $penerimaan = DB::select(DB::raw('select a.*, b.Ko_unit1, SUM(b.To_Rp) AS Total
    //                               from tb_bp a
    //                               left join tb_bprc b
    //                               ON a.Ko_unit1 = b.Ko_unit1
    //                               AND a.id_bp = b.id_bp
    //                               WHERE a.Ko_bp IN (1,11,42)
    //                               AND a.Ko_Period = '.Tahun().'
    //                               AND a.Ko_unit1 = "'.kd_bidang().'"
    //                               GROUP BY a.id_bp
    //                               ORDER BY a.dt_bp DESC, a.id_bp DESC')); 

    //   return view('transaksi.penerimaan.blu.index', compact('penerimaan'));
    // }

    public function v_bulan(Request $request,$id)
    {
      $bulan = $id;
      $request->session()->put('bulan', $bulan);

      // $penerimaan = DB::select(DB::raw('select a.*, b.Ko_unit1, SUM(b.To_Rp) AS Total
      //                             from tb_bp a
      //                             left join tb_bprc b
      //                             ON a.Ko_unit1 = b.Ko_unit1
      //                             AND a.id_bp = b.id_bp
      //                             WHERE a.Ko_bp IN (1,11,42)
      //                             AND a.Ko_Period = "'.Tahun().'"
      //                             AND a.Ko_unit1 = "'.kd_bidang().'"
      //                             AND MONTH(a.dt_bp) = "'.$bulan.'"
      //                             GROUP BY a.id_bp
      //                             ORDER BY a.dt_bp DESC, a.id_bp DESC')); 

      $penerimaan = DB::select('SELECT a.*,b.id_byr FROM (
                    SELECT a.*, SUM(b.To_Rp) AS Total
                    FROM tb_bp a
                    LEFT JOIN tb_bprc b ON a.Ko_Period = b.Ko_Period AND a.Ko_unit1 = b.Ko_unit1 AND a.id_bp = b.id_bp
                    WHERE a.Ko_bp IN (1,11,42)
                    AND a.Ko_Period = "'.Tahun().'"
                    AND a.Ko_unit1 = "'.kd_bidang().'"
                    AND MONTH(a.dt_bp) = "'.$bulan.'"
                    GROUP BY a.id_bp) a
                    LEFT JOIN tb_byr b ON a.Ko_Period = b.Ko_Period AND LEFT(a.Ko_unit1,18) = b.Ko_unitstr AND a.No_bp = b.No_bp 
                    GROUP BY a.id_bp
                    ORDER BY a.dt_bp DESC, a.id_bp DESC'); 

      return view('transaksi.penerimaan.blu.index', compact('penerimaan','bulan'));
    }

    public function create()
    {
      return view('transaksi.penerimaan.blu.create');
    }

    public function store(Request $request)
    {
      $rules = [
        'NoBp'      => 'required',
        'DtBp'      => 'required',
        'UrBp'      => 'required',
        'NmBuContr' => 'required',
        'AdrBuCntr' => 'required',
        'KoBp'      => 'required',
      ];
  
      $messages = [
        'NoBp.required'      => 'Nomor Bukti wajib diisi.',
        'DtBp.required'      => 'Tanggal wajib diisi.',
        'UrBp.required'      => 'Uraian wajib diisi.',
        'NmBuContr.required' => 'Nama wajib diisi.',
        'AdrBuCntr.required' => 'Alamat wajib diisi.',
        'KoBp.required'      => 'Jenis Penerimaan wajib diisi.',
      ];
  
      $validator = Validator::make($request->all(), $rules, $messages);
  
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

      $bulan = Carbon::parse($request->DtBp)->format('m');

      Tbbp::create([          
          'Ko_Period'   => Tahun(),
          'Ko_unit1'    => kd_bidang(),
          'Ko_bp'       => $request->KoBp,
          'No_bp'       => $request->NoBp,
          'dt_bp'       => $request->DtBp,
          'Ur_bp'       => $request->UrBp,
          'nm_BUcontr'  => $request->NmBuContr,
          'adr_bucontr' => $request->AdrBuCntr,
          'Nm_input'    => getUser('username'),
          'tb_ulog'     => getUser('username'),
          'created_at'  => NOW(),
          'update_at'   => NOW()
      ]);

      Alert::success('Berhasil', 'Data Penerimaan berhasil ditambah');
      return redirect()->route('penerimaan.bulan',$bulan);
    }

    public function show($id_bp)
    {
      //
    }

    public function edit($id_bp)
    {   
        $penerimaan = Tbbp::where('id_bp',$id_bp)->get();
        return view('transaksi.penerimaan.blu.edit', compact('penerimaan'));
    }

    public function update(Request $request, $id)
    {
      $rules = [
          "NoBp"       => "required",
          "DtBp"       => "required",
          "UrBp"       => "required",
          "NmBuContr"  => "required",
          "AdrBuContr" => "required",
        ];
    
        $messages = [
          "NoBp.required"       => "Nomor Bukti wajib diisi.",
          "DtBp.required"       => "Tanggal wajib diisi.",
          "UrBp.required"       => "Uraian wajib diisi.",
          "NmBuContr.required"  => "Nama wajib diisi.",
          "AdrBuContr.required" => "Alamat wajib diisi.",
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $bulan = Carbon::parse($request->DtBp)->format('m');

        Tbbp::where('id_bp', $id)->update([
            'No_bp'       => $request->NoBp,
            'Ur_bp'       => $request->UrBp,
            'dt_bp'       => $request->DtBp,
            'Ko_bp'       => $request->KoBp,
            'nm_BUcontr'  => $request->NmBuContr,
            'adr_bucontr' => $request->AdrBuContr,
            'updated_at'  => NOW()
        ]);

        Alert::success('Berhasil', "Data Penerimaan berhasil dirubah");
        return redirect()->route('penerimaan.bulan',$bulan);
    }

    public function destroy($id)
    {
      $bulan = Session::get('bulan');
      $data = Tbbp::where('id_bp',$id);
      $data->delete();

      Alert::success('Berhasil !!!', "Data berhasil dihapus");
      return redirect()->route('penerimaan.bulan',$bulan);
    }

}
