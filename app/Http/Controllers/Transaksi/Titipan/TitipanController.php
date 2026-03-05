<?php

namespace App\Http\Controllers\Transaksi\Titipan;

use App\Models\Tbbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tbbprc;
use RealRashid\SweetAlert\Facades\Alert;

class TitipanController extends Controller
{
    public function index()
    {
        $titipan = Tbbp::select('tb_bp.*',DB::raw('SUM(tb_bprc.To_Rp) As jml'))
                    ->leftJoin('tb_bprc', function ($join) {
                        $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                        $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                        $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                    })
                    ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 8])
                    ->groupBy('tb_bp.id_bp')
                    ->get();
        
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                    LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                    WHERE a.Ko_unit1 = '".kd_bidang()."'");
        return view('transaksi.titipan.index', compact('titipan','pegawai'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'No_bp'         => 'required',
            'dt_bp'         => 'required',
            'Ur_bp'         => 'required',
            'nm_BUcontr'    => 'required',
            'adr_bucontr'   => 'required',
            'Nm_input'      => 'required',
        ]);

        Tbbp::Create([
            'Ko_Period'     => Tahun(),
            'Ko_unit1'      => kd_bidang(),
            'Ko_bp'         => 8,
            'No_bp'         => $request->No_bp,
            'dt_bp'         => $request->dt_bp,
            'Ur_bp'         => $request->Ur_bp,
            'nm_BUcontr'    => $request->nm_BUcontr,
            'adr_bucontr'   => $request->adr_bucontr,
            'Nm_input'      => $request->Nm_input,
            'tb_ulog'       => 'admin',
            'Tag'           => 0,
        ]);

        Alert::success('Berhasil', "Titipan berhasil ditambah");
        return redirect()->route('titipan.index');
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
        $request->validate([
            'No_bp'         => 'required',
            'dt_bp'         => 'required',
            'Ur_bp'         => 'required',
            'nm_BUcontr'    => 'required',
            'adr_bucontr'   => 'required',
            'Nm_input'      => 'required',
        ]);

        Tbbp::where('id_bp', $id)->update([
            'No_bp'         => $request->No_bp,
            'dt_bp'         => $request->dt_bp,
            'Ur_bp'         => $request->Ur_bp,
            'nm_BUcontr'    => $request->nm_BUcontr,
            'adr_bucontr'   => $request->adr_bucontr,
            'Nm_input'      => $request->Nm_input,
        ]);

        Alert::success('Berhasil', "Tititpn $request->Ur_bp berhasil dirubah");
        return redirect()->route('titipan.index');
    }

    public function destroy($id)
    {
        $data = Tbbp::find($id);
        $data->delete();
        Alert::success('Berhasil', "Uang Titipan berhasil dihapus");
        return Redirect()->route('titipan.index');
    }

    public function titipandetail($id_bp)
    {
        $tbbprc = DB::table('tb_bprc')
            ->select('*', 'tb_bp.Ur_bp')
            ->leftJoin('tb_bp', 'tb_bp.id_bp', '=', 'tb_bprc.id_bp')
            ->where('tb_bprc.id_bp', $id_bp)
            ->get();
        $tb_bp = Tbbp::find($id_bp);
        $tahun = Tahun();
        $kounit1 = kd_bidang();
        $nobayar = DB::table('tb_byr')
            ->select('*')
            ->get();
        $kegiatan = DB::select('CALL SP_Anggaran_Pdpt("' . $tahun . '", "' . $kounit1 . '")'); 
        $kobank = DB::table('pf_bank')
            ->select('*')
            ->get();
        $max = Tbbprc::where('Ko_Period',Tahun())
                ->where('id_bp', $id_bp)
                ->where('Ko_Unit1', kd_bidang())
                ->max('Ko_bprc');
        return view('transaksi.titipanrinci.index', compact('tbbprc', 'tb_bp',  'nobayar', 'kegiatan', 'kobank', 'max'));
    }
}
