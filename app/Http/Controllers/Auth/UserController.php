<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sys_user;
use App\Models\Tbpjb;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // $pjb = Tbpjb::where('Ko_unitstr', tb_sub('Ko_unitstr'))->get(); //filter sesuai unit
        $pjb = Tbpjb::where('tb_pjb.Ko_unit1', 'like', kd_unit().'%')->get(); //filter sesuai unit

        // $user = Sys_user::where('ko_unit1',getUser('ko_unit1'))->where('user_level','!=', 1)->get();
        $user = DB::table('users')
                ->join('tb_pjb', 'users.username', '=', 'tb_pjb.NIP_pjb')
                ->select('users.*', 'tb_pjb.Nm_pjb AS nama')
                ->where('tb_pjb.Ko_unit1', 'like', kd_unit().'%')
                ->get();
        // dd($user);
        return view('setting.user.index',compact('user', 'pjb'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name'   => 'required',
            'user_level'   => 'required',
            'email'   => 'required',
        ]);

        $ko_unit1 = Tbpjb::where('NIP_pjb', $request->user_name)->value('Ko_unit1');
        
        $name = Sys_user::where('username', $request->user_name)->value('username');
        // dd($name);

        if($name == null){
            Sys_user::Create([
                'ko_unit1'  => $ko_unit1,
                'username'  => $request->user_name,
                'password'  => bcrypt('password'),
                'user_level' => $request->user_level,
                'email' => $request->email,
            ]);
            Alert::success('Berhasil', "User berhasil ditambah");
            return redirect()->route('user.index');

        }  
            Alert::warning('User Sama', "User gagal ditambah");
            return redirect()->route('user.index');    
    }

    public function show($id)
    {
        if(getUser('user_level') == 1){
            $dt =  Sys_user::where('user_id', '=',$id)->first();
        }else{
            $dt = DB::table('users')
                ->join('tb_pjb', 'users.username', '=', 'tb_pjb.NIP_pjb')
                ->select('users.*','tb_pjb.Nm_pjb AS nama')
                ->where('users.user_id','=', $id)
                ->first();
        }
        return view('setting.user.profile',compact('dt'));
        
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function change(Request $request, $id)
    {
        $request->validate([
            'password'   => 'required',
        ]);

        Sys_user::where('user_id', $id)
            ->update([
                'password' => bcrypt($request->password),
            ]);
       
        Alert::success('Berhasil', "Password Berhasil Diganti");
        return redirect('home');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_level'   => 'required',
            'email'   => 'required',
        ]);

        Sys_user::where('user_id', $id)
                ->update([
                    'user_level' => $request->user_level,
                    'email' => $request->email,
                ]);

        Alert::success('Berhasil', "User berhasil diupdate");
        return redirect(route('user.index'));
    }

    public function destroy($id)
    {
        $dt = Sys_user::where('user_id',$id);
        $dt->delete();

        Alert::success('Berhasil', "User berhasil dihapus");
        return redirect(route('user.index'));
    }
}
