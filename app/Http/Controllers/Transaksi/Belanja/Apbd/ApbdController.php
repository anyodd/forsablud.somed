<?php
namespace App\Http\Controllers\Transaksi\Belanja\Apbd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp;
use App\Models\Tbbprc;
use App\Models\Pfjnpdp;
use App\Models\Pfjnpdpr;
use App\Models\Tbtap;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class ApbdController extends Controller
{
    public function index()
    {
        $periode = Tahun();
        $kounit = kd_unit();
        $kounit1 = kd_bidang();

        $belanja = Tbbp::select('tb_bp.*',DB::raw('SUM(tb_bprc.To_Rp) As jml'))
                ->leftJoin('tb_bprc', function ($join) {
                    $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                    $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                    $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                })
                ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 2])
                ->groupBy('tb_bp.id_bp')
                ->get();
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
        
        return view('transaksi.belanja.apbd.index', compact('periode', 'kounit', 'belanja','pegawai'));
    }

    public function v_bulan(Request $request,$id)
    {
        $bulan = $id;
        $request->session()->put('bulan', $bulan);

        $periode = Tahun();
        $kounit = kd_unit();
        $kounit1 = kd_bidang();

        $belanja = Tbbp::select('tb_bp.*',DB::raw('SUM(tb_bprc.To_Rp) As jml'))
                ->leftJoin('tb_bprc', function ($join) {
                    $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                    $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                    $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                })
                ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 2])
                ->whereMonth('tb_bp.dt_bp', '=', $bulan)
                ->groupBy('tb_bp.id_bp')
                ->orderBy('tb_bp.dt_bp','DESC')
                ->get();

        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
        
        return view('transaksi.belanja.apbd.index', compact('periode', 'kounit', 'belanja','pegawai','bulan'));
    }

    public function create()
    {
       //
    }

    public function store(Request $request)
    {
        $Ko_Period  = Tahun();
        $Ko_bp      = '2';
        $Ko_unit1   = kd_bidang();
        $tb_ulog    = 'admin';
        $created_at = NOW();
        $update_at  = NOW();

        $rules = [
            "No_bp"       => "required",
            "dt_bp"       => "required",
            "Ur_bp"       => "required",
            "nm_BUcontr"  => "required",
            "adr_bucontr" => "required",
            "Nm_input"    => "required",
            "Jn_Spm"      => "required",
        ];

        $messages = [
            "No_bp.required"      => "Nomor Bukti wajib diisi.",
            "dt_bp.required"      => "Tanggal wajib diisi.",
            "Ur_bp.required"      => "Uraian wajib diisi.",
            "nm_BUcontr.required" => "Nama wajib diisi.",
            "AdrBuCntr.required"  => "Alamat wajib diisi.",
            "Nm_input.required"   => "Petugas wajib diisi.",
            "Jn_Spm"              => "Jenis SP2D wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $bulan = Carbon::parse($request->dt_bp)->format('m');

        Tbbp::create([
            'Ko_Period'  => $Ko_Period,
            'Ko_unit1'   => $Ko_unit1,
            'Ko_bp'      => $Ko_bp,
            'No_bp'      => $request->No_bp,
            'dt_bp'      => $request->dt_bp,
            'Ur_bp'      => $request->Ur_bp,
            'Jn_Spm'     => $request->Jn_Spm,
            'nm_BUcontr' => $request->nm_BUcontr,
            'adr_bucontr' => $request->adr_bucontr,
            'Nm_input'    => $request->Nm_input,
            'tb_ulog'     => $tb_ulog,
            'created_at'  => $created_at,
            'update_at'   => $update_at
        ]);

        Alert::success('Berhasil', "Data berhasil ditambah");
        return redirect()->route('apbd.bulan',$bulan);
    }


    public function show($id_bp)
    {
        $kegiatan = Tbtap::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();

        $rincian = DB::select(DB::raw('select a.*, b.*
            from tb_bp a
            join tb_bprc b
            on a.No_bp = b.No_bp
            where a.id_bp = ' . $id_bp));
        return view('transaksi.belanja.apbd.show', compact('rincian', 'sumber', 'sumber2', 'kegiatan'));
    }

    public function edit($id_bp)
    {
        $data = Tbbp::where('id_bp', $id_bp)->get();
        return view('transaksi.belanja.apbd.edit', compact('data'));
    }

    public function update(Request $request, $apbd)
    {
        $rules = [
            "No_bped"       => "required",
            "dt_bped"       => "required",
            "Ur_bped"       => "required",
            "nm_BUcntred"   => "required",
            "adr_bucntred"  => "required",
            "Nm_inputed"    => "required",
            "Jn_Spm"        => "required",
        ];

        $messages = [
            "No_bped.required"      => "Nomor Bukti wajib diisi.",
            "dt_bped.required"      => "Tanggal wajib diisi.",
            "Ur_bped.required"      => "Uraian wajib diisi.",
            "nm_BUcntred.required"  => "Nama wajib diisi.",
            "adr_bucntred.required" => "Alamat wajib diisi.",
            "Nm_inputed.required"   => "Nama Petugas wajib diisi.",
            "Jn_Spm"                => "Jenis SP2D wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $bulan = Carbon::parse($request->dt_bped)->format('m');

        Tbbp::where('id_bp', $apbd)->update([
            'No_bp' => $request->No_bped,
            'dt_bp' => $request->dt_bped,
            'Ur_bp' => $request->Ur_bped,
            'Jn_Spm'     => $request->Jn_Spm,
            'nm_BUcontr' => $request->nm_BUcntred,
            'adr_bucontr' => $request->adr_bucntred,
            'Nm_input' => $request->Nm_inputed,
            'updated_at' => NOW()
        ]);

        Alert::success('Berhasil', "Data Belanja APBD berhasil dirubah");
        return redirect()->route('apbd.bulan',$bulan);
    }

    public function destroy($apbd)
    {
        $bulan = Session::get('bulan');
        $apbd  = Tbbp::find($apbd);
        $apbd->delete();

        Alert::success('Berhasil', "Penyesuaian $apbd->Ko_Rkk berhasil dihapus");
        return redirect()->route('apbd.bulan',$bulan);
    }
}
