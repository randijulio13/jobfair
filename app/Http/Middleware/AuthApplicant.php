<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthApplicant
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
        if (!Session::has('userdata_applicant')) {
            if ($request->is('/login')) {
                return $next($request);
            }
            return redirect('/login');
        }

        if ($request->is('/login'))
            return redirect('/profile');

        if (!session('userdata_applicant')['type'] == 3)
            return redirect('/login');

        return $next($request);
    }
}
