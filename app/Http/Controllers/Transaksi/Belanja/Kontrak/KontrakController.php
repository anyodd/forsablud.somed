<?php

namespace App\Http\Controllers\Transaksi\Belanja\Kontrak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp;
use App\Models\Tbbprc;
use App\Models\Pfjnpdp;
use App\Models\Pfjnpdpr;
use App\Models\Tbtap;
use App\Models\Tbcontr;
use App\Models\Tbrekan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class KontrakController extends Controller
{
    public function index()
    {
        $Ko_Period = Tahun();
        $unit = kd_unit();
        $bidang = kd_bidang();

        $data = Tbcontr::select('tb_contr.*',DB::raw('tb_rekan.*,SUM(tb_contrc.To_Rp) As jml'))
                ->leftJoin('tb_contrc', function ($join) {
                    $join->on('tb_contr.Ko_Period', '=', 'tb_contrc.Ko_Period');
                    $join->on('tb_contr.ko_unit1', '=', 'tb_contrc.ko_unit1');
                    $join->on('tb_contr.No_contr', '=', 'tb_contrc.No_contr');
                })->leftJoin('tb_rekan', function($join){
                    $join->on('tb_contr.nm_BU','=','tb_rekan.id_rekan');
                })
                ->where(['tb_contr.Ko_Period' => Tahun(), 'tb_contr.ko_unit1' => kd_bidang()])
                ->groupBy('tb_contr.No_contr')
                ->orderBy('tb_contr.dt_contr','DESC')
                ->get();

        return view('transaksi.belanja.kontrak.index', compact('unit', 'Ko_Period', 'data'));
    }

    public function v_bulan(Request $request,$id)
    {
        $bulan = $id;
        $request->session()->put('bulan', $bulan);
        $Ko_Period = Tahun();
        $unit = kd_unit();

        $data = Tbcontr::select('tb_contr.*',DB::raw('tb_rekan.*,SUM(tb_contrc.To_Rp) As jml'))
                ->leftJoin('tb_contrc', function ($join) {
                    $join->on('tb_contr.Ko_Period', '=', 'tb_contrc.Ko_Period');
                    $join->on('tb_contr.ko_unit1', '=', 'tb_contrc.ko_unit1');
                    $join->on('tb_contr.No_contr', '=', 'tb_contrc.No_contr');
                })->leftJoin('tb_rekan', function($join){
                    $join->on('tb_contr.nm_BU','=','tb_rekan.id_rekan');
                })
                ->where(['tb_contr.Ko_Period' => Tahun(), 'tb_contr.ko_unit1' => kd_bidang()])
                ->whereMonth('tb_contr.dt_contr', '=', $bulan)
                ->groupBy('tb_contr.No_contr')
                ->orderBy('tb_contr.dt_contr','DESC')
                ->get();

        return view('transaksi.belanja.kontrak.index', compact('unit', 'Ko_Period', 'data','bulan'));
    }

    public function rincian($id_bp)
    {
        $kegiatan = Tbtap::all();
        $sumber = Pfjnpdp::all();
        $sumber2 = Pfjnpdpr::all();

        $rincian = DB::select(DB::raw('select a.*, b.*
            from tb_bp a
            join tb_bprc b
            on a.No_bp = b.No_bp
            where a.id_bp = ' . $id_bp));
        return view('transaksi.belanja.subkontrak.rincian', compact('rincian', 'sumber', 'sumber2', 'kegiatan'));
    }

    public function create()
    {
        $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");

        return view('transaksi.belanja.kontrak.create',compact('rekanan','pegawai'));
    }

    public function store(Request $request)
    {
        $rules = [
            'No_contr' => 'required',
            'dt_contr' => 'required',
            'Ur_contr' => 'required',
            'nm_ppk'   => 'required',
            'nm_BU'    => 'required',
        ];

        $messages = [
            'No_contr.required' => 'Nomor Bukti wajib diisi.',
            'dt_contr.required' => 'Tanggal wajib diisi.',
            'Ur_contr.required' => 'Uraian wajib diisi.',
            'nm_ppk.required'   => 'Nama PPK wajib diisi.',
            'nm_BU.required'    => 'Nama Penyedia wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $bulan = Carbon::parse($request->dt_contr)->format('m');

        Tbcontr::create([
            'Ko_Period' => Tahun(),
            'Ko_unit1' => kd_bidang(),
            'No_contr' => $request->No_contr,
            'dt_contr' => $request->dt_contr,
            'nm_BU' => $request->nm_BU,
            'Ur_contr' => $request->Ur_contr,
            'nm_ppk' => $request->nm_ppk,
            'Tag' => 0,
            'tb_ulog' => getUser('username'),
            'created_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('kontrak.bulan',$bulan);
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
        return view('transaksi.belanja.kontrak.show', compact('rincian', 'sumber', 'sumber2', 'kegiatan'));
    }

    public function edit($id)
    {
        $data = Tbcontr::where('id_contr', $id)->first();
        $rekanan = Tbrekan::where('Ko_unitstr', kd_unit())->orderBy('rekan_nm')->get();
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
                    
        return view('transaksi.belanja.kontrak.edit', compact('data','rekanan','pegawai'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'No_contr' => 'required',
            'dt_contr' => 'required',
            'Ur_contr' => 'required',
            'nm_ppk'   => 'required',
            'nm_BU'    => 'required',
        ];

        $messages = [
            'No_contr.required' => 'Nomor Bukti wajib diisi.',
            'dt_contr.required' => 'Tanggal wajib diisi.',
            'Ur_contr.required' => 'Uraian wajib diisi.',
            'nm_ppk.required'   => 'Nama PPK wajib diisi.',
            'nm_BU.required'    => 'Nama Penyedia wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $bulan = Carbon::parse($request->dt_contr)->format('m');

        Tbcontr::where('id_contr',$id)->update([
            'No_contr'  => $request->No_contr,
            'dt_contr'  => $request->dt_contr,
            'nm_BU'     => $request->nm_BU,
            'Ur_contr'  => $request->Ur_contr,
            'nm_ppk'    => $request->nm_ppk,
            'tb_ulog'   => getUser('username'),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('kontrak.bulan',$bulan);
    }

    public function destroy($id)
    {
        $bulan = Session::get('bulan');
        $kontrak = Tbcontr::where('id_contr',$id);
        $kontrak->delete();
        // $pajak->Jrpajaks()->delete();
        Alert::success('Berhasil', "Kontrak berhasil dihapus");
        return redirect()->route('kontrak.bulan',$bulan);
    }
}
