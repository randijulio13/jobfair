<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthAdmin
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
        if (!Session::has('userdata')) {
            if ($request->is('admin/login')) {
                return $next($request);
            }
            return redirect('/admin/login');
        }

        if ($request->is('admin/login'))
            return redirect('/admin');

        if (!session('userdata')['type'] == 1)
            return redirect('/admin/login');
        return $next($request);
    }
}
