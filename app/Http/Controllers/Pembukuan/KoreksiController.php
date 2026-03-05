<?php

namespace App\Http\Controllers\Pembukuan;

use App\Models\Tbkoreksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class KoreksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tahun = Tahun();
        $unitstr = kd_unit();
        $nm_unit = nm_unit();

        // $unitstr  = DB::table('tb_sub')
        //     ->select('*')
        //     ->get();

        $rkk4 = DB::select(DB::raw("SELECT CONCAT(LPAD(Ko_Rk1,2,0),'.' ,
					LPAD(Ko_Rk2,2,0),'.' ,
					LPAD(Ko_Rk3,2,0),'.' ,
					LPAD(Ko_Rk4,2,0)) AS RKK4, ur_rk4 FROM pf_rk4"));
        $koreksi = Tbkoreksi::all();
        $refkoreksi  = DB::table('pf_koreksi')
            ->select('*')
            ->get();
        $refspirc  = DB::table('tb_spirc')
            ->select('*')
            ->get();
        $tahun = Tahun();

        // dd($koreksi);

        return view('pembukuan.koreksi.index', compact('unitstr', 'nm_unit', 'rkk4', 'koreksi', 'refkoreksi', 'refspirc', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'Ko_Period'          => 'required',
            'Ko_unitstr'        => 'required',
            'Ko_Koreksi'       => 'required',
            // 'Koreksi_No'         => 'required',
            'Koreksi_Ur'         => 'required',
            'No_spi'         => 'required',
            'Ko_spirc'         => 'required',
            'Ko_Rkk'         => 'required',
            'Korek_Rp'         => 'required',
            'Korek_Tag'         => 'required',
        ]);
        $config = [
            'table' => 'tb_koreksi',
            'field' => 'Koreksi_No',
            'length' => 8,
            // 'prefix' => 'PW' . Auth::user()->pwk . '-Mon'
            'prefix' => 'Kor-'
        ];

        // now use it
        $idkorek = IdGenerator::generate($config);

        try {
            Tbkoreksi::Create([
                'Ko_Period' => $request->Ko_Period,
                'Ko_unitstr' => $request->Ko_unitstr,
                'Ko_Koreksi' => $request->Ko_Koreksi,
                'Koreksi_No' => $idkorek,
                'Koreksi_Ur' => $request->Koreksi_Ur,
                'No_spi' => $request->No_spi,
                'Ko_spirc' => $request->Ko_spirc,
                'Ko_Rkk' => $request->Ko_Rkk,
                'Korek_Rp' => $request->Korek_Rp,
                'Korek_Tag' => $request->Korek_Tag,
                'Tag' => 0,
                'tb_ulog' => 'admin',
                // 'Tag' => 0,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }
        Alert::success('Berhasil', "Koreksi $request->Koreksi_Ur berhasil ditambah");
        return redirect('koreksi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_koreksi)
    {
        $koreksi = Tbkoreksi::find($id_koreksi);
        $koreksi->delete();
        // $koreksi->Jrkoreksis()->delete();
        Alert::success('Berhasil', "Penyesuaian $koreksi->namarek berhasil dihapus");

        return redirect('koreksi');
    }
}
