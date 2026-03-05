<?php

namespace App\Http\Controllers\Transaksi\Belanja\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tbbp;
use App\Models\Tbbyr;
use RealRashid\SweetAlert\Facades\Alert;

class SubPembayaranController extends Controller
{
    public function index()
    {
        $belanja = Tbbp::orderBy('id')->orderBy('Ko_Period')->get();
        return view('transaksi.belanja.pembayaran.index', compact('belanja'));
    }

    public function create()
    {
        $belanja = Tbbp::all();
        return view('transaksi.belanja.pembayaran.create', compact('belanja'));
    }

    public function tambah()
    {
        $belanja = Tbbp::all();
        return view('transaksi.belanja.pembayaran.create', compact('belanja'));
    }

    public function store(Request $request)
    {
        //
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
        //
    }

    public function destroy($id)
    {
        $data = Tbbyr::where('id_byr', $id);
        $data->delete();

        Alert::success('Berhasil', "Data Berhasil dihapus");
        return redirect()->route('pembayaran.index');
    }

}
