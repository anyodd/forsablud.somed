<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class akses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $level = getUser('user_level');
        if(in_array($level, $roles)){
            return $next($request);
        }
    
        return redirect('dashboard');
    }
}
