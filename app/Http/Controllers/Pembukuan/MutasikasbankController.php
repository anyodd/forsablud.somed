<?php

namespace App\Http\Controllers\Pembukuan;

use App\Models\Tbmutabank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pfbank; 

class MutasikasbankController extends Controller
{
    public function index()
    {
        $refbank1  = Pfbank::where('Ko_unitstr', kd_unit())->get();
        $refbank2  = Pfbank::where('Ko_unitstr', kd_unit())->get();

        $mutabank = Tbmutabank::where([ 'Ko_Period'=>Tahun(), 'Ko_unitstr'=>kd_unit() ])->get();
        return view('pembukuan.mutasikasbank.index', compact('refbank1', 'refbank2', 'mutabank'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Ko_Period'          => 'required',
            'Ko_unitstr'        => 'required',
            'Ko_Bank1'       => 'required',
            'Ko_Bank2'         => 'required',
            'muta_Rp'         => 'required',
        ]);

        try {
            Tbmutabank::Create([
                'Ko_Period' => $request->Ko_Period,
                'Ko_unitstr' => $request->Ko_unitstr,
                'Ko_Bank1' => $request->Ko_Bank1,
                'Ko_Bank2' => $request->Ko_Bank2,
                'muta_Rp' => $request->muta_Rp,
                'tb_ulog' => 'admin',
                // 'Tag' => 0,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }

        Alert::success('Berhasil', "Penyesuaian $request->muta_Rp $request->Ko_Bank2, berhasil ditambah");
        return redirect('mutasikasbank');
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
            // 'Periodedit'          => 'required',
            // 'Ko_unitstr'        => 'required',
            'Ko_Bank1edit'       => 'required',
            'Ko_Bank2edit'         => 'required',
            'muta_Rpedit'         => 'required',
        ]);

        try {
            // Tbmutabank::Create([
            Tbmutabank::where('id', $request->id)->update([
                // 'Ko_Period' => $request->Ko_Period,
                // 'Ko_unitstr' => $request->Ko_unitstr,
                'Ko_Bank1' => $request->Ko_Bank1edit,
                'Ko_Bank2' => $request->Ko_Bank2edit,
                'muta_Rp' => $request->muta_Rpedit,
                'tb_ulog' => 'admin',
                // 'Tag' => 0,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }

        Alert::success('Berhasil', "Mutasi $request->muta_Rp $request->Ko_Bank2, berhasil diubah");
        return redirect('mutasikasbank');
    }

    public function destroy($id)
    {
        $mutabank = Tbmutabank::find($id);
        $mutabank->delete();

        Alert::success('Berhasil', "Penyesuaian $mutabank->muta_Rp berhasil dihapus");

        return redirect('mutasikasbank');
    }
}
