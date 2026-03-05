<?php

namespace App\Http\Controllers\Transaksi\Pembiayaan;

use App\Models\Tbbp;
use App\Models\Tbtap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tbbprc;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PembiayaanController extends Controller
{
    public function index()
    {
        $tahun = Tahun();
        $unitstr  = kd_unit();
        $pfbp  = DB::table('pf_bp')
            ->Where('Ko_bp', '=', '6')
            ->orWhere('Ko_bp', '=', '7  ')
            ->select('*')
            ->get();
        
        $penerimaan = Tbbp::select('tb_bp.*',DB::raw('SUM(tb_bprc.To_Rp) As jml'))
                ->leftJoin('tb_bprc', function ($join) {
                    $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                    $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                    $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                })
                ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 6])
                ->groupBy('tb_bp.id_bp')
                ->get();
        
        $pengeluaran = Tbbp::select('tb_bp.*',DB::raw('SUM(tb_bprc.To_Rp) As jml'))
                ->leftJoin('tb_bprc', function ($join) {
                    $join->on('tb_bp.Ko_Period', '=', 'tb_bprc.Ko_Period');
                    $join->on('tb_bp.ko_unit1', '=', 'tb_bprc.ko_unit1');
                    $join->on('tb_bp.id_bp', '=', 'tb_bprc.id_bp');
                })
                ->where(['tb_bp.Ko_Period' => Tahun(), 'tb_bp.ko_unit1' => kd_bidang(), 'tb_bp.Ko_bp' => 7])
                ->groupBy('tb_bp.id_bp')
                ->get();
        
        $pegawai = DB::select("SELECT a.NIP_pjb nip, a.Nm_pjb nama, b.Ur_pj jabatan FROM tb_pjb a
                LEFT JOIN pf_pj b ON a.id_pj = b.id_pj
                WHERE a.Ko_unit1 = '".kd_bidang()."'");

        return view('transaksi.pembiayaan.index', compact('tahun', 'unitstr', 'pfbp', 'penerimaan','pengeluaran','pegawai'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ko_bp'         => 'required',
            'No_bp'         => 'required',
            'dt_bp'         => 'required',
            'Ur_bp'         => 'required',
            'nm_BUcontr'    => 'required',
        ]);

        Tbbp::Create([
            'Ko_Period'     => Tahun(),
            'Ko_unit1'      => kd_bidang(),
            'Ko_bp'         => $request->Ko_bp,
            'No_bp'         => $request->No_bp,
            'dt_bp'         => $request->dt_bp,
            'Ur_bp'         => $request->Ur_bp,
            'nm_BUcontr'    => $request->nm_BUcontr,
            'adr_bucontr'   => $request->adr_bucontr,
            'Nm_input'      => $request->Nm_input,
            'tb_ulog'       => 'admin',
            'Tag'           => 0,
        ]);
        Alert::success('Berhasil', "Pembiayaan $request->Ur_bp berhasil ditambah");
        return redirect('pembiayaan');
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
            'Ko_bp'         => 'required',
            'No_bp'         => 'required',
            'dt_bp'         => 'required',
            'Ur_bp'         => 'required',
            'nm_BUcontr'    => 'required',
            'adr_bucontr'   => 'required',
            'nm_BUcontr'    => 'required',
        ]);

        Tbbp::where('id_bp', $id)->update([
            'Ko_bp'         => $request->Ko_bp,
            'No_bp'         => $request->No_bp,
            'dt_bp'         => $request->dt_bp,
            'Ur_bp'         => $request->Ur_bp,
            'nm_BUcontr'    => $request->nm_BUcontr,
            'adr_bucontr'   => $request->adr_bucontr,
            'Nm_input'      => $request->Nm_input,
            'updated_at'    => NOW()
        ]);
        Alert::success('Berhasil', "Pembiayaan berhasil dirubah");
        return redirect('pembiayaan');
    }

    public function destroy($id)
    {
        $dt = Tbbp::where('id_bp',$id);
        $dt->delete();
        Alert::success('Berhasil', "Pembiayaan berhasil dihapus");
        return redirect('pembiayaan');
    }

    public function pembiayaandetail($id_bp)
    {
        $type = Tbbp::where(['id_bp' =>$id_bp])->value('Ko_bp');
        if ($type == 6) { $type = 1; } else { $type = 2; }
        $tbbprc = DB::table('tb_bprc')
                ->select('*', 'tb_bp.Ur_bp')
                ->leftJoin('tb_bp', 'tb_bp.id_bp', '=', 'tb_bprc.id_bp')
                ->where('tb_bprc.id_bp', $id_bp)
                ->get();
        
        $tb_bp = Tbbp::find($id_bp);
        $kegiatan = DB::select('CALL SP_PembiayaanRinci("' . Tahun() . '", "' . kd_bidang() . '", "'.$type.'")'); 
        $kobank = DB::table('pf_bank')
                ->select('*')
                ->get();
        
        $max = Tbbprc::where('Ko_Period',Tahun())
        ->where('id_bp', $id_bp)
        ->where('Ko_Unit1', kd_bidang())
        ->max('Ko_bprc');
        return view('transaksi.pembiayaanrinci.index', compact('tbbprc', 'tb_bp', 'kegiatan', 'kobank','max'));
    }
}
