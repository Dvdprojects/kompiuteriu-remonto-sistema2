<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileState
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->profile_verified != 1)
        {
            return redirect()->route('home')->with('error', 'Profilis turi būti užpildytas, norint pateikti ir peržiūrėti remonto formas');
        }
        return $next($request);
    }
}
