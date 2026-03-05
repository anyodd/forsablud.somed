<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sys_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth');
    }

    public function authenticate(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required',
            '_answer'  => 'simple_captcha',
        ]);

        if ($request->tahun == '2023') {
            if ($request->wilayah == '0') {
              $dbase = 'db_test';
              // return redirect('/');
            } elseif($request->wilayah == '1') {
              $dbase = 'forsablud_231';
            } elseif($request->wilayah == '2') {
              $dbase = 'forsablud_232';
            } elseif($request->wilayah == '3') {
              $dbase = 'forsablud_233';
            } elseif($request->wilayah == '4') {
              $dbase = 'forsablud_234';
            } elseif($request->wilayah == '5') {
              $dbase = 'forsablud_235';
            }
        } else {
        $dbase = 'forsablud_'.$request->tahun;
        }
        config(['database.connections.mysql.database' => $dbase]);
        DB::purge('mysql'); 
        DB::reconnect('mysql');
        $way = $request->only('username', 'password');
        $dt = Sys_user::where('username', $request->username)->first();
        
        if(Auth::attempt($way)){
            $request->session()->regenerate();

            $request->session()->put('Period', $request->tahun);
            $request->session()->put('DBase', $dbase);
            $request->session()->put('userData', $dt);

            if(akses() == null)
            {
                $request->session()->flush();
                Auth::logout();
                return redirect('/')->with(['info' => 'Pesan Berhasil']);
            }
            //return redirect()->intended('home');
			    return redirect()->route('dashboard');

        }
        
        return redirect()->route('auth')->with(['infolog' => 'Pesan Berhasil']);
        
    }

    public function home()
    {
        return view('home');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
