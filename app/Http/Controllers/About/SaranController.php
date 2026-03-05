<?php

namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pfmenu;
use App\Models\Tbsaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SaranController extends Controller
{
    public function index()
    {
        $menu = Pfmenu::all();
        $saran = Tbsaran::all();
        $user = Session::get('userData')['username'];

        return view('about.saran.index', compact('menu', 'saran', 'user'));
    }

    public function create()
    {
        $menu = Pfmenu::all();
        return view('about.saran.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $rules = [
            'menu'      => 'required',
            'kondisi'    => 'required',
            'saran'  => 'required',
            'telp'     => 'required',
        ];

        $messages = [
            'menu.required'      => 'Menu wajib diisi.',
            'kondisi.required'    => 'Kondisi wajib diisi.',
            'saran.required'  => 'Nama Bank wajib diisi.',
            'telp.required'     => 'Nomor Telp dan Whatsapp wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        Tbsaran::create([
          'ur_menu'     => $request->menu,
          'kondisi'     => $request->kondisi,
          'saran'       => $request->saran,
          'telp'        => $request->telp,
          'tgl_saran'   => now(),
          'pesan_error' => $request->pesan_error,
          'status'      => 'open',
          'user'        => Session::get('userData')['username'],
      ]);

        Alert::success('Berhasil', "Data berhasil ditembah");
        return redirect()->route('saran.index');
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
        //
       $data = Tbsaran::find($id);
       $data->delete();

       Alert::success('Berhasil', "Data berhasil dihapus");
       return redirect()->route('saran.index');
   }
}
