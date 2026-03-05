<?php

namespace App\Http\Controllers\Transaksi\Belanja\Kuitansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp; 
use App\Models\Tbbyr; 
use App\Models\Tbbprc; 
use App\Models\Pfjnpdp; 
use App\Models\Pfjnpdpr;
use App\Models\Tbrekan;
use App\Models\Tbtap;
use App\Models\Tbtax;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Exception;

class KuitansiController extends Controller
{
    public function index()
    {
        $Ko_Period = Tahun();
        $data = DB::select(DB::raw('select a.*, c.rekan_nm, b.Ko_unit1, SUM(b.To_Rp) AS Total, d.sum_tax AS t_tax
                                    from tb_bp a
                                    left join tb_bprc b
                                    ON a.Ko_unit1 = b.Ko_unit1
                                    AND a.id_bp = b.id_bp
                                    LEFT JOIN tb_rekan c
                                    ON a.nm_BUcontr = c.id_rekan
                                    LEFT JOIN (SELECT d.id_bp, SUM(d.tax_Rp) AS sum_tax FROM tb_tax d GROUP BY d.id_bp) AS d
                                    ON a.id_bp = d.id_bp
                                    WHERE a.Ko_bp = 5
                                    AND a.Ko_Period = "'.$Ko_Period.'" AND a.Ko_unit1 = "'.kd_bidang().'"
                                    GROUP BY a.id_bp ORDER BY a.dt_bp DESC'));

        $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')->where('Ko_bp','5')->get();
        return view('transaksi.belanja.kuitansi.index', compact('data'));
    }

    public function v_bulan(Request $request,$id)
    {
        $bulan = $id;
        $request->session()->put('bulan', $bulan);
        $Ko_Period = Tahun();

        $data = DB::select(DB::raw('select a.*, c.rekan_nm, b.Ko_unit1, SUM(b.To_Rp) AS Total, d.sum_tax AS t_tax
                                    from tb_bp a
                                    left join tb_bprc b
                                    ON a.Ko_unit1 = b.Ko_unit1
                                    AND a.id_bp = b.id_bp
                                    LEFT JOIN tb_rekan c
                                    ON a.nm_BUcontr = c.id_rekan
                                    LEFT JOIN (SELECT d.id_bp, SUM(d.tax_Rp) AS sum_tax FROM tb_tax d GROUP BY d.id_bp) AS d
                                    ON a.id_bp = d.id_bp
                                    WHERE a.Ko_bp = 5
                                    AND a.Ko_Period = "'.$Ko_Period.'" AND a.Ko_unit1 = "'.kd_bidang().'" AND MONTH(a.dt_bp) = "'.$bulan.'"
                                    GROUP BY a.id_bp ORDER BY a.dt_bp DESC'));

        $belanja = Tbbp::orderBy('id_bp')->orderBy('Ko_Period')->where('Ko_bp','5')->get();

        return view('transaksi.belanja.kuitansi.index', compact('data','bulan'));
    }

    public function create()
    {
        $max = Tbbp::max('id_bp');
        $max1 = $max+1;
        
        $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
        return view('transaksi.belanja.kuitansi.create', compact('max1','rekanan'));
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

        $ceknobp = Tbbp::where('No_bp',$request->NoBp)->first();
        $bulan = Carbon::parse($request->DtBp)->format('m');

        if(empty($ceknobp)){  
            Tbbp::create([          
                'Ko_Period' => Tahun(),
                'Ko_unit1'  => kd_bidang(),
                'Ko_bp'     => '5',
                'No_bp'     => $request->NoBp,
                'dt_bp'     => $request->DtBp,
                'Ur_bp'     => $request->UrBp,
                'nm_BUcontr'  => $request->NmBuContr,
                'Nm_input'  => 'admin',
                'tb_ulog'   => 'admin',
                'created_at'=> now(),
            ]);

            Alert::success('Berhasil', 'Data berhasil ditambah');
            return redirect()->route('kuitansi.bulan',$bulan);
        }else{
            Alert::error('Gagal', 'Nomor BP Sudah Ada');
            return redirect()->route('kuitansi.bulan',$bulan);
        }    
    }

    public function rincian($id)
    {
        $realisasi = Tbbyr::where('id_bp',$id)->get();
        return view('transaksi.belanja.kuitansi.rincian', compact( 'realisasi'));
    }

    public function show($id_bp)
    {
        // dd($id_bp);
    //     $kegiatan = Tbtap::all();
    //     $sumber = Pfjnpdp::all();
    //     $sumber2 = Pfjnpdpr::all();

    //     $rincian = DB::select(DB::raw('select a.*, b.* 
    //         from tb_bp a
    //         join tb_bprc b 
    //         on a.No_bp = b.No_bp
    //         where a.id_bp = '.$id_bp));
    //     return view('transaksi.belanja.kuitansi.show', compact( 'rincian','sumber','sumber2','kegiatan' ));
    }

    public function edit($id)
    {
        $data = Tbbp::where(['Ko_bp' => 5, 'id_bp' => $id])->first();
        $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->get();
        return view('transaksi.belanja.kuitansi.edit',compact('data','rekanan')); 
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

          $bulan = Carbon::parse($request->DtBp)->format('m');

          Tbbp::where('id_bp', $id)->update([
            'No_bp' => $request->NoBp,
            'dt_bp' => $request->DtBp,
            'Ur_bp' => $request->UrBp,
            'nm_BUcontr' => $request->NmBuContr,
            'adr_bucontr'=> $request->AdrBuCntr,
            'updated_at' => now(),
          ]);

          Alert::success('Berhasil', 'Data berhasil dirubah');
          return redirect()->route('kuitansi.bulan',$bulan);
    }

    public function destroy($id)
    {
        $bulan = Session::get('bulan');
        $data = Tbbp::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Data kuitansi berhasil dihapus');
        return redirect()->route('kuitansi.bulan',$bulan);
    }

    public function pajak($id)
    {
        $kuitansi = Tbbp::where('id_bp',$id)->first();
        // $pajak = DB::select(DB::raw('SELECT a.*,b.* FROM tb_tax a LEFT JOIN tb_bp b ON a.id_bp=b.id_bp WHERE b.id_bp = "'.$id.'"'));
        $pajak   = DB::select(DB::raw("SELECT a.*,b.*,c.ur_rk6 FROM tb_tax a 
                    LEFT JOIN tb_bp b 
                    ON a.id_bp=b.id_bp
                    LEFT JOIN (SELECT CONCAT(
                    LPAD(Ko_Rk1,2,0),'.' ,
                    LPAD(Ko_Rk2,2,0),'.' ,
                    LPAD(Ko_Rk3,2,0),'.' ,
                    LPAD(Ko_Rk4,2,0),'.' ,
                    LPAD(Ko_Rk5,3,0),'.' ,
                    LPAD(Ko_Rk6,4,0)
                    ) AS rkk, ur_rk6
                    FROM pf_rk6
                    WHERE Ko_Rk1 = '2' AND  Ko_Rk2 = '1' AND  Ko_Rk3 = '1') c
                    ON a.Ko_Rkk = c.rkk 
                    WHERE b.id_bp = '".$id."'"));

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
        return view('transaksi.belanja.kuitansi.pajak.index',compact('kuitansi','pajak','rkk6'));
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
