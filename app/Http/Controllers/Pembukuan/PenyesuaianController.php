<?php

namespace App\Http\Controllers\Pembukuan;

use App\Models\Tbsesuai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Jrsesuai;
use App\Models\Pfrk6;
use App\Models\Tbspirc;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Yajra\DataTables\Facades\DataTables;

class PenyesuaianController extends Controller
{
    public function index()
    {
        $rkk4 = DB::select(DB::raw("SELECT CONCAT(LPAD(Ko_Rk1,2,0),'.' ,
					LPAD(Ko_Rk2,2,0),'.' ,
					LPAD(Ko_Rk3,2,0),'.' ,
					LPAD(Ko_Rk4,2,0)) AS RKK4, ur_rk4 FROM pf_rk4"));
        $pf_sesuai   = DB::select(DB::raw('SELECT * FROM pf_sesuai'));
        $penyesuaian = DB::select(DB::raw('SELECT a.*,b.*,c.Tag status_jr FROM tb_sesuai a
                        JOIN pf_sesuai b ON a.Ko_jr = b.id_sesuai
                        LEFT JOIN jr_sesuai c ON a.id_tbses = c.id_tbses
                        WHERE a.Ko_Period = "'.Tahun().'" && a.Ko_unitstr = "'.kd_unit().'" GROUP BY a.id_tbses'));

        return view('pembukuan.penyesuaian.index', compact('rkk4','pf_sesuai','penyesuaian'));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Sesuai_No'   => 'required',
            'dt_sesuai'   => 'required',
            'Ko_jr'       => 'required',
            'Sesuai_Ur'   => 'required',
        ]);

        // $config = [
        //     'table'  => 'tb_sesuai',
        //     'field'  => 'Sesuai_No',
        //     'length' => 8,
        //     'prefix' => 'Adj-'
        // ];

        // $idadj = IdGenerator::generate($config);

        Tbsesuai::Create([
            'Ko_Period'  => Tahun(),
            'Ko_unitstr' => kd_bidang(),
            'Ko_jr'      => $request->Ko_jr,
            'Sesuai_No'  => $request->Sesuai_No,
            'dt_sesuai'  => $request->dt_sesuai,
            'Sesuai_Ur'  => $request->Sesuai_Ur,
            'tb_ulog'    => getUser('username'),
            'Tag'        => 0,
        ]);

        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect('penyesuaian');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Tbsesuai::where('id_tbses', $id)->update([
            'Ko_jr'      => $request->Ko_jr,
            'Sesuai_No'  => $request->Sesuai_No,
            'dt_sesuai'  => $request->dt_sesuai,
            'Sesuai_Ur'  => $request->Sesuai_Ur,
        ]);

        Jrsesuai::where('id_tbses', $id)->update([
            'dt_sesuai' =>  $request->dt_sesuai,
        ]);

        Alert::success('Berhasil', "Penyesuaian berhasil di update");
        return redirect('penyesuaian');
    }

    public function destroy($id)
    {
        $sesuai = Tbsesuai::find($id);
        $sesuai->delete();
        $sesuai->Jrsesuais()->delete();
        Alert::success('Berhasil', "Data berhasil dihapus");

        return redirect('penyesuaian');
    }

    public function penyesuaiandetail($id)
    {
        // $rekening  = DB::select(DB::raw('SELECT * FROM pf_rk6'));
        $pf_sesuai = DB::select(DB::raw('SELECT * FROM pf_sesuai'));
        
        // $transaksi = Tbspirc::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit()])->orderBy('dt_rftrbprc','DESC')->get();
        
        $sesuai    = DB::select(DB::raw('SELECT * FROM tb_sesuai WHERE id_tbses = "'.$id.'"'));
        $data      = DB::select(DB::raw('SELECT a.*,b.Ur_Rk6 FROM jr_sesuai a 
                    left JOIN pf_rk6 b ON a.Ko_Rkk = b.Ko_RKK
                    WHERE a.id_tbses = "'.$id.'"'));
        
        return view('pembukuan.penyesuaiandetail.index', compact('pf_sesuai','sesuai','data'));
        // return view('pembukuan.penyesuaiandetail.index', compact('transaksi','rekening','sesuai','pf_sesuai','data'));
    }

    public function getTransaksi()
    {
      $data = Tbspirc::where(['Ko_Period' => Tahun(), 'Ko_unitstr' => kd_unit()])->orderBy('dt_rftrbprc','DESC')->get();
      return DataTables::of($data)
      ->addIndexColumn()
      ->addColumn('action', function($row){
        $btn = '<button class="btn btn-xs btn-warning py-0" title="Pilih Data" id="transaksi" data-dismiss="modal"
                  data-nobp = "'.$row->No_bp.'"
                  data-kobprc = "'.$row->Ko_bprc.'"
                  data-skeg1 = "'.$row->Ko_sKeg1.'"
                  data-skeg2 = "'.$row->Ko_sKeg2.'"
                  data-urkegs1 = "'.$row->Ur_KegBL1.'"
                  data-urkegs2 = "'.$row->Ur_KegBL2.'"
                  data-korkk = "'.$row->Ko_Rkk.'"
                  data-urkk = "'.$row->Ur_Rk6.'"
                  >
                    <i class="fas fa-check-alt"></i> Pilih
                </button>';
        return $btn;
      })
      ->rawColumns(['action'])
      ->make(true);
    }

    public function getRekening()
    {
      $data  = DB::select(DB::raw('SELECT Ko_RKK, Ur_Rk6 FROM pf_rk6'));
      return DataTables::of($data)
      ->addIndexColumn()
      ->addColumn('action', function($row){
        $btn = '<button class="btn btn-xs btn-warning py-0" title="Pilih Data" id="rekening" data-dismiss="modal"
                  data-korkk = "'.$row->Ko_RKK.'" data-ur_rkk = "'.$row->Ur_Rk6.'">
                    <i class="fas fa-check-alt"></i> Pilih
                </button>';
        return $btn;
      })
      ->rawColumns(['action'])
      ->make(true);
    }
}
