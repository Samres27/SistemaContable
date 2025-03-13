<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCobradorRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'cobrador') {
            return $next($request);
        }

        return redirect('/dashboard'); // O una ruta de error
    }
}
