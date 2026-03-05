<?php

namespace App\Http\Controllers\Transaksi\Belanja\Pajak;

use App\Models\Tbtaxor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class PajakrinciController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'id_tax'         => 'required',
            'Ko_Period'     => 'required',
            'Ko_unit1'      => 'required',
            'taxtor_Rp'         => 'required',
            'Ko_Bank'         => 'required',
            'No_ntpn'         => 'required',
        ]);

        try {
            Tbtaxor::Create([
                'id_tax' => $request->id_tax,
                'Ko_Period' => $request->Ko_Period,
                'Ko_unit1' => $request->Ko_unit1,
                'taxtor_Rp' => $request->taxtor_Rp,
                'Ko_Bank' => $request->Ko_Bank,
                'No_ntpn' => $request->No_ntpn,
                'Tag' => 0,
                'tb_ulog' => 'admin',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }
        Alert::success('Berhasil', "Setor Pajak $request->taxtor_Rp berhasil ditambah");
        return Redirect::back();
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
    public function update(Request $request, $pajakrinci)
    {
        // dd($request);
        $request->validate([
            'taxtor_Rped'         => 'required',
            'Ko_Banked'         => 'required',
            'No_ntpn'          => 'required',
        ]);

        try {
            // Tbtaxor::Create([
            Tbtaxor::where('id_taxtor', $pajakrinci)->update([
                'taxtor_Rp' => $request->taxtor_Rped,
                'Ko_Bank' => $request->Ko_Banked,
                'No_ntpn' => $request->No_ntpn,
                'Tag' => 0,
                'tb_ulog' => 'admin',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // do what you want here with $e->getMessage();
            $e->getMessage();
        }
        Alert::success('Berhasil', "Setor Pajak $request->taxtor_Rp berhasil diupdate");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pajaktor = Tbtaxor::find($id);
        $pajaktor->delete();
        // $pajaktor->Jrpajaktors()->delete();
        Alert::success('Berhasil', "Pajak  setor $pajaktor->taxtor_Rp berhasil dihapus");
        return Redirect::back();
    }
}
