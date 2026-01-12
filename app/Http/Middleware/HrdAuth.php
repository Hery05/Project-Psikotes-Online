<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HrdAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('hrd_id')) {
            return redirect('/hrd/login');
        }
        return $next($request);
    }
}
