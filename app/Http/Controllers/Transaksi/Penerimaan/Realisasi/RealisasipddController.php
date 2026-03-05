<?php

namespace App\Http\Controllers\Transaksi\Penerimaan\Realisasi;

use App\Http\Controllers\Controller;
use App\Models\Pfbank;
use App\Models\Tbbp;
use App\Models\Tbbyr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RealisasipddController extends Controller
{
    public function index()
    {
        $data = DB::select(DB::raw('SELECT * FROM tb_bp a
                LEFT JOIN (SELECT a.id_bp,a.No_bp,SUM(a.To_Rp) piutang,SUM(b.real_rp) realisasi FROM tb_bprc a
                LEFT JOIN tb_byr b ON a.id_bprc = b.id_bprc
                GROUP BY a.no_bp) b ON a.id_bp = b.id_bp
                WHERE a.Ko_bp = 42 && a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'" && b.id_bp IS NOT NULL
                ORDER BY a.dt_bp DESC'));
        $realisasi = Tbbp::where('Ko_bp',42)->orderBy('id_bp')->orderBy('Ko_Period')->get();
        return view('transaksi.penerimaan.realisasi.pdd.index', compact('realisasi','data'));
    }

    public function v_bulan(Request $request,$id)
    {
      $bulan = $id;
      $request->session()->put('bulan', $bulan);

      $data = DB::select(DB::raw('SELECT * FROM tb_bp a
      LEFT JOIN (SELECT a.id_bp,a.No_bp,SUM(a.To_Rp) piutang,SUM(b.real_rp) realisasi FROM tb_bprc a
      LEFT JOIN tb_byr b ON a.id_bprc = b.id_bprc
      GROUP BY a.no_bp) b ON a.id_bp = b.id_bp
      WHERE a.Ko_bp = 42 && a.Ko_Period = "'.Tahun().'" && a.Ko_unit1 = "'.kd_bidang().'" && b.id_bp IS NOT NULL
      ORDER BY a.dt_bp DESC'));
      $realisasi = Tbbp::where('Ko_bp',42)->orderBy('id_bp')->orderBy('Ko_Period')->get();

      return view('transaksi.penerimaan.realisasi.pdd.index', compact('realisasi','data','bulan'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function store_rinci(Request $request)
    {
        Tbbyr::create([      
            'id_bprc'    => $request->input('id_bprc'),
            'Ko_Period'  => $request->input('Ko_Period'),
            'Ko_unitstr' => kd_unit(),
            'No_byr'     => $request->input('No_byr'),
            'dt_byr'     => $request->input('dt_byr'),
            'Ur_byr'     => $request->input('Ur_byr'),
            'No_bp'      => $request->input('No_bp'),
            'Ko_bprc'    => $request->input('Ko_bprc'),
            'real_rp'    => $request->input('real_rp'),
            'ko_kas'     => $request->input('ko_kas'),
            'Ko_Bank'    => $request->input('Ko_Bank'),
            'Nm_Byr'     => $request->input('Nm_Byr'),
            'Tag'        => '0',
            'tb_ulog'    => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $data = [      
            'No_byr'     => $request->input('No_byr'),
            'dt_byr'     => $request->input('dt_byr'),
            'Ur_byr'     => $request->input('Ur_byr'),
            'No_bp'      => $request->input('No_bp'),
            'ko_kas'     => $request->input('ko_kas'),
            'Ko_Bank'    => $request->input('Ko_Bank')
        ];

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return json_encode(array(
            'statusCode' => 200,
            'data' => $data
        ));
    }

    public function show($id){

    }

    public function tambah($id)
    {
        $Ko_Wil1 = intval(substr(kd_unit(), 0, 2));
        $Ko_Wil2 = intval(substr(kd_unit(), 3, 2));
        $Ko_Urus = intval(substr(kd_unit(), 6, 2));
        $Ko_Bid  = intval(substr(kd_unit(), 9, 2));
        $Ko_Unit = intval(substr(kd_unit(), 12, 2));
        $Ko_Sub  = intval(substr(kd_unit(), 15, 3));
        $data    = Tbbp::where('id_bp',$id)->where('Ko_Period',Tahun())->where('Ko_unit1',kd_bidang())->first();
        $data2   = DB::select(DB::raw('select id_bp, Sum(To_Rp) AS Total From tb_bprc where id_bp = '.$id));

        $rincian = DB::select(DB::raw('SELECT a.*,SUM(b.real_rp) realisasi FROM tb_bprc a
                LEFT JOIN tb_byr b ON a.id_bprc = b.id_bprc
                WHERE a.id_bp = "'.$id.'" && a.Ko_Period = "'.Tahun().'"
                GROUP BY a.id_bprc'));
        $bank = Pfbank::where([ 'Ko_Wil1'=>$Ko_Wil1, 
                'Ko_Wil2'=>$Ko_Wil2, 
                'Ko_Urus'=>$Ko_Urus, 
                'Ko_Bid'=>$Ko_Bid, 
                'Ko_Unit'=>$Ko_Unit, 
                'Ko_Sub'=>$Ko_Sub 
                ])->get();
        $no_bp = Tbbp::where('id_bp',$id)->where('Ko_Period',Tahun())->where('Ko_unit1',kd_bidang())->first();

        $bayar = Tbbyr::where('no_bp',$no_bp->No_bp)->where('Ko_Period',Tahun())->where('Ko_unitstr',kd_unit())->get();
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
                                
        $cekbyr     = Tbbyr::where('id_bprc',$id)->where('Ko_Period',Tahun())->where('Ko_unitstr',kd_unit())->first();
        if(empty($cekbyr)){
        return view('transaksi.penerimaan.realisasi.pdd.create', compact('data','data2','rincian','bank','bayar','pegawai'));
        }else{
            Alert::error('Tidak Dapat Melakukan Penambahan Data', "Data Sudah Tersedia");
            return back();   
        }
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $data = Tbbyr::where('id_byr',$id);
        $data->delete();
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}
