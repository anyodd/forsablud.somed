<?php

namespace App\Http\Middleware;

use App\Models\Sys_user;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class status
{
    public function handle(Request $request, Closure $next)
    {

        if (
            Auth::Sys_user()->status == Sys_user::IN_ACTIVE) {
            Auth::logout();
            $request->session()->flush();

            return redirect()->route('dashboard')->withErrors(['user_id' => 'User tidak aktif, silakan hubungi Admin.']);
        }

        return $next($request);
    }
}
