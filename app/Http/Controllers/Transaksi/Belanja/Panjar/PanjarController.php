<?php

namespace App\Http\Controllers\Transaksi\Belanja\Panjar;

use App\Http\Controllers\Controller;
use App\Models\Pfbp;
use App\Models\Tbbp;
use App\Models\Tbrekan;
use App\Models\Tbtax;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class PanjarController extends Controller
{
    public function index()
    {
        $panjar = Tbbp::select('tb_bp.*',DB::raw('tb_rekan.*,SUM(tb_bprc.To_Rp) As jml, SUM(tb_tax.tax_Rp) AS t_tax'))
                  ->leftJoin('tb_bprc', function ($join) {
                    $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                    $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                    $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                  })->leftJoin('tb_rekan', function($join){
                    $join->on('tb_bp.nm_BUcontr','=','tb_rekan.id_rekan');
                  })->leftJoin('tb_tax', function($join){
                    $join->on('tb_bp.id_bp','=','tb_tax.id_bp');
                  })
                  ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 9])
                  ->groupBy('tb_bp.id_bp')
                  ->get();
              
        return view('transaksi.belanja.panjar.index', compact('panjar'));
    }

    public function create()
    {
      $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
      return view('transaksi.belanja.panjar.create', compact('rekanan'));
    }

    public function store(Request $request)
    {
      $rules = [
          'NoBp' => 'required',
          'DtBp' => 'required',
          'UrBp' => 'required',
          'NmBuContr' => 'required',
        ];
    
        $messages = [
          'NoBp.required' => 'Nomor Bukti wajib diisi.',
          'DtBp.required' => 'Tanggal wajib diisi.',
          'UrBp.required' => 'Uraian wajib diisi.',
          'NmBuContr.required' => 'Nama wajib diisi.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

      Tbbp::create([          
          'Ko_Period' => Tahun(),
          'Ko_unit1'  => kd_bidang(),
          'Ko_bp'     => '9',
          'No_bp'     => $request->NoBp,
          'dt_bp'     => $request->DtBp,
          'Ur_bp'     => $request->UrBp,
          'nm_BUcontr' => $request->NmBuContr,
          'Nm_input'   => 'admin',
          'tb_ulog'    => 'admin',
          'created_at' => now()
      ]);

      Alert::success('Berhasil', 'Data berhasil disimpan');
      return redirect()->route('panjar.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $data = Tbbp::where('id_bp', $id)->first();
      $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
      return view('transaksi.belanja.panjar.edit', compact('data','rekanan'));
    }

    public function update(Request $request, $id)
    {
      $rules = [
        'NoBp' => 'required',
        'DtBp' => 'required',
        'UrBp' => 'required',
        'NmBuContr' => 'required',
      ];
  
      $messages = [
        'NoBp.required' => 'Nomor Bukti wajib diisi.',
        'DtBp.required' => 'Tanggal wajib diisi.',
        'UrBp.required' => 'Uraian wajib diisi.',
        'NmBuContr.required' => 'Nama wajib diisi.',
      ];
  
      $validator = Validator::make($request->all(), $rules, $messages);
  
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
      }

      Tbbp::where('id_bp',$id)->update([          
          'No_bp'     => $request->NoBp,
          'dt_bp'     => $request->DtBp,
          'Ur_bp'     => $request->UrBp,
          'nm_BUcontr' => $request->NmBuContr,
          'updated_at' => now()
      ]);

      Alert::success('Berhasil', 'Data berhasil dirubah');
      return redirect()->route('panjar.index');
    }

    public function destroy($id)
    {   
        $panjar = Tbbp::find($id);
        $panjar->delete();

        toast("Data Panjar Nomor " . $panjar->No_bp . " Berhasil Dihapus!", " success");

        return redirect()->route('panjar.index');
    }

    public function pajak($id)
    {
        $panjar = Tbbp::where('id_bp',$id)->first();
        $pajak = DB::select(DB::raw('SELECT a.*,b.* FROM tb_tax a LEFT JOIN tb_bp b ON a.id_bp=b.id_bp WHERE b.id_bp = "'.$id.'"'));
        $rkk6 = DB::select(DB::raw("SELECT CONCAT(
            LPAD(Ko_Rk1,2,0),'.' ,
            LPAD(Ko_Rk2,2,0),'.' ,
            LPAD(Ko_Rk3,2,0),'.' ,
            LPAD(Ko_Rk4,2,0),'.' ,
            LPAD(Ko_Rk5,3,0),'.' ,
            LPAD(Ko_Rk6,4,0)
            ) AS RKK6, ur_rk6
            FROM pf_rk6
            WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1'"));
        return view('transaksi.belanja.panjar.pajak.index',compact('panjar','pajak','rkk6'));
    }

    public function potongpajak(Request $request)
    {
        $request->validate([
            'id_bp'          => 'required',
            'Ko_Period'      => 'required',
            'Ko_unit1'       => 'required',
            'No_bp'          => 'required',
            'Ko_tax'         => 'required',
            'Ko_Rkk'         => 'required',
            'tax_Rp'         => 'required',
        ]);

        try {
            Tbtax::Create([
                'id_bp'     => $request->id_bp,
                'Ko_Period' => $request->Ko_Period,
                'Ko_unit1'  => $request->Ko_unit1,
                'No_bp'     => $request->No_bp,
                'Ko_tax'    => $request->Ko_tax,
                'Ko_Rkk'    => $request->Ko_Rkk,
                'tax_Rp'    => $request->tax_Rp,
                'Tag'       => 0,
                'tb_ulog'   => 'admin',
                'created_at' => now()
            ]);
            Alert::success('Berhasil', "Pajak berhasil ditambah");
            return back();
        } catch (Exception $e) {
          Alert::warning('Gagal', "Uraian pajak sudah ada");
          return back();
        }
        
    }

    public function editpotongpajak(Request $request,$id)
    {
        $request->validate([
            'Ko_tax'         => 'required',
            'Ko_Rkk'         => 'required',
            'tax_Rp'         => 'required',
        ]);

        try {
            Tbtax::where('id_tax',$id)->update([
                'Ko_tax'    => $request->Ko_tax,
                'Ko_Rkk'    => $request->Ko_Rkk,
                'tax_Rp'    => $request->tax_Rp,
                'updated_at'=> now()

            ]);
            Alert::success('Berhasil', "Pajak berhasil dirubah");
            return back();
        } catch (Exception $e) {
            Alert::warning('Gagal', "Uraian pajak sudah ada");
            return back();
        }
        
    }

    public function destroyPajak($id)
    {
        $data = Tbtax::where('id_tax',$id)->first();
        $data->delete();

        Alert::success('Berhasil', "Pajak berhasil dihapus");
        return back();
    }
}
